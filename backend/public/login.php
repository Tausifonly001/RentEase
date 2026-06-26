<?php
declare(strict_types=1);

use RentEase\Services\AuthService;
use RentEase\Support\Csrf;
use RentEase\Support\Session;

require_once __DIR__ . '/../bootstrap.php';

$authService = new AuthService($config);
$csrfToken = Csrf::token();
$error = Session::getFlash('error', $_GET['error'] ?? null);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 if (!Csrf::validate($_POST['csrf_token'] ?? null)) {
 $error = 'Session expired. Please refresh and try again.';
 } else {
 $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
 $password = $_POST['password'] ?? '';

 if (!$email || empty($password)) {
 $error = 'Both email and password are required.';
 } else {
 try {
 $loginResult = $authService->login(['email' => $email, 'password' => $password]);
 $token = (string) ($loginResult['access_token'] ?? '');
 if ($token !== '') {
  $rememberMe = !empty($_POST['remember']);
  $authService->persistSession($loginResult, $rememberMe);
  $redirect = $_GET['redirect'] ?? '';
  if ($redirect && !str_contains($redirect, '..') && !str_contains($redirect, '//')) {
   header('Location: ' . baseUrl('/' . ltrim($redirect, '/')));
  } else {
   header('Location: ' . baseUrl('/'));
  }
  exit;
 } else {
 $error = 'Authentication failed. Please verify your credentials.';
 }
 } catch (Throwable $e) {
 $error = 'Login failed. Please verify your credentials and try again.';
 }
 }
 }
}

$oauthProviders = $config['enabled_oauth_providers'] ?? [];
$pageTitle = 'Welcome back — RentEase';
$pageDescription = 'Sign in to manage your rentals, track deliveries, and access member rewards.';
$appUrl = $config['app_url'] ?? baseUrl('/');
$ogImage = baseUrl('/assets/images/og-image.png');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
	<title><?= htmlspecialchars($pageTitle) ?></title>
	<meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
	<meta name="robots" content="index, follow">
	<meta name="theme-color" content="#fafaf9">
	<link rel="canonical" href="<?= htmlspecialchars($appUrl) ?>">
	<link rel="icon" type="image/svg+xml" href="<?= baseUrl('/favicon.svg') ?>">
	<link rel="apple-touch-icon" href="<?= baseUrl('/favicon.svg') ?>">
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?= htmlspecialchars($appUrl) ?>">
	<meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
	<meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
	<meta property="og:image" content="<?= htmlspecialchars($ogImage) ?>">
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?= htmlspecialchars($pageTitle) ?>">
	<meta name="twitter:description" content="<?= htmlspecialchars($pageDescription) ?>">
	<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
	<style>
	body{background:#FAFAF9;color:#18181B;font-family:Inter,system-ui,sans-serif;overflow-x:hidden}
	.clip-reveal{clip-path:inset(0 100% 0 0)}
	.text-mask{overflow:hidden;display:inline-block;vertical-align:bottom;padding-bottom:.1em;margin-bottom:-.1em}
	.text-mask-inner{display:inline-block;transform:translateY(100%)}
	</style>
	<link rel="stylesheet" href="<?= baseUrl('/dist/output.css') ?>" media="print" onload="this.media='all';this.onload=null">
	<noscript><link rel="stylesheet" href="<?= baseUrl('/dist/output.css') ?>"></noscript>
	<link rel="stylesheet" href="<?= baseUrl('/assets/css/theme.css') ?>" media="print" onload="this.media='all';this.onload=null">
	<noscript><link rel="stylesheet" href="<?= baseUrl('/assets/css/theme.css') ?>"></noscript>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap" media="print" onload="this.media='all';this.onload=null">
	<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap"></noscript>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" media="print" onload="this.media='auto';this.onload=null">
	<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"></noscript>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js" defer></script>
</head>
<body class="min-h-screen bg-canvas text-muted font-sans selection:bg-champagne/20 selection:text-champagne-dark overflow-x-hidden">
 <div class="flex min-h-screen w-full flex-row-reverse">
 <!-- Form Side -->
 <div class="w-full lg:w-1/2 flex flex-col px-6 sm:px-12 lg:px-20 py-10 relative z-10 bg-surface">
 <header class="flex items-center justify-between mb-auto opacity-0 gsap-fade">
 <a href="<?= baseUrl('/') ?>" class="inline-flex items-center gap-3 text-xl font-serif font-medium tracking-tight text-ink outline-none focus-visible:ring-1 ring-champagne group">
 <span class="w-8 h-8 flex items-center justify-center bg-ink text-white text-xs font-medium group-hover:bg-champagne transition-colors duration-500">R</span>
 RentEase.
 </a>
 <a href="<?= baseUrl('/signup') ?>" class="text-[11px] font-medium text-muted-light uppercase tracking-[0.15em] hover:text-champagne transition-colors duration-300 outline-none focus-visible:text-champagne">
 New here? <span class="text-ink ml-1">Join</span>
 </a>
 </header>

 <div class="w-full max-w-sm mx-auto py-12 lg:py-0 my-auto">
 <div class="mb-12">
 <h1 class="text-4xl md:text-5xl font-serif text-ink mb-4 tracking-tight leading-tight">
 <span class="text-mask"><span class="text-mask-inner">Welcome</span></span><br>
 <span class="text-mask"><span class="text-mask-inner italic text-champagne">back.</span></span>
 </h1>
 <p class="text-muted text-sm font-light opacity-0 gsap-fade">Please enter your details to sign in.</p>
 </div>

 <?php if ($error): ?>
 <div class="mb-8 p-4 bg-rose-50 border border-rose-200 text-rose-700 text-sm font-light opacity-0 gsap-fade">
 <?= htmlspecialchars($error) ?>
 </div>
 <?php endif; ?>

 <form action="<?= baseUrl('/login') ?>" method="POST" class="space-y-8" novalidate>
 <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

 <div class="space-y-2 opacity-0 gsap-fade">
 <label for="email" class="form-label">Email</label>
 <input type="email" id="email" name="email" required autocomplete="email"
 class="form-input"
 placeholder="you@company.com"
 value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
 </div>

 <div class="space-y-2 opacity-0 gsap-fade">
 <div class="flex items-center justify-between">
 <label for="password" class="form-label">Password</label>
 <a href="<?= baseUrl('/forgot-password') ?>" class="text-[10px] font-medium text-muted-light uppercase tracking-[0.1em] hover:text-champagne transition-colors duration-300 outline-none focus-visible:text-champagne">Forgot?</a>
 </div>
 <input type="password" id="password" name="password" required autocomplete="current-password"
 class="form-input"
 placeholder="********">
 </div>

 <div class="flex items-center pt-2 opacity-0 gsap-fade">
 <input type="checkbox" id="remember" name="remember" class="w-4 h-4 accent-champagne cursor-pointer transition-colors duration-300">
 <label for="remember" class="ml-3 text-sm text-muted font-light cursor-pointer select-none hover:text-ink transition-colors duration-300">Keep me signed in</label>
 </div>

 <button type="submit" class="btn-primary w-full mt-10 opacity-0 gsap-fade">Sign In</button>
 </form>

 <?php if (!empty($oauthProviders)): ?>
 <div class="mt-10 opacity-0 gsap-fade">
 <div class="relative">
 <div class="absolute inset-0 flex items-center">
  <div class="w-full border-t border-subtle"></div>
 </div>
 <div class="relative flex justify-center text-[9px] uppercase tracking-[0.25em] font-medium">
 <span class="px-4 bg-surface text-muted-light">Or continue with</span>
 </div>
 </div>
 <div class="mt-8 grid grid-cols-<?= min(2, count($oauthProviders)) ?> gap-4">
 <?php foreach ($oauthProviders as $id => $provider): ?>
  <a href="<?= baseUrl('/api/auth/oauth?provider=' . $id) ?>" class="flex justify-center items-center gap-3 w-full border border-subtle py-3 hover:border-champagne transition-colors duration-500 outline-none focus-visible:ring-1 ring-champagne group">
 <img src="<?= $provider['icon'] ?>" alt="<?= htmlspecialchars($provider['name']) ?>" class="w-4 h-4 opacity-60 group-hover:opacity-100 transition-opacity duration-500 grayscale group-hover:grayscale-0">
 <span class="text-[10px] font-medium text-ink uppercase tracking-widest"><?= htmlspecialchars($provider['name']) ?></span>
 </a>
 <?php endforeach; ?>
 </div>
 </div>
 <?php endif; ?>
 </div>

 <footer class="mt-auto text-[10px] uppercase tracking-[0.15em] text-muted-light font-medium flex flex-col sm:flex-row justify-between items-center gap-4 opacity-0 gsap-fade">
 <span>&copy; <?= date('Y') ?> RentEase.</span>
 <div class="flex gap-8">
 <a href="<?= baseUrl('/terms') ?>" class="hover:text-champagne transition-colors duration-300 outline-none focus-visible:text-champagne">Terms</a>
 <a href="<?= baseUrl('/privacy') ?>" class="hover:text-champagne transition-colors duration-300 outline-none focus-visible:text-champagne">Privacy</a>
 </div>
 </footer>
 </div>

 <!-- Image Side -->
 <div class="hidden lg:block lg:w-1/2 relative bg-surface overflow-hidden" style="border-right: 1px solid rgba(231,229,228,0.6);">
 <div class="absolute inset-0 bg-champagne/10 z-10 clip-reveal" id="image-overlay"></div>
	<img src="<?= baseUrl('/assets/images/auth/login_bg.png') ?>" alt="Modern Interior" loading="lazy" decoding="async" class="absolute inset-0 w-full h-full object-cover origin-center scale-110" id="hero-image" style="filter: grayscale(30%);">
 <div class="absolute inset-0 bg-gradient-to-t from-ink/60 via-transparent to-transparent z-10"></div>

 <div class="absolute bottom-16 left-16 right-16 text-white max-w-lg z-20">
 <blockquote class="text-3xl font-serif leading-snug mb-8 font-light italic">
 <span class="text-mask"><span class="text-mask-inner quote-text">"RentEase transformed our</span></span><br>
 <span class="text-mask"><span class="text-mask-inner quote-text">empty apartment into a</span></span><br>
 <span class="text-mask"><span class="text-mask-inner quote-text text-champagne">curated home."</span></span>
 </blockquote>
 <div class="flex items-center gap-5 opacity-0" id="quote-author">
 <div class="w-12 h-12 flex items-center justify-center font-serif italic text-champagne text-lg border" style="border-color: rgba(197,169,139,0.5); background: rgba(24,24,27,0.3); backdrop-filter: blur(8px);">S</div>
 <div>
 <div class="font-medium text-[13px] tracking-widest uppercase text-white mb-1">Sarah Miller</div>
 <div class="text-[10px] text-champagne uppercase tracking-[0.2em]">Interior Designer</div>
 </div>
 </div>
 </div>
 </div>
  </div>

  <script>
  document.addEventListener('DOMContentLoaded', () => {
 (window.RentEase ? RentEase.gsapReady : Promise.resolve(null)).then(function(gsap) {
 if (!gsap) {
 document.querySelectorAll('.gsap-fade, #quote-author').forEach(el => el.style.opacity = '1');
 document.querySelectorAll('.text-mask-inner').forEach(el => el.style.transform = 'translateY(0)');
 const overlay = document.getElementById('image-overlay');
 if (overlay) overlay.style.display = 'none';
 const img = document.getElementById('hero-image');
 if (img) img.style.transform = 'scale(1)';
 return;
 }
 gsap.context(() => {
 const tl = gsap.timeline();
 tl.to('.text-mask-inner:not(.quote-text)', { y: '0%', duration: 1.2, ease: 'power4.out', stagger: 0.15 });
 tl.to('#image-overlay', { clipPath: 'inset(0 0 0 100%)', duration: 1.5, ease: 'power4.inOut' }, "-=1.0");
 tl.to('#hero-image', { scale: 1, duration: 2.5, ease: 'power2.out' }, "-=1.5");
 tl.to('.gsap-fade', { y: 0, opacity: 1, duration: 1, stagger: 0.1, ease: 'power3.out', clearProps: 'transform' }, "-=2.0");
 tl.to('.quote-text', { y: '0%', duration: 1.2, ease: 'power4.out', stagger: 0.15 }, "-=1.5");
 tl.to('#quote-author', { opacity: 1, y: 0, duration: 1, ease: 'power3.out' }, "-=1.0");
 });
 });
 });
  </script>
  <script>if('serviceWorker' in navigator){window.addEventListener('load',()=>{navigator.serviceWorker.register('<?= baseUrl('/sw.js') ?>')});}</script>
</body>
</html>
