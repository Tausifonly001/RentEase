<?php
$profileLink = $profileLink ?? '/login';
$currentYear = date('Y');
?>
</main>

<footer class="bg-canvas text-muted font-sans w-full pt-24 pb-32 md:pb-24 border-t relative overflow-hidden" style="border-color: rgba(231,229,228,0.6);">
    <div class="absolute inset-0 bg-champagne/5 pointer-events-none"></div>
    <div class="relative max-w-[1600px] mx-auto px-6 lg:px-12">

        <!-- Newsletter -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center pb-20 mb-20 border-b" style="border-color: rgba(231,229,228,0.6);">
            <div>
                <h2 class="text-3xl md:text-5xl font-serif font-medium text-ink tracking-tight leading-[1.1] mb-4">
                    Make your space<br><span class="italic text-champagne">extraordinary.</span>
                </h2>
                <p class="text-muted text-lg leading-relaxed max-w-md font-light">
                    New collections, design insights, and member exclusives. No noise, ever.
                </p>
            </div>
            <form class="flex flex-col sm:flex-row gap-0 w-full lg:max-w-md ml-auto" onsubmit="event.preventDefault(); window.RentEase?.toast?.success('You\'re subscribed.'); this.reset();">
                <label class="sr-only" for="footer-email">Email address</label>
                <div class="relative flex-1">
                    <input id="footer-email" name="email" type="email" required placeholder="Email Address" class="w-full bg-transparent border-b text-ink placeholder-muted-light focus:outline-none focus:border-champagne focus:ring-0 transition-colors duration-500 font-light rounded-none py-4 px-0" style="border-color: rgba(231,229,228,0.8);">
                </div>
                <button type="submit" class="px-8 py-4 bg-ink hover:bg-champagne hover:text-ink text-white text-[11px] font-medium tracking-[0.2em] uppercase transition-all duration-500 whitespace-nowrap outline-none focus-visible:ring-1 ring-champagne">Subscribe</button>
            </form>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-10 lg:gap-8 mb-20">
            <div class="col-span-2 md:col-span-3 lg:col-span-2 flex flex-col gap-6">
                <a href="<?= baseUrl('/') ?>" class="inline-flex items-center gap-3 text-2xl font-serif font-bold text-ink tracking-tighter hover:opacity-70 transition-opacity w-fit outline-none focus-visible:ring-1 ring-champagne">
                    <span class="w-8 h-8 flex items-center justify-center bg-ink text-white text-xs font-medium">R</span>
                    RentEase.
                </a>
                <p class="text-muted leading-relaxed max-w-sm font-light text-sm">
                    Premium furniture and appliances on flexible monthly plans. Curated for the modern home.
                </p>
                <div class="flex gap-4 mt-2">
                    <span class="material-symbols-outlined text-muted-light text-xl">cruelty_free</span>
                    <span class="material-symbols-outlined text-muted-light text-xl">recycling</span>
                    <span class="material-symbols-outlined text-muted-light text-xl">handshake</span>
                </div>
            </div>

            <div class="flex flex-col gap-5">
                <h4 class="font-medium text-ink uppercase tracking-[0.2em] text-[10px]">Shop</h4>
                <a class="hover:text-ink transition-colors text-sm font-light w-fit outline-none focus-visible:text-ink" href="<?= baseUrl('/shop?category=Furniture') ?>">Furniture</a>
                <a class="hover:text-ink transition-colors text-sm font-light w-fit outline-none focus-visible:text-ink" href="<?= baseUrl('/shop?category=Appliances') ?>">Appliances</a>
                <a class="hover:text-ink transition-colors text-sm font-light w-fit outline-none focus-visible:text-ink" href="<?= baseUrl('/shop') ?>">Collections</a>
            </div>

            <div class="flex flex-col gap-5">
                <h4 class="font-medium text-ink uppercase tracking-[0.2em] text-[10px]">Company</h4>
                <a class="hover:text-ink transition-colors text-sm font-light w-fit outline-none focus-visible:text-ink" href="<?= baseUrl('/about') ?>">Our Story</a>
                <a class="hover:text-ink transition-colors text-sm font-light w-fit outline-none focus-visible:text-ink" href="<?= baseUrl('/partner') ?>">Partner</a>
                <a class="hover:text-ink transition-colors text-sm font-light w-fit outline-none focus-visible:text-ink" href="<?= baseUrl('/concierge') ?>">Concierge</a>
            </div>

            <div class="flex flex-col gap-5">
                <h4 class="font-medium text-ink uppercase tracking-[0.2em] text-[10px]">Support</h4>
                <a class="hover:text-ink transition-colors text-sm font-light w-fit outline-none focus-visible:text-ink" href="<?= baseUrl('/help-center') ?>">Help Center</a>
                <a class="hover:text-ink transition-colors text-sm font-light w-fit outline-none focus-visible:text-ink" href="<?= baseUrl('/tracking') ?>">Track Order</a>
                <a class="hover:text-ink transition-colors text-sm font-light w-fit outline-none focus-visible:text-ink" href="<?= baseUrl('/terms') ?>">Terms & Privacy</a>
            </div>
        </div>

        <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-6 border-t" style="border-color: rgba(231,229,228,0.4);">
            <p class="text-xs text-muted-light font-light tracking-wide">
                &copy; <?= $currentYear ?> RentEase. All rights reserved.
            </p>
            <div class="flex gap-8 text-[10px] uppercase tracking-[0.15em] text-muted-light font-medium">
                <a href="<?= baseUrl('/privacy') ?>" class="hover:text-ink transition-colors duration-300 outline-none focus-visible:text-ink">Privacy</a>
                <a href="<?= baseUrl('/terms') ?>" class="hover:text-ink transition-colors duration-300 outline-none focus-visible:text-ink">Terms</a>
            </div>
        </div>
    </div>
</footer>

<!-- Mobile Bottom Nav -->
<nav class="bg-canvas/90 backdrop-blur-md text-muted font-sans text-[10px] font-medium tracking-wide fixed bottom-0 w-full z-50 border-t md:hidden" style="border-color: rgba(231,229,228,0.6); box-shadow: 0 -4px 20px rgba(24,24,27,0.03);" aria-label="Mobile navigation">
    <div class="flex justify-around items-center px-2 py-1">
        <a href="<?= baseUrl('/') ?>" class="flex flex-col items-center justify-center hover:text-ink active:scale-95 transition-all duration-200 px-4 py-2 outline-none focus-visible:text-ink">
            <span class="material-symbols-outlined mb-0.5 text-[22px] font-light">home</span>
            <span>Home</span>
        </a>
        <a href="<?= baseUrl('/shop') ?>" class="flex flex-col items-center justify-center hover:text-ink active:scale-95 transition-all duration-200 px-4 py-2 outline-none focus-visible:text-ink">
            <span class="material-symbols-outlined mb-0.5 text-[22px] font-light">search</span>
            <span>Explore</span>
        </a>
        <a href="<?= baseUrl('/cart') ?>" class="flex flex-col items-center justify-center hover:text-ink active:scale-95 transition-all duration-200 px-4 py-2 outline-none focus-visible:text-ink">
            <span class="material-symbols-outlined mb-0.5 text-[22px] font-light">shopping_bag</span>
            <span>Cart</span>
        </a>
        <a href="<?= baseUrl($profileLink) ?>" class="flex flex-col items-center justify-center hover:text-ink active:scale-95 transition-all duration-200 px-4 py-2 outline-none focus-visible:text-ink">
            <span class="material-symbols-outlined mb-0.5 text-[22px] font-light">person</span>
            <span>Profile</span>
        </a>
    </div>
</nav>

</body>
</html>
