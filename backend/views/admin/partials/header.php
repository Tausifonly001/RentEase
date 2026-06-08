<?php
declare(strict_types=1);

/**
 * Admin/Vendor Shared Header Partial
 * This partial only contains the navigation bar to avoid double <html> tags.
 */

$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
?>
<nav class="sticky top-0 z-50 w-full border-b border-slate-200 bg-white/80 backdrop-blur-md">
    <div class="mx-auto max-w-7xl px-4 md:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="<?= baseUrl('/') ?>" class="group flex items-center gap-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-teal-600 text-white shadow-lg shadow-teal-200 transition-transform group-hover:scale-110">
                        <span class="material-symbols-outlined text-[20px]">rocket_launch</span>
                    </span>
                    <span class="text-xl font-black tracking-tighter text-slate-900">RentEase <span class="text-teal-600">Ops</span></span>
                </a>
            </div>

            <div class="flex items-center gap-6">
                <div class="hidden md:flex items-center gap-6 text-sm font-semibold text-slate-600">
                    <a href="<?= baseUrl('/admin') ?>" class="hover:text-teal-600 transition-colors">Admin</a>
                    <a href="<?= baseUrl('/vendor-panel') ?>" class="hover:text-teal-600 transition-colors">Vendor</a>
                    <a href="<?= baseUrl('/shop') ?>" class="hover:text-teal-600 transition-colors">Shop</a>
                </div>

                <div class="flex items-center gap-3 pl-6 border-l border-slate-200">
                    <a href="<?= baseUrl('/logout') ?>" class="flex items-center gap-2 px-4 py-2 rounded-full bg-slate-900 text-white text-xs font-bold uppercase tracking-widest hover:bg-teal-600 transition-all shadow-md active:scale-95">
                        <span class="material-symbols-outlined text-[16px]">logout</span>
                        Sign Out
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
