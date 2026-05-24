<?php

declare(strict_types=1);

use RentEase\Middleware\ApiSecurity;
use RentEase\Middleware\AuthMiddleware;
use RentEase\Services\LogisticsService;

require_once __DIR__ . '/../../../bootstrap.php';

header('Content-Type: application/json; charset=utf-8');
ApiSecurity::enforce($config);

$logisticsService = new LogisticsService($config);

try {
    $auth = AuthMiddleware::requireUser($config);
    $currentUser = $auth['user'];
    $token = $auth['token'];
} catch (\RuntimeException) {
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
