<?php
/**
 * Support / Contact Page
 */

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use RentEase\Services\AuthService;

$authService = new AuthService($config);

if (session_status() !== PHP_SESSION_ACTIVE) {
 session_start();
}

$currentUser = null;
try {
 $token = $_COOKIE[$config['cookie_name'] ?? ''] ?? '';
 if ($token) {
 $currentUser = $authService->validateToken($token);
 }
} catch (Throwable $ignored) {}

$title = 'Contact Support | RentEase';
require_once __DIR__ . '/partials/header.php';
?>

<main class="pt-32 pb-24 bg-canvas min-h-screen">
 <div class="max-w-7xl mx-auto px-8">
 <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

 <!-- Left: Contact Info -->
 <div class="lg:col-span-1 space-y-8">
 <div>
 <h1 class="text-4xl font-normal text-ink mb-4 tracking-tight">How can we help?</h1>
 <p class="text-lg text-muted leading-relaxed">Our concierge team is ready to assist you with any questions about your rentals, billing, or technical issues.</p>
 </div>

 <div class="space-y-6">
 <div class="flex items-start gap-4">
 <div class="w-12 h-12 bg-surface flex items-center justify-center text-champagne-dark shrink-0" style="border-radius: 0.75rem;">
 <span class="material-symbols-outlined">chat_bubble</span>
 </div>
 <div>
 <h4 class="font-normal text-ink mb-1">Live Chat</h4>
 <p class="text-sm text-muted font-light">Available 24/7 for urgent issues</p>
 <a href="<?= baseUrl('/concierge') ?>" class="text-champagne-dark text-sm font-light mt-2 hover:underline inline-block">Start Chatting →</a>
 </div>
 </div>

 <div class="flex items-start gap-4">
 <div class="w-12 h-12 bg-surface flex items-center justify-center text-champagne-dark shrink-0" style="border-radius: 0.75rem;">
 <span class="material-symbols-outlined">mail</span>
 </div>
 <div>
 <h4 class="font-normal text-ink mb-1">Email Support</h4>
 <p class="text-sm text-muted font-light">Typical response within 2 hours</p>
 <a href="mailto:support@rentease.com" class="text-champagne-dark text-sm font-light mt-1 hover:underline">support@rentease.com</a>
 </div>
 </div>

 <div class="flex items-start gap-4">
 <div class="w-12 h-12 bg-surface flex items-center justify-center text-champagne-dark shrink-0" style="border-radius: 0.75rem;">
 <span class="material-symbols-outlined">call</span>
 </div>
 <div>
 <h4 class="font-normal text-ink mb-1">Phone Support</h4>
 <p class="text-sm text-muted font-light">Mon-Fri, 9am - 6pm EST</p>
 <a href="tel:+1800RENTEASE" class="text-champagne-dark text-sm font-light mt-1 hover:underline">+1 (800) RENT-EASE</a>
 </div>
 </div>
 </div>

 <!-- FAQ Link -->
 <div class="p-6 bg-ink text-white relative overflow-hidden group" style="border-radius: 0.75rem;">
 <div class="relative z-10">
 <h4 class="font-normal mb-2">Check the Help Center</h4>
 <p class="text-xs text-white/70 mb-4 font-light">Most questions can be answered instantly in our knowledge base.</p>
 <a href="<?= baseUrl('/help-center') ?>" class="inline-block bg-champagne text-white text-xs font-light px-4 py-2 hover:brightness-110 transition-all" style="border-radius: 0.5rem;">Go to FAQs</a>
 </div>
 <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-7xl text-white/5 group-hover:scale-110 transition-transform">help</span>
 </div>
 </div>

 <!-- Right: Ticket Form -->
 <div class="lg:col-span-2">
 <div class="bg-surface rounded-3xl p-8 md:p-12 reveal-element" style="border-color: rgba(231,229,228,0.6);">
 <form id="support-form" class="space-y-8">
 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <div class="space-y-2">
 <label class="text-[10px] font-normal text-muted-light uppercase tracking-widest px-1">Reason for contact</label>
 <select name="category" required class="w-full p-4 bg-canvas border text-ink font-normal appearance-none outline-none transition-all focus:ring-4 focus:ring-secondary/10 focus:border-secondary" style="border-color: rgba(231,229,228,0.6);">
 <option value="">Select a category</option>
 <option value="billing">Billing & Payments</option>
 <option value="delivery">Delivery & Setup</option>
 <option value="maintenance">Maintenance Request</option>
 <option value="account">Account Management</option>
 <option value="other">Something else</option>
 </select>
 </div>
 <div class="space-y-2">
 <label class="text-[10px] font-normal text-muted-light uppercase tracking-widest px-1">Subject</label>
 <input type="text" name="subject" required placeholder="Briefly describe the issue" class="w-full p-4 bg-canvas border text-ink font-normal outline-none transition-all focus:ring-4 focus:ring-secondary/10 focus:border-secondary" style="border-color: rgba(231,229,228,0.6);">
 </div>
 </div>

 <div class="space-y-2">
 <label class="text-[10px] font-normal text-muted-light uppercase tracking-widest px-1">Describe your issue</label>
 <textarea name="description" required placeholder="Please provide as much detail as possible..." class="w-full p-4 bg-canvas border text-ink font-normal outline-none transition-all focus:ring-4 focus:ring-secondary/10 focus:border-secondary min-h-[180px]" style="border-color: rgba(231,229,228,0.6);"></textarea>
 </div>

 <div class="flex items-center gap-4 p-4 bg-champagne/10 border border-champagne/20" style="border-radius: 0.75rem;">
 <span class="material-symbols-outlined text-champagne">info</span>
 <p class="text-xs text-champagne-dark font-light">Providing your Order ID helps us resolve issues faster.</p>
 </div>

 <div class="pt-4">
 <button type="submit" id="submit-btn" class="w-full bg-ink text-white font-normal py-5 hover:opacity-95 transition-all active:scale-95 text-lg flex items-center justify-center gap-2" style="border-radius: 0.75rem;">
 Submit Support Ticket
 </button>
 </div>
 </form>
 </div>
 </div>
 </div>
 </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
 gsap.from('.reveal-element', {
 opacity: 0,
 x: 30,
 duration: 1,
 ease: 'power4.out'
 });

 document.getElementById('support-form').addEventListener('submit', async (e) => {
 e.preventDefault();

 const btn = document.getElementById('submit-btn');
 const originalText = btn.innerHTML;
 btn.disabled = true;
 btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-xl">sync</span> Processing...';

 const formData = new FormData(e.target);
 const data = Object.fromEntries(formData.entries());

 try {
  const response = await fetch('<?= baseUrl('/api/support/ticket') ?>', {
 method: 'POST',
 headers: { 'Content-Type': 'application/json' },
 body: JSON.stringify(data)
 });

 const result = await response.json();
 if (result.success) {
 btn.innerHTML = '<span class="material-symbols-outlined text-xl">check_circle</span> Submitted Successfully';
 btn.classList.replace('bg-ink', 'bg-champagne');

 setTimeout(() => {
 window.location.href = '<?= baseUrl('/dashboard') ?>?msg=ticket_created';
 }, 1500);
 } else {
 alert(result.error || 'Failed to submit ticket');
 btn.disabled = false;
 btn.innerHTML = originalText;
 }
 } catch (error) {
 console.error(error);
 alert('An unexpected error occurred');
 btn.disabled = false;
 btn.innerHTML = originalText;
 }
 });
});
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
