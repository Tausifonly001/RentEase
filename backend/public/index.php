<?php

declare(strict_types=1);

require __DIR__ . '/../bootstrap.php';

$path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/', '/');
// Strip base path if applicable (e.g. /rentease/backend/public/)
$basePath = 'rentease/backend/public';
if (str_starts_with($path, $basePath)) {
    $path = trim(substr($path, strlen($basePath)), '/');
}

if (empty($path) || $path === 'index.php') {
    require __DIR__ . '/home.php';
    exit;
}

// Clean up extension from path for matching
$cleanPath = str_ends_with($path, '.php') ? substr($path, 0, -4) : $path;
$targetFile = __DIR__ . '/' . $cleanPath . '.php';

// Security check: ensure the file is actually in the public directory and not navigating up
$realPublicDir = realpath(__DIR__);
$realTarget = realpath($targetFile);

if ($realTarget && str_starts_with($realTarget, $realPublicDir) && file_exists($realTarget)) {
    require $realTarget;
    exit;
}

http_response_code(404);
header('Content-Type: text/plain; charset=utf-8');
echo 'Route not found: ' . $path;