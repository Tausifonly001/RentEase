<?php
/**
 * Delivery Tracking
 * 
 * Live tracking for deliveries and returns with manifest and GPS simulation.
 */

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../src/Support/Csrf.php';

use RentEase\Services\AuthService;
use RentEase\Services\LogisticsService;

$authService = new AuthService($config);
$logisticsService = new LogisticsService($config);

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
    header('Location: ' . baseUrl('/login'));
    exit;
}

// Fetch delivery
$deliveryId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$activeDelivery = null;

try {
    if ($deliveryId) {
        $activeDelivery = $logisticsService->getDeliveryById($deliveryId, $token);
    } else {
        $deliveries = $logisticsService->getUserDeliveries($currentUser['id'], $token);
        foreach ($deliveries as $d) {
            if ($d['status'] === 'IN_TRANSIT' || $d['status'] === 'SCHEDULED' || $d['status'] === 'PENDING') {
                $activeDelivery = $d;
                break;
            }
        }
    }
} catch (Throwable $ignored) {}

$pageTitle = 'Track Your Delivery - RentEase';
require_once __DIR__ . '/partials/header.php';
?>

<main class="flex-grow pt-24 pb-20 px-6 md:px-12 max-w-7xl mx-auto min-h-screen w-full">
    <?php if (!$activeDelivery): ?>
        <div class="text-center py-20 bg-surface rounded-3xl reveal-element" style="border-color: rgba(231,229,228,0.6);">
            <span class="material-symbols-outlined text-6xl text-muted-light mb-6">local_shipping</span>
            <h1 class="text-3xl font-normal text-ink mb-4">No Active Deliveries</h1>
            <p class="text-muted max-w-md mx-auto mb-8 font-normal">You don't have any deliveries or pickups currently in progress.</p>
            <a href="<?= baseUrl('/dashboard') ?>" class="inline-flex items-center gap-2 px-8 py-4 bg-ink text-white font-normal hover:opacity-95 transition-all">
                Go to Dashboard
                <span class="material-symbols-outlined">arrow_forward</span>
            </a>
        </div>
    <?php else: 
        $status = $activeDelivery['status'] ?? 'PENDING';
        $isPickup = ($activeDelivery['type'] ?? 'DELIVERY') === 'PICKUP';
        $orderNumber = !empty($activeDelivery['orders']['id']) ? 'RE-' . strtoupper(substr((string)$activeDelivery['orders']['id'], 0, 8)) : 'RE-' . strtoupper(substr((string)$activeDelivery['user_id'], 0, 4));
    ?>
        <!-- Header Section: Live Countdown -->
        <div class="mb-12 grid grid-cols-1 md:grid-cols-2 gap-8 items-end reveal-element">
            <div>
                <h1 class="text-4xl font-normal text-ink tracking-tight mb-2"><?= $isPickup ? 'Track Your Pickup' : 'Track Your Delivery' ?></h1>
                <p class="text-muted font-normal">Order #<?= htmlspecialchars((string)$orderNumber) ?> • Status: <span class="text-champagne-dark font-normal"><?= str_replace('_', ' ', $status) ?></span></p>
            </div>
            <div class="bg-ink text-white p-8 rounded-3xl flex flex-col md:items-end relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-champagne/10 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-1000"></div>
                <span class="text-[10px] font-normal uppercase tracking-[0.2em] text-champagne mb-2">Estimated Arrival</span>
                <div class="flex items-baseline space-x-2">
                    <span class="text-3xl md:text-4xl font-normal"><?= htmlspecialchars((string)($activeDelivery['time_slot'] ?? '10:30 AM - 11:45 AM')) ?></span>
                </div>
                <div class="flex items-center mt-3 text-champagne/40">
                    <span class="material-symbols-outlined text-sm mr-2 font-light">schedule</span>
                    <p class="text-xs font-light italic"><?= htmlspecialchars((string)($activeDelivery['scheduled_date'] ?? date('Y-m-d'))) ?></p>
                </div>
            </div>
        </div>

        <!-- Bento Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column: Map -->
            <div class="lg:col-span-8 space-y-8">
                <div class="relative bg-surface rounded-3xl overflow-hidden aspect-video group reveal-element" style="border-color: rgba(231,229,228,0.6);">
                    <div id="map-container" class="absolute inset-0 bg-canvas">
                        <!-- Google Map will render here -->
                    </div>
                    <div class="absolute top-6 left-6 bg-surface/90 backdrop-blur-md px-4 py-2 flex items-center" style="border-color: rgba(255,255,255,0.5);border-radius: 0.75rem;">
                        <div class="w-2.5 h-2.5 bg-champagne rounded-full animate-pulse mr-3"></div>
                        <span class="text-[10px] font-normal text-ink uppercase tracking-widest" id="lastUpdatedText">Live GPS Tracking</span>
                    </div>
                </div>

                <!-- Driver & Instructions -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 reveal-element">
                    <div class="bg-surface p-6 rounded-3xl flex items-center justify-between group" style="border-color: rgba(231,229,228,0.6);">
                        <div class="flex items-center">
                            <div class="w-16 h-16 overflow-hidden mr-5 bg-canvas border-2 border-surface shrink-0" style="border-radius: 0.75rem;">
                                <img class="w-full h-full object-cover" src="https://i.pravatar.cc/150?u=driver" alt="Driver"/>
                            </div>
                            <div>
                                <p class="text-[10px] font-normal text-muted-light uppercase tracking-widest mb-1">Your Driver</p>
                                <p class="text-xl font-normal text-ink">Marcus J.</p>
                                <div class="flex items-center text-champagne-dark text-xs font-light mt-1">
                                    <span class="material-symbols-outlined text-[14px] mr-1">star</span>
                                    <span>4.9 (2.4k deliveries)</span>
                                </div>
                            </div>
                        </div>
                        <button class="bg-champagne/10 text-champagne-dark p-4 hover:bg-champagne hover:text-white transition-all" style="border-radius: 0.75rem; border-color: rgba(231,229,228,0.6);">
                            <span class="material-symbols-outlined">call</span>
                        </button>
                    </div>
                    <div class="bg-canvas p-6 rounded-3xl flex flex-col justify-center" style="border-left: 4px solid #D4A574;">
                        <div class="flex items-center mb-2">
                            <span class="material-symbols-outlined text-champagne-dark mr-2 text-xl">description</span>
                            <span class="text-[10px] font-normal text-ink uppercase tracking-widest">Notes</span>
                        </div>
                        <p class="text-sm text-muted italic leading-relaxed font-light">"<?= htmlspecialchars((string)($activeDelivery['agent_notes'] ?? 'No special instructions provided.')) ?>"</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Status & Items -->
            <div class="lg:col-span-4 space-y-8">
                <!-- Status Timeline -->
                <div class="bg-surface p-8 rounded-3xl reveal-element" style="border-color: rgba(231,229,228,0.6);">
                    <h3 class="text-xl font-normal text-ink mb-8 tracking-tight">Status</h3>
                    <div class="space-y-8 relative">
                        <?php 
                        $steps = [
                            ['key' => 'PENDING', 'label' => 'Order Received', 'icon' => 'inventory'],
                            ['key' => 'SCHEDULED', 'label' => 'Scheduled', 'icon' => 'calendar_today'],
                            ['key' => 'IN_TRANSIT', 'label' => 'In Transit', 'icon' => 'local_shipping'],
                            ['key' => 'COMPLETED', 'label' => 'Completed', 'icon' => 'check_circle']
                        ];
                        $reached = false;
                        $currentIndex = 0;
                        foreach($steps as $index => $step) {
                            if($status === $step['key']) {
                                $currentIndex = $index;
                                break;
                            }
                        }
                        
                        foreach ($steps as $index => $step): 
                            $isDone = $index < $currentIndex;
                            $isActive = $index === $currentIndex;
                            $isLast = $index === count($steps) - 1;
                        ?>
                            <div class="relative flex items-start">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center z-10 shrink-0 <?= $isDone ? 'bg-champagne text-white' : ($isActive ? 'bg-champagne/10 text-champagne-dark border-2 border-champagne ring-4 ring-champagne/10' : 'bg-canvas text-muted-light border') ?>" <?= $isDone || $isActive ? '' : 'style="border-color: rgba(231,229,228,0.6);"' ?>>
                                    <?php if ($isDone): ?>
                                        <span class="material-symbols-outlined text-sm font-light">check</span>
                                    <?php elseif ($isActive): ?>
                                        <div class="w-2 h-2 bg-champagne rounded-full animate-ping"></div>
                                    <?php else: ?>
                                        <span class="material-symbols-outlined text-sm font-light"><?= $step['icon'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="ml-6 pt-1">
                                    <p class="text-sm font-light <?= $isActive || $isDone ? 'text-ink' : 'text-muted-light' ?> uppercase tracking-widest mb-1"><?= $step['label'] ?></p>
                                    <?php if ($isActive): ?>
                                        <p class="text-xs text-champagne-dark font-light">Updated just now</p>
                                    <?php endif; ?>
                                </div>
                                <?php if (!$isLast): ?>
                                    <div class="absolute left-4 top-8 w-[2px] h-8 <?= $isDone ? 'bg-champagne' : '' ?>" <?= $isDone ? '' : 'style="background: rgba(231,229,228,0.6);"' ?>></div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Items -->
                <div class="bg-surface p-8 rounded-3xl reveal-element" style="border-color: rgba(231,229,228,0.6);">
                    <h3 class="text-xl font-normal text-ink mb-8 tracking-tight">Manifest</h3>
                    <?php 
                    $rental = $activeDelivery['rentals'] ?? null;
                    $product = $rental['products'] ?? null;
                    if ($product):
                    ?>
                        <div class="flex items-center p-3 hover:bg-canvas transition-all border border-transparent hover:border-[rgba(231,229,228,0.6)] group cursor-pointer" style="border-radius: 0.75rem;">
                            <div class="w-14 h-14 bg-canvas mr-4 overflow-hidden shrink-0" style="border-radius: 0.75rem;">
                                <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="<?= htmlspecialchars((string)$product['image_url']) ?>" alt="Product"/>
                            </div>
                            <div class="flex-grow">
                                <p class="text-sm font-light text-ink mb-0.5"><?= htmlspecialchars((string)$product['name']) ?></p>
                                <p class="text-[10px] font-normal text-muted-light uppercase tracking-widest">SKU: <?= htmlspecialchars((string)($product['sku'] ?? 'N/A')) ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mt-10 pt-6 flex flex-col space-y-3" style="border-top-color: rgba(231,229,228,0.6);">
                        <a href="<?= baseUrl('/support') ?>" class="w-full bg-ink text-white font-normal py-4 flex items-center justify-center gap-2 hover:scale-[1.02] transition-all" style="border-radius: 0.75rem;">
                            <span class="material-symbols-outlined text-xl">support_agent</span>
                            Live Support
                        </a>
                        <?php if ($status !== 'COMPLETED'): ?>
                            <a href="reschedule.php?id=<?= $activeDelivery['id'] ?>" class="w-full bg-surface border-2 text-muted font-normal py-4 flex items-center justify-center gap-2 hover:bg-canvas transition-all" style="border-color: rgba(231,229,228,0.6); border-radius: 0.75rem;">
                                <span class="material-symbols-outlined text-xl">event_repeat</span>
                                Reschedule
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
<script>
const deliveryId = <?= $activeDelivery['id'] ?? 'null' ?>;
const activeOrderId = '<?= $activeDelivery['order_id'] ?? '' ?>';
const supabaseUrl = '<?= $config['supabase_url'] ?? '' ?>';
const supabaseKey = '<?= $config['supabase_anon_key'] ?? '' ?>';

if (supabaseUrl && supabaseKey) {
    window.supabaseClient = supabase.createClient(supabaseUrl, supabaseKey);
}
window.activeOrderId = activeOrderId;
// For simulation, setting a fixed destination. In a real app, load this from order.
window.destinationCoords = { lat: 40.7100, lng: -74.0000 };

async function pollStatus() {
    if (!deliveryId) return;
    try {
        const response = await fetch(`api/logistics/status.php?id=${deliveryId}`);
        const data = await response.json();
        if (data.status && data.status !== '<?= $status ?>') {
            window.location.reload();
        }
    } catch (e) {
        console.error('Polling failed', e);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    gsap.from('.reveal-element', {
        opacity: 0,
        y: 20,
        duration: 0.8,
        stagger: 0.1,
        ease: 'power3.out'
    });
    
    // Poll every 30 seconds for general status changes, but GPS is realtime
    setInterval(pollStatus, 30000);
});
</script>

<!-- Load tracking JS -->
<script src="<?= baseUrl('/js/tracking.js') ?>"></script>
<!-- Load Google Maps API (Deferred to maintain performance) -->
<?php $mapsKey = getenv('GOOGLE_MAPS_API_KEY') ?: ''; ?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= htmlspecialchars($mapsKey) ?>&callback=initMap"></script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
