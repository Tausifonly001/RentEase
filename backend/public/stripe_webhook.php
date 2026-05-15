<?php

declare(strict_types=1);

use RentEase\Services\PaymentService;
use RentEase\Services\RentalService;

require __DIR__ . '/../bootstrap.php';

$paymentService = new PaymentService($config);
$rentalService = new RentalService($config);

$payload = file_get_contents('php://input');
$sigHeader = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';

$session = $paymentService->handleWebhook((string)$payload, $sigHeader);

if (!$session) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid webhook payload or signature']);
    exit;
}

if ($session['type'] === 'checkout.session.completed') {
    $sessionObject = $session['data']['object'] ?? null;
    if ($sessionObject) {
        $paymentService->processSuccessfulPayment($sessionObject);
        
        // Post-payment logic: Create rentals and deliveries
        $userId = (string)($sessionObject['client_reference_id'] ?? $sessionObject['metadata']['user_id'] ?? '');
        $orderId = (string)($sessionObject['metadata']['order_id'] ?? '');
        $cartIdsStr = (string)($sessionObject['metadata']['cart_ids'] ?? '');
        
        if ($userId && $orderId && $cartIdsStr) {
            $cartIds = explode(',', $cartIdsStr);
            foreach ($cartIds as $prodId) {
                $prodId = trim($prodId);
                if ($prodId !== '') {
                    try {
                        $rentalRes = $rentalService->createBookingWithServiceRole([
                            'user_id' => $userId,
                            'product_id' => (int)$prodId,
                            'start_date' => date('Y-m-d'),
                            'end_date' => date('Y-m-d', strtotime('+3 months'))
                        ]);

                        $rentalId = $rentalRes[0]['id'] ?? null;
                        if ($rentalId) {
                            // Register Delivery
                            $rentalService->createDelivery([
                                'order_id' => $orderId,
                                'rental_id' => $rentalId,
                                'user_id' => $userId,
                                'type' => 'DELIVERY',
                                'scheduled_date' => $sessionObject['metadata']['delivery_date'] ?? date('Y-m-d', strtotime('+2 days')),
                                'time_slot' => $sessionObject['metadata']['delivery_time'] ?? '09:00 AM - 12:00 PM',
                                'address' => $sessionObject['metadata']['address'] ?? 'Default Address',
                                'status' => 'SCHEDULED',
                                'agent_notes' => 'Initial dispatch created.'
                            ]);
                        }
                    } catch (Throwable $e) {
                        error_log("Webhook Post-Process Error: " . $e->getMessage());
                    }
                }
            }

            // Send Push Notification via OneSignal
            try {
                $onesignal = new \RentEase\Services\NotificationService($config);
                $onesignal->sendPush([$userId], 'Payment Successful!', "Order #{$orderId} has been confirmed.");
            } catch (\Throwable $e) {
                error_log("Push notification failed: " . $e->getMessage());
            }
        }
    }
}

http_response_code(200);
echo json_encode(['status' => 'success']);
exit;
