<?php
/** @var array $config */
$profileLink = $profileLink ?? '/login';
$currentYear = date('Y');
?>
</main>

<!-- =============================================================================
     PREMIUM FOOTER
     ============================================================================= -->
<footer class="bg-slate-50 text-slate-900 font-sans w-full pt-20 pb-32 md:pb-12 border-t border-slate-200/70 mt-24 relative overflow-hidden">

    <!-- Subtle background accent -->
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-teal-500/5 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-emerald-500/5 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>

    <div class="relative max-w-[1440px] mx-auto px-6 lg:px-12">

        <!-- Newsletter / Hero band -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center pb-16 mb-16 border-b border-slate-200/70">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold tracking-tight leading-[1.1] mb-3">
                    Make your space <span class="text-teal-500">extraordinary.</span>
                </h2>
                <p class="text-slate-500 text-lg leading-relaxed max-w-md">
                    New collections, design tips, and member-only offers — delivered monthly. No spam, ever.
                </p>
            </div>
            <form class="flex flex-col sm:flex-row gap-3 w-full" onsubmit="event.preventDefault(); window.RentEase.toast.success('You\\'re subscribed. Welcome aboard!', 'Subscribed'); this.reset();">
                <label class="sr-only" for="footer-newsletter-email">Email address</label>
                <div class="input-group flex-1">
                    <span class="input-group-icon material-symbols-outlined" aria-hidden="true">mail</span>
                    <input id="footer-newsletter-email" name="email" type="email" required placeholder="you@yourdomain.com" class="form-input" autocomplete="email">
                </div>
                <button type="submit" class="btn-pill btn-pill-lg whitespace-nowrap">
                    Subscribe
                    <span class="material-symbols-outlined text-base" aria-hidden="true">arrow_forward</span>
                </button>
            </form>
        </div>

        <!-- Main grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-10 lg:gap-8 mb-16">

            <!-- Brand column (wider) -->
            <div class="col-span-2 md:col-span-3 lg:col-span-2 flex flex-col gap-5">
                <a href="<?= baseUrl('/') ?>" class="inline-flex items-center text-3xl font-bold text-slate-900 tracking-tighter hover:text-teal-500 transition-colors w-fit">
                    RentEase<span class="text-teal-500">.</span>
                </a>
                <p class="text-slate-500 leading-relaxed max-w-sm">
                    Premium furniture and appliances on flexible monthly plans. Designed for students, professionals, and everyone in between.
                </p>

                <!-- Socials -->
                <div class="flex items-center gap-2 mt-2">
                    <a href="#" aria-label="Instagram" class="btn-icon !w-10 !h-10">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.16c3.2 0 3.58.01 4.85.07 1.17.05 1.8.25 2.23.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.36 1.06.41 2.23.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.25 1.8-.41 2.23-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.06.36-2.23.41-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.8-.25-2.23-.41a3.71 3.71 0 0 1-1.38-.9 3.71 3.71 0 0 1-.9-1.38c-.16-.42-.36-1.06-.41-2.23C2.17 15.58 2.16 15.2 2.16 12s.01-3.58.07-4.85c.05-1.17.25-1.8.41-2.23.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.42-.16 1.06-.36 2.23-.41C8.42 2.17 8.8 2.16 12 2.16M12 0C8.74 0 8.33.01 7.05.07 5.78.13 4.9.33 4.14.63a5.86 5.86 0 0 0-2.13 1.38A5.86 5.86 0 0 0 .63 4.14C.33 4.9.13 5.78.07 7.05.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.06 1.27.26 2.15.56 2.91.31.79.73 1.46 1.38 2.13a5.86 5.86 0 0 0 2.13 1.38c.76.3 1.64.5 2.91.56C8.33 23.99 8.74 24 12 24s3.67-.01 4.95-.07c1.27-.06 2.15-.26 2.91-.56a5.86 5.86 0 0 0 2.13-1.38 5.86 5.86 0 0 0 1.38-2.13c.3-.76.5-1.64.56-2.91.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.06-1.27-.26-2.15-.56-2.91a5.86 5.86 0 0 0-1.38-2.13A5.86 5.86 0 0 0 19.86.63C19.1.33 18.22.13 16.95.07 15.67.01 15.26 0 12 0zm0 5.84a6.16 6.16 0 1 0 0 12.32 6.16 6.16 0 0 0 0-12.32zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm7.85-10.4a1.44 1.44 0 1 1-2.88 0 1.44 1.44 0 0 1 2.88 0z"/></svg>
                    </a>
                    <a href="#" aria-label="Twitter / X" class="btn-icon !w-10 !h-10">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="#" aria-label="LinkedIn" class="btn-icon !w-10 !h-10">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.45 20.45h-3.55v-5.57c0-1.33-.03-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.36V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.45v6.29zM5.34 7.43a2.06 2.06 0 1 1 0-4.12 2.06 2.06 0 0 1 0 4.12zM7.12 20.45H3.56V9h3.56v11.45zM22.23 0H1.77C.79 0 0 .77 0 1.72v20.56C0 23.23.79 24 1.77 24h20.46c.98 0 1.77-.77 1.77-1.72V1.72C24 .77 23.21 0 22.23 0z"/></svg>
                    </a>
                    <a href="#" aria-label="YouTube" class="btn-icon !w-10 !h-10">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.6 12 3.6 12 3.6s-7.5 0-9.4.5A3 3 0 0 0 .5 6.2 31 31 0 0 0 0 12a31 31 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.9.5 9.4.5 9.4.5s7.5 0 9.4-.5a3 3 0 0 0 2.1-2.1A31 31 0 0 0 24 12a31 31 0 0 0-.5-5.8zM9.6 15.6V8.4l6.3 3.6-6.3 3.6z"/></svg>
                    </a>
                </div>

                <!-- Live status -->
                <div class="flex items-center gap-2 text-sm text-slate-500 mt-1">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    All systems operational
                </div>
            </div>

            <!-- Shop -->
            <div class="flex flex-col gap-4">
                <h4 class="font-semibold text-slate-900 uppercase tracking-widest text-[10px]">Shop</h4>
                <a class="text-slate-500 hover:text-teal-600 transition-colors text-sm" href="<?= baseUrl('/shop?category=Furniture') ?>">Furniture</a>
                <a class="text-slate-500 hover:text-teal-600 transition-colors text-sm" href="<?= baseUrl('/shop?category=Appliances') ?>">Appliances</a>
                <a class="text-slate-500 hover:text-teal-600 transition-colors text-sm" href="<?= baseUrl('/shop?package=studio') ?>">Studio Packages</a>
                <a class="text-slate-500 hover:text-teal-600 transition-colors text-sm" href="<?= baseUrl('/shop?package=1bhk') ?>">1 BHK Packages</a>
                <a class="text-slate-500 hover:text-teal-600 transition-colors text-sm" href="<?= baseUrl('/shop?package=2bhk') ?>">2 BHK Packages</a>
                <a class="text-slate-500 hover:text-teal-600 transition-colors text-sm" href="<?= baseUrl('/shop?package=office') ?>">WFH Setup</a>
            </div>

            <!-- Company -->
            <div class="flex flex-col gap-4">
                <h4 class="font-semibold text-slate-900 uppercase tracking-widest text-[10px]">Company</h4>
                <a class="text-slate-500 hover:text-teal-600 transition-colors text-sm" href="<?= baseUrl('/about') ?>">About Us</a>
                <a class="text-slate-500 hover:text-teal-600 transition-colors text-sm" href="<?= baseUrl('/partner') ?>">Partner With Us</a>
                <a class="text-slate-500 hover:text-teal-600 transition-colors text-sm" href="<?= baseUrl('/rewards') ?>">Rewards Program</a>
                <a class="text-slate-500 hover:text-teal-600 transition-colors text-sm" href="<?= baseUrl('/referrals') ?>">Refer a Friend</a>
                <a class="text-slate-500 hover:text-teal-600 transition-colors text-sm" href="<?= baseUrl('/concierge') ?>">Concierge</a>
            </div>

            <!-- Support -->
            <div class="flex flex-col gap-4">
                <h4 class="font-semibold text-slate-900 uppercase tracking-widest text-[10px]">Support</h4>
                <a class="text-slate-500 hover:text-teal-600 transition-colors text-sm" href="<?= baseUrl('/help-center') ?>">Help Center</a>
                <a class="text-slate-500 hover:text-teal-600 transition-colors text-sm" href="<?= baseUrl('/maintenance') ?>">Maintenance</a>
                <a class="text-slate-500 hover:text-teal-600 transition-colors text-sm" href="<?= baseUrl('/tracking') ?>">Track Delivery</a>
                <a class="text-slate-500 hover:text-teal-600 transition-colors text-sm" href="<?= baseUrl('/support') ?>">Contact Us</a>
                <a class="text-slate-500 hover:text-teal-600 transition-colors text-sm" href="<?= baseUrl('/privacy') ?>">Privacy</a>
                <a class="text-slate-500 hover:text-teal-600 transition-colors text-sm" href="<?= baseUrl('/terms') ?>">Terms</a>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="pt-8 border-t border-slate-200/70 flex flex-col md:flex-row items-center justify-between gap-6">
            <p class="text-slate-500 text-sm">
                &copy; <?= $currentYear ?> RentEase. Crafted with care in Bengaluru.
            </p>
            <div class="flex items-center gap-3 text-slate-400">
                <span class="text-xs uppercase tracking-widest mr-1">Secure payments</span>
                <span class="px-2.5 py-1 bg-white border border-slate-200 rounded-md text-[10px] font-bold text-slate-700">VISA</span>
                <span class="px-2.5 py-1 bg-white border border-slate-200 rounded-md text-[10px] font-bold text-slate-700">MC</span>
                <span class="px-2.5 py-1 bg-white border border-slate-200 rounded-md text-[10px] font-bold text-slate-700">AMEX</span>
                <span class="px-2.5 py-1 bg-white border border-slate-200 rounded-md text-[10px] font-bold text-slate-700">UPI</span>
                <span class="px-2.5 py-1 bg-white border border-slate-200 rounded-md text-[10px] font-bold text-slate-700">STRIPE</span>
            </div>
        </div>
    </div>
</footer>

<!-- =============================================================================
     MOBILE BOTTOM NAV (sticky on small screens)
     ============================================================================= -->
<nav class="bg-white/95 backdrop-blur-md text-slate-900 font-sans text-[10px] font-semibold fixed bottom-0 w-full z-50 border-t border-slate-200 shadow-[0_-4px_12px_rgba(0,0,0,0.04)] md:hidden" aria-label="Mobile bottom navigation">
    <div class="flex justify-around items-center px-2 py-2">
        <a href="<?= baseUrl('/') ?>" class="flex flex-col items-center justify-center text-teal-600 bg-teal-50 rounded-2xl px-4 py-1.5 active:scale-90 transition-transform duration-150">
            <span class="material-symbols-outlined mb-1" aria-hidden="true" style="font-variation-settings: 'FILL' 1;">home</span>
            Home
        </a>
        <a href="<?= baseUrl('/shop') ?>" class="flex flex-col items-center justify-center text-slate-400 hover:bg-slate-50 active:scale-90 transition-transform duration-150 px-4 py-1.5 rounded-2xl">
            <span class="material-symbols-outlined mb-1" aria-hidden="true" style="font-variation-settings: 'FILL' 0;">search</span>
            Explore
        </a>
        <a href="<?= baseUrl('/cart') ?>" class="flex flex-col items-center justify-center text-slate-400 hover:bg-slate-50 active:scale-90 transition-transform duration-150 px-4 py-1.5 rounded-2xl">
            <span class="material-symbols-outlined mb-1" aria-hidden="true" style="font-variation-settings: 'FILL' 0;">shopping_bag</span>
            Cart
        </a>
        <a href="<?= baseUrl($profileLink) ?>" class="flex flex-col items-center justify-center text-slate-400 hover:bg-slate-50 active:scale-90 transition-transform duration-150 px-4 py-1.5 rounded-2xl">
            <span class="material-symbols-outlined mb-1" aria-hidden="true" style="font-variation-settings: 'FILL' 0;">person</span>
            Profile
        </a>
    </div>
</nav>

</body>
</html>
