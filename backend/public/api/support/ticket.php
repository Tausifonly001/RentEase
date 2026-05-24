<?php

declare(strict_types=1);

use RentEase\Middleware\ApiSecurity;
use RentEase\Middleware\AuthMiddleware;
use RentEase\Services\SupportService;

require_once __DIR__ . '/../../../bootstrap.php';

header('Content-Type: application/json; charset=utf-8');
ApiSecurity::enforce($config);

try {
    $auth = AuthMiddleware::requireUser($config);
    $currentUser = $auth['user'];
    $token = $auth['token'];
} catch (\RuntimeException) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$supportService = new SupportService($config);

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input') ?: '{}', true);
if (!is_array($input)) {
    $input = $_POST;
}

$category = trim((string) ($input['category'] ?? ''));
$subject = trim((string) ($input['subject'] ?? ''));
$description = trim((string) ($input['description'] ?? ''));

if ($category === '' || $subject === '' || $description === '') {
    http_response_code(400);
    echo json_encode(['error' => 'All fields are required']);
    exit;
}

try {
    $payload = [
        'user_id' => $currentUser['id'],
        'category' => $category,
        'subject' => $subject,
        'description' => $description,
        'status' => 'OPEN',
        'created_at' => date('c'),
        'updated_at' => date('c'),
    ];

    $result = $supportService->createTicket($payload, $token);
    echo json_encode($result);
} catch (\Throwable $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
