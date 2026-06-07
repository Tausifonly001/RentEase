<?php
/**
 * User Profile Settings
 * 
 * Allows users to update their personal information and preferences.
 */

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../src/Support/Csrf.php';

use RentEase\Support\Csrf;

$pageTitle = 'Account Settings - RentEase';
require_once __DIR__ . '/partials/header.php';

// Redirect to login if not authenticated
if (!$currentUser) {
    header('Location: ' . baseUrl('/login'));
    exit;
}

$csrfToken = Csrf::token();
?>

<div class="max-w-7xl mx-auto flex min-h-screen">
    <!-- SideNavBar (Secondary Contextual Nav) -->
    <aside class="hidden md:flex w-64 border-r border-slate-200 bg-slate-50 flex-col p-4 gap-2">
        <div class="mb-6 px-4 pt-4">
            <h2 class="text-lg font-normal text-slate-900">Settings</h2>
            <p class="text-xs text-slate-500 font-light">Manage your rental experience</p>
        </div>
        <nav class="space-y-1">
            <a class="bg-teal-50 text-teal-700 font-normal rounded-lg px-4 py-3 flex items-center gap-3 transition-all" href="settings.php">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">person</span>
                <span class="text-sm font-light">Profile</span>
            </a>
            <a class="text-slate-600 px-4 py-3 flex items-center gap-3 hover:bg-slate-100 rounded-lg transition-all" href="coming-soon.php">
                <span class="material-symbols-outlined">notifications</span>
                <span class="text-sm font-light">Notifications</span>
            </a>
            <a class="text-slate-600 px-4 py-3 flex items-center gap-3 hover:bg-slate-100 rounded-lg transition-all" href="coming-soon.php">
                <span class="material-symbols-outlined">security</span>
                <span class="text-sm font-light">Security</span>
            </a>
            <a class="text-slate-600 px-4 py-3 flex items-center gap-3 hover:bg-slate-100 rounded-lg transition-all" href="payment-methods.php">
                <span class="material-symbols-outlined">credit_card</span>
                <span class="text-sm font-light">Payment Methods</span>
            </a>
            <a class="text-slate-600 px-4 py-3 flex items-center gap-3 hover:bg-slate-100 rounded-lg transition-all" href="coming-soon.php">
                <span class="material-symbols-outlined">card_membership</span>
                <span class="text-sm font-light">Membership</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content Canvas -->
    <div class="flex-1 p-8 bg-white">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <header class="mb-10">
                <h1 class="font-h1 text-4xl text-primary font-normal mb-2 tracking-tight">Account Settings</h1>
                <p class="text-body-lg text-slate-500">Update your personal details and manage your rental preferences.</p>
            </header>

            <!-- Bento Layout for Settings -->
            <div class="grid grid-cols-12 gap-8">
                <!-- Personal Information Section -->
                <section class="col-span-12 lg:col-span-8 bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                    <form action="api/update-profile.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        
                        <div class="p-8">
                            <div class="flex items-center gap-3 mb-8">
                                <span class="material-symbols-outlined text-secondary">badge</span>
                                <h3 class="font-h3 text-xl font-normal text-primary">Personal Information</h3>
                            </div>
                            
                            <div class="flex flex-col md:flex-row gap-10 items-start">
                                <div class="relative group">
                                    <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-slate-50 bg-slate-100 relative">
                                        <img alt="User Profile" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBDTBx_SEjGLvxThMGCvUA_WVCGvEhQgTIsz4Y-sYh_trCZc0eOxIzsy6RlzG0LCuV3pu3lo1X6kZTx27gdaXwDUhXebVksvM78wVheV2mmLzE9Db1yHGjk8F-dWuGdXQ1XsOsIAMJ_0lIgnicC0S3-OlojuldQTmoQsKTcQ25QKz-GDkvuQp29Ee1KqFjl3XJF_GgU2SJr665q9FggHMjQ5CGLcNVE1fn20YE4x9rJQu2g193CVOcj6jzcXdy9L1wiFra9G464l7JE"/>
                                        <div class="absolute inset-0 bg-primary/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer">
                                            <span class="material-symbols-outlined text-white">photo_camera</span>
                                        </div>
                                    </div>
                                    <button type="button" class="mt-4 text-teal-600 text-xs font-light uppercase tracking-wider block text-center w-full hover:text-teal-700">Change Photo</button>
                                </div>
                                
                                <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                                    <div class="flex flex-col gap-2">
                                        <label class="text-[10px] font-normal text-slate-500 uppercase tracking-widest">Full Name</label>
                                        <input name="full_name" class="bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 focus:border-secondary focus:ring-1 focus:ring-secondary outline-none transition-all text-sm font-light" type="text" value="<?= htmlspecialchars((string)($currentUser['user_metadata']['full_name'] ?? $currentUser['name'])) ?>"/>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <label class="text-[10px] font-normal text-slate-500 uppercase tracking-widest">Email Address</label>
                                        <input name="email" class="bg-slate-100 border border-slate-200 rounded-lg px-4 py-3 text-slate-500 outline-none text-sm cursor-not-allowed font-light" type="email" value="<?= htmlspecialchars((string)$currentUser['email']) ?>" readonly/>
                                        <p class="text-[10px] text-slate-400 mt-1">Email cannot be changed.</p>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <label class="text-[10px] font-normal text-slate-500 uppercase tracking-widest">Phone Number</label>
                                        <input name="phone" class="bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 focus:border-secondary focus:ring-1 focus:ring-secondary outline-none transition-all text-sm font-light" type="tel" placeholder="+1 (555) 000-0000"/>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <label class="text-[10px] font-normal text-slate-500 uppercase tracking-widest">Date of Birth</label>
                                        <input name="dob" class="bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 focus:border-secondary focus:ring-1 focus:ring-secondary outline-none transition-all text-sm font-light" type="date"/>
                                    </div>
                                    <div class="flex flex-col gap-2 md:col-span-2">
                                        <label class="text-[10px] font-normal text-slate-500 uppercase tracking-widest">Delivery Address</label>
                                        <textarea name="address" class="bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 focus:border-secondary focus:ring-1 focus:ring-secondary outline-none transition-all text-sm font-light" rows="2" placeholder="Street Address, Apartment, Suite, etc."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50 px-8 py-4 flex justify-end border-t border-slate-100">
                            <button type="submit" class="bg-primary text-white font-button px-8 py-2.5 rounded-lg active:scale-95 duration-150 hover:bg-primary/90 transition-all font-normal">Save Changes</button>
                        </div>
                    </form>
                </section>

                <!-- Membership & Loyalty Card -->
                <section class="col-span-12 lg:col-span-4 flex flex-col gap-8">
                    <div class="bg-primary text-white rounded-xl shadow-lg p-8 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <span class="material-symbols-outlined text-8xl">stars</span>
                        </div>
                        <div class="relative z-10">
                            <span class="inline-block bg-secondary px-2 py-1 rounded text-[10px] font-normal tracking-widest uppercase mb-4">Current Plan</span>
                            <h3 class="text-3xl font-normal mb-1 tracking-tight">Premium Renter</h3>
                            <div class="flex items-center gap-2 text-teal-400 mb-8">
                                <span class="material-symbols-outlined text-sm font-light" style="font-variation-settings: 'FILL' 1;">verified</span>
                                <span class="text-xs font-light">Member since 2022</span>
                            </div>
                            <div class="flex justify-between items-end border-t border-white/20 pt-6">
                                <div>
                                    <p class="text-[10px] font-normal opacity-70 mb-1 uppercase tracking-widest">Loyalty Points</p>
                                    <p class="text-2xl font-normal">12,450 <span class="text-xs font-light opacity-60">pts</span></p>
                                </div>
                                <button class="text-teal-400 text-sm font-light hover:underline underline-offset-4">View Rewards</button>
                            </div>
                        </div>
                    </div>

                    <!-- Security Health Prompt -->
                    <div class="bg-slate-50 rounded-xl p-6 border border-slate-200">
                        <div class="flex gap-4">
                            <div class="bg-teal-100 p-2 rounded-lg h-fit">
                                <span class="material-symbols-outlined text-teal-700">enhanced_encryption</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-light mb-1">Security Health</h4>
                                <p class="text-xs text-slate-500 mb-4 leading-relaxed font-light">2FA is currently disabled. Enable it to secure your account and personal data.</p>
                                <button class="text-teal-600 text-xs font-light flex items-center gap-1 hover:gap-2 transition-all">
                                    Enable now <span class="material-symbols-outlined text-sm font-light">arrow_forward</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Rental Preferences -->
                <section class="col-span-12 lg:col-span-7 bg-white rounded-xl shadow-sm border border-slate-100 p-8">
                    <div class="flex items-center gap-3 mb-8">
                        <span class="material-symbols-outlined text-secondary">settings_suggest</span>
                        <h3 class="font-h3 text-xl font-normal text-primary">Rental Preferences</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 rounded-lg hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                            <div class="flex gap-4">
                                <span class="material-symbols-outlined text-slate-400">payments</span>
                                <div>
                                    <p class="text-sm font-light text-primary">Payment Reminders</p>
                                    <p class="text-xs text-slate-500 font-light">Get notified 3 days before your rental renewal</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input checked class="sr-only peer" type="checkbox"/>
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between p-4 rounded-lg hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                            <div class="flex gap-4">
                                <span class="material-symbols-outlined text-slate-400">local_shipping</span>
                                <div>
                                    <p class="text-sm font-light text-primary">Delivery & Collection Alerts</p>
                                    <p class="text-xs text-slate-500 font-light">Live tracking for scheduled furniture arrivals</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input checked class="sr-only peer" type="checkbox"/>
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between p-4 rounded-lg hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                            <div class="flex gap-4">
                                <span class="material-symbols-outlined text-slate-400">build_circle</span>
                                <div>
                                    <p class="text-sm font-light text-primary">Maintenance Updates</p>
                                    <p class="text-xs text-slate-500 font-light">Status updates on requested furniture repairs</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input class="sr-only peer" type="checkbox"/>
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
                            </label>
                        </div>
                    </div>
                </section>

                <!-- Security Quick View -->
                <section class="col-span-12 lg:col-span-5 bg-white rounded-xl shadow-sm border border-slate-100 p-8">
                    <div class="flex items-center gap-3 mb-8">
                        <span class="material-symbols-outlined text-secondary">lock</span>
                        <h3 class="font-h3 text-xl font-normal text-primary">Security</h3>
                    </div>
                    <div class="space-y-4">
                        <button class="w-full flex items-center justify-between p-4 border border-slate-200 rounded-lg hover:border-secondary transition-all group">
                            <div class="flex items-center gap-4">
                                <span class="material-symbols-outlined text-slate-400 group-hover:text-secondary transition-colors">password</span>
                                <span class="text-sm font-light text-primary">Change Password</span>
                            </div>
                            <span class="material-symbols-outlined text-slate-300 group-hover:text-secondary transition-colors">chevron_right</span>
                        </button>
                        <div class="bg-slate-50 p-6 rounded-lg">
                            <p class="text-[10px] font-normal text-slate-500 uppercase tracking-widest mb-4">Active Sessions</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-green-500 text-[10px]" style="font-variation-settings: 'FILL' 1;">circle</span>
                                    <span class="text-xs font-light">This Device - Current Session</span>
                                </div>
                                <span class="text-[10px] text-slate-400 uppercase font-normal">Active</span>
                            </div>
                        </div>
                        <button class="w-full text-red-500 text-sm font-light py-3 border border-red-100 rounded-lg hover:bg-red-50 transition-all">Sign Out from All Devices</button>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
