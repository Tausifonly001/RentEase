<?php global $config; ?>
</main>
<!-- Footer -->
<footer class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 font-inter text-sm leading-relaxed w-full py-16 mt-20 border-t border-slate-200 dark:border-slate-800 hidden md:block">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="col-span-1 md:col-span-1 flex flex-col gap-4">
            <a href="<?= baseUrl('/') ?>" class="text-xl font-bold text-slate-900 dark:text-slate-100">RentEase</a>
            <p class="text-slate-500 dark:text-slate-400">&copy; <?= date('Y') ?> RentEase. Elevating urban living through flexible ownership.</p>
        </div>
        <div class="col-span-1 md:col-span-3 grid grid-cols-2 md:grid-cols-3 gap-8">
            <div class="flex flex-col gap-2">
                <a class="text-slate-500 dark:text-slate-400 hover:text-teal-600 dark:hover:text-teal-400 underline underline-offset-4 cursor-pointer" href="<?= baseUrl('/about') ?>">About Us</a>
                <a class="text-slate-500 dark:text-slate-400 hover:text-teal-600 dark:hover:text-teal-400 underline underline-offset-4 cursor-pointer" href="<?= baseUrl('/rewards') ?>">Rewards Program</a>
                <a class="text-slate-500 dark:text-slate-400 hover:text-teal-600 dark:hover:text-teal-400 underline underline-offset-4 cursor-pointer" href="<?= baseUrl('/referrals') ?>">Refer a Friend</a>
            </div>
            <div class="flex flex-col gap-2">
                <a class="text-slate-500 dark:text-slate-400 hover:text-teal-600 dark:hover:text-teal-400 underline underline-offset-4 cursor-pointer" href="<?= baseUrl('/privacy') ?>">Privacy Policy</a>
                <a class="text-slate-500 dark:text-slate-400 hover:text-teal-600 dark:hover:text-teal-400 underline underline-offset-4 cursor-pointer" href="<?= baseUrl('/help-center') ?>">Help Center</a>
            </div>
            <div class="flex flex-col gap-2">
                <a class="text-slate-500 dark:text-slate-400 hover:text-teal-600 dark:hover:text-teal-400 underline underline-offset-4 cursor-pointer" href="<?= baseUrl('/maintenance') ?>">Maintenance Request</a>
                <a class="text-slate-500 dark:text-slate-400 hover:text-teal-600 dark:hover:text-teal-400 underline underline-offset-4 cursor-pointer" href="<?= baseUrl('/tracking') ?>">Delivery Tracking</a>
                <a class="text-slate-500 dark:text-slate-400 hover:text-teal-600 dark:hover:text-teal-400 underline underline-offset-4 cursor-pointer" href="<?= baseUrl('/partner') ?>">Partner With Us</a>
                <a class="text-slate-500 dark:text-slate-400 hover:text-teal-600 dark:hover:text-teal-400 underline underline-offset-4 cursor-pointer" href="<?= baseUrl('/concierge') ?>">Concierge Support</a>
            </div>
        </div>
    </div>
</footer>

<!-- BottomNavBar (Mobile Only) -->
<nav class="bg-white/95 dark:bg-slate-900/95 backdrop-blur-md text-slate-900 dark:text-slate-50 font-inter text-[10px] font-semibold fixed bottom-0 w-full z-50 border-t border-slate-100 dark:border-slate-800 shadow-[0_-4px_12px_rgba(0,0,0,0.05)] md:hidden">
    <div class="fixed bottom-0 left-0 w-full flex justify-around items-center px-2 py-3 bg-white dark:bg-slate-900">
        <!-- Home (Active) -->
        <a href="<?= baseUrl('/') ?>" class="flex flex-col items-center justify-center text-teal-600 dark:text-teal-400 bg-teal-50 dark:bg-teal-900/20 rounded-2xl px-4 py-1.5 active:scale-90 transition-transform duration-150">
            <span class="material-symbols-outlined mb-1" style="font-variation-settings: 'FILL' 1;">home</span>
            Home
        </a>
        <!-- Explore -->
        <a href="<?= baseUrl('/shop') ?>" class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 active:scale-90 transition-transform duration-150 px-4 py-1.5 rounded-2xl">
            <span class="material-symbols-outlined mb-1" style="font-variation-settings: 'FILL' 0;">search</span>
            Explore
        </a>
        <!-- Cart -->
        <a href="<?= baseUrl('/cart') ?>" class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 active:scale-90 transition-transform duration-150 px-4 py-1.5 rounded-2xl">
            <span class="material-symbols-outlined mb-1" style="font-variation-settings: 'FILL' 0;">shopping_bag</span>
            Cart
        </a>
        <!-- Profile -->
        <a href="<?= baseUrl($profileLink) ?>" class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 active:scale-90 transition-transform duration-150 px-4 py-1.5 rounded-2xl">
            <span class="material-symbols-outlined mb-1" style="font-variation-settings: 'FILL' 0;">person</span>
            Profile
        </a>
    </div>
</nav>

</body>
</html>
