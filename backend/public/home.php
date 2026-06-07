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

$pageTitle = 'RentEase — Premium Furniture Rental';
$pageDescription = 'Transform your space without commitment. Rent premium furniture and appliances with flexible monthly plans, free delivery, and easy returns.';
require __DIR__ . '/partials/header.php';
?>



<main class="w-full relative">

<!-- 1. BRIGHT HERO SECTION -->
<section class="relative w-full min-h-screen flex flex-col justify-center px-6 lg:px-12 pt-32 pb-20 max-w-[1600px] mx-auto">
    
    <div class="w-full text-center mb-12">
        <h1 class="text-5xl md:text-7xl lg:text-[6rem] font-normal tracking-tight leading-[1.1] mb-6">
            <span class="reveal-wrap"><span class="reveal-text">Design your space.</span></span><br>
            <span class="reveal-wrap"><span class="reveal-text text-gray-400">Keep your freedom.</span></span>
        </h1>
        <p class="text-xl md:text-2xl text-gray-500 max-w-2xl mx-auto font-light mb-10 reveal-fade">
            Rent premium furniture and appliances with flexible monthly plans. Free delivery and white-glove assembly.
        </p>
        <div class="reveal-fade">
            <a href="<?= baseUrl('/shop') ?>" class="btn-pill">Explore the Collection</a>
        </div>
    </div>

    <!-- Massive Hero Image -->
    <div class="w-full h-[60vh] md:h-[70vh] img-rounded hero-img-wrap shadow-2xl shadow-black/5">
        <img src="https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?q=80&w=2000&auto=format&fit=crop" class="parallax-img hero-img" alt="Sunlit Living Room">
    </div>

</section>

<!-- 1.5. BENEFITS SECTION -->
<section class="py-24 bg-white">
    <div class="px-6 lg:px-12 max-w-[1600px] mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
        <div class="reveal-fade flex flex-col items-center">
            <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-3xl">local_shipping</span>
            </div>
            <h3 class="text-2xl font-normal mb-4">Free Delivery</h3>
            <p class="text-gray-500 font-light leading-relaxed">White-glove delivery and assembly in your space. We handle all the heavy lifting.</p>
        </div>
        <div class="reveal-fade flex flex-col items-center" style="transition-delay: 100ms;">
            <div class="w-16 h-16 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-3xl">sync</span>
            </div>
            <h3 class="text-2xl font-normal mb-4">Ultimate Flexibility</h3>
            <p class="text-gray-500 font-light leading-relaxed">Swap, upgrade, or return items when your lease is up. Your space evolves with you.</p>
        </div>
        <div class="reveal-fade flex flex-col items-center" style="transition-delay: 200ms;">
            <div class="w-16 h-16 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-3xl">build</span>
            </div>
            <h3 class="text-2xl font-normal mb-4">Zero Maintenance</h3>
            <p class="text-gray-500 font-light leading-relaxed">Accidental damage? Wear and tear? Our team handles repairs and replacements for free.</p>
        </div>
    </div>
</section>

<!-- 2. STICKY SCROLL STORYTELLING (How it Works) -->
<section id="how-it-works" class="py-32 px-6 lg:px-12 max-w-[1600px] mx-auto bg-white relative">
    
    <div class="text-center mb-24">
        <h2 class="text-4xl md:text-5xl font-normal tracking-tight">
            <span class="reveal-wrap"><span class="reveal-text">Beautifully simple.</span></span>
        </h2>
    </div>

    <div class="flex flex-col lg:flex-row gap-16 relative">
        
        <!-- Left Side: Pinned Image -->
        <div class="hidden lg:block w-1/2 h-screen sticky top-0 md:top-24 flex items-center justify-center">
            <div class="w-full aspect-square img-rounded shadow-xl shadow-black/5 bg-gray-50">
                <img id="sticky-img-1" src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=1000&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700" alt="Select">
                <img id="sticky-img-2" src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=1000&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-700" alt="Deliver">
                <img id="sticky-img-3" src="https://images.unsplash.com/photo-1583847268964-b28dc8f51f92?w=1000&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-700" alt="Enjoy">
            </div>
        </div>

        <!-- Right Side: Scrolling Text -->
        <div class="w-full lg:w-1/2 py-[10vh] lg:pl-12">
            <div class="step-block min-h-[70vh] flex flex-col justify-center">
                <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-normal text-xl mb-6">1</div>
                <h3 class="text-4xl font-normal mb-6">Choose your pieces</h3>
                <p class="text-xl text-gray-500 leading-relaxed font-light">Browse our curated collection of premium furniture and appliances. Select the items that fit your style and choose a rental plan that works for your timeline.</p>
            </div>
            
            <div class="step-block min-h-[70vh] flex flex-col justify-center">
                <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center font-normal text-xl mb-6">2</div>
                <h3 class="text-4xl font-normal mb-6">Free delivery & assembly</h3>
                <p class="text-xl text-gray-500 leading-relaxed font-light">Our white-glove delivery team brings everything to your door, assembles the furniture in your preferred room, and removes all packaging.</p>
            </div>
            
            <div class="step-block min-h-[70vh] flex flex-col justify-center">
                <div class="w-12 h-12 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-normal text-xl mb-6">3</div>
                <h3 class="text-4xl font-normal mb-6">Ultimate flexibility</h3>
                <p class="text-xl text-gray-500 leading-relaxed font-light">When your plan ends, you're in control. Renew your rental, swap for new pieces, buy them out, or schedule a free pickup.</p>
            </div>
        </div>

    </div>
</section>

<!-- 2.5 CATEGORIES SECTION -->
<section class="py-32 bg-white">
    <div class="px-6 lg:px-12 max-w-[1600px] mx-auto">
        <div class="mb-16 text-center">
            <h2 class="text-4xl md:text-5xl font-normal tracking-tight mb-4">
                <span class="reveal-wrap"><span class="reveal-text">Explore by space.</span></span>
            </h2>
            <p class="text-xl text-gray-500 font-light reveal-fade">Curated collections for every room.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="group cursor-pointer reveal-fade" onclick="window.location.href='<?= baseUrl('/shop?category=Furniture') ?>'">
                <div class="w-full h-[50vh] img-rounded mb-6 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1583847268964-b28dc8f51f92?w=1000&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="Living Room">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-8 left-8 text-white">
                        <h3 class="text-3xl font-normal mb-2">Living Room</h3>
                        <p class="text-white/80">Sofas, tables, and accents.</p>
                    </div>
                </div>
            </div>
            <div class="group cursor-pointer reveal-fade" style="transition-delay: 100ms;" onclick="window.location.href='<?= baseUrl('/shop?category=Appliances') ?>'">
                <div class="w-full h-[50vh] img-rounded mb-6 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=1000&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="Appliances">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-8 left-8 text-white">
                        <h3 class="text-3xl font-normal mb-2">Smart Appliances</h3>
                        <p class="text-white/80">Premium tech for your home.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. AIRY PRODUCT GRID -->
<section class="py-32 bg-gray-50">
    <div class="px-6 lg:px-12 max-w-[1600px] mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16">
            <div>
                <h2 class="text-4xl md:text-5xl font-normal tracking-tight mb-4">
                    <span class="reveal-wrap"><span class="reveal-text">Trending now.</span></span>
                </h2>
                <p class="text-xl text-gray-500 font-light reveal-fade">Pieces our community loves.</p>
            </div>
            <a href="<?= baseUrl('/shop') ?>" class="text-blue-600 font-normal hover:text-blue-700 flex items-center gap-2 mt-6 md:mt-0 reveal-fade">
                Shop all <span class="material-symbols-outlined text-sm font-light">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
            <?php
            $allProducts = array_merge($furniture, $appliances);
            if (!empty($allProducts)): 
                foreach (array_slice($allProducts, 0, 8) as $index => $product): 
            ?>
            <div class="group/card relative w-full aspect-[4/5] rounded-[2.5rem] overflow-hidden cursor-pointer shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-700 reveal-fade" onclick="window.location.href='<?= baseUrl('/product-detail?id=' . ($product['id'] ?? 0)) ?>'">
                <!-- Background Image -->
                <img alt="<?= htmlspecialchars((string)($product['name'] ?? 'Product')) ?>"
                     src="<?= htmlspecialchars((string)($product['image_url'] ?? 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&q=80&w=600')) ?>"
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover/card:scale-110" />

                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent opacity-80 group-hover/card:opacity-100 transition-opacity duration-700"></div>

                <!-- Top Badges -->
                <div class="absolute top-6 left-6 right-6 flex justify-between items-start">
                    <span class="bg-white/20 backdrop-blur-md border border-white/10 text-white text-[10px] font-normal uppercase tracking-widest px-3 py-1.5 rounded-full shadow-lg">
                        <?= htmlspecialchars((string)($product['category'] ?? 'Collection')) ?>
                    </span>
                    <div class="flex flex-col items-end bg-slate-900/40 backdrop-blur-md border border-white/10 px-3 py-1.5 rounded-2xl shadow-lg">
                        <span class="text-white font-normal text-lg leading-none">$<?= number_format((float)($product['monthly_price'] ?? 0), 0) ?></span>
                        <span class="text-white/70 text-[9px] font-normal uppercase tracking-widest mt-0.5">/month</span>
                    </div>
                </div>

                <!-- Bottom Content -->
                <div class="absolute bottom-6 left-6 right-6 flex flex-col translate-y-4 group-hover/card:translate-y-0 transition-transform duration-500 ease-out">
                    <h3 class="text-2xl font-normal text-white mb-2 leading-tight drop-shadow-md pr-8">
                        <?= htmlspecialchars((string)($product['name'] ?? 'Premium Piece')) ?>
                    </h3>
                    
                    <!-- Action Row -->
                    <div class="flex items-center justify-between mt-4 overflow-hidden">
                        <div class="flex items-center gap-2 text-teal-400 font-light text-sm tracking-wide opacity-0 -translate-x-4 group-hover/card:opacity-100 group-hover/card:translate-x-0 transition-all duration-500 delay-100">
                            <span>View Details</span>
                            <span class="material-symbols-outlined text-sm font-light">arrow_forward</span>
                        </div>
                        
                        <div class="w-10 h-10 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white group-hover/card:bg-teal-500 group-hover/card:border-teal-500 transition-colors duration-500 shadow-xl">
                            <span class="material-symbols-outlined text-lg">add</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>

<!-- 3.5 TESTIMONIALS -->
<section class="py-32 bg-white">
    <div class="px-6 lg:px-12 max-w-[1600px] mx-auto text-center">
        <h2 class="text-4xl md:text-5xl font-normal tracking-tight mb-16">
            <span class="reveal-wrap"><span class="reveal-text">Loved by thousands.</span></span>
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
            <div class="bg-white rounded-[2rem] p-10 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500 reveal-fade">
                <div class="flex items-center gap-1 text-yellow-400 mb-6">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                </div>
                <p class="text-lg text-gray-700 leading-relaxed mb-8">"I moved to a new city and furnished my entire apartment in two days without spending a fortune. The quality is incredible."</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center font-normal text-blue-600">SJ</div>
                    <div>
                        <h4 class="font-normal text-gray-900">Sarah Jenkins</h4>
                        <p class="text-sm text-gray-500 font-light">Subscribed for 12 months</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] p-10 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500 reveal-fade" style="transition-delay: 100ms;">
                <div class="flex items-center gap-1 text-yellow-400 mb-6">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                </div>
                <p class="text-lg text-gray-700 leading-relaxed mb-8">"The delivery team was so professional. They carried a massive sofa up three flights of stairs and assembled it perfectly."</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center font-normal text-green-600">MR</div>
                    <div>
                        <h4 class="font-normal text-gray-900">Michael Ross</h4>
                        <p class="text-sm text-gray-500 font-light">Subscribed for 6 months</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] p-10 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500 reveal-fade" style="transition-delay: 200ms;">
                <div class="flex items-center gap-1 text-yellow-400 mb-6">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                </div>
                <p class="text-lg text-gray-700 leading-relaxed mb-8">"I love changing my decor frequently. RentEase lets me swap out my dining set whenever I want a fresh look. Highly recommend."</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center font-normal text-purple-600">AP</div>
                    <div>
                        <h4 class="font-normal text-gray-900">Anita Patel</h4>
                        <p class="text-sm text-gray-500 font-light">Subscribed for 24 months</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4. FOOTER CTA -->
<section class="py-32 px-6 text-center bg-gray-50">
    <div class="max-w-3xl mx-auto">
        <h2 class="text-5xl md:text-7xl font-normal tracking-tight mb-8">
            <span class="reveal-wrap"><span class="reveal-text">Ready for a change?</span></span>
        </h2>
        <p class="text-xl text-gray-500 font-light mb-12 reveal-fade">Join thousands who have embraced spatial freedom.</p>
        <div class="reveal-fade">
            <a href="<?= baseUrl('/shop') ?>" class="btn-pill">Get Started Today</a>
        </div>
    </div>
</section>
<!-- Home Page Scroll Logic -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const checkHomeGsap = setInterval(() => {
        if (window.gsap && window.ScrollTrigger) {
            clearInterval(checkHomeGsap);
            
            // Storytelling sticky images
            const steps = document.querySelectorAll('.step-block');
            const images = [
                document.getElementById('sticky-img-1'),
                document.getElementById('sticky-img-2'),
                document.getElementById('sticky-img-3')
            ];

            if (steps.length > 0 && images[0]) {
                let ctx = gsap.context(() => {
                    steps.forEach((step, index) => {
                        ScrollTrigger.create({
                            trigger: step,
                            start: "top center",
                            end: "bottom center",
                            onToggle: self => {
                                if (self.isActive && images[index]) {
                                    images.forEach(img => {
                                        if (img) img.style.opacity = '0';
                                    });
                                    images[index].style.opacity = '1';
                                }
                            }
                        });
                    });
                });
            }
        }
    }, 50);
});
</script>

</main>



<?php require __DIR__ . '/partials/footer.php'; ?>