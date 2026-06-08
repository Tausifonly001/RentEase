<?php

declare(strict_types=1);

/**
 * Stripe Webhook Handler
 *
 * Processes checkout.session.completed events from Stripe.
 * Includes idempotency check to prevent duplicate processing.
 */

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
 // SEC-005: Idempotency — prevent duplicate event processing
 $eventId = $session['id'] ?? '';
 if ($eventId !== '') {
 if (session_status() !== PHP_SESSION_ACTIVE) {
 session_start();
 }

 // Track processed webhook event IDs in a server-side store
 // For production, use a database table (webhook_events) instead of session
 $http = new \RentEase\Support\HttpClient();
 $serviceHeaders = [
 'apikey' => (string) $config['supabase_service_role_key'],
 'Authorization' => 'Bearer ' . $config['supabase_service_role_key'],
 'Content-Type' => 'application/json',
 'Accept' => 'application/json'
 ];

 // Check if event was already processed
 $checkRes = $http->request(
 'GET',
 $config['supabase_url'] . '/rest/v1/webhook_events?event_id=eq.' . urlencode($eventId) . '&limit=1',
 $serviceHeaders
 );

 if (($checkRes['status'] ?? 0) >= 200 && ($checkRes['status'] ?? 0) < 300 && !empty($checkRes['body'])) {
 // Already processed — return 200 to prevent Stripe retries
 http_response_code(200);
 echo json_encode(['status' => 'already_processed']);
 exit;
 }

 // Record the event as processed (best-effort — table may not exist yet)
 try {
 $http->request('POST', $config['supabase_url'] . '/rest/v1/webhook_events', $serviceHeaders, [
 'event_id' => $eventId,
 'event_type' => $session['type'],
 'processed_at' => gmdate('Y-m-d\TH:i:s\Z')
 ]);
 } catch (\Throwable $e) {
 // If table doesn't exist, log but continue processing
 error_log("Webhook idempotency record failed (table may not exist): " . $e->getMessage());
 }
 }

 $sessionObject = $session['data']['object'] ?? null;
 if ($sessionObject) {
 $paymentService->processSuccessfulPayment($sessionObject);

 // Post-payment logic: Create rentals and deliveries
 $userId = (string)($sessionObject['client_reference_id'] ?? $sessionObject['metadata']['user_id'] ?? '');
 $orderId = (string)($sessionObject['metadata']['order_id'] ?? '');

 if ($userId && $orderId) {
 try {
 // 1. Activate pre-created rentals
 $rentalService->activateRentalsByOrder($orderId);

 // 2. Ensure all deliveries for this order are active/confirmed
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
