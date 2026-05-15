<?php

declare(strict_types=1);

namespace RentEase\Services;

use RentEase\Support\HttpClient;
use RuntimeException;
use PDO;

final class ShiprocketService
{
    private ?string $email;
    private ?string $password;
    private ?string $token = null;
    private HttpClient $http;
    private ?PDO $db = null;

    public function __construct(PDO $db = null, ?HttpClient $http = null)
    {
        $this->email = getenv('SHIPROCKET_EMAIL') ?: 'test@rentease.com';
        $this->password = getenv('SHIPROCKET_PASSWORD') ?: 'TestPassword123!';
        $this->http = $http ?? new HttpClient();
        $this->db = $db;
    }

    /**
     * Authenticate with Shiprocket to retrieve the token. Now cached in Database.
     */
    public function authenticate(): ?string
    {
        if ($this->token) {
            return $this->token;
        }

        // Try getting token from DB if DB connection exists
        if ($this->db) {
            $stmt = $this->db->prepare("SELECT token FROM shiprocket_auth_tokens WHERE expires_at > NOW() + INTERVAL '1 hour' ORDER BY id DESC LIMIT 1");
            $stmt->execute();
            $cached = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($cached) {
                $this->token = $cached['token'];
                return $this->token;
            }
        }

        $url = 'https://apiv2.shiprocket.in/v1/external/auth/login';
        $payload = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        $response = $this->http->request('POST', $url, ['Content-Type' => 'application/json'], $payload);
        if ($response['status'] >= 200 && $response['status'] < 300 && !empty($response['body']['token'])) {
            $this->token = (string) $response['body']['token'];
            
            if ($this->db) {
                $stmt = $this->db->prepare("INSERT INTO shiprocket_auth_tokens (token, expires_at) VALUES (?, NOW() + INTERVAL '9 days')");
                $stmt->execute([$this->token]);
            }
            return $this->token;
        }

        throw new RuntimeException('Failed to authenticate with Shiprocket API.');
    }

    /**
     * Create an order in Shiprocket and record its DB entry automatically
     */
    public function createOrder(array $orderData, int $localOrderId = null): array
    {
        // 1. Check for duplicates in DB
        if ($this->db && $localOrderId) {
            $stmt = $this->db->prepare("SELECT shiprocket_order_id FROM order_shipments WHERE order_id = ?");
            $stmt->execute([$localOrderId]);
            if ($stmt->fetch()) {
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

            // 2. Persist tracking record to DB
            if ($this->db && $localOrderId) {
                $stmt = $this->db->prepare("INSERT INTO order_shipments (order_id, shiprocket_order_id, shiprocket_shipment_id, status) VALUES (?, ?, ?, 'NEW')");
                $stmt->execute([$localOrderId, $result['order_id'], $result['shipment_id']]);
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
            
            if (isset($data['awb_assign_status']) && $data['awb_assign_status'] == 1 && $this->db) {
                $stmt = $this->db->prepare("UPDATE order_shipments SET awb_code = ?, courier_company_id = ?, courier_name = ?, status = 'AWB_GENERATED' WHERE shiprocket_shipment_id = ?");
                $stmt->execute([
                    $data['response']['data']['awb_code'],
                    $data['response']['data']['courier_company_id'],
                    $data['response']['data']['courier_name'],
                    $shipmentId
                ]);
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
