<?php
/** @var array $config */
$profileLink = $profileLink ?? '/login';
$currentYear = date('Y');
?>
</main>

<!-- =============================================================================
     LUXURY MINIMAL FOOTER
     ============================================================================= -->
<footer class="bg-white text-zinc-500 font-sans w-full pt-24 pb-12 border-t border-zinc-200 mt-24 relative overflow-hidden">
    <div class="relative max-w-[1600px] mx-auto px-6 lg:px-12">
        
        <!-- Newsletter Band -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center pb-20 mb-20 border-b border-zinc-200">
            <div>
                <h2 class="text-3xl md:text-5xl font-serif font-bold text-ink tracking-tight leading-[1.1] mb-4">
                    Make your space extraordinary.
                </h2>
                <p class="text-zinc-500 text-lg leading-relaxed max-w-md font-light">
                    New collections, design tips, and member-only offers. No spam, ever.
                </p>
            </div>
            <form class="flex flex-col sm:flex-row gap-0 w-full lg:max-w-md ml-auto" onsubmit="event.preventDefault(); window.RentEase?.toast?.success('You\'re subscribed.'); this.reset();">
                <label class="sr-only" for="footer-newsletter-email">Email address</label>
                <div class="relative flex-1">
                    <input id="footer-newsletter-email" name="email" type="email" required placeholder="Email Address" class="w-full bg-transparent border-b border-zinc-300 py-4 px-0 text-ink focus:outline-none focus:border-ink focus:ring-0 transition-colors placeholder-zinc-400 font-light rounded-none">
                </div>
                <button type="submit" class="px-8 py-4 bg-ink hover:bg-zinc-800 text-white font-medium text-[11px] tracking-[0.2em] uppercase transition-colors whitespace-nowrap outline-none focus-visible:ring-1 ring-ink border border-ink">
                    Subscribe
                </button>
            </form>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-10 lg:gap-8 mb-20">
            <!-- Brand Column -->
            <div class="col-span-2 md:col-span-3 lg:col-span-2 flex flex-col gap-6">
                <a href="<?= baseUrl('/') ?>" class="inline-flex items-center text-3xl font-serif font-bold text-ink tracking-tighter hover:opacity-70 transition-opacity w-fit outline-none focus-visible:ring-1 ring-ink">
                    RentEase.
                </a>
                <p class="text-zinc-500 leading-relaxed max-w-sm font-light">
                    Premium furniture and appliances on flexible monthly plans. Designed for modern living.
                </p>
            </div>

            <!-- Shop -->
            <div class="flex flex-col gap-5">
                <h4 class="font-medium text-ink uppercase tracking-[0.2em] text-[10px]">Shop</h4>
                <a class="hover:text-ink transition-colors text-sm font-light w-fit outline-none focus-visible:text-ink" href="<?= baseUrl('/shop?category=Furniture') ?>">Furniture</a>
                <a class="hover:text-ink transition-colors text-sm font-light w-fit outline-none focus-visible:text-ink" href="<?= baseUrl('/shop?category=Appliances') ?>">Appliances</a>
                <a class="hover:text-ink transition-colors text-sm font-light w-fit outline-none focus-visible:text-ink" href="<?= baseUrl('/shop') ?>">Packages</a>
            </div>

            <!-- Company -->
            <div class="flex flex-col gap-5">
                <h4 class="font-medium text-ink uppercase tracking-[0.2em] text-[10px]">Company</h4>
                <a class="hover:text-ink transition-colors text-sm font-light w-fit outline-none focus-visible:text-ink" href="<?= baseUrl('/about') ?>">About Us</a>
                <a class="hover:text-ink transition-colors text-sm font-light w-fit outline-none focus-visible:text-ink" href="<?= baseUrl('/partner') ?>">Partner With Us</a>
                <a class="hover:text-ink transition-colors text-sm font-light w-fit outline-none focus-visible:text-ink" href="<?= baseUrl('/concierge') ?>">Concierge</a>
            </div>

            <!-- Support -->
            <div class="flex flex-col gap-5">
                <h4 class="font-medium text-ink uppercase tracking-[0.2em] text-[10px]">Support</h4>
                <a class="hover:text-ink transition-colors text-sm font-light w-fit outline-none focus-visible:text-ink" href="<?= baseUrl('/help-center') ?>">Help Center</a>
                <a class="hover:text-ink transition-colors text-sm font-light w-fit outline-none focus-visible:text-ink" href="<?= baseUrl('/tracking') ?>">Track Delivery</a>
                <a class="hover:text-ink transition-colors text-sm font-light w-fit outline-none focus-visible:text-ink" href="<?= baseUrl('/terms') ?>">Terms & Privacy</a>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <p class="text-xs text-zinc-400 font-light tracking-wide">
                &copy; <?= $currentYear ?> RentEase. All rights reserved.
            </p>
        </div>
    </div>
</footer>

<!-- =============================================================================
     MOBILE BOTTOM NAV
     ============================================================================= -->
<nav class="bg-white/95 backdrop-blur-md text-zinc-500 font-sans text-[10px] font-medium tracking-wide fixed bottom-0 w-full z-50 border-t border-zinc-200 shadow-[0_-4px_20px_rgba(0,0,0,0.03)] md:hidden" aria-label="Mobile bottom navigation">
    <div class="flex justify-around items-center px-2 py-2">
        <a href="<?= baseUrl('/') ?>" class="flex flex-col items-center justify-center hover:text-ink active:scale-95 transition-all duration-200 px-4 py-1.5 rounded-none outline-none focus-visible:text-ink">
            <span class="material-symbols-outlined mb-1 text-[22px] font-light">home</span>
            Home
        </a>
        <a href="<?= baseUrl('/shop') ?>" class="flex flex-col items-center justify-center hover:text-ink active:scale-95 transition-all duration-200 px-4 py-1.5 rounded-none outline-none focus-visible:text-ink">
            <span class="material-symbols-outlined mb-1 text-[22px] font-light">search</span>
            Explore
        </a>
        <a href="<?= baseUrl('/cart') ?>" class="flex flex-col items-center justify-center hover:text-ink active:scale-95 transition-all duration-200 px-4 py-1.5 rounded-none outline-none focus-visible:text-ink">
            <span class="material-symbols-outlined mb-1 text-[22px] font-light">shopping_bag</span>
            Cart
        </a>
        <a href="<?= baseUrl($profileLink) ?>" class="flex flex-col items-center justify-center hover:text-ink active:scale-95 transition-all duration-200 px-4 py-1.5 rounded-none outline-none focus-visible:text-ink">
            <span class="material-symbols-outlined mb-1 text-[22px] font-light">person</span>
            Profile
        </a>
    </div>
</nav>

</body>
</html>
