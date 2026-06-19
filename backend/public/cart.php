<?php
declare(strict_types=1);

use RentEase\Services\ProductService;
use RentEase\Services\RentalService;
use RentEase\Services\AuthService;
use RentEase\Support\Csrf;

require_once __DIR__ . '/../bootstrap.php';

$authService = new AuthService($config);
$productService = new ProductService($config);
$rentalService = new RentalService($config);

$csrfToken = Csrf::token();
$error = null;
$success = null;

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

$currentUser = null;
try {
 $token = $_COOKIE[$config['cookie_name']] ?? '';
 if ($token) $currentUser = $authService->validateToken($token);
} catch (Throwable $ignored) {}

$cart = $_SESSION['cart'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
 $action = $_POST['action'];
 if ($action === 'add') {
 $productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
 $months = filter_input(INPUT_POST, 'months', FILTER_VALIDATE_INT) ?: 3;
 if ($productId) {
 $product = $productService->findById($productId);
 if ($product) {
 if (session_status() !== PHP_SESSION_ACTIVE) session_start();
 $_SESSION['cart'][$productId] = [
 'id' => $product['id'], 'name' => $product['name'],
 'monthly_price' => (float)$product['monthly_price'], 'months' => $months,
 'image_url' => $product['image_url'] ?? ''
 ];
 $success = "Added " . $product['name'] . " to your basket.";
 $cart = $_SESSION['cart'] ?? [];
 } else { $error = "Product not found."; }
 } else { $error = "Invalid product."; }
 }
 if ($action === 'clear') { $_SESSION['cart'] = []; header('Location: ' . baseUrl('/cart')); exit; }
 if ($action === 'checkout') {
 if (!Csrf::validate($_POST['csrf_token'] ?? null)) {
 $error = 'Session expired. Please refresh.';
 } elseif (!$currentUser) {
 header('Location: ' . baseUrl('/login?redirect=cart'));
 exit;
 } elseif (empty($cart)) {
 $error = 'Cart is empty.';
 } else {
 $idNumber = filter_input(INPUT_POST, 'id_number', FILTER_DEFAULT);
 $deliveryDate = filter_input(INPUT_POST, 'delivery_date', FILTER_DEFAULT);
 $deliveryTime = filter_input(INPUT_POST, 'delivery_time', FILTER_DEFAULT);
 $address = filter_input(INPUT_POST, 'address', FILTER_DEFAULT);
 $mobileNumber = filter_input(INPUT_POST, 'mobile_number', FILTER_DEFAULT);
 if (empty($idNumber) || empty($deliveryDate) || empty($deliveryTime) || empty($address) || empty($mobileNumber)) {
 $error = 'All fields are required.';
 } else {
 $_SESSION['checkout_kyc'] = [
 'id_number' => $idNumber, 'delivery_date' => $deliveryDate,
 'delivery_time' => $deliveryTime, 'address' => $address,
 'mobile_number' => $mobileNumber,
 'work_verify' => filter_input(INPUT_POST, 'work_verify', FILTER_DEFAULT)
 ];
 header('Location: ' . baseUrl('/checkout'));
 exit;
 }
 }
 }
}

$subtotal = 0.0;
$deposits = 0.0;
$delivery = 29.0;
foreach ($cart as $id => $item) {
 $monthlyPrice = (float)($item['monthly_price'] ?? ($item['rental_price'] ?? 0));
 $subtotal += $monthlyPrice;
 $deposits += $monthlyPrice * 0.5;
}
$tax = $subtotal * 0.08;
$total = $subtotal + $deposits + $delivery + $tax;

$cartCount = count($cart);
$dbItems = [];
foreach ($cart as $id => $item) {
 $dbProd = $productService->findById((int)$id);
 if (!$dbProd) { unset($_SESSION['cart'][$id]); continue; }
 if ($dbProd) $dbItems[] = $dbProd;
}

$pageTitle = 'Your Cart - RentEase';
$pageDescription = 'Review and checkout your premium furniture and appliance rentals.';
require __DIR__ . '/partials/header.php';
?>

<main class="flex-grow w-full max-w-[1600px] mx-auto px-6 lg:px-12 py-28 lg:py-32">
 <div class="max-w-3xl mx-auto text-center mb-16">
 <a href="<?= baseUrl('/shop') ?>" class="inline-flex items-center gap-2 text-[11px] font-medium tracking-[0.2em] uppercase text-muted hover:text-ink transition-colors mb-8 outline-none">
 <span class="material-symbols-outlined text-sm">arrow_back</span>
 Continue Shopping
 </a>
 <h1 class="text-4xl md:text-5xl font-serif font-medium text-ink tracking-tight mb-4">Your Basket</h1>
 <p class="text-muted font-light">Review your items and complete your details.</p>
 </div>

 <?php if ($error): ?>
 <div class="max-w-3xl mx-auto mb-10 p-4 border border-rose/20 text-rose bg-rose/5 flex items-center gap-3 text-sm font-light">
 <span class="material-symbols-outlined">error</span>
 <p><?= htmlspecialchars($error) ?></p>
 </div>
 <?php endif; ?>
 <?php if ($success): ?>
 <div class="max-w-3xl mx-auto mb-10 p-4 border border-champagne/20 text-champagne-dark bg-champagne/5 flex items-center gap-3 text-sm font-light">
 <span class="material-symbols-outlined">check_circle</span>
 <p><?= htmlspecialchars($success) ?></p>
 </div>
 <?php endif; ?>

 <?php if (empty($cart)): ?>
 <div class="text-center py-24 border border-dashed max-w-lg mx-auto" style="border-color: rgba(231,229,228,0.6);">
 <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-champagne/5 text-muted-light">
 <span class="material-symbols-outlined text-3xl">shopping_bag</span>
 </div>
 <p class="text-muted font-light mb-8">Your basket is currently empty.</p>
 <a href="<?= baseUrl('/shop') ?>" class="btn-primary inline-flex">Explore Collections</a>
 </div>
 <?php else: ?>

 <!-- Stepper -->
 <div class="flex items-center justify-center gap-4 mb-16 max-w-lg mx-auto">
 <div class="flex items-center gap-3">
 <span class="w-9 h-9 flex items-center justify-center bg-ink text-white text-xs font-medium">1</span>
 <span class="text-[10px] uppercase tracking-[0.15em] text-ink font-medium">Cart</span>
 </div>
 <div class="w-12 h-[1px] bg-muted-light"></div>
 <div class="flex items-center gap-3">
 <span class="w-9 h-9 flex items-center justify-center border text-muted-light text-xs font-medium" style="border-color: rgba(231,229,228,0.6);">2</span>
 <span class="text-[10px] uppercase tracking-[0.15em] text-muted-light">Shipping</span>
 </div>
 <div class="w-12 h-[1px] bg-muted-light"></div>
 <div class="flex items-center gap-3">
 <span class="w-9 h-9 flex items-center justify-center border text-muted-light text-xs font-medium" style="border-color: rgba(231,229,228,0.6);">3</span>
 <span class="text-[10px] uppercase tracking-[0.15em] text-muted-light">Payment</span>
 </div>
 </div>

 <form action="<?= baseUrl('/cart') ?>" method="POST" class="flex flex-col lg:flex-row gap-12">
 <input type="hidden" name="action" value="checkout">
 <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

 <!-- Left: Forms -->
 <div class="w-full lg:w-2/3 flex flex-col gap-10">
 <!-- Items -->
 <div class="space-y-4">
 <h2 class="text-xl font-serif font-medium text-ink mb-6 tracking-tight">Items</h2>
 <?php foreach ($dbItems as $dbItem): ?>
 <div class="flex gap-6 p-6 bg-surface border group" style="border-color: rgba(231,229,228,0.6);">
 <div class="w-24 h-24 bg-surface overflow-hidden shrink-0">
 <img src="<?= htmlspecialchars($dbItem['image_url'] ?? 'https://placehold.co/150') ?>" alt="<?= htmlspecialchars($dbItem['name']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
 </div>
 <div class="flex-1 flex flex-col justify-center">
 <h3 class="font-serif text-lg text-ink group-hover:text-champagne transition-colors"><?= htmlspecialchars($dbItem['name']) ?></h3>
 <p class="text-[10px] text-muted-light uppercase tracking-widest mt-1 font-medium">Monthly Rental</p>
 <p class="text-lg font-serif text-ink mt-1">$<?= number_format((float)($dbItem['monthly_price'] ?? 0), 2) ?><span class="text-sm text-muted-light font-sans">/mo</span></p>
 </div>
 </div>
 <?php endforeach; ?>
 </div>

 <!-- Delivery -->
 <div class="p-8 bg-surface border" style="border-color: rgba(231,229,228,0.6);">
 <h2 class="text-xl font-serif font-medium text-ink mb-8 tracking-tight flex items-center gap-3">
 <span class="w-8 h-8 flex items-center justify-center bg-champagne/5 text-champagne-dark">
 <span class="material-symbols-outlined text-lg">local_shipping</span>
 </span>
 Delivery Details
 </h2>
 <div class="space-y-6">
 <div>
 <label class="form-label">Preferred Date</label>
 <input type="date" name="delivery_date" required class="form-input">
 </div>
 <div>
 <label class="form-label">Time Slot</label>
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
  <label class="relative cursor-pointer border p-4 text-center transition-all hover:border-champagne/30 has-[:checked]:border-champagne has-[:checked]:bg-champagne/5" style="border-color: rgba(231,229,228,0.6);">
  <input type="radio" name="delivery_time" value="09:00 - 12:00" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required>
  <div class="text-muted has-[:checked]:text-champagne-dark">
  <span class="material-symbols-outlined text-2xl mb-1">light_mode</span>
  <p class="text-sm font-light">Morning</p>
  <p class="text-[10px] text-muted-light uppercase tracking-widest">9AM - 12PM</p>
  </div>
  </label>
  <label class="relative cursor-pointer border p-4 text-center transition-all hover:border-champagne/30 has-[:checked]:border-champagne has-[:checked]:bg-champagne/5" style="border-color: rgba(231,229,228,0.6);">
  <input type="radio" name="delivery_time" value="12:00 - 15:00" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required>
  <div class="text-muted has-[:checked]:text-champagne-dark">
  <span class="material-symbols-outlined text-2xl mb-1">wb_sunny</span>
  <p class="text-sm font-light">Afternoon</p>
  <p class="text-[10px] text-muted-light uppercase tracking-widest">12PM - 3PM</p>
  </div>
  </label>
  <label class="relative cursor-pointer border p-4 text-center transition-all hover:border-champagne/30 has-[:checked]:border-champagne has-[:checked]:bg-champagne/5" style="border-color: rgba(231,229,228,0.6);">
  <input type="radio" name="delivery_time" value="15:00 - 18:00" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required>
  <div class="text-muted has-[:checked]:text-champagne-dark">
  <span class="material-symbols-outlined text-2xl mb-1">routine</span>
  <p class="text-sm font-light">Evening</p>
  <p class="text-[10px] text-muted-light uppercase tracking-widest">3PM - 6PM</p>
  </div>
  </label>
  </div>
 </div>
 </div>
 </div>

 <!-- Address -->
 <div class="p-8 bg-surface border" style="border-color: rgba(231,229,228,0.6);">
 <h2 class="text-xl font-serif font-medium text-ink mb-8 tracking-tight flex items-center gap-3">
 <span class="w-8 h-8 flex items-center justify-center bg-champagne/5 text-champagne-dark">
 <span class="material-symbols-outlined text-lg">home_pin</span>
 </span>
 Shipping Address
 </h2>
 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <div class="md:col-span-2">
 <label class="form-label">Street Address</label>
 <textarea rows="3" name="address" placeholder="Apt/Suite, Building, Street..." required class="form-input resize-none"></textarea>
 </div>
 <div class="md:col-span-2">
 <label class="form-label">Mobile Number</label>
 <input type="tel" name="mobile_number" placeholder="+1 555-0123" required class="form-input">
 </div>
 </div>
 </div>

 <!-- KYC -->
 <div class="p-8 bg-surface border" style="border-color: rgba(231,229,228,0.6);">
 <h2 class="text-xl font-serif font-medium text-ink mb-8 tracking-tight flex items-center gap-3">
 <span class="w-8 h-8 flex items-center justify-center bg-champagne/5 text-champagne-dark">
 <span class="material-symbols-outlined text-lg">verified_user</span>
 </span>
 Verification
 </h2>
 <p class="text-sm text-muted font-light mb-6 p-4 bg-champagne/5 border border-champagne/10 flex items-start gap-3">
 <span class="material-symbols-outlined text-champagne-dark shrink-0">info</span>
 <span>Mandatory for background check before delivery approval. Your data is securely encrypted.</span>
 </p>
 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <div class="md:col-span-2">
 <label class="form-label">Valid ID (Aadhaar/SSN/Passport)</label>
 <input type="text" name="id_number" placeholder="Enter valid ID number" required class="form-input">
 </div>
 <div class="md:col-span-2">
 <label class="form-label">Employer <span class="text-muted-light font-light normal-case tracking-normal ml-1">(Optional)</span></label>
 <input type="text" name="work_verify" placeholder="Employer name" class="form-input">
 </div>
 </div>
 </div>
 </div>

 <!-- Right: Summary -->
 <div class="w-full lg:w-1/3">
 <div class="bg-ink text-white p-8 lg:sticky lg:top-28">
 <h2 class="text-xl font-serif font-medium mb-8 tracking-tight">Order Summary</h2>

 <div class="space-y-4 mb-6 max-h-80 overflow-y-auto pr-2">
 <?php foreach ($dbItems as $dbItem): ?>
 <div class="flex gap-4 p-3 bg-white/5 group">
 <div class="w-16 h-16 bg-white/10 overflow-hidden shrink-0">
 <img src="<?= htmlspecialchars($dbItem['image_url'] ?? 'https://placehold.co/150') ?>" alt="<?= htmlspecialchars($dbItem['name']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
 </div>
 <div class="flex-1 py-1">
 <h3 class="text-sm text-white font-light line-clamp-1"><?= htmlspecialchars($dbItem['name']) ?></h3>
 <p class="text-[10px] text-white/40 uppercase tracking-widest mt-1">Monthly</p>
 <p class="text-base text-champagne font-serif mt-0.5">$<?= number_format((float)($dbItem['monthly_price'] ?? 0), 0) ?>/mo</p>
 </div>
 </div>
 <?php endforeach; ?>
 </div>

 <div class="pt-6 mb-6 space-y-4" style="border-top: 1px solid rgba(255,255,255,0.1);">
 <div class="flex justify-between text-sm">
 <span class="text-white/50">Subtotal</span>
 <span class="text-white">$<?= number_format($subtotal, 2) ?></span>
 </div>
 <div class="flex justify-between text-sm">
 <span class="text-white/50">Deposit</span>
 <span class="text-champagne">+ $<?= number_format($deposits, 2) ?></span>
 </div>
 <div class="flex justify-between text-sm">
 <span class="text-white/50">Fees & Tax</span>
 <span class="text-white/60">+ $<?= number_format($tax + $delivery, 2) ?></span>
 </div>
 </div>

 <div class="pt-6 mb-8" style="border-top: 1px solid rgba(255,255,255,0.1);">
 <div class="flex justify-between items-baseline">
 <div>
 <span class="block text-white/40 uppercase tracking-widest text-[10px] mb-1">Total Today</span>
 <span class="block text-white/40 text-xs font-light">1st month + deposit</span>
 </div>
 <span class="text-3xl font-serif text-champagne">$<?= number_format($total, 2) ?></span>
 </div>
 </div>

 <button type="submit" class="w-full py-5 bg-champagne text-ink text-[11px] font-medium tracking-[0.2em] uppercase hover:bg-white transition-all duration-500 flex items-center justify-center gap-3 outline-none">
 <span class="material-symbols-outlined text-lg">lock</span>
 Secure Checkout
 </button>
 </div>
 </div>
 </form>

 <div class="flex justify-end mt-8">
 <form action="<?= baseUrl('/cart') ?>" method="POST">
 <input type="hidden" name="action" value="clear">
 <button type="submit" class="text-sm text-rose hover:text-rose/70 transition-colors font-light flex items-center gap-2 outline-none">
 <span class="material-symbols-outlined text-sm">delete</span>
 Empty Cart
 </button>
 </form>
 </div>

 <?php endif; ?>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
 const check = setInterval(() => {
 if (window.gsap) {
 clearInterval(check);
 gsap.context(() => {
 gsap.utils.toArray('.bg-surface.border, .bg-ink').forEach((el, i) => {
 gsap.from(el, { opacity: 0, y: 20, duration: 0.8, delay: i * 0.1, ease: 'power3.out' });
 });
 });
 }
 }, 100);
});
</script>

<?php require __DIR__ . '/partials/footer.php'; ?>
