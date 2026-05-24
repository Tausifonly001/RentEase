<?php

declare(strict_types=1);

use RentEase\Services\AuthService;
use RentEase\Middleware\ApiSecurity;
use RentEase\Support\HttpClient;

require_once __DIR__ . '/../../bootstrap.php';

header('Content-Type: application/json; charset=utf-8');
ApiSecurity::enforce($config);

$authService = new AuthService($config);

$currentUser = null;
try {
    $token = $_COOKIE[$config['cookie_name'] ?? ''] ?? '';
    if ($token) {
        $currentUser = $authService->validateToken($token);
    }
} catch (\Throwable $ignored) {}

if (!$currentUser) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized user. Please log in first.']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'POST';

if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input)) {
        $input = $_POST;
    }

    $orderId = $input['order_id'] ?? null;
    $returnStatus = 'pending'; // Fix: Users can only request a return, never approve it.

    if (!$orderId) {
        http_response_code(400);
        echo json_encode(['error' => 'Order ID is required.']);
        exit;
    }

    $http = new HttpClient();
    $serviceHeaders = [
        'apikey' => (string) $config['supabase_service_role_key'],
        'Authorization' => 'Bearer ' . $config['supabase_service_role_key'],
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
        'Prefer' => 'return=representation'
    ];

    // Verify order ownership
    $verifyRes = $http->request(
        'GET',
        $config['supabase_url'] . '/rest/v1/orders?select=*&id=eq.' . urlencode((string)$orderId) . '&limit=1',
        $serviceHeaders
    );

    if ($verifyRes['status'] < 200 || $verifyRes['status'] >= 300 || empty($verifyRes['body'])) {
        http_response_code(404);
        echo json_encode(['error' => 'Order not found.']);
        exit;
    }

    $order = is_array($verifyRes['body']) ? ($verifyRes['body'][0] ?? $verifyRes['body']) : [];
    if ($order['user_id'] !== $currentUser['id']) {
        http_response_code(403);
        echo json_encode(['error' => 'Forbidden. This order belongs to another user.']);
        exit;
    }

    // Update return status
    $updateRes = $http->request(
        'PATCH',
        $config['supabase_url'] . '/rest/v1/orders?id=eq.' . urlencode((string)$orderId),
        $serviceHeaders,
        [
            'return_status' => $returnStatus
        ]
    );

    if ($updateRes['status'] >= 200 && $updateRes['status'] < 300) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Order return status updated to ' . $returnStatus,
            'order_id' => $orderId,
            'return_status' => $returnStatus
        ]);
    } else {
        http_response_code($updateRes['status']);
        echo json_encode(['error' => 'Failed to update return status']);
    }
    exit;
}
