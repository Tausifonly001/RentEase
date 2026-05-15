<?php
declare(strict_types=1);

use RentEase\Services\AuthService;

require __DIR__ . '/../../../bootstrap.php';

$provider = $_GET['provider'] ?? null;
if (!$provider) {
    header('Location: ../../login.php?error=Missing provider');
    exit;
}

$authService = new AuthService($config);

// Construct the full callback URL
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$callbackUrl = $protocol . '://' . $host . '/rentease/auth-callback.php';

try {
    $url = $authService->getOAuthUrl($provider, $callbackUrl);
    header('Location: ' . $url);
} catch (Throwable $e) {
    header('Location: ../../login.php?error=' . urlencode($e->getMessage()));
}
exit;
