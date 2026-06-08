<?php if ($error): ?>
    <div class="p-8 border border-border text-muted text-sm text-center bg-surface">
        <span class="material-symbols-outlined font-light mb-2">error</span>
        <p class="font-light text-sm"><?= htmlspecialchars($error) ?></p>
    </div>
<?php elseif (empty($products)): ?>
    <div class="py-32 text-center border border-border bg-surface">
        <span class="material-symbols-outlined text-4xl text-muted-light mb-4">inventory_2</span>
        <h3 class="text-2xl font-serif font-medium text-ink mb-2">No pieces found</h3>
        <p class="text-muted font-light">We couldn't find any products matching your filters.</p>
    </div>
<?php else: ?>
    <!-- Grid -->
    <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-20">
        <?php foreach ($products as $product): ?>
            <div class="product-card group relative w-full outline-none focus-visible:ring-1 ring-champagne p-2 -m-2 reveal-fade block">
                
                <div class="aspect-[4/5] bg-surface relative overflow-hidden mb-6">
                    <!-- Image -->
                    <img alt="<?= htmlspecialchars((string)($product['name'] ?? 'Product')) ?>"
                         src="<?= htmlspecialchars((string)($product['image_url'] ?? 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&q=80&w=600')) ?>"
                         class="absolute inset-0 w-full h-full object-cover transition-all duration-1000 group-hover:scale-105 cursor-pointer"
                         onclick="window.location.href='<?= baseUrl('/product-detail?id=' . ($product['id'] ?? 0)) ?>'"
                         loading="lazy"
                         style="filter: grayscale(10%);" />
                    
                    <div class="absolute inset-0 bg-ink/0 group-hover:bg-ink/5 transition-colors duration-700 pointer-events-none"></div>
                    
                    <!-- View Details Hover -->
                    <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-canvas/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none">
                        <span class="text-[11px] font-medium tracking-[0.2em] uppercase text-ink">View Details</span>
                    </div>

                    <!-- Top Bar with Category & Wishlist -->
                    <div class="absolute top-4 left-4 right-4 flex justify-between items-start z-10 pointer-events-none">
                        <span class="bg-surface/80 backdrop-blur-sm border border-border text-ink text-[9px] font-medium tracking-[0.15em] uppercase px-3 py-1.5 shadow-sm">
                            <?= htmlspecialchars((string)($product['category'] ?? 'Collection')) ?>
                        </span>

                        <div class="pointer-events-auto">
                            <form method="POST" class="m-0">
                                <input type="hidden" name="csrf_token" value="<?= RentEase\Support\Csrf::token() ?>">
                                <input type="hidden" name="toggle_wishlist" value="1">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <?php $isInWishlist = in_array((int) $product['id'], $wishlistIds); ?>
                                <button type="submit" class="wishlist-btn h-8 w-8 bg-surface/80 hover:bg-surface backdrop-blur-sm border border-border flex items-center justify-center shadow-sm transition-colors text-ink">
                                    <span class="material-symbols-outlined text-[16px] <?= $isInWishlist ? 'text-rose' : '' ?>" style="font-variation-settings: 'FILL' <?= $isInWishlist ? '1' : '0' ?>;">favorite</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col px-1">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-serif font-medium text-ink group-hover:text-champagne transition-colors duration-500 cursor-pointer" onclick="window.location.href='<?= baseUrl('/product-detail?id=' . ($product['id'] ?? 0)) ?>'">
                            <?= htmlspecialchars((string)($product['name'] ?? 'Premium Piece')) ?>
                        </h3>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="font-mono text-ink font-medium">
                            $<?= number_format((float)($product['monthly_price'] ?? 0), 0) ?><span class="text-muted-light font-sans text-[10px]">/mo</span>
                        </span>
                        
                        <!-- Add to Cart (Quick Action) -->
                        <form method="POST" action="<?= baseUrl('/cart') ?>" class="m-0 pointer-events-auto">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="text-[10px] text-muted hover:text-ink font-medium tracking-[0.1em] uppercase transition-colors outline-none flex items-center gap-1">
                                <span>Add to Bag</span>
                                <span class="material-symbols-outlined text-[14px]">add</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
