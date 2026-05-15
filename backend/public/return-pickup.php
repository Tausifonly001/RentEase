<?php
/**
 * Return Pickup Scheduling
 * 
 * Step-by-step flow to select items for return and schedule a pickup.
 */

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use RentEase\Services\AuthService;
use RentEase\Services\RentalService;

$authService = new AuthService($config);
$rentalService = new RentalService($config);

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

$activeRentals = [];
try {
    $activeRentals = $rentalService->activeRentalsForUser($currentUser['id'], $token);
} catch (Throwable $ignored) {}

$selectedId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$title = 'Schedule a Return | RentEase';
require_once __DIR__ . '/partials/header.php';
?>

<main class="pt-24 pb-16 max-w-7xl mx-auto px-8 min-h-screen">
    <!-- Hero & Progress -->
    <section class="mb-10">
        <h1 class="text-4xl md:text-5xl font-bold text-primary mb-4 tracking-tight">Schedule a Return</h1>
        <p class="text-lg text-slate-500 max-w-2xl leading-relaxed">Effortlessly manage your rental end-of-life. Choose your items, tell us about their condition, and pick a time that works for you.</p>
    </section>

    <!-- Stepper Component -->
    <div class="mb-12">
        <div class="flex items-center justify-between max-w-4xl mx-auto">
            <div class="flex flex-col items-center gap-2 group step-indicator" data-step="1">
                <div class="step-circle w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shadow-lg shadow-primary/20">1</div>
                <span class="step-text text-[10px] font-bold tracking-widest text-primary uppercase">ITEM SELECTION</span>
            </div>
            <div class="flex-1 h-[2px] bg-slate-100 mx-4 mb-6"></div>
            <div class="flex flex-col items-center gap-2 step-indicator" data-step="2">
                <div class="step-circle w-10 h-10 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center font-bold">2</div>
                <span class="step-text text-[10px] font-bold tracking-widest text-slate-400 uppercase">CONDITION</span>
            </div>
            <div class="flex-1 h-[2px] bg-slate-100 mx-4 mb-6"></div>
            <div class="flex flex-col items-center gap-2 step-indicator" data-step="3">
                <div class="step-circle w-10 h-10 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center font-bold">3</div>
                <span class="step-text text-[10px] font-bold tracking-widest text-slate-400 uppercase">SCHEDULING</span>
            </div>
            <div class="flex-1 h-[2px] bg-slate-100 mx-4 mb-6"></div>
            <div class="flex flex-col items-center gap-2 step-indicator" data-step="4">
                <div class="step-circle w-10 h-10 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center font-bold">4</div>
                <span class="step-text text-[10px] font-bold tracking-widest text-slate-400 uppercase">CONFIRM</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-8">
            <!-- Step 1: Item Selection -->
            <div id="step-1-content" class="step-content bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-2xl font-bold text-primary tracking-tight">Select items to return</h3>
                    <span class="text-sm font-bold text-teal-600 bg-teal-50 px-3 py-1 rounded-full border border-teal-100"><?= count($activeRentals) ?> items active</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php if (empty($activeRentals)): ?>
                        <div class="col-span-2 py-12 text-center bg-slate-50 rounded-2xl border-2 border-dashed border-slate-100">
                            <span class="material-symbols-outlined text-4xl text-slate-200 mb-4">inventory_2</span>
                            <p class="text-slate-500 font-medium">No active rentals to return.</p>
                            <a href="browse.php" class="text-teal-600 font-bold mt-2 inline-block hover:underline">Browse Catalog</a>
                        </div>
                    <?php else: ?>
                        <?php foreach ($activeRentals as $rental): 
                            $product = $rental['products'];
                            $isSelected = $selectedId && (int)$rental['id'] === $selectedId;
                        ?>
                            <div class="rental-item relative border-2 <?= $isSelected ? 'border-secondary bg-white selected' : 'border-transparent bg-slate-50' ?> rounded-2xl p-5 flex gap-5 transition-all hover:border-secondary/30 hover:shadow-md group cursor-pointer" 
                                 onclick="toggleItemSelection(this, <?= $rental['id'] ?>)"
                                 data-id="<?= $rental['id'] ?>"
                                 data-name="<?= htmlspecialchars((string)($product['name'] ?? '')) ?>">
                                <div class="check-icon <?= $isSelected ? '' : 'hidden' ?> absolute top-4 right-4 w-6 h-6 bg-secondary rounded-full flex items-center justify-center shadow-lg shadow-secondary/20">
                                    <span class="material-symbols-outlined text-white text-sm">check</span>
                                </div>
                                <div class="w-24 h-24 rounded-xl overflow-hidden flex-shrink-0 bg-white border border-slate-100">
                                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" 
                                         src="<?= htmlspecialchars((string)($product['image_url'] ?? '')) ?>" 
                                         alt="<?= htmlspecialchars((string)($product['name'] ?? '')) ?>">
                                </div>
                                <div class="flex flex-col justify-center">
                                    <p class="text-[10px] font-bold text-secondary tracking-widest uppercase mb-1">FURNITURE</p>
                                    <h4 class="text-lg font-bold text-primary leading-tight"><?= htmlspecialchars((string)($product['name'] ?? '')) ?></h4>
                                    <p class="text-xs text-slate-400 font-medium mt-1 uppercase">Order #RE-<?= substr((string)$rental['id'], 0, 4) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Step 2: Condition -->
            <div id="step-2-content" class="step-content hidden bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                <h3 class="text-2xl font-bold text-primary mb-8 tracking-tight">Item Condition & Reason</h3>
                <div class="space-y-8">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">REASON FOR RETURN</label>
                        <select id="return-reason" class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-secondary/10 focus:border-secondary outline-none transition-all appearance-none text-slate-700 font-medium">
                            <option>Subscription period ended</option>
                            <option>Upgrading to a newer model</option>
                            <option>Relocating to a new city</option>
                            <option>No longer needed</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">CURRENT ITEM HEALTH</label>
                        <div class="grid grid-cols-3 gap-4">
                            <button onclick="selectCondition(this, 'Pristine')" class="condition-btn flex flex-col items-center p-6 border-2 border-secondary bg-secondary-container/5 rounded-2xl group transition-all" data-condition="Pristine">
                                <span class="material-symbols-outlined text-secondary text-3xl mb-2" style="font-variation-settings: 'FILL' 1;">sentiment_very_satisfied</span>
                                <span class="text-sm font-bold text-secondary">Pristine</span>
                            </button>
                            <button onclick="selectCondition(this, 'Minor Wear')" class="condition-btn flex flex-col items-center p-6 border-2 border-transparent bg-slate-50 hover:border-secondary/30 rounded-2xl group transition-all" data-condition="Minor Wear">
                                <span class="material-symbols-outlined text-slate-400 group-hover:text-secondary text-3xl mb-2">sentiment_neutral</span>
                                <span class="text-sm font-bold text-slate-500 group-hover:text-secondary">Minor Wear</span>
                            </button>
                            <button onclick="selectCondition(this, 'Damaged')" class="condition-btn flex flex-col items-center p-6 border-2 border-transparent bg-slate-50 hover:border-secondary/30 rounded-2xl group transition-all" data-condition="Damaged">
                                <span class="material-symbols-outlined text-slate-400 group-hover:text-secondary text-3xl mb-2">sentiment_very_dissatisfied</span>
                                <span class="text-sm font-bold text-slate-500 group-hover:text-secondary">Damaged</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Scheduling -->
            <div id="step-3-content" class="step-content hidden bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Calendar -->
                    <div>
                        <h3 class="text-xl font-bold text-primary mb-6 tracking-tight">Select Pickup Date</h3>
                        <div class="grid grid-cols-7 text-center gap-y-2 calendar-grid">
                            <?php foreach (['S','M','T','W','T','F','S'] as $day): ?>
                                <span class="text-[10px] font-bold text-slate-400 uppercase py-2"><?= $day ?></span>
                            <?php endforeach; ?>
                            <?php 
                            $today = (int)date('d');
                            for($i=1; $i<=31; $i++): 
                                $isPast = $i < $today + 1; // At least tomorrow
                                $dateStr = date('Y-m-') . str_pad((string)$i, 2, '0', STR_PAD_LEFT);
                            ?>
                                <div class="pickup-day py-3 font-bold text-sm transition-all rounded-xl cursor-pointer
                                    <?= $isPast ? 'text-slate-200 cursor-not-allowed' : 'text-slate-600 hover:bg-slate-50' ?>"
                                    data-date="<?= $dateStr ?>"
                                    <?= $isPast ? '' : 'onclick="selectPickupDate(this)"' ?>>
                                    <?= $i ?>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <!-- Time Slots -->
                    <div class="md:border-l border-slate-100 md:pl-8">
                        <h3 class="text-xl font-bold text-primary mb-6 tracking-tight">Pickup Window</h3>
                        <div class="space-y-3">
                            <button onclick="selectPickupTime(this)" data-slot="09:00 AM - 12:00 PM" class="pickup-time-btn w-full flex items-center justify-between p-4 border border-slate-100 rounded-2xl bg-white hover:border-secondary transition-all group">
                                <span class="text-sm font-bold text-primary">Morning (9am - 12pm)</span>
                                <span class="material-symbols-outlined text-slate-200 group-hover:text-secondary">radio_button_unchecked</span>
                            </button>
                            <button onclick="selectPickupTime(this)" data-slot="12:00 PM - 03:00 PM" class="pickup-time-btn w-full flex items-center justify-between p-4 border border-slate-100 rounded-2xl bg-white hover:border-secondary transition-all group">
                                <span class="text-sm font-bold text-primary">Afternoon (12pm - 3pm)</span>
                                <span class="material-symbols-outlined text-slate-200 group-hover:text-secondary">radio_button_unchecked</span>
                            </button>
                            <button onclick="selectPickupTime(this)" data-slot="03:00 PM - 06:00 PM" class="pickup-time-btn w-full flex items-center justify-between p-4 border border-slate-100 rounded-2xl bg-white hover:border-secondary transition-all group">
                                <span class="text-sm font-bold text-primary">Evening (3pm - 6pm)</span>
                                <span class="material-symbols-outlined text-slate-200 group-hover:text-secondary">radio_button_unchecked</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4: Confirm -->
            <div id="step-4-content" class="step-content hidden bg-white rounded-3xl shadow-sm border border-slate-100 p-8 text-center">
                <div class="w-20 h-20 bg-teal-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-teal-500 text-4xl">inventory_2</span>
                </div>
                <h3 class="text-2xl font-bold text-primary mb-6 tracking-tight">Ready to Return?</h3>
                <div class="max-w-md mx-auto space-y-4 text-left">
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">ITEMS TO RETURN</p>
                        <p id="confirm-items" class="text-sm font-bold text-primary">Selected Items</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">PICKUP SCHEDULE</p>
                        <p id="confirm-schedule" class="text-sm font-bold text-primary">Date & Time Slot</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">DEPOSIT REFUND</p>
                        <p class="text-sm font-bold text-teal-600 leading-relaxed">Your deposit will be processed within 5-7 business days after inspection.</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="mt-8 flex justify-between items-center">
                <button id="prev-btn" onclick="prevStep()" class="px-8 py-4 text-primary font-bold bg-white border border-slate-200 rounded-2xl hover:bg-slate-50 transition-all flex items-center gap-2 active:scale-95 shadow-sm hidden">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Back
                </button>
                <div class="flex-grow"></div>
                <button id="next-btn" onclick="nextStep()" class="px-10 py-4 bg-primary text-white font-bold rounded-2xl hover:opacity-95 transition-all flex items-center gap-2 active:scale-95 shadow-xl shadow-primary/20">
                    Next Step
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="lg:col-span-4 space-y-8">
            <!-- Return Tips -->
            <div class="bg-primary text-white p-8 rounded-3xl shadow-xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-teal-500/10 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="p-2 bg-teal-500/20 rounded-xl">
                        <span class="material-symbols-outlined text-teal-400" style="font-variation-settings: 'FILL' 1;">info</span>
                    </div>
                    <h4 class="text-2xl font-bold tracking-tight">Return Guide</h4>
                </div>
                <ul class="space-y-6 relative z-10">
                    <li class="flex gap-4">
                        <span class="material-symbols-outlined text-teal-400 mt-0.5">cleaning_services</span>
                        <p class="text-sm text-teal-100/70 leading-relaxed">Please vacuum upholstery and wipe down appliance surfaces to ensure a full deposit refund.</p>
                    </li>
                    <li class="flex gap-4">
                        <span class="material-symbols-outlined text-teal-400 mt-0.5">package_2</span>
                        <p class="text-sm text-teal-100/70 leading-relaxed">Remove all personal belongings from drawers and compartments before our team arrives.</p>
                    </li>
                    <li class="flex gap-4">
                        <span class="material-symbols-outlined text-teal-400 mt-0.5">payments</span>
                        <p class="text-sm text-teal-100/70 leading-relaxed">Deposits are typically processed and returned within 5-7 business days.</p>
                    </li>
                </ul>
            </div>

            <!-- Scheduling Widget Preview -->
            <div class="bg-white border border-slate-100 p-8 rounded-3xl shadow-sm text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-slate-300 text-3xl">calendar_today</span>
                </div>
                <h4 class="text-xl font-bold text-primary mb-2">Pickup Summary</h4>
                <div id="sidebar-summary" class="text-sm text-slate-400 leading-relaxed italic">
                    Start by selecting items you wish to return.
                </div>
            </div>
        </div>
    </div>
</main>

<script>
let currentStep = 1;
let selectedItems = [];
let selectedCondition = 'Pristine';
let pickupDate = null;
let pickupTime = null;

function toggleItemSelection(el, id) {
    el.classList.toggle('border-secondary');
    el.classList.toggle('bg-white');
    el.classList.toggle('selected');
    el.querySelector('.check-icon').classList.toggle('hidden');
    
    const index = selectedItems.indexOf(id);
    if (index === -1) {
        selectedItems.push(id);
    } else {
        selectedItems.splice(index, 1);
    }
}

function selectCondition(el, condition) {
    document.querySelectorAll('.condition-btn').forEach(btn => {
        btn.classList.remove('border-secondary', 'bg-secondary-container/5');
        btn.classList.add('border-transparent', 'bg-slate-50');
        btn.querySelector('.material-symbols-outlined').style.fontVariationSettings = "'FILL' 0";
        btn.querySelector('span:last-child').classList.remove('text-secondary');
        btn.querySelector('span:last-child').classList.add('text-slate-500');
    });
    
    el.classList.add('border-secondary', 'bg-secondary-container/5');
    el.classList.remove('border-transparent', 'bg-slate-50');
    el.querySelector('.material-symbols-outlined').style.fontVariationSettings = "'FILL' 1";
    el.querySelector('span:last-child').classList.add('text-secondary');
    el.querySelector('span:last-child').classList.remove('text-slate-500');
    
    selectedCondition = condition;
}

function selectPickupDate(el) {
    document.querySelectorAll('.pickup-day').forEach(d => d.classList.remove('bg-secondary', 'text-white', 'shadow-lg', 'scale-110'));
    el.classList.add('bg-secondary', 'text-white', 'shadow-lg', 'scale-110');
    pickupDate = el.dataset.date;
}

function selectPickupTime(el) {
    document.querySelectorAll('.pickup-time-btn').forEach(btn => {
        btn.classList.remove('border-secondary', 'bg-secondary/5');
        btn.querySelector('.material-symbols-outlined').textContent = 'radio_button_unchecked';
    });
    el.classList.add('border-secondary', 'bg-secondary/5');
    el.querySelector('.material-symbols-outlined').textContent = 'check_circle';
    pickupTime = el.dataset.slot;
}

function updateStepper() {
    document.querySelectorAll('.step-indicator').forEach(ind => {
        const step = parseInt(ind.dataset.step);
        const circle = ind.querySelector('.step-circle');
        const text = ind.querySelector('.step-text');
        
        if (step === currentStep) {
            circle.className = 'step-circle w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shadow-lg shadow-primary/20';
            text.className = 'step-text text-[10px] font-bold tracking-widest text-primary uppercase';
        } else if (step < currentStep) {
            circle.className = 'step-circle w-10 h-10 rounded-full bg-teal-500 text-white flex items-center justify-center font-bold shadow-lg shadow-teal-500/20';
            text.className = 'step-text text-[10px] font-bold tracking-widest text-teal-600 uppercase';
        } else {
            circle.className = 'step-circle w-10 h-10 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center font-bold';
            text.className = 'step-text text-[10px] font-bold tracking-widest text-slate-400 uppercase';
        }
    });
}

function nextStep() {
    if (currentStep === 1) {
        if (selectedItems.length === 0) {
            alert('Please select at least one item to return.');
            return;
        }
    }
    
    if (currentStep === 3) {
        if (!pickupDate || !pickupTime) {
            alert('Please select a pickup date and time window.');
            return;
        }
        
        // Prepare confirmation screen
        const names = Array.from(document.querySelectorAll('.rental-item.selected')).map(el => el.dataset.name).join(', ');
        document.getElementById('confirm-items').textContent = names;
        document.getElementById('confirm-schedule').textContent = `${new Date(pickupDate).toLocaleDateString()} at ${pickupTime}`;
    }
    
    if (currentStep === 4) {
        submitReturn();
        return;
    }

    document.getElementById(`step-${currentStep}-content`).classList.add('hidden');
    currentStep++;
    document.getElementById(`step-${currentStep}-content`).classList.remove('hidden');
    
    if (currentStep > 1) document.getElementById('prev-btn').classList.remove('hidden');
    if (currentStep === 4) document.getElementById('next-btn').innerHTML = 'Confirm Return <span class="material-symbols-outlined">check</span>';
    
    updateStepper();
    gsap.from(`#step-${currentStep}-content`, { opacity: 0, y: 10, duration: 0.4 });
}

function prevStep() {
    document.getElementById(`step-${currentStep}-content`).classList.add('hidden');
    currentStep--;
    document.getElementById(`step-${currentStep}-content`).classList.remove('hidden');
    
    if (currentStep === 1) document.getElementById('prev-btn').classList.add('hidden');
    document.getElementById('next-btn').innerHTML = 'Next Step <span class="material-symbols-outlined">arrow_forward</span>';
    
    updateStepper();
}

async function submitReturn() {
    const reason = document.getElementById('return-reason').value;
    const btn = document.getElementById('next-btn');
    btn.disabled = true;
    btn.innerHTML = '<span class="material-symbols-outlined animate-spin">sync</span> Submitting...';
    
    try {
        // We handle one item at a time for now to keep it simple with existing API
        // or loop through if needed. Let's do the first one selected for simplicity.
        const response = await fetch('api/logistics/return-pickup.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                rental_id: selectedItems[0],
                date: pickupDate,
                time_slot: pickupTime,
                condition: selectedCondition,
                reason: reason
            })
        });
        
        const result = await response.json();
        if (result.success) {
            window.location.href = 'dashboard.php?msg=return_scheduled';
        } else {
            alert(result.error || 'Failed to schedule return.');
            btn.disabled = false;
            btn.innerHTML = 'Confirm Return <span class="material-symbols-outlined">check</span>';
        }
    } catch (e) {
        console.error(e);
        alert('An unexpected error occurred.');
        btn.disabled = false;
        btn.innerHTML = 'Confirm Return <span class="material-symbols-outlined">check</span>';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    gsap.from('main > section, .grid > div', {
        opacity: 0,
        y: 20,
        duration: 0.8,
        stagger: 0.1,
        ease: 'power3.out'
    });
});
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>

