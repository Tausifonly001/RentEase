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

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

$currentUser = null;
try {
    $token = $_COOKIE[$config['cookie_name'] ?? ''] ?? '';
    if ($token) $currentUser = $authService->validateToken($token);
} catch (Throwable $ignored) {}

if (!$currentUser) { header('Location: ' . baseUrl('/login?redirect=cart')); exit; }

$cart = $_SESSION['cart'] ?? [];
$kyc = $_SESSION['checkout_kyc'] ?? [];

if (empty($cart)) { header('Location: ' . baseUrl('/shop')); exit; }

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

$cartItemsForMetadata = [];
foreach ($validCart as $id => $item) {
    $cartItemsForMetadata[] = [
        'id' => (string)$id, 'name' => $item['name'],
        'monthly_price' => $item['monthly_price'], 'months' => $item['months'],
        'image_url' => $item['image_url']
    ];
}

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay'])) {
    if (!Csrf::validate($_POST['csrf_token'] ?? null)) {
        $error = 'Session token expired. Please reload.';
    } else {
        try {
            $baseUrl = rtrim(str_replace('index.php', '', $config['app_url']), '/');
            $checkoutParams = [
                'success_url' => $baseUrl . '/success',
                'cancel_url' => $baseUrl . '/cart',
                'customer_email' => $currentUser['email'],
                'client_reference_id' => $currentUser['id'],
                'line_items' => [[
                    'name' => 'RentEase Total Initial Payment',
                    'unit_amount' => (int) round($total * 100),
                    'currency' => 'usd',
                    'quantity' => 1
                ]],
                'metadata' => [
                    'user_id' => $currentUser['id'],
                    'kyc_id' => $kyc['id_number'] ?? 'Not provided',
                    'delivery_date' => $kyc['delivery_date'] ?? 'Asap',
                    'delivery_time' => $kyc['delivery_time'] ?? '09:00 AM - 12:00 PM',
                    'address' => $kyc['address'] ?? 'Not provided',
                    'mobile_number' => $kyc['mobile_number'] ?? 'Not provided',
                    'cart_items' => json_encode($cartItemsForMetadata)
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
                    'items' => $cartItemsForMetadata,
                    'shipping_status' => 'pending'
                ];

                $orderHeaders = array_merge($serviceHeaders, ['Prefer' => 'return=representation']);
                $orderRes = $http->request('POST', $config['supabase_url'] . '/rest/v1/orders', $orderHeaders, $orderData);
                $newOrder = $orderRes['body'][0] ?? null;
                $orderId = $newOrder['id'] ?? null;

                if ($orderId) {
                    $rentalService = new \RentEase\Services\RentalService($config);
                    $rentalErrors = [];
                    foreach ($validCart as $prodId => $details) {
                        try {
                            $rentalRes = $rentalService->createBookingWithServiceRole([
                                'user_id' => $currentUser['id'],
                                'product_id' => (int)$prodId,
                                'start_date' => date('Y-m-d'),
                                'end_date' => date('Y-m-d', strtotime('+' . ($details['months'] ?? 3) . ' months')),
                                'status' => 'pending',
                                'order_id' => $orderId
                            ]);
                            $rentalId = $rentalRes[0]['id'] ?? null;
                            if ($rentalId) {
                                $rentalService->createDelivery([
                                    'order_id' => $orderId, 'rental_id' => $rentalId,
                                    'user_id' => $currentUser['id'], 'type' => 'DELIVERY',
                                    'scheduled_date' => $kyc['delivery_date'] ?? date('Y-m-d', strtotime('+2 days')),
                                    'time_slot' => $kyc['delivery_time'] ?? '09:00 AM - 12:00 PM',
                                    'address' => $kyc['address'] ?? 'Not provided', 'status' => 'SCHEDULED',
                                    'agent_notes' => 'Awaiting payment confirmation.'
                                ]);
                            }
                        } catch (\Throwable $e) {
                            $rentalErrors[] = htmlspecialchars($details['name'] ?? "Product #{$prodId}") . ': ' . $e->getMessage();
                            error_log("Checkout rental creation failed for product {$prodId}: " . $e->getMessage());
                        }
                    }
                    if (!empty($rentalErrors)) {
                        $error = 'Some items could not be reserved: ' . implode('; ', $rentalErrors) . '. Please try again or contact support.';
                    }
                } else {
                    $error = 'We could not create your lease order. Please try again or contact support.';
                }

                if (empty($error)) {
                    $_SESSION['cart'] = [];
                    unset($_SESSION['checkout_kyc']);
                    header('Location: ' . $session['url']);
                    exit;
                }
            } else {
                $error = 'Stripe initialization failure: ' . ($session['error']['message'] ?? 'Unknown API error.');
            }
        } catch (Throwable $e) {
            $error = 'An error occurred during payment processing: ' . $e->getMessage();
        }
    }
}

$cartCount = count($cart);

$pageTitle = 'Secure Checkout - RentEase';
$pageDescription = 'Complete your rental request with secure checkout.';
require __DIR__ . '/partials/header.php';
?>

<main class="flex-grow w-full max-w-[1600px] mx-auto px-6 lg:px-12 py-28 lg:py-32">
    <div class="max-w-3xl mx-auto text-center mb-16 reveal-fade">
        <h1 class="text-4xl md:text-5xl font-serif font-medium text-ink tracking-tight mb-4">Secure Order</h1>
        <p class="text-muted font-light">Review your selections and proceed to secure payment.</p>
    </div>

    <!-- Stepper -->
    <div class="flex items-center justify-center gap-4 mb-16 max-w-lg mx-auto reveal-fade">
        <div class="flex items-center gap-3">
            <span class="w-9 h-9 flex items-center justify-center bg-ink text-white text-xs font-medium"><span class="material-symbols-outlined text-sm">check</span></span>
            <span class="text-[10px] uppercase tracking-[0.15em] text-ink font-medium">Cart</span>
        </div>
        <div class="w-12 h-[1px] bg-ink/30"></div>
        <div class="flex items-center gap-3">
            <span class="w-9 h-9 flex items-center justify-center bg-ink text-white text-xs font-medium"><span class="material-symbols-outlined text-sm">check</span></span>
            <span class="text-[10px] uppercase tracking-[0.15em] text-ink font-medium">Shipping</span>
        </div>
        <div class="w-12 h-[1px] bg-ink/30"></div>
        <div class="flex items-center gap-3">
            <span class="w-9 h-9 flex items-center justify-center bg-champagne text-ink text-xs font-medium"><span class="material-symbols-outlined text-sm">credit_card</span></span>
            <span class="text-[10px] uppercase tracking-[0.15em] text-champagne-dark font-medium">Payment</span>
        </div>
    </div>

    <?php if ($error): ?>
        <div class="max-w-3xl mx-auto mb-10 p-4 border border-rose/20 text-rose bg-rose/5 flex items-center gap-3 text-sm font-light">
            <span class="material-symbols-outlined">error</span>
            <p><?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Left -->
        <div class="lg:col-span-2 space-y-10">
            <!-- Items -->
            <div class="p-8 bg-surface border" style="border-color: rgba(231,229,228,0.6);">
                <h2 class="text-xl font-serif font-medium text-ink mb-8 tracking-tight flex items-center gap-3">
                    <span class="w-8 h-8 flex items-center justify-center bg-champagne/5 text-champagne-dark">
                        <span class="material-symbols-outlined text-lg">inventory_2</span>
                    </span>
                    Selections
                </h2>
                <div class="divide-y" style="border-color: rgba(231,229,228,0.6);">
                    <?php foreach ($validCart as $id => $item): ?>
                    <div class="py-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 group">
                        <div class="flex items-center gap-5">
                            <div class="h-24 w-24 overflow-hidden bg-surface shrink-0">
                                <img src="<?= htmlspecialchars((string)($item['image_url'] ?? 'https://placehold.co/150')) ?>" alt="<?= htmlspecialchars((string)$item['name']) ?>" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            </div>
                            <div>
                                <h4 class="text-lg font-serif text-ink group-hover:text-champagne transition-colors"><?= htmlspecialchars((string)$item['name']) ?></h4>
                                <p class="text-[10px] text-muted-light uppercase tracking-widest mt-1 font-medium"><?= (int)$item['months'] ?> Month Rental</p>
                            </div>
                        </div>
                        <span class="text-2xl font-serif text-ink sm:text-right">$<?= number_format((float)$item['monthly_price'], 2) ?><span class="text-sm text-muted-light font-sans font-light tracking-normal block">/month</span></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- KYC -->
            <div class="p-8 bg-surface border" style="border-color: rgba(231,229,228,0.6);">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-xl font-serif font-medium text-ink tracking-tight flex items-center gap-3">
                        <span class="w-8 h-8 flex items-center justify-center bg-champagne/5 text-champagne-dark">
                            <span class="material-symbols-outlined text-lg">verified_user</span>
                        </span>
                        Verification
                    </h2>
                    <a href="<?= baseUrl('/cart') ?>" class="text-[11px] font-medium tracking-[0.2em] uppercase text-muted hover:text-ink transition-colors">Edit</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-6 bg-canvas" style="border: 1px solid rgba(231,229,228,0.4);">
                    <div>
                        <span class="flex items-center gap-2 text-[10px] text-muted-light uppercase tracking-widest mb-1 font-medium">
                            <span class="material-symbols-outlined text-sm">badge</span> ID
                        </span>
                        <p class="text-lg text-ink"><?= htmlspecialchars((string)($kyc['id_number'] ?? 'Not provided')) ?></p>
                    </div>
                    <div>
                        <span class="flex items-center gap-2 text-[10px] text-muted-light uppercase tracking-widest mb-1 font-medium">
                            <span class="material-symbols-outlined text-sm">local_shipping</span> Delivery
                        </span>
                        <p class="text-lg text-ink"><?= htmlspecialchars((string)($kyc['delivery_date'] ?? 'Asap')) ?></p>
                        <p class="text-sm text-muted font-light"><?= htmlspecialchars((string)($kyc['delivery_time'] ?? '09:00 AM - 12:00 PM')) ?></p>
                    </div>
                    <div class="sm:col-span-2 pt-6" style="border-top: 1px solid rgba(231,229,228,0.6);">
                        <span class="flex items-center gap-2 text-[10px] text-muted-light uppercase tracking-widest mb-1 font-medium">
                            <span class="material-symbols-outlined text-sm">home_work</span> Address
                        </span>
                        <p class="text-base text-ink"><?= htmlspecialchars((string)($kyc['address'] ?? 'Not provided')) ?></p>
                    </div>
                    <?php if (!empty($kyc['work_verify'])): ?>
                    <div class="sm:col-span-2 pt-6" style="border-top: 1px solid rgba(231,229,228,0.6);">
                        <span class="flex items-center gap-2 text-[10px] text-muted-light uppercase tracking-widest mb-1 font-medium">
                            <span class="material-symbols-outlined text-sm">work</span> Employment
                        </span>
                        <p class="text-base text-ink"><?= htmlspecialchars((string)$kyc['work_verify']) ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right: Summary -->
        <div>
            <div class="bg-ink text-white p-8 lg:sticky lg:top-28">
                <h2 class="text-xl font-serif font-medium mb-8 tracking-tight">Summary</h2>

                <div class="space-y-4 mb-6">
                    <div class="flex justify-between items-center p-3 bg-white/5">
                        <span class="text-sm text-white/50 font-light">Base Rate</span>
                        <span class="text-white">$<?= number_format($subtotal, 2) ?></span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-white/5">
                        <span class="text-sm text-white/50 font-light">Deposit</span>
                        <span class="text-champagne">+$<?= number_format($deposits, 2) ?></span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-white/5">
                        <span class="text-sm text-white/50 font-light">Logistics</span>
                        <span class="text-white">+$<?= number_format($delivery, 2) ?></span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-white/5">
                        <span class="text-sm text-white/50 font-light">Tax (8%)</span>
                        <span class="text-white">+$<?= number_format($tax, 2) ?></span>
                    </div>
                    <div class="pt-6 mt-6" style="border-top: 1px solid rgba(255,255,255,0.1);">
                        <div class="flex justify-between items-baseline mb-2">
                            <span class="text-[10px] uppercase tracking-widest text-white/40">Total Today</span>
                            <span class="text-3xl font-serif text-champagne">$<?= number_format($total, 2) ?></span>
                        </div>
                        <p class="text-xs text-white/30 italic text-right font-light">1st month + deposit</p>
                    </div>
                </div>

                <form action="<?= baseUrl('/checkout') ?>" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
                    <button type="submit" name="pay" value="1" class="w-full py-5 bg-champagne text-ink text-[11px] font-medium tracking-[0.2em] uppercase hover:bg-white transition-all duration-500 flex items-center justify-center gap-3 outline-none">
                        <span class="material-symbols-outlined">payments</span>
                        Pay with Stripe
                    </button>
                </form>

                <div class="mt-6 flex items-center justify-center gap-2 text-white/30 py-3 border border-white/10">
                    <span class="material-symbols-outlined text-sm">lock</span>
                    <span class="text-xs font-light">256-bit encrypted</span>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const check = setInterval(() => {
        if (window.gsap) {
            clearInterval(check);
            gsap.context(() => {
                gsap.utils.toArray('.reveal-fade, .bg-surface.border, .bg-ink').forEach((el, i) => {
                    gsap.from(el, { opacity: 0, y: 20, duration: 0.8, delay: i * 0.1, ease: 'power3.out' });
                });
            });
        }
    }, 100);
});
</script>

<?php require __DIR__ . '/partials/footer.php'; ?>
