<?php

declare(strict_types=1);

use RentEase\Services\AuthService;
use RentEase\Middleware\ApiSecurity;

require_once __DIR__ . '/../../bootstrap.php';

header('Content-Type: application/json; charset=utf-8');
ApiSecurity::enforce($config);

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new RuntimeException('Method not allowed');
    }

    $payload = json_decode(file_get_contents('php://input') ?: '{}', true, 512, JSON_THROW_ON_ERROR);
    if (!is_array($payload)) {
        throw new InvalidArgumentException('Invalid request body');
    }

    $authService = new AuthService($config);
    $result = $authService->signup($payload);

    if (!empty($result['access_token'])) {
        $authService->persistSession($result, false);
    }

    echo json_encode(['ok' => true, 'user' => $result['user'] ?? null], JSON_THROW_ON_ERROR);
} catch (InvalidArgumentException $e) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => $e->getMessage()], JSON_THROW_ON_ERROR);
} catch (RuntimeException $e) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => $e->getMessage()], JSON_THROW_ON_ERROR);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Server error'], JSON_THROW_ON_ERROR);
}