<?php
declare(strict_types=1);

use RentEase\Services\ProductService;
use RentEase\Services\AuthService;

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
                class="bg-primary text-on-primary font-button text-button px-6 py-3 rounded-DEFAULT hover:bg-opacity-90 transition-all ambient-shadow-low hover:ambient-shadow-high">Explore
                Catalog</a>
            <a href="<?= baseUrl('/shop') ?>"
                class="border border-secondary text-secondary font-button text-button px-6 py-3 rounded-DEFAULT hover:bg-surface-container transition-all">View
                Packages</a>
        </div>
    </div>
    <div class="w-full md:w-1/2 relative h-[400px] md:h-[500px] rounded-xl overflow-hidden ambient-shadow-low">
        <img alt="Hero Image" class="w-full h-full object-cover"
            src="https://images.unsplash.com/photo-1540518614846-7eded433c457?q=80&w=1000&auto=format&fit=crop" />
        <div class="absolute inset-0 bg-gradient-to-t from-primary/20 to-transparent"></div>
    </div>
</section>

<!-- Error Message -->
<?php if ($error): ?>
    <section class="max-w-container-max mx-auto px-4 md:px-8 py-4">
        <div class="bg-error-container text-on-error-container p-4 rounded-lg flex items-center gap-3">
            <span class="material-symbols-outlined">error</span>
            <p><?= htmlspecialchars($error) ?></p>
        </div>
    </section>
<?php endif; ?>

<!-- Product Categories (Bento Grid) -->
<section class="w-full max-w-container-max mx-auto px-4 md:px-8 py-xl">
    <div class="flex justify-between items-end mb-lg">
        <h2 class="font-h2 text-h2 text-primary">Shop by Category</h2>
        <a class="font-button text-button text-secondary flex items-center gap-xs hover:underline"
            href="<?= baseUrl('/shop') ?>">View All <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-gutter auto-rows-[250px]">
        <!-- Living Room -->
        <a class="group relative rounded-xl overflow-hidden ambient-shadow-low hover:ambient-shadow-high transition-all md:col-span-2 lg:col-span-2 row-span-2"
            href="<?= baseUrl('/shop?category=Furniture') ?>">
            <img alt="Living Room"
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
        <a class="group relative rounded-xl overflow-hidden ambient-shadow-low hover:ambient-shadow-high transition-all md:col-span-1 lg:col-span-1 row-span-1"
            href="<?= baseUrl('/shop?category=Bedroom') ?>">
            <img alt="Bedroom"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                src="https://images.unsplash.com/photo-1505691723518-36a5ac3be353?q=80&w=1000&auto=format&fit=crop" />
            <div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent"></div>
            <div class="absolute bottom-0 left-0 p-md w-full">
                <h3 class="font-body-lg text-body-lg font-semibold text-on-primary">Bedroom</h3>
            </div>
        </a>
        <!-- Kitchen / Appliances -->
        <a class="group relative rounded-xl overflow-hidden ambient-shadow-low hover:ambient-shadow-high transition-all md:col-span-1 lg:col-span-1 row-span-1"
            href="<?= baseUrl('/shop?category=Appliances') ?>">
            <img alt="Kitchen"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                src="https://images.unsplash.com/photo-1556911220-e15b29be8c8f?q=80&w=1000&auto=format&fit=crop" />
            <div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent"></div>
            <div class="absolute bottom-0 left-0 p-md w-full">
                <h3 class="font-body-lg text-body-lg font-semibold text-on-primary">Kitchen &amp; Appliances</h3>
            </div>
        </a>
        <!-- Home Office -->
        <a class="group relative rounded-xl overflow-hidden ambient-shadow-low hover:ambient-shadow-high transition-all md:col-span-2 lg:col-span-2 row-span-1"
            href="<?= baseUrl('/shop?category=Office') ?>">
            <img alt="Home Office"
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
                class="flex flex-col items-center text-center p-md bg-surface rounded-xl ambient-shadow-low relative overflow-hidden">
                <div
                    class="w-16 h-16 bg-surface-variant rounded-full flex items-center justify-center mb-sm text-secondary">
                    <span class="material-symbols-outlined text-3xl"
                        style="font-variation-settings: 'FILL' 1;">touch_app</span>
                </div>
                <h3 class="font-h3 text-h3 text-primary mb-2">1. Choose</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Browse our curated catalog of premium
                    furniture and high-end appliances to fit your space.</p>
                <span
                    class="absolute -bottom-4 -right-4 text-9xl font-black text-surface-container opacity-50 select-none">1</span>
            </div>
            <div
                class="flex flex-col items-center text-center p-md bg-surface rounded-xl ambient-shadow-low relative overflow-hidden">
                <div
                    class="w-16 h-16 bg-surface-variant rounded-full flex items-center justify-center mb-sm text-secondary">
                    <span class="material-symbols-outlined text-3xl"
                        style="font-variation-settings: 'FILL' 1;">calendar_month</span>
                </div>
                <h3 class="font-h3 text-h3 text-primary mb-2">2. Schedule</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Select your rental term (3, 6, or 12
                    months) and pick a convenient delivery date.</p>
                <span
                    class="absolute -bottom-4 -right-4 text-9xl font-black text-surface-container opacity-50 select-none">2</span>
            </div>
            <div
                class="flex flex-col items-center text-center p-md bg-surface rounded-xl ambient-shadow-low relative overflow-hidden">
                <div
                    class="w-16 h-16 bg-surface-variant rounded-full flex items-center justify-center mb-sm text-secondary">
                    <span class="material-symbols-outlined text-3xl"
                        style="font-variation-settings: 'FILL' 1;">chair</span>
                </div>
                <h3 class="font-h3 text-h3 text-primary mb-2">3. Enjoy</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">We deliver and assemble. When your term is
                    up, extend, swap, or return with zero hassle.</p>
                <span
                    class="absolute -bottom-4 -right-4 text-9xl font-black text-surface-container opacity-50 select-none">3</span>
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
                <div
                    class="bg-surface rounded-lg ambient-shadow-low hover:ambient-shadow-high transition-shadow p-xs flex flex-col h-full border border-outline-variant">
                    <a href="<?= baseUrl('/product-detail?id=' . $product['id']) ?>"
                        class="relative w-full aspect-square rounded-DEFAULT overflow-hidden bg-surface-container-lowest mb-sm group">
                        <img alt="<?= htmlspecialchars($product['name']) ?>"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            src="<?= htmlspecialchars($product['image_url'] ?? 'https://via.placeholder.com/400x300?text=No+Image') ?>"
                            loading="lazy" />
                        <?php if ($product['category'] === 'Appliances'): ?>
                            <div
                                class="absolute top-2 left-2 bg-secondary-container text-on-secondary-container font-label-caps text-label-caps px-2 py-1 rounded-sm uppercase">
                                Fast Delivery</div>
                        <?php endif; ?>
                    </a>
                    <div class="flex-grow px-2">
                        <a href="<?= baseUrl('/product-detail?id=' . $product['id']) ?>">
                            <h3 class="font-body-lg text-body-lg font-medium text-primary line-clamp-1">
                                <?= htmlspecialchars($product['name']) ?>
                            </h3>
                        </a>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 line-clamp-2">
                            <?= htmlspecialchars($product['category']) ?> - Premium quality for your home.
                        </p>
                    </div>
                    <div class="px-2 pb-2 pt-4 flex items-center justify-between border-t border-outline-variant mt-sm">
                        <div>
                            <span
                                class="font-h3 text-h3 text-primary font-bold">$<?= number_format($product['monthly_price'], 0) ?></span>
                            <span class="font-body-sm text-body-sm text-on-surface-variant">/mo</span>
                        </div>
                        <form method="POST" action="<?= baseUrl('/cart') ?>">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" aria-label="Add to cart"
                                class="bg-secondary text-on-secondary w-10 h-10 rounded-full flex items-center justify-center hover:bg-opacity-90 transition-colors">
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">add</span>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>