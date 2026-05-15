<?php

declare(strict_types=1);

use RentEase\Services\AuthService;
use RentEase\Services\LogisticsService;

require_once __DIR__ . '/../../bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

$authService = new AuthService($config);
$logisticsService = new LogisticsService($config);

$currentUser = null;
$token = '';
try {
    $token = $_COOKIE[$config['cookie_name'] ?? ''] ?? '';
    if ($token) {
        $currentUser = $authService->validateToken($token);
    }
} catch (\Throwable $ignored) {}

if (!$currentUser) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'POST';

if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input)) {
        $input = $_POST;
    }

    $deliveryId = $input['delivery_id'] ?? null;
    $rating = $input['rating'] ?? 0;
    $comments = $input['comments'] ?? '';
    $tags = $input['tags'] ?? [];

    if (!$deliveryId) {
        http_response_code(400);
        echo json_encode(['error' => 'Delivery ID is required']);
        exit;
    }

    try {
        $payload = [
            'user_id' => $currentUser['id'],
            'delivery_id' => (int)$deliveryId,
            'rating' => (int)$rating,
            'comments' => $comments,
            'tags' => is_array($tags) ? json_encode($tags) : $tags,
            'created_at' => date('c')
        ];

        $result = $logisticsService->submitFeedback($payload, $token);
        echo json_encode($result);
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Method not allowed']);
