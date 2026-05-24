<?php
declare(strict_types=1);

use RentEase\Middleware\ApiSecurity;
use RentEase\Middleware\AuthMiddleware;

require __DIR__ . '/../../bootstrap.php';

header('Content-Type: application/json');
ApiSecurity::enforce($config);

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

try {
    AuthMiddleware::requireUser($config);
} catch (\RuntimeException) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$input = json_decode(file_get_contents('php://input') ?: '{}', true);
$message = is_array($input) ? trim((string) ($input['message'] ?? '')) : '';

if ($message === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Message is required']);
    exit;
}

if (mb_strlen($message) > 2000) {
    http_response_code(422);
    echo json_encode(['error' => 'Message is too long']);
    exit;
}

$apiKey = getenv('GEMINI_API_KEY') ?: '';

if ($apiKey === '') {
    sleep(1);
    $lowerMessage = strtolower($message);
    $reply = "I'm a virtual concierge. Please set GEMINI_API_KEY in the .env file to enable smart AI features.";

    if (strpos($lowerMessage, 'hello') !== false || strpos($lowerMessage, 'hi') !== false) {
        $reply = "Hello! How can I help you with your rental today?";
    } elseif (strpos($lowerMessage, 'billing') !== false) {
        $reply = "For billing inquiries, please check your dashboard or email support@rentease.com.";
    } elseif (strpos($lowerMessage, 'maintenance') !== false) {
        $reply = "You can submit a maintenance request from your account dashboard.";
    } elseif (strpos($lowerMessage, 'delivery') !== false) {
        $reply = "Your delivery status can be tracked via the active rentals section in your profile.";
    }

    echo json_encode(['reply' => $reply]);
    exit;
}

$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . urlencode($apiKey);

$data = [
    'contents' => [
        [
            'role' => 'user',
            'parts' => [
                ['text' => "You are an AI support concierge for a premium furniture rental service called RentEase. Provide a helpful, concise response to the user's message. User message: " . $message],
            ],
        ],
    ],
];

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS => json_encode($data),
]);
$response = curl_exec($ch);
$httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200 || !is_string($response)) {
    http_response_code(502);
    echo json_encode(['error' => 'Failed to connect to AI service']);
    exit;
}

$responseData = json_decode($response, true);
$replyText = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? "I'm sorry, I couldn't understand that.";

echo json_encode(['reply' => $replyText]);
