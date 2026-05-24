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

<main class="pt-32 pb-24 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Left: Contact Info -->
            <div class="lg:col-span-1 space-y-8">
                <div>
                    <h1 class="text-4xl font-bold text-primary mb-4 tracking-tight">How can we help?</h1>
                    <p class="text-lg text-slate-500 leading-relaxed">Our concierge team is ready to assist you with any questions about your rentals, billing, or technical issues.</p>
                </div>

                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-secondary shrink-0">
                            <span class="material-symbols-outlined">chat_bubble</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-primary mb-1">Live Chat</h4>
                            <p class="text-sm text-slate-500">Available 24/7 for urgent issues</p>
                            <a href="concierge.php" class="text-secondary text-sm font-bold mt-2 hover:underline inline-block">Start Chatting →</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-secondary shrink-0">
                            <span class="material-symbols-outlined">mail</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-primary mb-1">Email Support</h4>
                            <p class="text-sm text-slate-500">Typical response within 2 hours</p>
                            <p class="text-secondary text-sm font-bold mt-1">support@rentease.com</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-secondary shrink-0">
                            <span class="material-symbols-outlined">call</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-primary mb-1">Phone Support</h4>
                            <p class="text-sm text-slate-500">Mon-Fri, 9am - 6pm EST</p>
                            <p class="text-secondary text-sm font-bold mt-1">+1 (800) RENT-EASE</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Link -->
                <div class="p-6 bg-primary text-white rounded-2xl relative overflow-hidden group">
                    <div class="relative z-10">
                        <h4 class="font-bold mb-2">Check the Help Center</h4>
                        <p class="text-xs text-on-primary-container mb-4">Most questions can be answered instantly in our knowledge base.</p>
                        <a href="help-center.php" class="inline-block bg-secondary text-white text-xs font-bold px-4 py-2 rounded-lg hover:brightness-110 transition-all">Go to FAQs</a>
                    </div>
                    <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-7xl text-white/5 group-hover:scale-110 transition-transform">help</span>
                </div>
            </div>

            <!-- Right: Ticket Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 p-8 md:p-12 reveal-element">
                    <form id="support-form" class="space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Reason for contact</label>
                                <select name="category" required class="w-full p-4 bg-slate-50 border border-slate-100 rounded-xl focus:ring-4 focus:ring-secondary/10 focus:border-secondary outline-none transition-all text-slate-700 font-medium appearance-none">
                                    <option value="">Select a category</option>
                                    <option value="billing">Billing & Payments</option>
                                    <option value="delivery">Delivery & Setup</option>
                                    <option value="maintenance">Maintenance Request</option>
                                    <option value="account">Account Management</option>
                                    <option value="other">Something else</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Subject</label>
                                <input type="text" name="subject" required placeholder="Briefly describe the issue" class="w-full p-4 bg-slate-50 border border-slate-100 rounded-xl focus:ring-4 focus:ring-secondary/10 focus:border-secondary outline-none transition-all text-slate-700 font-medium">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Describe your issue</label>
                            <textarea name="description" required placeholder="Please provide as much detail as possible..." class="w-full p-4 bg-slate-50 border border-slate-100 rounded-xl focus:ring-4 focus:ring-secondary/10 focus:border-secondary outline-none transition-all text-slate-700 font-medium min-h-[180px]"></textarea>
                        </div>

                        <div class="flex items-center gap-4 p-4 bg-blue-50/50 rounded-xl border border-blue-100">
                            <span class="material-symbols-outlined text-blue-500">info</span>
                            <p class="text-xs text-blue-700 font-medium">Providing your Order ID helps us resolve issues faster.</p>
                        </div>

                        <div class="pt-4">
                            <button type="submit" id="submit-btn" class="w-full bg-primary text-white font-bold py-5 rounded-2xl shadow-xl shadow-primary/20 hover:opacity-95 transition-all active:scale-95 text-lg flex items-center justify-center gap-2">
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
        const data = Object.from_entries(formData.entries());

        try {
            const response = await fetch('api/support/ticket.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            if (result.success) {
                btn.innerHTML = '<span class="material-symbols-outlined text-xl">check_circle</span> Submitted Successfully';
                btn.classList.replace('bg-primary', 'bg-emerald-500');
                
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
