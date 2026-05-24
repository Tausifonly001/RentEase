<?php
/**
 * Payment Methods & Billing
 * 
 * Manages user cards and rental invoices.
 */

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

$pageTitle = 'Payment Methods - RentEase';
require_once __DIR__ . '/partials/header.php';

// Redirect to login if not authenticated
if (!$currentUser) {
    header('Location: ' . baseUrl('/login'));
    exit;
}
?>

<div class="max-w-7xl mx-auto flex min-h-screen">
    <!-- SideNavBar (Secondary Contextual Nav) -->
    <aside class="hidden md:flex w-64 border-r border-slate-200 bg-slate-50 flex-col p-4 gap-2">
        <div class="mb-6 px-4 pt-4">
            <h2 class="text-lg font-bold text-slate-900">Settings</h2>
            <p class="text-xs text-slate-500">Manage your account & billing</p>
        </div>
        <nav class="space-y-1">
            <a class="text-slate-600 px-4 py-3 flex items-center gap-3 hover:bg-slate-100 rounded-lg transition-all" href="settings.php">
                <span class="material-symbols-outlined">person</span>
                <span class="text-sm">Profile Info</span>
            </a>
            <a class="bg-teal-50 text-teal-700 font-semibold rounded-lg px-4 py-3 flex items-center gap-3 border-l-4 border-teal-600 transition-all" href="payment-methods.php">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">payments</span>
                <span class="text-sm">Payment Methods</span>
            </a>
            <a class="text-slate-600 px-4 py-3 flex items-center gap-3 hover:bg-slate-100 rounded-lg transition-all" href="<?= baseUrl('/dashboard') ?>">
                <span class="material-symbols-outlined">receipt_long</span>
                <span class="text-sm">Rental History</span>
            </a>
            <a class="text-slate-600 px-4 py-3 flex items-center gap-3 hover:bg-slate-100 rounded-lg transition-all" href="coming-soon.php">
                <span class="material-symbols-outlined">notifications</span>
                <span class="text-sm">Notifications</span>
            </a>
            <a class="text-slate-600 px-4 py-3 flex items-center gap-3 hover:bg-slate-100 rounded-lg transition-all" href="coming-soon.php">
                <span class="material-symbols-outlined">security</span>
                <span class="text-sm">Security</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 p-8 bg-white">
        <div class="max-w-4xl mx-auto space-y-10">
            <!-- Saved Cards Grid -->
            <section>
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-3xl font-bold text-primary tracking-tight">Payment Methods</h1>
                    <button class="flex items-center gap-2 px-6 py-2.5 bg-secondary text-white rounded-lg font-semibold hover:brightness-110 transition-all shadow-sm">
                        <span class="material-symbols-outlined text-[20px]">add</span>
                        Add New Method
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Primary Card -->
                    <div class="bg-white border-2 border-teal-100 rounded-2xl p-6 shadow-sm relative overflow-hidden group">
                        <div class="absolute top-4 right-4">
                            <span class="bg-teal-100 text-teal-800 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">Primary</span>
                        </div>
                        <div class="flex flex-col h-full justify-between gap-12">
                            <div class="flex justify-between items-start">
                                <div class="w-12 h-8 bg-slate-50 rounded flex items-center justify-center border border-slate-100">
                                    <span class="material-symbols-outlined text-blue-600">credit_card</span>
                                </div>
                                <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button class="text-slate-400 hover:text-primary transition-colors"><span class="material-symbols-outlined text-[18px]">edit</span></button>
                                    <button class="text-slate-400 hover:text-red-500 transition-colors"><span class="material-symbols-outlined text-[18px]">delete</span></button>
                                </div>
                            </div>
                            <div>
                                <p class="font-mono text-xl text-primary tracking-[0.2em] mb-2 font-medium">•••• •••• •••• 4242</p>
                                <div class="flex justify-between items-end">
                                    <div>
                                        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-widest mb-1">Expires</p>
                                        <p class="text-sm font-bold">12/26</p>
                                    </div>
                                    <p class="text-sm font-bold text-slate-400">Visa Debit</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Secondary Card -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:border-teal-200 transition-colors group">
                        <div class="flex flex-col h-full justify-between gap-12">
                            <div class="flex justify-between items-start">
                                <div class="w-12 h-8 bg-slate-50 rounded flex items-center justify-center border border-slate-100">
                                    <span class="material-symbols-outlined text-orange-500">account_balance_wallet</span>
                                </div>
                                <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button class="text-slate-400 hover:text-primary transition-colors"><span class="material-symbols-outlined text-[18px]">edit</span></button>
                                    <button class="text-slate-400 hover:text-red-500 transition-colors"><span class="material-symbols-outlined text-[18px]">delete</span></button>
                                </div>
                            </div>
                            <div>
                                <p class="font-mono text-xl text-primary tracking-[0.2em] mb-2 font-medium">•••• •••• •••• 8890</p>
                                <div class="flex justify-between items-end">
                                    <div>
                                        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-widest mb-1">Expires</p>
                                        <p class="text-sm font-bold">08/25</p>
                                    </div>
                                    <p class="text-sm font-bold text-slate-400">Mastercard Credit</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Auto-Pay Section -->
            <section class="bg-primary text-white rounded-2xl p-10 relative overflow-hidden shadow-xl">
                <div class="absolute -right-12 -bottom-12 opacity-10">
                    <span class="material-symbols-outlined text-[200px]" style="font-variation-settings: 'wght' 200;">published_with_changes</span>
                </div>
                <div class="relative z-10 md:w-3/4">
                    <h3 class="text-2xl font-bold mb-3 tracking-tight">Effortless Monthly Payments</h3>
                    <p class="text-slate-300 mb-8 leading-relaxed">Set up Auto-Pay to ensure your rentals are never interrupted. We'll automatically charge your primary card on the 1st of every month.</p>
                    <div class="flex flex-wrap items-center gap-8">
                        <div class="flex items-center">
                            <button class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 focus:outline-none bg-secondary">
                                <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                            <span class="ml-3 text-sm font-bold">Auto-Pay is ON</span>
                        </div>
                        <button class="text-white underline underline-offset-8 text-sm font-semibold hover:text-teal-400 transition-colors">Adjust charge date</button>
                    </div>
                </div>
            </section>

            <!-- Billing History -->
            <section class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="text-sm font-bold text-primary uppercase tracking-widest">Recent Invoices</h3>
                    <a class="text-teal-600 text-xs font-bold hover:underline underline-offset-4" href="<?= baseUrl('/dashboard') ?>">View All History</a>
                </div>
                <div class="divide-y divide-slate-100">
                    <!-- Invoice 1 -->
                    <div class="px-8 py-6 flex flex-wrap items-center justify-between gap-4 hover:bg-slate-50/50 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                                <span class="material-symbols-outlined">description</span>
                            </div>
                            <div>
                                <p class="font-bold text-primary">Invoice #RE-2024-008</p>
                                <p class="text-xs text-slate-400">Aug 01, 2024 • Monthly Subscription</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-8">
                            <span class="font-bold text-primary">$184.50</span>
                            <button class="flex items-center gap-2 text-teal-600 hover:bg-teal-50 px-4 py-2 rounded-lg transition-all font-semibold text-sm">
                                <span class="material-symbols-outlined text-[18px]">download</span>
                                PDF
                            </button>
                        </div>
                    </div>
                    <!-- Invoice 2 -->
                    <div class="px-8 py-6 flex flex-wrap items-center justify-between gap-4 hover:bg-slate-50/50 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                                <span class="material-symbols-outlined">description</span>
                            </div>
                            <div>
                                <p class="font-bold text-primary">Invoice #RE-2024-007</p>
                                <p class="text-xs text-slate-400">Jul 01, 2024 • Monthly Subscription</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-8">
                            <span class="font-bold text-primary">$184.50</span>
                            <button class="flex items-center gap-2 text-teal-600 hover:bg-teal-50 px-4 py-2 rounded-lg transition-all font-semibold text-sm">
                                <span class="material-symbols-outlined text-[18px]">download</span>
                                PDF
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
