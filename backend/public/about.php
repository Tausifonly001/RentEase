<?php
declare(strict_types=1);

require __DIR__ . '/../bootstrap.php';

$pageTitle = "About Us - RentEase";
require __DIR__ . '/partials/header.php';
?>

<main class="w-full relative bg-white">

    <!-- 1. EDITORIAL HERO SECTION -->
    <section class="relative w-full min-h-[70vh] flex items-center px-6 lg:px-12 pt-32 pb-20 max-w-[1600px] mx-auto border-b border-zinc-200 overflow-hidden">
        
        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center w-full">
            <div>
                <h1 class="text-6xl md:text-7xl font-serif font-medium tracking-tight text-ink leading-[1.05] mb-8">
                    Redefining<br>ownership.
                </h1>
                <p class="text-xl text-zinc-500 font-light leading-relaxed mb-12 max-w-lg">
                    At RentEase, we believe that life is about experiences, not just possessions. We're on a mission to make premium living accessible through flexible, sustainable, and hassle-free rentals.
                </p>
                <div class="flex flex-col sm:flex-row gap-6">
                    <a href="<?= baseUrl('/shop') ?>" class="px-10 py-4 bg-ink text-white hover:bg-zinc-800 text-[11px] font-medium tracking-[0.2em] uppercase transition-colors flex items-center justify-center outline-none focus-visible:ring-1 ring-ink border border-ink">
                        Explore Catalog
                    </a>
                    <a href="#our-story" class="px-10 py-4 bg-transparent text-ink border border-zinc-300 hover:border-ink text-[11px] font-medium tracking-[0.2em] uppercase transition-colors flex items-center justify-center outline-none focus-visible:ring-1 ring-ink">
                        Our Story
                    </a>
                </div>
            </div>
            <div class="relative hidden lg:block">
                <div class="aspect-[4/5] bg-surface relative">
                    <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&q=80&w=1000" class="absolute inset-0 w-full h-full object-cover grayscale-[20%]" alt="Premium Living Space">
                </div>
            </div>
        </div>
    </section>

    <!-- 2. OUR STORY -->
    <section id="our-story" class="py-32 relative bg-surface border-b border-zinc-200">
        <div class="max-w-[1600px] mx-auto px-6 lg:px-12 grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div class="order-2 lg:order-1 relative">
                <div class="aspect-square bg-white relative max-w-md mx-auto p-4 border border-zinc-200">
                    <img src="https://images.unsplash.com/photo-1542314831-c53cd4b85aca?auto=format&fit=crop&q=80&w=1000" class="w-full h-full object-cover grayscale-[30%]" alt="Founder Story">
                </div>
                <!-- Floating badge -->
                <div class="absolute bottom-10 right-10 lg:-right-4 bg-white border border-zinc-200 p-8 shadow-sm">
                    <div class="text-4xl font-serif font-medium text-ink mb-2">2023</div>
                    <div class="text-[10px] text-zinc-400 font-medium uppercase tracking-[0.2em]">Year Founded</div>
                </div>
            </div>
            <div class="order-1 lg:order-2">
                <h2 class="text-4xl md:text-5xl font-serif font-medium tracking-tight text-ink mb-10">
                    Born from a<br><span class="text-zinc-400">nomadic spirit.</span>
                </h2>
                <div class="space-y-8 text-lg text-zinc-500 font-light leading-relaxed max-w-lg">
                    <p>
                        We started RentEase when we realized how much friction was involved in moving. Buying furniture, assembling it, and then figuring out what to do with it when moving again felt like a relic of the past.
                    </p>
                    <p>
                        We envisioned a world where you could live in a beautifully furnished home without being tied down by your belongings. A service that adapts to your life, not the other way around.
                    </p>
                    <p>
                        Today, we serve thousands of members who value flexibility, design, and sustainability over traditional ownership.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. OUR VALUES -->
    <section class="py-32 relative bg-white">
        <div class="max-w-[1600px] mx-auto px-6 lg:px-12">
            <div class="mb-24 max-w-2xl">
                <h2 class="text-5xl md:text-6xl font-serif font-medium tracking-tight text-ink mb-6">
                    Our Values.
                </h2>
                <p class="text-lg text-zinc-500 font-light leading-relaxed">The foundational principles that guide our curation, service, and vision for the future.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 lg:gap-16">
                <!-- Value 1 -->
                <div class="border-t border-zinc-200 pt-8">
                    <div class="text-zinc-300 font-serif text-5xl mb-6">I.</div>
                    <h3 class="text-2xl font-serif font-medium text-ink mb-4">Sustainability</h3>
                    <p class="text-zinc-500 font-light leading-relaxed">
                        Reducing waste by promoting a circular economy. Why buy when you can share? We extend the lifecycle of premium products, ensuring nothing goes to landfill prematurely.
                    </p>
                </div>
                
                <!-- Value 2 -->
                <div class="border-t border-zinc-200 pt-8">
                    <div class="text-zinc-300 font-serif text-5xl mb-6">II.</div>
                    <h3 class="text-2xl font-serif font-medium text-ink mb-4">Flexibility</h3>
                    <p class="text-zinc-500 font-light leading-relaxed">
                        Life changes fast. Our rental terms adapt to your needs, whether it's 3 months or 3 years. Upgrade, swap, or return whenever your circumstances evolve.
                    </p>
                </div>
                
                <!-- Value 3 -->
                <div class="border-t border-zinc-200 pt-8">
                    <div class="text-zinc-300 font-serif text-5xl mb-6">III.</div>
                    <h3 class="text-2xl font-serif font-medium text-ink mb-4">Quality</h3>
                    <p class="text-zinc-500 font-light leading-relaxed">
                        We only offer premium, well-maintained products that meet our rigorous aesthetic and functional standards. Every item is professionally cleaned and sanitized.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. STATS -->
    <section class="py-32 relative border-t border-zinc-200 bg-surface">
        <div class="max-w-[1600px] mx-auto px-6 lg:px-12 grid grid-cols-2 md:grid-cols-4 gap-16 lg:gap-10 text-center relative z-10">
            <div>
                <div class="text-6xl lg:text-7xl font-serif font-medium text-ink mb-4">10k<span class="text-zinc-300">+</span></div>
                <div class="text-zinc-500 uppercase tracking-[0.2em] text-[10px] font-medium">Active Members</div>
            </div>
            <div>
                <div class="text-6xl lg:text-7xl font-serif font-medium text-ink mb-4">500<span class="text-zinc-300">+</span></div>
                <div class="text-zinc-500 uppercase tracking-[0.2em] text-[10px] font-medium">Premium Items</div>
            </div>
            <div>
                <div class="text-6xl lg:text-7xl font-serif font-medium text-ink mb-4">24/7</div>
                <div class="text-zinc-500 uppercase tracking-[0.2em] text-[10px] font-medium">Concierge Support</div>
            </div>
            <div>
                <div class="text-6xl lg:text-7xl font-serif font-medium text-ink mb-4">4.9<span class="text-zinc-300 text-4xl">/5</span></div>
                <div class="text-zinc-500 uppercase tracking-[0.2em] text-[10px] font-medium">Average Rating</div>
            </div>
        </div>
    </section>

</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
