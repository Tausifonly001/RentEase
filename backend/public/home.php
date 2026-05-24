<?php
declare(strict_types=1);

use RentEase\Services\ProductService;
use RentEase\Services\AuthService;
use RentEase\Support\Csrf;

require __DIR__ . '/../bootstrap.php';

$productService = new ProductService($config);
$furniture = [];
$appliances = [];
$error = null;

try {
    $furniture = $productService->catalog(1, 4, 'Furniture');
    $appliances = $productService->catalog(1, 4, 'Appliances');
} catch (Throwable $e) {
    $error = 'Unable to load products at this time.';
}

$pageTitle = 'RentEase — Premium Furniture & Appliance Rentals';
$pageDescription = 'Transform your space without commitment. Rent premium furniture and appliances with flexible monthly plans, free delivery, and easy returns.';
require __DIR__ . '/partials/header.php';
?>

<!-- Main Content Canvas -->
<main class="flex-grow pb-24 md:pb-0">

<!-- Hero Section -->
<section
    class="relative w-full max-w-container-max mx-auto px-4 md:px-8 py-xl lg:py-20 flex flex-col md:flex-row items-center gap-lg">
    <div class="w-full md:w-1/2 flex flex-col gap-md z-10">
        <h1 class="font-h1 text-h1 text-primary">Premium Furniture &amp; Appliances, on Your Terms.</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-lg">Transform your space without the
            commitment. Flexible monthly rentals for high-quality pieces, delivered and assembled for you.</p>
        <div class="flex flex-wrap gap-sm mt-xs">
            <a href="<?= baseUrl('/shop') ?>"
                class="bg-primary text-on-primary font-button text-button px-6 py-3 rounded-DEFAULT hover:bg-opacity-90 transition-all shadow-ambient-low hover:shadow-ambient-high focus-visible:ring-2 ring-teal-500 outline-none">Explore
                Catalog</a>
            <a href="<?= baseUrl('/shop') ?>"
                class="border border-secondary text-secondary font-button text-button px-6 py-3 rounded-DEFAULT hover:bg-surface-container transition-all focus-visible:ring-2 ring-teal-500 outline-none">View
                Packages</a>
        </div>
    </div>
    <div class="w-full md:w-1/2 relative h-[400px] md:h-[500px] rounded-xl overflow-hidden shadow-ambient-low">
        <img alt="Modern living room with premium furniture" class="w-full h-full object-cover" fetchpriority="high"
            src="https://images.unsplash.com/photo-1540518614846-7eded433c457?q=80&w=1000&auto=format&fit=crop" />
        <div class="absolute inset-0 bg-gradient-to-t from-primary/20 to-transparent"></div>
    </div>
</section>

<!-- Error Message -->
<?php if ($error): ?>
    <section class="max-w-container-max mx-auto px-4 md:px-8 py-4">
        <div class="bg-error-container text-on-error-container p-4 rounded-lg flex items-center gap-3">
            <span class="material-symbols-outlined" aria-hidden="true">error</span>
            <p><?= htmlspecialchars($error) ?></p>
        </div>
    </section>
<?php endif; ?>

<!-- Product Categories (Bento Grid) -->
<section class="w-full max-w-container-max mx-auto px-4 md:px-8 py-xl">
    <div class="flex justify-between items-end mb-lg">
        <h2 class="font-h2 text-h2 text-primary">Shop by Category</h2>
        <a class="font-button text-button text-secondary flex items-center gap-xs hover:underline focus-visible:ring-2 ring-teal-500 rounded outline-none"
            href="<?= baseUrl('/shop') ?>">View All <span class="material-symbols-outlined text-sm" aria-hidden="true">arrow_forward</span></a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-gutter auto-rows-[250px]">
        <!-- Living Room -->
        <a class="group relative rounded-xl overflow-hidden shadow-ambient-low hover:shadow-ambient-high transition-all md:col-span-2 lg:col-span-2 row-span-2 focus-visible:ring-2 ring-teal-500 outline-none"
            href="<?= baseUrl('/shop?category=Furniture') ?>">
            <img alt="Elegant living room furniture"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?q=80&w=1000&auto=format&fit=crop" />
            <div class="absolute inset-0 bg-gradient-to-t from-primary/60 via-primary/10 to-transparent"></div>
            <div class="absolute bottom-0 left-0 p-lg w-full">
                <h3 class="font-h3 text-h3 text-on-primary">Living Room</h3>
                <p
                    class="font-body-sm text-body-sm text-surface-container-high mt-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    Sofas, Tables, TV Stands</p>
            </div>
        </a>
        <!-- Bedroom -->
        <a class="group relative rounded-xl overflow-hidden shadow-ambient-low hover:shadow-ambient-high transition-all md:col-span-1 lg:col-span-1 row-span-1 focus-visible:ring-2 ring-teal-500 outline-none"
            href="<?= baseUrl('/shop?category=Bedroom') ?>">
            <img alt="Comfortable bedroom setup"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                src="https://images.unsplash.com/photo-1505691723518-36a5ac3be353?q=80&w=1000&auto=format&fit=crop" />
            <div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent"></div>
            <div class="absolute bottom-0 left-0 p-md w-full">
                <h3 class="font-body-lg text-body-lg font-semibold text-on-primary">Bedroom</h3>
            </div>
        </a>
        <!-- Kitchen / Appliances -->
        <a class="group relative rounded-xl overflow-hidden shadow-ambient-low hover:shadow-ambient-high transition-all md:col-span-1 lg:col-span-1 row-span-1 focus-visible:ring-2 ring-teal-500 outline-none"
            href="<?= baseUrl('/shop?category=Appliances') ?>">
            <img alt="Modern kitchen appliances"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                src="https://images.unsplash.com/photo-1556911220-e15b29be8c8f?q=80&w=1000&auto=format&fit=crop" />
            <div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent"></div>
            <div class="absolute bottom-0 left-0 p-md w-full">
                <h3 class="font-body-lg text-body-lg font-semibold text-on-primary">Kitchen &amp; Appliances</h3>
            </div>
        </a>
        <!-- Home Office -->
        <a class="group relative rounded-xl overflow-hidden shadow-ambient-low hover:shadow-ambient-high transition-all md:col-span-2 lg:col-span-2 row-span-1 focus-visible:ring-2 ring-teal-500 outline-none"
            href="<?= baseUrl('/shop?category=Office') ?>">
            <img alt="Productive home office space"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?q=80&w=1000&auto=format&fit=crop" />
            <div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent"></div>
            <div class="absolute bottom-0 left-0 p-md w-full">
                <h3 class="font-body-lg text-body-lg font-semibold text-on-primary">Home Office</h3>
            </div>
        </a>
    </div>
</section>

<!-- How it Works -->
<section class="w-full bg-surface-container-low py-xl">
    <div class="max-w-container-max mx-auto px-4 md:px-8">
        <div class="text-center mb-lg">
            <h2 class="font-h2 text-h2 text-primary">How it Works</h2>
            <p class="font-body-md text-body-md text-on-surface-variant mt-2">Simple, flexible, and entirely on your
                terms.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-lg">
            <div
                class="flex flex-col items-center text-center p-md bg-surface rounded-xl shadow-ambient-low relative overflow-hidden">
                <div
                    class="w-16 h-16 bg-surface-variant rounded-full flex items-center justify-center mb-sm text-secondary">
                    <span class="material-symbols-outlined text-3xl" aria-hidden="true"
                        style="font-variation-settings: 'FILL' 1;">touch_app</span>
                </div>
                <h3 class="font-h3 text-h3 text-primary mb-2">1. Choose</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Browse our curated catalog of premium
                    furniture and high-end appliances to fit your space.</p>
                <span
                    class="absolute -bottom-4 -right-4 text-9xl font-black text-surface-container opacity-50 select-none" aria-hidden="true">1</span>
            </div>
            <div
                class="flex flex-col items-center text-center p-md bg-surface rounded-xl shadow-ambient-low relative overflow-hidden">
                <div
                    class="w-16 h-16 bg-surface-variant rounded-full flex items-center justify-center mb-sm text-secondary">
                    <span class="material-symbols-outlined text-3xl" aria-hidden="true"
                        style="font-variation-settings: 'FILL' 1;">calendar_month</span>
                </div>
                <h3 class="font-h3 text-h3 text-primary mb-2">2. Schedule</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Select your rental term (3, 6, or 12
                    months) and pick a convenient delivery date.</p>
                <span
                    class="absolute -bottom-4 -right-4 text-9xl font-black text-surface-container opacity-50 select-none" aria-hidden="true">2</span>
            </div>
            <div
                class="flex flex-col items-center text-center p-md bg-surface rounded-xl shadow-ambient-low relative overflow-hidden">
                <div
                    class="w-16 h-16 bg-surface-variant rounded-full flex items-center justify-center mb-sm text-secondary">
                    <span class="material-symbols-outlined text-3xl" aria-hidden="true"
                        style="font-variation-settings: 'FILL' 1;">chair</span>
                </div>
                <h3 class="font-h3 text-h3 text-primary mb-2">3. Enjoy</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">We deliver and assemble. When your term is
                    up, extend, swap, or return with zero hassle.</p>
                <span
                    class="absolute -bottom-4 -right-4 text-9xl font-black text-surface-container opacity-50 select-none" aria-hidden="true">3</span>
            </div>
        </div>
    </div>
</section>

<!-- Featured Rentals -->
<section class="w-full max-w-container-max mx-auto px-4 md:px-8 py-xl">
    <div class="flex justify-between items-end mb-lg">
        <h2 class="font-h2 text-h2 text-primary">Featured Rentals</h2>
        <a class="font-button text-button text-secondary flex items-center gap-xs hover:underline"
            href="<?= baseUrl('/shop') ?>">View All <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
        <?php
        $allProducts = array_merge($furniture, $appliances);
        if (empty($allProducts)): ?>
            <p class="text-on-surface-variant py-8 col-span-full text-center">No featured products available.</p>
        <?php else: ?>
            <?php foreach (array_slice($allProducts, 0, 8) as $product): ?>
                    <div class="group flex flex-col bg-white border border-slate-100 rounded-3xl overflow-hidden hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.05)] hover:-translate-y-1 transition-all duration-500 relative">
                        <!-- Image Area -->
                        <a href="<?= baseUrl('/product-detail?id=' . $product['id']) ?>" class="relative aspect-[4/3] overflow-hidden bg-slate-50 block">
                            <img alt="<?= htmlspecialchars($product['name']) ?>"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                src="<?= htmlspecialchars($product['image_url'] ?? 'https://via.placeholder.com/400x300?text=No+Image') ?>"
                                loading="lazy" />
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex flex-col gap-2 items-start">
                                <?php if ($product['category'] === 'Appliances'): ?>
                                    <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-primary text-[10px] font-black uppercase tracking-widest rounded-full shadow-sm">Fast Delivery</span>
                                <?php endif; ?>
                            </div>
                        </a>

                        <!-- Content Area -->
                        <div class="p-6 flex flex-col flex-grow bg-white z-10 relative">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2"><?= htmlspecialchars($product['category']) ?></p>
                            <a href="<?= baseUrl('/product-detail?id=' . $product['id']) ?>" class="mb-4">
                                <h3 class="font-bold text-xl text-slate-900 leading-tight group-hover:text-teal-600 transition-colors line-clamp-2">
                                    <?= htmlspecialchars($product['name']) ?>
                                </h3>
                            </a>
                            
                            <div class="mt-auto flex items-end justify-between border-t border-slate-100 pt-4">
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Monthly</p>
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-2xl font-black text-slate-900 tracking-tighter">$<?= number_format($product['monthly_price'] ?? 0, 0) ?></span>
                                    </div>
                                </div>
                                
                                <form method="POST" action="<?= baseUrl('/cart') ?>">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
                                    <input type="hidden" name="action" value="add">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" aria-label="Add to cart"
                                        class="h-12 w-12 rounded-2xl bg-slate-50 text-slate-600 flex items-center justify-center group-hover:bg-teal-600 group-hover:text-white transition-colors duration-300 transform group-hover:rotate-12 active:scale-90">
                                        <span class="material-symbols-outlined !text-xl">shopping_bag</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>