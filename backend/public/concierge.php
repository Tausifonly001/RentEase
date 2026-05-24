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

<main class="bg-slate-50 dark:bg-slate-950 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 h-[750px]">
            <!-- Chat Window -->
            <section class="lg:col-span-8 flex flex-col bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
                <!-- Chat Header -->
                <header class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-white dark:bg-slate-900">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full bg-teal-600 flex items-center justify-center text-white">
                                <span class="material-symbols-outlined">support_agent</span>
                            </div>
                            <span class="absolute bottom-0 right-0 w-3 h-3 bg-teal-400 rounded-full border-2 border-white dark:border-slate-900"></span>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Support Concierge</h2>
                            <p class="text-xs text-teal-600 font-medium">Online</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button class="p-2 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl text-slate-500 transition-colors">
                            <span class="material-symbols-outlined">search</span>
                        </button>
                        <button class="p-2 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl text-slate-500 transition-colors">
                            <span class="material-symbols-outlined">more_vert</span>
                        </button>
                    </div>
                </header>

                <!-- Messaging Area -->
                <div id="chat-messages" class="flex-grow overflow-y-auto p-6 space-y-6 bg-slate-50/30 dark:bg-slate-950/30 chat-scrollbar">
                    <!-- Date Separator -->
                    <div class="flex justify-center">
                        <span class="bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest">Today</span>
                    </div>

                    <!-- Concierge Message -->
                    <div class="flex gap-3 max-w-[85%]">
                        <div class="w-8 h-8 rounded-full bg-teal-600 flex-shrink-0 flex items-center justify-center text-white">
                            <span class="material-symbols-outlined text-sm">support_agent</span>
                        </div>
                        <div class="space-y-1">
                            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 rounded-2xl rounded-tl-none shadow-sm">
                                <p class="text-sm text-slate-700 dark:text-slate-300">Hello <?= htmlspecialchars($currentUser['user_metadata']['full_name'] ?? 'there') ?>! Welcome back to RentEase Support. How can I assist you today?</p>
                            </div>
                            <span class="text-[10px] text-slate-400 px-1">10:24 AM</span>
                        </div>
                    </div>



                    <!-- Status Update -->
                    <div id="initial-status" class="flex justify-center">
                        <div class="flex items-center gap-2 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800/30 px-4 py-2 rounded-xl">
                            <span class="material-symbols-outlined text-emerald-600 text-sm">smart_toy</span>
                            <span class="text-xs text-emerald-900 dark:text-emerald-100 font-medium">AI Concierge is online and ready to help</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Replies -->
                <div class="px-6 py-4 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800">
                    <div class="flex gap-2 flex-wrap">
                        <button class="px-4 py-1.5 rounded-full border border-teal-600 text-teal-600 font-medium text-xs hover:bg-teal-50 dark:hover:bg-teal-900/20 transition-colors">Billing Inquiry</button>
                        <button class="px-4 py-1.5 rounded-full border border-teal-600 text-teal-600 font-medium text-xs hover:bg-teal-50 dark:hover:bg-teal-900/20 transition-colors">Maintenance Status</button>
                        <button class="px-4 py-1.5 rounded-full border border-teal-600 text-teal-600 font-medium text-xs hover:bg-teal-50 dark:hover:bg-teal-900/20 transition-colors">Delivery Update</button>
                        <button class="px-4 py-1.5 rounded-full border border-teal-600 text-teal-600 font-medium text-xs hover:bg-teal-50 dark:hover:bg-teal-900/20 transition-colors">Other</button>
                    </div>
                </div>

                <!-- Input Area -->
                <footer class="p-4 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800">
                    <form id="chat-form" class="flex items-center gap-3 bg-slate-50 dark:bg-slate-800/50 rounded-2xl px-4 py-2 border border-transparent focus-within:border-teal-600 focus-within:ring-1 focus-within:ring-teal-600 transition-all">
                        <button type="button" class="p-2 text-slate-500 hover:text-teal-600">
                            <span class="material-symbols-outlined">attachment</span>
                        </button>
                        <input type="text" id="chat-input" class="flex-grow bg-transparent border-none focus:ring-0 text-sm text-slate-900 dark:text-white py-2" placeholder="Type your message here..." required>
                        <button type="submit" id="chat-submit" class="bg-teal-600 text-white px-6 py-2.5 rounded-xl flex items-center gap-2 hover:bg-teal-500 transition-all active:scale-95 shadow-sm">
                            <span class="text-sm font-bold">Send</span>
                            <span class="material-symbols-outlined text-sm">send</span>
                        </button>
                    </form>
                </footer>
            </section>

            <!-- Contextual Sidebar -->
            <aside class="hidden lg:flex lg:col-span-4 flex-col gap-6">
                <!-- Active Rentals -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
                    <h3 class="text-slate-900 dark:text-white font-bold mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-teal-600">inventory_2</span>
                        Active Rentals
                    </h3>
                    <div class="space-y-4">
                        <div class="flex gap-4 p-3 rounded-xl border border-slate-50 dark:border-slate-800 hover:border-teal-100 dark:hover:border-teal-900/30 transition-colors group">
                            <div class="w-16 h-16 rounded-lg bg-slate-100 dark:bg-slate-800 overflow-hidden flex-shrink-0">
                                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuAOq3W0kiWCLELjfcWMen7ODze2YZA-2N34n3oJE66elrV0FTznx9HYGkJMrSvIqafPUbIWp01CMBTWs0ukSajdrFYa3cehsEfrSh_GaYcjRUJwn3Ih8Yf699jxtyAtNf6nwCLZ9w_yq49wy153MGN_V_SXCyi-Nh9TxTNkZXTkgMnGRQbrlgb2V7Xwhg0VhG9objCSdPOHN9iNsU0SZJaPw6fWlaPPZXAoXs4on0NAQCBtoe6E5BpLO7DX0a08_rBSCoFz6puQSWGJ" 
                                     alt="Rental" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="flex flex-col justify-center">
                                <p class="font-bold text-slate-900 dark:text-white text-sm">Emerald Velvet Sofa</p>
                                <p class="text-[10px] text-slate-500 uppercase tracking-wider font-bold">Premium Tier</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Support Resources -->
                <div class="bg-[#041627] text-white rounded-2xl p-6 shadow-lg overflow-hidden relative">
                    <div class="relative z-10">
                        <p class="text-lg font-bold mb-2">Need a faster resolution?</p>
                        <p class="text-sm text-slate-400 mb-6">Our help center has answers to 90% of common questions.</p>
                        <a href="<?= baseUrl('/help-center') ?>" class="inline-flex items-center gap-2 text-teal-400 font-bold text-sm hover:underline">
                            Browse Help Center
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                    <span class="material-symbols-outlined absolute -bottom-4 -right-4 text-7xl opacity-10 rotate-12">help_center</span>
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
    const quickReplies = document.querySelectorAll('.px-4.py-1\\.5.rounded-full');
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
            <div class="flex flex-row-reverse gap-3 max-w-[85%] ml-auto">
                <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-800 flex-shrink-0 flex items-center justify-center text-slate-600 dark:text-slate-400">
                    <span class="material-symbols-outlined text-sm">person</span>
                </div>
                <div class="space-y-1 text-right">
                    <div class="bg-teal-600 text-white p-4 rounded-2xl rounded-tr-none shadow-sm">
                        <p class="text-sm whitespace-pre-wrap">${escapeHtml(text)}</p>
                    </div>
                    <span class="text-[10px] text-slate-400 px-1">${time}</span>
                </div>
            </div>
        `;
        chatMessages.insertAdjacentHTML('beforeend', html);
        scrollToBottom();
    }

    function appendConciergeMessage(text) {
        const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const html = `
            <div class="flex gap-3 max-w-[85%]">
                <div class="w-8 h-8 rounded-full bg-teal-600 flex-shrink-0 flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-sm">support_agent</span>
                </div>
                <div class="space-y-1">
                    <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 rounded-2xl rounded-tl-none shadow-sm">
                        <p class="text-sm text-slate-700 dark:text-slate-300 whitespace-pre-wrap">${escapeHtml(text)}</p>
                    </div>
                    <span class="text-[10px] text-slate-400 px-1">${time}</span>
                </div>
            </div>
        `;
        chatMessages.insertAdjacentHTML('beforeend', html);
        scrollToBottom();
    }

    function showTypingIndicator() {
        const html = `
            <div id="typing-indicator" class="flex justify-center">
                <div class="flex items-center gap-2 bg-teal-50 dark:bg-teal-900/20 border border-teal-100 dark:border-teal-800/30 px-4 py-2 rounded-xl">
                    <span class="material-symbols-outlined text-teal-600 text-sm animate-spin">sync</span>
                    <span class="text-xs text-teal-900 dark:text-teal-100 font-medium">Concierge is typing...</span>
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
