<?php
/**
 * Maintenance Tracker
 * 
 * Displays active and past maintenance requests with a visual timeline.
 */

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../src/Support/Csrf.php';

use RentEase\Services\AuthService;
use RentEase\Services\MaintenanceService;
use RentEase\Support\Csrf;

$authService = new AuthService($config);
$maintenanceService = new MaintenanceService($config);

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
        }
    }
} catch (Throwable $ignored) {}

if (!$currentUser) {
    header('Location: login.php');
    exit;
}

$error = null;
$success = null;

// Fetch maintenance requests
$requests = [];
try {
    $requests = $maintenanceService->getUserRequests($currentUser['id'], $token);
} catch (Throwable $e) {
    $error = "Failed to load maintenance requests.";
}

// Separate active and past requests
$activeRequests = array_filter($requests, fn($r) => $r['status'] !== 'RESOLVED');
$pastRequests = array_filter($requests, fn($r) => $r['status'] === 'RESOLVED');

$pageTitle = 'Maintenance Tracker - RentEase';
require_once __DIR__ . '/partials/header.php';
?>

<main class="flex-grow max-w-7xl mx-auto w-full px-6 md:px-12 py-12">
    <!-- Feedback Messages -->
    <?php if ($error): ?>
        <div class="mb-8 bg-red-50 border border-red-100 text-red-600 p-4 rounded-xl flex items-center gap-3 reveal-element">
            <span class="material-symbols-outlined">error</span>
            <p><?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif; ?>

    <!-- Summary Header -->
    <section class="mb-12 reveal-element">
        <h1 class="text-4xl font-bold text-primary mb-8 tracking-tight">Maintenance Tracker</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-primary text-white p-8 rounded-2xl shadow-lg flex items-center space-x-6">
                <div class="bg-white/10 p-3 rounded-xl backdrop-blur-sm">
                    <span class="material-symbols-outlined text-white text-3xl">pending_actions</span>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-teal-400 uppercase tracking-widest mb-1">ACTIVE REQUESTS</p>
                    <p class="text-2xl font-bold"><?= count($activeRequests) ?> Active</p>
                </div>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-6">
                <div class="bg-slate-50 p-3 rounded-xl">
                    <span class="material-symbols-outlined text-primary text-3xl">event_available</span>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">NEXT VISIT</p>
                    <p class="text-2xl font-bold text-primary">Pending Schedule</p>
                </div>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-6">
                <div class="bg-slate-50 p-3 rounded-xl text-teal-600">
                    <span class="material-symbols-outlined text-3xl">history</span>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">RESOLVED TOTAL</p>
                    <p class="text-2xl font-bold text-primary"><?= count($pastRequests) ?> Tickets</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Tickets Section -->
        <section class="lg:col-span-8 space-y-6">
            <div class="flex items-center justify-between mb-4 reveal-element">
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Current Tickets</h2>
                <a href="help-center.php" class="flex items-center space-x-2 text-teal-600 font-bold hover:underline transition-all">
                    <span class="material-symbols-outlined text-xl">add_circle</span>
                    <span>New Request</span>
                </a>
            </div>

            <?php if (empty($activeRequests)): ?>
                <div class="bg-white rounded-3xl p-16 border-2 border-dashed border-slate-100 text-center reveal-element">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="material-symbols-outlined text-4xl text-slate-200">inventory_2</span>
                    </div>
                    <p class="text-slate-500 font-medium text-lg">No active maintenance requests.</p>
                </div>
            <?php else: ?>
                <?php foreach ($activeRequests as $req): 
                    $product = $req['rentals']['products'] ?? null;
                    $status = $req['status'];
                    $progress = $status === 'IN_PROGRESS' ? 'w-2/3' : 'w-1/3';
                ?>
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden reveal-element">
                        <div class="p-8">
                            <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 mb-8">
                                <div class="flex items-center space-x-6">
                                    <div class="w-24 h-24 rounded-2xl overflow-hidden bg-slate-50 shrink-0 shadow-sm">
                                        <img class="w-full h-full object-cover" src="<?= htmlspecialchars((string)($product['image_url'] ?? 'https://via.placeholder.com/100')) ?>" alt="Product"/>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-slate-900"><?= htmlspecialchars((string)($product['name'] ?? 'Furniture Item')) ?></h3>
                                        <div class="flex items-center gap-2 mt-2">
                                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">REQ #<?= htmlspecialchars((string)$req['id']) ?></span>
                                            <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Opened <?= date('M d, Y', strtotime($req['created_at'])) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-orange-50 text-orange-600 px-6 py-2.5 rounded-full font-bold text-sm flex items-center space-x-2 shrink-0 border border-orange-100">
                                    <span class="material-symbols-outlined text-[20px]">engineering</span>
                                    <span><?= htmlspecialchars($status === 'OPEN' ? 'Reviewing' : 'Technician En Route') ?></span>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-10 px-2">
                                <div class="flex justify-between mb-4">
                                    <span class="text-[10px] font-bold text-teal-600 uppercase tracking-widest">SUBMITTED</span>
                                    <span class="text-[10px] font-bold <?= $status === 'IN_PROGRESS' ? 'text-teal-600' : 'text-slate-300' ?> uppercase tracking-widest">SCHEDULED</span>
                                    <span class="text-[10px] font-bold <?= $status === 'IN_PROGRESS' ? 'text-teal-600' : 'text-slate-300' ?> uppercase tracking-widest">EN ROUTE</span>
                                    <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">RESOLVED</span>
                                </div>
                                <div class="relative h-2 w-full bg-slate-50 rounded-full border border-slate-100">
                                    <div class="absolute left-0 top-0 h-full <?= $progress ?> bg-teal-500 rounded-full transition-all duration-1000"></div>
                                    <div class="absolute left-0 top-1/2 -translate-y-1/2 flex justify-between w-full">
                                        <div class="w-4 h-4 rounded-full bg-teal-500 border-4 border-white shadow-sm"></div>
                                        <div class="w-4 h-4 rounded-full <?= $status === 'IN_PROGRESS' ? 'bg-teal-500' : 'bg-white' ?> border-4 <?= $status === 'IN_PROGRESS' ? 'border-white' : 'border-slate-100' ?> shadow-sm"></div>
                                        <div class="w-4 h-4 rounded-full <?= $status === 'IN_PROGRESS' ? 'bg-teal-500' : 'bg-white' ?> border-4 <?= $status === 'IN_PROGRESS' ? 'border-white' : 'border-slate-100' ?> shadow-sm"></div>
                                        <div class="w-4 h-4 rounded-full bg-white border-4 border-slate-100 shadow-sm"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Technician Window -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 bg-slate-50 rounded-2xl border border-slate-100">
                                <div class="flex items-center space-x-4">
                                    <div class="w-14 h-14 rounded-full overflow-hidden bg-slate-200 border-2 border-white shadow-sm">
                                        <img class="w-full h-full object-cover" src="https://i.pravatar.cc/150?u=marcus" alt="Technician"/>
                                    </div>
                                    <div class="flex-grow">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">TECHNICIAN</p>
                                        <p class="text-base font-bold text-slate-900">Marcus Jensen</p>
                                        <button class="text-teal-600 text-xs font-bold hover:underline mt-1 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">chat</span> Message
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">SCHEDULED WINDOW</p>
                                    <p class="text-base font-bold text-slate-900">Pending Scheduling</p>
                                    <p class="text-xs text-slate-500 mt-1 italic">We'll notify you when a slot is assigned.</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50/50 px-8 py-5 flex items-center justify-end gap-4 border-t border-slate-50">
                            <button class="px-6 py-2.5 border-2 border-slate-100 text-slate-600 font-bold text-sm rounded-xl hover:bg-white transition-all">Reschedule</button>
                            <button class="px-6 py-2.5 bg-primary text-white font-bold text-sm rounded-xl hover:opacity-90 transition-all shadow-md shadow-primary/10">View Details</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

        <!-- Sidebar: Past Requests -->
        <aside class="lg:col-span-4 space-y-8">
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight reveal-element">Past Requests</h2>
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 space-y-6 reveal-element max-h-[600px] overflow-y-auto custom-scrollbar">
                <?php if (empty($pastRequests)): ?>
                    <p class="text-slate-400 text-center italic py-8">No past service history.</p>
                <?php else: ?>
                    <?php foreach ($pastRequests as $req): 
                        $product = $req['rentals']['products'] ?? null;
                    ?>
                        <div class="group p-4 hover:bg-slate-50 rounded-2xl transition-all border-b border-slate-50 last:border-0 pb-6">
                            <div class="flex justify-between items-start mb-4">
                                <span class="bg-teal-50 text-teal-600 font-bold text-[10px] px-3 py-1 rounded-full border border-teal-100">RESOLVED</span>
                                <span class="text-xs font-bold text-slate-300"><?= date('M d', strtotime($req['created_at'])) ?></span>
                            </div>
                            <h4 class="text-lg font-bold text-slate-900 mb-1"><?= htmlspecialchars((string)($product['name'] ?? 'Furniture Item')) ?></h4>
                            <p class="text-sm text-slate-500 line-clamp-2 italic">"<?= htmlspecialchars($req['issue_description']) ?>"</p>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-300">#<?= htmlspecialchars((string)$req['id']) ?></span>
                                <button class="text-teal-600 font-bold text-xs hover:underline">View History</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <button class="w-full py-4 text-center text-sm text-slate-400 font-bold hover:text-primary transition-all border-t border-slate-50">
                    View All History
                </button>
            </div>

            <!-- Support Card -->
            <div class="bg-primary text-white rounded-3xl p-8 shadow-xl reveal-element">
                <h3 class="text-2xl font-bold mb-3 tracking-tight">Need Help?</h3>
                <p class="text-teal-100/80 text-sm leading-relaxed mb-8">Our 24/7 concierge is available for emergency maintenance or general inquiries.</p>
                <button class="w-full bg-white text-primary py-4 rounded-xl font-bold hover:scale-[1.02] active:scale-95 transition-all shadow-lg">
                    Contact Support
                </button>
            </div>
        </aside>
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
