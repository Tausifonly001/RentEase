<?php
/**
 * FAQ Article Detail
 *
 * Displays detailed information for a specific FAQ topic.
 */

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

$pageTitle = 'Return Process - RentEase Help Center';
require_once __DIR__ . '/partials/header.php';
?>

<main class="pt-8 pb-12 max-w-7xl mx-auto px-4 md:px-8">
 <!-- Breadcrumbs -->
 <nav aria-label="Breadcrumb" class="flex items-center space-x-2 text-on-surface-variant font-label-caps mb-8 text-xs uppercase tracking-wider font-light">
 <a class="hover:text-secondary transition-colors" href="<?= baseUrl('/help-center') ?>">Help Center</a>
 <span class="material-symbols-outlined text-[16px]">chevron_right</span>
 <a class="hover:text-secondary transition-colors" href="<?= baseUrl('/help-center') ?>">Returns & End of Lease</a>
 <span class="material-symbols-outlined text-[16px]">chevron_right</span>
 <span class="text-ink font-normal">Return Process</span>
 </nav>

 <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
 <!-- Sidebar: Table of Contents -->
 <aside class="hidden lg:block lg:col-span-3 space-y-8">
 <div class="sticky top-24">
 <h4 class="text-ink font-h3 text-xl mb-4">On this page</h4>
 <ul class="space-y-3 font-body-sm text-on-surface-variant border-l-2 border-border">
 <li><a class="block pl-4 py-1 border-l-2 -ml-[2px] border-champagne text-champagne-dark font-normal" href="#initiate">Initiating Return</a></li>
 <li><a class="block pl-4 py-1 hover:text-secondary transition-colors" href="#inspection">Pre-pickup Inspection</a></li>
 <li><a class="block pl-4 py-1 hover:text-secondary transition-colors" href="#pickup">Scheduling Logistics</a></li>
 <li><a class="block pl-4 py-1 hover:text-secondary transition-colors" href="#security">Security Deposit Refund</a></li>
 </ul>
 <div class="mt-12 bg-surface-container rounded-xl p-6">
 <h4 class="text-ink font-h3 text-lg mb-4">Related articles</h4>
 <ul class="space-y-4 font-body-sm">
 <li>
 <a class="text-champagne-dark hover:underline flex items-start" href="<?= baseUrl('/help-center') ?>">
 <span class="material-symbols-outlined mr-2 text-[18px]">article</span>
 Moving out early: Breakage terms
 </a>
 </li>
 <li>
 <a class="text-champagne-dark hover:underline flex items-start" href="<?= baseUrl('/help-center') ?>">
 <span class="material-symbols-outlined mr-2 text-[18px]">article</span>
 Tenure extension options
 </a>
 </li>
 <li>
 <a class="text-champagne-dark hover:underline flex items-start" href="<?= baseUrl('/help-center') ?>">
 <span class="material-symbols-outlined mr-2 text-[18px]">article</span>
 Damages and repair policy
 </a>
 </li>
 </ul>
 </div>
 </div>
 </aside>

 <!-- Main Article Content -->
 <article class="lg:col-span-6 bg-white p-6 md:p-10 rounded-xl shadow-sm border border-slate-50">
 <h1 class="font-h1 text-ink text-3xl md:text-4xl mb-6 leading-tight font-normal tracking-tight">How do I return my furniture at the end of a lease?</h1>

 <div class="flex items-center space-x-4 mb-8 text-on-surface-variant text-sm font-light">
 <div class="flex items-center">
 <span class="material-symbols-outlined mr-1 text-[18px]">calendar_today</span>
 Updated 2 days ago
 </div>
 <div class="flex items-center">
 <span class="material-symbols-outlined mr-1 text-[18px]">schedule</span>
 5 min read
 </div>
 </div>

 <div class="font-body-lg text-on-surface space-y-6 leading-relaxed">
 <p>Returning your furniture with RentEase is designed to be as seamless as the delivery. As your lease term approaches its final 30 days, you have several flexible options to choose from, ensuring your transition is stress-free.</p>

 <div class="my-8 rounded-xl overflow-hidden shadow-lg aspect-video bg-canvas">
 <img alt="Professional moving team" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDF0E0M6x5LKzDqEbKyUIg68wxUytmdIc0gSRBXT2DjrShZNpczsRkRTuSQU-t4edzTvJUZ-a95gbMHa3YSb4on0bGP0pXp2dARfbrXrlayuQKL_ur3h7Y9whSS0CT5eHYTZz3L6QU76X70JMiiFVN1YAkktabzSYffIY8pvZIvCRrEZUtdXx2Fot4jJgqyyaqs-bvoP6gw2c6Cg87AgrJZQXzppI_ME4wAF3cZVyQ94vRFBcly8nbV8RFZhOlpicHVyZMSCexZni4s"/>
 </div>

 <h2 class="font-h2 text-ink text-2xl font-normal mt-12 mb-4" id="initiate">1. Initiating the Return</h2>
 <p>Thirty days before your lease expires, you will receive an automated notification via the RentEase app. You can also manually start the process through your dashboard:</p>
 <ul class="list-disc pl-5 space-y-2">
 <li>Log in to your <strong>RentEase Account</strong>.</li>
 <li>Navigate to the <strong>My Rentals</strong> section.</li>
 <li>Select the active lease you wish to conclude.</li>
 <li>Click on <strong>Request Return</strong>.</li>
 </ul>

 <h2 class="font-h2 text-ink text-2xl font-normal mt-12 mb-4" id="inspection">2. Pre-pickup Inspection</h2>
 <p>To ensure a smooth deposit refund, we recommend a self-inspection of all items. Our team looks for "Normal Wear and Tear," which includes minor scuffs or fabric pilling. However, significant damage like deep gouges in wood or permanent stains may affect your refund status.</p>

 <div class="bg-champagne/10 border-l-4 border-champagne p-6 my-8 rounded-r-lg">
 <p class="font-normal text-champagne-dark mb-2 flex items-center gap-2">
 <span class="material-symbols-outlined">lightbulb</span>
 Pro Tip:
 </p>
 <p class="text-sm text-champagne-dark leading-relaxed font-light">Taking clear photos of your items 48 hours before pickup can serve as helpful documentation for your final inspection report.</p>
 </div>

 <h2 class="font-h2 text-ink text-2xl font-normal mt-12 mb-4" id="pickup">3. Scheduling Logistics</h2>
 <p>Once you request a return, you can pick a 4-hour window that fits your schedule. Our white-glove logistics team will arrive, disassemble larger items like bed frames or shelving units, and move everything out of your home. You do not need to lift a finger.</p>

 <h2 class="font-h2 text-ink text-2xl font-normal mt-12 mb-4" id="security">4. Security Deposit Refund</h2>
 <p>After the items reach our refurbishment center, a final quality check is performed. Your security deposit will be processed within 5-7 business days of the items being received. The funds will be returned to your original payment method.</p>
 </div>

 <!-- Feedback Widget -->
 <div class="mt-16 pt-8 border-t border-border text-center">
 <p class="font-h3 text-lg mb-6 font-normal">Was this article helpful?</p>
 <div class="flex justify-center space-x-4">
 <button class="flex items-center px-6 py-2 border border-border rounded-full hover:bg-surface transition-colors font-button text-ink font-normal">
 <span class="material-symbols-outlined mr-2">thumb_up</span>
 Yes
 </button>
 <button class="flex items-center px-6 py-2 border border-border rounded-full hover:bg-surface transition-colors font-button text-ink font-normal">
 <span class="material-symbols-outlined mr-2">thumb_down</span>
 No
 </button>
 </div>
 </div>
 </article>

 <!-- Sidebar: Support CTA -->
 <aside class="lg:col-span-3 space-y-6">
 <div class="bg-ink text-white rounded-xl p-8 shadow-xl">
 <h3 class="font-h3 text-xl mb-4 font-normal">Still need help?</h3>
 <p class="text-sm opacity-90 mb-6 leading-relaxed font-light">Our concierge team is available 24/7 to assist with your move-out logistics or billing questions.</p>
 <div class="space-y-4">
 <a href="<?= baseUrl('/concierge') ?>" class="flex items-center justify-center w-full py-3 bg-champagne text-white font-button rounded-lg hover:brightness-110 transition-all font-normal">
 <span class="material-symbols-outlined mr-2" style="font-variation-settings: 'FILL' 1;">chat_bubble</span>
 Live Chat
 </a>
 <a href="<?= baseUrl('/support') ?>" class="flex items-center justify-center w-full py-3 bg-white/10 text-white font-button border border-white/20 rounded-lg hover:bg-white/20 transition-all font-normal">
 <span class="material-symbols-outlined mr-2">mail</span>
 Email Support
 </a>
 </div>
 <div class="mt-8 pt-8 border-t border-white/10 text-center">
 <p class="text-xs text-white/60 mb-2 uppercase tracking-widest font-light">Call us directly</p>
 <p class="font-h3 text-xl font-normal">1-800-RENTEASE</p>
 </div>
 </div>
 </aside>
 </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
