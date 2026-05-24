<?php

declare(strict_types=1);

use RentEase\Services\ProductService;
use RentEase\Services\AuthService;
use RentEase\Services\StripeService;
use RentEase\Middleware\ApiSecurity;

require_once __DIR__ . '/../../bootstrap.php';

header('Content-Type: application/json; charset=utf-8');
ApiSecurity::enforce($config);

$authService = new AuthService($config);
$productService = new ProductService($config);
$stripeService = new StripeService($config);

$currentUser = null;
try {
    $token = $_COOKIE[$config['cookie_name'] ?? ''] ?? '';
    if ($token) {
        $currentUser = $authService->validateToken($token);
    }
} catch (\Throwable $ignored) {}

if (!$currentUser) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized user. Please log in first.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    // Check $_POST if JSON body isn't provided
    $input = $_POST;
}

$cart = $input['items'] ?? $_SESSION['cart'] ?? [];
if (empty($cart)) {
    http_response_code(400);
    echo json_encode(['error' => 'Cart is empty.']);
    exit;
}

// Server-side validation
$subtotal = 0.0;
$deposits = 0.0;
$delivery = 29.0;
$validCart = [];

foreach ($cart as $id => $item) {
    try {
        $dbProd = $productService->findById((int)$id);
        if ($dbProd) {
            $monthlyPrice = (float)($dbProd['monthly_price'] ?? $item['monthly_price']);
            $quantity = (int)($item['quantity'] ?? $item['months'] ?? 1);
            if ($quantity < 1) { $quantity = 1; }

            $subtotal += $monthlyPrice * $quantity;
            $deposits += $monthlyPrice * $quantity * 0.5;

            $validCart[$id] = [
                'id' => $id,
                'name' => $dbProd['name'] ?? 'RentEase Premium Product',
                'monthly_price' => $monthlyPrice,
                'months' => $quantity,
                'image_url' => $dbProd['image_url'] ?? ''
            ];
        }
    } catch (\Throwable $e) {
        // Log or skip
    }
}

if (empty($validCart)) {
    http_response_code(400);
    echo json_encode(['error' => 'No valid items found.']);
    exit;
}

$tax = $subtotal * 0.08;
$total = $subtotal + $deposits + $delivery + $tax;

try {
    $baseUrl = rtrim((string)$config['app_url'], '/');
    $checkoutParams = [
        'success_url' => $baseUrl . '/orders.php?checkout_success=1',
        'cancel_url' => $baseUrl . '/cart.php',
        'customer_email' => $currentUser['email'],
        'client_reference_id' => $currentUser['id'],
        'line_items' => [
            [
                'name' => 'RentEase Total Initial Payment',
                'unit_amount' => (int) round($total * 100),
                'currency' => 'usd',
                'quantity' => 1
            ]
        ],
        'metadata' => [
            'user_id' => $currentUser['id'],
            'address' => $input['address'] ?? 'Not provided',
            'mobile_number' => $input['mobile_number'] ?? 'Not provided',
            'cart_items' => json_encode(array_values($validCart)),
            'total_amount' => (string) round($total, 2)
        ]
    ];

    $session = $stripeService->createCheckoutSession($checkoutParams);

    if (isset($session['url'])) {
        echo json_encode([
            'session_id' => $session['id'],
            'url' => $session['url']
        ]);
        exit;
    }

    http_response_code(500);
    echo json_encode([
        'error' => 'Stripe checkout session creation failed.',
        'details' => $session
    ]);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'An error occurred during payment processing: ' . $e->getMessage()
    ]);
}
