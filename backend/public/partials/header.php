<?php
declare(strict_types=1);

use RentEase\Services\AuthService;

/** @var array $config */
if (!isset($config)) {
    $config = require_once __DIR__ . '/../../config/config.php';
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$currentUser = null;
$token = $_COOKIE[$config['cookie_name'] ?? ''] ?? '';
$cachedToken = $_SESSION['_auth_cached_token'] ?? '';
$cacheExpiry = $_SESSION['_auth_cache_expiry'] ?? 0;

if ($token !== '' && $token === $cachedToken && time() < $cacheExpiry && !empty($_SESSION['_auth_cached_user'])) {
    $currentUser = $_SESSION['_auth_cached_user'];
} else {
    try {
        if ($token !== '') {
            $authService = new AuthService($config);
            $userData = $authService->validateToken($token);
            if ($userData) {
                $currentUser = $userData;
                $currentUser['name'] = $userData['user_metadata']['full_name']
                    ?? $userData['name']
                    ?? explode('@', $userData['email'])[0]
                    ?? 'User';

                $_SESSION['_auth_cached_user'] = $currentUser;
                $_SESSION['_auth_cached_token'] = $token;
                $_SESSION['_auth_cache_expiry'] = time() + 300;
            } else {
                unset($_SESSION['_auth_cached_user'], $_SESSION['_auth_cached_token'], $_SESSION['_auth_cache_expiry']);
            }
        } else {
            unset($_SESSION['_auth_cached_user'], $_SESSION['_auth_cached_token'], $_SESSION['_auth_cache_expiry']);
        }
    } catch (Throwable $ignored) {
        unset($_SESSION['_auth_cached_user'], $_SESSION['_auth_cached_token'], $_SESSION['_auth_cache_expiry']);
    }
}

$cartCount = 0;
if (!empty($_SESSION['cart'])) {
    $cartCount = count($_SESSION['cart']);
}

$pageTitle = $pageTitle ?? 'RentEase — Premium Furniture & Appliance Rentals';
$pageDescription = $pageDescription ?? 'Rent premium furniture and appliances with flexible monthly plans. Free delivery, easy returns, zero commitment.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, viewport-fit=cover" name="viewport">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#fafaf9">
    <link rel="icon" type="image/svg+xml" href="<?= baseUrl('/favicon.svg') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#18181B',
                        'ink-soft': '#27272A',
                        muted: '#78716C',
                        'muted-light': '#A8A29E',
                        canvas: '#FAFAF9',
                        champagne: '#C5A98B',
                        'champagne-light': '#D4C5B0',
                        'champagne-dark': '#A8886E',
                        rose: '#D4A59A',
                        'rose-light': '#E8CBC4',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                }
            }
        }
    </script>
    <link rel="stylesheet" href="<?= baseUrl('/assets/css/theme.css') ?>">
    <style>
        .text-mask { overflow: hidden; display: inline-block; vertical-align: bottom; padding-bottom: 0.1em; margin-bottom: -0.1em; }
        .text-mask-inner { display: inline-block; transform: translateY(100%); }
        .clip-reveal { clip-path: inset(0 100% 0 0); }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js" defer></script>
    <script src="<?= baseUrl('/assets/js/theme.js') ?>" defer></script>
</head>
<body class="bg-canvas text-ink font-sans antialiased min-h-screen flex flex-col selection:bg-champagne/20 selection:text-champagne-dark overflow-x-hidden">

<!-- Scroll Progress Bar -->
<div class="scroll-progress" aria-hidden="true">
    <div class="scroll-progress-bar" id="scroll-progress-bar"></div>
</div>

<!-- Mobile Overlay -->
<div id="mobile-overlay" class="hidden fixed inset-0 bg-ink/20 backdrop-blur-sm z-40 md:hidden" aria-hidden="true"></div>

<!-- Navigation -->
<nav id="main-nav" class="fixed w-full top-0 z-50 bg-canvas/80 backdrop-blur-md border-b border-border transition-all duration-300" style="border-color: rgba(231,229,228,0.6);">
    <div class="flex justify-between items-center h-20 px-6 md:px-12 w-full max-w-[1600px] mx-auto">
        <a href="<?= baseUrl('/') ?>" class="inline-flex items-center gap-3 text-2xl font-serif font-bold text-ink tracking-tighter hover:opacity-70 transition-opacity duration-300 outline-none focus-visible:ring-1 ring-champagne group">
            <span class="w-9 h-9 flex items-center justify-center bg-ink text-white text-sm font-medium group-hover:bg-champagne transition-colors duration-500">R</span>
            RentEase.
        </a>

        <div class="hidden md:flex gap-12 items-center h-full">
            <a href="<?= baseUrl('/shop?category=Furniture') ?>" class="text-[11px] text-muted hover:text-ink transition-colors duration-300 font-medium tracking-[0.2em] uppercase outline-none focus-visible:text-ink relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1px] after:bg-champagne after:transition-all after:duration-500 hover:after:w-full">Furniture</a>
            <a href="<?= baseUrl('/shop?category=Appliances') ?>" class="text-[11px] text-muted hover:text-ink transition-colors duration-300 font-medium tracking-[0.2em] uppercase outline-none focus-visible:text-ink relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1px] after:bg-champagne after:transition-all after:duration-500 hover:after:w-full">Appliances</a>
            <a href="<?= baseUrl('/shop') ?>" class="text-[11px] text-muted hover:text-ink transition-colors duration-300 font-medium tracking-[0.2em] uppercase outline-none focus-visible:text-ink relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1px] after:bg-champagne after:transition-all after:duration-500 hover:after:w-full">Packages</a>
            <a href="<?= baseUrl('/#how-it-works') ?>" class="text-[11px] text-muted hover:text-ink transition-colors duration-300 font-medium tracking-[0.2em] uppercase outline-none focus-visible:text-ink relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1px] after:bg-champagne after:transition-all after:duration-500 hover:after:w-full">How it Works</a>
        </div>

        <div class="hidden md:flex gap-6 items-center">
            <a href="<?= baseUrl('/cart') ?>" aria-label="Shopping bag" class="relative text-ink hover:opacity-60 transition-opacity duration-300 outline-none focus-visible:opacity-60 group">
                <span class="material-symbols-outlined text-[22px] font-light">shopping_bag</span>
                <?php if ($cartCount > 0): ?>
                    <span class="absolute -top-1.5 -right-2 bg-ink text-white text-[9px] font-medium h-4 w-4 flex items-center justify-center"><?= $cartCount ?></span>
                <?php endif; ?>
            </a>

            <?php
                $profileLink = '/login';
                if ($currentUser) {
                    $role = AuthService::resolveRole($currentUser);
                    $profileLink = ($role === 'admin') ? '/admin' : (($role === 'vendor') ? '/vendor-panel' : '/dashboard');
                }
            ?>
            <a href="<?= baseUrl($profileLink) ?>" aria-label="Profile" class="text-ink hover:opacity-60 transition-opacity duration-300 outline-none focus-visible:opacity-60">
                <span class="material-symbols-outlined text-[22px] font-light">person</span>
            </a>

            <?php if (!$currentUser): ?>
                <a href="<?= baseUrl('/login') ?>" class="px-6 py-2.5 bg-ink text-white text-[10px] font-medium tracking-[0.2em] uppercase transition-all duration-500 hover:bg-champagne hover:text-ink outline-none focus-visible:ring-1 ring-champagne">Sign In</a>
            <?php endif; ?>
        </div>

        <button id="mobile-menu-btn" aria-label="Toggle Menu" class="md:hidden text-ink hover:opacity-60 focus:outline-none transition-opacity duration-300">
            <span class="material-symbols-outlined text-[26px] font-light">menu</span>
        </button>
    </div>

    <div id="mobile-nav" class="hidden fixed top-20 left-0 w-full bg-canvas/98 backdrop-blur-md px-6 py-8 flex-col gap-1 shadow-xl border-b border-border" style="border-color: rgba(231,229,228,0.6);">
        <a href="<?= baseUrl('/shop?category=Furniture') ?>" class="text-sm text-muted hover:text-ink tracking-[0.15em] uppercase transition-colors py-4 border-b border-border" style="border-color: rgba(231,229,228,0.4);">Furniture</a>
        <a href="<?= baseUrl('/shop?category=Appliances') ?>" class="text-sm text-muted hover:text-ink tracking-[0.15em] uppercase transition-colors py-4 border-b border-border" style="border-color: rgba(231,229,228,0.4);">Appliances</a>
        <a href="<?= baseUrl('/shop') ?>" class="text-sm text-muted hover:text-ink tracking-[0.15em] uppercase transition-colors py-4 border-b border-border" style="border-color: rgba(231,229,228,0.4);">Packages</a>
        <a href="<?= baseUrl('/#how-it-works') ?>" class="text-sm text-muted hover:text-ink tracking-[0.15em] uppercase transition-colors py-4 border-b border-border" style="border-color: rgba(231,229,228,0.4);">How it Works</a>
        <div class="mt-6 pt-6 border-t border-border" style="border-color: rgba(231,229,228,0.4);">
            <?php if ($currentUser): ?>
                <a href="<?= baseUrl($profileLink) ?>" class="block w-full text-center py-3 bg-ink text-white text-[11px] font-medium tracking-[0.2em] uppercase transition-all duration-500 hover:bg-champagne hover:text-ink">My Account</a>
            <?php else: ?>
                <a href="<?= baseUrl('/login') ?>" class="block w-full text-center py-3 bg-ink text-white text-[11px] font-medium tracking-[0.2em] uppercase transition-all duration-500 hover:bg-champagne hover:text-ink">Sign In</a>
                <a href="<?= baseUrl('/signup') ?>" class="block w-full text-center py-3 mt-3 text-[11px] font-medium tracking-[0.2em] uppercase text-ink border border-border transition-all duration-500 hover:border-champagne">Join</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (window.RentEase) {
        RentEase.initScrollProgress();
        RentEase.initNavScroll();
    }

    const btn = document.getElementById('mobile-menu-btn');
    const nav = document.getElementById('mobile-nav');
    const overlay = document.getElementById('mobile-overlay');

    function toggleMobileNav() {
        const isOpen = nav.classList.contains('flex');
        nav.classList.toggle('hidden');
        nav.classList.toggle('flex');
        if (overlay) overlay.classList.toggle('hidden');
        document.body.style.overflow = isOpen ? '' : 'hidden';
        const icon = btn.querySelector('.material-symbols-outlined');
        if (icon) icon.textContent = isOpen ? 'menu' : 'close';
    }

    if (btn && nav) {
        btn.addEventListener('click', toggleMobileNav);
        if (overlay) overlay.addEventListener('click', toggleMobileNav);
    }

    const gsapCheck = setInterval(() => {
        if (window.gsap) {
            clearInterval(gsapCheck);
            gsap.context(() => {
                gsap.from('#main-nav', { y: -80, opacity: 0, duration: 1.2, ease: 'power2.out', delay: 0.1 });
            });
        }
    }, 100);
});
</script>
