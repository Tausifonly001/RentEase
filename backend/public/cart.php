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
        header('Location: cart.php');
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
                header('Location: checkout.php');
                exit;
            }
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
<?php require __DIR__ . '/partials/header.php'; ?>

<main class="flex-grow w-full max-w-container-max mx-auto px-4 md:px-8 py-lg md:py-xl">
    <!-- Minimal Header & Stepper -->
    <div class="mb-lg">
        <a class="inline-flex items-center text-secondary hover:text-on-secondary-container transition-colors mb-sm font-button text-button" href="browse.php">
            <span class="material-symbols-outlined text-sm mr-xs">arrow_back</span>
            Back to Browse
        </a>
        <h1 class="font-h1 text-h1 text-on-surface mb-md">Lease Cart & Checkout</h1>
        
    <?php if ($error): ?>
        <div class="bento-item mb-8 p-4 rounded-2xl bg-red-50 border border-red-100 flex items-center gap-3 text-red-700 text-sm font-semibold shadow-sm">
            <span class="material-symbols-outlined">error</span>
            <p><?= e($error) ?></p>
        </div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="bento-item mb-8 p-4 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center gap-3 text-emerald-700 text-sm font-semibold shadow-sm">
            <span class="material-symbols-outlined">check_circle</span>
            <p><?= e($success) ?></p>
        </div>
    <?php endif; ?>

        <?php if (empty($cart)): ?>
            <div class="text-center py-24 rounded-2xl border border-outline-variant/30 bg-surface-container-lowest mt-4">
                <p class="text-on-surface-variant font-medium text-lg mb-4">Your lease basket is currently empty.</p>
                <a href="browse.php" class="inline-flex items-center justify-center bg-primary text-on-primary font-button px-6 py-3 rounded-lg shadow-sm hover:scale-[1.02] active:scale-95 transition-all text-sm">
                    Explore Collections
                </a>
            </div>
        <?php else: ?>

        <!-- Progress Stepper -->
        <div class="flex items-center w-full max-w-2xl">
            <div class="flex items-center relative">
                <div class="h-8 w-8 rounded-full bg-secondary text-on-secondary flex items-center justify-center font-button text-button z-10">
                    <span class="material-symbols-outlined text-[16px]">check</span>
                </div>
                <div class="absolute top-10 left-1/2 -translate-x-1/2 whitespace-nowrap font-label-caps text-label-caps text-secondary">SHIPPING</div>
            </div>
            <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-outline-variant/50"></div>
            <div class="flex items-center relative">
                <div class="h-8 w-8 rounded-full bg-surface-container-high text-on-surface-variant flex items-center justify-center font-button text-button z-10">
                    2
                </div>
                <div class="absolute top-10 left-1/2 -translate-x-1/2 whitespace-nowrap font-label-caps text-label-caps text-on-surface-variant">PAYMENT</div>
            </div>
            <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-outline-variant/50"></div>
            <div class="flex items-center relative">
                <div class="h-8 w-8 rounded-full bg-surface-container-high text-on-surface-variant flex items-center justify-center font-button text-button z-10">
                    3
                </div>
                <div class="absolute top-10 left-1/2 -translate-x-1/2 whitespace-nowrap font-label-caps text-label-caps text-on-surface-variant">CONFIRM</div>
            </div>
        </div>
    </div>

    <!-- Main Checkout Area -->
    <form action="cart.php" method="POST" class="flex flex-col lg:flex-row gap-lg">
        <input type="hidden" name="action" value="checkout">
        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
        
        <!-- Left Column: Forms -->
        <div class="w-full lg:w-2/3 flex flex-col gap-md">
            
            <!-- Delivery Options -->
            <div class="bento-item bg-white/70 backdrop-blur-xl rounded-[2rem] p-8 border border-white/40 shadow-xl shadow-slate-200/50">
                <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3 font-outfit">
                    <div class="p-2 rounded-xl bg-teal-50 text-teal-600">
                        <span class="material-symbols-outlined">local_shipping</span>
                    </div>
                    Delivery Options
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-body-sm font-medium text-on-surface-variant mb-xs">Preferred Delivery Date</label>
                        <div class="relative">
                            <input type="date" name="delivery_date" required class="w-full border-outline-variant rounded-lg p-3 text-body-md text-on-surface focus:ring-secondary focus:border-secondary" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-body-sm font-medium text-on-surface-variant mb-xs">Preferred Time Slot</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            <label class="border border-outline-variant rounded-lg p-3 cursor-pointer hover:border-secondary hover:bg-surface-container-low transition-colors duration-200 has-[:checked]:border-secondary has-[:checked]:bg-surface-container">
                                <input type="radio" name="delivery_time" value="09:00 - 12:00" class="hidden" required />
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-on-surface-variant text-sm">light_mode</span>
                                    <span class="font-body-md text-on-surface">09:00 - 12:00</span>
                                </div>
                            </label>
                            <label class="border border-outline-variant rounded-lg p-3 cursor-pointer hover:border-secondary hover:bg-surface-container-low transition-colors duration-200 has-[:checked]:border-secondary has-[:checked]:bg-surface-container">
                                <input type="radio" name="delivery_time" value="12:00 - 15:00" class="hidden" required />
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-on-surface-variant text-sm">wb_sunny</span>
                                    <span class="font-body-md text-on-surface">12:00 - 15:00</span>
                                </div>
                            </label>
                            <label class="border border-outline-variant rounded-lg p-3 cursor-pointer hover:border-secondary hover:bg-surface-container-low transition-colors duration-200 has-[:checked]:border-secondary has-[:checked]:bg-surface-container">
                                <input type="radio" name="delivery_time" value="15:00 - 18:00" class="hidden" required />
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-on-surface-variant text-sm">routine</span>
                                    <span class="font-body-md text-on-surface">15:00 - 18:00</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="bento-item bg-white/70 backdrop-blur-xl rounded-[2rem] p-8 border border-white/40 shadow-xl shadow-slate-200/50">
                <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3 font-outfit">
                    <div class="p-2 rounded-xl bg-blue-50 text-blue-600">
                        <span class="material-symbols-outlined">home_pin</span>
                    </div>
                    Shipping Address
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-body-sm font-medium text-on-surface-variant mb-xs">Street Address</label>
                        <textarea rows="2" name="address" placeholder="Apt/Suite, Building Name, Street" required class="w-full border-outline-variant rounded-lg p-3 text-body-md placeholder-on-surface-variant/50 focus:ring-secondary focus:border-secondary"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-body-sm font-medium text-on-surface-variant mb-xs">Mobile Number</label>
                        <input type="tel" name="mobile_number" placeholder="e.g. +1 555-0123" required class="w-full border-outline-variant rounded-lg p-3 text-body-md placeholder-on-surface-variant/50 focus:ring-secondary focus:border-secondary" />
                    </div>
                </div>
            </div>

            <!-- KYC Details -->
            <div class="bento-item bg-white/70 backdrop-blur-xl rounded-[2rem] p-8 border border-white/40 shadow-xl shadow-slate-200/50">
                <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3 font-outfit">
                    <div class="p-2 rounded-xl bg-indigo-50 text-indigo-600">
                        <span class="material-symbols-outlined">verified_user</span>
                    </div>
                    KYC Verification
                </h2>
                <p class="text-body-sm text-on-surface-variant mb-4">Mandatory for background check before delivery approval.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-body-sm font-medium text-on-surface-variant mb-xs">Valid ID Number (Aadhaar/SSN/Passport)</label>
                        <input type="text" name="id_number" placeholder="Enter valid ID number" required class="w-full border-outline-variant rounded-lg p-3 text-body-md text-on-surface placeholder-on-surface-variant/50 focus:ring-secondary focus:border-secondary" />
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-body-sm font-medium text-on-surface-variant mb-xs">Employer Information (Optional)</label>
                        <input type="text" name="work_verify" placeholder="Employer name / Work verified email" class="w-full border-outline-variant rounded-lg p-3 text-body-md placeholder-on-surface-variant/50 focus:ring-secondary focus:border-secondary" />
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Order Summary -->
        <div class="w-full lg:w-1/3 bento-item">
            <div class="bg-slate-900 text-white rounded-[2rem] p-8 shadow-2xl shadow-slate-900/20 sticky top-24">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold font-outfit">Order Summary</h2>
                </div>
                
                <div class="space-y-4 mb-6 max-h-80 overflow-y-auto pr-2">
                    <?php foreach ($dbItems as $dbItem): ?>
                        <div class="flex gap-4 group">
                            <div class="w-20 h-20 bg-white/10 rounded-2xl overflow-hidden shrink-0 border border-white/5 shadow-inner transition-transform group-hover:scale-105">
                                <img src="<?= e($dbItem['image_url'] ?? 'https://placehold.co/150') ?>" alt="<?= e($dbItem['name']) ?>" class="w-full h-full object-cover" />
                            </div>
                            <div class="flex-1">
                                <h3 class="text-white font-bold line-clamp-1 group-hover:text-teal-400 transition-colors"><?= e($dbItem['name']) ?></h3>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Monthly Rental</p>
                                <p class="text-lg font-black text-teal-400 mt-1">$<?= number_format((float)($dbItem['monthly_price'] ?? 0), 2) ?>/mo</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="border-t border-white/10 pt-6 mb-6 space-y-4">
                    <div class="flex justify-between">
                        <span class="text-slate-400 font-medium">Subtotal (Monthly)</span>
                        <span class="text-white font-bold">$<?= number_format($subtotal, 2) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400 font-medium">Refundable Deposit</span>
                        <span class="text-teal-400 font-bold">+ $<?= number_format($deposits, 2) ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500 font-medium italic">Estimated Tax & Fees</span>
                        <span class="text-slate-400">+ $<?= number_format($tax + $delivery, 2) ?></span>
                    </div>
                </div>

                <div class="border-t border-white/10 pt-6 mb-8">
                    <div class="flex justify-between items-baseline">
                        <div>
                            <span class="block text-slate-400 font-bold uppercase tracking-widest text-[10px] mb-1">Total Due Today</span>
                            <span class="block text-slate-500 text-xs italic">Includes 1st month + deposit</span>
                        </div>
                        <span class="text-4xl font-black text-teal-400 font-outfit">$<?= number_format($total, 2) ?></span>
                    </div>
                </div>

                <button type="submit" class="flex items-center justify-center gap-2 bg-primary text-on-primary font-button px-6 py-4 rounded-xl shadow-md shadow-primary/20 hover:bg-primary/90 active:scale-95 transition-all w-full text-lg mb-3">
                    <span class="material-symbols-outlined">lock</span>
                    Proceed to Payment
                </button>
            </div>
        </div>
    </form>
    
    <!-- Clear Cart separate form -->
    <div class="flex justify-end mt-4 w-full lg:w-2/3">
        <form action="cart.php" method="POST">
            <input type="hidden" name="action" value="clear">
            <button type="submit" class="text-sm text-error underline hover:text-red-700 transition font-medium flex items-center gap-1">
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
