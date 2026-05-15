<?php
declare(strict_types=1);

require __DIR__ . '/../bootstrap.php';

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
    header('Location: login.php');
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
        <h1 class="text-4xl font-bold text-slate-900 dark:text-white mb-2">Maintenance Request</h1>
        <p class="text-lg text-slate-500 dark:text-slate-400">Tell us what's wrong and we'll send a technician to make it right.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
        <!-- Form Canvas -->
        <section class="md:col-span-8 bg-white dark:bg-slate-900 rounded-2xl p-8 shadow-sm border border-slate-200 dark:border-slate-800">
            <form action="api/maintenance/create.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                <!-- Rental Selection -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">SELECT ACTIVE RENTAL</label>
                    <div class="relative">
                        <select name="rental_id" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-4 focus:border-teal-600 focus:ring-1 focus:ring-teal-600 appearance-none text-slate-900 dark:text-white">
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
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                    </div>
                </div>

                <!-- Problem Description -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">DESCRIPTION OF THE ISSUE</label>
                    <textarea name="description" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-4 focus:border-teal-600 focus:ring-1 focus:ring-teal-600 h-32 resize-none text-slate-900 dark:text-white" 
                              placeholder="Please provide details about the problem..."></textarea>
                </div>

                <!-- Photo Upload -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">UPLOAD PHOTOS</label>
                    <div class="border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-2xl p-8 text-center flex flex-col items-center justify-center space-y-2 hover:border-teal-600 transition-colors cursor-pointer group">
                        <span class="material-symbols-outlined text-4xl text-slate-400 group-hover:text-teal-600 transition-colors">cloud_upload</span>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Click to <span class="text-teal-600 font-bold">browse</span> or drag and drop images</p>
                        <p class="text-xs text-slate-400">Supports JPG, PNG up to 10MB</p>
                        <input type="file" name="photos[]" multiple class="hidden" id="photo-upload">
                    </div>
                </div>

                <!-- Scheduling -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">PREFERRED TIME SLOT</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="time_slot" value="morning" class="peer sr-only" required>
                            <div class="border border-slate-200 dark:border-slate-700 peer-checked:border-teal-600 peer-checked:bg-teal-50 dark:peer-checked:bg-teal-900/10 rounded-xl p-4 flex items-center justify-center gap-2 text-slate-600 dark:text-slate-400 peer-checked:text-teal-600 transition-all">
                                <span class="material-symbols-outlined text-lg">today</span>
                                <span class="text-sm font-bold">Morning (8am-12pm)</span>
                            </div>
                        </label>
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="time_slot" value="afternoon" class="peer sr-only">
                            <div class="border border-slate-200 dark:border-slate-700 peer-checked:border-teal-600 peer-checked:bg-teal-50 dark:peer-checked:bg-teal-900/10 rounded-xl p-4 flex items-center justify-center gap-2 text-slate-600 dark:text-slate-400 peer-checked:text-teal-600 transition-all">
                                <span class="material-symbols-outlined text-lg">event</span>
                                <span class="text-sm font-bold">Afternoon (12pm-5pm)</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" class="w-full bg-[#041627] dark:bg-teal-600 text-white font-bold py-4 rounded-xl hover:opacity-90 active:scale-[0.98] transition-all shadow-lg">
                        Submit Maintenance Request
                    </button>
                </div>
            </form>
        </section>

        <!-- Sidebar Info -->
        <aside class="md:col-span-4 space-y-6">
            <div class="bg-teal-50 dark:bg-teal-900/10 rounded-2xl p-6 border border-teal-100 dark:border-teal-800/30">
                <h3 class="text-xl font-bold text-teal-900 dark:text-teal-100 mb-4">What happens next?</h3>
                <ul class="space-y-6">
                    <li class="flex gap-4">
                        <div class="h-8 w-8 bg-teal-600 text-white rounded-full flex items-center justify-center flex-shrink-0 text-sm font-bold">1</div>
                        <p class="text-sm text-slate-700 dark:text-slate-300">Our team reviews your request within 2 hours during business hours.</p>
                    </li>
                    <li class="flex gap-4">
                        <div class="h-8 w-8 bg-teal-600 text-white rounded-full flex items-center justify-center flex-shrink-0 text-sm font-bold">2</div>
                        <p class="text-sm text-slate-700 dark:text-slate-300">A technician is assigned and your time slot is confirmed via SMS.</p>
                    </li>
                    <li class="flex gap-4">
                        <div class="h-8 w-8 bg-teal-600 text-white rounded-full flex items-center justify-center flex-shrink-0 text-sm font-bold">3</div>
                        <p class="text-sm text-slate-700 dark:text-slate-300">Technician arrives and resolves the issue. No hidden repair fees for normal wear.</p>
                    </li>
                </ul>
            </div>
            <div class="relative rounded-2xl overflow-hidden aspect-video shadow-md group">
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuCv8neQZ-cjhuHL8a8e4Axof2oZuAiu2efxW_uFqIvjiGqH3LMHbFffwX3R31dtR44ct_MS-xLfm9RoKuU1CvnjSws-HIB9G2XZC8v1By8lqoewRJ-wk8JTn3qBxkI_jhO1kvypWtmEMjeVQcLFNJr9JKMPiPWcUl3Ca96G6SbNAWFO0UTXgn4Mjhh104Eg3bBLEvO0CCpC-zKHUBdFnd0t_fNcwKWbj9IN5Li4KAhIxwRC2_27i2Y-Y4hZ2PrpCzbdquGbB3rH5nTI" 
                     alt="Maintenance Service" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex items-end p-6">
                    <p class="text-white font-bold text-sm">Professional care for all your rented essentials.</p>
                </div>
            </div>
        </aside>
    </div>
</main>

<script>
    document.querySelector('.border-dashed').addEventListener('click', () => {
        document.getElementById('photo-upload').click();
    });
</script>

<?php include_once __DIR__ . '/partials/footer.php'; ?>
