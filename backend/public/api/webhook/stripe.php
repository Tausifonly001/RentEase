<?php

declare(strict_types=1);

use RentEase\Services\ShiprocketService;
use RentEase\Support\HttpClient;

require_once __DIR__ . '/../../../bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

$payload = file_get_contents('php://input');
$event = json_decode((string)$payload, true);

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

            // 1. Idempotency check: Check if order already exists
            $sessionId = $session['id'] ?? '';
            $orderRes = $http->request(
                'GET',
                $config['supabase_url'] . '/rest/v1/orders?select=*&stripe_session_id=eq.' . urlencode($sessionId) . '&limit=1',
                $serviceHeaders
            );

            if ($orderRes['status'] >= 200 && $orderRes['status'] < 300 && !empty($orderRes['body'])) {
                // Already processed
                echo json_encode(['status' => 'already_processed', 'order' => $orderRes['body'][0]]);
                exit;
            }

            // 2. Parse cart items from metadata
            $cartItemsStr = $session['metadata']['cart_items'] ?? '[]';
            $cartItems = json_decode($cartItemsStr, true);
            if (!is_array($cartItems)) {
                $cartItems = [];
            }

            // 3. Create order in database
            $orderData = [
                'user_id' => $userId,
                'stripe_session_id' => $sessionId ?: 'pi_' . rand(10000, 99999),
                'total_amount' => (float)$totalAmount,
                'payment_status' => 'completed',
                'items' => $cartItems,
                'shipping_status' => 'processing',
                'return_status' => 'none'
            ];

            $createOrderRes = $http->request(
                'POST',
                $config['supabase_url'] . '/rest/v1/orders',
                $serviceHeaders,
                $orderData
            );

            if ($createOrderRes['status'] >= 200 && $createOrderRes['status'] < 300 && !empty($createOrderRes['body'])) {
                $order = is_array($createOrderRes['body']) ? ($createOrderRes['body'][0] ?? $createOrderRes['body']) : [];
                $orderId = $order['id'] ?? null;

                if ($orderId) {
                    // 4. Send order to Shiprocket
                    $shiprocketService = new ShiprocketService($config);
                    
                    // Retrieve user profile to get customer full name
                    $profileRes = $http->request(
                        'GET',
                        $config['supabase_url'] . '/rest/v1/profiles?select=*&id=eq.' . urlencode($userId) . '&limit=1',
                        $serviceHeaders
                    );

                    $customerName = 'Customer';
                    if ($profileRes['status'] >= 200 && $profileRes['status'] < 300 && !empty($profileRes['body'][0])) {
                        $customerName = $profileRes['body'][0]['full_name'] ?: 'Customer';
                    }

                    $shiprocketPayload = [
                        'order_id' => (string)$orderId,
                        'order_date' => date('Y-m-d H:i:s'),
                        'pickup_location' => 'Primary',
                        'billing_customer_name' => $customerName,
                        'billing_last_name' => '',
                        'billing_address' => $session['metadata']['address'] ?? 'Not provided',
                        'billing_city' => 'Mumbai',
                        'billing_pincode' => '400001',
                        'billing_state' => 'Maharashtra',
                        'billing_country' => 'India',
                        'billing_email' => $session['customer_email'] ?? 'customer@rentease.com',
                        'billing_phone' => $session['metadata']['mobile_number'] ?? '9876543210',
                        'shipping_is_billing' => true,
                        'order_items' => array_map(function ($item) {
                            return [
                                'name' => $item['name'] ?? 'RentEase Product',
                                'sku' => 'SKU-' . ($item['id'] ?? rand(100, 999)),
                                'units' => (int)($item['months'] ?? 1),
                                'selling_price' => (float)($item['monthly_price'] ?? 0)
                            ];
                        }, $cartItems),
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

                        // 5. Update order with shipment_id, tracking_url, shipping_status
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

                    echo json_encode([
                        'status' => 'order_created_and_shipped',
                        'order_id' => $orderId,
                        'shipment_id' => $shipmentId,
                        'tracking_url' => $trackingUrl
                    ]);
                    exit;
                }
            } else {
                http_response_code(500);
                echo json_encode([
                    'error' => 'Failed to create order in database.',
                    'details' => $createOrderRes
                ]);
                exit;
            }
        }
    }
}

echo json_encode(['status' => 'success_unhandled_or_processed']);
