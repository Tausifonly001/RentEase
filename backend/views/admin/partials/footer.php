<?php
declare(strict_types=1);
/**
 * Admin/Vendor Shared Footer Partial
 */
?>
<footer class="mt-auto py-8 border-t border-slate-200 bg-white/50">
    <div class="mx-auto max-w-7xl px-4 md:px-8 flex flex-col md:flex-row justify-between items-center gap-4 text-slate-400 text-xs font-bold uppercase tracking-widest">
        <div class="flex items-center gap-2">
            <span class="text-teal-600">RentEase</span> &copy; <?= date('Y') ?> Operations Control
        </div>
        <div class="flex gap-6">
            <a href="#" class="hover:text-teal-600 transition-colors">Privacy</a>
            <a href="#" class="hover:text-teal-600 transition-colors">Support</a>
            <a href="#" class="hover:text-teal-600 transition-colors">Security</a>
        </div>
    </div>
</footer>
