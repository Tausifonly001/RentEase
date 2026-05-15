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
    if (!$id) {
        throw new RuntimeException('Product ID is missing or invalid.');
    }
    $product = $productService->findById((int) $id);
    if (!$product) {
        throw new RuntimeException('The requested product was not found.');
    }
    
    if ($currentUser) {
        try {
            $wishItems = $wishlistService->getItems($currentUser['id'], $token);
            $wishlistIds = array_column($wishItems, 'product_id');
            $isInWishlist = in_array((int)$id, $wishlistIds);
        } catch (Throwable $e) {
            // Log error but don't block the product view
            error_log("PDP Wishlist Error: " . $e->getMessage());
        }
    }
} catch (Throwable $e) {
    $error = $e->getMessage();
}

// Handle Toggle Wishlist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_wishlist'])) {
    if (!$currentUser) {
        header('Location: ' . baseUrl('/login'));
        exit;
    }
    
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!RentEase\Support\Csrf::validate((string)$csrfToken)) {
        $error = "Security validation failed. Please try again.";
    } else {
        try {
            $wishlistService->toggleItem($currentUser['id'], (int)$id, $token);
            $isInWishlist = !$isInWishlist; // Optimistic UI
        } catch (Throwable $e) {
            $error = "Wishlist update failed: " . $e->getMessage();
        }
    }
}

// Tenure add to cart logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rent_now'])) {
    $months = filter_input(INPUT_POST, 'tenure', FILTER_VALIDATE_INT) ?: 3;
    if ($product) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (empty($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        $discount = 0.0;
        if ($months === 6) {
            $discount = 0.05;
        } elseif ($months === 12) {
            $discount = 0.15;
        }

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

// Helper to get realistic specs based on category
function getProductSpecs(array $product): array {
    $cat = strtolower($product['category'] ?? '');
    $name = strtolower($product['name'] ?? '');
    
    if (str_contains($cat, 'sofa') || str_contains($name, 'sofa') || str_contains($name, 'couch')) {
        return [
            'Material' => 'Performance Velvet / Kiln-Dried Hardwood',
            'Condition' => 'Certified Mint',
            'Dimensions' => 'L: 210cm x W: 95cm x H: 85cm',
            'Seating' => '3 Seater'
        ];
    }
    if (str_contains($cat, 'chair') || str_contains($name, 'chair')) {
        return [
            'Material' => 'Breathable Mesh / Recycled Polymer',
            'Condition' => 'Like New',
            'Dimensions' => 'L: 65cm x W: 65cm x H: 110cm',
            'Adjustability' => '4D Armrests, Lumbar Support'
        ];
    }
    if (str_contains($cat, 'table') || str_contains($name, 'table') || str_contains($name, 'desk')) {
        return [
            'Material' => 'Solid Oak / Powder Coated Steel',
            'Condition' => 'Pristine',
            'Dimensions' => 'L: 120cm x W: 60cm x H: 75cm',
            'Finish' => 'Matte Water-Resistant'
        ];
    }
    if (str_contains($cat, 'bed') || str_contains($name, 'bed')) {
        return [
            'Material' => 'Upholstered Linen / Engineered Wood',
            'Condition' => 'Sanitized & Mint',
            'Dimensions' => 'L: 200cm x W: 160cm x H: 120cm',
            'Storage' => 'Ottoman Lift Support'
        ];
    }
    
    return [
        'Material' => 'Premium Sustainable Materials',
        'Condition' => 'Excellent',
        'Dimensions' => 'Standard'
    ];
}

$specs = $product ? getProductSpecs($product) : [];

// Fetch related products
$relatedProducts = [];
if ($product) {
    try {
        $relatedProducts = $productService->catalog(1, 5, $product['category']);
        $relatedProducts = array_filter($relatedProducts, fn($p) => $p['id'] != $product['id']);
        $relatedProducts = array_slice($relatedProducts, 0, 4);
    } catch (\Exception $e) {
        // Fallback to empty
    }
}


require __DIR__ . '/partials/header.php';
?>

<main class="flex-grow w-full max-w-7xl mx-auto px-4 md:px-8 py-8 md:py-12 bg-surface">
    
<?php if ($error || !$product): ?>
    <div class="py-24 text-center" id="error-state">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-error-container/20 text-error mb-6">
            <span class="material-symbols-outlined text-4xl">inventory_2</span>
        </div>
        <h2 class="text-2xl font-bold text-primary mb-2">Something went wrong</h2>
        <p class="text-on-surface-variant mb-8 max-w-md mx-auto"><?= htmlspecialchars($error ?? 'The requested product could not be found in our catalog.') ?></p>
        <a href="<?= baseUrl('/browse') ?>" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-white rounded-xl font-bold hover:bg-slate-800 transition-all shadow-lg shadow-primary/10">
            <span class="material-symbols-outlined">arrow_back</span>
            Browse Collections
        </a>
    </div>
<?php else: ?>

    <!-- Breadcrumbs -->
    <nav aria-label="Breadcrumb" class="mb-8 overflow-hidden" id="breadcrumbs">
        <ol class="flex items-center gap-2 text-sm text-on-surface-variant">
            <li><a href="<?= baseUrl('/') ?>" class="hover:text-secondary transition-colors">Home</a></li>
            <li><span class="material-symbols-outlined text-base">chevron_right</span></li>
            <li><a href="<?= baseUrl('/browse') ?>" class="hover:text-secondary transition-colors">Rentals</a></li>
            <li><span class="material-symbols-outlined text-base">chevron_right</span></li>
            <li><a href="<?= baseUrl('/browse?category=' . urlencode($product['category'])) ?>" class="hover:text-secondary transition-colors"><?= htmlspecialchars($product['category']) ?></a></li>
            <li><span class="material-symbols-outlined text-base">chevron_right</span></li>
            <li class="font-semibold text-primary truncate"><?= htmlspecialchars($product['name']) ?></li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-16 items-start">
        
        <!-- Left Column: Image Gallery (Bento Style) -->
        <div class="lg:col-span-7 space-y-6" id="gallery-container">
            <div class="grid grid-cols-2 gap-4">
                <!-- Main Image -->
                <div class="col-span-2 group relative rounded-3xl overflow-hidden bg-white border border-outline-variant aspect-[4/3] transition-all hover:shadow-2xl hover:shadow-primary/5">
                    <img 
                        id="main-product-image" 
                        src="<?= htmlspecialchars($product['image_url'] ?? 'https://via.placeholder.com/1200x900?text=' . urlencode($product['name'])) ?>" 
                        alt="<?= htmlspecialchars($product['name']) ?>"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                    >
                    
                    <!-- Wishlist Toggle -->
                    <form method="POST" class="absolute top-6 right-6 z-10">
                        <input type="hidden" name="csrf_token" value="<?= RentEase\Support\Csrf::token() ?>">
                        <input type="hidden" name="toggle_wishlist" value="1">
                        <button type="submit" class="h-12 w-12 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center transition-all hover:scale-110 active:scale-95 shadow-lg <?= $isInWishlist ? 'text-error' : 'text-slate-400 hover:text-error' ?>">
                            <span class="material-symbols-outlined !text-2xl" style="font-variation-settings: 'FILL' <?= $isInWishlist ? '1' : '0' ?>;">favorite</span>
                        </button>
                    </form>

                    <!-- Status Badges -->
                    <div class="absolute bottom-6 left-6 flex flex-wrap gap-2">
                        <span class="px-4 py-1.5 bg-primary/90 backdrop-blur text-white text-[10px] font-black uppercase tracking-widest rounded-full">Premium Series</span>
                        <?php if (($product['total_stock'] ?? 0) < 5): ?>
                            <span class="px-4 py-1.5 bg-error/90 backdrop-blur text-white text-[10px] font-black uppercase tracking-widest rounded-full">Low Stock</span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Secondary Images (Bento) -->
                <div class="aspect-square rounded-2xl overflow-hidden bg-white border border-outline-variant group">
                    <img src="<?= htmlspecialchars($product['image_url'] ?? 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&q=80') ?>" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 transition-opacity duration-500 cursor-zoom-in" alt="Detail View">
                </div>
                <div class="aspect-square rounded-2xl overflow-hidden bg-white border border-outline-variant group relative">
                    <img src="<?= htmlspecialchars($product['image_url'] ?? 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&q=80') ?>" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 transition-opacity duration-500 cursor-zoom-in" alt="Style View">
                    <div class="absolute inset-0 bg-primary/10 group-hover:bg-transparent transition-colors"></div>
                </div>
            </div>

            <!-- Features Quick Look -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4">
                <div class="p-4 rounded-2xl bg-white border border-outline-variant flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center">
                        <span class="material-symbols-outlined">local_shipping</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Delivery</p>
                        <p class="text-sm font-bold text-primary">Free & Fast</p>
                    </div>
                </div>
                <div class="p-4 rounded-2xl bg-white border border-outline-variant flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center">
                        <span class="material-symbols-outlined">build</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Assembly</p>
                        <p class="text-sm font-bold text-primary">Professional</p>
                    </div>
                </div>
                <div class="p-4 rounded-2xl bg-white border border-outline-variant flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center">
                        <span class="material-symbols-outlined">cleaning_services</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Service</p>
                        <p class="text-sm font-bold text-primary">Deep Cleaning</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Product Details & Actions -->
        <div class="lg:col-span-5 lg:sticky lg:top-24 space-y-8" id="details-container">
            <header>
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-secondary font-black text-[10px] uppercase tracking-[0.2em] px-3 py-1 bg-secondary/10 rounded-full">New Arrival</span>
                    <div class="flex items-center gap-1 text-amber-500">
                        <span class="material-symbols-outlined !text-sm">star</span>
                        <span class="material-symbols-outlined !text-sm">star</span>
                        <span class="material-symbols-outlined !text-sm">star</span>
                        <span class="material-symbols-outlined !text-sm">star</span>
                        <span class="material-symbols-outlined !text-sm">star_half</span>
                        <span class="text-slate-400 text-xs ml-1 font-bold">4.8 (124 reviews)</span>
                    </div>
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-primary leading-tight mb-4 tracking-tighter">
                    <?= htmlspecialchars($product['name']) ?>
                </h1>
                <p class="text-lg text-on-surface-variant leading-relaxed">
                    <?= htmlspecialchars($product['description'] ?? 'Elevate your interior with this curated ' . lcfirst($product['category']) . '. Designed for both aesthetics and durability.') ?>
                </p>
            </header>

            <div class="p-6 rounded-3xl bg-white border border-outline-variant shadow-sm">
                <div class="flex items-baseline gap-2 mb-1">
                    <span class="text-5xl font-black text-primary tracking-tighter" id="price-display">$<?= number_format((float)($product['monthly_price'] ?? 0), 0) ?></span>
                    <span class="text-on-surface-variant font-bold">/ month</span>
                </div>
                <p class="text-sm text-slate-400 font-medium">Fully refundable deposit: <span class="text-primary font-bold">+$<?= number_format((float)($product['monthly_price'] ?? 0) * 1.5, 0) ?></span></p>

                <hr class="my-8 border-slate-100">

                <!-- Tenure Selection -->
                <form id="rent-form" method="POST" action="<?= baseUrl('/product-detail?id=' . $product['id']) ?>" class="space-y-8">
                    <input type="hidden" name="csrf_token" value="<?= RentEase\Support\Csrf::token() ?>">
                    <input type="hidden" name="rent_now" value="1">
                    
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-sm font-black text-primary uppercase tracking-widest">Select Tenure</h3>
                            <span class="text-xs text-secondary font-bold bg-secondary/10 px-2 py-0.5 rounded">Up to 15% Off</span>
                        </div>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="cursor-pointer group">
                                <input class="peer sr-only" name="tenure" type="radio" value="3" checked onchange="updatePrice(1)"/>
                                <div class="py-4 px-2 rounded-2xl border-2 border-slate-100 text-center transition-all group-hover:border-slate-200 peer-checked:border-secondary peer-checked:bg-secondary/5 peer-checked:text-secondary">
                                    <p class="text-lg font-black tracking-tighter">3</p>
                                    <p class="text-[10px] font-bold uppercase opacity-60">Months</p>
                                </div>
                            </label>
                            <label class="cursor-pointer group">
                                <input class="peer sr-only" name="tenure" type="radio" value="6" onchange="updatePrice(0.95)"/>
                                <div class="py-4 px-2 rounded-2xl border-2 border-slate-100 text-center transition-all group-hover:border-slate-200 peer-checked:border-secondary peer-checked:bg-secondary/5 peer-checked:text-secondary relative overflow-hidden">
                                    <p class="text-lg font-black tracking-tighter">6</p>
                                    <p class="text-[10px] font-bold uppercase opacity-60">Months</p>
                                    <div class="absolute top-0 right-0 bg-secondary text-white text-[8px] font-black px-1.5 py-0.5 rounded-bl-lg">5% OFF</div>
                                </div>
                            </label>
                            <label class="cursor-pointer group">
                                <input class="peer sr-only" name="tenure" type="radio" value="12" onchange="updatePrice(0.85)"/>
                                <div class="py-4 px-2 rounded-2xl border-2 border-slate-100 text-center transition-all group-hover:border-slate-200 peer-checked:border-secondary peer-checked:bg-secondary/5 peer-checked:text-secondary relative overflow-hidden">
                                    <p class="text-lg font-black tracking-tighter">12</p>
                                    <p class="text-[10px] font-bold uppercase opacity-60">Months</p>
                                    <div class="absolute top-0 right-0 bg-secondary text-white text-[8px] font-black px-1.5 py-0.5 rounded-bl-lg">15% OFF</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <button type="submit" class="w-full py-5 bg-primary hover:bg-slate-800 text-white font-black rounded-2xl shadow-xl shadow-primary/20 transition-all transform hover:-translate-y-1 active:scale-[0.98] flex items-center justify-center gap-3 group">
                            <span class="material-symbols-outlined group-hover:rotate-12 transition-transform">shopping_cart</span>
                            Reserve for Rental
                        </button>
                        
                        <div class="relative group">
                            <input class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-4 pl-12 pr-4 text-sm font-medium focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all placeholder:text-slate-400" placeholder="Check delivery availability..." type="text"/>
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">local_shipping</span>
                            <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-secondary text-xs font-black uppercase tracking-widest hover:text-primary transition-colors">Check</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Rental Specs & Benefits -->
            <div class="space-y-4">
                <div class="bg-white border border-outline-variant rounded-2xl overflow-hidden">
                    <button class="w-full p-5 flex items-center justify-between text-left group" onclick="this.nextElementSibling.classList.toggle('hidden')">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                                <span class="material-symbols-outlined !text-xl">description</span>
                            </div>
                            <span class="font-bold text-primary">Specifications</span>
                        </div>
                        <span class="material-symbols-outlined transition-transform group-active:scale-90">expand_more</span>
                    </button>
                    <div class="p-5 pt-0 border-t border-slate-50">
                        <dl class="grid grid-cols-2 gap-4 text-sm">
                            <?php foreach ($specs as $key => $value): ?>
                            <div class="<?= $key === 'Dimensions' ? 'col-span-2' : '' ?>">
                                <dt class="text-slate-400 font-medium"><?= htmlspecialchars($key) ?></dt>
                                <dd class="text-primary font-bold"><?= htmlspecialchars($value) ?></dd>
                            </div>
                            <?php endforeach; ?>
                        </dl>
                    </div>
                </div>

                <div class="bg-white border border-outline-variant rounded-2xl overflow-hidden">
                    <button class="w-full p-5 flex items-center justify-between text-left group" onclick="this.nextElementSibling.classList.toggle('hidden')">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                                <span class="material-symbols-outlined !text-xl">verified</span>
                            </div>
                            <span class="font-bold text-primary">RentEase Promise</span>
                        </div>
                        <span class="material-symbols-outlined transition-transform group-active:scale-90">expand_more</span>
                    </button>
                    <div class="p-5 pt-0 border-t border-slate-50 hidden">
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3 text-sm text-on-surface-variant">
                                <span class="material-symbols-outlined text-teal-500 !text-lg">check_circle</span>
                                Free relocation within the city
                            </li>
                            <li class="flex items-center gap-3 text-sm text-on-surface-variant">
                                <span class="material-symbols-outlined text-teal-500 !text-lg">check_circle</span>
                                Complimentary deep cleaning service
                            </li>
                            <li class="flex items-center gap-3 text-sm text-on-surface-variant">
                                <span class="material-symbols-outlined text-teal-500 !text-lg">check_circle</span>
                                Professional maintenance & support
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products Placeholder -->
    <section class="mt-24 pt-24 border-t border-outline-variant" id="related-products">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl font-black text-primary tracking-tighter mb-2">Pairs well with</h2>
                <p class="text-on-surface-variant">Complete your room with these hand-picked items.</p>
            </div>
            <a href="<?= baseUrl('/browse') ?>" class="text-sm font-black text-secondary uppercase tracking-widest hover:underline underline-offset-8">Explore Catalog</a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <?php if (empty($relatedProducts)): ?>
                <?php for($i=1; $i<=4; $i++): ?>
                    <div class="group">
                        <div class="aspect-[4/5] rounded-3xl overflow-hidden bg-slate-50 border border-outline-variant mb-4 flex items-center justify-center">
                            <span class="material-symbols-outlined text-slate-200 text-4xl">inventory_2</span>
                        </div>
                        <div class="h-4 bg-slate-100 rounded w-2/3 mb-2"></div>
                        <div class="h-3 bg-slate-50 rounded w-1/2"></div>
                    </div>
                <?php endfor; ?>
            <?php else: ?>
                <?php foreach($relatedProducts as $related): ?>
                    <a href="<?= baseUrl('/product-detail?id=' . $related['id']) ?>" class="group block">
                        <div class="aspect-[4/5] rounded-3xl overflow-hidden bg-white border border-outline-variant mb-4 relative">
                            <img src="<?= htmlspecialchars($related['image_url'] ?? 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&q=80') ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="<?= htmlspecialchars($related['name']) ?>">
                            <div class="absolute inset-0 bg-primary/0 group-hover:bg-primary/5 transition-colors"></div>
                        </div>
                        <h3 class="font-bold text-primary mb-1 truncate group-hover:text-secondary transition-colors"><?= htmlspecialchars($related['name']) ?></h3>
                        <p class="text-sm text-on-surface-variant font-bold">$<?= number_format((float)$related['monthly_price'], 0) ?> <span class="font-medium opacity-60">/ month</span></p>
                    </a>
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
        
        // Smooth count animation
        gsap.to(display, {
            innerText: Math.round(newPrice),
            duration: 0.5,
            snap: { innerText: 1 },
            onUpdate: function() {
                display.innerHTML = '$' + display.innerText;
            }
        });
    }

    // GSAP Entrance Animations
    window.addEventListener('load', () => {
        // Image error handling
        document.querySelectorAll('img').forEach(img => {
            img.addEventListener('error', function() {
                this.src = 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&q=80';
                this.style.opacity = '0.5'; // Subtle indicator
            });
        });

        const tl = gsap.timeline({ defaults: { ease: 'power4.out', duration: 1.2 } });

        tl.from('#breadcrumbs', { opacity: 0, y: -10, duration: 0.8 })
          .from('#gallery-container > div > div', { 
              opacity: 0, 
              scale: 0.95, 
              stagger: 0.2,
              duration: 1
          }, '-=0.4')
          .from('#details-container > *', {
              opacity: 0,
              y: 20,
              stagger: 0.1,
              duration: 0.8
          }, '-=1')
          .from('#related-products', {
              opacity: 0,
              y: 40,
              scrollTrigger: {
                  trigger: '#related-products',
                  start: 'top 80%'
              }
          });
    });
</script>

<?php require __DIR__ . '/partials/footer.php'; ?>

