<?php
declare(strict_types=1);

use RentEase\Services\AuthService;

require __DIR__ . '/../bootstrap.php';

$code = $_GET['code'] ?? null;
$error = $_GET['error_description'] ?? $_GET['error'] ?? null;

if ($error) {
 header('Location: ' . baseUrl('/login') . '?error=' . urlencode((string) $error));
 exit;
}

if (!$code) {
 header('Location: ' . baseUrl('/login') . '?error=Missing authorization code');
 exit;
}

$verifier = (string) ($_SESSION['oauth_code_verifier'] ?? '');
unset($_SESSION['oauth_code_verifier'], $_SESSION['oauth_provider']);

if ($verifier === '') {
 header('Location: ' . baseUrl('/login') . '?error=OAuth session expired. Please try again.');
 exit;
}

$authService = new AuthService($config);

try {
 $session = $authService->exchangeCodeForSession((string) $code, $verifier);

 if (!empty($session['access_token'])) {
 $authService->persistSession($session, true);
 header('Location: ' . baseUrl('/'));
 exit;
 }

 header('Location: ' . baseUrl('/login') . '?error=Failed to retrieve access token');
} catch (Throwable $e) {
 header('Location: ' . baseUrl('/login') . '?error=' . urlencode($e->getMessage()));
}
exit;
