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
    <aside class="hidden md:flex w-64 flex-col p-4 gap-2" style="border-right-color: rgba(231,229,228,0.6); background: #FAFAF9;">
        <div class="mb-6 px-4 pt-4">
            <h2 class="text-lg font-normal text-ink">Settings</h2>
            <p class="text-xs text-muted font-light">Manage your rental experience</p>
        </div>
        <nav class="space-y-1">
            <a class="bg-champagne/10 text-champagne-dark px-4 py-3 flex items-center gap-3 transition-all" href="settings.php" style="border-radius: 0.5rem;">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">person</span>
                <span class="text-sm font-light">Profile</span>
            </a>
            <a class="text-muted px-4 py-3 flex items-center gap-3 hover:bg-canvas transition-all" href="coming-soon.php" style="border-radius: 0.5rem;">
                <span class="material-symbols-outlined">notifications</span>
                <span class="text-sm font-light">Notifications</span>
            </a>
            <a class="text-muted px-4 py-3 flex items-center gap-3 hover:bg-canvas transition-all" href="coming-soon.php" style="border-radius: 0.5rem;">
                <span class="material-symbols-outlined">security</span>
                <span class="text-sm font-light">Security</span>
            </a>
            <a class="text-muted px-4 py-3 flex items-center gap-3 hover:bg-canvas transition-all" href="payment-methods.php" style="border-radius: 0.5rem;">
                <span class="material-symbols-outlined">credit_card</span>
                <span class="text-sm font-light">Payment Methods</span>
            </a>
            <a class="text-muted px-4 py-3 flex items-center gap-3 hover:bg-canvas transition-all" href="coming-soon.php" style="border-radius: 0.5rem;">
                <span class="material-symbols-outlined">card_membership</span>
                <span class="text-sm font-light">Membership</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content Canvas -->
    <div class="flex-1 p-8 bg-surface">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <header class="mb-10">
                <h1 class="font-h1 text-4xl text-ink font-normal mb-2 tracking-tight">Account Settings</h1>
                <p class="text-body-lg text-muted">Update your personal details and manage your rental preferences.</p>
            </header>

            <!-- Bento Layout for Settings -->
            <div class="grid grid-cols-12 gap-8">
                <!-- Personal Information Section -->
                <section class="col-span-12 lg:col-span-8 bg-surface overflow-hidden" style="border-color: rgba(231,229,228,0.6);">
                    <form action="api/update-profile.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        
                        <div class="p-8">
                            <div class="flex items-center gap-3 mb-8">
                                <span class="material-symbols-outlined text-secondary">badge</span>
                                <h3 class="font-h3 text-xl font-normal text-ink">Personal Information</h3>
                            </div>
                            
                            <div class="flex flex-col md:flex-row gap-10 items-start">
                                <div class="relative group">
                                    <div class="w-32 h-32 rounded-full overflow-hidden border-4 bg-canvas relative" style="border-color: rgba(231,229,228,0.6);">
                                        <img alt="User Profile" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBDTBx_SEjGLvxThMGCvUA_WVCGvEhQgTIsz4Y-sYh_trCZc0eOxIzsy6RlzG0LCuV3pu3lo1X6kZTx27gdaXwDUhXebVksvM78wVheV2mmLzE9Db1yHGjk8F-dWuGdXQ1XsOsIAMJ_0lIgnicC0S3-OlojuldQTmoQsKTcQ25QKz-GDkvuQp29Ee1KqFjl3XJF_GgU2SJr665q9FggHMjQ5CGLcNVE1fn20YE4x9rJQu2g193CVOcj6jzcXdy9L1wiFra9G464l7JE"/>
                                        <div class="absolute inset-0 bg-ink/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer">
                                            <span class="material-symbols-outlined text-white">photo_camera</span>
                                        </div>
                                    </div>
                                    <button type="button" class="mt-4 text-champagne-dark text-xs font-light uppercase tracking-wider block text-center w-full hover:text-champagne-dark/80">Change Photo</button>
                                </div>
                                
                                <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                                    <div class="flex flex-col gap-2">
                                        <label class="text-[10px] font-normal text-muted uppercase tracking-widest">Full Name</label>
                                        <input name="full_name" class="bg-canvas border px-4 py-3 focus:border-secondary focus:ring-1 focus:ring-secondary outline-none transition-all text-sm font-light" type="text" value="<?= htmlspecialchars((string)($currentUser['user_metadata']['full_name'] ?? $currentUser['name'])) ?>" style="border-color: rgba(231,229,228,0.6);"/>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <label class="text-[10px] font-normal text-muted uppercase tracking-widest">Email Address</label>
                                        <input name="email" class="bg-canvas border px-4 py-3 text-muted outline-none text-sm cursor-not-allowed font-light" type="email" value="<?= htmlspecialchars((string)$currentUser['email']) ?>" readonly style="border-color: rgba(231,229,228,0.6);"/>
                                        <p class="text-[10px] text-muted-light mt-1">Email cannot be changed.</p>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <label class="text-[10px] font-normal text-muted uppercase tracking-widest">Phone Number</label>
                                        <input name="phone" class="bg-canvas border px-4 py-3 focus:border-secondary focus:ring-1 focus:ring-secondary outline-none transition-all text-sm font-light" type="tel" placeholder="+1 (555) 000-0000" style="border-color: rgba(231,229,228,0.6);"/>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <label class="text-[10px] font-normal text-muted uppercase tracking-widest">Date of Birth</label>
                                        <input name="dob" class="bg-canvas border px-4 py-3 focus:border-secondary focus:ring-1 focus:ring-secondary outline-none transition-all text-sm font-light" type="date" style="border-color: rgba(231,229,228,0.6);"/>
                                    </div>
                                    <div class="flex flex-col gap-2 md:col-span-2">
                                        <label class="text-[10px] font-normal text-muted uppercase tracking-widest">Delivery Address</label>
                                        <textarea name="address" class="bg-canvas border px-4 py-3 focus:border-secondary focus:ring-1 focus:ring-secondary outline-none transition-all text-sm font-light" rows="2" placeholder="Street Address, Apartment, Suite, etc." style="border-color: rgba(231,229,228,0.6);"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-canvas px-8 py-4 flex justify-end" style="border-top-color: rgba(231,229,228,0.6);">
                            <button type="submit" class="bg-ink text-white font-button px-8 py-2.5 active:scale-95 duration-150 hover:bg-ink/90 transition-all font-normal" style="border-radius: 0.5rem;">Save Changes</button>
                        </div>
                    </form>
                </section>

                <!-- Membership & Loyalty Card -->
                <section class="col-span-12 lg:col-span-4 flex flex-col gap-8">
                    <div class="bg-ink text-white p-8 relative overflow-hidden" style="border-radius: 0.75rem;">
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <span class="material-symbols-outlined text-8xl">stars</span>
                        </div>
                        <div class="relative z-10">
                            <span class="inline-block bg-secondary px-2 py-1 text-[10px] font-normal tracking-widest uppercase mb-4" style="border-radius: 0.25rem;">Current Plan</span>
                            <h3 class="text-3xl font-normal mb-1 tracking-tight">Premium Renter</h3>
                            <div class="flex items-center gap-2 text-champagne mb-8">
                                <span class="material-symbols-outlined text-sm font-light" style="font-variation-settings: 'FILL' 1;">verified</span>
                                <span class="text-xs font-light">Member since 2022</span>
                            </div>
                            <div class="flex justify-between items-end border-t border-white/20 pt-6">
                                <div>
                                    <p class="text-[10px] font-normal opacity-70 mb-1 uppercase tracking-widest">Loyalty Points</p>
                                    <p class="text-2xl font-normal">12,450 <span class="text-xs font-light opacity-60">pts</span></p>
                                </div>
                                <button class="text-champagne text-sm font-light hover:underline underline-offset-4">View Rewards</button>
                            </div>
                        </div>
                    </div>

                    <!-- Security Health Prompt -->
                    <div class="bg-canvas p-6" style="border-color: rgba(231,229,228,0.6); border-radius: 0.75rem;">
                        <div class="flex gap-4">
                            <div class="bg-champagne/10 p-2 h-fit" style="border-radius: 0.5rem;">
                                <span class="material-symbols-outlined text-champagne-dark">enhanced_encryption</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-light mb-1">Security Health</h4>
                                <p class="text-xs text-muted mb-4 leading-relaxed font-light">2FA is currently disabled. Enable it to secure your account and personal data.</p>
                                <button class="text-champagne-dark text-xs font-light flex items-center gap-1 hover:gap-2 transition-all">
                                    Enable now <span class="material-symbols-outlined text-sm font-light">arrow_forward</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Rental Preferences -->
                <section class="col-span-12 lg:col-span-7 bg-surface p-8" style="border-color: rgba(231,229,228,0.6);">
                    <div class="flex items-center gap-3 mb-8">
                        <span class="material-symbols-outlined text-secondary">settings_suggest</span>
                        <h3 class="font-h3 text-xl font-normal text-ink">Rental Preferences</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 hover:bg-canvas transition-colors border border-transparent hover:border-[rgba(231,229,228,0.6)]" style="border-radius: 0.5rem;">
                            <div class="flex gap-4">
                                <span class="material-symbols-outlined text-muted-light">payments</span>
                                <div>
                                    <p class="text-sm font-light text-ink">Payment Reminders</p>
                                    <p class="text-xs text-muted font-light">Get notified 3 days before your rental renewal</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input checked class="sr-only peer" type="checkbox"/>
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between p-4 hover:bg-canvas transition-colors border border-transparent hover:border-[rgba(231,229,228,0.6)]" style="border-radius: 0.5rem;">
                            <div class="flex gap-4">
                                <span class="material-symbols-outlined text-muted-light">local_shipping</span>
                                <div>
                                    <p class="text-sm font-light text-ink">Delivery & Collection Alerts</p>
                                    <p class="text-xs text-muted font-light">Live tracking for scheduled furniture arrivals</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input checked class="sr-only peer" type="checkbox"/>
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between p-4 hover:bg-canvas transition-colors border border-transparent hover:border-[rgba(231,229,228,0.6)]" style="border-radius: 0.5rem;">
                            <div class="flex gap-4">
                                <span class="material-symbols-outlined text-muted-light">build_circle</span>
                                <div>
                                    <p class="text-sm font-light text-ink">Maintenance Updates</p>
                                    <p class="text-xs text-muted font-light">Status updates on requested furniture repairs</p>
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
                <section class="col-span-12 lg:col-span-5 bg-surface p-8" style="border-color: rgba(231,229,228,0.6);">
                    <div class="flex items-center gap-3 mb-8">
                        <span class="material-symbols-outlined text-secondary">lock</span>
                        <h3 class="font-h3 text-xl font-normal text-ink">Security</h3>
                    </div>
                    <div class="space-y-4">
                        <button class="w-full flex items-center justify-between p-4 hover:border-secondary transition-all group" style="border-color: rgba(231,229,228,0.6); border-radius: 0.5rem;">
                            <div class="flex items-center gap-4">
                                <span class="material-symbols-outlined text-muted-light group-hover:text-secondary transition-colors">password</span>
                                <span class="text-sm font-light text-ink">Change Password</span>
                            </div>
                            <span class="material-symbols-outlined text-muted-light group-hover:text-secondary transition-colors">chevron_right</span>
                        </button>
                        <div class="bg-canvas p-6" style="border-radius: 0.5rem;">
                            <p class="text-[10px] font-normal text-muted uppercase tracking-widest mb-4">Active Sessions</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-green-500 text-[10px]" style="font-variation-settings: 'FILL' 1;">circle</span>
                                    <span class="text-xs font-light">This Device - Current Session</span>
                                </div>
                                <span class="text-[10px] text-muted-light uppercase font-normal">Active</span>
                            </div>
                        </div>
                        <button class="w-full text-rose text-sm font-light py-3 border hover:bg-rose/10 transition-all" style="border-color: rgba(231,229,228,0.6); border-radius: 0.5rem;">Sign Out from All Devices</button>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
