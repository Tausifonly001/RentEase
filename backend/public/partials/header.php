<?php
declare(strict_types=1);

use RentEase\Services\AuthService;

/** @var array $config */
if (!isset($config)) {
    $config = require_once __DIR__ . '/../../config/config.php';
}

/**
 * PERF-001: Cache authenticated user data in session to avoid
 * redundant Supabase API calls on every page load.
 * Cache TTL: 5 minutes. Invalidated if JWT cookie changes.
 */
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$currentUser = null;
$token = $_COOKIE[$config['cookie_name'] ?? ''] ?? '';
$cachedToken = $_SESSION['_auth_cached_token'] ?? '';
$cacheExpiry = $_SESSION['_auth_cache_expiry'] ?? 0;

if ($token !== '' && $token === $cachedToken && time() < $cacheExpiry && !empty($_SESSION['_auth_cached_user'])) {
    // Use cached user data
    $currentUser = $_SESSION['_auth_cached_user'];
} else {
    // Validate fresh from Supabase
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

                // Cache for 5 minutes
                $_SESSION['_auth_cached_user'] = $currentUser;
                $_SESSION['_auth_cached_token'] = $token;
                $_SESSION['_auth_cache_expiry'] = time() + 300;
            } else {
                // Clear stale cache
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

/* SEO-001/002: Dynamic page title and meta description */
$pageTitle = $pageTitle ?? 'RentEase — Premium Furniture & Appliance Rentals';
$pageDescription = $pageDescription ?? 'Rent premium furniture and appliances with flexible monthly plans. Free delivery, easy returns, zero commitment.';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0, viewport-fit=cover" name="viewport" />
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>" />
    <meta name="robots" content="index, follow" />
    <meta name="theme-color" content="#ffffff" />
    <link rel="icon" type="image/svg+xml" href="<?= baseUrl('/favicon.svg') ?>" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#000000',
                        card: '#ffffff',
                        surface: '#fafafa',
                        accent: '#d4cfc9', // Warm taupe for subtle accents
                        champagne: '#c5b39b', // Luxury accent
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    },
                }
            }
        }
    </script>
    <style>
        /* Smooth scrolling and base overrides */
        html { scroll-behavior: smooth; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #fafafa; }
        ::-webkit-scrollbar-thumb { background: #e4e4e7; }
        ::-webkit-scrollbar-thumb:hover { background: #d4d4d8; }
        ::selection { background-color: rgba(197, 179, 155, 0.3); color: #000000; }
        
        /* Typography Masking Utilities */
        .text-mask { overflow: hidden; display: inline-block; vertical-align: bottom; padding-bottom: 0.1em; margin-bottom: -0.1em; }
        .text-mask-inner { display: inline-block; transform: translateY(100%); }
        .clip-reveal { clip-path: inset(0 100% 0 0); }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js" defer></script>
</head>

<body class="bg-card text-zinc-900 font-sans antialiased min-h-screen flex flex-col">

<!-- TopNavBar -->
<nav id="main-nav" class="fixed w-full top-0 z-50 bg-white/95 backdrop-blur-md border-b border-zinc-200/60 transition-all duration-300">
    <div class="flex justify-between items-center h-20 px-6 md:px-12 w-full max-w-[1600px] mx-auto">
        <a href="<?= baseUrl('/') ?>" class="text-3xl font-serif font-bold text-ink tracking-tighter hover:opacity-70 transition-opacity duration-300 outline-none focus-visible:ring-1 ring-ink rounded-sm">
            RentEase.
        </a>
        
        <div class="hidden md:flex gap-10 items-center h-full">
            <a href="<?= baseUrl('/shop?category=Furniture') ?>" class="text-[11px] text-zinc-500 hover:text-ink transition-colors duration-200 font-medium tracking-[0.2em] uppercase outline-none focus-visible:text-ink">Furniture</a>
            <a href="<?= baseUrl('/shop?category=Appliances') ?>" class="text-[11px] text-zinc-500 hover:text-ink transition-colors duration-200 font-medium tracking-[0.2em] uppercase outline-none focus-visible:text-ink">Appliances</a>
            <a href="<?= baseUrl('/shop') ?>" class="text-[11px] text-zinc-500 hover:text-ink transition-colors duration-200 font-medium tracking-[0.2em] uppercase outline-none focus-visible:text-ink">Packages</a>
            <a href="<?= baseUrl('/#how-it-works') ?>" class="text-[11px] text-zinc-500 hover:text-ink transition-colors duration-200 font-medium tracking-[0.2em] uppercase outline-none focus-visible:text-ink">How it Works</a>
        </div>
        
        <div class="hidden md:flex gap-6 items-center">
            <a href="<?= baseUrl('/cart') ?>" aria-label="View shopping bag" class="relative text-zinc-900 hover:opacity-60 transition-opacity duration-200 group/icon focus-visible:opacity-60 outline-none">
                <span class="material-symbols-outlined text-xl font-light">shopping_bag</span>
                <?php if ($cartCount > 0): ?>
                    <span class="absolute -top-1.5 -right-2 bg-ink text-white text-[9px] font-medium h-4 w-4 flex items-center justify-center rounded-full"><?= $cartCount ?></span>
                <?php endif; ?>
            </a>
            
            <?php 
                $profileLink = '/login';
                if ($currentUser) {
                    $role = AuthService::resolveRole($currentUser);
                    $profileLink = ($role === 'admin') ? '/admin' : (($role === 'vendor') ? '/vendor-panel' : '/dashboard');
                }
            ?>
            <a href="<?= baseUrl($profileLink) ?>" aria-label="Go to profile" class="text-zinc-900 hover:opacity-60 transition-opacity duration-200 focus-visible:opacity-60 outline-none">
                <span class="material-symbols-outlined text-xl font-light">person</span>
            </a>
            
            <?php if (!$currentUser): ?>
                <a href="<?= baseUrl('/login') ?>" class="px-5 py-2 border border-zinc-200 hover:border-ink hover:bg-ink hover:text-white text-xs font-medium tracking-widest uppercase transition-all duration-300 outline-none focus-visible:ring-1 ring-ink">Sign In</a>
            <?php endif; ?>
        </div>

        <!-- Mobile Menu Btn -->
        <button id="mobile-menu-btn" aria-label="Toggle Menu" class="md:hidden text-zinc-900 hover:opacity-60 focus:outline-none transition-opacity duration-300">
            <span class="material-symbols-outlined text-2xl font-light">menu</span>
        </button>
    </div>
    
    <!-- Mobile Nav Panel -->
    <div id="mobile-nav" class="hidden absolute top-20 left-0 w-full bg-white border-b border-zinc-200 px-6 py-4 flex-col gap-2 shadow-xl">
        <a href="<?= baseUrl('/shop?category=Furniture') ?>" class="text-[11px] text-zinc-500 hover:text-ink tracking-[0.2em] uppercase transition-colors py-3 border-b border-zinc-100">Furniture</a>
        <a href="<?= baseUrl('/shop?category=Appliances') ?>" class="text-[11px] text-zinc-500 hover:text-ink tracking-[0.2em] uppercase transition-colors py-3 border-b border-zinc-100">Appliances</a>
        <a href="<?= baseUrl('/shop') ?>" class="text-[11px] text-zinc-500 hover:text-ink tracking-[0.2em] uppercase transition-colors py-3 border-b border-zinc-100">Packages</a>
        <?php if ($currentUser): ?>
            <a href="<?= baseUrl($profileLink) ?>" class="text-[11px] text-ink font-medium tracking-[0.2em] uppercase hover:opacity-60 transition-opacity py-3">My Account</a>
        <?php else: ?>
            <a href="<?= baseUrl('/login') ?>" class="text-[11px] text-ink font-medium tracking-[0.2em] uppercase hover:opacity-60 transition-opacity py-3">Sign In</a>
        <?php endif; ?>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('mobile-menu-btn');
    const nav = document.getElementById('mobile-nav');
    
    if (btn && nav) {
        btn.addEventListener('click', () => {
            nav.classList.toggle('hidden');
            nav.classList.toggle('flex');
            btn.innerHTML = nav.classList.contains('hidden') 
                ? '<span class="material-symbols-outlined text-2xl font-light">menu</span>' 
                : '<span class="material-symbols-outlined text-2xl font-light">close</span>';
        });
    }

    const checkGsap = setInterval(() => {
        if (window.gsap) {
            clearInterval(checkGsap);
            let ctx = gsap.context(() => {
                gsap.from('#main-nav', { y: -80, opacity: 0, duration: 1.2, ease: 'power2.out' });
            });
        }
    }, 100);
});
</script>