<?php

declare(strict_types=1);

use RentEase\Services\ShiprocketService;
use RentEase\Services\RentalService;
use RentEase\Support\HttpClient;

require_once __DIR__ . '/../../../bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

$payload = file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload, $sig_header, $config['stripe_webhook_secret']
    );
    $event = $event->toArray();
} catch(\UnexpectedValueException $e) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid payload']);
    exit;
} catch(\Stripe\Exception\SignatureVerificationException $e) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid signature']);
    exit;
}

if (!$event || !isset($event['type'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid webhook payload']);
    exit;
}

// Support both checkout.session.completed and payment_intent.succeeded
if ($event['type'] === 'checkout.session.completed' || $event['type'] === 'payment_intent.succeeded') {
    $session = $event['data']['object'] ?? null;
    if ($session) {
        $userId = $session['client_reference_id'] ?? $session['metadata']['user_id'] ?? null;
        $totalAmount = $session['amount_total'] ?? $session['metadata']['total_amount'] ?? 0;
        if (is_numeric($totalAmount)) {
            $totalAmount = (float)$totalAmount / (strpos((string)$event['type'], 'checkout') !== false ? 100 : 1);
        }

        if ($userId) {
            $http = new HttpClient();
            $serviceHeaders = [
                'apikey' => (string) $config['supabase_service_role_key'],
                'Authorization' => 'Bearer ' . $config['supabase_service_role_key'],
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Prefer' => 'return=representation'
            ];

            // SEC-005: Idempotency check — prevent duplicate event processing
            $eventId = $event['id'] ?? '';
            if ($eventId !== '') {
                $idempCheck = $http->request(
                    'GET',
                    $config['supabase_url'] . '/rest/v1/webhook_events?event_id=eq.' . urlencode($eventId) . '&limit=1',
                    $serviceHeaders
                );

                if (($idempCheck['status'] ?? 0) >= 200 && ($idempCheck['status'] ?? 0) < 300 && !empty($idempCheck['body'])) {
                    http_response_code(200);
                    echo json_encode(['status' => 'already_processed']);
                    exit;
                }

                // Record event as processed (best-effort)
                try {
                    $http->request('POST', $config['supabase_url'] . '/rest/v1/webhook_events', $serviceHeaders, [
                        'event_id' => $eventId,
                        'event_type' => $event['type'],
                        'processed_at' => gmdate('Y-m-d\TH:i:s\Z')
                    ]);
                } catch (\Throwable $e) {
                    error_log("Webhook idempotency record failed: " . $e->getMessage());
                }
            }

            // 1. Look up existing order by stripe_session_id
            $sessionId = $session['id'] ?? '';
            $orderRes = $http->request(
                'GET',
                $config['supabase_url'] . '/rest/v1/orders?select=*&stripe_session_id=eq.' . urlencode($sessionId) . '&limit=1',
                $serviceHeaders
            );

            $existingOrder = $orderRes['body'][0] ?? null;
            $orderId = null;
            $isNewlyCreated = false;

            if ($existingOrder) {
                $orderId = $existingOrder['id'];

                if ($existingOrder['payment_status'] === 'completed') {
                    echo json_encode(['status' => 'already_processed', 'order_id' => $orderId]);
                    exit;
                }

                // Update pending order to completed
                $http->request(
                    'PATCH',
                    $config['supabase_url'] . '/rest/v1/orders?id=eq.' . urlencode($orderId),
                    $serviceHeaders,
                    ['payment_status' => 'completed']
                );
            } else {
                // No existing order — create from metadata
                $cartItems = [];
                $cartItemsRaw = $session['metadata']['cart_items'] ?? '[]';
                if (is_string($cartItemsRaw)) {
                    $cartItems = json_decode($cartItemsRaw, true) ?? [];
                }

                $createOrderRes = $http->request(
                    'POST',
                    $config['supabase_url'] . '/rest/v1/orders',
                    $serviceHeaders,
                    [
                        'user_id' => $userId,
                        'stripe_session_id' => $sessionId ?: 'pi_' . rand(10000, 99999),
                        'total_amount' => (float)$totalAmount,
                        'payment_status' => 'completed',
                        'items' => $cartItems,
                        'shipping_status' => 'processing',
                        'return_status' => 'none'
                    ]
                );

                if ($createOrderRes['status'] < 200 || $createOrderRes['status'] >= 300 || empty($createOrderRes['body'])) {
                    http_response_code(500);
                    echo json_encode(['error' => 'Failed to create order.', 'details' => $createOrderRes]);
                    exit;
                }

                $created = is_array($createOrderRes['body']) ? ($createOrderRes['body'][0] ?? $createOrderRes['body']) : [];
                $orderId = $created['id'] ?? null;

                if (!$orderId) {
                    http_response_code(500);
                    echo json_encode(['error' => 'Order created but no ID returned.']);
                    exit;
                }

                $isNewlyCreated = true;

                // Create rentals and deliveries for the new order
                $rentalService = new RentalService($config);
                $metadata = $session['metadata'] ?? [];

                foreach ($cartItems as $item) {
                    try {
                        $productId = (int)($item['id'] ?? 0);
                        $months = (int)($item['months'] ?? 3);
                        if ($productId <= 0) continue;

                        $rentalRes = $rentalService->createBookingWithServiceRole([
                            'user_id' => $userId,
                            'product_id' => $productId,
                            'start_date' => date('Y-m-d'),
                            'end_date' => date('Y-m-d', strtotime('+' . $months . ' months')),
                            'status' => 'active',
                            'order_id' => $orderId
                        ]);

                        $rentalId = $rentalRes[0]['id'] ?? null;
                        if ($rentalId) {
                            $rentalService->createDelivery([
                                'order_id' => $orderId,
                                'rental_id' => $rentalId,
                                'user_id' => $userId,
                                'type' => 'DELIVERY',
                                'scheduled_date' => $metadata['delivery_date'] ?? date('Y-m-d', strtotime('+2 days')),
                                'time_slot' => $metadata['delivery_time'] ?? '09:00 AM - 12:00 PM',
                                'address' => $metadata['address'] ?? 'Not provided',
                                'status' => 'SCHEDULED',
                                'agent_notes' => 'Payment confirmed via Stripe webhook.'
                            ]);
                        }
                    } catch (\Throwable $e) {
                        error_log("Webhook rental/delivery creation failed for product {$item['id']}: " . $e->getMessage());
                    }
                }
            }

            // 2. Activate any pending rentals for this order
            try {
                $rentalService = $rentalService ?? new RentalService($config);
                $rentalService->activateRentalsByOrder($orderId);
            } catch (\Throwable $e) {
                error_log("Webhook rental activation failed: " . $e->getMessage());
            }

            // 3. Process Shiprocket fulfillment
            try {
                $shiprocketService = new ShiprocketService($config);

                $profileRes = $http->request(
                    'GET',
                    $config['supabase_url'] . '/rest/v1/profiles?select=*&id=eq.' . urlencode($userId) . '&limit=1',
                    $serviceHeaders
                );

                $customerName = 'Customer';
                if (!empty($profileRes['body'][0])) {
                    $customerName = $profileRes['body'][0]['full_name'] ?: 'Customer';
                }

                $cartItems = $session['metadata']['cart_items'] ?? '[]';
                $cartItemsArr = is_string($cartItems) ? (json_decode($cartItems, true) ?? []) : [];

                $metadata = $session['metadata'] ?? [];
                $shiprocketPayload = [
                    'order_id' => (string)$orderId,
                    'order_date' => date('Y-m-d H:i:s'),
                    'pickup_location' => 'Primary',
                    'billing_customer_name' => $customerName,
                    'billing_last_name' => '',
                    'billing_address' => $metadata['address'] ?? 'Not provided',
                    'billing_city' => 'Mumbai',
                    'billing_pincode' => '400001',
                    'billing_state' => 'Maharashtra',
                    'billing_country' => 'India',
                    'billing_email' => $session['customer_email'] ?? 'customer@rentease.com',
                    'billing_phone' => $metadata['mobile_number'] ?? '9876543210',
                    'shipping_is_billing' => true,
                    'order_items' => array_map(function ($item) {
                        return [
                            'name' => $item['name'] ?? 'RentEase Product',
                            'sku' => 'SKU-' . ($item['id'] ?? rand(100, 999)),
                            'units' => (int)($item['months'] ?? 1),
                            'selling_price' => (float)($item['monthly_price'] ?? 0)
                        ];
                    }, $cartItemsArr),
                    'payment_method' => 'Prepaid',
                    'sub_total' => (float)$totalAmount,
                    'length' => 10,
                    'breadth' => 10,
                    'height' => 10,
                    'weight' => 0.5
                ];

                $srOrder = $shiprocketService->createOrder($shiprocketPayload);
                $shipmentId = $srOrder['shipment_id'] ?? null;
                $trackingUrl = '';

                if ($shipmentId) {
                    $awb = $shiprocketService->generateAWB((int)$shipmentId);
                    $shiprocketService->requestPickup((int)$shipmentId);
                    $trackingUrl = 'https://shiprocket.co/tracking/' . ($awb['awb_code'] ?? '');

                    $http->request(
                        'PATCH',
                        $config['supabase_url'] . '/rest/v1/orders?id=eq.' . urlencode((string)$orderId),
                        $serviceHeaders,
                        [
                            'shipment_id' => (string)$shipmentId,
                            'tracking_url' => $trackingUrl,
                            'shipping_status' => 'shipped'
                        ]
                    );
                }

                // Send push notification
                try {
                    $notificationService = new \RentEase\Services\NotificationService($config);
                    $notificationService->sendPush([$userId], 'Payment Successful!', "Order #{$orderId} has been confirmed.");
                } catch (\Throwable $e) {
                    error_log("Push notification failed: " . $e->getMessage());
                }

                echo json_encode([
                    'status' => $isNewlyCreated ? 'order_created' : 'order_updated',
                    'order_id' => $orderId,
                    'shipment_id' => $shipmentId,
                    'tracking_url' => $trackingUrl
                ]);
                exit;
            } catch (\Throwable $e) {
                // Send push notification even if fulfillment fails
                try {
                    $notificationService = new \RentEase\Services\NotificationService($config);
                    $notificationService->sendPush([$userId], 'Payment Received', "Order #{$orderId} is being processed.");
                } catch (\Throwable $notifErr) {
                    error_log("Push notification failed: " . $notifErr->getMessage());
                }

                echo json_encode([
                    'status' => $isNewlyCreated ? 'order_created' : 'order_updated',
                    'order_id' => $orderId,
                    'shipment_error' => $e->getMessage()
                ]);
                exit;
            }
        }
    }
}

echo json_encode(['status' => 'success_unhandled_or_processed']);
