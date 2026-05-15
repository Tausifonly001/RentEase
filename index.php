<?php

declare(strict_types=1);

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

// Strip base path if it exists
$basePath = '/rentease';
if (strpos($path, $basePath) === 0) {
    $path = substr($path, strlen($basePath));
}

// Strip leading index.php if it exists
if (strpos($path, '/index.php') === 0) {
    $path = substr($path, strlen('/index.php'));
}

// Normalize path: remove trailing slash and .php extension
$cleanPath = trim($path, '/');
if (str_ends_with($cleanPath, '.php')) {
    $cleanPath = substr($cleanPath, 0, -4);
}

// If empty path, it's home
if ($cleanPath === '') {
    $cleanPath = 'home';
}

// Define the route mapping
$routes = [
    'home' => 'home.php',
    'browse' => 'browse.php',
    'product-detail' => 'product-detail.php',
    'cart' => 'cart.php',
    'dashboard' => 'dashboard.php',
    'checkout' => 'checkout.php',
    'orders' => 'orders.php',
    'admin' => 'admin.php',
    'stripe_webhook' => 'stripe_webhook.php',
    'login' => 'login.php',
    'signup' => 'signup.php',
    'logout' => 'logout.php',
    
    // New Support & Logistics Pages
    'rewards' => 'rewards.php',
    'referrals' => 'referrals.php',
    'partner' => 'partner.php',
    'concierge' => 'concierge.php',
    'request-maintenance' => 'request-maintenance.php',
    'return-pickup' => 'return-pickup.php',
    'reschedule' => 'reschedule.php',
    'survey' => 'survey.php',
    'maintenance-tracker' => 'maintenance-tracker.php',
    'tracking' => 'tracking.php',
    'faq-article' => 'faq-article.php',
    'help-center' => 'help-center.php',
    'payment-methods' => 'payment-methods.php',
    'settings' => 'settings.php',
    'wishlist' => 'wishlist.php',
    'maintenance-history' => 'maintenance-tracker.php',
    'post-delivery-survey' => 'survey.php',
    'about' => 'about.php',
    'privacy' => 'privacy.php',
    'terms' => 'terms.php',
    'coming-soon' => 'coming-soon.php'
];

// Handle specific API patterns
if (strpos($path, '/api/') === 0) {
    $apiFile = __DIR__ . '/backend/public' . $path;
    if (file_exists($apiFile) && !is_dir($apiFile)) {
        require $apiFile;
        exit;
    }
    $apiFileWithPhp = __DIR__ . '/backend/public' . $path . '.php';
    if (file_exists($apiFileWithPhp)) {
        require $apiFileWithPhp;
        exit;
    }
    
    // Special case for orders API with ID
    if (strpos($path, '/api/orders/') === 0) {
        $parts = explode('/', trim($path, '/'));
        if (count($parts) === 3 && $parts[0] === 'api' && $parts[1] === 'orders') {
            $_GET['id'] = $parts[2];
            require __DIR__ . '/backend/public/api/orders.php';
            exit;
        }
    }
}

// Special case for old hardcoded API paths
if ($path === '/api/checkout' || $path === '/api/checkout.php') {
    require __DIR__ . '/backend/public/api/checkout.php';
    exit;
}
if ($path === '/api/webhook/stripe' || $path === '/api/webhook/stripe.php') {
    require __DIR__ . '/backend/public/api/webhook/stripe.php';
    exit;
}
if ($path === '/api/returns' || $path === '/api/returns.php') {
    require __DIR__ . '/backend/public/api/returns.php';
    exit;
}

// Final check against routes map
if (isset($routes[$cleanPath])) {
    $targetFile = __DIR__ . '/backend/public/' . $routes[$cleanPath];
    if (file_exists($targetFile)) {
        require $targetFile;
        exit;
    }
}

// Route not found
http_response_code(404);
header('Content-Type: text/plain; charset=utf-8');
echo 'Route not found';

