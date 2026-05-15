<?php
/**
 * Reschedule Delivery/Pickup
 * 
 * Multi-step flow to change appointment dates and times.
 */

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

$activeDeliveries = [];
try {
    $activeDeliveries = $logisticsService->getUserDeliveries($currentUser['id'], $token);
} catch (Throwable $ignored) {}

$deliveryId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$delivery = null;

if ($deliveryId) {
    foreach ($activeDeliveries as $d) {
        if ((int)$d['id'] === $deliveryId) {
            $delivery = $d;
            break;
        }
    }
}

if (!$delivery && !empty($activeDeliveries)) {
    $delivery = $activeDeliveries[0];
}

$title = 'Reschedule Appointment | RentEase';
require_once __DIR__ . '/partials/header.php';
?>

<main class="max-w-7xl mx-auto px-8 py-16 grid grid-cols-1 lg:grid-cols-12 gap-8 min-h-screen">
    <!-- Main Content Area -->
    <div class="lg:col-span-8">
        <!-- Header: Current Appointment Details -->
        <section class="bg-white p-8 rounded-3xl shadow-sm mb-8 border border-slate-100">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div>
                    <span class="text-[10px] font-bold text-secondary uppercase tracking-[0.2em] mb-2 block">Current Schedule</span>
                    <h1 class="text-3xl md:text-4xl font-bold text-primary tracking-tight">Reschedule Delivery</h1>
                </div>
                <div class="flex gap-6 bg-slate-50 p-6 rounded-2xl border border-slate-100">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">calendar_today</span>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Date</p>
                            <p class="text-sm font-bold text-primary"><?= $delivery ? date('M d, Y', strtotime($delivery['scheduled_date'])) : 'Oct 24, 2024' ?></p>
                        </div>
                    </div>
                    <div class="w-px bg-slate-200 h-10 self-center"></div>
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">schedule</span>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Window</p>
                            <p class="text-sm font-bold text-primary"><?= $delivery ? htmlspecialchars((string)($delivery['time_slot'] ?? '09:00 - 12:00')) : '09:00 - 12:00' ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stepper Navigation -->
        <nav class="flex items-center justify-between mb-12 px-8">
            <div class="flex flex-col items-center gap-2 relative step-indicator" data-step="1">
                <div class="step-circle w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold z-10 shadow-lg shadow-primary/20">1</div>
                <span class="step-text text-[10px] font-bold tracking-widest text-primary uppercase">New Date/Time</span>
                <div class="absolute top-5 left-1/2 w-full h-[2px] bg-slate-100 -z-0"></div>
            </div>
            <div class="flex flex-col items-center gap-2 relative step-indicator" data-step="2">
                <div class="step-circle w-10 h-10 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center font-bold z-10">2</div>
                <span class="step-text text-[10px] font-bold tracking-widest text-slate-400 uppercase">Reason</span>
                <div class="absolute top-5 left-1/2 w-full h-[2px] bg-slate-100 -z-0"></div>
            </div>
            <div class="flex flex-col items-center gap-2 step-indicator" data-step="3">
                <div class="step-circle w-10 h-10 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center font-bold z-10">3</div>
                <span class="step-text text-[10px] font-bold tracking-widest text-slate-400 uppercase">Confirmation</span>
            </div>
        </nav>

        <!-- Step 1: Interactive Calendar & Time Slots -->
        <div id="step-1-content" class="step-content grid grid-cols-1 md:grid-cols-2 gap-8 bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
            <!-- Calendar Section -->
            <div>
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-bold text-primary tracking-tight"><?= date('F Y') ?></h3>
                    <div class="flex gap-2">
                        <button class="p-2 rounded-xl hover:bg-slate-50 transition-all"><span class="material-symbols-outlined text-slate-400">chevron_left</span></button>
                        <button class="p-2 rounded-xl hover:bg-slate-50 transition-all"><span class="material-symbols-outlined text-slate-400">chevron_right</span></button>
                    </div>
                </div>
                <div class="grid grid-cols-7 text-center gap-y-3 calendar-grid">
                    <?php foreach (['S','M','T','W','T','F','S'] as $day): ?>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest py-2"><?= $day ?></span>
                    <?php endforeach; ?>
                    
                    <?php 
                    $today = (int)date('d');
                    for($i=1; $i<=31; $i++): 
                        $isPast = $i < $today;
                        $isCurrentAppt = $delivery && $i == (int)date('d', strtotime($delivery['scheduled_date']));
                        $dateStr = date('Y-m-') . str_pad((string)$i, 2, '0', STR_PAD_LEFT);
                    ?>
                        <div class="calendar-day py-3 font-bold text-sm transition-all rounded-xl cursor-pointer relative group
                            <?= $isPast ? 'text-slate-200 cursor-not-allowed' : 'text-slate-600 hover:bg-slate-50' ?>
                            <?= $isCurrentAppt ? 'text-primary border-2 border-primary' : '' ?>"
                            data-date="<?= $dateStr ?>"
                            <?= $isPast ? '' : 'onclick="selectDate(this)"' ?>>
                            <?= $i ?>
                            <?php if ($isCurrentAppt): ?>
                                <div class="absolute bottom-1 left-1/2 -translate-x-1/2 w-1 h-1 bg-primary rounded-full"></div>
                            <?php endif; ?>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Time Slot Selector -->
            <div class="md:border-l border-slate-100 md:pl-8">
                <h3 class="text-xl font-bold text-primary tracking-tight mb-8">Select Time Window</h3>
                <div class="space-y-6 time-slots">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Morning</p>
                        <div class="space-y-3">
                            <button onclick="selectTimeSlot(this)" data-slot="08:00 AM - 11:00 AM" class="time-slot-btn w-full flex items-center justify-between p-4 border border-slate-100 rounded-2xl bg-white hover:border-secondary transition-all group active:scale-95">
                                <span class="text-sm font-bold text-primary">08:00 AM - 11:00 AM</span>
                                <span class="material-symbols-outlined text-slate-200 group-hover:text-secondary">radio_button_unchecked</span>
                            </button>
                            <button onclick="selectTimeSlot(this)" data-slot="09:00 AM - 12:00 PM" class="time-slot-btn w-full flex items-center justify-between p-4 border border-slate-100 rounded-2xl bg-white hover:border-secondary transition-all group active:scale-95">
                                <span class="text-sm font-bold text-primary">09:00 AM - 12:00 PM</span>
                                <span class="material-symbols-outlined text-slate-200 group-hover:text-secondary">radio_button_unchecked</span>
                            </button>
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Afternoon</p>
                        <div class="space-y-3">
                            <button onclick="selectTimeSlot(this)" data-slot="12:00 PM - 03:00 PM" class="time-slot-btn w-full flex items-center justify-between p-4 border border-slate-100 rounded-2xl bg-white hover:border-secondary transition-all group active:scale-95">
                                <span class="text-sm font-bold text-primary">12:00 PM - 03:00 PM</span>
                                <span class="material-symbols-outlined text-slate-200 group-hover:text-secondary">radio_button_unchecked</span>
                            </button>
                            <button class="w-full flex items-center justify-between p-4 border border-slate-100 rounded-2xl bg-slate-50 opacity-50 cursor-not-allowed">
                                <span class="text-sm font-bold text-slate-400">03:00 PM - 06:00 PM</span>
                                <span class="text-[10px] font-bold text-error uppercase tracking-widest">Fully Booked</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Reason -->
        <div id="step-2-content" class="step-content hidden bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
            <h3 class="text-2xl font-bold text-primary mb-8 tracking-tight">Reason for Rescheduling</h3>
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">SELECT REASON</label>
                    <select id="reschedule-reason" class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-secondary/10 focus:border-secondary outline-none transition-all text-slate-700 font-medium">
                        <option value="Personal emergency">Personal emergency</option>
                        <option value="Work conflict">Work conflict</option>
                        <option value="Travel plans changed">Travel plans changed</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">ADDITIONAL NOTES (OPTIONAL)</label>
                    <textarea id="additional-notes" rows="4" class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-secondary/10 focus:border-secondary outline-none transition-all text-slate-700 font-medium" placeholder="Anything else we should know?"></textarea>
                </div>
            </div>
        </div>

        <!-- Step 3: Confirmation -->
        <div id="step-3-content" class="step-content hidden bg-white p-8 rounded-3xl shadow-sm border border-slate-100 text-center">
            <div class="w-20 h-20 bg-teal-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="material-symbols-outlined text-teal-500 text-4xl">check_circle</span>
            </div>
            <h3 class="text-2xl font-bold text-primary mb-4 tracking-tight">Review New Schedule</h3>
            <div class="max-w-md mx-auto bg-slate-50 p-6 rounded-2xl border border-slate-100 mb-8">
                <div class="flex justify-between mb-4">
                    <span class="text-slate-400 font-medium">New Date</span>
                    <span id="summary-date" class="font-bold text-primary">Oct 28, 2024</span>
                </div>
                <div class="flex justify-between mb-4">
                    <span class="text-slate-400 font-medium">Time Window</span>
                    <span id="summary-time" class="font-bold text-primary">09:00 AM - 12:00 PM</span>
                </div>
                <div class="flex justify-between pt-4 border-t border-slate-200">
                    <span class="text-slate-400 font-medium">Service Fee</span>
                    <span class="font-bold text-secondary">$0.00</span>
                </div>
            </div>
            <p class="text-sm text-slate-500 leading-relaxed italic">By confirming, you agree to our rescheduling policy.</p>
        </div>

        <!-- Navigation Buttons -->
        <div class="mt-8 flex justify-between items-center">
            <button onclick="window.location.href='dashboard.php'" class="px-8 py-4 font-bold text-primary bg-white border border-slate-200 rounded-2xl hover:bg-slate-50 transition-all active:scale-95 shadow-sm">
                Cancel
            </button>
            <div class="flex gap-4">
                <button id="prev-btn" onclick="prevStep()" class="px-8 py-4 font-bold text-slate-400 opacity-50 cursor-not-allowed hidden">
                    Previous
                </button>
                <button id="next-btn" onclick="nextStep()" class="px-12 py-4 font-bold bg-primary text-white rounded-2xl shadow-xl shadow-primary/20 hover:opacity-95 transition-all active:scale-95">
                    Next Step
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar: Policies -->
    <aside class="lg:col-span-4 space-y-8">
        <div class="bg-primary text-white p-8 rounded-3xl shadow-xl relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-32 h-32 bg-teal-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-1000"></div>
            <h3 class="text-2xl font-bold mb-6 tracking-tight">Policies</h3>
            <ul class="space-y-6 relative z-10">
                <li class="flex items-start gap-4">
                    <span class="material-symbols-outlined text-teal-400 mt-1">info</span>
                    <p class="text-sm text-teal-100/70 leading-relaxed">Cancellations or rescheduling requires at least **24-hour notice**.</p>
                </li>
                <li class="flex items-start gap-4">
                    <span class="material-symbols-outlined text-teal-400 mt-1">payments</span>
                    <p class="text-sm text-teal-100/70 leading-relaxed">One complimentary reschedule is allowed per rental item.</p>
                </li>
                <li class="flex items-start gap-4">
                    <span class="material-symbols-outlined text-teal-400 mt-1">history</span>
                    <p class="text-sm text-teal-100/70 leading-relaxed">Rescheduling within 12 hours may incur a small **$25 service fee**.</p>
                </li>
            </ul>
        </div>

        <?php if ($delivery): ?>
        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
            <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">Item Being Delivered</h4>
            <div class="flex gap-4 items-center">
                <div class="w-20 h-20 bg-slate-50 rounded-2xl overflow-hidden border border-slate-100 shrink-0">
                    <img class="w-full h-full object-cover" 
                         src="<?= htmlspecialchars((string)($delivery['rentals']['products']['image_url'] ?? '')) ?>" 
                         alt="Product"/>
                </div>
                <div>
                    <p class="text-base font-bold text-primary leading-tight"><?= htmlspecialchars((string)($delivery['rentals']['products']['name'] ?? 'Product')) ?></p>
                    <p class="text-xs text-slate-400 font-medium mt-1">Order #RE-<?= substr((string)($delivery['order_id'] ?? ''), -5) ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="bg-slate-50 p-8 rounded-3xl border-2 border-dashed border-slate-200 flex flex-col items-center text-center">
            <span class="material-symbols-outlined text-slate-300 text-4xl mb-4" style="font-variation-settings: 'opsz' 48;">support_agent</span>
            <p class="text-sm text-slate-500 font-medium mb-4">Need help with your delivery?</p>
            <a class="text-secondary font-bold hover:underline" href="concierge.php">Chat with Support</a>
        </div>
    </aside>
</main>

<script>
let currentStep = 1;
let selectedDate = null;
let selectedTime = null;
const deliveryId = <?= json_encode($deliveryId) ?>;

function selectDate(el) {
    document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('bg-secondary', 'text-white', 'shadow-lg', 'shadow-secondary/20', 'scale-110'));
    el.classList.add('bg-secondary', 'text-white', 'shadow-lg', 'shadow-secondary/20', 'scale-110');
    selectedDate = el.dataset.date;
}

function selectTimeSlot(el) {
    document.querySelectorAll('.time-slot-btn').forEach(btn => {
        btn.classList.remove('border-2', 'border-secondary', 'bg-secondary/5', 'shadow-sm');
        btn.classList.add('border-slate-100', 'bg-white');
        btn.querySelector('.material-symbols-outlined').textContent = 'radio_button_unchecked';
        btn.querySelector('.material-symbols-outlined').style.fontVariationSettings = "'FILL' 0";
    });
    
    el.classList.add('border-2', 'border-secondary', 'bg-secondary/5', 'shadow-sm');
    el.classList.remove('border-slate-100', 'bg-white');
    el.querySelector('.material-symbols-outlined').textContent = 'check_circle';
    el.querySelector('.material-symbols-outlined').style.fontVariationSettings = "'FILL' 1";
    selectedTime = el.dataset.slot;
}

function updateStepper() {
    document.querySelectorAll('.step-indicator').forEach(ind => {
        const step = parseInt(ind.dataset.step);
        const circle = ind.querySelector('.step-circle');
        const text = ind.querySelector('.step-text');
        
        if (step === currentStep) {
            circle.className = 'step-circle w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold z-10 shadow-lg shadow-primary/20';
            text.className = 'step-text text-[10px] font-bold tracking-widest text-primary uppercase';
        } else if (step < currentStep) {
            circle.className = 'step-circle w-10 h-10 rounded-full bg-teal-500 text-white flex items-center justify-center font-bold z-10 shadow-lg shadow-teal-500/20';
            text.className = 'step-text text-[10px] font-bold tracking-widest text-teal-600 uppercase';
        } else {
            circle.className = 'step-circle w-10 h-10 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center font-bold z-10';
            text.className = 'step-text text-[10px] font-bold tracking-widest text-slate-400 uppercase';
        }
    });
}

function nextStep() {
    if (currentStep === 1) {
        if (!selectedDate || !selectedTime) {
            alert('Please select both a date and a time slot.');
            return;
        }
        document.getElementById('summary-date').textContent = new Date(selectedDate).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        document.getElementById('summary-time').textContent = selectedTime;
    }
    
    if (currentStep === 3) {
        submitReschedule();
        return;
    }

    document.getElementById(`step-${currentStep}-content`).classList.add('hidden');
    currentStep++;
    document.getElementById(`step-${currentStep}-content`).classList.remove('hidden');
    
    if (currentStep > 1) document.getElementById('prev-btn').classList.remove('hidden');
    if (currentStep === 3) document.getElementById('next-btn').textContent = 'Confirm Changes';
    
    updateStepper();
    
    gsap.from(`#step-${currentStep}-content`, {
        opacity: 0,
        x: 20,
        duration: 0.5,
        ease: 'power3.out'
    });
}

function prevStep() {
    document.getElementById(`step-${currentStep}-content`).classList.add('hidden');
    currentStep--;
    document.getElementById(`step-${currentStep}-content`).classList.remove('hidden');
    
    if (currentStep === 1) document.getElementById('prev-btn').classList.add('hidden');
    document.getElementById('next-btn').textContent = 'Next Step';
    
    updateStepper();
    
    gsap.from(`#step-${currentStep}-content`, {
        opacity: 0,
        x: -20,
        duration: 0.5,
        ease: 'power3.out'
    });
}

async function submitReschedule() {
    const reason = document.getElementById('reschedule-reason').value;
    const notes = document.getElementById('additional-notes').value;
    
    const btn = document.getElementById('next-btn');
    btn.disabled = true;
    btn.innerHTML = '<span class="material-symbols-outlined animate-spin">sync</span> Processing...';
    
    try {
        const response = await fetch('api/logistics/reschedule.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                delivery_id: deliveryId,
                date: selectedDate,
                time_slot: selectedTime,
                reason: reason + (notes ? ': ' + notes : '')
            })
        });
        
        const result = await response.json();
        if (result.success) {
            window.location.href = 'dashboard.php?msg=reschedule_success';
        } else {
            alert(result.error || 'Failed to reschedule.');
            btn.disabled = false;
            btn.textContent = 'Confirm Changes';
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An unexpected error occurred.');
        btn.disabled = false;
        btn.textContent = 'Confirm Changes';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    gsap.from('main > div, aside > div', {
        opacity: 0,
        y: 20,
        duration: 0.8,
        stagger: 0.1,
        ease: 'power3.out'
    });
});
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>

