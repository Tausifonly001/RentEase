<?php

require_once __DIR__ . '/../../bootstrap.php';

use RentEase\Services\MaintenanceService;
use RentEase\Middleware\ApiSecurity;
use RentEase\Middleware\AuthMiddleware;
use RentEase\Support\Csrf;

header('Content-Type: application/json');
ApiSecurity::enforce($config);

// OWASP Security: Only accept POST
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

try {
    // Read JSON payload
    $input = file_get_contents('php://input');
    $payload = json_decode($input, true);

    if (json_last_error() !== JSON_ERROR_NONE || !is_array($payload)) {
        throw new InvalidArgumentException("Invalid JSON payload");
    }

    // Validate CSRF
    $csrfToken = $payload['csrf_token'] ?? '';
    if (!Csrf::validate($csrfToken)) {
        http_response_code(419);
        echo json_encode(['error' => 'Invalid or expired CSRF token']);
        exit;
    }

    // Require authenticated user
    $auth = AuthMiddleware::requireUser($config);
    $jwt = $auth['token'];

    // Add user_id from auth to prevent forging requests for other users
    $payload['user_id'] = $auth['user']['id'] ?? '';

    $maintenanceService = new MaintenanceService($config);
    $result = $maintenanceService->createRequest($payload, $jwt);

    http_response_code(201);
    echo json_encode($result);

} catch (InvalidArgumentException $e) {
    http_response_code(422);
    echo json_encode(['error' => $e->getMessage()]);
} catch (RuntimeException $e) {
    $code = $e->getMessage() === 'Unauthorized' ? 401 : 409;
    http_response_code($code);
    echo json_encode(['error' => $e->getMessage()]);
} catch (Exception $e) {
    error_log("Maintenance Request API Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'An unexpected error occurred.']);
}
