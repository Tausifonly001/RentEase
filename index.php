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

require_once __DIR__ . '/backend/bootstrap.php';

use RentEase\Routing\Router;
use RentEase\Controllers\AdminController;
use RentEase\Controllers\ShopController;
use RentEase\Controllers\VendorController;
use RentEase\Support\ValidationException;

$router = new Router();

// API Routes
$router->post('/api/signup', function() use ($config) { require __DIR__ . '/backend/public/api/signup.php'; });
$router->post('/api/login', function() use ($config) { require __DIR__ . '/backend/public/api/login.php'; });
$router->get('/api/auth/oauth', function() use ($config) { require __DIR__ . '/backend/public/api/auth/oauth.php'; });
$router->get('/api/products', function() use ($config) { require __DIR__ . '/backend/public/api/products.php'; });
$router->get('/api/furniture', function() use ($config) { require __DIR__ . '/backend/public/api/furniture.php'; });
$router->post('/api/checkout', function() use ($config) { require __DIR__ . '/backend/public/api/checkout.php'; });
$router->post('/api/book-rental', function() use ($config) { require __DIR__ . '/backend/public/api/book-rental.php'; });
$router->get('/api/orders/{id}', function($id) use ($config) { $_GET['id'] = $id; require __DIR__ . '/backend/public/api/orders.php'; });
$router->get('/api/orders', function() use ($config) { require __DIR__ . '/backend/public/api/orders.php'; });
$router->post('/api/returns', function() use ($config) { require __DIR__ . '/backend/public/api/returns.php'; });
$router->post('/api/maintenance-request', function() use ($config) { require __DIR__ . '/backend/public/api/maintenance-request.php'; });
$router->post('/api/update-profile', function() use ($config) { require __DIR__ . '/backend/public/api/update-profile.php'; });
$router->post('/api/webhook/stripe', function() use ($config) { require __DIR__ . '/backend/public/api/webhook/stripe.php'; });
$router->post('/api/webhook/shiprocket', function() use ($config) { require __DIR__ . '/backend/public/api/webhook/shiprocket.php'; });
$router->post('/api/support/ticket', function() use ($config) { require __DIR__ . '/backend/public/api/support/ticket.php'; });
$router->post('/api/chat', function() use ($config) { require __DIR__ . '/backend/public/api/chat.php'; });
$router->get('/api/logistics/status', function() use ($config) { require __DIR__ . '/backend/public/api/logistics/status.php'; });
$router->post('/api/logistics/reschedule', function() use ($config) { require __DIR__ . '/backend/public/api/logistics/reschedule.php'; });
$router->post('/api/logistics/return-pickup', function() use ($config) { require __DIR__ . '/backend/public/api/logistics/return-pickup.php'; });
$router->post('/api/logistics/survey', function() use ($config) { require __DIR__ . '/backend/public/api/logistics/survey.php'; });

// Controller Routes
$router->get('/admin', [AdminController::class, 'dashboard']);
$router->post('/admin', [AdminController::class, 'action']);
$router->get('/browse', [ShopController::class, 'browse']);
$router->get('/shop', [ShopController::class, 'browse']);
$router->post('/browse', [ShopController::class, 'action']);
$router->get('/vendor-panel', [VendorController::class, 'dashboard']);
$router->post('/vendor-panel', [VendorController::class, 'action']);

// Map simple string routes to files
$viewRoutes = [
    'home' => 'home.php',
    'product-detail' => 'product-detail.php',
    'cart' => 'cart.php',
    'dashboard' => 'dashboard.php',
    'checkout' => 'checkout.php',
    'orders' => 'orders.php',
    'login' => 'login.php',
    'signup' => 'signup.php',
    'logout' => 'logout.php',
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
    'support' => 'support.php',
    'feedback' => 'survey.php',
    'maintenance' => 'maintenance-tracker.php',
    'payments' => 'payment-methods.php',
    'coming-soon' => 'coming-soon.php',
    'success' => 'success.php',
    'agent-tracking' => 'agent-tracking.php',
    'auth-callback' => 'auth-callback.php',
];

foreach ($viewRoutes as $route => $file) {
    $router->get('/' . $route, function() use ($file, $config) {
        require __DIR__ . '/backend/public/' . $file;
    });
    $router->post('/' . $route, function() use ($file, $config) {
        require __DIR__ . '/backend/public/' . $file;
    });
}

$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$normalizedUri = '/' . $cleanPath;

try {
    if (!$router->dispatch($normalizedUri, $requestMethod)) {
        http_response_code(404);
        require __DIR__ . '/backend/public/404.php';
    }
} catch (ValidationException $e) {
    if (strpos($normalizedUri, '/api/') === 0) {
        http_response_code(422);
        header('Content-Type: application/json');
        echo json_encode(['error' => $e->getMessage(), 'details' => $e->getErrors()]);
        exit;
    }
    // For non-API, could redirect with flash
    \RentEase\Support\Session::flash('error', 'Validation failed: ' . implode(', ', $e->getErrors()));
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
} catch (\Throwable $e) {
    if (strpos($normalizedUri, '/api/') === 0) {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    }
    throw $e;
}

