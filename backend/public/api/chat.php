<?php
declare(strict_types=1);

use RentEase\Middleware\ApiSecurity;

require_once __DIR__ . '/../../bootstrap.php';

header('Content-Type: application/json');
ApiSecurity::enforce($config);

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

try {
    $token = $_COOKIE[$config['cookie_name'] ?? ''] ?? '';
    if ($token) {
        $authService = new \RentEase\Services\AuthService($config);
        $authService->validateToken($token);
    }
} catch (\Throwable $e) {
    // Ignore auth errors, allow guest chat
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

$apiKey = $config['groq_api_key'] ?? '';

if ($apiKey === '') {
    sleep(1);
    $lowerMessage = strtolower($message);
    $reply = "I'm a virtual concierge. Please set GROQ_API_KEY in the .env file to enable smart AI features.";

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

$url = 'https://api.groq.com/openai/v1/chat/completions';

$data = [
    'model' => 'llama-3.3-70b-versatile',
    'messages' => [
        [
            'role' => 'system',
            'content' => "You are an AI support concierge for a premium furniture rental service called RentEase. Provide a helpful, concise response to the user's message."
        ],
        [
            'role' => 'user',
            'content' => $message
        ]
    ]
];

$isLocal = strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false || strpos($config['app_url'] ?? '', 'localhost') !== false;

$ch = curl_init($url);
$curlOptions = [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    ],
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_TIMEOUT => 20,
];

if ($isLocal) {
    $curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
    $curlOptions[CURLOPT_SSL_VERIFYHOST] = false;
}

curl_setopt_array($ch, $curlOptions);
$response = curl_exec($ch);
$httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($httpCode !== 200 || !is_string($response)) {
    error_log("Groq API Error - HTTP Code: " . $httpCode . ", cURL Error: " . $curlError . ", Response: " . (is_string($response) ? $response : 'Not a string'));
    http_response_code(502);
    echo json_encode([
        'error' => 'Failed to connect to AI service',
        'details' => is_string($response) ? $response : 'cURL error: ' . $curlError
    ], JSON_THROW_ON_ERROR);
    exit;
}

$responseData = json_decode($response, true);
$replyText = $responseData['choices'][0]['message']['content'] ?? "I'm sorry, I couldn't understand that.";

echo json_encode(['reply' => $replyText]);
