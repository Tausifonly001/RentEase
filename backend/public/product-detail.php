<?php
declare(strict_types=1);

use RentEase\Services\ProductService;
use RentEase\Services\WishlistService;
use RentEase\Services\AuthService;

require __DIR__ . '/../bootstrap.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$productService = new ProductService($config);
$wishlistService = new WishlistService($config);
$authService = new AuthService($config);

$currentUser = null;
$token = $_COOKIE[$config['cookie_name'] ?? ''] ?? '';
if ($token) {
 try {
 $userData = $authService->validateToken($token);
 if ($userData) {
 $currentUser = $userData;
 $currentUser['name'] = $userData['user_metadata']['full_name']
 ?? $userData['name']
 ?? explode('@', $userData['email'])[0]
 ?? 'User';
 }
 } catch (Throwable $ignored) {}
}

$product = null;
$error = null;
$isInWishlist = false;

try {
 if (!$id) throw new RuntimeException('Product ID is missing or invalid.');
 $product = $productService->findById((int) $id);
 if (!$product) throw new RuntimeException('The requested product was not found.');

 if ($currentUser) {
 try {
 $wishItems = $wishlistService->getItems($currentUser['id'], $token);
 $wishlistIds = array_column($wishItems, 'product_id');
 $isInWishlist = in_array((int)$id, $wishlistIds);
 } catch (Throwable $e) { error_log("PDP Wishlist Error: " . $e->getMessage()); }
 }
} catch (Throwable $e) {
 $error = $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_wishlist'])) {
 if (!$currentUser) { header('Location: ' . baseUrl('/login')); exit; }
 $csrfToken = $_POST['csrf_token'] ?? '';
 if (!RentEase\Support\Csrf::validate((string)$csrfToken)) {
 $error = "Security validation failed.";
 } else {
 try {
 $wishlistService->toggleItem($currentUser['id'], (int)$id, $token);
 $isInWishlist = !$isInWishlist;
 } catch (Throwable $e) { $error = "Wishlist update failed: " . $e->getMessage(); }
 }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rent_now'])) {
 $months = filter_input(INPUT_POST, 'tenure', FILTER_VALIDATE_INT) ?: 3;
 if ($product) {
 if (session_status() !== PHP_SESSION_ACTIVE) session_start();
 if (empty($_SESSION['cart'])) $_SESSION['cart'] = [];

 $discount = 0.0;
 if ($months === 6) $discount = 0.05;
 elseif ($months === 12) $discount = 0.15;

 $basePrice = (float)($product['monthly_price'] ?? 0);
 $finalPrice = $basePrice * (1.0 - $discount);

 $_SESSION['cart'][$product['id']] = [
 'id' => $product['id'],
 'name' => $product['name'],
 'image_url' => $product['image_url'] ?? '',
 'category' => $product['category'] ?? 'General',
 'monthly_price' => $finalPrice,
 'original_price' => $basePrice,
 'months' => $months
 ];
 session_write_close();
 header('Location: ' . baseUrl('/cart'));
 exit;
 }
}

function getProductSpecs(array $product): array {
 $cat = strtolower($product['category'] ?? '');
 $name = strtolower($product['name'] ?? '');

 if (str_contains($cat, 'sofa') || str_contains($name, 'sofa') || str_contains($name, 'couch')) {
 return ['Material' => 'Performance Velvet / Kiln-Dried Hardwood', 'Condition' => 'Certified Mint', 'Dimensions' => 'L: 210cm x W: 95cm x H: 85cm', 'Seating' => '3 Seater'];
 }
 if (str_contains($cat, 'chair') || str_contains($name, 'chair')) {
 return ['Material' => 'Breathable Mesh / Recycled Polymer', 'Condition' => 'Like New', 'Dimensions' => 'L: 65cm x W: 65cm x H: 110cm', 'Adjustability' => '4D Armrests, Lumbar Support'];
 }
 if (str_contains($cat, 'table') || str_contains($name, 'table') || str_contains($name, 'desk')) {
 return ['Material' => 'Solid Oak / Powder Coated Steel', 'Condition' => 'Pristine', 'Dimensions' => 'L: 120cm x W: 60cm x H: 75cm', 'Finish' => 'Matte Water-Resistant'];
 }
 if (str_contains($cat, 'bed') || str_contains($name, 'bed')) {
 return ['Material' => 'Upholstered Linen / Engineered Wood', 'Condition' => 'Sanitized & Mint', 'Dimensions' => 'L: 200cm x W: 160cm x H: 120cm', 'Storage' => 'Ottoman Lift Support'];
 }
 return ['Material' => 'Premium Sustainable Materials', 'Condition' => 'Excellent', 'Dimensions' => 'Standard'];
}

$specs = $product ? getProductSpecs($product) : [];

$relatedProducts = [];
if ($product) {
 try {
 $relatedProducts = $productService->catalog(1, 5, $product['category']);
 $relatedProducts = array_filter($relatedProducts, fn($p) => $p['id'] != $product['id']);
 $relatedProducts = array_slice($relatedProducts, 0, 4);
 } catch (\Exception $e) {}
}

$pageTitle = htmlspecialchars($product['name'] ?? 'Product Details') . ' - RentEase';
$pageDescription = 'Rent ' . htmlspecialchars($product['name'] ?? 'this product') . ' on a flexible monthly plan.';
require __DIR__ . '/partials/header.php';
?>

<main class="flex-grow w-full max-w-[1600px] mx-auto px-6 lg:px-12 py-28 lg:py-32 bg-canvas">

<?php if ($error || !$product): ?>
 <div class="py-24 text-center">
 <div class="w-20 h-20 mx-auto mb-6 flex items-center justify-center bg-champagne/10 text-champagne-dark">
 <span class="material-symbols-outlined text-4xl">inventory_2</span>
 </div>
 <h2 class="text-2xl font-serif font-medium text-ink mb-3">Something went wrong</h2>
 <p class="text-muted mb-10 max-w-md mx-auto font-light"><?= htmlspecialchars($error ?? 'The requested product could not be found.') ?></p>
 <a href="<?= baseUrl('/shop') ?>" class="btn-primary inline-flex">Browse Collections</a>
 </div>
<?php else: ?>

 <!-- Breadcrumbs -->
 <nav aria-label="Breadcrumb" class="mb-10" id="breadcrumbs">
 <ol class="flex items-center gap-2 text-sm text-muted font-light">
 <li><a href="<?= baseUrl('/') ?>" class="hover:text-ink transition-colors">Home</a></li>
 <li><span class="material-symbols-outlined text-base">chevron_right</span></li>
 <li><a href="<?= baseUrl('/shop') ?>" class="hover:text-ink transition-colors">Collection</a></li>
 <li><span class="material-symbols-outlined text-base">chevron_right</span></li>
 <li><a href="<?= baseUrl('/shop?category=' . urlencode($product['category'])) ?>" class="hover:text-ink transition-colors"><?= htmlspecialchars($product['category']) ?></a></li>
 <li><span class="material-symbols-outlined text-base">chevron_right</span></li>
 <li class="text-ink font-medium truncate"><?= htmlspecialchars($product['name']) ?></li>
 </ol>
 </nav>

 <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-20 items-start">

 <!-- Gallery -->
 <div class="lg:col-span-7 space-y-4" id="gallery">
 <div class="grid grid-cols-2 gap-4">
 <div class="col-span-2 group relative overflow-hidden bg-surface aspect-[4/3]">
 <img id="main-product-image"
 src="<?= htmlspecialchars($product['image_url'] ?? 'https://via.placeholder.com/1200x900?text=' . urlencode($product['name'])) ?>"
 alt="<?= htmlspecialchars($product['name']) ?>"
 class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105"
 style="filter: grayscale(10%);">

 <form method="POST" class="absolute top-6 right-6 z-10">
 <input type="hidden" name="csrf_token" value="<?= RentEase\Support\Csrf::token() ?>">
 <input type="hidden" name="toggle_wishlist" value="1">
 <button type="submit" class="h-11 w-11 bg-white/80 backdrop-blur-md flex items-center justify-center transition-all hover:scale-110 active:scale-95 <?= $isInWishlist ? 'text-rose' : 'text-muted-light hover:text-rose' ?> outline-none">
 <span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' <?= $isInWishlist ? '1' : '0' ?>;">favorite</span>
 </button>
 </form>

 <div class="absolute bottom-6 left-6 flex flex-wrap gap-2">
 <span class="px-4 py-1.5 bg-ink/80 text-white text-[10px] font-medium uppercase tracking-widest">Premium Series</span>
 <?php if (($product['total_stock'] ?? 0) < 5): ?>
 <span class="px-4 py-1.5 bg-rose/80 text-white text-[10px] font-medium uppercase tracking-widest">Low Stock</span>
 <?php endif; ?>
 </div>
 </div>

 <div class="aspect-square overflow-hidden bg-surface group cursor-crosshair">
 <img src="<?= htmlspecialchars($product['image_url'] ?? 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&q=80') ?>"
 class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700"
 alt="Detail View" loading="lazy">
 </div>
 <div class="aspect-square overflow-hidden bg-surface group cursor-crosshair relative">
 <img src="<?= htmlspecialchars($product['image_url'] ?? 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&q=80') ?>"
 class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700"
 alt="Style View" loading="lazy">
 </div>
 </div>

 <!-- Feature Strip -->
 <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4">
 <div class="p-5 bg-surface border hover:-translate-y-0.5 transition-transform duration-300" style="border-color: rgba(231,229,228,0.6);">
 <div class="flex items-center gap-4">
 <span class="material-symbols-outlined text-2xl text-champagne">local_shipping</span>
 <div>
 <p class="text-[10px] font-medium text-muted-light uppercase tracking-widest">Delivery</p>
 <p class="text-sm text-ink">Free & White-Glove</p>
 </div>
 </div>
 </div>
 <div class="p-5 bg-surface border hover:-translate-y-0.5 transition-transform duration-300" style="border-color: rgba(231,229,228,0.6);">
 <div class="flex items-center gap-4">
 <span class="material-symbols-outlined text-2xl text-champagne">build</span>
 <div>
 <p class="text-[10px] font-medium text-muted-light uppercase tracking-widest">Assembly</p>
 <p class="text-sm text-ink">Professional</p>
 </div>
 </div>
 </div>
 <div class="p-5 bg-surface border hover:-translate-y-0.5 transition-transform duration-300" style="border-color: rgba(231,229,228,0.6);">
 <div class="flex items-center gap-4">
 <span class="material-symbols-outlined text-2xl text-champagne">cleaning_services</span>
 <div>
 <p class="text-[10px] font-medium text-muted-light uppercase tracking-widest">Service</p>
 <p class="text-sm text-ink">Deep Cleaning Included</p>
 </div>
 </div>
 </div>
 </div>
 </div>

 <!-- Details -->
 <div class="lg:col-span-5 lg:sticky lg:top-28 space-y-10" id="details">
 <header>
 <div class="flex items-center gap-4 mb-6">
 <span class="px-3 py-1.5 bg-champagne/10 text-champagne-dark text-[10px] font-medium uppercase tracking-widest">New Arrival</span>
 <div class="flex items-center gap-1 text-champagne">
 <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
 <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
 <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
 <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
 <span class="material-symbols-outlined text-sm">star_half</span>
 <span class="text-muted text-xs ml-2 font-light">4.8 (124 reviews)</span>
 </div>
 </div>
 <h1 class="text-3xl md:text-4xl lg:text-5xl font-serif text-ink leading-tight mb-4 tracking-tight">
 <?= htmlspecialchars($product['name']) ?>
 </h1>
 <p class="text-base text-muted leading-relaxed font-light">
 <?= htmlspecialchars($product['description'] ?? 'Elevate your interior with this curated ' . lcfirst($product['category']) . '. Designed for both aesthetics and durability.') ?>
 </p>
 </header>

 <!-- Pricing Card -->
 <div class="p-8 lg:p-10 bg-surface border shadow-lg" style="border-color: rgba(231,229,228,0.6); box-shadow: 0 24px 64px rgba(24,24,27,0.06);">
 <div class="flex items-baseline gap-2 mb-2">
 <span class="text-4xl md:text-5xl font-serif text-ink tracking-tight" id="price-display">$<?= number_format((float)($product['monthly_price'] ?? 0), 0) ?></span>
 <span class="text-muted uppercase tracking-widest text-[10px]">/ month</span>
 </div>
 <p class="text-sm text-muted-light font-light flex items-center gap-1 mt-1">
 <span class="material-symbols-outlined text-sm text-champagne font-light" style="font-variation-settings: 'FILL' 1;">verified_user</span>
 Refundable deposit: <span class="text-ink">+$<?= number_format((float)($product['monthly_price'] ?? 0) * 1.5, 0) ?></span>
 </p>

 <hr class="my-8" style="border-color: rgba(231,229,228,0.6);">

 <form id="rent-form" method="POST" action="<?= baseUrl('/product-detail?id=' . $product['id']) ?>" class="space-y-8">
 <input type="hidden" name="csrf_token" value="<?= RentEase\Support\Csrf::token() ?>">
 <input type="hidden" name="rent_now" value="1">

 <div>
 <div class="flex justify-between items-center mb-5">
 <h3 class="text-[11px] text-ink uppercase tracking-widest font-medium">Select Tenure</h3>
 <span class="text-[10px] text-champagne-dark uppercase tracking-widest bg-champagne/10 px-2 py-1">Up to 15% Off</span>
 </div>
 <div class="grid grid-cols-3 gap-3" role="radiogroup">
 <label class="cursor-pointer group">
 <input class="peer sr-only" name="tenure" type="radio" value="3" checked onchange="updatePrice(1)">
 <div class="py-5 px-2 border-2 text-center transition-all group-hover:border-champagne/30 peer-checked:border-champagne peer-checked:bg-champagne/5 peer-checked:text-champagne-dark peer-focus-visible:ring-2 ring-champagne" style="border-color: rgba(231,229,228,0.6);">
 <p class="text-2xl font-serif tracking-tight">3</p>
 <p class="text-[10px] uppercase tracking-widest text-muted-light mt-1">Months</p>
 </div>
 </label>
 <label class="cursor-pointer group">
 <input class="peer sr-only" name="tenure" type="radio" value="6" onchange="updatePrice(0.95)">
 <div class="py-5 px-2 border-2 text-center transition-all group-hover:border-champagne/30 peer-checked:border-champagne peer-checked:bg-champagne/5 peer-checked:text-champagne-dark peer-focus-visible:ring-2 ring-champagne relative overflow-hidden" style="border-color: rgba(231,229,228,0.6);">
 <p class="text-2xl font-serif tracking-tight">6</p>
 <p class="text-[10px] uppercase tracking-widest text-muted-light mt-1">Months</p>
 <div class="absolute top-0 right-0 bg-champagne text-ink text-[8px] font-medium px-2 py-1">5% OFF</div>
 </div>
 </label>
 <label class="cursor-pointer group">
 <input class="peer sr-only" name="tenure" type="radio" value="12" onchange="updatePrice(0.85)">
 <div class="py-5 px-2 border-2 text-center transition-all group-hover:border-champagne/30 peer-checked:border-champagne peer-checked:bg-champagne/5 peer-checked:text-champagne-dark peer-focus-visible:ring-2 ring-champagne relative overflow-hidden" style="border-color: rgba(231,229,228,0.6);">
 <p class="text-2xl font-serif tracking-tight">12</p>
 <p class="text-[10px] uppercase tracking-widest text-muted-light mt-1">Months</p>
 <div class="absolute top-0 right-0 bg-champagne text-ink text-[8px] font-medium px-2 py-1">15% OFF</div>
 </div>
 </label>
 </div>
 </div>

 <div class="space-y-4">
 <button type="submit" class="btn-primary w-full justify-center py-5">
 <span class="material-symbols-outlined group-hover:rotate-12 transition-transform">shopping_bag</span>
 Reserve for Rental
 </button>
 <div class="relative group">
 <input aria-label="Check delivery availability by zip code" class="w-full bg-transparent border-b py-4 pl-10 text-sm font-light outline-none transition-all placeholder-muted-light focus:border-champagne" style="border-color: rgba(231,229,228,0.6);" placeholder="Check delivery availability..." type="text">
 <span class="material-symbols-outlined absolute left-0 top-1/2 -translate-y-1/2 text-muted-light">local_shipping</span>
 <button type="button" class="absolute right-0 top-1/2 -translate-y-1/2 text-champagne-dark text-[10px] font-medium uppercase tracking-widest hover:text-champagne transition-colors outline-none">Check</button>
 </div>
 </div>
 </form>
 </div>

 <!-- Specs Accordion -->
 <div class="space-y-3">
 <div class="bg-surface border overflow-hidden transition-all" style="border-color: rgba(231,229,228,0.6);">
 <button class="w-full px-8 py-5 flex items-center justify-between text-left group" onclick="this.nextElementSibling.classList.toggle('hidden')">
 <div class="flex items-center gap-4">
 <span class="w-9 h-9 flex items-center justify-center bg-champagne/5 text-champagne-dark">
 <span class="material-symbols-outlined text-lg">tune</span>
 </span>
 <span class="text-ink font-medium">Specifications</span>
 </div>
 <span class="material-symbols-outlined text-muted-light transition-transform group-active:scale-90">expand_more</span>
 </button>
 <div class="px-8 pb-6 pt-0 hidden">
 <dl class="grid grid-cols-2 gap-y-6 gap-x-4 text-sm font-light">
 <?php foreach ($specs as $key => $value): ?>
 <div class="<?= $key === 'Dimensions' ? 'col-span-2' : '' ?>">
 <dt class="text-[10px] text-muted-light uppercase tracking-widest mb-1 font-medium"><?= htmlspecialchars($key) ?></dt>
 <dd class="text-ink font-light"><?= htmlspecialchars($value) ?></dd>
 </div>
 <?php endforeach; ?>
 </dl>
 </div>
 </div>

 <div class="bg-surface border overflow-hidden" style="border-color: rgba(231,229,228,0.6);">
 <button class="w-full px-8 py-5 flex items-center justify-between text-left group" onclick="this.nextElementSibling.classList.toggle('hidden')">
 <div class="flex items-center gap-4">
 <span class="w-9 h-9 flex items-center justify-center bg-champagne/5 text-champagne-dark">
 <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">verified</span>
 </span>
 <span class="text-ink font-medium">RentEase Promise</span>
 </div>
 <span class="material-symbols-outlined text-muted-light transition-transform group-active:scale-90">expand_more</span>
 </button>
 <div class="px-8 pb-6 pt-0 hidden">
 <ul class="space-y-4">
 <li class="flex items-start gap-4">
 <span class="material-symbols-outlined text-champagne text-lg mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
 <div>
 <p class="text-ink text-sm">Free Relocation</p>
 <p class="text-xs text-muted mt-0.5 font-light">Moving within the city? We'll transport it for free.</p>
 </div>
 </li>
 <li class="flex items-start gap-4">
 <span class="material-symbols-outlined text-champagne text-lg mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
 <div>
 <p class="text-ink text-sm">Deep Cleaning</p>
 <p class="text-xs text-muted mt-0.5 font-light">Complimentary deep cleaning service every 6 months.</p>
 </div>
 </li>
 <li class="flex items-start gap-4">
 <span class="material-symbols-outlined text-champagne text-lg mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
 <div>
 <p class="text-ink text-sm">Professional Support</p>
 <p class="text-xs text-muted mt-0.5 font-light">Dedicated maintenance team available on demand.</p>
 </div>
 </li>
 </ul>
 </div>
 </div>
 </div>
 </div>
 </div>

 <!-- Related Products -->
 <section class="mt-24 pt-24 border-t" style="border-color: rgba(231,229,228,0.6);" id="related">
 <div class="flex flex-col md:flex-row justify-between items-end mb-12">
 <div>
 <h2 class="section-title text-3xl">Pairs well with</h2>
 <p class="section-subtitle">Complete your room with these hand-picked items.</p>
 </div>
 <a href="<?= baseUrl('/shop') ?>" class="btn-ghost mt-4 md:mt-0">Explore Catalog <span class="material-symbols-outlined text-sm ml-1">arrow_right_alt</span></a>
 </div>

 <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
 <?php if (empty($relatedProducts)): ?>
 <?php for($i=1; $i<=4; $i++): ?>
 <div class="group">
 <div class="aspect-[4/3] overflow-hidden bg-surface border mb-4 flex items-center justify-center" style="border-color: rgba(231,229,228,0.6);">
 <span class="material-symbols-outlined text-muted-light text-4xl">inventory_2</span>
 </div>
 <div class="h-4 bg-surface w-2/3 mb-2" style="background: rgba(231,229,228,0.6);"></div>
 <div class="h-3 bg-surface w-1/2" style="background: rgba(231,229,228,0.4);"></div>
 </div>
 <?php endfor; ?>
 <?php else: ?>
 <?php foreach($relatedProducts as $related): ?>
 <div class="group flex flex-col bg-surface border overflow-hidden hover:-translate-y-1 transition-all duration-500 relative" style="border-color: rgba(231,229,228,0.6);">
 <a href="<?= baseUrl('/product-detail?id=' . $related['id']) ?>" class="relative aspect-[4/3] overflow-hidden bg-surface block">
 <img src="<?= htmlspecialchars($related['image_url'] ?? 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&q=80') ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="<?= htmlspecialchars($related['name']) ?>" loading="lazy">
 <div class="absolute inset-0 bg-gradient-to-t from-ink/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
 </a>
 <div class="p-5 flex flex-col flex-grow bg-surface z-10 relative">
 <a href="<?= baseUrl('/product-detail?id=' . $related['id']) ?>" class="mb-2">
 <h3 class="font-serif text-lg text-ink leading-tight group-hover:text-champagne transition-colors line-clamp-1"><?= htmlspecialchars($related['name']) ?></h3>
 </a>
 <div class="mt-auto flex items-end justify-between pt-2">
 <div class="flex items-baseline gap-1">
 <span class="text-xl font-serif text-ink tracking-tight">$<?= number_format((float)$related['monthly_price'], 0) ?></span>
 <span class="text-[10px] text-muted-light uppercase tracking-widest">/mo</span>
 </div>
 </div>
 </div>
 </div>
 <?php endforeach; ?>
 <?php endif; ?>
 </div>
 </section>

<?php endif; ?>
</main>

<script>
 const basePrice = <?= (float)($product['monthly_price'] ?? 0) ?>;
 function updatePrice(multiplier) {
 const newPrice = basePrice * multiplier;
 const display = document.getElementById('price-display');
 if (window.gsap) {
 gsap.to(display, {
 innerText: Math.round(newPrice),
 duration: 0.5,
 snap: { innerText: 1 },
 onUpdate: function() { display.innerHTML = '$' + display.innerText; }
 });
 } else {
 display.innerHTML = '$' + Math.round(newPrice);
 }
 }

 window.addEventListener('load', () => {
 document.querySelectorAll('img').forEach(img => {
 img.addEventListener('error', function() {
 this.src = 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&q=80';
 this.style.opacity = '0.5';
 });
 });

 const gsapCheck = setInterval(() => {
 if (window.gsap) {
 clearInterval(gsapCheck);
 const ctx = gsap.context(() => {
 const tl = gsap.timeline({ defaults: { ease: 'power4.out', duration: 1.2 } });
 tl.from('#breadcrumbs', { opacity: 0, y: -10, duration: 0.8 })
 .from('#gallery > div > div', { opacity: 0, y: 20, stagger: 0.15, duration: 1, ease: 'power3.out' }, '-=0.4')
 .from('#gallery .grid-cols-1 > div', { opacity: 0, y: 20, stagger: 0.1, duration: 0.8 }, '-=0.6')
 .from('#details > *', { opacity: 0, y: 20, stagger: 0.1, duration: 0.8 }, '-=1');

 if (window.ScrollTrigger) {
 gsap.registerPlugin(ScrollTrigger);
 gsap.from('#related', {
 opacity: 0, y: 40, duration: 1,
 scrollTrigger: { trigger: '#related', start: 'top 85%' }
 });
 }

 // Micro-interactions
 const tenureCards = document.querySelectorAll('input[name="tenure"] + div');
 tenureCards.forEach(card => {
 card.addEventListener('mouseenter', () => {
 if (!card.previousElementSibling.checked) {
 gsap.to(card, { y: -3, duration: 0.3, ease: 'power2.out' });
 }
 });
 card.addEventListener('mouseleave', () => {
 gsap.to(card, { y: 0, duration: 0.3, ease: 'power2.out' });
 });
 });
 });
 }
 }, 100);
 });
</script>

<?php require __DIR__ . '/partials/footer.php'; ?>
