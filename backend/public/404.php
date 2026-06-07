<?php
declare(strict_types=1);

/**
 * 404 - Page Not Found
 *
 * UX-003: Styled 404 page with navigation back to home.
 */

$pageTitle = '404 — Page Not Found | RentEase';
$pageDescription = 'The page you are looking for could not be found.';

require __DIR__ . '/partials/header.php';
?>

<main class="flex-grow flex items-center justify-center py-xl px-4">
    <div class="text-center max-w-lg mx-auto">
        <div class="relative mb-8">
            <span class="text-[10rem] md:text-[14rem] font-normal text-surface-container-high leading-none select-none">404</span>
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="material-symbols-outlined text-6xl md:text-8xl text-secondary opacity-60" style="font-variation-settings: 'FILL' 1;">explore_off</span>
            </div>
        </div>

        <h1 class="font-h2 text-h2 text-primary mb-4">Page Not Found</h1>
        <p class="font-body-md text-body-md text-on-surface-variant mb-8 max-w-md mx-auto">
            The page you're looking for doesn't exist or may have been moved.
            Let's get you back on track.
        </p>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="<?= baseUrl('/') ?>"
                class="bg-primary text-on-primary font-button text-button px-6 py-3 rounded-DEFAULT hover:bg-opacity-90 transition-all shadow-ambient-low hover:shadow-ambient-high inline-flex items-center justify-center gap-2 focus-visible:ring-2 ring-teal-500 outline-none">
                <span class="material-symbols-outlined text-lg">home</span>
                Back to Home
            </a>
            <a href="<?= baseUrl('/shop') ?>"
                class="border border-secondary text-secondary font-button text-button px-6 py-3 rounded-DEFAULT hover:bg-surface-container transition-all inline-flex items-center justify-center gap-2 focus-visible:ring-2 ring-teal-500 outline-none">
                <span class="material-symbols-outlined text-lg">storefront</span>
                Browse Catalog
            </a>
        </div>
    </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
