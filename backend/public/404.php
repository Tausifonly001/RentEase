<?php
declare(strict_types=1);

/**
 * 404 - Page Not Found
 */

$pageTitle = '404 — Page Not Found | RentEase';
$pageDescription = 'The page you are looking for could not be found.';

require __DIR__ . '/partials/header.php';
?>

<main class="flex-grow flex items-center justify-center px-4 py-20 page-fade">
    <div class="text-center max-w-2xl mx-auto">

        <!-- Hero illustration -->
        <div class="relative mb-12 inline-block">
            <!-- Soft halo behind -->
            <div class="absolute inset-0 -m-12 bg-gradient-to-br from-teal-500/20 via-emerald-500/10 to-transparent rounded-full blur-3xl"></div>

            <!-- Big 404 with depth -->
            <div class="relative">
                <h1 class="text-[10rem] md:text-[16rem] font-black leading-none tracking-tighter bg-gradient-to-br from-teal-500 via-teal-600 to-emerald-700 bg-clip-text text-transparent select-none">
                    404
                </h1>
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="w-24 h-24 md:w-32 md:h-32 rounded-3xl bg-white shadow-2xl shadow-teal-500/20 flex items-center justify-center rotate-6 hover:rotate-0 transition-transform duration-500">
                        <span class="material-symbols-outlined text-5xl md:text-6xl text-teal-600" style="font-variation-settings: 'FILL' 1;">explore_off</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copy -->
        <span class="badge badge-accent mb-5">Lost in the catalog</span>
        <h2 class="text-3xl md:text-5xl font-bold text-slate-900 mb-4 tracking-tight">We can't find that page</h2>
        <p class="text-slate-500 text-lg max-w-md mx-auto mb-12 leading-relaxed">
            The page you're looking for doesn't exist, was moved, or is temporarily unavailable. Let's get you back to the good stuff.
        </p>

        <!-- CTAs -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center items-center">
            <a href="<?= baseUrl('/') ?>" class="btn-pill btn-pill-lg group">
                <span class="material-symbols-outlined text-base">home</span>
                Back to Home
            </a>
            <a href="<?= baseUrl('/shop') ?>" class="btn-pill btn-pill-lg btn-pill-secondary group">
                <span class="material-symbols-outlined text-base">storefront</span>
                Browse Catalog
            </a>
        </div>

        <!-- Helpful links -->
        <div class="mt-16 pt-10 border-t border-slate-100">
            <p class="text-xs font-medium text-slate-400 uppercase tracking-widest mb-5">Or try these popular pages</p>
            <div class="flex flex-wrap justify-center gap-x-6 gap-y-3 text-sm">
                <a href="<?= baseUrl('/browse') ?>" class="text-slate-600 hover:text-teal-600 transition-colors font-medium">Furniture</a>
                <a href="<?= baseUrl('/how-it-works') ?>" class="text-slate-600 hover:text-teal-600 transition-colors font-medium">How it works</a>
                <a href="<?= baseUrl('/about') ?>" class="text-slate-600 hover:text-teal-600 transition-colors font-medium">About us</a>
                <a href="<?= baseUrl('/contact') ?>" class="text-slate-600 hover:text-teal-600 transition-colors font-medium">Contact support</a>
            </div>
        </div>
    </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
