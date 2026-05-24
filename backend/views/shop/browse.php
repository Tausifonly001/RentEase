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
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-gutter">
                    <?php foreach ($products as $product): ?>
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

                            <!-- Wishlist Button - Floating -->
                            <form method="POST" class="absolute top-4 right-4 z-10">
                                <input type="hidden" name="csrf_token" value="<?= RentEase\Support\Csrf::token() ?>">
                                <input type="hidden" name="toggle_wishlist" value="1">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <?php $isInWishlist = in_array((int) $product['id'], $wishlistIds); ?>
                                <button type="submit"
                                    class="h-10 w-10 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center transition-all hover:scale-110 active:scale-95 shadow-sm <?= $isInWishlist ? 'text-red-500' : 'text-slate-400 hover:text-red-500' ?>">
                                    <span class="material-symbols-outlined !text-xl"
                                        style="font-variation-settings: 'FILL' <?= $isInWishlist ? '1' : '0' ?>;">favorite</span>
                                </button>
                            </form>

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
                                        <input type="hidden" name="action" value="add">
                                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                            class="h-12 w-12 rounded-2xl bg-slate-50 text-slate-600 flex items-center justify-center group-hover:bg-teal-600 group-hover:text-white transition-colors duration-300 transform group-hover:rotate-12 active:scale-90">
                                            <span class="material-symbols-outlined !text-xl">shopping_bag</span>
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

<?php require __DIR__ . '/../../public/partials/footer.php'; ?>