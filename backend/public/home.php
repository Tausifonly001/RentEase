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


<main class="w-full relative bg-white">

<!-- 1. EDITORIAL HERO SECTION -->
<section class="relative w-full min-h-screen flex items-center px-6 lg:px-12 pt-20 max-w-[1600px] mx-auto overflow-hidden">
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 w-full items-center">
        <!-- Text Column -->
        <div class="relative z-10 w-full max-w-2xl order-2 lg:order-1">
            <div class="mb-8">
                <h1 class="text-6xl md:text-7xl lg:text-[6.5rem] font-serif tracking-tight text-ink leading-[1.05]" id="hero-title">
                    <span class="text-mask"><span class="text-mask-inner">Design your</span></span><br>
                    <span class="text-mask"><span class="text-mask-inner italic text-champagne">space.</span></span>
                </h1>
            </div>
            <div class="overflow-hidden mb-12 max-w-lg">
                <p class="text-lg md:text-xl text-zinc-500 font-light leading-relaxed opacity-0" id="hero-desc">
                    Curated furniture and smart appliances. Flexible terms. White-glove delivery included.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-6 opacity-0" id="hero-ctas">
                <a href="<?= baseUrl('/shop') ?>" class="px-10 py-4 bg-ink text-white hover:bg-champagne hover:text-ink hover:border-champagne text-[11px] font-medium tracking-[0.2em] uppercase transition-all duration-500 flex items-center justify-center outline-none focus-visible:ring-1 ring-champagne border border-ink">
                    Explore Collection
                </a>
                <a href="#how-it-works" class="px-10 py-4 bg-transparent text-ink border border-zinc-200 hover:border-champagne hover:text-champagne text-[11px] font-medium tracking-[0.2em] uppercase transition-all duration-500 flex items-center justify-center outline-none focus-visible:ring-1 ring-champagne">
                    How it Works
                </a>
            </div>
        </div>
        
        <!-- Image Column -->
        <div class="relative z-10 w-full h-[60vh] lg:h-[85vh] order-1 lg:order-2 overflow-hidden bg-surface" id="hero-img-container">
            <div class="absolute inset-0 bg-champagne/10 z-10 clip-reveal" id="hero-image-overlay"></div>
            <img src="<?= baseUrl('/assets/images/home_hero.png') ?>" alt="Ultra luxury living room" class="w-full h-full object-cover origin-center scale-110 grayscale-[15%]" id="hero-img">
        </div>
    </div>
</section>

<!-- 2. EDITORIAL BENEFITS -->
<section class="py-32 relative border-t border-zinc-200">
    <div class="px-6 lg:px-12 max-w-[1600px] mx-auto grid grid-cols-1 md:grid-cols-3 gap-16 lg:gap-24 text-left">
        <div class="benefit-card border-l border-zinc-200 pl-8">
            <h3 class="text-xl font-serif font-medium text-ink mb-4">I. Delivery</h3>
            <p class="text-zinc-500 font-light leading-relaxed">White-glove delivery and assembly in your space. We handle the heavy lifting, allowing you to simply enjoy.</p>
        </div>
        <div class="benefit-card border-l border-zinc-200 pl-8">
            <h3 class="text-xl font-serif font-medium text-ink mb-4">II. Flexibility</h3>
            <p class="text-zinc-500 font-light leading-relaxed">Swap, upgrade, or return items when your term ends. Your space evolves seamlessly with your lifestyle.</p>
        </div>
        <div class="benefit-card border-l border-zinc-200 pl-8">
            <h3 class="text-xl font-serif font-medium text-ink mb-4">III. Maintenance</h3>
            <p class="text-zinc-500 font-light leading-relaxed">Accidental damage or general wear? Our dedicated team handles repairs and replacements at no extra cost.</p>
        </div>
    </div>
</section>

<!-- 3. STICKY STORYTELLING -->
<section id="how-it-works" class="py-32 px-6 lg:px-12 max-w-[1600px] mx-auto relative border-t border-zinc-200 bg-surface">
    <div class="text-left mb-24 max-w-2xl">
        <h2 class="text-5xl md:text-6xl font-serif font-medium tracking-tight text-ink mb-6">
            Beautifully simple.
        </h2>
        <p class="text-zinc-500 text-lg font-light leading-relaxed">A seamless process designed to remove the friction of traditional ownership.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-20 relative">
        <!-- Left: Text Scroller -->
        <div class="w-full lg:w-1/2 py-[10vh] lg:pr-16">
            <div class="step-block min-h-[70vh] flex flex-col justify-center">
                <div class="text-zinc-300 font-serif text-6xl mb-8">01.</div>
                <h3 class="text-3xl font-serif font-medium text-ink mb-6">Choose your pieces.</h3>
                <p class="text-lg text-zinc-500 leading-relaxed font-light">Browse our curated collection of premium furniture and appliances. Select the items that fit your aesthetic and choose a rental plan that aligns with your timeline.</p>
            </div>
            
            <div class="step-block min-h-[70vh] flex flex-col justify-center">
                <div class="text-zinc-300 font-serif text-6xl mb-8">02.</div>
                <h3 class="text-3xl font-serif font-medium text-ink mb-6">White-glove delivery.</h3>
                <p class="text-lg text-zinc-500 leading-relaxed font-light">Our delivery team brings everything to your door, assembles the furniture in your preferred room, and removes all packaging.</p>
            </div>
            
            <div class="step-block min-h-[70vh] flex flex-col justify-center">
                <div class="text-zinc-300 font-serif text-6xl mb-8">03.</div>
                <h3 class="text-3xl font-serif font-medium text-ink mb-6">Live freely.</h3>
                <p class="text-lg text-zinc-500 leading-relaxed font-light">When your plan ends, you're in control. Renew your rental, swap for new pieces, buy them out, or schedule a free pickup.</p>
            </div>
        </div>

        <!-- Right: Sticky Image -->
        <div class="hidden lg:block w-1/2 h-screen sticky top-0 flex items-center justify-center py-20">
            <div class="w-full h-full relative bg-white">
                <img id="sticky-img-1" src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&q=80&w=1000" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700" alt="Select">
                <img id="sticky-img-2" src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&q=80&w=1000" class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-700" alt="Deliver">
                <img id="sticky-img-3" src="https://images.unsplash.com/photo-1583847268964-b28dc8f51f92?auto=format&fit=crop&q=80&w=1000" class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-700" alt="Enjoy">
            </div>
        </div>
    </div>
</section>

<!-- 4. AIRY PRODUCT GRID -->
<section class="py-32 relative border-t border-zinc-200">
    <div class="px-6 lg:px-12 max-w-[1600px] mx-auto relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-end mb-20">
            <div>
                <h2 class="text-4xl md:text-5xl font-serif font-medium tracking-tight text-ink mb-4">
                    The Collection.
                </h2>
                <p class="text-lg text-zinc-500 font-light">Pieces our community loves.</p>
            </div>
            <a href="<?= baseUrl('/shop') ?>" class="text-[11px] font-medium tracking-[0.2em] uppercase text-ink hover:opacity-60 transition-opacity border-b border-ink pb-1 mt-6 md:mt-0 outline-none focus-visible:ring-1 ring-ink">
                View All
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-16">
            <?php
            $allProducts = array_merge($furniture, $appliances);
            if (!empty($allProducts)): 
                foreach (array_slice($allProducts, 0, 8) as $index => $product): 
            ?>
            <a href="<?= baseUrl('/product-detail?id=' . ($product['id'] ?? 0)) ?>" class="group block relative w-full outline-none focus-visible:ring-1 ring-ink p-2 -m-2">
                <!-- Image Container -->
                <div class="aspect-[4/5] bg-surface relative overflow-hidden mb-6">
                    <img alt="<?= htmlspecialchars((string)($product['name'] ?? 'Product')) ?>"
                         src="<?= htmlspecialchars((string)($product['image_url'] ?? 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&q=80&w=600')) ?>"
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" />
                    <div class="absolute inset-0 bg-ink/0 group-hover:bg-ink/5 transition-colors duration-500"></div>
                </div>

                <!-- Text Content -->
                <div class="flex flex-col">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-serif font-medium text-ink">
                            <?= htmlspecialchars((string)($product['name'] ?? 'Premium Piece')) ?>
                        </h3>
                        <span class="text-ink font-medium text-sm">$<?= number_format((float)($product['monthly_price'] ?? 0), 0) ?></span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-zinc-500 uppercase tracking-widest font-medium">
                            <?= htmlspecialchars((string)($product['category'] ?? 'Collection')) ?>
                        </span>
                        <span class="text-zinc-400 font-light">/mo</span>
                    </div>
                </div>
            </a>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>

<!-- 5. TESTIMONIALS -->
<section class="py-32 relative border-t border-zinc-200 bg-surface">
    <div class="px-6 lg:px-12 max-w-[1600px] mx-auto">
        <h2 class="text-4xl md:text-5xl font-serif font-medium tracking-tight text-ink mb-24 text-center">
            Client Stories
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-16 text-left">
            <div class="flex flex-col">
                <p class="text-lg text-zinc-600 leading-relaxed mb-10 font-light italic">"I moved to a new city and furnished my entire apartment in two days without spending a fortune. The curation is impeccable."</p>
                <div class="mt-auto">
                    <h4 class="font-medium text-ink tracking-wide">Sarah Jenkins</h4>
                    <p class="text-xs text-zinc-400 uppercase tracking-widest mt-1">New York</p>
                </div>
            </div>

            <div class="flex flex-col">
                <p class="text-lg text-zinc-600 leading-relaxed mb-10 font-light italic">"The delivery team was so professional. They carried a massive sofa up three flights of stairs and assembled it perfectly."</p>
                <div class="mt-auto">
                    <h4 class="font-medium text-ink tracking-wide">Michael Ross</h4>
                    <p class="text-xs text-zinc-400 uppercase tracking-widest mt-1">Chicago</p>
                </div>
            </div>

            <div class="flex flex-col">
                <p class="text-lg text-zinc-600 leading-relaxed mb-10 font-light italic">"I love changing my decor frequently. RentEase lets me swap out my dining set whenever I want a fresh look. Highly recommend."</p>
                <div class="mt-auto">
                    <h4 class="font-medium text-ink tracking-wide">Anita Patel</h4>
                    <p class="text-xs text-zinc-400 uppercase tracking-widest mt-1">Los Angeles</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 6. FOOTER CTA -->
<section class="py-40 px-6 text-center border-t border-zinc-200 relative bg-white">
    <div class="relative z-10 max-w-3xl mx-auto">
        <h2 class="text-5xl md:text-6xl font-serif font-medium tracking-tight text-ink mb-8">
            Ready for a change?
        </h2>
        <p class="text-xl text-zinc-500 font-light mb-16">Join thousands who have embraced spatial freedom.</p>
        <div>
            <a href="<?= baseUrl('/shop') ?>" class="inline-flex items-center justify-center px-12 py-5 bg-ink text-white hover:bg-zinc-800 text-[11px] font-medium tracking-[0.2em] uppercase transition-colors outline-none focus-visible:ring-1 ring-ink border border-ink">
                Start Exploring
            </a>
        </div>
    </div>
</section>

<!-- Home GSAP Initialization -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const checkHomeGsap = setInterval(() => {
        if (window.gsap && window.ScrollTrigger) {
            clearInterval(checkHomeGsap);
            gsap.registerPlugin(ScrollTrigger);
            
            let ctx = gsap.context(() => {
                // Hero entrance
                const tl = gsap.timeline();
                
                // Text Reveal
                tl.to('.text-mask-inner', {
                    y: '0%',
                    duration: 1.2,
                    ease: 'power4.out',
                    stagger: 0.15
                });

                // Image Reveal (Curtain effect)
                tl.to('#hero-image-overlay', {
                    clipPath: 'inset(0 0 0 100%)',
                    duration: 1.5,
                    ease: 'power4.inOut'
                }, "-=1.0");

                // Image Scale down
                tl.to('#hero-img', {
                    scale: 1,
                    duration: 2.5,
                    ease: 'power2.out'
                }, "-=1.5");

                // Fade up desc and ctas
                tl.to('#hero-desc', { y: 0, opacity: 1, duration: 1, ease: 'power2.out' }, "-=2.0");
                tl.to('#hero-ctas', { y: 0, opacity: 1, duration: 1, ease: 'power2.out' }, "-=1.8");

                // Benefit cards
                gsap.fromTo('.benefit-card', 
                    { y: 30, opacity: 0 },
                    { 
                        y: 0, opacity: 1, duration: 1, stagger: 0.15, ease: 'power2.out',
                        scrollTrigger: { trigger: '.benefit-card', start: 'top 85%' }
                    }
                );

                // Storytelling sticky logic
                const steps = document.querySelectorAll('.step-block');
                const images = [
                    document.getElementById('sticky-img-1'),
                    document.getElementById('sticky-img-2'),
                    document.getElementById('sticky-img-3')
                ];

                if (steps.length > 0 && images[0]) {
                    steps.forEach((step, index) => {
                        ScrollTrigger.create({
                            trigger: step,
                            start: "top center",
                            end: "bottom center",
                            onToggle: self => {
                                if (self.isActive && images[index]) {
                                    images.forEach(img => {
                                        if (img) gsap.to(img, { opacity: 0, duration: 0.8, ease: 'power2.inOut' });
                                    });
                                    gsap.to(images[index], { opacity: 1, duration: 0.8, ease: 'power2.inOut' });
                                }
                            }
                        });
                    });
                }
            });
        }
    }, 100);
});
</script>

</main>

<?php require __DIR__ . '/partials/footer.php'; ?>?>