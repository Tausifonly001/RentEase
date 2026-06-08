<?php
declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../src/Support/Csrf.php';

use RentEase\Services\AuthService;
use RentEase\Services\RentalService;
use RentEase\Services\MaintenanceService;
use RentEase\Support\Csrf;

$authService = new AuthService($config);
$rentalService = new RentalService($config);
$maintenanceService = new MaintenanceService($config);

$error = null;
$success = null;

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

$currentUser = null;
$token = '';
try {
    $token = $_COOKIE[$config['cookie_name'] ?? ''] ?? '';
    if ($token) {
        $userData = $authService->validateToken($token);
        if ($userData) {
            $currentUser = $userData;
            $currentUser['name'] = $userData['user_metadata']['full_name']
                ?? $userData['name']
                ?? explode('@', $userData['email'])[0]
                ?? 'User';
        }
    }
} catch (Throwable $ignored) {}

if (!$currentUser) {
    header('Location: ' . baseUrl('/login'));
    exit;
}

$rentals = [];
try { $rentals = $rentalService->getUserRentals($currentUser['id']); } catch (Throwable $e) { $error = 'Failed to load user rentals.'; }

$maintenanceRequests = [];
try { $maintenanceRequests = $maintenanceService->getUserRequests($currentUser['id'], $token); } catch (Throwable $e) {}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if (!Csrf::validate((string)($_POST['csrf_token'] ?? ''))) {
        $error = "Security validation failed.";
    } else {
        $action = $_POST['action'];
        $rentalId = filter_input(INPUT_POST, 'rental_id', FILTER_VALIDATE_INT);
        if ($action === 'extend_lease' && $rentalId) {
            $extraDays = filter_input(INPUT_POST, 'extra_days', FILTER_VALIDATE_INT);
            try {
                $rentalService->extendLease($rentalId, $currentUser['id'], (int)$extraDays, $token);
                $success = "Lease extended successfully!";
                $rentals = $rentalService->getUserRentals($currentUser['id']);
            } catch (Throwable $e) { $error = 'Extension failed: ' . $e->getMessage(); }
        }
    }
}

$pageTitle = 'My Dashboard - RentEase';
require_once __DIR__ . '/partials/header.php';
?>

<main class="flex-grow w-full max-w-[1600px] mx-auto px-6 lg:px-12 py-28 lg:py-32">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 reveal-fade">
        <div>
            <h1 class="text-3xl md:text-4xl font-serif font-medium text-ink tracking-tight">Welcome back, <?= htmlspecialchars((string)$currentUser['name']) ?></h1>
            <p class="text-muted text-base font-light mt-2">Manage your current rentals and account settings.</p>
        </div>
        <?php if (AuthService::resolveRole($currentUser) === 'admin'): ?>
            <a href="<?= baseUrl('/admin') ?>" class="btn-secondary mt-4 md:mt-0">
                <span class="material-symbols-outlined text-base">admin_panel_settings</span>
                Admin Console
            </a>
        <?php endif; ?>
    </div>

    <?php if ($error): ?>
        <div class="mb-10 p-4 border border-rose/20 text-rose bg-rose/5 flex items-center gap-3 text-sm font-light">
            <span class="material-symbols-outlined">error</span>
            <p><?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="mb-10 p-4 border border-champagne/20 text-champagne-dark bg-champagne/5 flex items-center gap-3 text-sm font-light">
            <span class="material-symbols-outlined">check_circle</span>
            <p><?= htmlspecialchars($success) ?></p>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Left: Rentals + Quick Actions -->
        <div class="lg:col-span-8 flex flex-col gap-10">

            <!-- Active Rentals -->
            <section class="reveal-fade">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-serif font-medium text-ink tracking-tight">Active Rentals</h2>
                    <a href="<?= baseUrl('/shop') ?>" class="text-[11px] font-medium tracking-[0.2em] uppercase text-muted hover:text-ink transition-colors">Explore More</a>
                </div>

                <?php if (empty($rentals)): ?>
                    <div class="p-16 text-center border border-dashed" style="border-color: rgba(231,229,228,0.6); background: rgba(250,250,249,0.5);">
                        <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-champagne/5 text-muted-light">
                            <span class="material-symbols-outlined text-3xl">inventory_2</span>
                        </div>
                        <p class="text-muted font-light mb-8">You don't have any active rentals yet.</p>
                        <a href="<?= baseUrl('/shop') ?>" class="btn-primary inline-flex">Start Your First Rental</a>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach ($rentals as $rental): ?>
                        <div class="group bg-surface border p-5 transition-all hover:-translate-y-0.5" style="border-color: rgba(231,229,228,0.6);">
                            <div class="aspect-[4/3] w-full overflow-hidden bg-surface mb-5 relative">
                                <img alt="<?= htmlspecialchars($rental['products']['name'] ?? 'Item') ?>" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-700" src="<?= htmlspecialchars($rental['products']['image_url'] ?? 'https://via.placeholder.com/400x300') ?>" loading="lazy"/>
                                <div class="absolute top-3 right-3 bg-ink/80 text-white text-[10px] font-medium px-3 py-1.5 uppercase tracking-widest flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;"><?= $rental['status'] === 'active' ? 'local_shipping' : 'schedule' ?></span>
                                    <?= htmlspecialchars(str_replace('_', ' ', (string)$rental['status'])) ?>
                                </div>
                            </div>
                            <h3 class="text-lg font-serif font-medium text-ink mb-1"><?= htmlspecialchars($rental['products']['name'] ?? 'Asset #'.$rental['id']) ?></h3>
                            <p class="text-xs text-muted mb-6 font-light">Ends: <?= date('M j, Y', strtotime((string)$rental['end_date'])) ?></p>

                            <div class="flex justify-between items-center pt-4" style="border-top: 1px solid rgba(231,229,228,0.6);">
                                <span class="text-xl font-serif text-ink">$<?= number_format((float)($rental['products']['monthly_price'] ?? 0), 0) ?><span class="text-xs font-light text-muted">/mo</span></span>
                                <div class="flex gap-2">
                                    <?php if ($rental['status'] === 'active'): ?>
                                        <a href="<?= baseUrl('/return-pickup?id=' . $rental['id']) ?>" class="px-4 py-2 bg-ink text-white text-[10px] font-medium tracking-widest uppercase hover:bg-champagne hover:text-ink transition-all duration-500">Return</a>
                                    <?php elseif ($rental['status'] === 'scheduled'): ?>
                                        <a href="<?= baseUrl('/reschedule?id=' . $rental['id']) ?>" class="px-4 py-2 border text-[10px] font-medium tracking-widest uppercase hover:border-champagne hover:text-champagne transition-all duration-500" style="border-color: rgba(231,229,228,0.6);">Reschedule</a>
                                        <a href="<?= baseUrl('/tracking?id=' . $rental['id']) ?>" class="px-4 py-2 bg-champagne/10 text-champagne-dark text-[10px] font-medium tracking-widest uppercase hover:bg-champagne/20 transition-colors">Track</a>
                                    <?php endif; ?>
                                    <button onclick="document.getElementById('extend-<?= $rental['id'] ?>').classList.toggle('hidden')" class="px-4 py-2 border text-[10px] font-medium tracking-widest uppercase hover:border-champagne hover:text-champagne transition-all duration-500" style="border-color: rgba(231,229,228,0.6);">Extend</button>
                                </div>
                            </div>

                            <div id="extend-<?= $rental['id'] ?>" class="hidden mt-4 p-5 bg-canvas border" style="border-color: rgba(231,229,228,0.6);">
                                <form action="<?= baseUrl('/dashboard') ?>" method="POST" class="flex flex-col gap-3">
                                    <input type="hidden" name="csrf_token" value="<?= Csrf::token() ?>">
                                    <input type="hidden" name="action" value="extend_lease">
                                    <input type="hidden" name="rental_id" value="<?= $rental['id'] ?>">
                                    <p class="text-[10px] uppercase tracking-widest text-muted font-medium">Select Term</p>
                                    <div class="flex gap-2">
                                        <select name="extra_days" class="flex-grow bg-transparent border-b py-2 text-sm outline-none focus:border-champagne font-light" style="border-color: rgba(231,229,228,0.6);">
                                            <option value="90">3 Months</option>
                                            <option value="180">6 Months</option>
                                            <option value="365">12 Months</option>
                                        </select>
                                        <button type="submit" class="px-5 py-2 bg-ink text-white text-[10px] font-medium tracking-widest uppercase hover:bg-champagne hover:text-ink transition-all duration-500">Confirm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Quick Actions -->
            <section class="reveal-fade">
                <h2 class="text-2xl font-serif font-medium text-ink mb-8 tracking-tight">Quick Actions</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="<?= baseUrl('/request-maintenance') ?>" class="p-8 bg-surface border flex flex-col items-center justify-center text-center gap-4 hover:border-champagne/30 transition-all group" style="border-color: rgba(231,229,228,0.6);">
                        <div class="w-12 h-12 flex items-center justify-center bg-champagne/5 text-champagne-dark group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">build</span>
                        </div>
                        <span class="text-sm text-ink font-light">Request Repair</span>
                    </a>
                    <a href="<?= baseUrl('/shop') ?>" class="p-8 bg-surface border flex flex-col items-center justify-center text-center gap-4 hover:border-champagne/30 transition-all group" style="border-color: rgba(231,229,228,0.6);">
                        <div class="w-12 h-12 flex items-center justify-center bg-champagne/5 text-champagne-dark group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">add_circle</span>
                        </div>
                        <span class="text-sm text-ink font-light">Rent New</span>
                    </a>
                    <a href="<?= baseUrl('/wishlist') ?>" class="p-8 bg-surface border flex flex-col items-center justify-center text-center gap-4 hover:border-champagne/30 transition-all group" style="border-color: rgba(231,229,228,0.6);">
                        <div class="w-12 h-12 flex items-center justify-center bg-champagne/5 text-champagne-dark group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">favorite</span>
                        </div>
                        <span class="text-sm text-ink font-light">Wishlist</span>
                    </a>
                    <a href="<?= baseUrl('/support') ?>" class="p-8 bg-surface border flex flex-col items-center justify-center text-center gap-4 hover:border-champagne/30 transition-all group" style="border-color: rgba(231,229,228,0.6);">
                        <div class="w-12 h-12 flex items-center justify-center bg-champagne/5 text-champagne-dark group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">rate_review</span>
                        </div>
                        <span class="text-sm text-ink font-light">Get Support</span>
                    </a>
                </div>
            </section>
        </div>

        <!-- Right: Profile + Tickets -->
        <div class="lg:col-span-4 flex flex-col gap-10">
            <!-- Profile -->
            <section class="bg-surface border p-8 reveal-fade" style="border-color: rgba(231,229,228,0.6);">
                <div class="flex flex-col items-center text-center gap-5 mb-8">
                    <div class="w-20 h-20 bg-ink text-white flex items-center justify-center text-2xl font-serif italic">
                        <?= substr((string)$currentUser['name'], 0, 1) ?>
                    </div>
                    <div>
                        <h3 class="text-xl font-serif font-medium text-ink"><?= htmlspecialchars((string)$currentUser['name']) ?></h3>
                        <p class="text-sm text-muted font-light"><?= htmlspecialchars((string)$currentUser['email']) ?></p>
                    </div>
                </div>
                <nav class="space-y-1">
                    <a href="<?= baseUrl('/settings') ?>" class="flex items-center justify-between p-3 hover:bg-canvas transition-colors group">
                        <div class="flex items-center gap-3 text-muted group-hover:text-ink transition-colors">
                            <span class="material-symbols-outlined text-xl">manage_accounts</span>
                            <span class="text-sm font-light">Account Settings</span>
                        </div>
                        <span class="material-symbols-outlined text-muted-light group-hover:text-ink">chevron_right</span>
                    </a>
                    <a href="<?= baseUrl('/payment-methods') ?>" class="flex items-center justify-between p-3 hover:bg-canvas transition-colors group">
                        <div class="flex items-center gap-3 text-muted group-hover:text-ink transition-colors">
                            <span class="material-symbols-outlined text-xl">credit_card</span>
                            <span class="text-sm font-light">Payment Methods</span>
                        </div>
                        <span class="material-symbols-outlined text-muted-light group-hover:text-ink">chevron_right</span>
                    </a>
                    <a href="<?= baseUrl('/orders') ?>" class="flex items-center justify-between p-3 hover:bg-canvas transition-colors group">
                        <div class="flex items-center gap-3 text-muted group-hover:text-ink transition-colors">
                            <span class="material-symbols-outlined text-xl">receipt_long</span>
                            <span class="text-sm font-light">Order History</span>
                        </div>
                        <span class="material-symbols-outlined text-muted-light group-hover:text-ink">chevron_right</span>
                    </a>
                    <div class="pt-4 mt-4" style="border-top: 1px solid rgba(231,229,228,0.6);">
                        <a href="<?= baseUrl('/logout') ?>" class="flex items-center gap-3 p-3 hover:bg-rose/5 text-rose transition-colors">
                            <span class="material-symbols-outlined text-xl">logout</span>
                            <span class="text-sm font-light">Sign Out</span>
                        </a>
                    </div>
                </nav>
            </section>

            <!-- Maintenance -->
            <section class="reveal-fade">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-serif font-medium text-ink tracking-tight">Maintenance</h2>
                    <a href="<?= baseUrl('/request-maintenance') ?>" class="text-[11px] font-medium tracking-[0.2em] uppercase text-muted hover:text-ink transition-colors">New Request</a>
                </div>
                <div class="bg-surface border overflow-hidden" style="border-color: rgba(231,229,228,0.6);">
                    <?php if (empty($maintenanceRequests)): ?>
                        <div class="p-8 text-center">
                            <p class="text-sm text-muted font-light italic">No active service tickets.</p>
                        </div>
                    <?php else: ?>
                        <div class="divide-y" style="border-color: rgba(231,229,228,0.6);">
                            <?php foreach (array_slice($maintenanceRequests, 0, 3) as $req): ?>
                            <div class="p-4 hover:bg-canvas transition-colors flex items-start gap-4">
                                <div class="w-8 h-8 flex items-center justify-center shrink-0 <?= $req['status'] === 'RESOLVED' ? 'bg-champagne/10 text-champagne-dark' : 'bg-rose/10 text-rose' ?>">
                                    <span class="material-symbols-outlined text-sm font-light"><?= $req['status'] === 'RESOLVED' ? 'check_circle' : 'pending' ?></span>
                                </div>
                                <div class="flex-grow">
                                    <p class="text-sm text-ink font-light line-clamp-1"><?= htmlspecialchars($req['issue_description']) ?></p>
                                    <p class="text-[10px] text-muted-light mt-1 uppercase tracking-widest font-medium"><?= date('M j', strtotime($req['created_at'])) ?> &bull; <?= htmlspecialchars($req['status']) ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <a href="<?= baseUrl('/support') ?>" class="block w-full py-4 bg-canvas text-muted text-sm font-light text-center hover:bg-champagne/5 transition-colors" style="border-top: 1px solid rgba(231,229,228,0.6);">Create New Ticket</a>
                </div>
            </section>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const checkGsap = setInterval(() => {
        if (window.gsap) {
            clearInterval(checkGsap);
            gsap.context(() => {
                gsap.utils.toArray('.reveal-fade').forEach((el, i) => {
                    gsap.from(el, {
                        opacity: 0,
                        y: 20,
                        duration: 0.8,
                        delay: i * 0.1,
                        ease: 'power3.out'
                    });
                });
            });
        }
    }, 100);
});
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
