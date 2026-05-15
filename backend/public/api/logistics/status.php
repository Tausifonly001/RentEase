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

$deliveryId = $_GET['id'] ?? null;

if (!$deliveryId) {
    http_response_code(400);
    echo json_encode(['error' => 'Delivery ID is required']);
    exit;
}

try {
    $delivery = $logisticsService->getDeliveryById((int)$deliveryId, $token);
    echo json_encode($delivery);
} catch (\Throwable $e) {
    http_response_code(404);
    echo json_encode(['error' => $e->getMessage()]);
}
