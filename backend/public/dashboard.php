<?php
/**
 * User Dashboard
 * 
 * Refined production dashboard with premium prototype layout and dynamic data.
 */

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

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

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

// Fetch dynamic data
$rentals = [];
try {
    $rentals = $rentalService->getUserRentals($currentUser['id']);
} catch (Throwable $e) {
    $error = 'Failed to load user rentals.';
}

$maintenanceRequests = [];
try {
    $maintenanceRequests = $maintenanceService->getUserRequests($currentUser['id'], $token);
} catch (Throwable $e) {}

// Handle actions
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
            } catch (Throwable $e) {
                $error = 'Extension failed: ' . $e->getMessage();
            }
        }
    }
}

$pageTitle = 'My Dashboard - RentEase';
require_once __DIR__ . '/partials/header.php';
?>

<!-- Main Content Canvas -->
<main class="flex-grow w-full max-w-7xl mx-auto px-4 md:px-8 py-10">
    <div class="mb-10 reveal-element">
        <h1 class="text-4xl font-normal text-primary tracking-tight">Welcome Back, <?= htmlspecialchars((string)$currentUser['name']) ?></h1>
        <p class="text-lg text-slate-500 mt-2">Manage your current rentals and account settings.</p>
    </div>

    <?php if ($error): ?>
        <div class="mb-8 bg-red-50 border border-red-100 text-red-600 p-4 rounded-xl flex items-center gap-3">
            <span class="material-symbols-outlined">error</span>
            <p><?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="mb-8 bg-teal-50 border border-teal-100 text-teal-700 p-4 rounded-xl flex items-center gap-3">
            <span class="material-symbols-outlined">check_circle</span>
            <p><?= htmlspecialchars($success) ?></p>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Column: Active Rentals & Quick Actions -->
        <div class="lg:col-span-8 flex flex-col gap-10">
            <!-- Active Rentals Section -->
            <section class="reveal-element">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-normal text-slate-900 tracking-tight">Active Rentals</h2>
                    <a class="text-teal-600 font-normal hover:underline underline-offset-4" href="<?= baseUrl('/shop') ?>">Explore More</a>
                </div>

                <?php if (empty($rentals)): ?>
                    <div class="bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 p-12 text-center">
                        <div class="w-16 h-16 bg-white rounded-full shadow-sm flex items-center justify-center mx-auto mb-4 text-slate-400">
                            <span class="material-symbols-outlined text-3xl">inventory_2</span>
                        </div>
                        <p class="text-slate-500 font-normal mb-6">You don't have any active rentals yet.</p>
                        <a href="<?= baseUrl('/shop') ?>" class="bg-primary text-white px-8 py-3 rounded-lg font-normal hover:opacity-90 transition-all inline-block">Start Your First Rental</a>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach ($rentals as $rental): ?>
                            <div class="group bg-white rounded-2xl border border-slate-100 p-4 shadow-sm hover:shadow-md transition-all">
                                <div class="aspect-[4/3] w-full rounded-xl overflow-hidden bg-slate-100 mb-4 relative">
                                    <img alt="<?= htmlspecialchars($rental['products']['name'] ?? 'Item') ?>" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" src="<?= htmlspecialchars($rental['products']['image_url'] ?? 'https://via.placeholder.com/400x300') ?>"/>
                                    <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-primary text-[10px] font-normal px-3 py-1 rounded-full uppercase tracking-widest flex items-center gap-1.5 shadow-sm">
                                        <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;"><?= $rental['status'] === 'active' ? 'local_shipping' : 'schedule' ?></span>
                                        <?= htmlspecialchars(str_replace('_', ' ', (string)$rental['status'])) ?>
                                    </div>
                                </div>
                                <h3 class="text-lg font-normal text-slate-900 mb-1"><?= htmlspecialchars($rental['products']['name'] ?? 'Asset #'.$rental['id']) ?></h3>
                                <p class="text-xs text-slate-500 mb-6 font-light">Ends: <?= date('M j, Y', strtotime((string)$rental['end_date'])) ?></p>
                                
                                <div class="flex justify-between items-center pt-4 border-t border-slate-50">
                                    <span class="text-xl font-normal text-primary">$<?= number_format((float)($rental['products']['monthly_price'] ?? 0), 0) ?><span class="text-xs font-light text-slate-400">/mo</span></span>
                                    <div class="flex gap-2">
                                        <?php if ($rental['status'] === 'active'): ?>
                                            <a href="<?= baseUrl('/return-pickup?id=' . $rental['id']) ?>" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-light hover:opacity-90 transition-all">Return</a>
                                        <?php elseif ($rental['status'] === 'scheduled'): ?>
                                            <a href="<?= baseUrl('/reschedule?id=' . $rental['id']) ?>" class="bg-secondary text-white px-4 py-2 rounded-lg text-sm font-light hover:opacity-90 transition-all">Reschedule</a>
                                            <a href="<?= baseUrl('/tracking?id=' . $rental['id']) ?>" class="bg-teal-50 text-teal-700 px-4 py-2 rounded-lg text-sm font-light hover:bg-teal-100 transition-colors">Track</a>
                                        <?php endif; ?>
                                        <button onclick="document.getElementById('extend-<?= $rental['id'] ?>').classList.toggle('hidden')" class="bg-slate-50 text-slate-600 px-4 py-2 rounded-lg text-sm font-light hover:bg-slate-100 transition-colors">Extend</button>
                                    </div>
                                </div>

                                <!-- Extension Inline Form -->
                                <div id="extend-<?= $rental['id'] ?>" class="hidden mt-4 bg-slate-50 p-4 rounded-xl border border-slate-100">
                                    <form action="<?= baseUrl('/dashboard') ?>" method="POST" class="flex flex-col gap-3">
                                        <input type="hidden" name="csrf_token" value="<?= Csrf::token() ?>">
                                        <input type="hidden" name="action" value="extend_lease">
                                        <input type="hidden" name="rental_id" value="<?= $rental['id'] ?>">
                                        <p class="text-[10px] font-normal uppercase tracking-widest text-slate-400">Select Term</p>
                                        <div class="flex gap-2">
                                            <select name="extra_days" class="flex-grow bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none font-light">
                                                <option value="90">3 Months</option>
                                                <option value="180">6 Months</option>
                                                <option value="365">12 Months</option>
                                            </select>
                                            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg font-light text-sm hover:opacity-90">Confirm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Quick Actions Bento -->
            <section class="reveal-element">
                <h2 class="text-2xl font-normal text-slate-900 mb-6 tracking-tight">Quick Actions</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="<?= baseUrl('/request-maintenance') ?>" class="bg-slate-50 border border-slate-100 rounded-2xl p-6 flex flex-col items-center justify-center text-center gap-4 hover:bg-teal-50 hover:border-teal-100 transition-all group">
                        <div class="w-12 h-12 rounded-full bg-white shadow-sm text-teal-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">build</span>
                        </div>
                        <span class="text-sm font-light text-slate-900">Request Repair</span>
                    </a>
                    <a href="<?= baseUrl('/shop') ?>" class="bg-slate-50 border border-slate-100 rounded-2xl p-6 flex flex-col items-center justify-center text-center gap-4 hover:bg-teal-50 hover:border-teal-100 transition-all group">
                        <div class="w-12 h-12 rounded-full bg-white shadow-sm text-teal-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">add_circle</span>
                        </div>
                        <span class="text-sm font-light text-slate-900">Rent New</span>
                    </a>
                    <a href="<?= baseUrl('/wishlist') ?>" class="bg-slate-50 border border-slate-100 rounded-2xl p-6 flex flex-col items-center justify-center text-center gap-4 hover:bg-teal-50 hover:border-teal-100 transition-all group">
                        <div class="w-12 h-12 rounded-full bg-white shadow-sm text-teal-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">favorite</span>
                        </div>
                        <span class="text-sm font-light text-slate-900">Wishlist</span>
                    </a>
                    <a href="<?= baseUrl('/feedback') ?>" class="bg-slate-50 border border-slate-100 rounded-2xl p-6 flex flex-col items-center justify-center text-center gap-4 hover:bg-teal-50 hover:border-teal-100 transition-all group">
                        <div class="w-12 h-12 rounded-full bg-white shadow-sm text-teal-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">rate_review</span>
                        </div>
                        <span class="text-sm font-light text-slate-900">Give Feedback</span>
                    </a>
                    <?php if (AuthService::resolveRole($currentUser) === 'admin'): ?>
                    <a href="<?= baseUrl('/admin') ?>" class="bg-slate-900 border border-slate-800 rounded-2xl p-6 flex flex-col items-center justify-center text-center gap-4 hover:bg-teal-600 transition-all group shadow-lg">
                        <div class="w-12 h-12 rounded-full bg-white shadow-sm text-slate-900 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">admin_panel_settings</span>
                        </div>
                        <span class="text-sm font-light text-white">Admin Console</span>
                    </a>
                    <?php endif; ?>
                </div>
            </section>
        </div>

        <!-- Right Column: Profile & Tickets -->
        <div class="lg:col-span-4 flex flex-col gap-10">
            <!-- Profile Snapshot -->
            <section class="bg-white rounded-2xl border border-slate-100 p-8 shadow-sm reveal-element">
                <div class="flex flex-col items-center text-center gap-4 mb-8">
                    <div class="w-20 h-20 rounded-full bg-slate-100 border-4 border-slate-50 flex items-center justify-center text-2xl font-normal text-primary uppercase">
                        <?= substr((string)$currentUser['name'], 0, 1) ?>
                    </div>
                    <div>
                        <h3 class="text-xl font-normal text-slate-900"><?= htmlspecialchars((string)$currentUser['name']) ?></h3>
                        <p class="text-sm text-slate-500 font-light"><?= htmlspecialchars((string)$currentUser['email']) ?></p>
                    </div>
                </div>
                <nav class="space-y-1">
                    <a href="<?= baseUrl('/settings') ?>" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition-colors group">
                        <div class="flex items-center gap-3 text-slate-600 group-hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-xl">manage_accounts</span>
                            <span class="text-sm font-light">Account Settings</span>
                        </div>
                        <span class="material-symbols-outlined text-slate-300 group-hover:text-primary">chevron_right</span>
                    </a>
                    <a href="<?= baseUrl('/payments') ?>" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition-colors group">
                        <div class="flex items-center gap-3 text-slate-600 group-hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-xl">credit_card</span>
                            <span class="text-sm font-light">Payment Methods</span>
                        </div>
                        <span class="material-symbols-outlined text-slate-300 group-hover:text-primary">chevron_right</span>
                    </a>
                    <a href="<?= baseUrl('/support') ?>" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition-colors group">
                        <div class="flex items-center gap-3 text-slate-600 group-hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-xl">help</span>
                            <span class="text-sm font-light">Support Center</span>
                        </div>
                        <span class="material-symbols-outlined text-slate-300 group-hover:text-primary">chevron_right</span>
                    </a>
                    <div class="pt-4 mt-4 border-t border-slate-50">
                        <a href="<?= baseUrl('/logout') ?>" class="flex items-center gap-3 p-3 rounded-xl hover:bg-red-50 text-red-500 transition-colors">
                            <span class="material-symbols-outlined text-xl">logout</span>
                            <span class="text-sm font-light">Sign Out</span>
                        </a>
                    </div>
                </nav>
            </section>

            <!-- Recent Tickets -->
            <section class="reveal-element">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-normal text-slate-900 tracking-tight">Maintenance</h2>
                    <a class="text-xs font-light text-teal-600 uppercase tracking-widest hover:underline" href="<?= baseUrl('/maintenance') ?>">View All</a>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
                    <?php if (empty($maintenanceRequests)): ?>
                        <div class="p-8 text-center">
                            <p class="text-sm text-slate-400 italic font-light">No active service tickets.</p>
                        </div>
                    <?php else: ?>
                        <div class="divide-y divide-slate-50">
                            <?php foreach (array_slice($maintenanceRequests, 0, 3) as $req): ?>
                                <div class="p-4 hover:bg-slate-50 transition-colors flex items-start gap-4">
                                    <div class="w-8 h-8 rounded-lg <?= $req['status'] === 'RESOLVED' ? 'bg-teal-50 text-teal-600' : 'bg-orange-50 text-orange-600' ?> flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-sm font-light"><?= $req['status'] === 'RESOLVED' ? 'check_circle' : 'pending' ?></span>
                                    </div>
                                    <div class="flex-grow">
                                        <p class="text-sm font-light text-slate-900 line-clamp-1"><?= htmlspecialchars($req['issue_description']) ?></p>
                                        <p class="text-[10px] text-slate-400 mt-1 uppercase font-normal tracking-widest"><?= date('M j', strtotime($req['created_at'])) ?> • <?= htmlspecialchars($req['status']) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <button onclick="window.location.href='<?= baseUrl('/support') ?>'" class="w-full py-4 bg-slate-50 text-slate-600 text-sm font-light hover:bg-slate-100 transition-colors border-t border-slate-100">
                        Create New Ticket
                    </button>
                </div>
            </section>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    gsap.from('.reveal-element', {
        opacity: 0,
        y: 20,
        duration: 0.8,
        stagger: 0.1,
        ease: 'power3.out'
    });
});
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
