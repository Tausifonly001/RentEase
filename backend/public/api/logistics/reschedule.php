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
    echo json_encode(['error' => 'Unauthorized user. Please log in first.']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'POST';

if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input)) {
        $input = $_POST;
    }

    $deliveryId = $input['delivery_id'] ?? null;
    $newDate = $input['date'] ?? null;
    $newTimeSlot = $input['time_slot'] ?? null;
    $reason = $input['reason'] ?? null;

    if (!$deliveryId || !$newDate || !$newTimeSlot) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields: delivery_id, date, time_slot are required.']);
        exit;
    }

    try {
        $result = $logisticsService->rescheduleDelivery((int)$deliveryId, $newDate, $newTimeSlot, $reason, $token);
        echo json_encode($result);
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Method not allowed.']);
