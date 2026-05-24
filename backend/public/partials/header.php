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
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>" />
    <meta name="robots" content="index, follow" />
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>" />
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>" />
    <meta property="og:type" content="website" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-secondary-fixed": "#00201e",
                        "on-secondary-fixed-variant": "#00504c",
                        "outline": "#74777d",
                        "secondary-fixed": "#79f6ed",
                        "on-error-container": "#93000a",
                        "background": "#f8f9ff",
                        "surface-bright": "#f8f9ff",
                        "outline-variant": "#c4c6cd",
                        "on-tertiary-fixed-variant": "#434749",
                        "on-tertiary-fixed": "#181c1e",
                        "primary-fixed": "#d2e4fb",
                        "surface-dim": "#cbdbf5",
                        "surface-container-high": "#dce9ff",
                        "on-surface": "#0b1c30",
                        "inverse-primary": "#b7c8de",
                        "error-container": "#ffdad6",
                        "on-primary-fixed-variant": "#38485a",
                        "primary-fixed-dim": "#b7c8de",
                        "surface-tint": "#4f6073",
                        "inverse-surface": "#213145",
                        "on-primary-fixed": "#0b1d2d",
                        "surface": "#f8f9ff",
                        "surface-container-highest": "#d3e4fe",
                        "on-background": "#0b1c30",
                        "primary": "#041627",
                        "on-error": "#ffffff",
                        "on-surface-variant": "#44474c",
                        "secondary-fixed-dim": "#59dad1",
                        "surface-container": "#e5eeff",
                        "on-secondary-container": "#006f69",
                        "on-primary-container": "#8192a7",
                        "on-tertiary-container": "#8d9193",
                        "tertiary-fixed-dim": "#c4c7c9",
                        "surface-container-low": "#eff4ff",
                        "primary-container": "#1a2b3c",
                        "secondary-container": "#76f3ea",
                        "tertiary-container": "#262a2c",
                        "on-tertiary": "#ffffff",
                        "tertiary-fixed": "#e0e3e5",
                        "on-primary": "#ffffff",
                        "on-secondary": "#ffffff",
                        "secondary": "#006a65",
                        "surface-variant": "#d3e4fe",
                        "surface-container-lowest": "#ffffff",
                        "inverse-on-surface": "#eaf1ff",
                        "tertiary": "#121617",
                        "error": "#ba1a1a"
                    },
                    "boxShadow": {
                        "ambient-low": "0 4px 12px rgba(4, 22, 39, 0.05)",
                        "ambient-high": "0 12px 24px rgba(4, 22, 39, 0.1)"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "lg": "2.5rem",
                        "gutter": "24px",
                        "container-max": "1280px",
                        "xl": "4rem",
                        "md": "1.5rem",
                        "sm": "1rem",
                        "unit": "8px",
                        "xs": "0.5rem"
                    },
                    "fontFamily": {
                        "body-md": ["Inter"],
                        "button": ["Inter"],
                        "h3": ["Inter"],
                        "h1": ["Inter"],
                        "body-sm": ["Inter"],
                        "h2": ["Inter"],
                        "label-caps": ["Inter"],
                        "body-lg": ["Inter"]
                    },
                    "fontSize": {
                        "body-md": ["16px", { "lineHeight": "1.6", "letterSpacing": "0", "fontWeight": "400" }],
                        "button": ["16px", { "lineHeight": "1", "letterSpacing": "0.01em", "fontWeight": "600" }],
                        "h3": ["24px", { "lineHeight": "1.4", "letterSpacing": "0", "fontWeight": "600" }],
                        "h1": ["48px", { "lineHeight": "1.2", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "body-sm": ["14px", { "lineHeight": "1.5", "letterSpacing": "0", "fontWeight": "400" }],
                        "h2": ["36px", { "lineHeight": "1.3", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "label-caps": ["12px", { "lineHeight": "1", "letterSpacing": "0.05em", "fontWeight": "700" }],
                        "body-lg": ["18px", { "lineHeight": "1.6", "letterSpacing": "0", "fontWeight": "400" }]
                    }
                }
            }
        }
    </script>

    <!-- OneSignal Integration -->
    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignal.SDK.js" defer></script>
    <script>
        window.RENTEASE_CONFIG = {
            onesignal_app_id: "<?= htmlspecialchars($config['onesignal_app_id'] ?? '') ?>",
            onesignal_safari_web_id: "<?= htmlspecialchars($config['onesignal_safari_web_id'] ?? '') ?>",
            current_user_id: "<?= htmlspecialchars($currentUser['id'] ?? '') ?>"
        };
    </script>
    <script src="/rentease/js/onesignal.js" defer></script>
    <!-- GSAP for animations (Deferred for performance) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js" defer></script>
</head>

<body class="bg-background text-on-background font-body-md text-body-md antialiased min-h-screen flex flex-col">

<!-- TopNavBar -->
<nav id="main-nav" class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl font-inter tracking-tight font-medium sticky w-full top-0 border-b z-50 border-slate-200/50 dark:border-slate-800/50 transition-all duration-300 group">
    <div class="flex justify-between items-center h-20 px-6 md:px-12 w-full max-w-[1440px] mx-auto">
        <a href="<?= baseUrl('/') ?>" class="text-3xl font-black text-slate-900 dark:text-slate-50 tracking-tighter hover:scale-105 transition-transform origin-left focus-visible:ring-2 ring-teal-500 rounded-lg outline-none">RentEase<span class="text-teal-500">.</span></a>
        
        <div class="hidden md:flex gap-10 items-center h-full">
            <!-- Furniture with Mega Menu -->
            <div class="h-full flex items-center group/menu relative">
                <a class="text-slate-600 dark:text-slate-300 hover:text-teal-600 dark:hover:text-teal-400 transition-colors py-8 font-semibold flex items-center gap-1 focus-visible:text-teal-600 outline-none" href="<?= baseUrl('/shop?category=Furniture') ?>">
                    Furniture
                    <span class="material-symbols-outlined text-sm transition-transform duration-300 group-hover/menu:rotate-180">expand_more</span>
                </a>
                
                <!-- Mega Menu Dropdown -->
                <div class="absolute top-[80px] left-1/2 -translate-x-1/2 w-[calc(100vw-2rem)] max-w-4xl bg-white dark:bg-slate-900 rounded-3xl shadow-[0_40px_100px_-20px_rgba(0,0,0,0.15)] border border-slate-100 dark:border-slate-800 opacity-0 invisible group-hover/menu:opacity-100 group-hover/menu:visible transition-all duration-500 translate-y-4 group-hover/menu:translate-y-0 overflow-hidden">
                    <div class="grid grid-cols-12 gap-0">
                        <div class="col-span-4 p-8 bg-slate-50 dark:bg-slate-800/50">
                            <h3 class="text-sm font-black uppercase tracking-widest text-slate-400 mb-6">Popular Categories</h3>
                            <ul class="space-y-4">
                                <li><a href="<?= baseUrl('/shop?category=Furniture&sub=LivingRoom') ?>" class="text-slate-700 dark:text-slate-300 hover:text-teal-600 font-medium flex items-center gap-2 group/link"><span class="w-2 h-2 rounded-full bg-slate-200 group-hover/link:bg-teal-500 transition-colors"></span> Living Room</a></li>
                                <li><a href="<?= baseUrl('/shop?category=Furniture&sub=Bedroom') ?>" class="text-slate-700 dark:text-slate-300 hover:text-teal-600 font-medium flex items-center gap-2 group/link"><span class="w-2 h-2 rounded-full bg-slate-200 group-hover/link:bg-teal-500 transition-colors"></span> Bedroom</a></li>
                                <li><a href="<?= baseUrl('/shop?category=Furniture&sub=Dining') ?>" class="text-slate-700 dark:text-slate-300 hover:text-teal-600 font-medium flex items-center gap-2 group/link"><span class="w-2 h-2 rounded-full bg-slate-200 group-hover/link:bg-teal-500 transition-colors"></span> Dining</a></li>
                                <li><a href="<?= baseUrl('/shop?category=Furniture&sub=Office') ?>" class="text-slate-700 dark:text-slate-300 hover:text-teal-600 font-medium flex items-center gap-2 group/link"><span class="w-2 h-2 rounded-full bg-slate-200 group-hover/link:bg-teal-500 transition-colors"></span> Work from Home</a></li>
                            </ul>
                            <a href="<?= baseUrl('/shop?category=Furniture') ?>" class="inline-block mt-8 text-sm font-bold text-teal-600 hover:text-teal-700 underline underline-offset-4 decoration-2">Shop All Furniture &rarr;</a>
                        </div>
                        <div class="col-span-8 p-8 flex gap-6">
                            <a href="<?= baseUrl('/product-detail?id=1') ?>" class="block w-1/2 group/card relative rounded-2xl overflow-hidden aspect-[4/3]">
                                <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&q=80&w=800" alt="Sofa" class="w-full h-full object-cover transition-transform duration-700 group-hover/card:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent p-6 flex flex-col justify-end">
                                    <span class="bg-teal-500 text-white text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded w-fit mb-2">Bestseller</span>
                                    <h4 class="text-white font-bold text-lg">Cloud Sofa</h4>
                                    <p class="text-white/80 text-sm">Starts at $49/mo</p>
                                </div>
                            </a>
                            <a href="<?= baseUrl('/product-detail?id=2') ?>" class="block w-1/2 group/card relative rounded-2xl overflow-hidden aspect-[4/3]">
                                <img src="https://images.unsplash.com/photo-1505693314120-0d443867891c?auto=format&fit=crop&q=80&w=800" alt="Bed" class="w-full h-full object-cover transition-transform duration-700 group-hover/card:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent p-6 flex flex-col justify-end">
                                    <span class="bg-indigo-500 text-white text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded w-fit mb-2">New Arrival</span>
                                    <h4 class="text-white font-bold text-lg">Zen Platform Bed</h4>
                                    <p class="text-white/80 text-sm">Starts at $35/mo</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appliances (Simple Link) -->
            <a class="text-slate-600 dark:text-slate-300 hover:text-teal-600 dark:hover:text-teal-400 transition-colors font-semibold relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-teal-500 hover:after:w-full after:transition-all after:duration-300" href="<?= baseUrl('/shop?category=Appliances') ?>">Appliances</a>
            
            <!-- Packages with Mega Menu -->
            <div class="h-full flex items-center group/menu relative">
                <a class="text-slate-600 dark:text-slate-300 hover:text-teal-600 dark:hover:text-teal-400 transition-colors py-8 font-semibold flex items-center gap-1 focus-visible:text-teal-600 outline-none" href="<?= baseUrl('/shop') ?>">
                    Packages
                    <span class="material-symbols-outlined text-sm transition-transform duration-300 group-hover/menu:rotate-180">expand_more</span>
                </a>
                
                <!-- Mega Menu Dropdown -->
                <div class="absolute top-[80px] left-1/2 -translate-x-1/2 w-[calc(100vw-2rem)] max-w-4xl bg-white dark:bg-slate-900 rounded-3xl shadow-[0_40px_100px_-20px_rgba(0,0,0,0.15)] border border-slate-100 dark:border-slate-800 opacity-0 invisible group-hover/menu:opacity-100 group-hover/menu:visible transition-all duration-500 translate-y-4 group-hover/menu:translate-y-0 overflow-hidden">
                    <div class="grid grid-cols-12 gap-0">
                        <div class="col-span-4 p-8 bg-slate-50 dark:bg-slate-800/50">
                            <h3 class="text-sm font-black uppercase tracking-widest text-slate-400 mb-6">Room Packages</h3>
                            <ul class="space-y-4">
                                <li><a href="<?= baseUrl('/shop?package=studio') ?>" class="text-slate-700 dark:text-slate-300 hover:text-teal-600 font-medium flex items-center gap-2 group/link"><span class="w-2 h-2 rounded-full bg-slate-200 group-hover/link:bg-teal-500 transition-colors"></span> Studio Setup</a></li>
                                <li><a href="<?= baseUrl('/shop?package=1bhk') ?>" class="text-slate-700 dark:text-slate-300 hover:text-teal-600 font-medium flex items-center gap-2 group/link"><span class="w-2 h-2 rounded-full bg-slate-200 group-hover/link:bg-teal-500 transition-colors"></span> 1 BHK Complete</a></li>
                                <li><a href="<?= baseUrl('/shop?package=2bhk') ?>" class="text-slate-700 dark:text-slate-300 hover:text-teal-600 font-medium flex items-center gap-2 group/link"><span class="w-2 h-2 rounded-full bg-slate-200 group-hover/link:bg-teal-500 transition-colors"></span> 2 BHK Premium</a></li>
                                <li><a href="<?= baseUrl('/shop?package=office') ?>" class="text-slate-700 dark:text-slate-300 hover:text-teal-600 font-medium flex items-center gap-2 group/link"><span class="w-2 h-2 rounded-full bg-slate-200 group-hover/link:bg-teal-500 transition-colors"></span> WFH Starter</a></li>
                            </ul>
                            <a href="<?= baseUrl('/shop') ?>" class="inline-block mt-8 text-sm font-bold text-teal-600 hover:text-teal-700 underline underline-offset-4 decoration-2">Browse All Packages &rarr;</a>
                        </div>
                        <div class="col-span-8 p-8 flex gap-6">
                            <a href="<?= baseUrl('/shop?package=studio') ?>" class="block w-1/2 group/card relative rounded-2xl overflow-hidden aspect-[4/3]">
                                <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&q=80&w=800" alt="Studio Package" class="w-full h-full object-cover transition-transform duration-700 group-hover/card:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent p-6 flex flex-col justify-end">
                                    <span class="bg-teal-500 text-white text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded w-fit mb-2">Most Popular</span>
                                    <h4 class="text-white font-bold text-lg">Essential Studio Pack</h4>
                                    <p class="text-white/80 text-sm">Everything you need from $89/mo</p>
                                </div>
                            </a>
                            <a href="<?= baseUrl('/shop?package=2bhk') ?>" class="block w-1/2 group/card relative rounded-2xl overflow-hidden aspect-[4/3]">
                                <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&q=80&w=800" alt="2BHK Package" class="w-full h-full object-cover transition-transform duration-700 group-hover/card:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent p-6 flex flex-col justify-end">
                                    <span class="bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded w-fit mb-2">Premium</span>
                                    <h4 class="text-white font-bold text-lg">2 BHK Luxe Setup</h4>
                                    <p class="text-white/80 text-sm">Elevate your home from $199/mo</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- How it Works with Mega Menu -->
            <div class="h-full flex items-center group/menu relative">
                <a class="text-slate-500 dark:text-slate-400 hover:text-teal-600 dark:hover:text-teal-400 transition-colors py-8 font-medium flex items-center gap-1 focus-visible:text-teal-600 outline-none" href="<?= baseUrl('/') ?>">
                    How it Works
                    <span class="material-symbols-outlined text-sm transition-transform duration-300 group-hover/menu:rotate-180">expand_more</span>
                </a>
                
                <!-- Mega Menu Dropdown -->
                <div class="absolute top-[80px] right-0 w-[calc(100vw-2rem)] max-w-3xl bg-white dark:bg-slate-900 rounded-3xl shadow-[0_40px_100px_-20px_rgba(0,0,0,0.15)] border border-slate-100 dark:border-slate-800 opacity-0 invisible group-hover/menu:opacity-100 group-hover/menu:visible transition-all duration-500 translate-y-4 group-hover/menu:translate-y-0 overflow-hidden">
                    <div class="grid grid-cols-12 gap-0">
                        <div class="col-span-5 p-8 bg-slate-50 dark:bg-slate-800/50">
                            <h3 class="text-sm font-black uppercase tracking-widest text-slate-400 mb-6">Discover RentEase</h3>
                            <ul class="space-y-4">
                                <li><a href="<?= baseUrl('/about') ?>" class="text-slate-700 dark:text-slate-300 hover:text-teal-600 font-medium flex items-center gap-3"><span class="material-symbols-outlined text-lg text-slate-400">info</span> About Us</a></li>
                                <li><a href="<?= baseUrl('/support') ?>" class="text-slate-700 dark:text-slate-300 hover:text-teal-600 font-medium flex items-center gap-3"><span class="material-symbols-outlined text-lg text-slate-400">help</span> Help Center / FAQ</a></li>
                                <li><a href="<?= baseUrl('/support') ?>" class="text-slate-700 dark:text-slate-300 hover:text-teal-600 font-medium flex items-center gap-3"><span class="material-symbols-outlined text-lg text-slate-400">local_shipping</span> Delivery & Returns</a></li>
                                <li><a href="<?= baseUrl('/concierge') ?>" class="text-slate-700 dark:text-slate-300 hover:text-teal-600 font-medium flex items-center gap-3"><span class="material-symbols-outlined text-lg text-slate-400">support_agent</span> Live Concierge</a></li>
                            </ul>
                        </div>
                        <div class="col-span-7 p-8">
                            <h3 class="text-sm font-black uppercase tracking-widest text-slate-400 mb-6">The Process</h3>
                            <div class="flex flex-col gap-6">
                                <div class="flex gap-4 items-start">
                                    <div class="w-10 h-10 rounded-full bg-teal-50 dark:bg-teal-900/30 text-teal-600 flex items-center justify-center flex-shrink-0">
                                        <span class="material-symbols-outlined">touch_app</span>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-slate-100 mb-1">1. Choose Your Style</h4>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">Browse premium pieces or complete packages that fit your aesthetic.</p>
                                    </div>
                                </div>
                                <div class="flex gap-4 items-start">
                                    <div class="w-10 h-10 rounded-full bg-teal-50 dark:bg-teal-900/30 text-teal-600 flex items-center justify-center flex-shrink-0">
                                        <span class="material-symbols-outlined">calendar_month</span>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-slate-100 mb-1">2. Flexible Subscription</h4>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">Select 3, 6, or 12-month terms. The longer you rent, the less you pay.</p>
                                    </div>
                                </div>
                                <div class="flex gap-4 items-start">
                                    <div class="w-10 h-10 rounded-full bg-teal-50 dark:bg-teal-900/30 text-teal-600 flex items-center justify-center flex-shrink-0">
                                        <span class="material-symbols-outlined">local_shipping</span>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-slate-100 mb-1">3. Free Delivery & Setup</h4>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">We deliver and assemble everything for free. Just sit back and relax.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="hidden md:flex gap-6 items-center text-slate-700 dark:text-slate-200">
            <div class="flex items-center gap-1 bg-slate-100 dark:bg-slate-800 rounded-full px-4 py-2 focus-within:ring-2 ring-teal-500 transition-shadow">
                <span class="material-symbols-outlined text-slate-400 text-xl">search</span>
                <input type="text" aria-label="Search products" placeholder="Search..." class="bg-transparent border-none focus:ring-0 text-sm w-32 focus:w-48 transition-all duration-300 placeholder-slate-400">
            </div>

            <a href="<?= baseUrl('/cart') ?>" aria-label="View shopping bag" class="hover:text-teal-600 dark:hover:text-teal-400 transition-colors duration-200 relative group/icon focus-visible:text-teal-600 outline-none">
                <span class="material-symbols-outlined text-[28px] font-light group-hover/icon:scale-110 transition-transform">shopping_bag</span>
                <?php if ($cartCount > 0): ?>
                    <span class="absolute -top-1 -right-1 bg-teal-500 text-white text-[10px] font-black h-5 w-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm"><?= $cartCount ?></span>
                <?php endif; ?>
            </a>
            
            <?php if ($currentUser && AuthService::resolveRole($currentUser) === 'admin'): ?>
                <a href="<?= baseUrl('/admin') ?>" class="flex items-center gap-1.5 px-4 py-2 rounded-full bg-slate-900 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-teal-600 hover:-translate-y-0.5 transition-all shadow-md hover:shadow-lg focus-visible:ring-2 ring-teal-500 outline-none">
                    <span class="material-symbols-outlined text-[16px]">admin_panel_settings</span>
                    Admin
                </a>
            <?php endif; ?>
            
            <?php 
                $profileLink = '/login';
                if ($currentUser) {
                    $role = AuthService::resolveRole($currentUser);
                    if ($role === 'admin') {
                        $profileLink = '/admin';
                    } elseif ($role === 'vendor') {
                        $profileLink = '/vendor-panel';
                    } else {
                        $profileLink = '/dashboard';
                    }
                }
            ?>
            <a href="<?= baseUrl($profileLink) ?>" aria-label="Go to profile" class="hover:text-teal-600 dark:hover:text-teal-400 transition-colors duration-200 group/icon focus-visible:text-teal-600 outline-none">
                <span class="material-symbols-outlined text-[28px] font-light group-hover/icon:scale-110 transition-transform">account_circle</span>
            </a>
        </div>

        <!-- Mobile hamburger menu -->
        <div class="flex md:hidden items-center gap-5">
            <a href="<?= baseUrl('/cart') ?>" aria-label="View shopping bag" class="relative hover:text-teal-600 transition-colors focus-visible:text-teal-600 outline-none">
                <span class="material-symbols-outlined text-[28px] font-light">shopping_bag</span>
                <?php if ($cartCount > 0): ?>
                    <span class="absolute -top-1 -right-1 bg-teal-500 text-white text-[10px] font-black h-5 w-5 rounded-full flex items-center justify-center border-2 border-white"><?= $cartCount ?></span>
                <?php endif; ?>
            </a>
            <button id="mobile-menu-btn" 
                aria-label="Toggle navigation" 
                aria-expanded="false"
                aria-controls="mobile-nav"
                class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors active:scale-95 focus-visible:ring-2 ring-teal-500 outline-none">
                <span class="material-symbols-outlined text-3xl" id="menu-icon">menu</span>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Panel -->
    <div id="mobile-nav" class="hidden md:hidden border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-6 pb-8 pt-4 space-y-2 shadow-2xl absolute w-full left-0 origin-top max-h-[85vh] overflow-y-auto scrollbar-hide">
        <a class="block py-4 text-xl border-b border-slate-100 dark:border-slate-800 text-slate-800 dark:text-slate-200 hover:text-teal-600 transition-colors font-semibold flex justify-between items-center" href="<?= baseUrl('/shop?category=Furniture') ?>">
            Furniture
            <span class="material-symbols-outlined text-slate-400">chevron_right</span>
        </a>
        <a class="block py-4 text-xl border-b border-slate-100 dark:border-slate-800 text-slate-800 dark:text-slate-200 hover:text-teal-600 transition-colors font-semibold flex justify-between items-center" href="<?= baseUrl('/shop?category=Appliances') ?>">
            Appliances
            <span class="material-symbols-outlined text-slate-400">chevron_right</span>
        </a>
        <a class="block py-4 text-xl border-b border-slate-100 dark:border-slate-800 text-slate-800 dark:text-slate-200 hover:text-teal-600 transition-colors font-semibold flex justify-between items-center" href="<?= baseUrl('/shop') ?>">
            Packages
            <span class="material-symbols-outlined text-slate-400">chevron_right</span>
        </a>
        
        <div class="pt-6 pb-2">
            <?php if ($currentUser): ?>
                <?php if ($currentUser && AuthService::resolveRole($currentUser) === 'admin'): ?>
                    <a class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-slate-900 text-white font-bold mb-3" href="<?= baseUrl('/admin') ?>">
                        <span class="material-symbols-outlined">admin_panel_settings</span> Admin Console
                    </a>
                <?php endif; ?>
                <a class="block py-3 px-4 rounded-xl bg-slate-100 dark:bg-slate-800 text-center text-slate-800 dark:text-slate-200 font-semibold mb-3" href="<?= baseUrl($profileLink) ?>">My Account</a>
            <?php else: ?>
                <a class="block py-3 px-4 rounded-xl bg-teal-500 text-center text-white font-bold mb-3 shadow-lg shadow-teal-500/30" href="<?= baseUrl('/login') ?>">Sign In</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Add GSAP Animations Logic -->
<script>
/** Header Animations and Scroll Logic */
document.addEventListener('DOMContentLoaded', () => {
    // Wait for GSAP to load
    const checkGsap = setInterval(() => {
        if (window.gsap) {
            clearInterval(checkGsap);
            initAnimations();
        }
    }, 50);

    function initAnimations() {
        // Scroll Shrink Effect
        const nav = document.getElementById('main-nav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                nav.classList.add('shadow-md');
                nav.querySelector('.h-20')?.classList.replace('h-20', 'h-16');
            } else {
                nav.classList.remove('shadow-md');
                nav.querySelector('.h-16')?.classList.replace('h-16', 'h-20');
            }
        }, { passive: true });

        // Mobile Menu Toggle with GSAP Animation
        const btn = document.getElementById('mobile-menu-btn');
        const mobileNav = document.getElementById('mobile-nav');
        const icon = document.getElementById('menu-icon');
        let isMenuOpen = false;

        if (btn && mobileNav && icon) {
            // Initial setup
            gsap.set(mobileNav, { height: 0, opacity: 0, display: 'none' });

            btn.addEventListener('click', () => {
                isMenuOpen = !isMenuOpen;
                btn.setAttribute('aria-expanded', isMenuOpen);
                
                if (isMenuOpen) {
                    icon.textContent = 'close';
                    gsap.to(mobileNav, {
                        duration: 0.4,
                        height: 'auto',
                        opacity: 1,
                        display: 'block',
                        ease: 'power3.out'
                    });
                    // Animate links in
                    gsap.fromTo(mobileNav.querySelectorAll('a'), 
                        { y: 20, opacity: 0 },
                        { y: 0, opacity: 1, duration: 0.3, stagger: 0.05, delay: 0.1, ease: 'power2.out' }
                    );
                } else {
                    icon.textContent = 'menu';
                    gsap.to(mobileNav, {
                        duration: 0.3,
                        height: 0,
                        opacity: 0,
                        display: 'none',
                        ease: 'power3.in'
                    });
                }
            });
        }

        // Initial Navbar Entrance Animation
        gsap.from('#main-nav', {
            y: -100,
            opacity: 0,
            duration: 0.8,
            ease: 'power3.out'
        });
    }
});
</script>