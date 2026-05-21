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
        
        if ($userId && $orderId) {
            try {
                // 1. Activate pre-created rentals
                $rentalService->activateRentalsByOrder($orderId);

                // 2. Ensure all deliveries for this order are active/confirmed
                $serviceHeaders = [
                    'apikey' => (string) $config['supabase_service_role_key'],
                    'Authorization' => 'Bearer ' . $config['supabase_service_role_key'],
                    'Content-Type' => 'application/json'
                ];
                $http = new \RentEase\Support\HttpClient();
                $http->request('PATCH', $config['supabase_url'] . "/rest/v1/deliveries?order_id=eq.{$orderId}", $serviceHeaders, [
                    'agent_notes' => 'Payment confirmed via webhook. Delivery scheduled.'
                ]);

            } catch (Throwable $e) {
                error_log("Webhook Post-Process Error: " . $e->getMessage());
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
