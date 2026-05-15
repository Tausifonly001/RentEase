<?php
declare(strict_types=1);

use RentEase\Services\AuthService;

require __DIR__ . '/../bootstrap.php';

$code = $_GET['code'] ?? null;
$error = $_GET['error_description'] ?? $_GET['error'] ?? null;

if ($error) {
    header('Location: login.php?error=' . urlencode($error));
    exit;
}

if (!$code) {
    header('Location: login.php?error=Missing authorization code');
    exit;
}

$authService = new AuthService($config);

try {
    $session = $authService->exchangeCodeForSession($code);
    
    $token = (string) ($session['access_token'] ?? '');
    $expires = (int) ($session['expires_in'] ?? 3600);

    if ($token !== '') {
        $authService->setAuthCookie($token, $expires);
        header('Location: index.php');
        exit;
    } else {
        header('Location: login.php?error=Failed to retrieve access token');
    }
} catch (Throwable $e) {
    header('Location: login.php?error=' . urlencode($e->getMessage()));
}
exit;
