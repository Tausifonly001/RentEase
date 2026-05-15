<?php
declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

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

$pageTitle = 'Agent Tracking - RentEase';
require_once __DIR__ . '/partials/header.php';

// In a real app we'd fetch active orders assigned to this agent.
// Here we'll just allow the agent to input an order ID for simulation.
?>

<main class="flex-grow pt-24 pb-20 px-6 md:px-12 max-w-3xl mx-auto min-h-screen w-full">
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 reveal-element">
        <h1 class="text-3xl font-bold text-primary mb-2">Agent Location Broadcaster</h1>
        <p class="text-slate-500 mb-8">Broadcast your real-time location to the customer.</p>
        
        <div class="mb-6">
            <label class="block text-sm font-bold text-slate-700 mb-2">Order ID (UUID)</label>
            <input type="text" id="orderIdInput" class="w-full border-slate-200 rounded-xl px-4 py-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-teal-500" placeholder="Enter Order UUID...">
        </div>

        <div class="flex gap-4 mb-8">
            <button id="startBtn" class="flex-1 bg-teal-600 text-white font-bold py-3 px-4 rounded-xl hover:bg-teal-700 transition shadow-lg shadow-teal-500/30 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined">play_arrow</span> Start Tracking
            </button>
            <button id="stopBtn" class="flex-1 bg-rose-50 text-rose-600 font-bold py-3 px-4 rounded-xl hover:bg-rose-100 transition flex items-center justify-center gap-2" disabled>
                <span class="material-symbols-outlined">stop</span> Stop
            </button>
        </div>

        <div id="statusBox" class="bg-slate-50 p-6 rounded-2xl border border-slate-100 text-sm font-mono text-slate-600">
            Waiting to start...
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
<script>
    const supabaseUrl = '<?= $config['supabase_url'] ?>';
    const supabaseKey = '<?= $config['supabase_anon_key'] ?>';
    const supabase = supabase.createClient(supabaseUrl, supabaseKey);

    let watchId = null;
    let lastLat = null;
    let lastLng = null;
    const DISTANCE_THRESHOLD = 10; // meters

    const statusBox = document.getElementById('statusBox');
    const startBtn = document.getElementById('startBtn');
    const stopBtn = document.getElementById('stopBtn');
    const orderIdInput = document.getElementById('orderIdInput');

    function log(msg) {
        const p = document.createElement('div');
        p.textContent = `[${new Date().toLocaleTimeString()}] ${msg}`;
        statusBox.prepend(p);
    }

    // Haversine formula to calculate distance
    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371e3; // metres
        const φ1 = lat1 * Math.PI/180; // φ, λ in radians
        const φ2 = lat2 * Math.PI/180;
        const Δφ = (lat2-lat1) * Math.PI/180;
        const Δλ = (lon2-lon1) * Math.PI/180;

        const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
                  Math.cos(φ1) * Math.cos(φ2) *
                  Math.sin(Δλ/2) * Math.sin(Δλ/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

        return R * c; // in metres
    }

    async function pushLocation(orderId, lat, lng, heading) {
        const { data, error } = await supabase
            .from('delivery_logistics')
            .upsert({
                order_id: orderId,
                latitude: lat,
                longitude: lng,
                heading: heading,
                last_updated: new Date().toISOString()
            }, { onConflict: 'order_id' });
            
        if (error) {
            log(`Error pushing to DB: ${error.message}`);
        } else {
            log(`Broadcasted: ${lat.toFixed(5)}, ${lng.toFixed(5)}`);
        }
    }

    startBtn.addEventListener('click', () => {
        const orderId = orderIdInput.value.trim();
        if (!orderId) {
            alert('Please enter an Order ID.');
            return;
        }

        if (!navigator.geolocation) {
            alert('Geolocation is not supported by your browser.');
            return;
        }

        startBtn.disabled = true;
        stopBtn.disabled = false;
        orderIdInput.disabled = true;
        log('Starting GPS tracking...');

        watchId = navigator.geolocation.watchPosition(
            (position) => {
                const { latitude, longitude, heading } = position.coords;
                
                if (lastLat !== null && lastLng !== null) {
                    const dist = calculateDistance(lastLat, lastLng, latitude, longitude);
                    if (dist < DISTANCE_THRESHOLD) {
                        return; // Did not move enough
                    }
                }
                
                lastLat = latitude;
                lastLng = longitude;
                
                pushLocation(orderId, latitude, longitude, heading || 0);
            },
            (error) => {
                log(`GPS Error: ${error.message}`);
            },
            {
                enableHighAccuracy: true,
                maximumAge: 0,
                timeout: 5000
            }
        );
    });

    stopBtn.addEventListener('click', () => {
        if (watchId !== null) {
            navigator.geolocation.clearWatch(watchId);
            watchId = null;
        }
        startBtn.disabled = false;
        stopBtn.disabled = true;
        orderIdInput.disabled = false;
        log('Tracking stopped.');
        lastLat = null;
        lastLng = null;
    });
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
