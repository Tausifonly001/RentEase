<?php
declare(strict_types=1);

use RentEase\Services\AuthService;

require __DIR__ . '/../bootstrap.php';

$authService = new AuthService($config);
$authService->clearAuthCookie();

if (session_status() === PHP_SESSION_ACTIVE) {
    $_SESSION = [];
    session_destroy();
}

header('Location: index.php');
exit;
