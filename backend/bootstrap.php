<?php

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

$config = require __DIR__ . '/config/config.php';

// Make config globally accessible (needed by controllers instantiated via Router)
$GLOBALS['config'] = $config;

require_once __DIR__ . '/src/Support/helpers.php';

// =============================================================================
// Fallback: Register RentEase namespace autoloader directly
// Guards against Composer autoloader issues in some environments (XAMPP, etc.)
// =============================================================================
spl_autoload_register(static function (string $class): void {
    $prefix = 'RentEase\\';
    $baseDir = __DIR__ . '/src/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relative = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relative) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});