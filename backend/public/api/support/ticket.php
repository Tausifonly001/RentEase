<?php

declare(strict_types=1);

use RentEase\Services\AuthService;
use RentEase\Services\SupportService;

require_once __DIR__ . '/../../bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

$authService = new AuthService($config);
$supportService = new SupportService($config);

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

    $category = $input['category'] ?? '';
    $subject = $input['subject'] ?? '';
    $description = $input['description'] ?? '';

    if (!$category || !$subject || !$description) {
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
            'updated_at' => date('c')
        ];

        $result = $supportService->createTicket($payload, $token);
        echo json_encode($result);
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Method not allowed']);
