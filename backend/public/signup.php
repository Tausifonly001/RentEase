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
 $error = 'Your session has expired. Please refresh and try again.';
 } else {
 $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
 $password = $_POST['password'] ?? '';
 $fullName = filter_input(INPUT_POST, 'full_name', FILTER_DEFAULT);

 if (!$email || empty($password) || empty($fullName)) {
 $error = 'All fields are required. Please check your inputs.';
 } elseif (strlen($password) < 8) {
 $error = 'Password must be at least 8 characters long.';
 } elseif (!preg_match('/[0-9]/', $password)) {
 $error = 'Password must contain at least one number.';
 } elseif (!preg_match('/[^a-zA-Z0-9]/', $password)) {
 $error = 'Password must contain at least one special character.';
 } else {
 try {
 $payload = ['email' => $email, 'password' => $password, 'full_name' => $fullName];
 $authService->signup($payload);

 try {
 $resend = new \RentEase\Services\Email\ResendService($config);
 $resend->send($email, 'Welcome to RentEase!', "<h1>Welcome, {$fullName}!</h1><p>Thanks for joining RentEase.</p>");
 } catch (\Throwable $e) { error_log("Welcome email failed: " . $e->getMessage()); }

 try {
 $onesignal = new \RentEase\Services\NotificationService($config);
 $onesignal->sendPush([$email], 'Welcome to RentEase!', 'Your account has been created successfully.');
 } catch (\Throwable $e) { error_log("Push notification failed: " . $e->getMessage()); }

 $loginResult = $authService->login(['email' => $email, 'password' => $password]);
 $token = (string) ($loginResult['access_token'] ?? '');
 if ($token !== '') $authService->persistSession($loginResult, true);
 header('Location: ' . baseUrl('/'));
 exit;
 } catch (Throwable $e) {
 $error = 'Signup failed. That email may already be in use or your password is too weak.';
 }
 }
 }
}

$oauthProviders = $config['enabled_oauth_providers'] ?? [];
$pageTitle = 'Start your story - RentEase';
$pageDescription = 'Join RentEase to rent premium furniture, track deliveries, and earn member rewards.';
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
 <div class="flex min-h-screen w-full">
 <!-- Form Side -->
 <div class="w-full lg:w-1/2 flex flex-col px-6 sm:px-12 lg:px-20 py-10 relative z-10 bg-surface">
 <header class="flex items-center justify-between lg:justify-end mb-auto opacity-0 gsap-fade">
 <a href="<?= baseUrl('/') ?>" class="lg:hidden inline-flex items-center gap-3 text-xl font-serif font-medium tracking-tight text-ink outline-none focus-visible:ring-1 ring-champagne group">
 <span class="w-8 h-8 flex items-center justify-center bg-ink text-white text-xs font-medium group-hover:bg-champagne transition-colors duration-500">R</span>
 </a>
 <p class="text-[11px] font-medium text-muted-light uppercase tracking-[0.15em]">
 Already a member? <a href="<?= baseUrl('/login') ?>" class="text-ink hover:text-champagne transition-colors duration-300 ml-1 outline-none focus-visible:ring-1 ring-champagne">Sign in</a>
 </p>
 </header>

 <div class="w-full max-w-sm mx-auto py-12 lg:py-0 my-auto">
 <div class="mb-12">
 <div class="hidden lg:inline-flex items-center gap-3 mb-8 opacity-0 gsap-fade group outline-none focus-visible:ring-1 ring-champagne">
 <span class="w-8 h-8 flex items-center justify-center bg-ink text-white text-xs font-medium group-hover:bg-champagne transition-colors duration-500">R</span>
 <span class="font-serif font-medium tracking-tight text-ink text-xl">RentEase.</span>
 </div>
 <h1 class="text-4xl md:text-5xl font-serif text-ink mb-4 tracking-tight leading-tight">
 <span class="text-mask"><span class="text-mask-inner">Start your</span></span><br>
 <span class="text-mask"><span class="text-mask-inner italic text-champagne">story.</span></span>
 </h1>
 <p class="text-muted text-sm font-light opacity-0 gsap-fade">Join RentEase to access premium living.</p>
 </div>

 <?php if ($error): ?>
 <div class="mb-8 p-4 bg-rose-50 border border-rose-200 text-rose-700 text-sm font-light opacity-0 gsap-fade">
 <?= htmlspecialchars($error) ?>
 </div>
 <?php endif; ?>

 <form action="<?= baseUrl('/signup') ?>" method="POST" class="space-y-6" novalidate>
 <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

 <div class="space-y-2 opacity-0 gsap-fade">
 <label for="full_name" class="form-label">Full name</label>
 <input type="text" id="full_name" name="full_name" required autocomplete="name"
 class="form-input"
 placeholder="Jane Cooper"
 value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">
 </div>

 <div class="space-y-2 opacity-0 gsap-fade">
 <label for="email" class="form-label">Email</label>
 <input type="email" id="email" name="email" required autocomplete="email"
 class="form-input"
 placeholder="you@example.com"
 value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
 </div>

 <div class="space-y-2 opacity-0 gsap-fade">
 <label for="password" class="form-label">Password</label>
 <input type="password" id="password" name="password" required autocomplete="new-password"
 class="form-input"
 placeholder="At least 8 characters">
 </div>

 <div class="flex items-start pt-2 opacity-0 gsap-fade">
 <input type="checkbox" id="terms" name="terms" required class="w-4 h-4 accent-champagne cursor-pointer transition-colors duration-300 mt-0.5">
 <label for="terms" class="ml-3 text-sm text-muted font-light leading-snug cursor-pointer select-none">
 I agree to the <a href="<?= baseUrl('/terms') ?>" class="text-ink hover:text-champagne transition-colors duration-300 underline decoration-muted-light underline-offset-4">Terms</a> and <a href="<?= baseUrl('/privacy') ?>" class="text-ink hover:text-champagne transition-colors duration-300 underline decoration-muted-light underline-offset-4">Privacy Policy</a>.
 </label>
 </div>

 <button type="submit" class="btn-primary w-full mt-10 opacity-0 gsap-fade">Create Account</button>
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

 <footer class="mt-auto text-[10px] uppercase tracking-[0.15em] text-muted-light font-medium flex justify-center lg:justify-end opacity-0 gsap-fade">
 <span>&copy; <?= date('Y') ?> RentEase.</span>
 </footer>
 </div>

 <!-- Image Side -->
 <div class="hidden lg:block lg:w-1/2 relative bg-surface overflow-hidden" style="border-right: 1px solid rgba(231,229,228,0.6);">
 <div class="absolute inset-0 bg-champagne/10 z-10 clip-reveal" id="image-overlay"></div>
	<img src="<?= baseUrl('/assets/images/auth/signup_bg.png') ?>" alt="Designer Furniture" loading="lazy" decoding="async" class="absolute inset-0 w-full h-full object-cover origin-center scale-110" id="hero-image" style="filter: grayscale(30%);">
 <div class="absolute inset-0 bg-gradient-to-t from-ink/60 via-transparent to-transparent z-10"></div>

 <div class="absolute bottom-16 left-16 right-16 text-white max-w-lg z-20">
 <div class="inline-flex items-center gap-3 px-4 py-2 border glass-champagne text-champagne text-[9px] font-medium uppercase tracking-[0.25em] mb-8 opacity-0 gsap-fade">
 <span class="w-1.5 h-1.5 bg-champagne" style="animation: pulse-dot 2s ease-in-out infinite;"></span>
 Premium Living
 </div>
 <h2 class="text-3xl font-serif leading-tight mb-8 font-light italic">
 <span class="text-mask"><span class="text-mask-inner quote-text">Elevate your everyday</span></span><br>
 <span class="text-mask"><span class="text-mask-inner quote-text">with designer pieces,</span></span><br>
 <span class="text-mask"><span class="text-mask-inner quote-text text-champagne">curated for you.</span></span>
 </h2>
 <div class="flex gap-12 mt-10 pt-8 opacity-0" id="stats" style="border-top: 1px solid rgba(255,255,255,0.15);">
 <div>
 <div class="text-3xl font-serif text-white mb-2 italic">12k+</div>
 <div class="text-[9px] text-champagne uppercase tracking-[0.25em] font-medium">Happy Members</div>
 </div>
 <div>
 <div class="text-3xl font-serif text-white mb-2 italic">4.9/5</div>
 <div class="text-[9px] text-champagne uppercase tracking-[0.25em] font-medium">Average Rating</div>
 </div>
 </div>
 </div>
 </div>
 </div>

  <script>
  document.addEventListener('DOMContentLoaded', () => {
 (window.RentEase ? RentEase.gsapReady : Promise.resolve(null)).then(function(gsap) {
 if (!gsap) {
 document.querySelectorAll('.gsap-fade, #stats').forEach(el => el.style.opacity = '1');
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
 tl.to('#stats', { opacity: 1, y: 0, duration: 1, ease: 'power3.out' }, "-=1.0");
 });
 });
 });
 </script>
  <script>if('serviceWorker' in navigator){window.addEventListener('load',()=>{navigator.serviceWorker.register('<?= baseUrl('/sw.js') ?>')});}</script>
</body>
</html>
