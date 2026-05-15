<?php
declare(strict_types=1);

use RentEase\Services\AuthService;
use RentEase\Support\HttpClient;

require __DIR__ . '/../bootstrap.php';

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

if (!$currentUser) {
    header('Location: ' . baseUrl('/login?redirect=orders'));
    exit;
}

$http = new HttpClient();
$userHeaders = [
    'apikey' => (string) $config['supabase_anon_key'],
    'Authorization' => 'Bearer ' . $token,
    'Accept' => 'application/json',
];

$orders = [];
$rentals = [];

// Fetch completed/pending orders for user
$ordersRes = $http->request(
    'GET',
    $config['supabase_url'] . '/rest/v1/orders?select=*&user_id=eq.' . urlencode($currentUser['id']) . '&order=created_at.desc',
    $userHeaders
);
if ($ordersRes['status'] >= 200 && $ordersRes['status'] < 300 && is_array($ordersRes['body'])) {
    $orders = $ordersRes['body'];
}

// Fetch user active rentals
$rentalsRes = $http->request(
    'GET',
    $config['supabase_url'] . '/rest/v1/rentals?select=*,products(name,image_url)&user_id=eq.' . urlencode($currentUser['id']) . '&order=created_at.desc',
    $userHeaders
);
if ($rentalsRes['status'] >= 200 && $rentalsRes['status'] < 300 && is_array($rentalsRes['body'])) {
    $rentals = $rentalsRes['body'];
}

if (isset($_GET['checkout_success'])) {
    $serviceHeaders = [
        'apikey' => (string) $config['supabase_service_role_key'],
        'Authorization' => 'Bearer ' . $config['supabase_service_role_key'],
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ];
    $latestOrderRes = $http->request(
        'GET',
        $config['supabase_url'] . '/rest/v1/orders?select=*&user_id=eq.' . urlencode($currentUser['id']) . '&payment_status=eq.pending&order=created_at.desc&limit=1',
        $serviceHeaders
    );
    if ($latestOrderRes['status'] >= 200 && !empty($latestOrderRes['body'][0])) {
        $orderId = $latestOrderRes['body'][0]['id'];
        $http->request(
            'PATCH',
            $config['supabase_url'] . '/rest/v1/orders?id=eq.' . urlencode((string)$orderId),
            $serviceHeaders,
            ['payment_status' => 'completed']
        );
    }
}

$success = isset($_GET['checkout_success']) ? 'Thank you for your order! Your lease is active and your items are queued for direct dispatch.' : null;


?>
<?php require __DIR__ . '/partials/header.php'; ?>

<main class="flex-grow w-full max-w-container-max mx-auto px-4 md:px-8 py-lg md:py-xl">
    <!-- Header -->
    <div class="mb-lg reveal-element">
        <h1 class="font-h1 text-h1 text-on-surface mb-md">Order & Lease History</h1>
        <p class="text-body-md text-on-surface-variant max-w-2xl">Track your confirmed lease terms, dynamic payments, and KYC records in one place.</p>
    </div>

    <?php if ($success): ?>
        <div class="bento-item bg-teal-600 text-white rounded-[2.5rem] p-10 mb-12 shadow-2xl shadow-teal-600/20 flex flex-col md:flex-row items-center gap-8 border border-teal-500 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 h-40 w-40 bg-white/10 rounded-full blur-3xl"></div>
            <div class="h-20 w-20 rounded-3xl bg-white text-teal-600 flex items-center justify-center shrink-0 shadow-xl">
                <span class="material-symbols-outlined text-4xl">verified</span>
            </div>
            <div>
                <h2 class="text-3xl font-black mb-2 font-outfit">Transaction Successful</h2>
                <p class="text-teal-50 font-medium leading-relaxed max-w-xl"><?= e($success) ?></p>
            </div>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-lg">
        
        <!-- Confirmed Leases -->
        <div class="space-y-md bento-item">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-2 rounded-xl bg-blue-50 text-blue-600">
                    <span class="material-symbols-outlined">history_edu</span>
                </div>
                <h2 class="text-2xl font-bold text-slate-900 font-outfit">Active Leases</h2>
            </div>

            <?php if (empty($rentals)): ?>
                <div class="bg-surface-container-low rounded-xl p-xl text-center border border-outline-variant/30">
                    <span class="material-symbols-outlined text-outline text-4xl mb-2">inventory_2</span>
                    <p class="text-on-surface-variant font-medium">No active product leases found.</p>
                    <a href="<?= baseUrl('/shop') ?>" class="inline-flex mt-4 text-secondary font-button hover:underline">Start browsing &rarr;</a>
                </div>
            <?php else: ?>
                <div class="grid gap-md">
                    <?php foreach ($rentals as $rental): ?>
                        <?php $p = $rental['products'] ?? null; ?>
                        <div class="bg-white/70 backdrop-blur-md rounded-3xl p-6 border border-slate-100 shadow-sm hover:border-blue-200 transition-all hover:scale-[1.02] active:scale-95 cursor-pointer">
                            <div class="flex items-center gap-6">
                                <div class="h-20 w-20 rounded-2xl overflow-hidden bg-slate-50 border border-slate-100 shrink-0 shadow-inner">
                                    <img src="<?= e((string)($p['image_url'] ?? 'https://placehold.co/150')) ?>" alt="Lease Product" class="h-full w-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-lg font-bold text-slate-900"><?= e((string)($p['name'] ?? 'Custom Product Lease')) ?></h4>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1"><?= e((string)$rental['start_date']) ?> — <?= e((string)$rental['end_date']) ?></p>
                                    <div class="mt-3">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-blue-50 text-blue-600 border border-blue-100">
                                            <?= e((string)$rental['status']) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Payments/Orders -->
        <div class="space-y-md bento-item">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-2 rounded-xl bg-emerald-50 text-emerald-600">
                    <span class="material-symbols-outlined">receipt_long</span>
                </div>
                <h2 class="text-2xl font-bold text-slate-900 font-outfit">Payment History</h2>
            </div>

            <?php if (empty($orders)): ?>
                <div class="bg-surface-container-low rounded-xl p-xl text-center border border-outline-variant/30">
                    <span class="material-symbols-outlined text-outline text-4xl mb-2">receipt_long</span>
                    <p class="text-on-surface-variant font-medium">No payment history recorded.</p>
                </div>
            <?php else: ?>
                <div class="grid gap-md">
                    <?php foreach ($orders as $order): ?>
                        <div class="bg-white/70 backdrop-blur-md rounded-3xl p-6 border border-slate-100 shadow-sm group hover:border-emerald-200 transition-all">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Session Reference</span>
                                    <p class="font-mono text-[10px] text-slate-500 break-all bg-slate-50 p-2 rounded-lg border border-slate-100"><?= e((string)$order['stripe_session_id']) ?></p>
                                </div>
                                <div class="text-right">
                                    <span class="text-2xl font-black text-slate-900 font-outfit">$<?= number_format((float)$order['total_amount'], 2) ?></span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mt-6">
                                <span class="text-xs font-bold text-slate-400 italic">Validated on <?= date('M d, Y', strtotime((string)$order['created_at'])) ?></span>
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest <?= $order['payment_status'] === 'completed' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-amber-50 text-amber-600 border border-amber-100' ?>">
                                    <?= e((string)$order['payment_status']) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    gsap.from(".bento-item", {
        opacity: 0,
        y: 30,
        duration: 0.8,
        stagger: 0.15,
        ease: "power4.out"
    });
});
</script>

<?php require __DIR__ . '/partials/footer.php'; ?>

