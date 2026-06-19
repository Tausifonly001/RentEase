<?php
declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use RentEase\Services\AuthService;
use RentEase\Services\RentalService;

$authService = new AuthService($config);
$currentUser = null;
try {
 $token = $_COOKIE[$config['cookie_name'] ?? ''] ?? '';
 if ($token) {
 $currentUser = $authService->validateToken($token);
 }
} catch (Throwable $ignored) {}

if (!$currentUser) {
 header('Location: ' . baseUrl('/login'));
 exit;
}

$rentalService = new RentalService($config);
$activeRentals = $rentalService->getUserRentals((string)$currentUser['id']);

// Filter only active rentals
$activeRentals = array_filter($activeRentals, fn($r) => $r['status'] === 'active' || $r['status'] === 'delivered');

$pageTitle = "Request Maintenance | RentEase";
include_once __DIR__ . '/partials/header.php';
?>

<main class="pt-24 pb-20 px-4 md:px-8 max-w-4xl mx-auto min-h-screen">
 <!-- Header Section -->
 <div class="mb-12">
 <h1 class="text-4xl font-normal text-ink mb-2">Maintenance Request</h1>
 <p class="text-lg text-muted ">Tell us what's wrong and we'll send a technician to make it right.</p>
 </div>

 <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
 <!-- Form Canvas -->
 <section class="md:col-span-8 bg-white rounded-2xl p-8 shadow-sm border border-border ">
  <form id="maintenance-form" class="space-y-6">
  <!-- Rental Selection -->
  <div>
  <label class="block text-xs font-light text-muted uppercase tracking-widest mb-2">SELECT ACTIVE RENTAL</label>
  <div class="relative">
  <select name="rental_id" required class="w-full bg-surface border border-border rounded-xl p-4 focus:border-champagne focus:ring-1 focus:ring-champagne appearance-none text-ink ">
  <?php if (empty($activeRentals)): ?>
  <option disabled selected>No active rentals found</option>
  <?php else: ?>
  <option value="" disabled selected>Choose a rental item...</option>
  <?php foreach ($activeRentals as $rental): ?>
  <option value="<?= htmlspecialchars((string)$rental['id']) ?>">
  <?= htmlspecialchars($rental['product_name'] ?? 'Rental Item') ?>
  </option>
  <?php endforeach; ?>
  <?php endif; ?>
  </select>
  <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-muted-light">expand_more</span>
  </div>
  </div>

  <!-- Problem Description -->
  <div>
  <label class="block text-xs font-light text-muted uppercase tracking-widest mb-2">DESCRIPTION OF THE ISSUE</label>
  <textarea name="description" required class="w-full bg-surface border border-border rounded-xl p-4 focus:border-champagne focus:ring-1 focus:ring-champagne h-32 resize-none text-ink "
  placeholder="Please provide details about the problem..."></textarea>
  </div>

  <!-- Scheduling -->
  <div>
  <label class="block text-xs font-light text-muted uppercase tracking-widest mb-2">PREFERRED TIME SLOT</label>
  <div class="grid grid-cols-2 gap-4">
  <label class="relative cursor-pointer group">
  <input type="radio" name="time_slot" value="morning" class="peer sr-only" required>
  <div class="border border-border peer-checked:border-champagne peer-checked:bg-champagne/10 :bg-teal-900/10 rounded-xl p-4 flex items-center justify-center gap-2 text-ink peer-checked:text-champagne transition-all">
  <span class="material-symbols-outlined text-lg">today</span>
  <span class="text-sm font-light">Morning (8am-12pm)</span>
  </div>
  </label>
  <label class="relative cursor-pointer group">
  <input type="radio" name="time_slot" value="afternoon" class="peer sr-only">
  <div class="border border-border peer-checked:border-champagne peer-checked:bg-champagne/10 :bg-teal-900/10 rounded-xl p-4 flex items-center justify-center gap-2 text-ink peer-checked:text-champagne transition-all">
  <span class="material-symbols-outlined text-lg">event</span>
  <span class="text-sm font-light">Afternoon (12pm-5pm)</span>
  </div>
  </label>
  </div>
  </div>

  <!-- Submit Button -->
  <div class="pt-4">
  <button type="submit" class="w-full bg-ink text-white font-normal py-4 rounded-xl hover:opacity-90 active:scale-[0.98] transition-all shadow-lg">
  Submit Maintenance Request
  </button>
  </div>
  </form>
 </section>

 <!-- Sidebar Info -->
 <aside class="md:col-span-4 space-y-6">
 <div class="bg-champagne/10 rounded-2xl p-6 border border-champagne/20 ">
 <h3 class="text-xl font-normal text-champagne-dark mb-4">What happens next?</h3>
 <ul class="space-y-6">
 <li class="flex gap-4">
 <div class="h-8 w-8 bg-champagne-dark text-white rounded-full flex items-center justify-center flex-shrink-0 text-sm font-light">1</div>
 <p class="text-sm text-ink font-light">Our team reviews your request within 2 hours during business hours.</p>
 </li>
 <li class="flex gap-4">
 <div class="h-8 w-8 bg-champagne-dark text-white rounded-full flex items-center justify-center flex-shrink-0 text-sm font-light">2</div>
 <p class="text-sm text-ink font-light">A technician is assigned and your time slot is confirmed via SMS.</p>
 </li>
 <li class="flex gap-4">
 <div class="h-8 w-8 bg-champagne-dark text-white rounded-full flex items-center justify-center flex-shrink-0 text-sm font-light">3</div>
 <p class="text-sm text-ink font-light">Technician arrives and resolves the issue. No hidden repair fees for normal wear.</p>
 </li>
 </ul>
 </div>
 <div class="relative rounded-2xl overflow-hidden aspect-video shadow-md group">
 <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuCv8neQZ-cjhuHL8a8e4Axof2oZuAiu2efxW_uFqIvjiGqH3LMHbFffwX3R31dtR44ct_MS-xLfm9RoKuU1CvnjSws-HIB9G2XZC8v1By8lqoewRJ-wk8JTn3qBxkI_jhO1kvypWtmEMjeVQcLFNJr9JKMPiPWcUl3Ca96G6SbNAWFO0UTXgn4Mjhh104Eg3bBLEvO0CCpC-zKHUBdFnd0t_fNcwKWbj9IN5Li4KAhIxwRC2_27i2Y-Y4hZ2PrpCzbdquGbB3rH5nTI"
 alt="Maintenance Service" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
 <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex items-end p-6">
 <p class="text-white font-light text-sm">Professional care for all your rented essentials.</p>
 </div>
 </div>
 </aside>
 </div>
</main>

<input type="hidden" name="csrf_token" value="<?= \RentEase\Support\Csrf::token() ?>">

<script>
  document.getElementById('maintenance-form').addEventListener('submit', async (e) => {
  e.preventDefault();
  const form = e.target;
  const data = Object.fromEntries(new FormData(form));
  const btn = form.querySelector('button[type="submit"]');
  btn.disabled = true;
  btn.textContent = 'Submitting...';
  try {
  const res = await fetch('<?= baseUrl('/api/maintenance-request') ?>', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify(data)
  });
  const result = await res.json();
  if (res.ok) {
  window.location.href = '<?= baseUrl('/dashboard') ?>?maintenance=success';
  } else {
  alert(result.error || 'Failed to submit request.');
  }
  } catch {
  alert('Network error. Please try again.');
  } finally {
  btn.disabled = false;
  btn.textContent = 'Submit Maintenance Request';
  }
  });
</script>

<?php include_once __DIR__ . '/partials/footer.php'; ?>
