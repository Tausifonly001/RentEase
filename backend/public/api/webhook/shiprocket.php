<?php
require_once __DIR__ . '/../../../bootstrap.php';

// OWASP Security: Only accept POST
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    exit("Method Not Allowed");
}

$headers = getallheaders();
// Note: Sometimes headers are lowercase depending on the server configuration.
$webhookSecret = $_ENV['SHIPROCKET_WEBHOOK_TOKEN'] ?? '';

$apiKey = $headers['x-api-key'] ?? ($headers['X-Api-Key'] ?? null);

if (!$apiKey || $apiKey !== $webhookSecret) {
    error_log("Unauthorized Shiprocket webhook attempt. IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
    http_response_code(401);
    exit("Unauthorized");
}

$payload = file_get_contents('php://input');
$data = json_decode($payload, true);

if (!$data || !isset($data['awb'])) {
    http_response_code(400);
    exit("Invalid Payload");
}

try {
    $http = new \RentEase\Support\HttpClient();
    $serviceHeaders = [
        'apikey' => (string) $config['supabase_service_role_key'],
        'Authorization' => 'Bearer ' . $config['supabase_service_role_key'],
        'Accept' => 'application/json',
        'Prefer' => 'return=representation'
    ];

    // Sanitize input
    $awb = trim((string)($data['awb'] ?? ''));
    $status = trim((string)($data['current_status'] ?? ''));
    $statusCode = trim((string)($data['sr_status'] ?? ''));

    // 1. Update order_shipments
    $updateShipmentRes = $http->request(
        'PATCH',
        $config['supabase_url'] . '/rest/v1/order_shipments?awb_code=eq.' . urlencode($awb),
        $serviceHeaders,
        [
            'status' => $status,
            'status_code' => $statusCode,
            'updated_at' => date('c') // ISO 8601
        ]
    );

    if ($updateShipmentRes['status'] >= 400) {
        throw new RuntimeException("Failed to update shipment: " . json_encode($updateShipmentRes['body']));
    }

    // 2. If delivered, mark order as COMPLETED
    if ($statusCode == '7') { // 7 = Delivered in Shiprocket
        // Get order_id from shipment first
        $getShipmentRes = $http->request(
            'GET',
            $config['supabase_url'] . '/rest/v1/order_shipments?select=order_id&awb_code=eq.' . urlencode($awb),
            $serviceHeaders
        );

        if (!empty($getShipmentRes['body']) && is_array($getShipmentRes['body'])) {
            $orderId = $getShipmentRes['body'][0]['order_id'] ?? null;
            if ($orderId) {
                $updateOrderRes = $http->request(
                    'PATCH',
                    $config['supabase_url'] . '/rest/v1/orders?id=eq.' . urlencode((string)$orderId),
                    $serviceHeaders,
                    ['status' => 'COMPLETED']
                );
            }
        }
    }

    http_response_code(200);
    echo json_encode(["ok" => true, "message" => "Webhook processed successfully"]);
} catch (Throwable $e) {
    error_log("Webhook processing error: " . $e->getMessage());
    http_response_code(500);
    exit("Internal Server Error");
}
