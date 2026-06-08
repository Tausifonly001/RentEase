<?php
declare(strict_types=1);

use RentEase\Services\AuthService;

require_once __DIR__ . '/../bootstrap.php';

$authService = new AuthService($config);
$authService->clearAuthCookie();

if (session_status() === PHP_SESSION_ACTIVE) {
 $_SESSION = [];
 session_destroy();
}

header('Location: ' . baseUrl('/'));
exit;
