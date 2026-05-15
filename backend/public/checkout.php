<?php
declare(strict_types=1);

use RentEase\Services\ProductService;
use RentEase\Services\AuthService;
use RentEase\Services\StripeService;
use RentEase\Support\Csrf;
use RentEase\Support\HttpClient;

require __DIR__ . '/../bootstrap.php';

$authService = new AuthService($config);
$productService = new ProductService($config);
$stripeService = new StripeService($config);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$currentUser = null;
try {
    $token = $_COOKIE[$config['cookie_name'] ?? ''] ?? '';
    if ($token) {
        $currentUser = $authService->validateToken($token);
    }
} catch (Throwable $ignored) {}

if (!$currentUser) {
    header('Location: login.php?redirect=cart.php');
    exit;
}

$cart = $_SESSION['cart'] ?? [];
$kyc = $_SESSION['checkout_kyc'] ?? [];

if (empty($cart)) {
    header('Location: browse.php');
    exit;
}

$subtotal = 0.0;
$deposits = 0.0;
$delivery = 29.0;

$validCart = [];
foreach ($cart as $id => $item) {
    $dbProd = $productService->findById((int)$id);
    if ($dbProd) {
        $monthlyPrice = (float)($dbProd['monthly_price'] ?? $item['monthly_price']);
        $subtotal += $monthlyPrice;
        $deposits += $monthlyPrice * 0.5;
        $validCart[$id] = [
            'name' => $dbProd['name'] ?? 'Premium RentEase Product',
            'monthly_price' => $monthlyPrice,
            'months' => (int)($item['months'] ?? 3),
            'image_url' => $dbProd['image_url'] ?? 'https://placehold.co/150'
        ];
    }
}

$tax = $subtotal * 0.08;
$total = $subtotal + $deposits + $delivery + $tax;

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay'])) {
    if (!Csrf::validate($_POST['csrf_token'] ?? null)) {
        $error = 'Session token expired. Please reload.';
    } else {
        try {
            $baseUrl = rtrim(str_replace('index.php', '', $config['app_url']), '/');
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
                    'kyc_id' => $kyc['id_number'] ?? 'Not provided',
                    'delivery_date' => $kyc['delivery_date'] ?? 'Asap',
                    'delivery_time' => $kyc['delivery_time'] ?? '09:00 AM - 12:00 PM',
                    'address' => $kyc['address'] ?? 'Not provided',
                    'mobile_number' => $kyc['mobile_number'] ?? 'Not provided',
                    'cart_ids' => implode(',', array_keys($validCart))
                ]
            ];

            $session = $stripeService->createCheckoutSession($checkoutParams);

            if (isset($session['url'])) {
                $http = new HttpClient();
                $serviceHeaders = [
                    'apikey' => (string) $config['supabase_service_role_key'],
                    'Authorization' => 'Bearer ' . $config['supabase_service_role_key'],
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Prefer' => 'return=minimal'
                ];

                $orderData = [
                    'user_id' => $currentUser['id'],
                    'stripe_session_id' => $session['id'],
                    'total_amount' => (float)$total,
                    'payment_status' => 'pending',
                    'address' => $kyc['address'] ?? 'Not provided',
                    'mobile_number' => $kyc['mobile_number'] ?? 'Not provided'
                ];

                $orderRes = $http->request('POST', $config['supabase_url'] . '/rest/v1/orders', $serviceHeaders, $orderData);
                if ($orderRes['status'] >= 400) {
                    unset($orderData['address'], $orderData['mobile_number']);
                    $http->request('POST', $config['supabase_url'] . '/rest/v1/orders', $serviceHeaders, $orderData);
                }

                $_SESSION['cart'] = [];
                unset($_SESSION['checkout_kyc']);

                header('Location: ' . $session['url']);
                exit;
            } else {
                $error = 'Stripe initialization failure: ' . ($session['error']['message'] ?? 'Unknown API error.');
            }
        } catch (Throwable $e) {
            $error = 'An error occurred during payment processing: ' . $e->getMessage();
        }
    }
}

$cartCount = count($cart);

/**
 * Escape HTML output for security.
 *
 * @param string $value
 * @return string
 */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<?php require __DIR__ . '/partials/header.php'; ?>

<main class="flex-grow w-full max-w-container-max mx-auto px-4 md:px-8 py-lg md:py-xl">
    <!-- Header & Progress -->
    <div class="mb-lg reveal-element">
        <h1 class="font-h1 text-h1 text-on-surface mb-md">Secure Order Validation</h1>
        <p class="text-body-md text-on-surface-variant max-w-2xl">Review your lease selections and verification details before proceeding to secure payment.</p>
    </div>

    <?php if ($error): ?>
        <div class="bento-item mb-8 p-4 rounded-2xl bg-red-50 border border-red-100 flex items-center gap-3 text-red-700 text-sm font-semibold shadow-sm">
            <span class="material-symbols-outlined">error</span>
            <p><?= e($error) ?></p>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-lg">
        
        <!-- Left: Reservation Details -->
        <div class="lg:col-span-2 space-y-md">
            
            <!-- Items Section -->
            <div class="bento-item bg-white/70 backdrop-blur-xl rounded-[2rem] p-8 border border-white/40 shadow-xl shadow-slate-200/50">
                <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3 font-outfit">
                    <div class="p-2 rounded-xl bg-teal-50 text-teal-600">
                        <span class="material-symbols-outlined">inventory_2</span>
                    </div>
                    Validated Selections
                </h2>
                <div class="divide-y divide-outline-variant/30">
                    <?php foreach ($validCart as $id => $item): ?>
                        <div class="py-4 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="h-20 w-20 rounded-xl overflow-hidden bg-surface-container-highest border border-outline-variant/30 shrink-0">
                                    <img src="<?= e((string)($item['image_url'] ?? 'https://placehold.co/150')) ?>" alt="<?= e((string)$item['name']) ?>" class="h-full w-full object-cover">
                                </div>
                                <div>
                                    <h4 class="font-body-md font-bold text-on-surface"><?= e((string)$item['name']) ?></h4>
                                    <p class="text-label-caps text-on-surface-variant uppercase mt-1"><?= (int)$item['months'] ?> Month Rental Duration</p>
                                </div>
                            </div>
                            <span class="font-h3 text-h3 text-on-surface">$<?= number_format((float)$item['monthly_price'], 2) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- KYC Section -->
            <div class="bento-item bg-white/70 backdrop-blur-xl rounded-[2rem] p-8 border border-white/40 shadow-xl shadow-slate-200/50">
                <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3 font-outfit">
                    <div class="p-2 rounded-xl bg-blue-50 text-blue-600">
                        <span class="material-symbols-outlined">verified_user</span>
                    </div>
                    Verification Summary
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <div>
                        <span class="text-label-caps text-on-surface-variant uppercase">Identity Reference</span>
                        <p class="font-body-md font-semibold text-on-surface mt-1"><?= e((string)($kyc['id_number'] ?? 'Not provided')) ?></p>
                    </div>
                    <div>
                        <span class="text-label-caps text-on-surface-variant uppercase">Delivery Arrival</span>
                        <p class="font-body-md font-semibold text-on-surface mt-1"><?= e((string)($kyc['delivery_date'] ?? 'Asap')) ?> at <?= e((string)($kyc['delivery_time'] ?? '09:00 AM - 12:00 PM')) ?></p>
                    </div>
                    <?php if (!empty($kyc['work_verify'])): ?>
                        <div class="md:col-span-2">
                            <span class="text-label-caps text-on-surface-variant uppercase">Employment Proof</span>
                            <p class="font-body-md font-semibold text-on-surface mt-1"><?= e((string)$kyc['work_verify']) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right: Bill Summary -->
        <div class="reveal-element">
            <div class="bento-item bg-slate-900 text-white rounded-[2rem] p-8 shadow-2xl shadow-slate-900/20 sticky top-24">
                <h2 class="text-2xl font-bold mb-8 font-outfit">Bill Outlay</h2>

                <div class="space-y-4 mb-6">
                    <div class="flex justify-between">
                        <span class="text-body-md text-on-surface-variant">Base Monthly Rate</span>
                        <span class="font-body-md font-semibold text-on-surface">$<?= number_format($subtotal, 2) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-body-md text-on-surface-variant">Refundable Deposit</span>
                        <span class="font-body-md font-semibold text-on-surface">$<?= number_format($deposits, 2) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-body-md text-on-surface-variant">Tech & Logistics Fee</span>
                        <span class="font-body-md font-semibold text-on-surface">$<?= number_format($delivery, 2) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-body-md text-on-surface-variant">Service Taxes (8%)</span>
                        <span class="font-body-md font-semibold text-on-surface">$<?= number_format($tax, 2) ?></span>
                    </div>
                    <div class="pt-4 border-t border-outline-variant/30">
                        <div class="flex justify-between items-baseline">
                            <span class="font-h3 text-h3 text-on-surface">Total Due</span>
                            <span class="font-h1 text-h1 text-secondary">$<?= number_format($total, 2) ?></span>
                        </div>
                    </div>
                </div>

                <form action="checkout.php" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= e(Csrf::token()) ?>" />
                    <button type="submit" name="pay" value="1" class="flex items-center justify-center gap-2 bg-primary text-on-primary font-button px-6 py-4 rounded-xl shadow-md hover:bg-primary/90 active:scale-95 transition-all w-full text-lg">
                        <span class="material-symbols-outlined">payments</span>
                        Pay with Stripe
                    </button>
                </form>
                
                <p class="mt-4 text-center text-body-sm text-on-surface-variant">
                    Securely encrypted transaction via Stripe.
                </p>
            </div>
        </div>

    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    gsap.from(".bento-item", {
        opacity: 0,
        y: 30,
        duration: 0.8,
        stagger: 0.15,
        ease: "power4.out"
    });
});
</script>

<?php require __DIR__ . '/partials/footer.php'; ?>

