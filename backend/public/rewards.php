<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use RentEase\Services\AuthService;
use RentEase\Services\RewardService;

$authService = new AuthService($config);
$rewardService = new RewardService($config);

// Check authentication
$jwt = $_COOKIE[$config['cookie_name']] ?? '';
$user = $authService->validateToken($jwt);

if (!$user) {
    header('Location: ' . baseUrl('/login'));
    exit;
}

$userId = $user['id'];
$rewards = $rewardService->getUserRewards($userId);
$catalog = $rewardService->getRewardsCatalog();
$history = $rewardService->getRedemptionHistory($userId);

$title = 'Rewards Catalog | RentEase';
include __DIR__ . '/partials/header.php';
?>

<main class="pt-20">
    <!-- Hero: Rewards Balance Section -->
    <section class="bg-primary-container text-white py-12 md:py-16">
        <div class="max-w-7xl mx-auto px-8 flex flex-col md:flex-row justify-between items-center gap-8">
            <div>
                <span class="text-xs font-bold tracking-widest text-secondary-container mb-2 block uppercase">LOYALTY MEMBER</span>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Your Rewards Catalog</h1>
                <p class="text-slate-400 text-lg max-w-lg">Unlock premium experiences and rental benefits with your accumulated points.</p>
            </div>
            <div class="bg-white/10 p-8 rounded-xl border border-white/10 backdrop-blur-sm w-full md:w-auto min-w-[320px]">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <p class="text-slate-400 text-xs font-bold tracking-widest mb-1 uppercase">AVAILABLE BALANCE</p>
                        <h2 class="text-3xl font-bold text-white"><?= number_format((float)($rewards['points_balance'] ?? 0)) ?> <span class="text-lg font-normal opacity-70">pts</span></h2>
                    </div>
                    <div class="bg-secondary text-white px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">workspace_premium</span>
                        <?= htmlspecialchars((string)($rewards['tier'] ?? 'Bronze')) ?> TIER
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-xs text-slate-400">
                        <span>Next Tier: <?= htmlspecialchars((string)($rewards['next_tier'] ?? 'Silver')) ?></span>
                        <span><?= number_format((float)($rewards['points_to_next_tier'] ?? 0)) ?> pts left</span>
                    </div>
                    <div class="w-full bg-white/20 h-2 rounded-full overflow-hidden">
                        <div class="bg-secondary-container h-full" style="width: <?= (int)($rewards['tier_progress'] ?? 0) ?>%"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-8 py-12 md:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Main Content (Left/Center) -->
            <div class="lg:col-span-9">
                <!-- Filters -->
                <div class="flex items-center gap-4 mb-8 overflow-x-auto pb-4 scrollbar-hide">
                    <button class="px-6 py-2 rounded-full bg-primary text-white text-sm font-semibold whitespace-nowrap">All Rewards</button>
                    <button class="px-6 py-2 rounded-full bg-white border border-slate-200 text-slate-700 hover:border-secondary transition-colors text-sm font-semibold whitespace-nowrap">Rental Discounts</button>
                    <button class="px-6 py-2 rounded-full bg-white border border-slate-200 text-slate-700 hover:border-secondary transition-colors text-sm font-semibold whitespace-nowrap">Lifestyle</button>
                    <button class="px-6 py-2 rounded-full bg-white border border-slate-200 text-slate-700 hover:border-secondary transition-colors text-sm font-semibold whitespace-nowrap">Experiences</button>
                </div>

                <!-- Rewards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    <?php foreach ($catalog as $item): ?>
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden group hover:shadow-lg transition-all border border-slate-100 flex flex-col">
                        <div class="h-48 relative overflow-hidden">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                                 src="<?= htmlspecialchars((string)$item['image_url']) ?>" 
                                 alt="<?= htmlspecialchars((string)$item['name']) ?>">
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-[10px] font-bold tracking-widest text-primary shadow-sm uppercase">
                                <?= htmlspecialchars((string)$item['category']) ?>
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-slate-900 mb-2"><?= htmlspecialchars((string)$item['name']) ?></h3>
                            <p class="text-slate-500 text-sm mb-6 flex-grow"><?= htmlspecialchars((string)$item['description']) ?></p>
                            <div class="flex items-center justify-between mt-auto">
                                <div class="text-primary font-bold"><?= number_format((float)$item['points_required']) ?> pts</div>
                                <button class="bg-secondary text-white px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-90 active:scale-95 transition-all">Redeem Now</button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Recently Redeemed -->
                <?php if (!empty($history)): ?>
                <div class="mt-16">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6">Recently Redeemed</h2>
                    <div class="bg-white rounded-xl border border-slate-100 divide-y divide-slate-100">
                        <?php foreach ($history as $entry): ?>
                        <div class="p-6 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded bg-slate-50 flex items-center justify-center text-secondary">
                                    <span class="material-symbols-outlined">
                                        <?= $entry['type'] === 'service' ? 'local_shipping' : 'confirmation_number' ?>
                                    </span>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900"><?= htmlspecialchars((string)$entry['reward_name']) ?></p>
                                    <p class="text-xs text-slate-500">Redeemed on <?= date('M d, Y', strtotime((string)$entry['created_at'])) ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-slate-400">-<?= number_format((float)$entry['points_spent']) ?> pts</p>
                                <span class="text-[10px] bg-slate-100 text-teal-700 px-2 py-0.5 rounded-full font-bold uppercase"><?= htmlspecialchars((string)$entry['status']) ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar (Right) -->
            <aside class="lg:col-span-3 space-y-6">
                <!-- How to Earn Card -->
                <div class="bg-slate-50 text-slate-900 p-6 rounded-xl border border-slate-200">
                    <h3 class="text-lg font-bold mb-4">How to Earn</h3>
                    <div class="space-y-6">
                        <div class="flex gap-3">
                            <div class="bg-secondary/10 p-2 rounded-lg h-fit">
                                <span class="material-symbols-outlined text-secondary">payments</span>
                            </div>
                            <div>
                                <p class="font-semibold text-sm">Rent & Earn</p>
                                <p class="text-xs text-slate-500 mt-1">Get 1 point for every $1 spent on your monthly subscription.</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="bg-secondary/10 p-2 rounded-lg h-fit">
                                <span class="material-symbols-outlined text-secondary">group_add</span>
                            </div>
                            <div>
                                <p class="font-semibold text-sm">Refer a Friend</p>
                                <p class="text-xs text-slate-500 mt-1">Earn 500 bonus points for every friend who starts a rental.</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="bg-secondary/10 p-2 rounded-lg h-fit">
                                <span class="material-symbols-outlined text-secondary">cake</span>
                            </div>
                            <div>
                                <p class="font-semibold text-sm">Anniversary Bonus</p>
                                <p class="text-xs text-slate-500 mt-1">1,000 points on every year you stay with RentEase.</p>
                            </div>
                        </div>
                    </div>
                    <button class="w-full mt-6 py-3 border border-secondary text-secondary rounded-lg text-sm font-semibold hover:bg-secondary/5 transition-colors">Learn More</button>
                </div>

                <!-- Current Perks -->
                <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm">
                    <h3 class="text-lg font-bold mb-4"><?= htmlspecialchars((string)($rewards['tier'] ?? 'Bronze')) ?> Tier Perks</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-2 text-sm text-slate-600">
                            <span class="material-symbols-outlined text-secondary text-lg">check_circle</span>
                            Multiplier on points: <?= $rewards['multiplier'] ?? '1.0' ?>x
                        </li>
                        <li class="flex items-center gap-2 text-sm text-slate-600">
                            <span class="material-symbols-outlined text-secondary text-lg">check_circle</span>
                            Priority customer support
                        </li>
                        <?php if (($rewards['tier'] ?? '') === 'Gold' || ($rewards['tier'] ?? '') === 'Platinum'): ?>
                        <li class="flex items-center gap-2 text-sm text-slate-600">
                            <span class="material-symbols-outlined text-secondary text-lg">check_circle</span>
                            Early access to new arrivals
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</main>

<?php include __DIR__ . '/partials/footer.php'; ?>
