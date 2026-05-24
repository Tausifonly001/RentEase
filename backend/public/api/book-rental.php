<?php

declare(strict_types=1);

use RentEase\Middleware\AuthMiddleware;
use RentEase\Middleware\ApiSecurity;
use RentEase\Services\RentalService;
use RentEase\Support\Csrf;

require __DIR__ . '/../../bootstrap.php';

header('Content-Type: application/json; charset=utf-8');
ApiSecurity::enforce($config);

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new RuntimeException('Method not allowed');
    }

    $csrfHeader = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
    if (!Csrf::validate($csrfHeader)) {
        http_response_code(419);
        echo json_encode(['ok' => false, 'message' => 'CSRF validation failed'], JSON_THROW_ON_ERROR);
        exit;
    }

    $raw = file_get_contents('php://input');
    $payload = json_decode($raw ?: '{}', true, 512, JSON_THROW_ON_ERROR);
    if (!is_array($payload)) {
        throw new InvalidArgumentException('Invalid payload');
    }

    $auth = AuthMiddleware::requireUser($config);
    $payload['user_id'] = (string) ($auth['user']['id'] ?? '');

    $rentalService = new RentalService($config);
    $booking = $rentalService->createBooking($payload, (string) $auth['token']);

    echo json_encode(['ok' => true, 'booking' => $booking], JSON_THROW_ON_ERROR);
} catch (InvalidArgumentException $e) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => $e->getMessage()], JSON_THROW_ON_ERROR);
} catch (RuntimeException $e) {
    $code = $e->getMessage() === 'Unauthorized' ? 401 : 409;
    http_response_code($code);
    echo json_encode(['ok' => false, 'message' => $e->getMessage()], JSON_THROW_ON_ERROR);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Unexpected server error'], JSON_THROW_ON_ERROR);
}