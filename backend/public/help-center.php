<?php
/**
 * Help Center / Support Center
 *
 * Provides FAQs, contact options, and community access.
 */

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

$pageTitle = 'Help Center - RentEase';
require_once __DIR__ . '/partials/header.php';
?>

<!-- Help Center Hero -->
<section class="relative bg-ink rounded-[2.5rem] overflow-hidden mx-4 md:mx-8 mt-8 mb-16 px-8 py-24 md:py-32 reveal-fade">
 <div class="absolute inset-0">
 <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=2000&q=80" class="w-full h-full object-cover opacity-30 mix-blend-luminosity" alt="Support Team">
 <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/80 to-transparent"></div>
 </div>
 <div class="relative z-10 max-w-4xl mx-auto text-center">
 <span class="inline-block bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] font-normal uppercase tracking-widest px-3 py-1.5 rounded-full mb-6">Support Concierge</span>
 <h1 class="text-5xl md:text-7xl font-normal text-white mb-6 tracking-tight">How can we help you?</h1>
 <p class="text-white/70 text-lg md:text-xl font-light max-w-2xl mx-auto mb-10">Search our knowledge base for everything from delivery schedules to our rent-to-own program details.</p>
 <div class="max-w-2xl mx-auto relative group">
 <span class="material-symbols-outlined absolute left-6 top-1/2 -translate-y-1/2 text-muted-light group-focus-within:text-champagne transition-colors">search</span>
 <input type="text" class="w-full bg-white/10 backdrop-blur-md border border-white/20 text-white placeholder-white/50 pl-14 pr-6 py-4 focus:bg-surface focus:text-ink focus:placeholder-muted focus:ring-4 ring-champagne/30 transition-all font-light outline-none" style="border-radius: 9999px;" placeholder="Search for 'security deposit', 'delivery'...">
 </div>
 </div>
</section>

<!-- Category Grid -->
<section class="max-w-7xl mx-auto px-6 md:px-12 py-16">
 <h2 class="text-3xl font-normal text-ink mb-10 text-center reveal-fade">Browse by Category</h2>
 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
 <!-- Category 1 -->
 <a href="<?= baseUrl('/faq-article') ?>" class="bg-surface p-8 rounded-[2rem] hover:-translate-y-2 transition-all duration-500 group reveal-fade" style="border-color: rgba(231,229,228,0.6);">
 <div class="w-14 h-14 bg-champagne/10 text-champagne-dark flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-champagne group-hover:text-white transition-all duration-500" style="border-radius: 0.75rem;">
 <span class="material-symbols-outlined font-light text-[28px]">local_shipping</span>
 </div>
 <h3 class="text-xl font-normal text-ink mb-2 group-hover:text-champagne-dark transition-colors">Delivery & Returns</h3>
 <p class="text-muted font-light text-sm leading-relaxed">Tracking, white-glove setup, and return logistics.</p>
 </a>
 <!-- Category 2 -->
 <a href="<?= baseUrl('/faq-article') ?>" class="bg-surface p-8 rounded-[2rem] hover:-translate-y-2 transition-all duration-500 group reveal-fade" style="transition-delay: 100ms; border-color: rgba(231,229,228,0.6);">
 <div class="w-14 h-14 bg-champagne/10 text-champagne-dark flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-500" style="border-radius: 0.75rem;">
 <span class="material-symbols-outlined font-light text-[28px]">payments</span>
 </div>
 <h3 class="text-xl font-normal text-ink mb-2 group-hover:text-indigo-600 transition-colors">Billing & Payments</h3>
 <p class="text-muted font-light text-sm leading-relaxed">Payment methods, invoices, and security deposits.</p>
 </a>
 <!-- Category 3 -->
 <a href="<?= baseUrl('/faq-article') ?>" class="bg-surface p-8 rounded-[2rem] hover:-translate-y-2 transition-all duration-500 group reveal-fade" style="transition-delay: 200ms; border-color: rgba(231,229,228,0.6);">
 <div class="w-14 h-14 bg-rose/10 text-rose flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-orange-500 group-hover:text-white transition-all duration-500" style="border-radius: 0.75rem;">
 <span class="material-symbols-outlined font-light text-[28px]">handyman</span>
 </div>
 <h3 class="text-xl font-normal text-ink mb-2 group-hover:text-orange-600 transition-colors">Maintenance</h3>
 <p class="text-muted font-light text-sm leading-relaxed">Repair requests, damage policy, and cleanings.</p>
 </a>
 <!-- Category 4 -->
 <a href="<?= baseUrl('/faq-article') ?>" class="bg-surface p-8 rounded-[2rem] hover:-translate-y-2 transition-all duration-500 group reveal-fade" style="transition-delay: 300ms; border-color: rgba(231,229,228,0.6);">
 <div class="w-14 h-14 bg-champagne/10 text-champagne-dark flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-purple-500 group-hover:text-white transition-all duration-500" style="border-radius: 0.75rem;">
 <span class="material-symbols-outlined font-light text-[28px]">workspace_premium</span>
 </div>
 <h3 class="text-xl font-normal text-ink mb-2 group-hover:text-purple-600 transition-colors">Lease & Credits</h3>
 <p class="text-muted font-light text-sm leading-relaxed">Rent-to-own, tenure extensions, and points.</p>
 </a>
 </div>
</section>

<!-- Trending Articles Section -->
<section class="bg-canvas py-24 mt-10">
 <div class="max-w-7xl mx-auto px-6 md:px-12">
 <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6 reveal-fade">
 <div>
 <h2 class="text-3xl md:text-4xl font-normal text-ink mb-4 tracking-tight">Trending Knowledge</h2>
 <p class="text-lg text-muted font-light max-w-lg">Quick answers to the most common questions from our community of urban dwellers.</p>
 </div>
 <a href="<?= baseUrl('/faq-article') ?>" class="text-champagne-dark font-normal hover:text-champagne-dark/80 flex items-center gap-2 group transition-colors">
 View all articles
 <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
 </a>
 </div>

 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
 <!-- Article Card 1 -->
 <a href="<?= baseUrl('/faq-article') ?>" class="bg-surface p-6 hover:-translate-y-1 transition-all duration-300 group flex gap-5 items-start reveal-fade" style="border-color: rgba(231,229,228,0.6);">
 <div class="shrink-0 w-10 h-10 rounded-full bg-canvas text-muted-light flex items-center justify-center group-hover:bg-champagne/10 group-hover:text-champagne-dark transition-colors">
 <span class="material-symbols-outlined font-light">article</span>
 </div>
 <div>
 <h4 class="text-lg font-normal text-ink mb-2 group-hover:text-champagne-dark transition-colors">How do I return my furniture at the end of a lease?</h4>
 <p class="text-muted font-light text-sm line-clamp-2">Complete guide on scheduling pickups and refunding security deposits.</p>
 </div>
 </a>
 <!-- Article Card 2 -->
 <a href="<?= baseUrl('/faq-article') ?>" class="bg-surface p-6 hover:-translate-y-1 transition-all duration-300 group flex gap-5 items-start reveal-fade" style="transition-delay: 100ms; border-color: rgba(231,229,228,0.6);">
 <div class="shrink-0 w-10 h-10 rounded-full bg-canvas text-muted-light flex items-center justify-center group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
 <span class="material-symbols-outlined font-light">article</span>
 </div>
 <div>
 <h4 class="text-lg font-normal text-ink mb-2 group-hover:text-indigo-600 transition-colors">Can I purchase the items I am currently renting?</h4>
 <p class="text-muted font-light text-sm line-clamp-2">Understand the 'Rent-to-Own' credits and buyout options.</p>
 </div>
 </a>
 <!-- Article Card 3 -->
 <a href="<?= baseUrl('/faq-article') ?>" class="bg-surface p-6 hover:-translate-y-1 transition-all duration-300 group flex gap-5 items-start reveal-fade" style="transition-delay: 200ms; border-color: rgba(231,229,228,0.6);">
 <div class="shrink-0 w-10 h-10 rounded-full bg-canvas text-muted-light flex items-center justify-center group-hover:bg-orange-50 group-hover:text-orange-600 transition-colors">
 <span class="material-symbols-outlined font-light">article</span>
 </div>
 <div>
 <h4 class="text-lg font-normal text-ink mb-2 group-hover:text-orange-600 transition-colors">What happens if I accidentally damage an item?</h4>
 <p class="text-muted font-light text-sm line-clamp-2">Details on our damage protection plans and repair policies.</p>
 </div>
 </a>
 <!-- Article Card 4 -->
 <a href="<?= baseUrl('/faq-article') ?>" class="bg-surface p-6 hover:-translate-y-1 transition-all duration-300 group flex gap-5 items-start reveal-fade" style="transition-delay: 300ms; border-color: rgba(231,229,228,0.6);">
 <div class="shrink-0 w-10 h-10 rounded-full bg-canvas text-muted-light flex items-center justify-center group-hover:bg-champagne/10 group-hover:text-champagne-dark transition-colors">
 <span class="material-symbols-outlined font-light">article</span>
 </div>
 <div>
 <h4 class="text-lg font-normal text-ink mb-2 group-hover:text-champagne-dark transition-colors">Updating your billing information and autopay</h4>
 <p class="text-muted font-light text-sm line-clamp-2">Step-by-step guide to managing your payments securely.</p>
 </div>
 </a>
 <!-- Article Card 5 -->
 <a href="<?= baseUrl('/faq-article') ?>" class="bg-surface p-6 hover:-translate-y-1 transition-all duration-300 group flex gap-5 items-start reveal-fade" style="transition-delay: 400ms; border-color: rgba(231,229,228,0.6);">
 <div class="shrink-0 w-10 h-10 rounded-full bg-canvas text-muted-light flex items-center justify-center group-hover:bg-purple-50 group-hover:text-purple-600 transition-colors">
 <span class="material-symbols-outlined font-light">article</span>
 </div>
 <div>
 <h4 class="text-lg font-normal text-ink mb-2 group-hover:text-purple-600 transition-colors">Delivery window: What to expect on your big day</h4>
 <p class="text-muted font-light text-sm line-clamp-2">Preparing your space for our white-glove delivery team.</p>
 </div>
 </a>
 <!-- Article Card 6 -->
 <a href="<?= baseUrl('/faq-article') ?>" class="bg-surface p-6 hover:-translate-y-1 transition-all duration-300 group flex gap-5 items-start reveal-fade" style="transition-delay: 500ms; border-color: rgba(231,229,228,0.6);">
 <div class="shrink-0 w-10 h-10 rounded-full bg-canvas text-muted-light flex items-center justify-center group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
 <span class="material-symbols-outlined font-light">article</span>
 </div>
 <div>
 <h4 class="text-lg font-normal text-ink mb-2 group-hover:text-indigo-600 transition-colors">Refer-a-friend: RentEase Rewards Program</h4>
 <p class="text-muted font-light text-sm line-clamp-2">How to earn credits by sharing RentEase with your network.</p>
 </div>
 </a>
 </div>
 </div>
</section>

<!-- Still Need Help? Section -->
<section class="max-w-7xl mx-auto px-6 md:px-12 py-24">
 <div class="bg-ink rounded-[3rem] p-12 md:p-20 flex flex-col lg:flex-row items-center justify-between gap-12 relative overflow-hidden reveal-fade">
 <div class="absolute -right-32 -bottom-32 w-96 h-96 bg-champagne/10 rounded-full blur-3xl"></div>
 <div class="absolute -left-32 -top-32 w-96 h-96 bg-champagne/20 rounded-full blur-3xl"></div>

 <div class="relative z-10 text-center lg:text-left">
 <h2 class="text-4xl md:text-5xl font-normal text-white mb-6 tracking-tight">Still need help?</h2>
 <p class="text-lg text-white/70 font-light max-w-lg">Our dedicated concierge team is available 24/7 to ensure your home living experience is seamless.</p>
 </div>
 <div class="relative z-10 flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
 <a href="<?= baseUrl('/concierge') ?>" class="bg-champagne text-white font-normal px-8 py-4 rounded-full flex items-center justify-center gap-2 hover:bg-champagne/90 transition-colors w-full sm:w-auto">
 <span class="material-symbols-outlined font-light">chat</span>
 Start Live Chat
 </a>
 <a href="<?= baseUrl('/support') ?>" class="bg-white/10 backdrop-blur-md border border-white/20 text-white font-normal px-8 py-4 rounded-full flex items-center justify-center gap-2 hover:bg-white/20 transition-colors w-full sm:w-auto">
 <span class="material-symbols-outlined font-light">mail</span>
 Email Support
 </a>
 </div>
 </div>
</section>

<!-- Newsletter / Community Section -->
<section class="max-w-7xl mx-auto px-6 md:px-12 py-24" style="border-top-color: rgba(231,229,228,0.6);">
 <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
 <div class="aspect-[4/3] rounded-[2.5rem] bg-cover bg-center overflow-hidden reveal-fade" style="background-image: url('https://images.unsplash.com/photo-1600607686527-6fb886090705?auto=format&fit=crop&q=80&w=1000')"></div>
 <div class="reveal-fade">
 <span class="inline-block bg-champagne/10 text-champagne-dark text-[10px] font-normal uppercase tracking-widest px-3 py-1.5 rounded-full mb-6">Community Knowledge</span>
 <h2 class="text-4xl md:text-5xl font-normal text-ink mb-6 tracking-tight">Join the RentEase Circle</h2>
 <p class="text-lg text-muted font-light mb-10 leading-relaxed">Connect with other urban professionals, share interior design tips, and get early access to our new furniture collections and sustainability initiatives.</p>
 <form class="flex flex-col sm:flex-row gap-3">
 <input class="flex-1 bg-canvas py-4 px-6 outline-none font-light transition-all text-ink placeholder-muted-light focus:border-champagne focus:ring-4 ring-champagne/20" style="border-radius: 9999px; border-color: rgba(231,229,228,0.6);" placeholder="Your email address" type="email" required/>
 <button type="submit" class="bg-ink text-white font-normal px-8 py-4 rounded-full hover:bg-ink/90 transition-colors whitespace-nowrap">Join Now</button>
 </form>
 </div>
 </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
 const initGsap = setInterval(() => {
 if (window.gsap && window.ScrollTrigger) {
 clearInterval(initGsap);
 gsap.registerPlugin(ScrollTrigger);
 const fades = document.querySelectorAll('.reveal-fade');
 fades.forEach((el, index) => {
 gsap.fromTo(el,
 { opacity: 0, y: 30 },
 {
 opacity: 1, y: 0,
 duration: 1,
 ease: "power3.out",
 delay: index * 0.05,
 scrollTrigger: {
 trigger: el,
 start: "top 90%",
 }
 }
 );
 });
 }
 }, 100);
});
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
