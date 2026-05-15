<?php

require_once __DIR__ . '/../../bootstrap.php';

use RentEase\Services\MaintenanceService;
use RentEase\Middleware\AuthMiddleware;
use RentEase\Support\Csrf;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

try {
    // Read JSON payload
    $input = file_get_contents('php://input');
    $payload = json_decode($input, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
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
    $user = AuthMiddleware::requireUser();
    $jwt = $_COOKIE['access_token'] ?? '';
    
    // Add user_id from auth to prevent forging requests for other users
    $payload['user_id'] = $user['id'];

    $maintenanceService = new MaintenanceService();
    $result = $maintenanceService->createRequest($payload, $jwt);

    http_response_code(201);
    echo json_encode($result);

} catch (InvalidArgumentException $e) {
    http_response_code(422);
    echo json_encode(['error' => $e->getMessage()]);
} catch (RuntimeException $e) {
    http_response_code(400); // Or 409 depending on error type
    echo json_encode(['error' => $e->getMessage()]);
} catch (Exception $e) {
    error_log("Maintenance Request API Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'An unexpected error occurred.']);
}
