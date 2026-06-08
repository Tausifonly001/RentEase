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
 <aside class="hidden md:flex w-64 border-r border-border bg-surface flex-col p-4 gap-2">
 <div class="mb-6 px-4 pt-4">
 <h2 class="text-lg font-normal text-ink">Settings</h2>
 <p class="text-xs text-muted font-light">Manage your account & billing</p>
 </div>
 <nav class="space-y-1">
 <a class="text-ink px-4 py-3 flex items-center gap-3 hover:bg-canvas rounded-lg transition-all" href="settings.php">
 <span class="material-symbols-outlined">person</span>
 <span class="text-sm font-light">Profile Info</span>
 </a>
 <a class="bg-champagne/10 text-champagne-dark font-normal rounded-lg px-4 py-3 flex items-center gap-3 border-l-4 border-champagne-dark transition-all" href="payment-methods.php">
 <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">payments</span>
 <span class="text-sm font-light">Payment Methods</span>
 </a>
 <a class="text-ink px-4 py-3 flex items-center gap-3 hover:bg-canvas rounded-lg transition-all" href="<?= baseUrl('/dashboard') ?>">
 <span class="material-symbols-outlined">receipt_long</span>
 <span class="text-sm font-light">Rental History</span>
 </a>
 <a class="text-ink px-4 py-3 flex items-center gap-3 hover:bg-canvas rounded-lg transition-all" href="coming-soon.php">
 <span class="material-symbols-outlined">notifications</span>
 <span class="text-sm font-light">Notifications</span>
 </a>
 <a class="text-ink px-4 py-3 flex items-center gap-3 hover:bg-canvas rounded-lg transition-all" href="coming-soon.php">
 <span class="material-symbols-outlined">security</span>
 <span class="text-sm font-light">Security</span>
 </a>
 </nav>
 </aside>

 <!-- Main Content Area -->
 <main class="flex-1 p-8 bg-white">
 <div class="max-w-4xl mx-auto space-y-10">
 <!-- Saved Cards Grid -->
 <section>
 <div class="flex items-center justify-between mb-8">
 <h1 class="text-3xl font-normal text-ink tracking-tight">Payment Methods</h1>
 <button class="flex items-center gap-2 px-6 py-2.5 bg-champagne text-white rounded-lg font-normal hover:brightness-110 transition-all shadow-sm">
 <span class="material-symbols-outlined text-[20px]">add</span>
 Add New Method
 </button>
 </div>

 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <!-- Primary Card -->
 <div class="bg-white border-2 border-champagne/20 rounded-2xl p-6 shadow-sm relative overflow-hidden group">
 <div class="absolute top-4 right-4">
 <span class="bg-champagne/20 text-champagne-dark text-[10px] font-normal px-3 py-1 rounded-full uppercase tracking-widest">Primary</span>
 </div>
 <div class="flex flex-col h-full justify-between gap-12">
 <div class="flex justify-between items-start">
 <div class="w-12 h-8 bg-surface rounded flex items-center justify-center border border-border">
 <span class="material-symbols-outlined text-champagne-dark">credit_card</span>
 </div>
 <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
 <button class="text-muted-light hover:text-primary transition-colors"><span class="material-symbols-outlined text-[18px]">edit</span></button>
 <button class="text-muted-light hover:text-red-500 transition-colors"><span class="material-symbols-outlined text-[18px]">delete</span></button>
 </div>
 </div>
 <div>
 <p class="font-mono text-xl text-ink tracking-[0.2em] mb-2 font-normal">•••• •••• •••• 4242</p>
 <div class="flex justify-between items-end">
 <div>
 <p class="text-[10px] text-muted-light uppercase font-normal tracking-widest mb-1">Expires</p>
 <p class="text-sm font-light">12/26</p>
 </div>
 <p class="text-sm font-light text-muted-light">Visa Debit</p>
 </div>
 </div>
 </div>
 </div>

 <!-- Secondary Card -->
 <div class="bg-white border border-border rounded-2xl p-6 shadow-sm hover:border-teal-200 transition-colors group">
 <div class="flex flex-col h-full justify-between gap-12">
 <div class="flex justify-between items-start">
 <div class="w-12 h-8 bg-surface rounded flex items-center justify-center border border-border">
 <span class="material-symbols-outlined text-champagne">account_balance_wallet</span>
 </div>
 <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
 <button class="text-muted-light hover:text-primary transition-colors"><span class="material-symbols-outlined text-[18px]">edit</span></button>
 <button class="text-muted-light hover:text-red-500 transition-colors"><span class="material-symbols-outlined text-[18px]">delete</span></button>
 </div>
 </div>
 <div>
 <p class="font-mono text-xl text-ink tracking-[0.2em] mb-2 font-normal">•••• •••• •••• 8890</p>
 <div class="flex justify-between items-end">
 <div>
 <p class="text-[10px] text-muted-light uppercase font-normal tracking-widest mb-1">Expires</p>
 <p class="text-sm font-light">08/25</p>
 </div>
 <p class="text-sm font-light text-muted-light">Mastercard Credit</p>
 </div>
 </div>
 </div>
 </div>
 </div>
 </section>

 <!-- Auto-Pay Section -->
 <section class="bg-ink text-white rounded-2xl p-10 relative overflow-hidden shadow-xl">
 <div class="absolute -right-12 -bottom-12 opacity-10">
 <span class="material-symbols-outlined text-[200px]" style="font-variation-settings: 'wght' 200;">published_with_changes</span>
 </div>
 <div class="relative z-10 md:w-3/4">
 <h3 class="text-2xl font-normal mb-3 tracking-tight">Effortless Monthly Payments</h3>
 <p class="text-muted-light mb-8 leading-relaxed">Set up Auto-Pay to ensure your rentals are never interrupted. We'll automatically charge your primary card on the 1st of every month.</p>
 <div class="flex flex-wrap items-center gap-8">
 <div class="flex items-center">
 <button class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 focus:outline-none bg-champagne">
 <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
 </button>
 <span class="ml-3 text-sm font-light">Auto-Pay is ON</span>
 </div>
 <button class="text-white underline underline-offset-8 text-sm font-light hover:text-teal-400 transition-colors">Adjust charge date</button>
 </div>
 </div>
 </section>

 <!-- Billing History -->
 <section class="bg-white rounded-2xl border border-border overflow-hidden shadow-sm">
 <div class="px-8 py-5 border-b border-border flex items-center justify-between bg-surface">
 <h3 class="text-sm font-light text-ink uppercase tracking-widest">Recent Invoices</h3>
 <a class="text-champagne-dark text-xs font-light hover:underline underline-offset-4" href="<?= baseUrl('/dashboard') ?>">View All History</a>
 </div>
 <div class="divide-y divide-slate-100">
 <!-- Invoice 1 -->
 <div class="px-8 py-6 flex flex-wrap items-center justify-between gap-4 hover:bg-surface transition-colors">
 <div class="flex items-center gap-4">
 <div class="w-10 h-10 rounded-full bg-canvas flex items-center justify-center text-muted">
 <span class="material-symbols-outlined">description</span>
 </div>
 <div>
 <p class="font-normal text-ink">Invoice #RE-2024-008</p>
 <p class="text-xs text-muted-light font-light">Aug 01, 2024 • Monthly Subscription</p>
 </div>
 </div>
 <div class="flex items-center gap-8">
 <span class="font-normal text-ink">$184.50</span>
 <button class="flex items-center gap-2 text-champagne-dark hover:bg-teal-50 px-4 py-2 rounded-lg transition-all font-light text-sm">
 <span class="material-symbols-outlined text-[18px]">download</span>
 PDF
 </button>
 </div>
 </div>
 <!-- Invoice 2 -->
 <div class="px-8 py-6 flex flex-wrap items-center justify-between gap-4 hover:bg-surface transition-colors">
 <div class="flex items-center gap-4">
 <div class="w-10 h-10 rounded-full bg-canvas flex items-center justify-center text-muted">
 <span class="material-symbols-outlined">description</span>
 </div>
 <div>
 <p class="font-normal text-ink">Invoice #RE-2024-007</p>
 <p class="text-xs text-muted-light font-light">Jul 01, 2024 • Monthly Subscription</p>
 </div>
 </div>
 <div class="flex items-center gap-8">
 <span class="font-normal text-ink">$184.50</span>
 <button class="flex items-center gap-2 text-champagne-dark hover:bg-teal-50 px-4 py-2 rounded-lg transition-all font-light text-sm">
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
