<?php
declare(strict_types=1);

use RentEase\Services\AuthService;

/** @var array $config */
if (!isset($config)) {
    $config = require_once __DIR__ . '/../../config/config.php';
}

$authService = new AuthService($config);
$currentUser = null;
try {
    $token = $_COOKIE[$config['cookie_name'] ?? ''] ?? '';
    if ($token) {
        $userData = $authService->validateToken($token);
        if ($userData) {
            $currentUser = $userData;
            // Map Supabase 'full_name' from metadata if 'name' is missing
            $currentUser['name'] = $userData['user_metadata']['full_name']
                ?? $userData['name']
                ?? explode('@', $userData['email'])[0]
                ?? 'User';
        }
    }
} catch (Throwable $ignored) {
}

$cartCount = 0;
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!empty($_SESSION['cart'])) {
    $cartCount = count($_SESSION['cart']);
}
?>
<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>RentEase - Premium Furniture & Appliances</title>
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
    <style>
        .ambient-shadow-low {
            box-shadow: 0 4px 12px rgba(4, 22, 39, 0.05);
        }

        .ambient-shadow-high {
            box-shadow: 0 12px 24px rgba(4, 22, 39, 0.1);
        }
    </style>

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
</head>

<body class="bg-background text-on-background font-body-md text-body-md antialiased min-h-screen flex flex-col">

<!-- TopNavBar -->
<nav class="bg-white dark:bg-slate-900 font-inter tracking-tight font-medium sticky w-full top-0 border-b z-50 border-slate-200 dark:border-slate-800 shadow-sm dark:shadow-none flex">
    <div class="flex justify-between items-center h-16 px-4 md:px-8 w-full max-w-7xl mx-auto">
        <a href="<?= baseUrl('/') ?>" class="text-2xl font-black text-slate-900 dark:text-slate-50 tracking-tighter">RentEase</a>
        <div class="hidden md:flex gap-6 items-center">
            <a class="text-slate-500 dark:text-slate-400 hover:text-teal-600 dark:hover:text-teal-400 transition-colors duration-200 active:opacity-80 transition-opacity" href="<?= baseUrl('/shop?category=Furniture') ?>">Furniture</a>
            <a class="text-slate-500 dark:text-slate-400 hover:text-teal-600 dark:hover:text-teal-400 transition-colors duration-200 active:opacity-80 transition-opacity" href="<?= baseUrl('/shop?category=Appliances') ?>">Appliances</a>
            <a class="text-slate-500 dark:text-slate-400 hover:text-teal-600 dark:hover:text-teal-400 transition-colors duration-200 active:opacity-80 transition-opacity" href="<?= baseUrl('/shop') ?>">Packages</a>
            <a class="text-slate-500 dark:text-slate-400 hover:text-teal-600 dark:hover:text-teal-400 transition-colors duration-200 active:opacity-80 transition-opacity" href="<?= baseUrl('/') ?>">How it Works</a>
        </div>
        <div class="hidden md:flex gap-4 items-center text-slate-900 dark:text-slate-50">
            <a href="<?= baseUrl('/cart') ?>" class="hover:text-teal-600 dark:hover:text-teal-400 transition-colors duration-200 active:opacity-80 transition-opacity relative">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">shopping_cart</span>
                <?php if ($cartCount > 0): ?>
                    <span class="absolute -top-1 -right-1 bg-secondary text-white text-[10px] font-bold h-4 w-4 rounded-full flex items-center justify-center"><?= $cartCount ?></span>
                <?php endif; ?>
            </a>
            <?php if (($currentUser['role'] ?? 'user') === 'admin'): ?>
                <a href="<?= baseUrl('/admin') ?>" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-900 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-teal-600 transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[14px]">admin_panel_settings</span>
                    Admin Console
                </a>
            <?php endif; ?>
            <?php 
                $profileLink = '/login';
                if ($currentUser) {
                    $role = $currentUser['role'] ?? 'user';
                    if ($role === 'admin') {
                        $profileLink = '/admin';
                    } elseif ($role === 'vendor') {
                        $profileLink = '/vendor-panel';
                    } else {
                        $profileLink = '/dashboard';
                    }
                }
            ?>
            <a href="<?= baseUrl($profileLink) ?>" class="hover:text-teal-600 dark:hover:text-teal-400 transition-colors duration-200 active:opacity-80 transition-opacity">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">account_circle</span>
            </a>
        </div>
    </div>
</nav>