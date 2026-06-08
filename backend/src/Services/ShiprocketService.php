<?php

declare(strict_types=1);

namespace RentEase\Services;

use RentEase\Support\HttpClient;
use RuntimeException;
use PDO;

final class ShiprocketService extends BaseSupabaseService
{
    private ?string $email;
    private ?string $password;
    private ?string $token = null;

    public function __construct(array $config, ?HttpClient $http = null)
    {
        parent::__construct($config, $http);
        $this->email = getenv('SHIPROCKET_EMAIL');
        $this->password = getenv('SHIPROCKET_PASSWORD');
    }

    /**
     * Authenticate with Shiprocket to retrieve the token. Now cached in Supabase.
     */
    public function authenticate(): ?string
    {
        if (empty($this->email) || empty($this->password)) {
            throw new RuntimeException('Shiprocket credentials not configured. Set SHIPROCKET_EMAIL and SHIPROCKET_PASSWORD in .env');
        }
        if ($this->token) {
            return $this->token;
        }

        // Try getting token from DB
        $res = $this->request(
            'GET',
            '/rest/v1/shiprocket_auth_tokens?select=token&expires_at=gt.now()&order=id.desc&limit=1',
            $this->serviceHeaders()
        );

        if (!empty($res['body']) && is_array($res['body'])) {
            $this->token = $res['body'][0]['token'];
            return $this->token;
        }

        $url = 'https://apiv2.shiprocket.in/v1/external/auth/login';
        $payload = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        $response = $this->http->request('POST', $url, ['Content-Type' => 'application/json'], $payload);
        if ($response['status'] >= 200 && $response['status'] < 300 && !empty($response['body']['token'])) {
            $this->token = (string) $response['body']['token'];

            // Persist to Supabase
            $this->request(
                'POST',
                '/rest/v1/shiprocket_auth_tokens',
                $this->serviceHeaders(),
                ['token' => $this->token, 'expires_at' => date('Y-m-d H:i:s', strtotime('+9 days'))]
            );

            return $this->token;
        }

        throw new RuntimeException('Failed to authenticate with Shiprocket API.');
    }

    /**
     * Create an order in Shiprocket and record its DB entry automatically
     */
    public function createOrder(array $orderData, $localOrderId = null): array
    {
        // 1. Check for duplicates
        if ($localOrderId) {
            $res = $this->request(
                'GET',
                '/rest/v1/order_shipments?select=shiprocket_order_id&order_id=eq.' . $localOrderId,
                $this->serviceHeaders()
            );
            if (!empty($res['body'])) {
                throw new RuntimeException("Shipment for this order already exists.");
            }
        }

        $token = $this->authenticate();
        $url = 'https://apiv2.shiprocket.in/v1/external/orders/create/adhoc';

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ];

        $response = $this->http->request('POST', $url, $headers, $orderData);
        if ($response['status'] >= 200 && $response['status'] < 300 && !empty($response['body'])) {
            $result = $response['body'];

            // 2. Persist tracking record
            if ($localOrderId) {
                $this->request(
                    'POST',
                    '/rest/v1/order_shipments',
                    $this->serviceHeaders(),
                    [
                        'order_id' => $localOrderId,
                        'shiprocket_order_id' => $result['order_id'],
                        'shiprocket_shipment_id' => $result['shipment_id'],
                        'status' => 'NEW'
                    ]
                );
            }

            return $result;
        }

        throw new RuntimeException("Failed to generate order with Shiprocket. API Response: " . json_encode($response['body'] ?? []));
    }

    /**
     * Assign courier and generate AWB
     */
    public function generateAWB(int $shipmentId): array
    {
        $token = $this->authenticate();
        $url = 'https://apiv2.shiprocket.in/v1/external/courier/assign/awb';

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ];

        $payload = [
            'shipment_id' => $shipmentId,
        ];

        $response = $this->http->request('POST', $url, $headers, $payload);
        if ($response['status'] >= 200 && $response['status'] < 300 && !empty($response['body'])) {
            $data = $response['body'];

            if (isset($data['awb_assign_status']) && $data['awb_assign_status'] == 1) {
                $this->request(
                    'PATCH',
                    '/rest/v1/order_shipments?shiprocket_shipment_id=eq.' . $shipmentId,
                    $this->serviceHeaders(),
                    [
                        'awb_code' => $data['response']['data']['awb_code'],
                        'courier_company_id' => $data['response']['data']['courier_company_id'],
                        'courier_name' => $data['response']['data']['courier_name'],
                        'status' => 'AWB_GENERATED'
                    ]
                );
            }
            return $data;
        }

        throw new RuntimeException("AWB Generation Failed: " . json_encode($response['body'] ?? []));
    }

    /**
     * Request pickup
     */
    public function requestPickup(int $shipmentId): array
    {
        $token = $this->authenticate();
        $url = 'https://apiv2.shiprocket.in/v1/external/courier/generate/pickup';

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ];

        $payload = [
            'shipment_id' => $shipmentId,
        ];

        $response = $this->http->request('POST', $url, $headers, $payload);
        if ($response['status'] >= 200 && $response['status'] < 300 && !empty($response['body'])) {
            return $response['body'];
        }

        throw new RuntimeException("Failed to request pickup: " . json_encode($response['body'] ?? []));
    }
}
