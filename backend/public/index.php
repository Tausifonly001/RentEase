<?php

declare(strict_types=1);

require __DIR__ . '/../bootstrap.php';

$path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/', '/');

if (empty($path) || $path === 'index.php') {
    require __DIR__ . '/home.php';
    exit;
}

// Map of routes to files
$routes = [
    'home' => 'home.php',
    'browse' => 'browse.php',
    'cart' => 'cart.php',
    'checkout' => 'checkout.php',
    'dashboard' => 'dashboard.php',
    'faq-article' => 'faq-article.php',
    'help-center' => 'help-center.php',
    'login' => 'login.php',
    'logout' => 'logout.php',
    'maintenance-tracker' => 'maintenance-tracker.php',
    'orders' => 'orders.php',
    'payment-methods' => 'payment-methods.php',
    'product-detail' => 'product-detail.php',
    'settings' => 'settings.php',
    'signup' => 'signup.php',
    'tracking' => 'tracking.php',
    'wishlist' => 'wishlist.php',
    'rewards' => 'rewards.php',
    'referrals' => 'referrals.php',
    'partner' => 'partner.php',
    'concierge' => 'concierge.php',
    'request-maintenance' => 'request-maintenance.php',
    'return-pickup' => 'return-pickup.php',
    'reschedule' => 'reschedule.php',
    'survey' => 'survey.php'
];

// Clean up extension from path for matching
$cleanPath = str_ends_with($path, '.php') ? substr($path, 0, -4) : $path;

if (isset($routes[$cleanPath])) {
    require __DIR__ . '/' . $routes[$cleanPath];
    exit;
}

// Fallback for direct .php access if not in map but file exists
if (str_ends_with($path, '.php') && file_exists(__DIR__ . '/' . $path)) {
    require __DIR__ . '/' . $path;
    exit;
}

http_response_code(404);
header('Content-Type: text/plain; charset=utf-8');
echo 'Route not found: ' . $path;