<?php
declare(strict_types=1);

use RentEase\Services\AuthService;

require_once __DIR__ . '/../../../bootstrap.php';

$provider = $_GET['provider'] ?? null;
if (!$provider) {
    header('Location: ' . baseUrl('/login') . '?error=Missing provider');
    exit;
}

$authService = new AuthService($config);

$callbackUrl = rtrim((string) ($config['app_url'] ?? ''), '/') . '/auth-callback';

try {
    [$verifier, $challenge] = AuthService::generatePkcePair();
    $_SESSION['oauth_code_verifier'] = $verifier;
    $_SESSION['oauth_provider'] = $provider;

    $url = $authService->getOAuthUrl($provider, $callbackUrl, $challenge);
    header('Location: ' . $url);
} catch (Throwable $e) {
    header('Location: ' . baseUrl('/login') . '?error=' . urlencode($e->getMessage()));
}
exit;
