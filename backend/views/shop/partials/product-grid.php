<?php if ($error): ?>
    <div class="bg-red-50 text-red-600 p-4 rounded-2xl flex items-center gap-3 border border-red-100 shadow-sm mt-4">
        <span class="material-symbols-outlined font-light">error</span>
        <p class="font-light text-sm"><?= htmlspecialchars($error) ?></p>
    </div>
<?php elseif (empty($products)): ?>
    <div class="py-24 text-center border border-dashed border-slate-200 rounded-[2rem] bg-slate-50 mt-4">
        <span class="material-symbols-outlined text-5xl mb-4 text-slate-300 font-light">inventory_2</span>
        <h3 class="text-2xl font-normal mb-2 text-slate-900">No items found</h3>
        <p class="text-slate-500 font-light">We couldn't find any products matching your filters.</p>
    </div>
<?php else: ?>
    <!-- Grid -->
    <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($products as $product): ?>
            <div class="group/card relative w-full aspect-[4/5] rounded-[2.5rem] overflow-hidden cursor-pointer shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-700 product-card reveal-fade">
                <!-- Background Image -->
                <img alt="<?= htmlspecialchars((string)($product['name'] ?? 'Product')) ?>"
                     src="<?= htmlspecialchars((string)($product['image_url'] ?? 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&q=80&w=600')) ?>"
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover/card:scale-110" />

                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent opacity-80 group-hover/card:opacity-100 transition-opacity duration-700" onclick="window.location.href='<?= baseUrl('/product-detail?id=' . ($product['id'] ?? 0)) ?>'"></div>

                <!-- Top Badges -->
                <div class="absolute top-6 left-6 right-6 flex justify-between items-start z-10 pointer-events-none">
                    <span class="bg-white/20 backdrop-blur-md border border-white/10 text-white text-[10px] font-light uppercase tracking-widest px-3 py-1.5 rounded-full shadow-lg">
                        <?= htmlspecialchars((string)($product['category'] ?? 'Collection')) ?>
                    </span>
                    
                    <!-- Wishlist Button -->
                    <div class="pointer-events-auto">
                        <form method="POST" class="m-0">
                            <input type="hidden" name="csrf_token" value="<?= RentEase\Support\Csrf::token() ?>">
                            <input type="hidden" name="toggle_wishlist" value="1">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <?php $isInWishlist = in_array((int) $product['id'], $wishlistIds); ?>
                            <button type="submit" class="wishlist-btn h-10 w-10 bg-white/20 hover:bg-white/30 backdrop-blur-md border border-white/10 rounded-full flex items-center justify-center shadow-lg transition-colors <?= $isInWishlist ? 'text-red-400' : 'text-white' ?>">
                                <span class="material-symbols-outlined !text-[20px] <?= $isInWishlist ? 'heart-beat' : '' ?>" style="font-variation-settings: 'FILL' <?= $isInWishlist ? '1' : '0' ?>;">favorite</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Bottom Content -->
                <div class="absolute bottom-6 left-6 right-6 flex flex-col translate-y-4 group-hover/card:translate-y-0 transition-transform duration-500 ease-out z-10 pointer-events-none">
                    
                    <!-- Price Badge -->
                    <div class="flex flex-col items-start bg-slate-900/40 backdrop-blur-md border border-white/10 px-3 py-1.5 rounded-2xl shadow-lg mb-3 self-start">
                        <span class="text-white font-normal text-lg leading-none">$<?= number_format((float)($product['monthly_price'] ?? 0), 0) ?></span>
                        <span class="text-white/70 text-[9px] font-light uppercase tracking-widest mt-0.5">/month</span>
                    </div>

                    <h3 class="text-2xl font-normal text-white mb-2 leading-tight drop-shadow-md pr-8 pointer-events-auto cursor-pointer" onclick="window.location.href='<?= baseUrl('/product-detail?id=' . ($product['id'] ?? 0)) ?>'">
                        <?= htmlspecialchars((string)($product['name'] ?? 'Premium Piece')) ?>
                    </h3>
                    
                    <!-- Action Row -->
                    <div class="flex items-center justify-between mt-4 overflow-hidden pointer-events-auto">
                        <div class="flex items-center gap-2 text-teal-400 font-light text-sm tracking-wide opacity-0 -translate-x-4 group-hover/card:opacity-100 group-hover/card:translate-x-0 transition-all duration-500 delay-100 cursor-pointer" onclick="window.location.href='<?= baseUrl('/product-detail?id=' . ($product['id'] ?? 0)) ?>'">
                            <span>View Details</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </div>
                        
                        <form method="POST" action="<?= baseUrl('/cart') ?>" class="m-0">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-10 h-10 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white hover:bg-teal-500 hover:border-teal-500 transition-colors duration-500 shadow-xl group/cartbtn" title="Add to Cart">
                                <span class="material-symbols-outlined text-lg group-hover/cartbtn:scale-110 transition-transform">add_shopping_cart</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
