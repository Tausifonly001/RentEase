<?php
declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use RentEase\Services\AuthService;

$authService = new AuthService($config);
$currentUser = null;
try {
    $token = $_COOKIE[$config['cookie_name'] ?? ''] ?? '';
    if ($token !== '') {
        $currentUser = $authService->validateToken($token);
    }
} catch (Throwable $ignored) {}

// If not logged in we shouldn't really be here, but stay safe.
if (!$currentUser) {
    header('Location: ' . baseUrl('/login'));
    exit;
}

$rawName = $currentUser['user_metadata']['full_name']
    ?? $currentUser['full_name']
    ?? ($currentUser['email'] ?? 'Guest');
$name = is_string($rawName) ? $rawName : 'Guest';

$pageTitle = 'Order Confirmed — RentEase';
require __DIR__ . '/partials/header.php';
?>

<main class="w-full relative bg-canvas text-ink pt-40 pb-32 min-h-screen flex items-center">
    <div class="max-w-2xl mx-auto px-6 text-center">
        <!-- Success icon -->
        <div class="mb-10 flex justify-center">
            <div class="relative">
                <div class="absolute inset-0 bg-champagne/30 blur-3xl rounded-full"></div>
                <div class="relative h-28 w-28 rounded-[2rem] bg-surface border border-border shadow-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-6xl text-champagne-dark">check_circle</span>
                </div>
            </div>
        </div>

        <h1 class="text-4xl md:text-6xl font-serif font-medium tracking-tight text-ink mb-6">Payment Received!</h1>
        <p class="text-muted text-lg font-light leading-relaxed mb-12">
            Thank you, <span class="text-ink font-normal"><?= e($name) ?></span>. Your order has been confirmed and our fulfillment team is already preparing your premium lease items for dispatch.
        </p>

        <!-- Information cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-12">
            <div class="bg-surface border border-border p-6 text-left rounded-sm">
                <span class="material-symbols-outlined text-champagne-dark mb-2">local_shipping</span>
                <h3 class="font-medium text-ink mb-1">Next Step</h3>
                <p class="text-sm text-muted font-light">Scheduled delivery within 48 hours.</p>
            </div>
            <div class="bg-surface border border-border p-6 text-left rounded-sm">
                <span class="material-symbols-outlined text-champagne-dark mb-2">description</span>
                <h3 class="font-medium text-ink mb-1">Lease Agreement</h3>
                <p class="text-sm text-muted font-light">Available in your dashboard.</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?= baseUrl('/orders') ?>" class="btn-primary">Track My Order</a>
            <a href="<?= baseUrl('/shop') ?>" class="btn-secondary">Back to Shop</a>
        </div>

        <p class="mt-12 text-xs font-light text-muted-light uppercase tracking-[0.2em]">Secured by Stripe &amp; Supabase</p>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof confetti !== 'function') return;
    var count = 200;
    var defaults = { origin: { y: 0.7 }, colors: ['#C5A98B', '#A8886E', '#18181B'] };
    function fire(ratio, opts) {
        confetti(Object.assign({}, defaults, opts, { particleCount: Math.floor(count * ratio) }));
    }
    setTimeout(function () {
        fire(0.25, { spread: 26, startVelocity: 55 });
        fire(0.2, { spread: 60 });
        fire(0.35, { spread: 100, decay: 0.91, scalar: 0.8 });
        fire(0.1, { spread: 120, startVelocity: 25, decay: 0.92, scalar: 1.2 });
        fire(0.1, { spread: 120, startVelocity: 45 });
    }, 400);
});
</script>

<?php require __DIR__ . '/partials/footer.php'; ?>
