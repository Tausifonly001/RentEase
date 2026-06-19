<?php
declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use RentEase\Services\AuthService;

$authService = new AuthService($config);
$currentUser = null;
try {
 $token = $_COOKIE[$config['cookie_name'] ?? ''] ?? '';
 if ($token) {
 $currentUser = $authService->validateToken($token);
 }
} catch (Throwable $ignored) {}

// If not logged in, we shouldn't really be here, but let's be safe
if (!$currentUser) {
 header('Location: ' . baseUrl('/login'));
 exit;
}
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-white selection:bg-champagne/20">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Success — RentEase</title>
 <script src="https://cdn.tailwindcss.com"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
 <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap">
 <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <script>
  tailwind.config = {
  theme: {
  extend: {
  fontFamily: {
  sans: ['Inter', 'sans-serif'],
  inter: ['Inter', 'sans-serif'],
  },
  colors: {
  teal: { 50: '#f0fdfa', 100: '#ccfbf1', 200: '#99f6e4', 300: '#5eead4', 400: '#2dd4bf', 500: '#14b8a6', 600: '#0d9488', 700: '#0f766e', 800: '#115e59', 900: '#134e4a', 950: '#042f2e' },
  ink: '#18181B',
  'ink-soft': '#27272A',
  muted: '#6B6561',
  'muted-light': '#8C8885',
  canvas: '#FAFAF9',
  surface: '#FFFFFF',
  champagne: '#C5A98B',
  'champagne-light': '#D4C5B0',
  'champagne-dark': '#A8886E',
  border: 'rgba(231, 229, 228, 0.6)',
  }
  }
  }
  }
  </script>
 <style>
 .gradient-bg {
 background: radial-gradient(circle at top right, #f0fdfa 0%, #ffffff 50%, #f8fafc 100%);
 }
 .success-checkmark {
 width: 80px;
 height: 80px;
 border-radius: 50%;
 display: block;
 stroke-width: 2;
 stroke: #0d9488;
 stroke-miterlimit: 10;
 box-shadow: inset 0px 0px 0px #0d9488;
 animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
 }
 @keyframes scale { 0%, 100% { transform: none; } 50% { transform: scale3d(1.1, 1.1, 1); } }
 @keyframes fill { 100% { box-shadow: inset 0px 0px 0px 40px #0d9488; } }
 </style>
</head>
<body class="h-full gradient-bg overflow-hidden flex items-center justify-center">

 <div class="max-w-xl w-full px-6 text-center">
 <!-- Animated Icon Container -->
 <div class="mb-8 flex justify-center scale-up-element opacity-0">
 <div class="relative">
 <div class="absolute inset-0 bg-champagne blur-3xl opacity-20 animate-pulse"></div>
 <div class="relative h-32 w-32 bg-white rounded-[2.5rem] shadow-2xl flex items-center justify-center border border-champagne/20">
 <span class="material-symbols-outlined text-6xl text-champagne-dark font-variation-fill translate-y-1">verified</span>
 </div>
 </div>
 </div>

 <!-- Success Message -->
 <div class="space-y-4 mb-12">
 <h1 class="text-4xl md:text-5xl font-normal tracking-tighter text-ink font-sans slide-up-element opacity-0">
 Payment Received!
 </h1>
 <p class="text-lg text-muted font-normal leading-relaxed slide-up-element opacity-0">
 Thank you, <span class="text-champagne-dark font-normal"><?= e($currentUser['full_name'] ?? 'Guest') ?></span>.
 Your order has been confirmed and our fulfillment team is already preparing your premium lease items for dispatch.
 </p>
 </div>

 <!-- Information Cards -->
 <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-12 slide-up-element opacity-0">
 <div class="bg-white/70 backdrop-blur-md p-6 rounded-3xl border border-border shadow-sm text-left">
 <span class="material-symbols-outlined text-champagne-dark mb-2">local_shipping</span>
 <h3 class="font-normal text-ink">Next Step</h3>
 <p class="text-sm text-muted font-light">Scheduled delivery in 48 hours.</p>
 </div>
 <div class="bg-white/70 backdrop-blur-md p-6 rounded-3xl border border-border shadow-sm text-left">
 <span class="material-symbols-outlined text-champagne-dark mb-2">history_edu</span>
 <h3 class="font-normal text-ink">Lease Agreement</h3>
 <p class="text-sm text-muted font-light">Available in your dashboard.</p>
 </div>
 </div>

 <!-- Actions -->
 <div class="flex flex-col sm:flex-row items-center justify-center gap-4 slide-up-element opacity-0">
 <a href="<?= baseUrl('/orders') ?>" class="w-full sm:w-auto px-8 py-4 bg-ink text-white rounded-full font-normal shadow-xl shadow-lg hover:bg-champagne-dark transition-all hover:-translate-y-1 active:scale-95">
 Track My Order
 </a>
 <a href="<?= baseUrl('/shop') ?>" class="w-full sm:w-auto px-8 py-4 bg-white text-ink rounded-full font-normal border border-border hover:bg-surface transition-all active:scale-95">
 Back to Shop
 </a>
 </div>

 <!-- Order Number Placeholder -->
 <p class="mt-12 text-xs font-light text-muted-light uppercase tracking-widest slide-up-element opacity-0">
 Transaction Secured by Stripe & Supabase
 </p>
 </div>

 <script>
 document.addEventListener('DOMContentLoaded', () => {
 // GSAP Animations
 const tl = gsap.timeline();

 tl.to('.scale-up-element', {
 opacity: 1,
 scale: 1,
 duration: 1,
 ease: "back.out(1.7)",
 startAt: { scale: 0.5 }
 })
 .to('.slide-up-element', {
 opacity: 1,
 y: 0,
 duration: 0.8,
 stagger: 0.15,
 ease: "power4.out",
 startAt: { y: 40 }
 }, "-=0.5");

 // Confetti Blast
 const count = 200;
 const defaults = {
 origin: { y: 0.7 },
 colors: ['#0d9488', '#2dd4bf', '#14b8a6']
 };

 function fire(particleRatio, opts) {
 confetti({
 ...defaults,
 ...opts,
 particleCount: Math.floor(count * particleRatio)
 });
 }

 setTimeout(() => {
 fire(0.25, { spread: 26, startVelocity: 55 });
 fire(0.2, { spread: 60 });
 fire(0.35, { spread: 100, decay: 0.91, scalar: 0.8 });
 fire(0.1, { spread: 120, startVelocity: 25, decay: 0.92, scalar: 1.2 });
 fire(0.1, { spread: 120, startVelocity: 45 });
 }, 500);
 });
 </script>
</body>
</html>
