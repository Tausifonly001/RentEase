<?php 
$pageTitle = 'RentEase - Browse Premium Rentals';
$pageDescription = 'Explore our catalog of premium furniture and appliances with flexible monthly plans. Free delivery and easy returns.';
require __DIR__ . '/../../public/partials/header.php'; 
?>

<!-- Main Content Area -->
<main class="flex-grow w-full max-w-container-max mx-auto px-4 md:px-8 py-lg mb-xl">
    <!-- Breadcrumbs -->
    <nav aria-label="Breadcrumb" class="flex text-on-surface-variant font-body-sm text-body-sm mb-lg">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a class="inline-flex items-center hover:text-secondary transition-colors" href="<?= baseUrl('/') ?>">
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-[16px] mx-1">chevron_right</span>
                    <a class="hover:text-secondary transition-colors" href="<?= baseUrl('/browse') ?>">Rentals</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-[16px] mx-1">chevron_right</span>
                    <span
                        class="text-on-surface font-medium"><?= $category ? htmlspecialchars($category) : 'All Products' ?></span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="flex flex-col md:flex-row gap-gutter">
        <!-- Sidebar Filters -->
        <aside class="w-full md:w-64 flex-shrink-0">
            <div class="bg-surface rounded-lg border border-outline-variant p-sm sticky top-24">
                <h2 class="font-h3 text-h3 text-on-surface mb-md">Filters</h2>
                <!-- Category Filter -->
                <div class="mb-md">
                    <h3 class="font-button text-button text-on-surface mb-xs">Category</h3>
                    <div class="flex flex-col gap-2">
                        <a href="<?= baseUrl('/browse') ?>" class="flex items-center gap-3 group">
                            <div
                                class="w-5 h-5 rounded border border-outline-variant flex items-center justify-center group-hover:border-secondary transition-colors <?= $category === null ? 'bg-secondary border-secondary' : '' ?>">
                                <?php if ($category === null): ?>
                                    <span class="material-symbols-outlined text-on-secondary text-sm">check</span>
                                <?php endif; ?>
                            </div>
                            <span
                                class="font-body-sm text-body-sm transition-colors <?= $category === null ? 'text-on-surface font-semibold' : 'text-on-surface-variant group-hover:text-on-surface' ?>">All
                                Items</span>
                        </a>
                        <a href="<?= baseUrl('/browse?category=Furniture') ?>" class="flex items-center gap-3 group">
                            <div
                                class="w-5 h-5 rounded border border-outline-variant flex items-center justify-center group-hover:border-secondary transition-colors <?= $category === 'Furniture' ? 'bg-secondary border-secondary' : '' ?>">
                                <?php if ($category === 'Furniture'): ?>
                                    <span class="material-symbols-outlined text-on-secondary text-sm">check</span>
                                <?php endif; ?>
                            </div>
                            <span
                                class="font-body-sm text-body-sm transition-colors <?= $category === 'Furniture' ? 'text-on-surface font-semibold' : 'text-on-surface-variant group-hover:text-on-surface' ?>">Furniture</span>
                        </a>
                        <a href="<?= baseUrl('/browse?category=Appliances') ?>" class="flex items-center gap-3 group">
                            <div
                                class="w-5 h-5 rounded border border-outline-variant flex items-center justify-center group-hover:border-secondary transition-colors <?= $category === 'Appliances' ? 'bg-secondary border-secondary' : '' ?>">
                                <?php if ($category === 'Appliances'): ?>
                                    <span class="material-symbols-outlined text-on-secondary text-sm">check</span>
                                <?php endif; ?>
                            </div>
                            <span
                                class="font-body-sm text-body-sm transition-colors <?= $category === 'Appliances' ? 'text-on-surface font-semibold' : 'text-on-surface-variant group-hover:text-on-surface' ?>">Appliances</span>
                        </a>
                    </div>
                </div>

                <!-- Quick Perks -->
                <div class="border-t border-outline-variant pt-md">
                    <h3 class="font-button text-button text-on-surface mb-xs">Tenure Options</h3>
                    <div class="grid grid-cols-3 gap-2">
                        <button
                            class="px-2 py-1 border border-secondary text-secondary rounded font-label-caps text-label-caps hover:bg-secondary hover:text-on-secondary transition-colors">3
                            Mo</button>
                        <button
                            class="px-2 py-1 border border-outline-variant text-on-surface-variant rounded font-label-caps text-label-caps hover:border-secondary hover:text-secondary transition-colors">6
                            Mo</button>
                        <button
                            class="px-2 py-1 border border-outline-variant text-on-surface-variant rounded font-label-caps text-label-caps hover:border-secondary hover:text-secondary transition-colors">12
                            Mo</button>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Product Grid -->
        <div class="flex-grow">
            <!-- Toolbar -->
            <div class="flex justify-between items-center mb-lg">
                <span class="font-body-sm text-body-sm text-on-surface-variant"><?= count($products) ?> items
                    found</span>
                <div class="flex items-center gap-2">
                    <span class="font-body-sm text-body-sm text-on-surface-variant">Sort by:</span>
                    <select
                        class="form-select font-body-sm text-body-sm border-outline-variant rounded-DEFAULT py-1 pl-2 pr-8 focus:ring-secondary focus:border-secondary text-on-surface bg-surface">
                        <option>Recommended</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Newest Arrivals</option>
                    </select>
                </div>
            </div>

            <?php if ($error): ?>
                <div class="bg-error-container text-on-error-container p-4 rounded-lg flex items-center gap-3">
                    <span class="material-symbols-outlined">error</span>
                    <p><?= htmlspecialchars($error) ?></p>
                </div>
            <?php elseif (empty($products)): ?>
                <div
                    class="py-16 text-center text-on-surface-variant border border-dashed border-outline-variant rounded-xl bg-surface">
                    <span class="material-symbols-outlined text-4xl mb-4">inventory_2</span>
                    <h3 class="font-h3 text-xl mb-2 text-on-surface">No items found</h3>
                    <p>We couldn't find any products in this category.</p>
                </div>
            <?php else: ?>
                <!-- Grid -->
                <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-gutter">
                    <?php foreach ($products as $product): ?>
                        <div class="product-card flex flex-col bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-[0_2px_12px_rgba(4,22,39,0.03)] relative cursor-pointer" style="visibility: hidden;">
                            <!-- Image Area -->
                            <div class="relative aspect-square overflow-hidden bg-[#F8F9FA] flex items-center justify-center p-6 group/img" onclick="window.location.href='<?= baseUrl('/product-detail?id=' . $product['id']) ?>'">
                                <img alt="<?= htmlspecialchars($product['name']) ?>"
                                    class="product-img w-full h-full object-contain mix-blend-multiply"
                                    src="<?= htmlspecialchars($product['image_url'] ?? 'https://via.placeholder.com/400x400?text=No+Image') ?>"
                                    loading="lazy" />
                                
                                <!-- Badges -->
                                <div class="absolute top-3 left-3 flex flex-col gap-2 items-start z-10">
                                    <?php if ($product['category'] === 'Appliances'): ?>
                                        <span class="px-2.5 py-1 bg-white/90 backdrop-blur-sm text-slate-900 text-[9px] font-bold uppercase tracking-wider rounded-full shadow-sm">Fast Delivery</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Wishlist Button - Floating top right -->
                            <form method="POST" class="absolute top-3 right-3 z-20">
                                <input type="hidden" name="csrf_token" value="<?= RentEase\Support\Csrf::token() ?>">
                                <input type="hidden" name="toggle_wishlist" value="1">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <?php $isInWishlist = in_array((int) $product['id'], $wishlistIds); ?>
                                <button type="submit"
                                    class="wishlist-btn h-8 w-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-sm <?= $isInWishlist ? 'text-red-500' : 'text-slate-400' ?>">
                                    <span class="material-symbols-outlined !text-[18px] <?= $isInWishlist ? 'heart-beat' : '' ?>"
                                        style="font-variation-settings: 'FILL' <?= $isInWishlist ? '1' : '0' ?>;">favorite</span>
                                </button>
                            </form>

                            <!-- Content Area -->
                            <div class="p-5 flex flex-col flex-grow bg-white z-10 relative border-t border-slate-50">
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1.5"><?= htmlspecialchars($product['category']) ?></p>
                                <a href="<?= baseUrl('/product-detail?id=' . $product['id']) ?>" class="mb-4">
                                    <h3 class="product-title font-bold text-[16px] text-slate-900 leading-snug line-clamp-2">
                                        <?= htmlspecialchars($product['name']) ?>
                                    </h3>
                                </a>
                                
                                <div class="mt-auto flex items-end justify-between pt-1">
                                    <div>
                                        <p class="text-[10px] font-medium text-slate-500 mb-0.5">Starting at</p>
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-xl font-black text-slate-900 tracking-tight">$<?= number_format($product['monthly_price'] ?? 0, 0) ?></span>
                                            <span class="text-xs text-slate-400 font-medium">/mo</span>
                                        </div>
                                    </div>
                                    
                                    <form method="POST" action="<?= baseUrl('/cart') ?>" class="z-20">
                                        <input type="hidden" name="action" value="add">
                                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                            class="add-to-cart-btn h-10 w-10 rounded-full bg-slate-900 text-white flex items-center justify-center shadow-md">
                                            <span class="material-symbols-outlined !text-[18px]">add_shopping_cart</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<style>
@keyframes heartbeat {
    0%, 100% { transform: scale(1); }
    25% { transform: scale(1.1); }
    50% { transform: scale(1); }
    75% { transform: scale(1.1); }
}
.heart-beat { animation: heartbeat 1s ease-in-out; }

/* Fallback: if GSAP fails to load after 2s, show everything */
.no-js .product-card, .gsap-failed .product-card {
    visibility: visible !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    
    // Safety fallback
    const fallbackTimer = setTimeout(() => {
        if (!window.gsap) {
            document.body.classList.add('gsap-failed');
        }
    }, 2000);

    const checkGsap = setInterval(() => {
        if (window.gsap) {
            clearInterval(checkGsap);
            clearTimeout(fallbackTimer);
            initBrowseAnimations();
        }
    }, 50);

    function initBrowseAnimations() {
        const ctx = gsap.context(() => {
            
            // Make cards visible for GSAP
            gsap.set('.product-card', { visibility: 'visible' });

            const tl = gsap.timeline();
            
            // Sidebar slide-in
            tl.from('aside', {
                opacity: 0,
                x: -30,
                duration: 0.8,
                ease: 'power3.out'
            });

            // Grid Cards stagger
            tl.from('.product-card', {
                opacity: 0,
                y: 40,
                scale: 0.95,
                stagger: 0.1,
                duration: 0.8,
                ease: 'back.out(1.2)'
            }, '-=0.4');

            // Dynamic Hover Interactions
            document.querySelectorAll('.product-card').forEach(card => {
                const img = card.querySelector('.product-img');
                const overlay = card.querySelector('.product-overlay');
                const btn = card.querySelector('.add-to-cart-btn');
                const title = card.querySelector('.product-title');
                const wishlistBtn = card.querySelector('.wishlist-btn');

                card.addEventListener('mouseenter', () => {
                    gsap.to(card, { y: -6, boxShadow: '0 20px 40px -12px rgba(4,22,39,0.08)', duration: 0.4, ease: 'power2.out' });
                    gsap.to(img, { scale: 1.05, duration: 0.6, ease: 'power2.out' });
                    gsap.to(title, { color: '#006a65', duration: 0.3 }); // secondary color
                    gsap.to(btn, { backgroundColor: '#006a65', scale: 1.1, rotation: 12, duration: 0.4, ease: 'back.out(2)' });
                    gsap.to(wishlistBtn, { scale: 1.1, duration: 0.3, ease: 'back.out(2)' });
                });

                card.addEventListener('mouseleave', () => {
                    gsap.to(card, { y: 0, boxShadow: '0 2px 12px rgba(4,22,39,0.03)', duration: 0.4, ease: 'power2.out' });
                    gsap.to(img, { scale: 1, duration: 0.6, ease: 'power2.out' });
                    gsap.to(title, { color: '#0b1c30', duration: 0.3 }); // on-surface
                    gsap.to(btn, { backgroundColor: '#0f172a', scale: 1, rotation: 0, duration: 0.4, ease: 'power2.out' }); // slate-900
                    gsap.to(wishlistBtn, { scale: 1, duration: 0.3, ease: 'power2.out' });
                });
            });

        });
    }
});
</script>

<?php require __DIR__ . '/../../public/partials/footer.php'; ?>