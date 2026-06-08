<?php
declare(strict_types=1);

use RentEase\Services\AuthService;
use RentEase\Services\LogisticsService;
use RentEase\Support\HttpClient;

require __DIR__ . '/../bootstrap.php';

$authService = new AuthService($config);
$logisticsService = new LogisticsService($config);

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

// Fetch deliveries to enable tracking
$deliveries = [];
try {
 $deliveries = $logisticsService->getUserDeliveries($currentUser['id'], $token);
} catch (Throwable $e) {}

// Map deliveries by order_id and rental_id for quick lookup
$orderDeliveries = [];
$rentalDeliveries = [];
foreach ($deliveries as $d) {
 if (!empty($d['order_id'])) {
 $orderDeliveries[$d['order_id']] = $d;
 }
 if (!empty($d['rental_id'])) {
 $rentalDeliveries[$d['rental_id']] = $d;
 }
}

// Success logic moved to success.php

$success = null;


?>
<?php require __DIR__ . '/partials/header.php'; ?>

<main class="flex-grow w-full max-w-container-max mx-auto px-4 md:px-8 py-lg md:py-xl">
 <!-- Header -->
 <div class="mb-lg reveal-element">
 <h1 class="font-h1 text-h1 text-on-surface mb-md">Order & Lease History</h1>
 <p class="text-body-md text-on-surface-variant max-w-2xl">Track your confirmed lease terms, dynamic payments, and KYC records in one place.</p>
 </div>

 <?php if ($success): ?>
 <div class="bento-item bg-champagne text-white rounded-[2.5rem] p-10 mb-12 flex flex-col md:flex-row items-center gap-8 relative overflow-hidden">
 <div class="absolute -right-10 -top-10 h-40 w-40 bg-white/10 rounded-full blur-3xl"></div>
 <div class="h-20 w-20 rounded-3xl bg-surface text-champagne-dark flex items-center justify-center shrink-0">
 <span class="material-symbols-outlined text-4xl">verified</span>
 </div>
 <div>
 <h2 class="text-3xl font-normal mb-2">Transaction Successful</h2>
 <p class="text-white/80 font-normal leading-relaxed max-w-xl"><?= e($success) ?></p>
 </div>
 </div>
 <?php endif; ?>

 <div class="grid grid-cols-1 lg:grid-cols-2 gap-lg">

 <!-- Confirmed Leases -->
 <div class="space-y-md bento-item">
 <div class="flex items-center gap-3 mb-6">
 <div class="p-2 bg-canvas text-champagne-dark">
 <span class="material-symbols-outlined">history_edu</span>
 </div>
 <h2 class="text-2xl font-normal text-ink">Active Leases</h2>
 </div>

 <?php if (empty($rentals)): ?>
 <div class="bg-surface-container-low p-xl text-center border border-outline-variant/30">
 <span class="material-symbols-outlined text-outline text-4xl mb-2">inventory_2</span>
 <p class="text-on-surface-variant font-normal">No active product leases found.</p>
 <a href="<?= baseUrl('/shop') ?>" class="inline-flex mt-4 text-champagne-dark font-button hover:underline">Start browsing &rarr;</a>
 </div>
 <?php else: ?>
 <div class="grid gap-md">
 <?php foreach ($rentals as $rental): ?>
 <?php $p = $rental['products'] ?? null; ?>
 <div class="bg-surface/70 backdrop-blur-md rounded-3xl p-6 hover:border-blue-200 transition-all hover:scale-[1.02] active:scale-95 cursor-pointer" style="border-color: rgba(231,229,228,0.6);">
 <div class="flex items-center gap-6">
 <div class="h-20 w-20 overflow-hidden bg-canvas shrink-0" style="border-color: rgba(231,229,228,0.6);">
 <img src="<?= e((string)($p['image_url'] ?? 'https://placehold.co/150')) ?>" alt="Lease Product" class="h-full w-full object-cover">
 </div>
 <div class="flex-1">
 <h4 class="text-lg font-normal text-ink"><?= e((string)($p['name'] ?? 'Custom Product Lease')) ?></h4>
 <p class="text-xs font-light text-muted-light uppercase tracking-widest mt-1"><?= e((string)$rental['start_date']) ?> — <?= e((string)$rental['end_date']) ?></p>
 <div class="mt-3">
 <span class="px-3 py-1 rounded-full text-[10px] font-normal uppercase tracking-widest bg-canvas text-champagne-dark border border-champagne/20">
 <?= e((string)$rental['status']) ?>
 </span>
 </div>
 <?php if (isset($rentalDeliveries[$rental['id']])): ?>
 <div class="mt-4">
 <a href="<?= baseUrl('/tracking?id=' . $rentalDeliveries[$rental['id']]['id']) ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-champagne-dark text-white text-[10px] font-normal uppercase tracking-widest hover:bg-champagne-dark transition-all shadow-lg shadow-lg">
 <span class="material-symbols-outlined text-sm font-light">local_shipping</span>
 Track Delivery
 </a>
 </div>
 <?php endif; ?>
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
 <div class="p-2 bg-champagne/10 text-champagne-dark">
 <span class="material-symbols-outlined">receipt_long</span>
 </div>
 <h2 class="text-2xl font-normal text-ink">Payment History</h2>
 </div>

 <?php if (empty($orders)): ?>
 <div class="bg-surface-container-low p-xl text-center border border-outline-variant/30">
 <span class="material-symbols-outlined text-outline text-4xl mb-2">receipt_long</span>
 <p class="text-on-surface-variant font-normal">No payment history recorded.</p>
 </div>
 <?php else: ?>
 <div class="grid gap-md">
 <?php foreach ($orders as $order): ?>
 <div class="bg-surface/70 backdrop-blur-md rounded-3xl p-6 group hover:border-champagne/30 transition-all" style="border-color: rgba(231,229,228,0.6);">
 <div class="flex justify-between items-start mb-4">
 <div>
 <span class="text-[10px] font-normal text-muted-light uppercase tracking-widest block mb-1">Receipt Number</span>
 <p class="text-sm font-light text-ink bg-canvas px-3 py-1 rounded-full inline-block" style="border-color: rgba(231,229,228,0.6);">
 #<?= strtoupper(substr((string)$order['id'], 0, 8)) ?>
 </p>
 </div>
 <div class="text-right">
 <span class="text-2xl font-normal text-ink">$<?= number_format((float)$order['total_amount'], 2) ?></span>
 </div>
 </div>
 <div class="flex justify-between items-center mt-6">
 <span class="text-xs font-light text-muted-light italic">Validated on <?= date('M d, Y', strtotime((string)$order['created_at'])) ?></span>
 <span class="px-3 py-1 rounded-full text-[10px] font-normal uppercase tracking-widest <?= $order['payment_status'] === 'completed' ? 'bg-champagne/10 text-champagne-dark' : 'bg-amber-50 text-amber-600' ?>">
 <?= e((string)$order['payment_status']) ?>
 </span>
 <?php if (isset($orderDeliveries[$order['id']])): ?>
 <a href="<?= baseUrl('/tracking?id=' . $orderDeliveries[$order['id']]['id']) ?>" class="ml-3 inline-flex items-center gap-1.5 px-3 py-1.5 bg-champagne text-white text-[9px] font-normal uppercase tracking-widest hover:bg-champagne/90 transition-all">
 <span class="material-symbols-outlined text-[14px]">distance</span>
 Live Track
 </a>
 <?php endif; ?>
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