<?php
declare(strict_types=1);

namespace RentEase\Services;

final class StripeService
{
    private string $secretKey;

    public function __construct(array $config)
    {
        $this->secretKey = (string)($config['stripe_secret_key'] ?? getenv('STRIPE_SECRET_KEY') ?: getenv('STRIPE_SECRET') ?: 'sk_test_51PxTEST');
    }

    /**
     * Create Stripe Hosted Checkout Session
     *
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public function createCheckoutSession(array $params): array
    {
        $url = 'https://api.stripe.com/v1/checkout/sessions';

        $data = [
            'mode' => 'payment',
            'success_url' => $params['success_url'] ?? '',
            'cancel_url' => $params['cancel_url'] ?? '',
            'customer_email' => $params['customer_email'] ?? '',
            'client_reference_id' => $params['client_reference_id'] ?? '',
        ];

        // Add line items
        if (!empty($params['line_items'])) {
            foreach ($params['line_items'] as $index => $item) {
                $data["line_items[$index][price_data][currency]"] = $item['currency'] ?? 'usd';
                $data["line_items[$index][price_data][unit_amount]"] = (int)($item['unit_amount']);
                $data["line_items[$index][price_data][product_data][name]"] = $item['name'] ?? 'Product Lease';
                $data["line_items[$index][quantity]"] = $item['quantity'] ?? 1;
            }
        }

        // Add metadata
        if (!empty($params['metadata'])) {
            foreach ($params['metadata'] as $key => $value) {
                $data["metadata[$key]"] = $value;
            }
        }

        return $this->post($url, $data);
    }

    /**
     * Retrieve Stripe Session
     *
     * @param string $sessionId
     * @return array<string, mixed>
     */
    public function retrieveSession(string $sessionId): array
    {
        $url = 'https://api.stripe.com/v1/checkout/sessions/' . urlencode($sessionId);
        return $this->get($url);
    }

    /**
     * @param string $url
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function post(string $url, array $data): array
    {
        $ch = curl_init($url);
        if ($ch === false) {
            throw new \RuntimeException('Stripe Client initialization failed');
        }

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->secretKey,
                'Content-Type: application/x-www-form-urlencoded'
            ],
            CURLOPT_TIMEOUT => 20,
        ]);

        $response = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        $decoded = json_decode((string)$response, true);
        return is_array($decoded) ? $decoded : ['status' => $status, 'raw' => $response];
    }

    /**
     * @param string $url
     * @return array<string, mixed>
     */
    private function get(string $url): array
    {
        $ch = curl_init($url);
        if ($ch === false) {
            throw new \RuntimeException('Stripe Client initialization failed');
        }

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->secretKey
            ],
            CURLOPT_TIMEOUT => 20,
        ]);

        $response = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        $decoded = json_decode((string)$response, true);
        return is_array($decoded) ? $decoded : ['status' => $status, 'raw' => $response];
    }
}
