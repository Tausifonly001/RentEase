<?php

declare(strict_types=1);

use RentEase\Services\AuthService;
use RentEase\Support\HttpClient;

require_once __DIR__ . '/../../bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

$authService = new AuthService($config);

$currentUser = null;
try {
    $token = $_COOKIE[$config['cookie_name'] ?? ''] ?? '';
    if ($token) {
        $currentUser = $authService->validateToken($token);
    }
} catch (\Throwable $ignored) {}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($method === 'GET') {
    // GET /api/orders/:id
    if (!$currentUser) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized user. Please log in.']);
        exit;
    }

    $id = $_GET['id'] ?? null;
    if (!$id) {
        // Fallback to fetching all user orders if ID is not specified
        $http = new HttpClient();
        $userHeaders = [
            'apikey' => (string) $config['supabase_anon_key'],
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ];

        $res = $http->request(
            'GET',
            $config['supabase_url'] . '/rest/v1/orders?select=*&user_id=eq.' . urlencode($currentUser['id']) . '&order=created_at.desc',
            $userHeaders
        );

        if ($res['status'] >= 200 && $res['status'] < 300) {
            echo json_encode($res['body']);
        } else {
            http_response_code($res['status']);
            echo json_encode(['error' => 'Failed to fetch orders.']);
        }
        exit;
    }

    $http = new HttpClient();
    $serviceHeaders = [
        'apikey' => (string) $config['supabase_service_role_key'],
        'Authorization' => 'Bearer ' . $config['supabase_service_role_key'],
        'Accept' => 'application/json'
    ];

    $res = $http->request(
        'GET',
        $config['supabase_url'] . '/rest/v1/orders?select=*&id=eq.' . urlencode((string)$id) . '&limit=1',
        $serviceHeaders
    );

    if ($res['status'] >= 200 && $res['status'] < 300 && !empty($res['body'][0])) {
        $order = $res['body'][0];
        // Authorization check
        if ($order['user_id'] !== $currentUser['id']) {
            http_response_code(403);
            echo json_encode(['error' => 'Forbidden. Access to this order is restricted.']);
            exit;
        }

        echo json_encode($order);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Order not found.']);
    }
    exit;
}

if ($method === 'POST') {
    // POST /api/orders -> create order (internal use)
    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input)) {
        $input = $_POST;
    }

    $userId = $input['user_id'] ?? $currentUser['id'] ?? null;
    if (!$userId) {
        http_response_code(401);
        echo json_encode(['error' => 'User ID is required.']);
        exit;
    }

    $totalAmount = $input['total_amount'] ?? 0;
    $items = $input['items'] ?? [];

    $orderData = [
        'user_id' => $userId,
        'stripe_session_id' => $input['stripe_session_id'] ?? 'internal_' . rand(10000, 99999),
        'total_amount' => (float)$totalAmount,
        'payment_status' => $input['payment_status'] ?? 'pending',
        'items' => $items,
        'shipping_status' => $input['shipping_status'] ?? 'processing',
        'return_status' => 'none'
    ];

    $http = new HttpClient();
    $serviceHeaders = [
        'apikey' => (string) $config['supabase_service_role_key'],
        'Authorization' => 'Bearer ' . $config['supabase_service_role_key'],
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
        'Prefer' => 'return=representation'
    ];

    $createRes = $http->request(
        'POST',
        $config['supabase_url'] . '/rest/v1/orders',
        $serviceHeaders,
        $orderData
    );

    if ($createRes['status'] >= 200 && $createRes['status'] < 300 && !empty($createRes['body'])) {
        http_response_code(201);
        echo json_encode(is_array($createRes['body']) ? ($createRes['body'][0] ?? $createRes['body']) : []);
    } else {
        http_response_code($createRes['status']);
        echo json_encode(['error' => 'Failed to create order', 'details' => $createRes['body']]);
    }
    exit;
}
