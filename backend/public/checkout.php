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
    header('Location: ' . baseUrl('/login?redirect=cart'));
    exit;
}

$cart = $_SESSION['cart'] ?? [];
$kyc = $_SESSION['checkout_kyc'] ?? [];

if (empty($cart)) {
    header('Location: ' . baseUrl('/shop'));
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

$cartItemsForMetadata = [];
foreach ($validCart as $id => $item) {
    $cartItemsForMetadata[] = [
        'id' => (string)$id,
        'name' => $item['name'],
        'monthly_price' => $item['monthly_price'],
        'months' => $item['months'],
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
                                    'order_id' => $orderId,
                                    'rental_id' => $rentalId,
                                    'user_id' => $currentUser['id'],
                                    'type' => 'DELIVERY',
                                    'scheduled_date' => $kyc['delivery_date'] ?? date('Y-m-d', strtotime('+2 days')),
                                    'time_slot' => $kyc['delivery_time'] ?? '09:00 AM - 12:00 PM',
                                    'address' => $kyc['address'] ?? 'Not provided',
                                    'status' => 'SCHEDULED',
                                    'agent_notes' => 'Awaiting payment confirmation.'
                                ]);
                            }
                        } catch (\Throwable $e) {
                            // SEC-006: Collect errors instead of swallowing silently
                            $rentalErrors[] = htmlspecialchars($details['name'] ?? "Product #{$prodId}") . ': ' . $e->getMessage();
                            error_log("Checkout rental creation failed for product {$prodId}: " . $e->getMessage());
                        }
                    }

                    // If any rentals failed, show error and prevent redirect to Stripe
                    if (!empty($rentalErrors)) {
                        $error = 'Some items could not be reserved: ' . implode('; ', $rentalErrors) . '. Please try again or contact support.';
                    }
                } else {
                    $error = 'We could not create your lease order. Please try again or contact support.';
                }

                // Only proceed to payment if all rentals were created successfully
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

/**
 * Escape HTML output for security.
 *
 * @param string $value
 * @return string
 */

?>
<?php 
$pageTitle = 'Secure Checkout - RentEase';
$pageDescription = 'Complete your rental request with secure checkout.';
require __DIR__ . '/partials/header.php'; 
?>

<main class="flex-grow w-full max-w-container-max mx-auto px-4 md:px-8 py-lg md:py-xl">
    <!-- Header & Progress -->
    <div class="mb-12 text-center max-w-3xl mx-auto reveal-element">
        <h1 class="text-4xl md:text-5xl font-normal text-slate-900 tracking-tighter mb-4">Secure Order Validation</h1>
        <p class="text-slate-500 font-normal">Review your lease selections and verification details before proceeding to secure payment.</p>
    </div>

    <!-- Progress Stepper -->
    <div class="flex items-center w-full max-w-2xl mx-auto mb-12 reveal-element">
        <div class="flex flex-col items-center relative z-10">
            <div class="h-10 w-10 rounded-full bg-teal-500 text-white flex items-center justify-center font-normal shadow-lg shadow-teal-500/30 border-4 border-white">
                <span class="material-symbols-outlined text-[16px]">check</span>
            </div>
            <div class="absolute top-12 whitespace-nowrap text-[10px] font-normal tracking-widest text-teal-600 uppercase">CART</div>
        </div>
        <div class="flex-auto border-t-2 border-teal-500"></div>
        <div class="flex flex-col items-center relative z-10">
            <div class="h-10 w-10 rounded-full bg-teal-500 text-white flex items-center justify-center font-normal shadow-lg shadow-teal-500/30 border-4 border-white">
                <span class="material-symbols-outlined text-[16px]">check</span>
            </div>
            <div class="absolute top-12 whitespace-nowrap text-[10px] font-normal tracking-widest text-teal-600 uppercase">SHIPPING</div>
        </div>
        <div class="flex-auto border-t-2 border-dashed border-teal-500/30"></div>
        <div class="flex flex-col items-center relative z-10">
            <div class="h-10 w-10 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center font-normal shadow-sm border-4 border-white">
                <span class="material-symbols-outlined text-[20px]">credit_card</span>
            </div>
            <div class="absolute top-12 whitespace-nowrap text-[10px] font-normal tracking-widest text-slate-400 uppercase">PAYMENT</div>
        </div>
    </div>

    <?php if ($error): ?>
        <div class="bento-item mb-8 p-4 rounded-2xl bg-red-50 border border-red-100 flex items-center gap-3 text-red-700 text-sm font-light shadow-sm">
            <span class="material-symbols-outlined">error</span>
            <p><?= e($error) ?></p>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-lg">
        
        <!-- Left: Reservation Details -->
        <div class="lg:col-span-2 space-y-md">
            
            <!-- Items Section -->
            <div class="bento-item bg-white/70 backdrop-blur-xl rounded-[2rem] p-8 border border-white/40 shadow-xl shadow-slate-200/50">
                <h2 class="text-2xl font-normal text-slate-900 mb-6 flex items-center gap-3 font-sans">
                    <div class="p-2 rounded-xl bg-teal-50 text-teal-600">
                        <span class="material-symbols-outlined">inventory_2</span>
                    </div>
                    Validated Selections
                </h2>
                <div class="divide-y divide-slate-100">
                    <?php foreach ($validCart as $id => $item): ?>
                        <div class="py-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 group">
                            <div class="flex items-center gap-5">
                                <div class="h-24 w-24 rounded-2xl overflow-hidden bg-slate-50 border border-slate-100 shrink-0">
                                    <img src="<?= e((string)($item['image_url'] ?? 'https://placehold.co/150')) ?>" alt="<?= e((string)$item['name']) ?>" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                                </div>
                                <div>
                                    <h4 class="text-lg font-normal text-slate-900 group-hover:text-teal-600 transition-colors"><?= e((string)$item['name']) ?></h4>
                                    <p class="text-[10px] font-normal text-slate-400 uppercase tracking-widest mt-1"><?= (int)$item['months'] ?> Month Rental Duration</p>
                                </div>
                            </div>
                            <span class="text-2xl font-normal text-slate-900 sm:text-right">$<?= number_format((float)$item['monthly_price'], 2) ?><span class="text-sm text-slate-400 font-light tracking-normal block">/month</span></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- KYC Section -->
            <div class="bento-item bg-white/70 backdrop-blur-xl rounded-[2rem] p-8 border border-white/40 shadow-xl shadow-slate-200/50">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-normal text-slate-900 flex items-center gap-3 font-sans">
                        <div class="p-2 rounded-xl bg-blue-50 text-blue-600">
                            <span class="material-symbols-outlined">verified_user</span>
                        </div>
                        Verification Summary
                    </h2>
                    <a href="<?= baseUrl('/cart') ?>" class="text-[10px] font-normal uppercase tracking-widest text-teal-600 hover:text-teal-700 bg-teal-50 px-3 py-1.5 rounded-lg transition-colors">Edit Details</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mt-4 bg-slate-50 p-6 rounded-2xl border border-slate-100">
                    <div>
                        <span class="flex items-center gap-2 text-[10px] font-normal text-slate-400 uppercase tracking-widest mb-1">
                            <span class="material-symbols-outlined text-[14px]">badge</span>
                            Identity Reference
                        </span>
                        <p class="text-lg font-normal text-slate-900"><?= e((string)($kyc['id_number'] ?? 'Not provided')) ?></p>
                    </div>
                    <div>
                        <span class="flex items-center gap-2 text-[10px] font-normal text-slate-400 uppercase tracking-widest mb-1">
                            <span class="material-symbols-outlined text-[14px]">local_shipping</span>
                            Delivery Arrival
                        </span>
                        <p class="text-lg font-normal text-slate-900"><?= e((string)($kyc['delivery_date'] ?? 'Asap')) ?></p>
                        <p class="text-sm font-light text-slate-500"><?= e((string)($kyc['delivery_time'] ?? '09:00 AM - 12:00 PM')) ?></p>
                    </div>
                    <div class="sm:col-span-2 pt-6 border-t border-slate-200">
                        <span class="flex items-center gap-2 text-[10px] font-normal text-slate-400 uppercase tracking-widest mb-1">
                            <span class="material-symbols-outlined text-[14px]">home_work</span>
                            Shipping Address
                        </span>
                        <p class="text-base font-normal text-slate-900"><?= e((string)($kyc['address'] ?? 'Not provided')) ?></p>
                    </div>
                    <?php if (!empty($kyc['work_verify'])): ?>
                        <div class="sm:col-span-2 pt-6 border-t border-slate-200">
                            <span class="flex items-center gap-2 text-[10px] font-normal text-slate-400 uppercase tracking-widest mb-1">
                                <span class="material-symbols-outlined text-[14px]">work</span>
                                Employment Proof
                            </span>
                            <p class="text-base font-normal text-slate-900"><?= e((string)$kyc['work_verify']) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right: Bill Summary -->
        <div class="reveal-element">
            <div class="bento-item bg-slate-900 text-white rounded-[2rem] p-8 shadow-2xl shadow-slate-900/20 sticky top-32">
                <h2 class="text-2xl font-normal mb-8 font-sans">Bill Outlay</h2>

                <div class="space-y-4 mb-6">
                    <div class="flex justify-between items-center bg-white/5 p-3 rounded-xl">
                        <span class="text-sm font-light text-slate-300">Base Monthly Rate</span>
                        <span class="text-base font-normal text-white">$<?= number_format($subtotal, 2) ?></span>
                    </div>
                    <div class="flex justify-between items-center bg-white/5 p-3 rounded-xl">
                        <span class="text-sm font-light text-slate-300">Refundable Deposit</span>
                        <span class="text-base font-normal text-teal-400">+$<?= number_format($deposits, 2) ?></span>
                    </div>
                    <div class="flex justify-between items-center bg-white/5 p-3 rounded-xl">
                        <span class="text-sm font-light text-slate-300">Tech & Logistics Fee</span>
                        <span class="text-base font-normal text-white">+$<?= number_format($delivery, 2) ?></span>
                    </div>
                    <div class="flex justify-between items-center bg-white/5 p-3 rounded-xl">
                        <span class="text-sm font-light text-slate-300">Service Taxes (8%)</span>
                        <span class="text-base font-normal text-white">+$<?= number_format($tax, 2) ?></span>
                    </div>
                    <div class="pt-6 border-t border-white/10 mt-6">
                        <div class="flex justify-between items-baseline mb-2">
                            <span class="text-[10px] font-normal uppercase tracking-widest text-slate-400">Total Due Today</span>
                            <span class="text-4xl font-normal text-teal-400 font-sans">$<?= number_format($total, 2) ?></span>
                        </div>
                        <p class="text-xs text-slate-500 italic text-right mb-6 font-light">Includes 1st month + deposit</p>
                    </div>
                </div>

                <form action="<?= baseUrl('/checkout') ?>" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= e(Csrf::token()) ?>" />
                    <button type="submit" name="pay" value="1" class="group flex items-center justify-center gap-2 bg-teal-500 text-white font-normal px-6 py-5 rounded-2xl shadow-xl shadow-teal-500/30 hover:bg-teal-400 active:scale-[0.98] transition-all w-full text-lg">
                        <span class="material-symbols-outlined transition-transform group-hover:scale-110">payments</span>
                        Pay with Stripe
                    </button>
                </form>
                
                <div class="mt-6 flex items-center justify-center gap-2 text-slate-400 bg-white/5 py-3 rounded-xl border border-white/5">
                    <span class="material-symbols-outlined text-[16px] text-teal-500">lock</span>
                    <span class="text-xs font-light">Secure 256-bit encrypted transaction</span>
                </div>
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

