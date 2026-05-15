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
    header('Location: login.php');
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
        <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-slate-100 reveal-element">
            <span class="material-symbols-outlined text-6xl text-slate-200 mb-6">local_shipping</span>
            <h1 class="text-3xl font-bold text-primary mb-4">No Active Deliveries</h1>
            <p class="text-slate-500 max-w-md mx-auto mb-8 font-medium">You don't have any deliveries or pickups currently in progress.</p>
            <a href="dashboard.php" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-white font-bold rounded-2xl hover:opacity-95 transition-all shadow-xl shadow-primary/20">
                Go to Dashboard
                <span class="material-symbols-outlined">arrow_forward</span>
            </a>
        </div>
    <?php else: 
        $status = $activeDelivery['status'] ?? 'PENDING';
        $isPickup = ($activeDelivery['type'] ?? 'DELIVERY') === 'PICKUP';
        $orderNumber = $activeDelivery['orders']['order_number'] ?? 'RE-' . substr($activeDelivery['user_id'], 0, 4);
    ?>
        <!-- Header Section: Live Countdown -->
        <div class="mb-12 grid grid-cols-1 md:grid-cols-2 gap-8 items-end reveal-element">
            <div>
                <h1 class="text-4xl font-bold text-primary tracking-tight mb-2"><?= $isPickup ? 'Track Your Pickup' : 'Track Your Delivery' ?></h1>
                <p class="text-slate-500 font-medium">Order #<?= htmlspecialchars((string)$orderNumber) ?> • Status: <span class="text-teal-600 font-bold"><?= str_replace('_', ' ', $status) ?></span></p>
            </div>
            <div class="bg-primary text-white p-8 rounded-3xl shadow-xl flex flex-col md:items-end relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-teal-500/10 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-1000"></div>
                <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-teal-400 mb-2">Estimated Arrival</span>
                <div class="flex items-baseline space-x-2">
                    <span class="text-3xl md:text-4xl font-bold"><?= htmlspecialchars((string)($activeDelivery['time_slot'] ?? '10:30 AM - 11:45 AM')) ?></span>
                </div>
                <div class="flex items-center mt-3 text-teal-100/60">
                    <span class="material-symbols-outlined text-sm mr-2">schedule</span>
                    <p class="text-xs font-bold italic"><?= htmlspecialchars((string)($activeDelivery['scheduled_date'] ?? date('Y-m-d'))) ?></p>
                </div>
            </div>
        </div>

        <!-- Bento Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column: Map -->
            <div class="lg:col-span-8 space-y-8">
                <div class="relative bg-white rounded-3xl overflow-hidden shadow-sm aspect-video border border-slate-100 group reveal-element">
                    <div id="map-container" class="absolute inset-0 bg-slate-100">
                        <!-- Google Map will render here -->
                    </div>
                    <div class="absolute top-6 left-6 bg-white/90 backdrop-blur-md px-4 py-2 rounded-xl shadow-lg flex items-center border border-white/50">
                        <div class="w-2.5 h-2.5 bg-teal-500 rounded-full animate-pulse mr-3"></div>
                        <span class="text-[10px] font-bold text-primary uppercase tracking-widest" id="lastUpdatedText">Live GPS Tracking</span>
                    </div>
                </div>

                <!-- Driver & Instructions -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 reveal-element">
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center justify-between group">
                        <div class="flex items-center">
                            <div class="w-16 h-16 rounded-2xl overflow-hidden mr-5 bg-slate-50 border-2 border-white shadow-sm shrink-0">
                                <img class="w-full h-full object-cover" src="https://i.pravatar.cc/150?u=driver" alt="Driver"/>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Your Driver</p>
                                <p class="text-xl font-bold text-primary">Marcus J.</p>
                                <div class="flex items-center text-teal-600 text-xs font-bold mt-1">
                                    <span class="material-symbols-outlined text-[14px] mr-1">star</span>
                                    <span>4.9 (2.4k deliveries)</span>
                                </div>
                            </div>
                        </div>
                        <button class="bg-teal-50 text-teal-600 p-4 rounded-2xl hover:bg-teal-600 hover:text-white transition-all shadow-sm border border-teal-100">
                            <span class="material-symbols-outlined">call</span>
                        </button>
                    </div>
                    <div class="bg-slate-50 p-6 rounded-3xl border-l-4 border-teal-500 shadow-sm flex flex-col justify-center">
                        <div class="flex items-center mb-2">
                            <span class="material-symbols-outlined text-teal-600 mr-2 text-xl">description</span>
                            <span class="text-[10px] font-bold text-primary uppercase tracking-widest">Notes</span>
                        </div>
                        <p class="text-sm text-slate-600 italic leading-relaxed">"<?= htmlspecialchars((string)($activeDelivery['agent_notes'] ?? 'No special instructions provided.')) ?>"</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Status & Items -->
            <div class="lg:col-span-4 space-y-8">
                <!-- Status Timeline -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 reveal-element">
                    <h3 class="text-xl font-bold text-primary mb-8 tracking-tight">Status</h3>
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
                                <div class="w-8 h-8 rounded-full flex items-center justify-center z-10 shrink-0 <?= $isDone ? 'bg-teal-500 text-white shadow-lg shadow-teal-500/20' : ($isActive ? 'bg-teal-50 text-teal-500 border-2 border-teal-500 ring-4 ring-teal-50' : 'bg-slate-50 text-slate-300 border border-slate-100') ?>">
                                    <?php if ($isDone): ?>
                                        <span class="material-symbols-outlined text-sm">check</span>
                                    <?php elseif ($isActive): ?>
                                        <div class="w-2 h-2 bg-teal-500 rounded-full animate-ping"></div>
                                    <?php else: ?>
                                        <span class="material-symbols-outlined text-sm"><?= $step['icon'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="ml-6 pt-1">
                                    <p class="text-sm font-bold <?= $isActive || $isDone ? 'text-primary' : 'text-slate-300' ?> uppercase tracking-widest mb-1"><?= $step['label'] ?></p>
                                    <?php if ($isActive): ?>
                                        <p class="text-xs text-teal-600 font-medium">Updated just now</p>
                                    <?php endif; ?>
                                </div>
                                <?php if (!$isLast): ?>
                                    <div class="absolute left-4 top-8 w-[2px] h-8 <?= $isDone ? 'bg-teal-500' : 'bg-slate-100' ?>"></div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Items -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 reveal-element">
                    <h3 class="text-xl font-bold text-primary mb-8 tracking-tight">Manifest</h3>
                    <?php 
                    $rental = $activeDelivery['rentals'] ?? null;
                    $product = $rental['products'] ?? null;
                    if ($product):
                    ?>
                        <div class="flex items-center p-3 hover:bg-slate-50 transition-all rounded-2xl border border-transparent hover:border-slate-100 group cursor-pointer">
                            <div class="w-14 h-14 bg-slate-50 rounded-xl mr-4 overflow-hidden shrink-0 shadow-sm">
                                <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="<?= htmlspecialchars((string)$product['image_url']) ?>" alt="Product"/>
                            </div>
                            <div class="flex-grow">
                                <p class="text-sm font-bold text-slate-900 mb-0.5"><?= htmlspecialchars((string)$product['name']) ?></p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">SKU: <?= htmlspecialchars((string)($product['sku'] ?? 'N/A')) ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mt-10 pt-6 border-t border-slate-50 flex flex-col space-y-3">
                        <a href="support.php" class="w-full bg-primary text-white font-bold py-4 rounded-xl flex items-center justify-center gap-2 hover:scale-[1.02] transition-all shadow-lg shadow-primary/20">
                            <span class="material-symbols-outlined text-xl">support_agent</span>
                            Live Support
                        </a>
                        <?php if ($status !== 'COMPLETED'): ?>
                            <a href="reschedule.php?id=<?= $activeDelivery['id'] ?>" class="w-full bg-white border-2 border-slate-100 text-slate-600 font-bold py-4 rounded-xl flex items-center justify-center gap-2 hover:bg-slate-50 transition-all">
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
<script src="../js/tracking.js"></script>
<!-- Load Google Maps API (Deferred to maintain performance) -->
<?php $mapsKey = getenv('GOOGLE_MAPS_API_KEY') ?: ''; ?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= htmlspecialchars($mapsKey) ?>&callback=initMap"></script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
?>
