<?php
declare(strict_types=1);

use RentEase\Services\ProductService;
use RentEase\Services\RentalService;
use RentEase\Services\AuthService;
use RentEase\Support\Csrf;

require __DIR__ . '/../bootstrap.php';

$authService = new AuthService($config);
$productService = new ProductService($config);
$rentalService = new RentalService($config);

$csrfToken = Csrf::token();
$error = null;
$success = null;

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$currentUser = null;
try {
    $token = $_COOKIE[$config['cookie_name']] ?? '';
    if ($token) {
        $currentUser = $authService->validateToken($token);
    }
} catch (Throwable $ignored) {}

$cart = $_SESSION['cart'] ?? [];

$subtotal = 0.0;
$deposits = 0.0;
$delivery   = 29.0;
foreach ($cart as $id => $item) {
    // Determine monthly price, checking if it was saved as monthly_price
    $monthlyPrice = (float)($item['monthly_price'] ?? ($item['rental_price'] ?? 0));
    $subtotal += $monthlyPrice;
    $deposits += $monthlyPrice * 0.5;
}
$tax    = $subtotal * 0.08;
$total  = $subtotal + $deposits + $delivery + $tax;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'add') {
        $productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $months = filter_input(INPUT_POST, 'months', FILTER_VALIDATE_INT) ?: 3;
        
        if ($productId) {
            $product = $productService->findById($productId);
            if ($product) {
                if (session_status() !== PHP_SESSION_ACTIVE) {
                    session_start();
                }
                
                $_SESSION['cart'][$productId] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'monthly_price' => (float)$product['monthly_price'],
                    'months' => $months,
                    'image_url' => $product['image_url'] ?? ''
                ];
                $success = "Added " . $product['name'] . " to your lease basket.";
            } else {
                $error = "Product not found.";
            }
        } else {
            $error = "Invalid product selection.";
        }
        
        // Refresh cart variable after addition
        $cart = $_SESSION['cart'] ?? [];
    }

    if ($action === 'clear') {
        $_SESSION['cart'] = [];
        header('Location: ' . baseUrl('/cart'));
        exit;
    }

    if ($action === 'checkout') {
        if (!Csrf::validate($_POST['csrf_token'] ?? null)) {
            $error = 'Session expired. Please refresh and try again.';
        } elseif (!$currentUser) {
            $error = 'Account required to finalize booking. Please login/sign up first.';
        } elseif (empty($cart)) {
            $error = 'Shopping cart is empty.';
        } else {
            $idNumber = filter_input(INPUT_POST, 'id_number', FILTER_DEFAULT);
            $deliveryDate = filter_input(INPUT_POST, 'delivery_date', FILTER_DEFAULT);
            $deliveryTime = filter_input(INPUT_POST, 'delivery_time', FILTER_DEFAULT);
            $address = filter_input(INPUT_POST, 'address', FILTER_DEFAULT);
            $mobileNumber = filter_input(INPUT_POST, 'mobile_number', FILTER_DEFAULT);
            
            if (empty($idNumber) || empty($deliveryDate) || empty($deliveryTime) || empty($address) || empty($mobileNumber)) {
                $error = 'All KYC details, including shipping address, time slot, and valid mobile number, are required to proceed.';
            } else {
                $_SESSION['checkout_kyc'] = [
                    'id_number' => $idNumber,
                    'delivery_date' => $deliveryDate,
                    'delivery_time' => $deliveryTime,
                    'address' => $address,
                    'mobile_number' => $mobileNumber,
                    'work_verify' => filter_input(INPUT_POST, 'work_verify', FILTER_DEFAULT)
                ];
                header('Location: ' . baseUrl('/checkout'));
                exit;
            }
        }
    }
}

$cartCount = count($cart);



// Fetch DB details for the items
$dbItems = [];
foreach ($cart as $id => $item) {
    $dbProd = $productService->findById((int)$id);
    if (!$dbProd) {
        unset($_SESSION['cart'][$id]);
        continue;
    }
    if ($dbProd) {
        $dbItems[] = $dbProd;
    }
}
?>
<?php 
$pageTitle = 'Your Cart - RentEase';
$pageDescription = 'Review and checkout your premium furniture and appliance rentals.';
require __DIR__ . '/partials/header.php'; 
?>

<main class="flex-grow w-full max-w-container-max mx-auto px-4 md:px-8 py-lg md:py-xl">
    <!-- Minimal Header & Stepper -->
    <div class="mb-12 text-center max-w-3xl mx-auto">
        <a class="inline-flex items-center text-teal-600 hover:text-teal-700 transition-colors mb-6 font-light text-sm bg-teal-50 px-4 py-2 rounded-full" href="<?= baseUrl('/browse') ?>">
            <span class="material-symbols-outlined text-sm mr-2 font-light">arrow_back</span>
            Continue Shopping
        </a>
        <h1 class="text-4xl md:text-5xl font-normal text-slate-900 tracking-tighter mb-4">Your Basket</h1>
        <p class="text-slate-500 font-normal">Review your items and complete your shipping details.</p>
    </div>

    <?php if ($error): ?>
        <div class="bento-item mb-8 p-4 rounded-2xl bg-red-50 border border-red-100 flex items-center gap-3 text-red-700 text-sm font-light shadow-sm">
            <span class="material-symbols-outlined">error</span>
            <p><?= e($error) ?></p>
        </div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="bento-item mb-8 p-4 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center gap-3 text-emerald-700 text-sm font-light shadow-sm">
            <span class="material-symbols-outlined">check_circle</span>
            <p><?= e($success) ?></p>
        </div>
    <?php endif; ?>

        <?php if (empty($cart)): ?>
            <div class="text-center py-24 rounded-2xl border border-outline-variant/30 bg-surface-container-lowest mt-4">
                <p class="text-on-surface-variant font-normal text-lg mb-4">Your lease basket is currently empty.</p>
                <a href="<?= baseUrl('/browse') ?>" class="inline-flex items-center justify-center bg-primary text-on-primary font-button px-6 py-3 rounded-lg shadow-sm hover:scale-[1.02] active:scale-95 transition-all text-sm font-light">
                    Explore Collections
                </a>
            </div>
        <?php else: ?>

        <!-- Progress Stepper -->
        <div class="flex items-center w-full max-w-2xl mx-auto mb-12">
            <div class="flex flex-col items-center relative z-10">
                <div class="h-10 w-10 rounded-full bg-teal-500 text-white flex items-center justify-center font-normal shadow-lg shadow-teal-500/30 border-4 border-white">
                    <span class="material-symbols-outlined text-[20px]">shopping_basket</span>
                </div>
                <div class="absolute top-12 whitespace-nowrap text-[10px] font-normal tracking-widest text-teal-600 uppercase">CART</div>
            </div>
            <div class="flex-auto border-t-2 border-dashed border-teal-500/30"></div>
            <div class="flex flex-col items-center relative z-10">
                <div class="h-10 w-10 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center font-normal shadow-sm border-4 border-white">
                    <span class="material-symbols-outlined text-[20px]">local_shipping</span>
                </div>
                <div class="absolute top-12 whitespace-nowrap text-[10px] font-normal tracking-widest text-slate-400 uppercase">SHIPPING</div>
            </div>
            <div class="flex-auto border-t-2 border-dashed border-slate-200"></div>
            <div class="flex flex-col items-center relative z-10">
                <div class="h-10 w-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center font-normal shadow-sm border-4 border-white">
                    <span class="material-symbols-outlined text-[20px]">credit_card</span>
                </div>
                <div class="absolute top-12 whitespace-nowrap text-[10px] font-normal tracking-widest text-slate-400 uppercase">PAYMENT</div>
            </div>
        </div>
    </div>

    <!-- Main Checkout Area -->
    <form action="<?= baseUrl('/cart') ?>" method="POST" class="flex flex-col lg:flex-row gap-lg">
        <input type="hidden" name="action" value="checkout">
        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
        
        <!-- Left Column: Forms -->
        <div class="w-full lg:w-2/3 flex flex-col gap-md">
            
            <!-- Delivery Options -->
            <div class="bento-item bg-white/70 backdrop-blur-xl rounded-[2rem] p-8 border border-white/40 shadow-xl shadow-slate-200/50">
                <h2 class="text-2xl font-normal text-slate-900 mb-6 flex items-center gap-3 font-sans">
                    <div class="p-2 rounded-xl bg-teal-50 text-teal-600">
                        <span class="material-symbols-outlined">local_shipping</span>
                    </div>
                    Delivery Options
                </h2>
                <div class="space-y-5">
                    <div>
                        <label class="block text-[10px] font-normal uppercase tracking-widest text-slate-500 mb-2">Preferred Delivery Date</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-teal-500 transition-colors">calendar_month</span>
                            <input type="date" name="delivery_date" required class="w-full bg-slate-50 border border-slate-200 rounded-xl py-4 pl-12 pr-4 text-slate-900 focus:bg-white focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all font-normal" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-normal uppercase tracking-widest text-slate-500 mb-2">Preferred Time Slot</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <label class="border-2 border-slate-100 rounded-xl p-4 cursor-pointer hover:border-teal-200 hover:bg-teal-50/50 transition-all duration-200 has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/50 group relative overflow-hidden">
                                <input type="radio" name="delivery_time" value="09:00 - 12:00" class="hidden" required />
                                <div class="flex flex-col items-center gap-2 relative z-10 text-slate-500 group-has-[:checked]:text-teal-700">
                                    <span class="material-symbols-outlined text-2xl">light_mode</span>
                                    <span class="font-light text-sm whitespace-nowrap">Morning</span>
                                    <span class="text-[10px] font-normal tracking-widest opacity-60">9AM - 12PM</span>
                                </div>
                                <div class="absolute inset-0 bg-teal-500/5 opacity-0 group-has-[:checked]:opacity-100 transition-opacity"></div>
                            </label>
                            <label class="border-2 border-slate-100 rounded-xl p-4 cursor-pointer hover:border-teal-200 hover:bg-teal-50/50 transition-all duration-200 has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/50 group relative overflow-hidden">
                                <input type="radio" name="delivery_time" value="12:00 - 15:00" class="hidden" required />
                                <div class="flex flex-col items-center gap-2 relative z-10 text-slate-500 group-has-[:checked]:text-teal-700">
                                    <span class="material-symbols-outlined text-2xl">wb_sunny</span>
                                    <span class="font-light text-sm whitespace-nowrap">Afternoon</span>
                                    <span class="text-[10px] font-normal tracking-widest opacity-60">12PM - 3PM</span>
                                </div>
                                <div class="absolute inset-0 bg-teal-500/5 opacity-0 group-has-[:checked]:opacity-100 transition-opacity"></div>
                            </label>
                            <label class="border-2 border-slate-100 rounded-xl p-4 cursor-pointer hover:border-teal-200 hover:bg-teal-50/50 transition-all duration-200 has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/50 group relative overflow-hidden">
                                <input type="radio" name="delivery_time" value="15:00 - 18:00" class="hidden" required />
                                <div class="flex flex-col items-center gap-2 relative z-10 text-slate-500 group-has-[:checked]:text-teal-700">
                                    <span class="material-symbols-outlined text-2xl">routine</span>
                                    <span class="font-light text-sm whitespace-nowrap">Evening</span>
                                    <span class="text-[10px] font-normal tracking-widest opacity-60">3PM - 6PM</span>
                                </div>
                                <div class="absolute inset-0 bg-teal-500/5 opacity-0 group-has-[:checked]:opacity-100 transition-opacity"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="bento-item bg-white/70 backdrop-blur-xl rounded-[2rem] p-8 border border-white/40 shadow-xl shadow-slate-200/50">
                <h2 class="text-2xl font-normal text-slate-900 mb-6 flex items-center gap-3 font-sans">
                    <div class="p-2 rounded-xl bg-blue-50 text-blue-600">
                        <span class="material-symbols-outlined">home_pin</span>
                    </div>
                    Shipping Address
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-normal uppercase tracking-widest text-slate-500 mb-2">Street Address</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-4 top-4 text-slate-400 group-focus-within:text-blue-500 transition-colors">home_work</span>
                            <textarea rows="3" name="address" placeholder="Apt/Suite, Building Name, Street..." required class="w-full bg-slate-50 border border-slate-200 rounded-xl py-4 pl-12 pr-4 text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all font-normal resize-none"></textarea>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-normal uppercase tracking-widest text-slate-500 mb-2">Mobile Number</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors">call</span>
                            <input type="tel" name="mobile_number" placeholder="e.g. +1 555-0123" required class="w-full bg-slate-50 border border-slate-200 rounded-xl py-4 pl-12 pr-4 text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all font-normal" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- KYC Details -->
            <div class="bento-item bg-white/70 backdrop-blur-xl rounded-[2rem] p-8 border border-white/40 shadow-xl shadow-slate-200/50">
                <h2 class="text-2xl font-normal text-slate-900 mb-6 flex items-center gap-3 font-sans">
                    <div class="p-2 rounded-xl bg-indigo-50 text-indigo-600">
                        <span class="material-symbols-outlined">verified_user</span>
                    </div>
                    KYC Verification
                </h2>
                <p class="text-sm font-light text-slate-500 mb-6 bg-indigo-50/50 p-4 rounded-xl border border-indigo-100 flex items-start gap-3">
                    <span class="material-symbols-outlined text-indigo-500 shrink-0">info</span>
                    <span>Mandatory for background check before delivery approval. Your data is securely encrypted.</span>
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-normal uppercase tracking-widest text-slate-500 mb-2">Valid ID Number (Aadhaar/SSN/Passport)</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-500 transition-colors">badge</span>
                            <input type="text" name="id_number" placeholder="Enter valid ID number" required class="w-full bg-slate-50 border border-slate-200 rounded-xl py-4 pl-12 pr-4 text-slate-900 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-normal" />
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-normal uppercase tracking-widest text-slate-500 mb-2">Employer Information <span class="text-slate-400 font-normal normal-case tracking-normal ml-1">(Optional)</span></label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-500 transition-colors">work</span>
                            <input type="text" name="work_verify" placeholder="Employer name / Work verified email" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-4 pl-12 pr-4 text-slate-900 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-normal" />
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Order Summary -->
        <div class="w-full lg:w-1/3 bento-item">
            <div class="bg-slate-900 text-white rounded-[2rem] p-8 shadow-2xl shadow-slate-900/20 sticky top-32">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-normal font-sans">Order Summary</h2>
                </div>
                
                <div class="space-y-4 mb-6 max-h-80 overflow-y-auto pr-2">
                    <?php foreach ($dbItems as $dbItem): ?>
                        <div class="flex gap-4 group bg-white/5 p-3 rounded-2xl border border-white/10 hover:bg-white/10 transition-colors">
                            <div class="w-20 h-20 bg-white/10 rounded-xl overflow-hidden shrink-0 shadow-inner">
                                <img src="<?= e($dbItem['image_url'] ?? 'https://placehold.co/150') ?>" alt="<?= e($dbItem['name']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                            </div>
                            <div class="flex-1 py-1">
                                <h3 class="text-white font-normal line-clamp-1 group-hover:text-teal-400 transition-colors"><?= e($dbItem['name']) ?></h3>
                                <p class="text-[10px] text-slate-400 font-normal uppercase tracking-widest mt-1">Monthly Rental</p>
                                <p class="text-lg font-normal text-teal-400 mt-0.5">$<?= number_format((float)($dbItem['monthly_price'] ?? 0), 2) ?>/mo</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="border-t border-white/10 pt-6 mb-6 space-y-4">
                    <div class="flex justify-between">
                        <span class="text-slate-400 font-normal">Subtotal (Monthly)</span>
                        <span class="text-white font-normal">$<?= number_format($subtotal, 2) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400 font-normal">Refundable Deposit</span>
                        <span class="text-teal-400 font-normal">+ $<?= number_format($deposits, 2) ?></span>
                    </div>
                    <div class="flex justify-between text-sm font-light">
                        <span class="text-slate-500 font-normal italic">Estimated Tax & Fees</span>
                        <span class="text-slate-400">+ $<?= number_format($tax + $delivery, 2) ?></span>
                    </div>
                </div>

                <div class="border-t border-white/10 pt-6 mb-8">
                    <div class="flex justify-between items-baseline">
                        <div>
                            <span class="block text-slate-400 font-normal uppercase tracking-widest text-[10px] mb-1">Total Due Today</span>
                            <span class="block text-slate-500 text-xs italic font-light">Includes 1st month + deposit</span>
                        </div>
                        <span class="text-4xl font-normal text-teal-400 font-sans">$<?= number_format($total, 2) ?></span>
                    </div>
                </div>

                <button type="submit" class="group flex items-center justify-center gap-2 bg-teal-500 text-white font-normal px-6 py-5 rounded-2xl shadow-xl shadow-teal-500/30 hover:bg-teal-400 active:scale-[0.98] transition-all w-full text-lg mb-3">
                    <span class="material-symbols-outlined transition-transform group-hover:scale-110">lock</span>
                    Secure Checkout
                </button>
            </div>
        </div>
    </form>
    
    <!-- Clear Cart separate form -->
    <div class="flex justify-end mt-6 w-full lg:w-2/3">
        <form action="<?= baseUrl('/cart') ?>" method="POST">
            <input type="hidden" name="action" value="clear">
            <button type="submit" class="text-sm text-red-500 hover:text-red-700 transition font-light flex items-center gap-1 bg-red-50 hover:bg-red-100 px-4 py-2 rounded-xl">
                <span class="material-symbols-outlined text-[16px]">delete</span> Empty Cart
            </button>
        </form>
    </div>
    
    <?php endif; ?>
</main>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    gsap.from(".bento-item", {
        opacity: 0,
        y: 40,
        duration: 1,
        stagger: 0.15,
        ease: "power4.out"
    });
});
</script>
<?php require __DIR__ . '/partials/footer.php'; ?>
