<?php global $config; ?>
</main>
<!-- Footer -->
<footer class="bg-gray-50 text-gray-900 font-sans text-sm leading-relaxed w-full py-16 mt-20 border-t border-gray-100 pb-32 md:pb-16 font-light">
    <div class="max-w-[1600px] mx-auto px-6 lg:px-12 grid grid-cols-1 md:grid-cols-4 gap-12 md:gap-8">
        <div class="col-span-1 md:col-span-1 flex flex-col gap-4">
            <a href="<?= baseUrl('/') ?>" class="text-2xl font-normal text-gray-900 tracking-tighter hover:text-blue-600 transition-colors">RentEase<span class="text-blue-600">.</span></a>
            <p class="text-gray-500">&copy; <?= date('Y') ?> RentEase. Elevating urban living through flexible ownership.</p>
        </div>
        <div class="col-span-1 md:col-span-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <div class="flex flex-col gap-4">
                <h4 class="font-normal text-gray-900 uppercase tracking-widest text-[10px]">Company</h4>
                <a class="text-gray-500 hover:text-blue-600 cursor-pointer transition-colors" href="<?= baseUrl('/about') ?>">About Us</a>
                <a class="text-gray-500 hover:text-blue-600 cursor-pointer transition-colors" href="<?= baseUrl('/rewards') ?>">Rewards Program</a>
                <a class="text-gray-500 hover:text-blue-600 cursor-pointer transition-colors" href="<?= baseUrl('/referrals') ?>">Refer a Friend</a>
            </div>
            <div class="flex flex-col gap-4">
                <h4 class="font-normal text-gray-900 uppercase tracking-widest text-[10px]">Support</h4>
                <a class="text-gray-500 hover:text-blue-600 cursor-pointer transition-colors" href="<?= baseUrl('/privacy') ?>">Privacy Policy</a>
                <a class="text-gray-500 hover:text-blue-600 cursor-pointer transition-colors" href="<?= baseUrl('/help-center') ?>">Help Center</a>
            </div>
            <div class="flex flex-col gap-4">
                <h4 class="font-normal text-gray-900 uppercase tracking-widest text-[10px]">Services</h4>
                <a class="text-gray-500 hover:text-blue-600 cursor-pointer transition-colors" href="<?= baseUrl('/maintenance') ?>">Maintenance Request</a>
                <a class="text-gray-500 hover:text-blue-600 cursor-pointer transition-colors" href="<?= baseUrl('/tracking') ?>">Delivery Tracking</a>
                <a class="text-gray-500 hover:text-blue-600 cursor-pointer transition-colors" href="<?= baseUrl('/partner') ?>">Partner With Us</a>
                <a class="text-gray-500 hover:text-blue-600 cursor-pointer transition-colors" href="<?= baseUrl('/concierge') ?>">Concierge Support</a>
            </div>
        </div>
    </div>
</footer>

<!-- BottomNavBar (Mobile Only) -->
<nav class="bg-white/95 backdrop-blur-md text-gray-900 font-sans text-[10px] font-normal fixed bottom-0 w-full z-50 border-t border-gray-100 shadow-[0_-4px_12px_rgba(0,0,0,0.05)] md:hidden" aria-label="Mobile bottom navigation">
    <div class="flex justify-around items-center px-2 py-3">
        <!-- Home -->
        <a href="<?= baseUrl('/') ?>" class="flex flex-col items-center justify-center text-blue-600 bg-blue-50 rounded-2xl px-4 py-1.5 active:scale-90 transition-transform duration-150">
            <span class="material-symbols-outlined mb-1" aria-hidden="true" style="font-variation-settings: 'FILL' 1;">home</span>
            Home
        </a>
        <!-- Explore -->
        <a href="<?= baseUrl('/shop') ?>" class="flex flex-col items-center justify-center text-gray-400 hover:bg-gray-50 active:scale-90 transition-transform duration-150 px-4 py-1.5 rounded-2xl">
            <span class="material-symbols-outlined mb-1" aria-hidden="true" style="font-variation-settings: 'FILL' 0;">search</span>
            Explore
        </a>
        <!-- Cart -->
        <a href="<?= baseUrl('/cart') ?>" class="flex flex-col items-center justify-center text-gray-400 hover:bg-gray-50 active:scale-90 transition-transform duration-150 px-4 py-1.5 rounded-2xl">
            <span class="material-symbols-outlined mb-1" aria-hidden="true" style="font-variation-settings: 'FILL' 0;">shopping_bag</span>
            Cart
        </a>
        <!-- Profile -->
        <a href="<?= baseUrl($profileLink ?? '/login') ?>" class="flex flex-col items-center justify-center text-gray-400 hover:bg-gray-50 active:scale-90 transition-transform duration-150 px-4 py-1.5 rounded-2xl">
            <span class="material-symbols-outlined mb-1" aria-hidden="true" style="font-variation-settings: 'FILL' 0;">person</span>
            Profile
        </a>
    </div>
</nav>

</body>
</html>
