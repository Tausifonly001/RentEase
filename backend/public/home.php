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

<!-- Scroll Progress Bar -->
<div id="scroll-progress" class="fixed top-0 left-0 h-1 bg-teal-500 z-[60] origin-left scale-x-0 w-full transition-transform duration-75 ease-linear"></div>

<!-- Load GSAP ScrollTrigger specifically for the homepage -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

<!-- Main Content Canvas -->
<main class="flex-grow pb-24 md:pb-0 overflow-x-hidden">

<!-- Hero Section -->
<section class="relative w-full max-w-container-max mx-auto px-4 md:px-8 py-xl lg:py-24 flex flex-col md:flex-row items-center gap-lg overflow-visible">
    <div class="w-full md:w-1/2 flex flex-col gap-6 z-10">
        <h1 class="hero-title font-h1 text-h1 text-primary leading-[1.1] opacity-0 translate-y-8">
            Premium Furniture &amp; Appliances, <br/><span class="text-teal-600">on Your Terms.</span>
        </h1>
        <p class="hero-text font-body-lg text-body-lg text-slate-500 max-w-lg opacity-0 translate-y-4">
            Transform your space without the commitment. Flexible monthly rentals for high-quality pieces, delivered and assembled for you.
        </p>
        <div class="hero-btns flex flex-wrap gap-4 mt-2 opacity-0 translate-y-4">
            <a href="<?= baseUrl('/shop') ?>"
                class="bg-slate-900 text-white font-button text-button px-8 py-4 rounded-full hover:bg-teal-600 transition-colors shadow-lg hover:shadow-teal-500/25 focus-visible:ring-2 ring-teal-500 outline-none flex items-center gap-2 group">
                Explore Catalog
                <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </a>
            <a href="<?= baseUrl('/shop') ?>"
                class="bg-white border border-slate-200 text-slate-700 font-button text-button px-8 py-4 rounded-full hover:border-slate-300 hover:bg-slate-50 transition-colors shadow-sm focus-visible:ring-2 ring-teal-500 outline-none">
                View Packages
            </a>
        </div>
    </div>
    
    <div class="hero-img-wrap w-full md:w-1/2 relative h-[450px] md:h-[600px] rounded-3xl overflow-hidden shadow-2xl opacity-0 scale-95">
        <img alt="Modern living room with premium furniture" class="hero-img w-full h-full object-cover scale-110" fetchpriority="high"
            src="https://images.unsplash.com/photo-1540518614846-7eded433c457?q=80&w=1200&auto=format&fit=crop" />
        <div class="absolute inset-0 bg-gradient-to-tr from-slate-900/20 to-transparent"></div>
    </div>
</section>

<!-- Trusted By Marquee -->
<section class="w-full border-y border-slate-100 bg-white py-10 overflow-hidden relative">
    <div class="absolute inset-y-0 left-0 w-24 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"></div>
    <div class="absolute inset-y-0 right-0 w-24 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>
    
    <div class="max-w-container-max mx-auto px-4 md:px-8 mb-4 text-center">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Trusted by top modern living spaces</p>
    </div>
    
    <div class="marquee-container flex whitespace-nowrap overflow-hidden items-center opacity-60 hover:opacity-100 transition-opacity duration-500">
        <div class="marquee-track flex items-center gap-16 md:gap-32 pl-16 md:pl-32">
            <!-- Logos -->
            <h3 class="text-xl font-black text-slate-400 font-serif tracking-tighter">Vogue<span class="text-teal-500">.</span></h3>
            <h3 class="text-xl font-black text-slate-400 tracking-widest uppercase">Forbes</h3>
            <h3 class="text-xl font-black text-slate-400 font-serif italic">TechCrunch</h3>
            <h3 class="text-xl font-black text-slate-400 tracking-tighter uppercase flex items-center gap-1"><span class="material-symbols-outlined !text-3xl">chair</span> Dwell</h3>
            <h3 class="text-xl font-black text-slate-400 tracking-wide">ArchDigest</h3>
            <h3 class="text-xl font-black text-slate-400 font-serif tracking-tighter">Vogue<span class="text-teal-500">.</span></h3>
            <h3 class="text-xl font-black text-slate-400 tracking-widest uppercase">Forbes</h3>
            <h3 class="text-xl font-black text-slate-400 font-serif italic">TechCrunch</h3>
            <h3 class="text-xl font-black text-slate-400 tracking-tighter uppercase flex items-center gap-1"><span class="material-symbols-outlined !text-3xl">chair</span> Dwell</h3>
            <h3 class="text-xl font-black text-slate-400 tracking-wide">ArchDigest</h3>
        </div>
    </div>
</section>

<!-- Error Message -->
<?php if ($error): ?>
    <section class="max-w-container-max mx-auto px-4 md:px-8 py-4">
        <div class="bg-red-50 text-red-600 border border-red-100 p-4 rounded-xl flex items-center gap-3">
            <span class="material-symbols-outlined" aria-hidden="true">error</span>
            <p><?= htmlspecialchars($error) ?></p>
        </div>
    </section>
<?php endif; ?>

<!-- Featured Rentals -->
<section class="w-full max-w-container-max mx-auto px-4 md:px-8 py-24">
    <div class="flex flex-col md:flex-row md:justify-between md:items-end mb-12 gap-4">
        <div>
            <p class="text-teal-600 font-bold tracking-widest text-[10px] uppercase mb-2">Top Picks</p>
            <h2 class="font-h2 text-[32px] md:text-h2 text-slate-900 leading-tight">Featured Rentals</h2>
        </div>
        <a class="group font-button text-button text-slate-600 flex items-center gap-2 hover:text-teal-600 transition-colors focus-visible:ring-2 ring-teal-500 rounded outline-none"
            href="<?= baseUrl('/shop') ?>">View Catalog <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span></a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <?php
        $allProducts = array_merge($furniture, $appliances);
        if (empty($allProducts)): ?>
            <p class="text-slate-500 py-8 col-span-full text-center">No featured products available.</p>
        <?php else: ?>
            <?php foreach (array_slice($allProducts, 0, 8) as $product): ?>
                    <div class="product-card flex flex-col bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-[0_2px_12px_rgba(4,22,39,0.03)] relative cursor-pointer opacity-0 translate-y-8" onclick="window.location.href='<?= baseUrl('/product-detail?id=' . $product['id']) ?>'">
                        <!-- Image Area -->
                        <div class="relative aspect-square overflow-hidden bg-[#F8F9FA] flex items-center justify-center p-6 group/img">
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
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
                                    <input type="hidden" name="action" value="add">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" aria-label="Add to cart"
                                        class="add-to-cart-btn h-10 w-10 rounded-full bg-slate-900 text-white flex items-center justify-center shadow-md transition-colors hover:bg-teal-600">
                                        <span class="material-symbols-outlined !text-[18px]">add_shopping_cart</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<!-- Product Categories (Bento Grid) -->
<section class="w-full max-w-container-max mx-auto px-4 md:px-8 py-24">
    <div class="flex flex-col md:flex-row md:justify-between md:items-end mb-12 gap-4">
        <div>
            <p class="text-teal-600 font-bold tracking-widest text-[10px] uppercase mb-2">Curated Collections</p>
            <h2 class="font-h2 text-[32px] md:text-h2 text-slate-900 leading-tight">Shop by Category</h2>
        </div>
        <a class="group font-button text-button text-slate-600 flex items-center gap-2 hover:text-teal-600 transition-colors focus-visible:ring-2 ring-teal-500 rounded outline-none"
            href="<?= baseUrl('/shop') ?>">View All Collections <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span></a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 auto-rows-[280px]">
        <!-- Living Room -->
        <a class="bento-card group relative rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all md:col-span-2 lg:col-span-2 row-span-2 focus-visible:ring-2 ring-teal-500 outline-none opacity-0 translate-y-12"
            href="<?= baseUrl('/shop?category=Furniture') ?>">
            <img alt="Elegant living room furniture"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?q=80&w=1000&auto=format&fit=crop" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent"></div>
            <div class="absolute bottom-0 left-0 p-8 w-full transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                <h3 class="font-h3 text-3xl font-bold text-white mb-2">Living Room</h3>
                <p class="text-white/80 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100 flex items-center gap-2">
                    Sofas, Tables, TV Stands <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </p>
            </div>
        </a>
        <!-- Bedroom -->
        <a class="bento-card group relative rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all md:col-span-1 lg:col-span-1 row-span-1 focus-visible:ring-2 ring-teal-500 outline-none opacity-0 translate-y-12"
            href="<?= baseUrl('/shop?category=Bedroom') ?>">
            <img alt="Comfortable bedroom setup"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                src="https://images.unsplash.com/photo-1505691723518-36a5ac3be353?q=80&w=1000&auto=format&fit=crop" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 to-transparent"></div>
            <div class="absolute bottom-0 left-0 p-6 w-full">
                <h3 class="text-xl font-bold text-white group-hover:text-teal-300 transition-colors">Bedroom</h3>
            </div>
        </a>
        <!-- Kitchen / Appliances -->
        <a class="bento-card group relative rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all md:col-span-1 lg:col-span-1 row-span-1 focus-visible:ring-2 ring-teal-500 outline-none opacity-0 translate-y-12"
            href="<?= baseUrl('/shop?category=Appliances') ?>">
            <img alt="Modern kitchen appliances"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                src="https://images.unsplash.com/photo-1556911220-e15b29be8c8f?q=80&w=1000&auto=format&fit=crop" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 to-transparent"></div>
            <div class="absolute bottom-0 left-0 p-6 w-full">
                <h3 class="text-xl font-bold text-white group-hover:text-teal-300 transition-colors">Appliances</h3>
            </div>
        </a>
        <!-- Home Office -->
        <a class="bento-card group relative rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all md:col-span-2 lg:col-span-2 row-span-1 focus-visible:ring-2 ring-teal-500 outline-none opacity-0 translate-y-12"
            href="<?= baseUrl('/shop?category=Office') ?>">
            <img alt="Productive home office space"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out center" style="background-position: center 30%"
                src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?q=80&w=1000&auto=format&fit=crop" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>
            <div class="absolute bottom-0 left-0 p-8 w-full flex justify-between items-end">
                <h3 class="text-2xl font-bold text-white group-hover:text-teal-300 transition-colors">Home Office</h3>
                <span class="bg-white/20 backdrop-blur-md rounded-full w-10 h-10 flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-[-10px] group-hover:translate-x-0"><span class="material-symbols-outlined text-sm">arrow_forward</span></span>
            </div>
        </a>
    </div>
</section>

<!-- Storytelling: How it Works -->
<section class="w-full bg-[#F8F9FA] py-24 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-teal-500/5 rounded-full blur-3xl translate-x-1/3 -translate-y-1/3 pointer-events-none"></div>
    
    <div class="max-w-container-max mx-auto px-4 md:px-8 relative z-10">
        <div class="text-center mb-20">
            <p class="text-teal-600 font-bold tracking-widest text-[10px] uppercase mb-2">The Process</p>
            <h2 class="font-h2 text-[36px] md:text-[48px] text-slate-900 leading-tight">How RentEase Works</h2>
            <p class="text-slate-500 max-w-2xl mx-auto mt-4 text-lg">Simple, flexible, and entirely on your terms. We've made furnishing your space as easy as ordering takeout.</p>
        </div>
        
        <div class="relative">
            <!-- Connecting Line (Desktop) -->
            <div class="hidden md:block absolute top-12 left-[16.6%] right-[16.6%] h-0.5 bg-slate-200">
                <div class="story-line h-full bg-teal-500 w-0"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 md:gap-8">
                <!-- Step 1 -->
                <div class="story-step flex flex-col items-center text-center relative opacity-0 translate-y-8">
                    <div class="w-24 h-24 bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex items-center justify-center mb-6 text-teal-600 relative z-10 border border-slate-50 transition-transform hover:scale-110 duration-300">
                        <span class="material-symbols-outlined !text-[40px]">touch_app</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">1. Choose Your Style</h3>
                    <p class="text-slate-500 leading-relaxed px-4">Browse our curated catalog of premium furniture and high-end appliances perfectly suited to fit your space.</p>
                </div>
                <!-- Step 2 -->
                <div class="story-step flex flex-col items-center text-center relative opacity-0 translate-y-8">
                    <div class="w-24 h-24 bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex items-center justify-center mb-6 text-teal-600 relative z-10 border border-slate-50 transition-transform hover:scale-110 duration-300">
                        <span class="material-symbols-outlined !text-[40px]">calendar_month</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">2. Flexible Schedule</h3>
                    <p class="text-slate-500 leading-relaxed px-4">Select your rental term—3, 6, or 12 months—and pick a convenient delivery date that works for you.</p>
                </div>
                <!-- Step 3 -->
                <div class="story-step flex flex-col items-center text-center relative opacity-0 translate-y-8">
                    <div class="w-24 h-24 bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex items-center justify-center mb-6 text-teal-600 relative z-10 border border-slate-50 transition-transform hover:scale-110 duration-300">
                        <span class="material-symbols-outlined !text-[40px]">chair</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">3. Enjoy Your Space</h3>
                    <p class="text-slate-500 leading-relaxed px-4">We deliver and assemble. When your term is up, simply extend, swap, or return with absolutely zero hassle.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Marquee -->
<section class="w-full bg-slate-900 py-24 overflow-hidden relative">
    <div class="absolute inset-y-0 left-0 w-32 bg-gradient-to-r from-slate-900 to-transparent z-10 pointer-events-none"></div>
    <div class="absolute inset-y-0 right-0 w-32 bg-gradient-to-l from-slate-900 to-transparent z-10 pointer-events-none"></div>

    <div class="max-w-container-max mx-auto px-4 md:px-8 mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-white">Loved by thousands</h2>
    </div>

    <div class="testimonial-marquee-container flex whitespace-nowrap overflow-hidden py-4 hover:[&>div]:animation-pause cursor-grab active:cursor-grabbing">
        <div class="testimonial-track flex items-stretch gap-6 pl-6">
            
            <?php
            // Placeholder testimonials
            $reviews = [
                ['name' => 'Sarah J.', 'role' => 'Software Engineer', 'text' => '"The quality of the furniture blew me away. It completely transformed my empty apartment in just 2 days."'],
                ['name' => 'Michael T.', 'role' => 'Freelance Designer', 'text' => '"Returning the items when I moved cities was frictionless. Best decision I made instead of buying."'],
                ['name' => 'Emma L.', 'role' => 'Marketing Manager', 'text' => '"Premium brands at a fraction of the cost. The customer service and delivery team were incredibly polite."'],
                ['name' => 'David W.', 'role' => 'Startup Founder', 'text' => '"Furnished my entire 2BHK without burning through my savings. Absolutely recommend RentEase to everyone."'],
            ];
            // Duplicate to create seamless loop
            $reviews = array_merge($reviews, $reviews, $reviews);
            foreach ($reviews as $review): 
            ?>
            <div class="inline-flex flex-col bg-slate-800/50 backdrop-blur-md border border-slate-700/50 p-8 rounded-3xl w-[350px] md:w-[400px] whitespace-normal flex-shrink-0 transition-transform duration-300 hover:-translate-y-2 hover:bg-slate-800">
                <div class="flex gap-1 mb-4 text-amber-400">
                    <span class="material-symbols-outlined !text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined !text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined !text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined !text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined !text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                </div>
                <p class="text-slate-300 text-lg leading-relaxed mb-8 flex-grow"><?= $review['text'] ?></p>
                <div class="flex items-center gap-3 mt-auto">
                    <div class="w-10 h-10 rounded-full bg-teal-500/20 text-teal-400 flex items-center justify-center font-bold text-sm">
                        <?= substr($review['name'], 0, 1) ?>
                    </div>
                    <div>
                        <h4 class="text-white font-bold text-sm"><?= $review['name'] ?></h4>
                        <p class="text-slate-500 text-xs"><?= $review['role'] ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            
        </div>
    </div>
</section>

</main>

<style>
/* Fallback: if GSAP fails to load after 2s, show everything gracefully */
.no-js .hero-title, .no-js .hero-text, .no-js .hero-btns, .no-js .hero-img-wrap,
.no-js .bento-card, .no-js .story-step, .no-js .product-card,
.gsap-failed .hero-title, .gsap-failed .hero-text, .gsap-failed .hero-btns, .gsap-failed .hero-img-wrap,
.gsap-failed .bento-card, .gsap-failed .story-step, .gsap-failed .product-card {
    opacity: 1 !important;
    transform: none !important;
    transition: opacity 0.5s ease, transform 0.5s ease;
}

/* CSS Marquee Animations (Performance friendly) */
@keyframes scrollMarquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

.marquee-track {
    animation: scrollMarquee 30s linear infinite;
    /* Ensure track width accommodates duplication */
    width: max-content;
}

.testimonial-track {
    animation: scrollMarquee 40s linear infinite;
    width: max-content;
}

.testimonial-marquee-container:hover .testimonial-track {
    animation-play-state: paused;
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
        if (window.gsap && window.ScrollTrigger) {
            clearInterval(checkGsap);
            clearTimeout(fallbackTimer);
            gsap.registerPlugin(ScrollTrigger);
            initHomeAnimations();
        }
    }, 50);

    function initHomeAnimations() {
        const ctx = gsap.context(() => {
            
            // --- 1. Global Scroll Progress Bar ---
            gsap.to('#scroll-progress', {
                scaleX: 1,
                ease: 'none',
                scrollTrigger: {
                    trigger: document.body,
                    start: 'top top',
                    end: 'bottom bottom',
                    scrub: 0.1
                }
            });

            // --- 2. Hero Section Entrance ---
            const heroTl = gsap.timeline({ defaults: { ease: 'power3.out' } });
            
            // Text entrance
            heroTl.to('.hero-title', { opacity: 1, y: 0, duration: 1 })
                  .to('.hero-text', { opacity: 1, y: 0, duration: 0.8 }, "-=0.6")
                  .to('.hero-btns', { opacity: 1, y: 0, duration: 0.8 }, "-=0.6")
                  // Image parallax entrance
                  .to('.hero-img-wrap', { opacity: 1, scale: 1, duration: 1.2, ease: 'power4.out' }, "-=1");

            // Hero Image Parallax on scroll
            gsap.to('.hero-img', {
                yPercent: 15,
                ease: 'none',
                scrollTrigger: {
                    trigger: '.hero-img-wrap',
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: true
                }
            });

            // --- 3. Featured Rentals ---
            gsap.to('.product-card', {
                scrollTrigger: {
                    trigger: '.product-card',
                    start: 'top 85%'
                },
                opacity: 1,
                y: 0,
                duration: 0.8,
                stagger: 0.1,
                ease: 'power3.out'
            });

            // Dynamic Hover Interactions for Product Cards
            document.querySelectorAll('.product-card').forEach(card => {
                const img = card.querySelector('.product-img');
                const btn = card.querySelector('.add-to-cart-btn');
                const title = card.querySelector('.product-title');

                card.addEventListener('mouseenter', () => {
                    gsap.to(card, { y: -6, boxShadow: '0 20px 40px -12px rgba(4,22,39,0.08)', duration: 0.4, ease: 'power2.out' });
                    gsap.to(img, { scale: 1.05, duration: 0.6, ease: 'power2.out' });
                    gsap.to(title, { color: '#006a65', duration: 0.3 });
                    gsap.to(btn, { backgroundColor: '#006a65', scale: 1.1, rotation: 12, duration: 0.4, ease: 'back.out(2)' });
                });

                card.addEventListener('mouseleave', () => {
                    gsap.to(card, { y: 0, boxShadow: '0 2px 12px rgba(4,22,39,0.03)', duration: 0.4, ease: 'power2.out' });
                    gsap.to(img, { scale: 1, duration: 0.6, ease: 'power2.out' });
                    gsap.to(title, { color: '#0f172a', duration: 0.3 }); 
                    gsap.to(btn, { backgroundColor: '#0f172a', scale: 1, rotation: 0, duration: 0.4, ease: 'power2.out' });
                });
            });

            // --- 4. Bento Grid (Categories) ---
            gsap.to('.bento-card', {
                scrollTrigger: {
                    trigger: '.bento-card',
                    start: 'top 85%',
                },
                opacity: 1,
                y: 0,
                duration: 0.8,
                stagger: 0.15,
                ease: 'power3.out'
            });

            // --- 5. Storytelling: How it Works ---
            const storyTl = gsap.timeline({
                scrollTrigger: {
                    trigger: '.story-step',
                    start: 'top 80%',
                }
            });

            storyTl.to('.story-step', {
                opacity: 1,
                y: 0,
                duration: 0.8,
                stagger: 0.2,
                ease: 'back.out(1.2)'
            });

            // Animate the connecting line
            gsap.to('.story-line', {
                width: '100%',
                duration: 1.2,
                ease: 'power2.inOut',
                scrollTrigger: {
                    trigger: '.story-step',
                    start: 'top 70%',
                }
            });
        });
    }
});
</script>

<?php require __DIR__ . '/partials/footer.php'; ?>