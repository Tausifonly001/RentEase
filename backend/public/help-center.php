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
<section class="relative bg-slate-900 rounded-[2.5rem] overflow-hidden mx-4 md:mx-8 mt-8 mb-16 px-8 py-24 md:py-32 reveal-fade">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=2000&q=80" class="w-full h-full object-cover opacity-30 mix-blend-luminosity" alt="Support Team">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/80 to-transparent"></div>
    </div>
    <div class="relative z-10 max-w-4xl mx-auto text-center">
        <span class="inline-block bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] font-normal uppercase tracking-widest px-3 py-1.5 rounded-full shadow-lg mb-6">Support Concierge</span>
        <h1 class="text-5xl md:text-7xl font-normal text-white mb-6 tracking-tight">How can we help you?</h1>
        <p class="text-white/70 text-lg md:text-xl font-light max-w-2xl mx-auto mb-10">Search our knowledge base for everything from delivery schedules to our rent-to-own program details.</p>
        <div class="max-w-2xl mx-auto relative group">
            <span class="material-symbols-outlined absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-teal-500 transition-colors">search</span>
            <input type="text" class="w-full bg-white/10 backdrop-blur-md border border-white/20 text-white placeholder-white/50 rounded-full pl-14 pr-6 py-4 focus:bg-white focus:text-slate-900 focus:placeholder-slate-400 focus:ring-4 ring-teal-500/30 transition-all font-light shadow-xl outline-none" placeholder="Search for 'security deposit', 'delivery'...">
        </div>
    </div>
</section>

<!-- Category Grid -->
<section class="max-w-7xl mx-auto px-6 md:px-12 py-16">
    <h2 class="text-3xl font-normal text-slate-900 mb-10 text-center reveal-fade">Browse by Category</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Category 1 -->
        <a href="<?= baseUrl('/faq-article') ?>" class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500 group reveal-fade">
            <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-teal-500 group-hover:text-white transition-all duration-500">
                <span class="material-symbols-outlined font-light text-[28px]">local_shipping</span>
            </div>
            <h3 class="text-xl font-normal text-slate-900 mb-2 group-hover:text-teal-600 transition-colors">Delivery & Returns</h3>
            <p class="text-slate-500 font-light text-sm leading-relaxed">Tracking, white-glove setup, and return logistics.</p>
        </a>
        <!-- Category 2 -->
        <a href="<?= baseUrl('/faq-article') ?>" class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500 group reveal-fade" style="transition-delay: 100ms;">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-500">
                <span class="material-symbols-outlined font-light text-[28px]">payments</span>
            </div>
            <h3 class="text-xl font-normal text-slate-900 mb-2 group-hover:text-indigo-600 transition-colors">Billing & Payments</h3>
            <p class="text-slate-500 font-light text-sm leading-relaxed">Payment methods, invoices, and security deposits.</p>
        </a>
        <!-- Category 3 -->
        <a href="<?= baseUrl('/faq-article') ?>" class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500 group reveal-fade" style="transition-delay: 200ms;">
            <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-orange-500 group-hover:text-white transition-all duration-500">
                <span class="material-symbols-outlined font-light text-[28px]">handyman</span>
            </div>
            <h3 class="text-xl font-normal text-slate-900 mb-2 group-hover:text-orange-600 transition-colors">Maintenance</h3>
            <p class="text-slate-500 font-light text-sm leading-relaxed">Repair requests, damage policy, and cleanings.</p>
        </a>
        <!-- Category 4 -->
        <a href="<?= baseUrl('/faq-article') ?>" class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500 group reveal-fade" style="transition-delay: 300ms;">
            <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-purple-500 group-hover:text-white transition-all duration-500">
                <span class="material-symbols-outlined font-light text-[28px]">workspace_premium</span>
            </div>
            <h3 class="text-xl font-normal text-slate-900 mb-2 group-hover:text-purple-600 transition-colors">Lease & Credits</h3>
            <p class="text-slate-500 font-light text-sm leading-relaxed">Rent-to-own, tenure extensions, and points.</p>
        </a>
    </div>
</section>

<!-- Trending Articles Section -->
<section class="bg-slate-50 py-24 mt-10">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6 reveal-fade">
            <div>
                <h2 class="text-3xl md:text-4xl font-normal text-slate-900 mb-4 tracking-tight">Trending Knowledge</h2>
                <p class="text-lg text-slate-500 font-light max-w-lg">Quick answers to the most common questions from our community of urban dwellers.</p>
            </div>
            <a href="<?= baseUrl('/faq-article') ?>" class="text-teal-600 font-normal hover:text-teal-700 flex items-center gap-2 group transition-colors">
                View all articles 
                <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Article Card 1 -->
            <a href="<?= baseUrl('/faq-article') ?>" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group flex gap-5 items-start reveal-fade">
                <div class="shrink-0 w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-teal-50 group-hover:text-teal-600 transition-colors">
                    <span class="material-symbols-outlined font-light">article</span>
                </div>
                <div>
                    <h4 class="text-lg font-normal text-slate-900 mb-2 group-hover:text-teal-600 transition-colors">How do I return my furniture at the end of a lease?</h4>
                    <p class="text-slate-500 font-light text-sm line-clamp-2">Complete guide on scheduling pickups and refunding security deposits.</p>
                </div>
            </a>
            <!-- Article Card 2 -->
            <a href="<?= baseUrl('/faq-article') ?>" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group flex gap-5 items-start reveal-fade" style="transition-delay: 100ms;">
                <div class="shrink-0 w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                    <span class="material-symbols-outlined font-light">article</span>
                </div>
                <div>
                    <h4 class="text-lg font-normal text-slate-900 mb-2 group-hover:text-indigo-600 transition-colors">Can I purchase the items I am currently renting?</h4>
                    <p class="text-slate-500 font-light text-sm line-clamp-2">Understand the 'Rent-to-Own' credits and buyout options.</p>
                </div>
            </a>
            <!-- Article Card 3 -->
            <a href="<?= baseUrl('/faq-article') ?>" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group flex gap-5 items-start reveal-fade" style="transition-delay: 200ms;">
                <div class="shrink-0 w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-orange-50 group-hover:text-orange-600 transition-colors">
                    <span class="material-symbols-outlined font-light">article</span>
                </div>
                <div>
                    <h4 class="text-lg font-normal text-slate-900 mb-2 group-hover:text-orange-600 transition-colors">What happens if I accidentally damage an item?</h4>
                    <p class="text-slate-500 font-light text-sm line-clamp-2">Details on our damage protection plans and repair policies.</p>
                </div>
            </a>
            <!-- Article Card 4 -->
            <a href="<?= baseUrl('/faq-article') ?>" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group flex gap-5 items-start reveal-fade" style="transition-delay: 300ms;">
                <div class="shrink-0 w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-teal-50 group-hover:text-teal-600 transition-colors">
                    <span class="material-symbols-outlined font-light">article</span>
                </div>
                <div>
                    <h4 class="text-lg font-normal text-slate-900 mb-2 group-hover:text-teal-600 transition-colors">Updating your billing information and autopay</h4>
                    <p class="text-slate-500 font-light text-sm line-clamp-2">Step-by-step guide to managing your payments securely.</p>
                </div>
            </a>
            <!-- Article Card 5 -->
            <a href="<?= baseUrl('/faq-article') ?>" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group flex gap-5 items-start reveal-fade" style="transition-delay: 400ms;">
                <div class="shrink-0 w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-purple-50 group-hover:text-purple-600 transition-colors">
                    <span class="material-symbols-outlined font-light">article</span>
                </div>
                <div>
                    <h4 class="text-lg font-normal text-slate-900 mb-2 group-hover:text-purple-600 transition-colors">Delivery window: What to expect on your big day</h4>
                    <p class="text-slate-500 font-light text-sm line-clamp-2">Preparing your space for our white-glove delivery team.</p>
                </div>
            </a>
            <!-- Article Card 6 -->
            <a href="<?= baseUrl('/faq-article') ?>" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group flex gap-5 items-start reveal-fade" style="transition-delay: 500ms;">
                <div class="shrink-0 w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                    <span class="material-symbols-outlined font-light">article</span>
                </div>
                <div>
                    <h4 class="text-lg font-normal text-slate-900 mb-2 group-hover:text-indigo-600 transition-colors">Refer-a-friend: RentEase Rewards Program</h4>
                    <p class="text-slate-500 font-light text-sm line-clamp-2">How to earn credits by sharing RentEase with your network.</p>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Still Need Help? Section -->
<section class="max-w-7xl mx-auto px-6 md:px-12 py-24">
    <div class="bg-slate-900 rounded-[3rem] p-12 md:p-20 flex flex-col lg:flex-row items-center justify-between gap-12 relative overflow-hidden shadow-2xl reveal-fade">
        <div class="absolute -right-32 -bottom-32 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl"></div>
        <div class="absolute -left-32 -top-32 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 text-center lg:text-left">
            <h2 class="text-4xl md:text-5xl font-normal text-white mb-6 tracking-tight">Still need help?</h2>
            <p class="text-lg text-white/70 font-light max-w-lg">Our dedicated concierge team is available 24/7 to ensure your home living experience is seamless.</p>
        </div>
        <div class="relative z-10 flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
            <a href="<?= baseUrl('/concierge') ?>" class="bg-teal-500 text-white font-normal px-8 py-4 rounded-full flex items-center justify-center gap-2 hover:bg-teal-400 transition-colors shadow-lg shadow-teal-500/30 w-full sm:w-auto">
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
<section class="max-w-7xl mx-auto px-6 md:px-12 py-24 border-t border-slate-100">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <div class="aspect-[4/3] rounded-[2.5rem] bg-cover bg-center shadow-xl overflow-hidden reveal-fade" style="background-image: url('https://images.unsplash.com/photo-1600607686527-6fb886090705?auto=format&fit=crop&q=80&w=1000')"></div>
        <div class="reveal-fade">
            <span class="inline-block bg-teal-50 text-teal-600 text-[10px] font-normal uppercase tracking-widest px-3 py-1.5 rounded-full mb-6">Community Knowledge</span>
            <h2 class="text-4xl md:text-5xl font-normal text-slate-900 mb-6 tracking-tight">Join the RentEase Circle</h2>
            <p class="text-lg text-slate-500 font-light mb-10 leading-relaxed">Connect with other urban professionals, share interior design tips, and get early access to our new furniture collections and sustainability initiatives.</p>
            <form class="flex flex-col sm:flex-row gap-3">
                <input class="flex-1 rounded-full border border-slate-200 bg-slate-50 focus:bg-white focus:border-teal-500 focus:ring-4 ring-teal-500/20 py-4 px-6 outline-none font-light transition-all text-slate-900 placeholder-slate-400" placeholder="Your email address" type="email" required/>
                <button type="submit" class="bg-slate-900 text-white font-normal px-8 py-4 rounded-full hover:bg-slate-800 transition-colors whitespace-nowrap shadow-lg">Join Now</button>
            </form>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
