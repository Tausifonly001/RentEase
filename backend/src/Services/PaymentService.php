<?php

declare(strict_types=1);

namespace RentEase\Services;

use Stripe\StripeClient;
use RentEase\Support\HttpClient;

final class PaymentService extends BaseSupabaseService
{
    private StripeClient $stripe;

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config, ?HttpClient $http = null)
    {
        parent::__construct($config, $http);
        $this->stripe = new StripeClient((string)($config['stripe_secret_key'] ?? ''));
    }

    /**
     * Create a Stripe Checkout Session for order payment.
     *
     * @param array<string, mixed> $orderData
     * @param array<int, array<string, mixed>> $lineItems
     * @param string $successUrl
     * @param string $cancelUrl
     * @return string
     */
    public function createCheckoutSession(array $orderData, array $lineItems, string $successUrl, string $cancelUrl): string
    {
        $session = $this->stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'client_reference_id' => (string)($orderData['user_id'] ?? ''),
            'metadata' => array_merge([
                'order_id' => (string)($orderData['id'] ?? ''),
            ], $orderData['metadata'] ?? []),
        ]);

        return $session->url;
    }

    /**
     * Handle Stripe Webhook event.
     *
     * @param string $payload
     * @param string $sigHeader
     * @return array<string, mixed>|null
     */
    public function handleWebhook(string $payload, string $sigHeader): ?array
    {
        $secret = (string)($this->config['stripe_webhook_secret'] ?? '');
        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $secret);
            return $event->jsonSerialize();
        } catch (\UnexpectedValueException | \Stripe\Exception\SignatureVerificationException $e) {
            return null;
        }
    }

    /**
     * Update order and payment status in database after successful payment.
     *
     * @param array<string, mixed> $session
     * @return void
     */
    public function processSuccessfulPayment(array $session): void
    {
        $sessionId = (string)($session['id'] ?? '');
        $userId = (string)($session['client_reference_id'] ?? $session['metadata']['user_id'] ?? '');
        $orderId = (string)($session['metadata']['order_id'] ?? '');

        if (!$sessionId || !$userId || !$orderId) {
            return;
        }

        $headers = array_merge($this->serviceHeaders(), [
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation'
        ]);

        // 1. Update order payment status
        $this->request(
            'PATCH',
            '/rest/v1/orders?id=eq.' . urlencode($orderId),
            $headers,
            ['payment_status' => 'completed', 'stripe_session_id' => $sessionId]
        );

        // 2. Register payment record
        $this->request(
            'POST',
            '/rest/v1/payments',
            $headers,
            [
                'user_id' => $userId,
                'order_id' => $orderId,
                'stripe_payment_intent' => (string)($session['payment_intent'] ?? ''),
                'amount' => (float)($session['amount_total'] ?? 0) / 100,
                'status' => 'completed'
            ]
        );
    }
}
