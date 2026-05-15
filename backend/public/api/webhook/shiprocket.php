<?php
require_once __DIR__ . '/../../../../bootstrap.php';

// OWASP Security: Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit("Method Not Allowed");
}

$headers = getallheaders();
// Note: Sometimes headers are lowercase depending on the server configuration.
$webhookSecret = $_ENV['SHIPROCKET_WEBHOOK_TOKEN'] ?? '';

$apiKey = $headers['x-api-key'] ?? ($headers['X-Api-Key'] ?? null);

if (!$apiKey || $apiKey !== $webhookSecret) {
    error_log("Unauthorized Shiprocket webhook attempt. IP: " . $_SERVER['REMOTE_ADDR']);
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
    // Use PDO directly from ENV loaded via bootstrap.php
    $dsn = "pgsql:host=" . $_ENV['DB_HOST'] . ";port=" . ($_ENV['DB_PORT'] ?? '5432') . ";dbname=" . $_ENV['DB_NAME'];
    $db = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // Sanitize input
    $awb = filter_var($data['awb'], FILTER_SANITIZE_STRING);
    $status = filter_var($data['current_status'], FILTER_SANITIZE_STRING);
    $statusCode = filter_var($data['sr_status'], FILTER_SANITIZE_STRING);

    $stmt = $db->prepare("UPDATE order_shipments SET status = ?, status_code = ?, updated_at = NOW() WHERE awb_code = ?");
    $stmt->execute([$status, $statusCode, $awb]);

    // If delivered, handle website-specific logic (e.g., mark order as COMPLETED)
    if ($statusCode == '7') { // 7 = Delivered in Shiprocket
        $stmt = $db->prepare("UPDATE orders SET status = 'COMPLETED' WHERE id IN (SELECT order_id FROM order_shipments WHERE awb_code = ?)");
        $stmt->execute([$awb]);
    }

    http_response_code(200);
    echo json_encode(["message" => "Webhook processed successfully"]);
} catch (Exception $e) {
    error_log("Webhook processing error: " . $e->getMessage());
    http_response_code(500);
    exit("Internal Server Error");
}
