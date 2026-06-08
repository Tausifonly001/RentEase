<?php
declare(strict_types=1);

require __DIR__ . '/../bootstrap.php';

use RentEase\Services\AuthService;

$authService = new AuthService($config);
$currentUser = null;
try {
 $token = $_COOKIE[$config['cookie_name'] ?? ''] ?? '';
 if ($token) {
 $currentUser = $authService->validateToken($token);
 }
} catch (Throwable $ignored) {}

$pageTitle = "Partner With Us | RentEase";
include_once __DIR__ . '/partials/header.php';
?>

<main class="bg-surface min-h-screen">
 <!-- Hero Section -->
 <section class="relative bg-ink overflow-hidden py-24 md:py-32">
 <div class="absolute inset-0 z-0 opacity-40">
 <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuBmAXDSAK_0WGWW91XLxUq0LFLmOyt7q3ybXXmW1sf-yaAnvZyGVg5suQrTTyXkZJS3L0TEl0w75Sz-_vWyCxFqCtmGC5Yi1fQUrcs1PvaB-xidl_8dZ7qGfljHeg71wQl-hxSi0IyjjGNm4P-WJNwyH5JoTM2wB6f0MrZ8DpMmXjPKG7YHmrqcCDxTVStMmx-ljZVojV5xcK71QqexWR7qNrR7DX-Jx8SHyN-68-MAfvPp7SrK9xxdfpNDtJrZsUXDeFB_3QPnpDab"
 alt="Modern Living" class="w-full h-full object-cover">
 </div>
 <div class="absolute inset-0 bg-gradient-to-r from-[#041627] via-[#041627]/80 to-transparent z-10"></div>
 <div class="max-w-7xl mx-auto px-4 relative z-20">
 <div class="max-w-2xl">
 <span class="inline-block px-3 py-1 bg-champagne/20 text-champagne-dark rounded-full text-xs font-light uppercase tracking-wider mb-6">
 FOR VENDORS & MANUFACTURERS
 </span>
 <h1 class="text-4xl md:text-6xl font-normal text-white mb-6 leading-tight">
 Turn Your Inventory Into <span class="text-champagne">Recurring Revenue</span>
 </h1>
 <p class="text-lg text-muted-light mb-10 max-w-xl">
 Join the world's most trusted furniture rental marketplace. We handle the logistics, you collect the monthly profits. Grow your business without the overhead.
 </p>
 <div class="flex flex-col sm:flex-row gap-4">
 <button class="bg-champagne-dark text-white font-normal px-8 py-4 rounded-xl hover:bg-teal-500 transition-all shadow-lg shadow-teal-600/20 active:scale-95">
 Become a Partner
 </button>
 <button class="border border-white/30 text-white font-normal px-8 py-4 rounded-xl hover:bg-white/10 transition-all backdrop-blur-sm">
 View Logistics Model
 </button>
 </div>
 </div>
 </div>
 </section>

 <!-- Trust Section -->
 <section class="py-12 bg-white border-b border-border ">
 <div class="max-w-7xl mx-auto px-4">
 <div class="flex flex-col md:flex-row items-center justify-between gap-12">
 <div class="flex flex-col">
 <span class="text-3xl font-normal text-ink ">500+</span>
 <span class="text-xs text-muted uppercase tracking-widest font-light">Active Vendors</span>
 </div>
 <div class="flex flex-wrap justify-center items-center gap-12 opacity-50 grayscale hover:grayscale-0 transition-all">
 <div class="font-normal text-xl text-muted-light italic">MODERN_HOME</div>
 <div class="font-normal text-xl text-muted-light">VISTA LIVING</div>
 <div class="font-normal text-xl text-muted-light tracking-tighter">NordicSpace</div>
 <div class="font-normal text-xl text-muted-light">URBANREST</div>
 <div class="font-normal text-xl text-muted-light italic">AURA</div>
 </div>
 </div>
 </div>
 </section>

 <!-- Benefits Section -->
 <section class="py-24 bg-surface ">
 <div class="max-w-7xl mx-auto px-4">
 <div class="text-center mb-16">
 <h2 class="text-3xl font-normal text-ink mb-4">Why Partner with RentEase?</h2>
 <p class="text-muted ">We bridge the gap between premium inventory and urban demand.</p>
 </div>

 <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
 <!-- Effortless Logistics -->
 <div class="md:col-span-8 bg-white p-8 rounded-2xl shadow-sm border border-border hover:shadow-md transition-all group overflow-hidden">
 <div class="flex flex-col md:flex-row gap-8 items-center h-full">
 <div class="flex-1">
 <div class="w-12 h-12 bg-champagne/10 flex items-center justify-center rounded-xl mb-6 text-champagne-dark">
 <span class="material-symbols-outlined">local_shipping</span>
 </div>
 <h3 class="text-2xl font-normal text-ink mb-4">Effortless Logistics</h3>
 <p class="text-muted ">Stop worrying about last-mile delivery. Our specialized white-glove team handles everything from your warehouse to the customer's living room, including assembly and installation.</p>
 </div>
 <div class="flex-1 w-full h-48 md:h-full min-h-[200px] rounded-xl overflow-hidden relative">
 <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuA8isg08tCSBuPXJzJEUalHwwHqpu93vBK3WjwapHx2fXGstNVA6vPB4crgTfW0UsGhS9b1bVEzQYZ9kJhwasgL6EqJJMjJ23exwiAvyz2YqLgwzh0mXbzucvbAVCp0WElg-HbP2WSZQ003VYZCo-VLvtzmcn7Pfk6Tl0_rNVpfcWKfpAt51l9NQuJwDz7uqi9lVvQhJQsS7WGv-ivBhbiU73i3CSQc1w72RTpfOXAvXM8TWJROGup9TRtnQM3-1ZHlzwxoZD2B6zU9"
 alt="Logistics" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
 </div>
 </div>
 </div>

 <!-- Guaranteed Income -->
 <div class="md:col-span-4 bg-ink p-8 rounded-2xl shadow-sm group">
 <div class="w-12 h-12 bg-champagne flex items-center justify-center rounded-xl mb-6 text-white">
 <span class="material-symbols-outlined">payments</span>
 </div>
 <h3 class="text-2xl font-normal text-white mb-4">Guaranteed Income</h3>
 <p class="text-muted-light">Say goodbye to unpredictable sales cycles. Enjoy stable, monthly recurring revenue from every piece in your rental catalog, paid out automatically.</p>
 </div>

 <!-- Automated Care -->
 <div class="md:col-span-4 bg-white p-8 rounded-2xl shadow-sm border border-border ">
 <div class="w-12 h-12 bg-canvas flex items-center justify-center rounded-xl mb-6 text-ink ">
 <span class="material-symbols-outlined">build</span>
 </div>
 <h3 class="text-2xl font-normal text-ink mb-4">Automated Care</h3>
 <p class="text-muted ">We protect your assets. Our team performs routine inspections and handles minor repairs, ensuring your inventory stays in showroom condition.</p>
 </div>

 <!-- Actionable Analytics -->
 <div class="md:col-span-8 bg-champagne/10 p-8 rounded-2xl shadow-sm border border-champagne/20 flex flex-col md:flex-row justify-between items-center gap-8">
 <div class="max-w-md">
 <h3 class="text-2xl font-normal text-champagne-dark mb-4">Actionable Analytics</h3>
 <p class="text-teal-800/70 ">Track which items are trending, monitor your ROI per SKU, and optimize your inventory based on real-time market demand in the vendor dashboard.</p>
 </div>
 <div class="bg-white/50 backdrop-blur-md p-6 rounded-2xl shadow-inner w-full md:w-auto flex items-center justify-center">
 <span class="material-symbols-outlined text-5xl text-champagne-dark">analytics</span>
 </div>
 </div>
 </div>
 </div>
 </section>

 <!-- Final CTA -->
 <section class="py-24 bg-white relative overflow-hidden">
 <div class="absolute top-0 right-0 w-1/3 h-full bg-champagne/10 -skew-x-12 transform translate-x-20"></div>
 <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
 <div class="max-w-3xl mx-auto">
 <h2 class="text-4xl md:text-5xl font-normal text-ink mb-6">Ready to grow your rental business?</h2>
 <p class="text-lg text-muted mb-10">
 Join hundreds of premium vendors who are scaling their reach with the RentEase marketplace. The future of furniture is flexible.
 </p>
 <div class="flex flex-col sm:flex-row gap-4 justify-center">
 <button class="bg-ink text-white font-normal px-10 py-4 rounded-xl shadow-xl hover:brightness-110 transition-all active:scale-95">
 Join RentEase Today
 </button>
 <button class="border border-slate-300 text-ink font-normal px-10 py-4 rounded-xl hover:bg-surface :bg-slate-800 transition-all active:scale-95">
 Schedule a Demo
 </button>
 </div>
 <p class="mt-8 text-sm text-muted-light flex items-center justify-center gap-2 font-light">
 <span class="material-symbols-outlined text-sm font-light">verified_user</span>
 No upfront listing fees. Dedicated vendor support.
 </p>
 </div>
 </div>
 </section>
</main>

<?php include_once __DIR__ . '/partials/footer.php'; ?>
