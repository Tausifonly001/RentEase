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
<section class="bg-primary text-white py-20 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-8 relative z-10 text-center md:text-left">
        <span class="font-label-caps text-secondary uppercase tracking-widest mb-xs block">Support Concierge</span>
        <h1 class="font-h1 text-h1 mb-md tracking-tight">How can we help you today?</h1>
        <p class="font-body-lg text-body-lg text-on-primary-container max-w-2xl mb-lg">Search our knowledge base for everything from delivery schedules to our rent-to-own program details.</p>
        <div class="flex flex-col md:flex-row gap-md max-w-xl">
            <div class="flex-1 relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline" style="font-size: 20px;">search</span>
                <input type="text" class="w-full bg-white text-primary border-none rounded-lg pl-12 pr-4 py-3.5 focus:ring-2 focus:ring-secondary text-sm shadow-lg" placeholder="Search for 'security deposit', 'delivery'...">
            </div>
            <button class="bg-secondary text-white font-button px-lg py-3.5 rounded-lg hover:brightness-110 transition-all shadow-lg active:scale-95 duration-150">Search</button>
        </div>
    </div>
    <!-- Decorative background elements -->
    <div class="absolute -right-20 -top-20 w-80 h-80 bg-secondary/10 rounded-full blur-3xl"></div>
    <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-secondary/10 rounded-full blur-3xl"></div>
</section>

<!-- Category Grid -->
<section class="max-w-7xl mx-auto px-8 py-xl">
    <h2 class="font-h2 text-h2 text-primary mb-lg">Browse by Category</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
        <!-- Category 1 -->
        <a href="faq-article.php" class="bg-white p-lg rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl transition-all cursor-pointer group">
            <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-secondary mb-md group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined" style="font-size: 28px;">local_shipping</span>
            </div>
            <h3 class="font-h3 text-h3 mb-xs text-primary">Delivery & Returns</h3>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Tracking, white-glove setup, and return logistics.</p>
        </a>
        <!-- Category 2 -->
        <a href="faq-article.php" class="bg-white p-lg rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl transition-all cursor-pointer group">
            <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-secondary mb-md group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined" style="font-size: 28px;">payments</span>
            </div>
            <h3 class="font-h3 text-h3 mb-xs text-primary">Billing & Payments</h3>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Payment methods, invoices, and security deposits.</p>
        </a>
        <!-- Category 3 -->
        <div class="bg-white p-lg rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl transition-all cursor-pointer group">
            <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-secondary mb-md group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined" style="font-size: 28px;">handyman</span>
            </div>
            <h3 class="font-h3 text-h3 mb-xs text-primary">Maintenance</h3>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Repair requests, damage policy, and cleanings.</p>
        </div>
        <!-- Category 4 -->
        <div class="bg-white p-lg rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl transition-all cursor-pointer group">
            <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-secondary mb-md group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined" style="font-size: 28px;">workspace_premium</span>
            </div>
            <h3 class="font-h3 text-h3 mb-xs text-primary">Lease & Credits</h3>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Rent-to-own, tenure extensions, and points.</p>
        </div>
    </div>
</section>

<!-- Trending Articles Section -->
<section class="bg-surface py-xl">
    <div class="max-w-7xl mx-auto px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-lg gap-md">
            <div>
                <h2 class="font-h2 text-h2 text-primary mb-xs">Trending Knowledge</h2>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-lg">Quick answers to the most common questions from our community of urban dwellers.</p>
            </div>
            <button class="font-button text-secondary flex items-center gap-2 hover:gap-3 transition-all">View all articles <span class="material-symbols-outlined">arrow_forward</span></button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-md">
            <!-- Article Card 1 -->
            <a href="faq-article.php" class="bg-white p-md rounded-xl shadow-sm hover:shadow-lg transition-all group flex gap-md items-start">
                <div class="shrink-0 w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-sm">article</span>
                </div>
                <div>
                    <h4 class="font-h3 text-[18px] mb-xs group-hover:text-secondary transition-colors">How do I return my furniture at the end of a lease?</h4>
                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2">Complete guide on scheduling pickups and refunding security deposits.</p>
                </div>
            </a>
            <!-- Article Card 2 -->
            <a href="faq-article.php" class="bg-white p-md rounded-xl shadow-sm hover:shadow-lg transition-all group flex gap-md items-start">
                <div class="shrink-0 w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-sm">article</span>
                </div>
                <div>
                    <h4 class="font-h3 text-[18px] mb-xs group-hover:text-secondary transition-colors">Can I purchase the items I am currently renting?</h4>
                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2">Understand the 'Rent-to-Own' credits and buyout options.</p>
                </div>
            </a>
            <!-- Article Card 3 -->
            <a href="faq-article.php" class="bg-white p-md rounded-xl shadow-sm hover:shadow-lg transition-all group flex gap-md items-start">
                <div class="shrink-0 w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-sm">article</span>
                </div>
                <div>
                    <h4 class="font-h3 text-[18px] mb-xs group-hover:text-secondary transition-colors">What happens if I accidentally damage an item?</h4>
                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2">Details on our damage protection plans and repair policies.</p>
                </div>
            </a>
            <!-- Article Card 4 -->
            <div class="bg-white p-md rounded-xl shadow-sm hover:shadow-lg transition-all group flex gap-md items-start">
                <div class="shrink-0 w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-sm">article</span>
                </div>
                <div>
                    <h4 class="font-h3 text-[18px] mb-xs group-hover:text-secondary transition-colors">Updating your billing information and autopay</h4>
                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2">Step-by-step guide to managing your payments securely.</p>
                </div>
            </div>
            <!-- Article Card 5 -->
            <div class="bg-white p-md rounded-xl shadow-sm hover:shadow-lg transition-all group flex gap-md items-start">
                <div class="shrink-0 w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-sm">article</span>
                </div>
                <div>
                    <h4 class="font-h3 text-[18px] mb-xs group-hover:text-secondary transition-colors">Delivery window: What to expect on your big day</h4>
                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2">Preparing your space for our white-glove delivery team.</p>
                </div>
            </div>
            <!-- Article Card 6 -->
            <a href="faq-article.php" class="bg-white p-md rounded-xl shadow-sm hover:shadow-lg transition-all group flex gap-md items-start">
                <div class="shrink-0 w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-sm">article</span>
                </div>
                <div>
                    <h4 class="font-h3 text-[18px] mb-xs group-hover:text-secondary transition-colors">Refer-a-friend: RentEase Rewards Program</h4>
                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2">How to earn credits by sharing RentEase with your network.</p>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Still Need Help? Section -->
<section class="max-w-7xl mx-auto px-8 py-xl">
    <div class="bg-primary text-white rounded-2xl p-lg md:p-xl flex flex-col md:flex-row items-center justify-between gap-lg relative overflow-hidden">
        <div class="relative z-10 text-center md:text-left">
            <h2 class="font-h2 text-h2 mb-md">Still need help?</h2>
            <p class="font-body-lg text-body-lg text-on-primary-container max-w-lg">Our dedicated concierge team is available 24/7 to ensure your home living experience is seamless.</p>
        </div>
        <div class="relative z-10 flex flex-col sm:flex-row gap-md">
            <button class="bg-secondary text-white font-button text-button px-lg py-md rounded-lg flex items-center gap-xs hover:bg-[#005a56] transition-all">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">chat</span>
                Start Live Chat
            </button>
            <button class="bg-transparent border border-white/30 text-white font-button text-button px-lg py-md rounded-lg flex items-center gap-xs hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined">mail</span>
                Email Support
            </button>
        </div>
        <!-- Decorative element -->
        <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-secondary/20 rounded-full blur-3xl"></div>
    </div>
</section>

<!-- Newsletter / Community Section -->
<section class="max-w-7xl mx-auto px-8 py-xl border-t border-slate-200">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-xl items-center">
        <div class="aspect-video rounded-2xl bg-cover bg-center shadow-lg" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDg8tZU96fhGQ9YwsJGQrBXNshP9FksstBcTSAfFI-rpFOgIuAi0Fc_dxZgOkgaGL2xuernOmoqMKGwJlPyAjNDfoNXZAOcde7b6YsUYpM0QiL6OrkzC0BnbbQ-SSe5aldoJW1-hukc9jphMethQQrvj9oN4O-mG9t9vjqyLv-XIro8w8W2b7psA-Ezg_mzt_8apA_uiCCHt0MMzB6JP2kVg37HdAYOhjBNLXk1XXzV9TQeYeojL6RIgFvi_dd2Vb91wv2qb3CU3FBT')"></div>
        <div>
            <span class="font-label-caps text-label-caps text-secondary uppercase tracking-widest mb-xs block">Community Knowledge</span>
            <h2 class="font-h2 text-h2 text-primary mb-md">Join the RentEase Circle</h2>
            <p class="font-body-md text-body-md text-on-surface-variant mb-lg leading-relaxed">Connect with other urban professionals, share interior design tips, and get early access to our new furniture collections and sustainability initiatives.</p>
            <div class="flex gap-xs">
                <input class="flex-1 rounded-lg border border-slate-200 focus:border-secondary focus:ring-secondary py-md px-md outline-none" placeholder="Your email address" type="email"/>
                <button class="bg-primary text-white font-button text-button px-lg py-md rounded-lg hover:bg-primary/90 transition-all">Join Now</button>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
