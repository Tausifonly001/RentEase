<?php
/**
 * Coming Soon / Placeholder Page
 * 
 * Used for features currently in development to provide a better user experience than a 404.
 */

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

$pageTitle = 'Coming Soon - RentEase';
require_once __DIR__ . '/partials/header.php';
?>

<main class="flex-grow flex items-center justify-center py-20 px-6">
    <div class="max-w-2xl w-full text-center reveal-element">
        <div class="relative inline-block mb-12">
            <div class="w-32 h-32 bg-teal-50 rounded-[2.5rem] flex items-center justify-center mx-auto shadow-xl shadow-teal-500/10 rotate-12">
                <span class="material-symbols-outlined text-6xl text-teal-600 -rotate-12">rocket_launch</span>
            </div>
            <div class="absolute -top-4 -right-4 w-12 h-12 bg-primary rounded-2xl flex items-center justify-center shadow-lg animate-bounce">
                <span class="material-symbols-outlined text-white">star</span>
            </div>
        </div>

        <h1 class="text-5xl font-bold text-primary mb-6 tracking-tight">Something Big is Coming!</h1>
        <p class="text-xl text-slate-500 mb-12 leading-relaxed font-medium">We're working hard to bring you this feature. Our team of designers and engineers is currently polishing the final details to ensure a premium experience.</p>

        <div class="flex flex-col md:flex-row gap-4 justify-center items-center">
            <a href="<?= baseUrl('/dashboard') ?>" class="w-full md:w-auto px-10 py-4 bg-primary text-white font-bold rounded-2xl shadow-xl shadow-primary/20 hover:opacity-95 transition-all active:scale-95 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined">dashboard</span>
                Back to Dashboard
            </a>
            <a href="browse.php" class="w-full md:w-auto px-10 py-4 bg-white border-2 border-slate-100 text-slate-600 font-bold rounded-2xl hover:bg-slate-50 transition-all active:scale-95 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined">search</span>
                Browse Furniture
            </a>
        </div>

        <div class="mt-20 pt-10 border-t border-slate-100 flex flex-col items-center">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em] mb-6">Stay Updated</p>
            <div class="flex gap-4">
                <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-primary transition-colors cursor-pointer">
                    <i class="fa-brands fa-twitter"></i>
                </div>
                <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-primary transition-colors cursor-pointer">
                    <i class="fa-brands fa-instagram"></i>
                </div>
                <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-primary transition-colors cursor-pointer">
                    <i class="fa-brands fa-linkedin-in"></i>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    gsap.from('.reveal-element', {
        opacity: 0,
        y: 40,
        duration: 1.2,
        ease: 'power4.out'
    });
});
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
