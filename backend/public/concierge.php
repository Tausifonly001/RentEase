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

$pageTitle = "Support Concierge | RentEase";
include_once __DIR__ . '/partials/header.php';
?>

<main class="bg-surface min-h-screen pt-40 pb-20 relative overflow-hidden">
 <div class="max-w-[1600px] mx-auto px-6 lg:px-12 relative z-10">

 <div class="mb-12">
 <h1 class="text-5xl md:text-6xl font-serif font-medium text-ink tracking-tight mb-4">Concierge</h1>
 <p class="text-muted text-lg font-light">We're here to help you design your perfect space.</p>
 </div>

 <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 h-[75vh] min-h-[600px]">
 <!-- Chat Window -->
 <section class="lg:col-span-8 flex flex-col bg-white border border-zinc-200 shadow-sm overflow-hidden">
 <!-- Chat Header -->
 <header class="px-8 py-6 border-b border-zinc-200 flex items-center justify-between bg-white">
 <div class="flex items-center gap-4">
 <div class="relative">
 <div class="w-12 h-12 rounded-none bg-surface flex items-center justify-center text-ink border border-zinc-200">
 <span class="material-symbols-outlined">support_agent</span>
 </div>
 <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-green-500 border-2 border-white"></span>
 </div>
 <div>
 <h2 class="text-lg font-serif font-medium text-ink">RentEase Concierge</h2>
 <p class="text-xs text-zinc-400 font-medium tracking-wide flex items-center gap-1.5 uppercase">
 <span class="w-1.5 h-1.5 bg-green-500 animate-pulse"></span>
 Online
 </p>
 </div>
 </div>
 <div class="flex gap-2">
 <button class="p-2 hover:bg-surface text-zinc-400 hover:text-ink transition-colors outline-none focus-visible:ring-1 ring-ink">
 <span class="material-symbols-outlined font-light">search</span>
 </button>
 <button class="p-2 hover:bg-surface text-zinc-400 hover:text-ink transition-colors outline-none focus-visible:ring-1 ring-ink">
 <span class="material-symbols-outlined font-light">more_vert</span>
 </button>
 </div>
 </header>

 <!-- Messaging Area -->
 <div id="chat-messages" class="flex-grow overflow-y-auto p-8 space-y-8 chat-scrollbar">
 <!-- Date Separator -->
 <div class="flex justify-center">
 <span class="bg-white border border-zinc-200 text-zinc-400 px-4 py-1.5 text-[10px] font-medium uppercase tracking-[0.2em]">Today</span>
 </div>

 <!-- Concierge Message -->
 <div class="flex gap-4 max-w-[85%]">
 <div class="w-10 h-10 bg-surface flex-shrink-0 flex items-center justify-center text-ink border border-zinc-200">
 <span class="material-symbols-outlined text-sm font-light">support_agent</span>
 </div>
 <div class="space-y-1.5">
 <div class="bg-surface border border-zinc-200 p-5 rounded-none shadow-sm">
 <p class="text-zinc-600 font-light leading-relaxed">Hello <?= htmlspecialchars($currentUser['user_metadata']['full_name'] ?? 'there') ?>! Welcome back to RentEase Support. How can I assist you today?</p>
 </div>
 <span class="text-[10px] text-zinc-400 font-medium px-2 uppercase tracking-widest">10:24 AM</span>
 </div>
 </div>

 <!-- Status Update -->
 <div id="initial-status" class="flex justify-center">
 <div class="flex items-center gap-2 bg-white border border-zinc-200 px-5 py-2.5 shadow-sm">
 <span class="material-symbols-outlined text-ink text-sm font-light">smart_toy</span>
 <span class="text-[10px] text-muted uppercase tracking-widest font-medium">AI Concierge is online</span>
 </div>
 </div>
 </div>

 <!-- Quick Replies -->
 <div class="px-8 py-5 bg-surface border-t border-zinc-200">
 <div class="flex gap-3 flex-wrap">
 <button class="px-5 py-2 bg-white border border-zinc-200 text-muted font-medium text-[10px] uppercase tracking-[0.1em] hover:text-ink hover:border-ink transition-colors outline-none focus-visible:ring-1 ring-ink">Billing Inquiry</button>
 <button class="px-5 py-2 bg-white border border-zinc-200 text-muted font-medium text-[10px] uppercase tracking-[0.1em] hover:text-ink hover:border-ink transition-colors outline-none focus-visible:ring-1 ring-ink">Maintenance Status</button>
 <button class="px-5 py-2 bg-white border border-zinc-200 text-muted font-medium text-[10px] uppercase tracking-[0.1em] hover:text-ink hover:border-ink transition-colors outline-none focus-visible:ring-1 ring-ink">Delivery Update</button>
 <button class="px-5 py-2 bg-white border border-zinc-200 text-muted font-medium text-[10px] uppercase tracking-[0.1em] hover:text-ink hover:border-ink transition-colors outline-none focus-visible:ring-1 ring-ink">Other</button>
 </div>
 </div>

 <!-- Input Area -->
 <footer class="p-6 bg-white border-t border-zinc-200">
 <form id="chat-form" class="flex items-center gap-3 bg-surface border border-zinc-200 px-4 py-2 focus-within:border-ink transition-colors">
 <button type="button" class="p-2 text-zinc-400 hover:text-ink transition-colors outline-none focus-visible:text-ink">
 <span class="material-symbols-outlined font-light">attachment</span>
 </button>
 <input type="text" id="chat-input" class="flex-grow bg-transparent border-none focus:ring-0 text-ink py-3 font-light placeholder-zinc-400 outline-none" placeholder="Type your message here..." required>
 <button type="submit" id="chat-submit" class="bg-ink hover:bg-zinc-800 text-white px-6 py-3 flex items-center gap-2 transition-all font-medium text-[11px] uppercase tracking-[0.2em] outline-none focus-visible:ring-1 ring-ink border border-ink">
 <span>Send</span>
 <span class="material-symbols-outlined text-sm font-light">send</span>
 </button>
 </form>
 </footer>
 </section>

 <!-- Contextual Sidebar -->
 <aside class="hidden lg:flex lg:col-span-4 flex-col gap-8">
 <!-- Active Rentals -->
 <div class="bg-white border border-zinc-200 p-8 shadow-sm">
 <h3 class="text-ink font-serif font-medium text-xl mb-6 flex items-center gap-3 border-b border-zinc-200 pb-4">
 <span class="material-symbols-outlined text-ink font-light">inventory_2</span>
 Active Rentals
 </h3>
 <div class="space-y-4">
 <div class="flex gap-5 p-4 border border-zinc-200 bg-surface hover:border-ink transition-colors group cursor-pointer">
 <div class="w-20 h-24 overflow-hidden flex-shrink-0 relative">
 <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&q=80&w=200"
 alt="Rental" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
 </div>
 <div class="flex flex-col justify-center">
 <p class="font-serif font-medium text-ink text-lg mb-2">Emerald Velvet Sofa</p>
 <p class="text-[9px] text-zinc-400 uppercase tracking-widest font-medium">Premium Tier</p>
 </div>
 </div>
 </div>
 </div>

 <!-- Support Resources -->
 <div class="bg-ink border border-ink p-8 relative overflow-hidden group">
 <div class="relative z-10">
 <h3 class="text-white font-serif font-medium text-2xl mb-4">Need a faster resolution?</h3>
 <p class="text-sm text-zinc-400 leading-relaxed mb-8 font-light">Our help center has answers to 90% of common questions, curated for your convenience.</p>
 <a href="<?= baseUrl('/help-center') ?>" class="inline-flex items-center justify-center gap-2 text-ink bg-white hover:bg-zinc-200 px-6 py-4 transition-colors outline-none focus-visible:ring-1 ring-white font-medium text-[11px] uppercase tracking-[0.2em] w-full">
 Browse Help Center
 <span class="material-symbols-outlined text-sm font-light">arrow_forward</span>
 </a>
 </div>
 </div>
 </aside>
 </div>
 </div>
</main>


<script>
document.addEventListener('DOMContentLoaded', () => {
 const chatForm = document.getElementById('chat-form');
 const chatInput = document.getElementById('chat-input');
 const chatMessages = document.getElementById('chat-messages');
 const submitBtn = document.getElementById('chat-submit');

 // Quick Replies
 const quickReplies = document.querySelectorAll('.px-5.py-2.bg-white.border');
 quickReplies.forEach(btn => {
 btn.addEventListener('click', () => {
 chatInput.value = btn.innerText;
 if (chatForm.requestSubmit) {
 chatForm.requestSubmit();
 } else {
 chatForm.dispatchEvent(new Event('submit', { cancelable: true }));
 }
 });
 });

 function appendUserMessage(text) {
 const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
 const html = `
 <div class="flex flex-row-reverse gap-4 max-w-[85%] ml-auto">
 <div class="w-10 h-10 bg-ink flex-shrink-0 flex items-center justify-center text-white">
 <span class="material-symbols-outlined text-sm font-light">person</span>
 </div>
 <div class="space-y-1.5 text-right">
 <div class="bg-ink text-white p-5 border border-ink shadow-sm">
 <p class="font-light leading-relaxed whitespace-pre-wrap">${escapeHtml(text)}</p>
 </div>
 <span class="text-[10px] text-zinc-400 font-medium px-2 uppercase tracking-widest">${time}</span>
 </div>
 </div>
 `;
 chatMessages.insertAdjacentHTML('beforeend', html);
 scrollToBottom();
 }

 function appendConciergeMessage(text) {
 const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
 const html = `
 <div class="flex gap-4 max-w-[85%]">
 <div class="w-10 h-10 bg-surface flex-shrink-0 flex items-center justify-center text-ink border border-zinc-200">
 <span class="material-symbols-outlined text-sm font-light">support_agent</span>
 </div>
 <div class="space-y-1.5">
 <div class="bg-surface border border-zinc-200 p-5 shadow-sm">
 <p class="text-zinc-600 font-light leading-relaxed whitespace-pre-wrap">${escapeHtml(text)}</p>
 </div>
 <span class="text-[10px] text-zinc-400 font-medium px-2 uppercase tracking-widest">${time}</span>
 </div>
 </div>
 `;
 chatMessages.insertAdjacentHTML('beforeend', html);
 scrollToBottom();
 }

 function showTypingIndicator() {
 const html = `
 <div id="typing-indicator" class="flex justify-center">
 <div class="flex items-center gap-2 bg-white border border-zinc-200 px-5 py-2.5 shadow-sm">
 <span class="material-symbols-outlined text-ink text-sm animate-spin font-light">sync</span>
 <span class="text-[10px] text-muted uppercase tracking-widest font-medium">Concierge is typing...</span>
 </div>
 </div>
 `;
 chatMessages.insertAdjacentHTML('beforeend', html);
 scrollToBottom();
 }

 function removeTypingIndicator() {
 const indicator = document.getElementById('typing-indicator');
 if (indicator) indicator.remove();
 }

 function scrollToBottom() {
 chatMessages.scrollTop = chatMessages.scrollHeight;
 }

 function escapeHtml(unsafe) {
 return unsafe
 .replace(/&/g, "&amp;")
 .replace(/</g, "&lt;")
 .replace(/>/g, "&gt;")
 .replace(/"/g, "&quot;")
 .replace(/'/g, "&#039;");
 }

 chatForm.addEventListener('submit', async (e) => {
 e.preventDefault();

 const message = chatInput.value.trim();
 if (!message) return;

 // Disable input
 chatInput.value = '';
 chatInput.disabled = true;
 submitBtn.disabled = true;

 appendUserMessage(message);

 // Remove existing connect status if exists
 const initialStatus = document.getElementById('initial-status');
 if(initialStatus) initialStatus.remove();

 showTypingIndicator();

 try {
 const response = await fetch('<?= baseUrl('/api/chat') ?>', {
 method: 'POST',
 headers: {
 'Content-Type': 'application/json'
 },
 body: JSON.stringify({ message })
 });

 removeTypingIndicator();

 if (response.ok) {
 const data = await response.json();
 appendConciergeMessage(data.reply || "Sorry, I couldn't process that.");
 } else {
 appendConciergeMessage("I'm currently experiencing technical difficulties. Please try again later.");
 }
 } catch (error) {
 removeTypingIndicator();
 appendConciergeMessage("Network error. Please check your connection.");
 } finally {
 chatInput.disabled = false;
 submitBtn.disabled = false;
 chatInput.focus();
 }
 });
});
</script>

<?php include_once __DIR__ . '/partials/footer.php'; ?>
