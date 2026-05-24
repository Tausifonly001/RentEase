<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use RentEase\Services\AuthService;
use RentEase\Services\ReferralService;

$authService = new AuthService($config);
$referralService = new ReferralService($config);

// Check authentication
$jwt = $_COOKIE[$config['cookie_name']] ?? '';
$user = $authService->validateToken($jwt);

if (!$user) {
    header('Location: ' . baseUrl('/login'));
    exit;
}

$userId = $user['id'];
$stats = $referralService->getReferralStats($userId);
$history = $referralService->getReferralHistory($userId);

$title = 'Refer a Friend | RentEase';
include __DIR__ . '/partials/header.php';
?>

<main class="pt-20">
    <!-- Hero Section -->
    <section class="relative bg-primary py-16 md:py-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 md:grid-cols-2 gap-12 items-center relative z-10">
            <div class="text-left text-white">
                <span class="inline-block px-3 py-1 bg-secondary/20 text-secondary-fixed-dim rounded-full text-[10px] font-bold tracking-widest mb-6 uppercase">RENTAL REFERRAL PROGRAM</span>
                <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">Give $50, Get $50</h1>
                <p class="text-lg text-slate-400 mb-8 max-w-lg">
                    Invite your friends to experience premium living. When they start their first rental, you both get a $50 credit towards your monthly subscription.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <button onclick="document.getElementById('referral-link-section').scrollIntoView({behavior: 'smooth'})" class="bg-secondary text-white px-8 py-4 rounded-lg font-bold hover:opacity-90 transition-all shadow-lg active:scale-95 text-center">Invite Friends Now</button>
                    <button class="bg-white/10 border border-white/20 text-white px-8 py-4 rounded-lg font-bold hover:bg-white/20 transition-all active:scale-95 text-center">View Reward Details</button>
                </div>
            </div>
            <div class="relative hidden md:block">
                <div class="aspect-square rounded-xl overflow-hidden shadow-2xl border border-white/10">
                    <img class="w-full h-full object-cover" 
                         src="https://lh3.googleusercontent.com/aida-public/AB6AXuBsrRbEeav9LaRgmITLWQRHrh2CJSdoBqRX_Vkr6gNWz4t4pvyZ1pol8jovMZNnRpvnzexEogEirsP6wG3oqo9fdpInPvFRyB9F3ge1iKD6h47VenEfqGFBvhfJl6Cfyi2A0YymydYcZgBBfdldYciHojR-0mQZNxfpVKrgtsXzLOfjfNuZebwOAIFcvInUHKtLsB9XNKsqjY603WSOEH-Tvwx02cgiwU09S_uvNl9k8iGhAUbe1pOPfwEpuraqMaJ9PCeTzS_7L9PS" 
                         alt="Happy friends sharing a moment in a modern living room">
                </div>
                <div class="absolute -bottom-6 -left-6 bg-secondary p-6 rounded-lg shadow-xl">
                    <p class="text-white text-2xl font-bold">$500+</p>
                    <p class="text-teal-100 text-[10px] font-bold tracking-widest uppercase">AVERAGE SAVINGS ANNUALLY</p>
                </div>
            </div>
        </div>
        <!-- Decorative Background Element -->
        <div class="absolute top-0 right-0 w-1/3 h-full bg-secondary opacity-5 -skew-x-12 translate-x-1/2"></div>
    </section>

    <!-- Personal Referral Link Section -->
    <section id="referral-link-section" class="py-16 bg-white">
        <div class="max-w-3xl mx-auto px-8">
            <div class="bg-slate-50 border border-slate-200 p-8 md:p-12 rounded-xl shadow-sm">
                <h2 class="text-2xl font-bold text-slate-900 mb-4 text-center">Share Your Unique Link</h2>
                <p class="text-slate-500 text-center mb-8">Copy your link or use one of the social share buttons below to start earning.</p>
                <div class="flex flex-col md:flex-row gap-4 mb-8">
                    <div class="flex-grow flex items-center bg-white border border-slate-200 rounded-lg px-4 py-3 focus-within:ring-2 focus-within:ring-secondary/20 focus-within:border-secondary transition-all">
                        <span class="text-slate-600 text-sm font-medium select-all">rentease.com/signup?ref=<?= htmlspecialchars((string)($stats['referral_code'] ?? '')) ?></span>
                    </div>
                    <button onclick="navigator.clipboard.writeText('rentease.com/signup?ref=<?= htmlspecialchars((string)($stats['referral_code'] ?? '')) ?>')" class="bg-primary text-white px-8 py-3 rounded-lg font-bold hover:bg-slate-800 transition-all flex items-center justify-center gap-2 whitespace-nowrap">
                        <span class="material-symbols-outlined text-sm">content_copy</span>
                        Copy Link
                    </button>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <button class="flex flex-col items-center justify-center gap-2 p-6 border border-slate-200 rounded-lg hover:border-secondary hover:bg-secondary/5 transition-all text-slate-500 hover:text-secondary group">
                        <span class="material-symbols-outlined text-2xl">chat</span>
                        <span class="text-[10px] font-bold tracking-widest uppercase">WhatsApp</span>
                    </button>
                    <button class="flex flex-col items-center justify-center gap-2 p-6 border border-slate-200 rounded-lg hover:border-secondary hover:bg-secondary/5 transition-all text-slate-500 hover:text-secondary group">
                        <span class="material-symbols-outlined text-2xl">mail</span>
                        <span class="text-[10px] font-bold tracking-widest uppercase">Email</span>
                    </button>
                    <button class="flex flex-col items-center justify-center gap-2 p-6 border border-slate-200 rounded-lg hover:border-secondary hover:bg-secondary/5 transition-all text-slate-500 hover:text-secondary group">
                        <span class="material-symbols-outlined text-2xl">share</span>
                        <span class="text-[10px] font-bold tracking-widest uppercase">Twitter</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Referral Dashboard -->
    <section class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-8">
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-primary mb-2">Your Referral Dashboard</h2>
                    <p class="text-slate-500 text-lg">Track your rewards and friend status in real-time.</p>
                </div>
                <button class="text-secondary font-bold flex items-center gap-1 hover:underline">
                    View History <span class="material-symbols-outlined">chevron_right</span>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-100 flex flex-col items-center text-center">
                    <div class="w-12 h-12 bg-secondary/10 rounded-full flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-secondary">payments</span>
                    </div>
                    <p class="text-[10px] font-bold tracking-widest text-slate-400 mb-1 uppercase">TOTAL REWARDS EARNED</p>
                    <h3 class="text-4xl font-bold text-primary">$<?= number_format((float)($stats['total_earned'] ?? 0), 2) ?></h3>
                    <p class="text-sm text-secondary font-medium mt-2"><?= $stats['successful_referrals'] ?? 0 ?> Rewards Applied</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-100 flex flex-col items-center text-center">
                    <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-slate-400">group_add</span>
                    </div>
                    <p class="text-[10px] font-bold tracking-widest text-slate-400 mb-1 uppercase">FRIENDS INVITED</p>
                    <h3 class="text-4xl font-bold text-primary"><?= $stats['friends_invited'] ?? 0 ?></h3>
                    <p class="text-sm text-slate-500 mt-2"><?= $stats['pending_invitations'] ?? 0 ?> Invitations Pending</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-100 flex flex-col items-center text-center">
                    <div class="w-12 h-12 bg-teal-50 rounded-full flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-secondary">check_circle</span>
                    </div>
                    <p class="text-[10px] font-bold tracking-widest text-slate-400 mb-1 uppercase">SUCCESSFUL REFERRALS</p>
                    <h3 class="text-4xl font-bold text-primary"><?= $stats['successful_referrals'] ?? 0 ?></h3>
                    <p class="text-sm text-secondary font-medium mt-2">+<?= $stats['recent_referrals'] ?? 0 ?> in the last 30 days</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How it Works -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-8">
            <h2 class="text-3xl font-bold text-primary text-center mb-16">How it Works</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center relative">
                    <div class="w-16 h-16 bg-primary text-white flex items-center justify-center rounded-full mx-auto mb-6 font-bold text-xl relative z-10">1</div>
                    <div class="hidden md:block absolute top-8 left-[60%] w-full h-[2px] bg-slate-100 -z-0"></div>
                    <h4 class="text-xl font-bold mb-4">Invite Friends</h4>
                    <p class="text-slate-500">Share your unique link via WhatsApp, Email, or Social Media with anyone looking to furnish their home.</p>
                </div>
                <div class="text-center relative">
                    <div class="w-16 h-16 bg-primary text-white flex items-center justify-center rounded-full mx-auto mb-6 font-bold text-xl relative z-10">2</div>
                    <div class="hidden md:block absolute top-8 left-[60%] w-full h-[2px] bg-slate-100 -z-0"></div>
                    <h4 class="text-xl font-bold mb-4">They Rent</h4>
                    <p class="text-slate-500">Your friends use your link to get $50 off their first rental subscription of $150 or more.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-secondary text-white flex items-center justify-center rounded-full mx-auto mb-6 font-bold text-xl">3</div>
                    <h4 class="text-xl font-bold mb-4">You Both Get Credit</h4>
                    <p class="text-slate-500">Once their first month is confirmed, we'll automatically apply a $50 credit to your next bill.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-24 bg-slate-50">
        <div class="max-w-4xl mx-auto px-8">
            <h2 class="text-3xl font-bold text-primary text-center mb-16">Common Questions</h2>
            <div class="space-y-4">
                <details class="bg-white p-6 rounded-lg shadow-sm group">
                    <summary class="flex justify-between items-center w-full text-left font-bold text-lg text-primary cursor-pointer list-none">
                        <span>When will I receive my $50 credit?</span>
                        <span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
                    </summary>
                    <div class="mt-4 text-slate-500 border-t pt-4">
                        Credits are issued 14 days after your referred friend completes their first successful rental delivery. You'll receive an email notification as soon as it's applied.
                    </div>
                </details>
                <details class="bg-white p-6 rounded-lg shadow-sm group">
                    <summary class="flex justify-between items-center w-full text-left font-bold text-lg text-primary cursor-pointer list-none">
                        <span>Do my referral credits expire?</span>
                        <span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
                    </summary>
                    <div class="mt-4 text-slate-500 border-t pt-4">
                        No, your referral credits do not expire! They will stay in your account until you use them for a rental payment.
                    </div>
                </details>
                <details class="bg-white p-6 rounded-lg shadow-sm group">
                    <summary class="flex justify-between items-center w-full text-left font-bold text-lg text-primary cursor-pointer list-none">
                        <span>Is there a limit to how many people I can invite?</span>
                        <span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
                    </summary>
                    <div class="mt-4 text-slate-500 border-t pt-4">
                        There is no limit! You can invite as many friends as you want and keep earning credits for every successful referral.
                    </div>
                </details>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/partials/footer.php'; ?>
