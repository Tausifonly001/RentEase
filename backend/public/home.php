<?php
declare(strict_types=1);

use RentEase\Services\ProductService;
use RentEase\Services\AuthService;
use RentEase\Support\Csrf;

require_once __DIR__ . '/../bootstrap.php';

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

<!-- Ultra-Professional Cinematic Loader -->
<div id="loader" class="fixed inset-0 flex pointer-events-auto overflow-hidden bg-transparent" style="z-index: 100;">
    
    <!-- Top-Left Triangle -->
    <div id="loader-tl" class="absolute inset-0 z-20 flex justify-center items-center overflow-hidden bg-ink" style="clip-path: polygon(0 0, 100% 0, 0 100%);">
        <!-- Seamless Cinematic Background Image -->
        <img src="https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&q=80&w=2000" class="absolute inset-0 w-full h-full object-cover loader-bg-img" style="transform: scale(1.1);" alt="" />
        <div class="absolute inset-0 bg-ink/50 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-ink/60 via-transparent to-ink/60"></div>
        
        <div class="relative text-center w-full z-10" id="logo-tl" style="transform: scale(0.95); opacity: 0;">
            <span class="font-serif text-4xl md:text-6xl font-medium tracking-[0.3em] text-white whitespace-nowrap drop-shadow-2xl">RENTEASE</span>
        </div>
    </div>

    <!-- Bottom-Right Triangle -->
    <div id="loader-br" class="absolute inset-0 z-10 flex justify-center items-center overflow-hidden bg-ink" style="clip-path: polygon(100% 0, 100% 100%, 0 100%);">
        <!-- Seamless Cinematic Background Image (Identical to Top-Left) -->
        <img src="https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&q=80&w=2000" class="absolute inset-0 w-full h-full object-cover loader-bg-img" style="transform: scale(1.1);" alt="" />
        <div class="absolute inset-0 bg-ink/50 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-ink/60 via-transparent to-ink/60"></div>

        <div class="relative text-center w-full z-10" id="logo-br" style="transform: scale(0.95); opacity: 0;">
            <span class="font-serif text-4xl md:text-6xl font-medium tracking-[0.3em] text-white whitespace-nowrap drop-shadow-2xl">RENTEASE</span>
        </div>
    </div>

</div>

<!-- Safety net: never let the intro loader block the page if GSAP fails to load -->
<script>
(function () {
    function hideLoader() {
        var l = document.getElementById('loader');
        if (l) { l.style.display = 'none'; }
    }
    window.addEventListener('load', function () { setTimeout(hideLoader, 3000); });
    setTimeout(hideLoader, 5000);
})();
</script>

<main class="w-full relative bg-canvas">

<!-- ============================================ -->
<!-- 1. CINEMATIC HERO SECTION -->
<!-- ============================================ -->
<section class="relative w-full min-h-[100dvh] flex items-center px-6 lg:px-12 pt-24 max-w-[1600px] mx-auto overflow-hidden">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 w-full items-center">
        <div class="relative z-10 w-full max-w-2xl order-2 lg:order-1">
            <div class="mb-4">
                <div class="inline-flex items-center gap-2 text-muted text-[10px] font-medium uppercase tracking-[0.2em] opacity-0 gsap-fade mb-6">
                    <span class="w-1.5 h-1.5 bg-champagne" style="animation: pulse-dot 2s ease-in-out infinite;"></span>
                    Premium Living, Flexible Terms
                </div>
            </div>
            <div class="mb-8">
                <h1 class="text-5xl md:text-7xl lg:text-[6.5rem] font-serif tracking-tight text-ink leading-[1.05]" id="hero-title">
                    <span class="text-mask"><span class="text-mask-inner">Design your</span></span><br>
                    <span class="text-mask"><span class="text-mask-inner italic text-champagne">space.</span></span>
                </h1>
            </div>
            <div class="overflow-hidden mb-12 max-w-lg">
                <p class="text-lg md:text-xl text-muted font-light leading-relaxed opacity-0" id="hero-desc">
                    Curated furniture and smart appliances. Flexible terms. White-glove delivery included.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-5 opacity-0" id="hero-ctas">
                <a href="<?= baseUrl('/shop') ?>" class="btn-primary">Explore Collection</a>
                <a href="#how-it-works" class="btn-secondary">How it Works</a>
            </div>
        </div>

        <div class="relative z-10 w-full min-h-[50vh] lg:min-h-[85vh] order-1 lg:order-2 overflow-hidden bg-surface" id="hero-img-container">
            <div class="absolute inset-0 bg-champagne/10 z-10 clip-reveal" id="hero-image-overlay"></div>
            <img src="<?= baseUrl('/assets/images/home_hero.png') ?>" alt="Luxury living room interior" fetchpriority="high" decoding="async" class="w-full h-full object-cover origin-center scale-110" id="hero-img" style="filter: grayscale(15%);">
            <div class="absolute inset-0 bg-gradient-to-t from-canvas/40 via-transparent to-transparent z-10 lg:hidden"></div>
        </div>
    </div>
</section>

<!-- ============================================ -->
<!-- 2. ASYMMETRIC EDITORIAL BENEFITS -->
<!-- ============================================ -->
<section class="py-28 lg:py-36 relative border-t" style="border-color: rgba(231,229,228,0.6);">
    <div class="px-6 lg:px-12 max-w-[1600px] mx-auto">
        <div class="max-w-2xl mb-20">
            <h2 class="section-title">Designed around you.</h2>
            <p class="section-subtitle">Every detail considered so you can focus on living, not logistics.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 lg:gap-16">
            <div class="benefit-card">
                <div class="text-5xl font-serif text-champagne/30 mb-6 font-medium italic">01</div>
                <h3 class="text-xl font-serif font-medium text-ink mb-4">White-Glove Delivery</h3>
                <p class="text-muted font-light leading-relaxed">We deliver, assemble, and place every item exactly where you want it. All packaging removed. Zero effort on your part.</p>
            </div>
            <div class="benefit-card">
                <div class="text-5xl font-serif text-champagne/30 mb-6 font-medium italic">02</div>
                <h3 class="text-xl font-serif font-medium text-ink mb-4">Total Flexibility</h3>
                <p class="text-muted font-light leading-relaxed">Swap, upgrade, or return items when your term ends. Your space evolves seamlessly with your changing tastes.</p>
            </div>
            <div class="benefit-card">
                <div class="text-5xl font-serif text-champagne/30 mb-6 font-medium italic">03</div>
                <h3 class="text-xl font-serif font-medium text-ink mb-4">Peace of Mind</h3>
                <p class="text-muted font-light leading-relaxed">Accidental damage or general wear? Our team handles repairs and replacements at no extra cost. Ever.</p>
            </div>
        </div>
    </div>
</section>

<!-- ============================================ -->
<!-- 3. STICKY STORYTELLING (CINEMATIC) -->
<!-- ============================================ -->
<section id="how-it-works" class="py-28 lg:py-36 px-6 lg:px-12 max-w-[1600px] mx-auto relative border-t" style="border-color: rgba(231,229,228,0.6); background: #FAFAF9;">
    <div class="max-w-3xl mb-20">
        <div class="section-eyebrow"><span class="dot"></span>The Process</div>
        <h2 class="section-title">Three steps.<br><span class="italic text-champagne">Beautifully simple.</span></h2>
        <p class="section-subtitle">A seamless journey designed to remove the friction of traditional ownership.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-16 relative">
        <div class="w-full lg:w-1/2 lg:pr-16">
            <div class="step-block min-h-[70vh] flex flex-col justify-center py-16 lg:py-0">
                <div class="inline-flex items-center gap-4 mb-10">
                    <span class="font-serif text-7xl text-champagne/25 italic font-medium">01</span>
                    <span class="h-[1px] w-12 bg-champagne/30"></span>
                </div>
                <h3 class="text-3xl font-serif font-medium text-ink mb-6">Choose your pieces.</h3>
                <p class="text-lg text-muted leading-relaxed font-light max-w-md">Browse our curated collection of premium furniture and appliances. Select the items that fit your aesthetic and choose a plan that aligns with your timeline.</p>
            </div>

            <div class="step-block min-h-[70vh] flex flex-col justify-center py-16 lg:py-0">
                <div class="inline-flex items-center gap-4 mb-10">
                    <span class="font-serif text-7xl text-champagne/25 italic font-medium">02</span>
                    <span class="h-[1px] w-12 bg-champagne/30"></span>
                </div>
                <h3 class="text-3xl font-serif font-medium text-ink mb-6">White-glove delivery.</h3>
                <p class="text-lg text-muted leading-relaxed font-light max-w-md">Our team brings everything to your door, assembles each piece in your preferred room, and removes all packaging — leaving you to simply enjoy.</p>
            </div>

            <div class="step-block min-h-[70vh] flex flex-col justify-center py-16 lg:py-0">
                <div class="inline-flex items-center gap-4 mb-10">
                    <span class="font-serif text-7xl text-champagne/25 italic font-medium">03</span>
                    <span class="h-[1px] w-12 bg-champagne/30"></span>
                </div>
                <h3 class="text-3xl font-serif font-medium text-ink mb-6">Live freely.</h3>
                <p class="text-lg text-muted leading-relaxed font-light max-w-md">When your plan ends, you're in control. Renew, swap for new pieces, buy them out, or schedule a free pickup. Your space evolves with you.</p>
            </div>
        </div>

        <div class="hidden lg:block w-1/2 h-screen sticky top-0 flex items-center justify-center py-20">
            <div class="w-full h-[80vh] relative bg-surface overflow-hidden">
                <img id="sticky-img-1" src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&q=80&w=800" class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-700" alt="Select furniture" loading="lazy">
                <img id="sticky-img-2" src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&q=80&w=800" class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-700" alt="Delivery service" loading="lazy">
                <img id="sticky-img-3" src="https://images.unsplash.com/photo-1583847268964-b28dc8f51f92?auto=format&fit=crop&q=80&w=800" class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-700" alt="Living freely" loading="lazy">
                <div class="absolute inset-0 bg-canvas/5"></div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================ -->
<!-- 4. PREMIUM COLLECTION GRID -->
<!-- ============================================ -->
<section class="py-28 lg:py-36 relative border-t" style="border-color: rgba(231,229,228,0.6);">
    <div class="px-6 lg:px-12 max-w-[1600px] mx-auto relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16">
            <div class="max-w-2xl">
                <div class="section-eyebrow"><span class="dot"></span>The Collection</div>
                <h2 class="section-title">Pieces our<br><span class="italic text-champagne">community loves.</span></h2>
            </div>
            <a href="<?= baseUrl('/shop') ?>" class="btn-ghost mt-6 md:mt-0">
                View All
                <span class="material-symbols-outlined text-sm ml-1">arrow_right_alt</span>
            </a>
        </div>

        <?php
        $allProducts = array_merge($furniture, $appliances);
        if (!empty($allProducts)):
        ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-20">
            <?php foreach (array_slice($allProducts, 0, 8) as $index => $product): ?>
            <a href="<?= baseUrl('/product-detail?id=' . ($product['id'] ?? 0)) ?>" class="product-card group block relative w-full outline-none focus-visible:ring-1 ring-champagne p-2 -m-2">
                <div class="aspect-[4/5] bg-surface relative overflow-hidden mb-6">
                    <img alt="<?= htmlspecialchars((string)($product['name'] ?? 'Product')) ?>"
                         src="<?= htmlspecialchars((string)($product['image_url'] ?? 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&q=80&w=600')) ?>"
                         class="absolute inset-0 w-full h-full object-cover transition-all duration-1000 group-hover:scale-105"
                         loading="lazy"
                         style="filter: grayscale(10%);" />
                    <div class="absolute inset-0 bg-ink/0 group-hover:bg-ink/5 transition-colors duration-700"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-canvas/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                        <span class="text-[11px] font-medium tracking-[0.2em] uppercase text-ink">View Details</span>
                    </div>
                </div>
                <div class="flex flex-col px-1">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-serif font-medium text-ink group-hover:text-champagne transition-colors duration-500">
                            <?= htmlspecialchars((string)($product['name'] ?? 'Premium Piece')) ?>
                        </h3>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-muted uppercase tracking-[0.15em] font-medium text-[10px]">
                            <?= htmlspecialchars((string)($product['category'] ?? 'Collection')) ?>
                        </span>
                        <span class="font-mono text-ink font-medium">
                            $<?= number_format((float)($product['monthly_price'] ?? 0), 0) ?><span class="text-muted-light font-sans text-[10px]">/mo</span>
                        </span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="py-20 text-center">
            <p class="text-muted font-light"><?= $error ? htmlspecialchars($error) : 'No products available at this time.' ?></p>
            <a href="<?= baseUrl('/shop') ?>" class="btn-primary mt-8 inline-flex">Browse All</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ============================================ -->
<!-- 5. CINEMATIC TESTIMONIALS -->
<!-- ============================================ -->
<section class="py-28 lg:py-36 relative border-t" style="border-color: rgba(231,229,228,0.6); background: #FAFAF9;">
    <div class="px-6 lg:px-12 max-w-[1600px] mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-20">
            <div class="section-eyebrow"><span class="dot"></span>Client Stories</div>
            <h2 class="section-title">What our<br><span class="italic text-champagne">members say.</span></h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
            <div class="testimonial-card p-10 lg:p-12 bg-surface border" style="border-color: rgba(231,229,228,0.6);">
                <div class="flex gap-1 mb-8 text-champagne">
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                </div>
                <p class="text-base text-muted leading-relaxed mb-10 font-light italic">"I moved to a new city and furnished my entire apartment in two days. The curation is impeccable — everything fits together effortlessly."</p>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-ink text-white flex items-center justify-center text-sm font-serif italic">SJ</div>
                    <div>
                        <h4 class="font-medium text-ink text-sm tracking-wide">Sarah Jenkins</h4>
                        <p class="text-[10px] text-muted-light uppercase tracking-[0.15em]">New York</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card p-10 lg:p-12 bg-surface border" style="border-color: rgba(231,229,228,0.6);">
                <div class="flex gap-1 mb-8 text-champagne">
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                </div>
                <p class="text-base text-muted leading-relaxed mb-10 font-light italic">"The delivery team was incredible. They carried a massive sofa up three flights and assembled it perfectly. Truly white-glove service."</p>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-ink text-white flex items-center justify-center text-sm font-serif italic">MR</div>
                    <div>
                        <h4 class="font-medium text-ink text-sm tracking-wide">Michael Ross</h4>
                        <p class="text-[10px] text-muted-light uppercase tracking-[0.15em]">Chicago</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card p-10 lg:p-12 bg-surface border" style="border-color: rgba(231,229,228,0.6);">
                <div class="flex gap-1 mb-8 text-champagne">
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                </div>
                <p class="text-base text-muted leading-relaxed mb-10 font-light italic">"I love changing my decor frequently. RentEase lets me swap pieces whenever I want a fresh look. It's interior design without commitment."</p>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-ink text-white flex items-center justify-center text-sm font-serif italic">AP</div>
                    <div>
                        <h4 class="font-medium text-ink text-sm tracking-wide">Anita Patel</h4>
                        <p class="text-[10px] text-muted-light uppercase tracking-[0.15em]">Los Angeles</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================ -->
<!-- 6. CINEMATIC CTA -->
<!-- ============================================ -->
<section class="py-32 lg:py-44 px-6 text-center relative border-t" style="border-color: rgba(231,229,228,0.6); background: #18181B;">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-champagne/5 rounded-full blur-[120px]"></div>
    </div>
    <div class="relative z-10 max-w-3xl mx-auto">
        <h2 class="text-4xl md:text-6xl font-serif font-medium tracking-tight text-white mb-8">
            Ready for a<br><span class="italic text-champagne">change?</span>
        </h2>
        <p class="text-lg text-white/60 font-light mb-14 max-w-lg mx-auto">Join thousands who have embraced spatial freedom. Start your first rental today.</p>
        <div class="flex flex-col sm:flex-row gap-5 justify-center">
            <a href="<?= baseUrl('/shop') ?>" class="inline-flex items-center justify-center px-12 py-5 bg-champagne text-ink text-[11px] font-medium tracking-[0.2em] uppercase transition-all duration-500 hover:bg-white outline-none focus-visible:ring-1 ring-champagne">Start Exploring</a>
            <a href="<?= baseUrl('/signup') ?>" class="inline-flex items-center justify-center px-12 py-5 bg-transparent text-white border border-white/20 text-[11px] font-medium tracking-[0.2em] uppercase transition-all duration-500 hover:border-champagne hover:text-champagne outline-none focus-visible:ring-1 ring-champagne">Create Account</a>
        </div>
    </div>
</section>

</main>

<!-- Home GSAP Animations -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    (window.RentEase ? RentEase.gsapReady : Promise.resolve(null)).then(function(gsap) {
        if (!gsap || !window.ScrollTrigger) {
            var l = document.getElementById('loader');
            if (l) { l.style.display = 'none'; }
            return;
        }
        gsap.registerPlugin(ScrollTrigger);

        gsap.context(() => {
            const tl = gsap.timeline();

            const loader = document.getElementById('loader');
            const loaderTl = document.getElementById('loader-tl');
            const loaderBr = document.getElementById('loader-br');
            const logoTl = document.getElementById('logo-tl');
            const logoBr = document.getElementById('logo-br');
            const loaderBgImgs = document.querySelectorAll('.loader-bg-img');

            tl.to(loaderBgImgs, { scale: 1.0, duration: 3.5, ease: "power1.out" }, 0)
              .to([logoTl, logoBr], { opacity: 1, scale: 1.0, duration: 1.5, ease: "power2.out" })
              .to(loaderTl, { x: -4, y: -4, duration: 0.8, ease: "expo.out" }, "+=0.3")
              .to(loaderBr, { x: 4, y: 4, duration: 0.8, ease: "expo.out" }, "<")
              .to(loaderTl, { xPercent: -100, yPercent: -100, duration: 1.6, ease: "expo.inOut" }, "+=0.5")
              .to(loaderBr, { xPercent: 100, yPercent: 100, duration: 1.6, ease: "expo.inOut" }, "<")
              .set(loader, { display: "none" })
              .from('#hero-img', { scale: 1.15, duration: 2.2, ease: "power2.out" }, "-=1.2")
              .to('.text-mask-inner', { y: '0%', duration: 1.2, ease: 'power4.out', stagger: 0.15 }, "-=1.3")
              .to('#hero-image-overlay', { clipPath: 'inset(0 0 0 100%)', duration: 1.5, ease: 'power4.inOut' }, "-=1.0")
              .to('#hero-img', { scale: 1, duration: 2.5, ease: 'power2.out' }, "-=1.5")
              .to('#hero-desc', { y: 0, opacity: 1, duration: 1, ease: 'power3.out' }, "-=2.0")
              .to('#hero-ctas', { y: 0, opacity: 1, duration: 1, ease: 'power3.out' }, "-=1.8")
              .to('.gsap-fade', { y: 0, opacity: 1, duration: 0.8, ease: 'power3.out' }, "-=1.5");

            gsap.utils.toArray('.benefit-card').forEach((card, i) => {
                gsap.from(card, { scrollTrigger: { trigger: card, start: 'top 85%' }, y: 40, opacity: 0, duration: 1.2, ease: 'power3.out', delay: i * 0.1 });
            });

            const steps = document.querySelectorAll('.step-block');
            const images = [
                document.getElementById('sticky-img-1'),
                document.getElementById('sticky-img-2'),
                document.getElementById('sticky-img-3')
            ];
            if (steps.length > 0 && images[0]) {
                steps.forEach((step, index) => {
                    ScrollTrigger.create({
                        trigger: step, start: "top center", end: "bottom center",
                        onToggle: self => {
                            if (self.isActive && images[index]) {
                                images.forEach(img => { if (img) gsap.to(img, { opacity: 0, duration: 0.8, ease: 'power2.inOut' }); });
                                gsap.to(images[index], { opacity: 1, duration: 0.8, ease: 'power2.inOut' });
                            }
                        }
                    });
                });
            }

            gsap.utils.toArray('.product-card').forEach((card, i) => {
                gsap.from(card, { scrollTrigger: { trigger: card, start: 'top 85%' }, y: 60, opacity: 0, duration: 1.2, ease: 'power3.out', delay: i * 0.08 });
            });
            gsap.utils.toArray('.testimonial-card').forEach((card, i) => {
                gsap.from(card, { scrollTrigger: { trigger: card, start: 'top 85%' }, y: 40, opacity: 0, duration: 1.2, ease: 'power3.out', delay: i * 0.1 });
            });
        });
    });
});
</script>

<?php require __DIR__ . '/partials/footer.php'; ?>
