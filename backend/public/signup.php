<?php
declare(strict_types=1);

use RentEase\Services\AuthService;
use RentEase\Support\Csrf;
use RentEase\Support\Session;

require __DIR__ . '/../bootstrap.php';

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
$pageTitle = 'Start your story — RentEase';
$pageDescription = 'Join RentEase to rent premium furniture, track deliveries, and earn member rewards.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="theme-color" content="#0a0e1a">
    <link rel="icon" type="image/svg+xml" href="<?= baseUrl('/favicon.svg') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Instrument+Serif:ital@0;1&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="<?= baseUrl('/assets/css/theme.css') ?>">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { ink: '#0a0e1a', accent: '#14b8a6' },
                    fontFamily: { sans: ['Inter', 'sans-serif'], serif: ['"Instrument Serif"', 'serif'], mono: ['"JetBrains Mono"', 'monospace'] }
                }
            }
        }
    </script>
    <style>
        :root { --ink: #0a0e1a; --ink-2: #131826; --accent: #14b8a6; --accent-glow: rgba(20, 184, 166, 0.4); }
        html, body { height: 100%; overscroll-behavior: none; }
        body { font-family: 'Inter', sans-serif; -webkit-font-smoothing: antialiased; background: var(--ink); color: #fff; }

        .cinematic-wrap { position: fixed; inset: 0; z-index: 0; overflow: hidden; }
        .cinematic-bg { position: absolute; inset: -8%; width: 116%; height: 116%; object-fit: cover; transform: scale(1.1); will-change: transform; }
        .atmosphere { position: absolute; inset: 0; pointer-events: none; background: radial-gradient(ellipse 60% 50% at 75% 40%, rgba(245, 158, 11, 0.10) 0%, transparent 70%), radial-gradient(ellipse 50% 40% at 25% 60%, rgba(20, 184, 166, 0.08) 0%, transparent 70%), linear-gradient(225deg, rgba(10, 14, 26, 0.7) 0%, rgba(10, 14, 26, 0.4) 50%, rgba(10, 14, 26, 0.85) 100%); }
        .vignette { position: absolute; inset: 0; pointer-events: none; background: radial-gradient(ellipse at center, transparent 30%, rgba(0,0,0,0.6) 100%); }
        .grain { position: absolute; inset: 0; pointer-events: none; opacity: 0.05; mix-blend-mode: overlay; background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'><filter id='n'><feTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='2'/></filter><rect width='100%' height='100%' filter='url(%23n)'/></svg>"); }
        .cursor-glow { position: fixed; left: 0; top: 0; width: 500px; height: 500px; background: radial-gradient(circle, rgba(245, 158, 11, 0.06) 0%, transparent 60%); border-radius: 9999px; pointer-events: none; z-index: 1; will-change: transform; transform: translate(-500px, -500px); }

        .aperture-wrap { position: relative; width: 100%; aspect-ratio: 1; max-width: 480px; margin: 0 auto; }
        .aperture-svg { width: 100%; height: 100%; overflow: visible; filter: drop-shadow(0 30px 60px rgba(0,0,0,0.4)) drop-shadow(0 0 40px rgba(245, 158, 11, 0.15)); animation: apertureBreathe 8s ease-in-out infinite; }
        @keyframes apertureBreathe { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.02); } }
        .aperture-blades { transform-origin: 250px 250px; animation: bladesRotate 60s linear infinite; }
        @keyframes bladesRotate { to { transform: rotate(360deg); } }
        .aperture-rays { position: absolute; inset: -30%; pointer-events: none; animation: raysRotate 40s linear infinite; opacity: 0.4; }
        @keyframes raysRotate { to { transform: rotate(360deg); } }
        .ring-text { position: absolute; inset: 0; animation: ringTextRotate 30s linear infinite; }
        @keyframes ringTextRotate { to { transform: rotate(360deg); } }

        .editorial-headline { font-size: clamp(2.5rem, 6vw, 5.5rem); font-weight: 800; line-height: 0.92; letter-spacing: -0.04em; }
        .word { display: inline-block; opacity: 0; transform: translateY(30px) rotate(3deg); animation: wordIn 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes wordIn { to { opacity: 1; transform: translateY(0) rotate(0deg); } }

        .form-panel { position: relative; background: rgba(19, 24, 38, 0.85); backdrop-filter: blur(32px) saturate(150%); -webkit-backdrop-filter: blur(32px) saturate(150%); border-radius: 28px; box-shadow: 0 1px 0 rgba(255, 255, 255, 0.08) inset, 0 40px 100px -20px rgba(0, 0, 0, 0.5), 0 20px 40px -10px rgba(0, 0, 0, 0.3); overflow: hidden; }
        .form-panel::before { content: ''; position: absolute; inset: 0; border-radius: inherit; padding: 1.5px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.6), rgba(245, 158, 11, 0.05) 40%, rgba(20, 184, 166, 0.5) 60%, rgba(245, 158, 11, 0.6)); background-size: 300% 300%; animation: borderOrbit 6s linear infinite; -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0); -webkit-mask-composite: xor; mask-composite: exclude; pointer-events: none; }
        @keyframes borderOrbit { 0% { background-position: 0% 50%; } 100% { background-position: 300% 50%; } }

        .status-bar { display: flex; align-items: center; justify-content: space-between; padding: 0.85rem 1.25rem; background: rgba(0, 0, 0, 0.25); border-bottom: 1px solid rgba(255, 255, 255, 0.06); font-family: 'JetBrains Mono', monospace; font-size: 0.7rem; color: rgba(255, 255, 255, 0.5); letter-spacing: 0.05em; }
        .status-dot { width: 6px; height: 6px; border-radius: 9999px; background: #f59e0b; box-shadow: 0 0 8px #f59e0b; animation: pulse 2s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }

        .auth-field { position: relative; }
        .auth-label { display: block; font-size: 0.7rem; font-weight: 600; color: rgba(255, 255, 255, 0.5); letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 0.5rem; font-family: 'JetBrains Mono', monospace; }
        .auth-input { width: 100%; padding: 0.95rem 1rem 0.95rem 2.75rem; background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; color: #fff; font-size: 0.95rem; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); outline: none; }
        .auth-input::placeholder { color: rgba(255, 255, 255, 0.3); }
        .auth-input:hover { border-color: rgba(255, 255, 255, 0.15); background: rgba(0, 0, 0, 0.4); }
        .auth-field.is-focused .auth-input { border-color: var(--accent); background: rgba(0, 0, 0, 0.5); box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.1), 0 0 20px rgba(20, 184, 166, 0.15); }
        .field-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: rgba(255, 255, 255, 0.3); font-size: 18px; pointer-events: none; transition: color 0.3s, transform 0.3s; }
        .auth-field.is-focused .field-icon { color: var(--accent); transform: translateY(-50%) scale(1.1); }

        .btn-stamp { position: relative; overflow: hidden; background: var(--accent); color: #041527; font-weight: 700; letter-spacing: 0.02em; transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1); }
        .btn-stamp::before { content: ''; position: absolute; inset: 0; background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,0.4) 50%, transparent 70%); transform: translateX(-100%); transition: transform 0.7s; }
        .btn-stamp:hover { transform: translateY(-2px); box-shadow: 0 12px 30px -8px var(--accent-glow), 0 0 20px rgba(20, 184, 166, 0.3); }
        .btn-stamp:hover::before { transform: translateX(100%); }
        .btn-stamp:active { transform: translateY(0) scale(0.98); }
        .btn-stamp.is-loading { pointer-events: none; }
        .btn-stamp .btn-text, .btn-stamp .btn-loader { transition: all 0.25s; }
        .btn-stamp .btn-loader { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; opacity: 0; transform: translateY(8px); }
        .btn-stamp.is-loading .btn-text { opacity: 0; transform: translateY(-8px); }
        .btn-stamp.is-loading .btn-loader { opacity: 1; transform: translateY(0); }
        .spinner { width: 16px; height: 16px; border: 2px solid rgba(4, 21, 39, 0.3); border-top-color: #041527; border-radius: 9999px; animation: spin 0.7s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }

        .is-submitting .cinematic-bg { transform: scale(1.3) !important; filter: blur(8px) brightness(0.6); transition: transform 0.8s, filter 0.8s; }
        .is-submitting .form-panel { opacity: 0.85; transform: scale(0.98); transition: all 0.4s; }
        .is-submitting .aperture-svg { transform: scale(0.95); opacity: 0.7; transition: all 0.6s; }

        .stagger-in { opacity: 0; transform: translateY(20px); animation: staggerIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes staggerIn { to { opacity: 1; transform: translateY(0); } }
        .s-1 { animation-delay: 0.05s; } .s-2 { animation-delay: 0.15s; } .s-3 { animation-delay: 0.25s; }
        .s-4 { animation-delay: 0.35s; } .s-5 { animation-delay: 0.45s; } .s-6 { animation-delay: 0.55s; }
        .s-7 { animation-delay: 0.65s; } .s-8 { animation-delay: 0.75s; } .s-9 { animation-delay: 0.85s; }
        .s-10 { animation-delay: 0.95s; }

        .pw-meter { height: 3px; border-radius: 9999px; background: rgba(255, 255, 255, 0.05); overflow: hidden; margin-top: 0.5rem; }
        .pw-meter-fill { height: 100%; width: 0%; transition: width 0.3s ease, background 0.3s ease; }

        @media (max-width: 1023px) { .aperture-wrap { max-width: 280px; } .form-panel { border-radius: 24px; } }
        @media (max-width: 640px) { .form-panel { border-radius: 20px; } .form-panel-body { padding: 1.5rem !important; } .editorial-headline { font-size: 2.5rem; } }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; animation-iteration-count: 1 !important; transition-duration: 0.01ms !important; }
            .cinematic-bg { transform: scale(1.05) !important; }
            .stagger-in, .word { opacity: 1; transform: none; }
            .cursor-glow { display: none; }
            .grain { opacity: 0.03; }
        }
    </style>
</head>
<body class="min-h-screen overflow-x-hidden">

    <div class="cinematic-wrap">
        <img class="cinematic-bg"
             src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=2400&q=85&auto=format&fit=crop"
             alt="" loading="eager"
             onerror="this.src='https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=2400&q=85&auto=format&fit=crop'">
        <div class="atmosphere"></div>
        <div class="vignette"></div>
        <div class="grain"></div>
    </div>

    <header class="relative z-20 flex items-center justify-between px-5 sm:px-8 lg:px-12 py-5">
        <a href="<?= baseUrl('/') ?>" class="stagger-in s-1 flex items-center gap-2.5 group">
            <div class="w-9 h-9 rounded-lg bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center group-hover:bg-white/20 transition-all duration-300 group-hover:scale-105">
                <span class="text-white font-bold text-sm">R</span>
            </div>
            <span class="text-white font-semibold text-base tracking-tight">RentEase<span class="text-teal-400">.</span></span>
        </a>
        <div class="stagger-in s-2 hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/5 backdrop-blur-md border border-white/10">
            <span class="status-dot"></span>
            <span class="text-[11px] font-mono text-white/70 tracking-wider">LIVE</span>
            <span class="text-white/30">·</span>
            <span class="text-[11px] font-mono text-white/70"><span data-live-count>2,847</span> online</span>
        </div>
        <a href="<?= baseUrl('/login') ?>" class="stagger-in s-2 group inline-flex items-center gap-1.5 text-sm font-medium text-white/80 hover:text-white transition-colors">
            Already a member?
            <span class="text-teal-300 inline-flex items-center gap-1 group-hover:gap-2 transition-all">
                Sign in
                <span class="material-symbols-outlined text-base">arrow_forward</span>
            </span>
        </a>
    </header>

    <main class="relative z-10 lg:absolute lg:inset-x-0 lg:top-0 lg:bottom-0 lg:pt-24 flex items-center justify-center px-5 sm:px-8 lg:px-12 py-8 lg:py-0">

        <div class="w-full max-w-6xl grid lg:grid-cols-[1.1fr_0.9fr] gap-10 lg:gap-16 items-center">

            <!-- LEFT: FORM PANEL -->
            <div class="order-1 w-full max-w-md mx-auto lg:mr-auto">
                <div class="form-panel stagger-in s-3">

                    <div class="status-bar">
                        <div class="flex items-center gap-2">
                            <span class="status-dot"></span>
                            <span>RENTEASE · NEW MEMBER</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span>SIGNUP 01</span>
                            <span class="material-symbols-outlined" style="font-size:14px;">wifi</span>
                        </div>
                    </div>

                    <div class="form-panel-body relative p-7 sm:p-9">

                        <?php if ($error): ?>
                            <div class="mb-5 p-3.5 rounded-xl bg-rose-500/10 border border-rose-400/20 flex gap-2.5 items-start text-rose-200 text-sm" role="alert">
                                <span class="material-symbols-outlined text-rose-400 text-lg mt-0.5 flex-shrink-0">error</span>
                                <p class="leading-relaxed"><?= htmlspecialchars($error) ?></p>
                            </div>
                        <?php endif; ?>

                        <form action="<?= baseUrl('/signup') ?>" method="POST" class="space-y-4" novalidate data-cinematic-submit>
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                            <div class="stagger-in s-4 auth-field">
                                <label for="full_name" class="auth-label">Full name</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined field-icon">person</span>
                                    <input type="text" id="full_name" name="full_name" required autocomplete="name"
                                           class="auth-input" placeholder="Jane Cooper"
                                           value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="stagger-in s-5 auth-field">
                                <label for="email" class="auth-label">Email</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined field-icon">mail</span>
                                    <input type="email" id="email" name="email" required autocomplete="email"
                                           class="auth-input" placeholder="you@company.com"
                                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="stagger-in s-6 auth-field">
                                <label for="password" class="auth-label">Password</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined field-icon">lock</span>
                                    <input type="password" id="password" name="password" required autocomplete="new-password"
                                           class="auth-input" placeholder="At least 8 characters" minlength="8"
                                           oninput="const v=this.value; const m=document.getElementById('pw-meter-fill'); const r=document.getElementById('pw-hint'); if(!v){m.style.width='0%';r.textContent='';return;} let s=0; if(v.length>=8)s++; if(/[A-Z]/.test(v))s++; if(/[0-9]/.test(v))s++; if(/[^a-zA-Z0-9]/.test(v))s++; const pct=[0,30,55,80,100][s]; m.style.width=pct+'%'; const colors=['#ef4444','#f59e0b','#eab308','#10b981','#14b8a6']; const labels=['','Weak','Fair','Good','Strong']; m.style.background=colors[s]; r.textContent=labels[s];">
                                    <button type="button" onclick="const p=this.previousElementSibling; p.type = p.type === 'password' ? 'text' : 'password'; this.querySelector('span').textContent = p.type === 'password' ? 'visibility_off' : 'visibility';" class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 text-white/30 hover:text-white/70 rounded-lg transition-colors" tabindex="-1" aria-label="Toggle password visibility">
                                        <span class="material-symbols-outlined text-lg">visibility_off</span>
                                    </button>
                                </div>
                                <div class="pw-meter"><div id="pw-meter-fill" class="pw-meter-fill"></div></div>
                                <p id="pw-hint" class="mt-1 text-[10px] font-mono text-white/40 min-h-[1em]"></p>
                            </div>

                            <label class="stagger-in s-7 flex items-start gap-2.5 cursor-pointer select-none">
                                <input type="checkbox" id="terms" name="terms" required class="w-4 h-4 mt-0.5 rounded border-white/20 bg-white/5 accent-teal-500 cursor-pointer flex-shrink-0">
                                <span class="text-xs text-white/60 leading-relaxed">
                                    I agree to the <a href="<?= baseUrl('/terms') ?>" class="text-white/90 font-semibold hover:text-teal-300">Terms</a> and <a href="<?= baseUrl('/privacy') ?>" class="text-white/90 font-semibold hover:text-teal-300">Privacy Policy</a>.
                                </span>
                            </label>

                            <button type="submit" class="stagger-in s-8 btn-stamp w-full inline-flex items-center justify-center gap-2 py-4 rounded-xl text-sm">
                                <span class="btn-text inline-flex items-center gap-2">
                                    Create my account
                                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                                </span>
                                <span class="btn-loader">
                                    <span class="spinner"></span>
                                    <span class="ml-2 text-sm">Setting up…</span>
                                </span>
                            </button>
                        </form>

                        <?php if (!empty($oauthProviders)): ?>
                        <div class="stagger-in s-9 mt-6 flex items-center gap-4">
                            <div class="flex-1 h-px bg-white/10"></div>
                            <span class="text-[10px] font-mono font-semibold text-white/40 uppercase tracking-[0.2em]">or</span>
                            <div class="flex-1 h-px bg-white/10"></div>
                        </div>

                        <div class="stagger-in s-9 mt-4 grid grid-cols-<?= min(2, count($oauthProviders)) ?> gap-2.5">
                            <?php foreach ($oauthProviders as $id => $provider): ?>
                                <a href="<?= baseUrl('/api/auth/oauth?provider=' . $id) ?>"
                                   class="flex items-center justify-center gap-2.5 py-2.5 px-3 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 rounded-xl transition-all duration-200 group">
                                    <img src="<?= $provider['icon'] ?>" alt="" class="w-4 h-4 group-hover:scale-110 transition-transform duration-200">
                                    <span class="text-xs font-semibold text-white/80"><?= $provider['name'] ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>

                        <p class="stagger-in s-10 mt-6 text-center text-xs text-white/40">
                            Already a member?
                            <a href="<?= baseUrl('/login') ?>" class="text-teal-300 font-semibold hover:text-teal-200">Sign in</a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- RIGHT: APERTURE + HEADLINE -->
            <div class="flex flex-col items-center lg:items-end text-center lg:text-right order-2">

                <div class="stagger-in s-2 aperture-wrap mb-8 lg:mb-10">
                    <svg class="aperture-rays" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <radialGradient id="ray-grad" cx="50%" cy="50%">
                                <stop offset="0%" stop-color="#f59e0b" stop-opacity="0.3"/>
                                <stop offset="100%" stop-color="#f59e0b" stop-opacity="0"/>
                            </radialGradient>
                        </defs>
                        <g fill="url(#ray-grad)">
                            <path d="M 300 300 L 580 200 L 580 400 Z" />
                            <path d="M 300 300 L 580 200 L 580 400 Z" transform="rotate(45 300 300)"/>
                            <path d="M 300 300 L 580 200 L 580 400 Z" transform="rotate(90 300 300)"/>
                            <path d="M 300 300 L 580 200 L 580 400 Z" transform="rotate(135 300 300)"/>
                            <path d="M 300 300 L 580 200 L 580 400 Z" transform="rotate(180 300 300)"/>
                            <path d="M 300 300 L 580 200 L 580 400 Z" transform="rotate(225 300 300)"/>
                            <path d="M 300 300 L 580 200 L 580 400 Z" transform="rotate(270 300 300)"/>
                            <path d="M 300 300 L 580 200 L 580 400 Z" transform="rotate(315 300 300)"/>
                        </g>
                    </svg>

                    <svg class="aperture-svg" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <clipPath id="lens-clip-s"><circle cx="250" cy="250" r="140"/></clipPath>
                            <linearGradient id="blade-grad-s" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#1a2030"/>
                                <stop offset="100%" stop-color="#0a0e1a"/>
                            </linearGradient>
                            <radialGradient id="lens-glow-s" cx="50%" cy="50%">
                                <stop offset="0%" stop-color="rgba(245, 158, 11, 0.15)"/>
                                <stop offset="70%" stop-color="rgba(245, 158, 11, 0)"/>
                            </radialGradient>
                        </defs>
                        <circle cx="250" cy="250" r="240" fill="#0a0e1a" stroke="rgba(255,255,255,0.1)" stroke-width="2"/>
                        <circle cx="250" cy="250" r="225" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/>
                        <circle cx="250" cy="250" r="200" fill="none" stroke="rgba(255,255,255,0.08)" stroke-width="1"/>
                        <image href="https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?w=600&q=80&auto=format&fit=crop"
                               x="110" y="110" width="280" height="280" clip-path="url(#lens-clip-s)" preserveAspectRatio="xMidYMid slice"/>
                        <circle cx="250" cy="250" r="140" fill="url(#lens-glow-s)"/>
                        <g class="aperture-blades" fill="url(#blade-grad-s)" stroke="rgba(255,255,255,0.1)" stroke-width="0.5">
                            <polygon points="250,250 250,110 358,142"/>
                            <polygon points="250,250 358,142 390,250"/>
                            <polygon points="250,250 390,250 358,358"/>
                            <polygon points="250,250 358,358 250,390"/>
                            <polygon points="250,250 250,390 142,358"/>
                            <polygon points="250,250 142,358 110,250"/>
                            <polygon points="250,250 110,250 142,142"/>
                            <polygon points="250,250 142,142 250,110"/>
                        </g>
                        <circle cx="250" cy="250" r="2" fill="rgba(255,255,255,0.8)"/>
                        <circle cx="250" cy="250" r="6" fill="none" stroke="rgba(255,255,255,0.3)" stroke-width="0.5"/>
                        <circle cx="250" cy="250" r="140" fill="none" stroke="rgba(245, 158, 11, 0.3)" stroke-width="1"/>
                        <circle cx="250" cy="250" r="155" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="0.5"/>
                        <g stroke="rgba(255,255,255,0.2)" stroke-width="1">
                            <line x1="250" y1="15" x2="250" y2="25"/>
                            <line x1="250" y1="475" x2="250" y2="485"/>
                            <line x1="15" y1="250" x2="25" y2="250"/>
                            <line x1="475" y1="250" x2="485" y2="250"/>
                        </g>
                    </svg>

                    <svg class="ring-text absolute inset-0" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <path id="circle-path-s" d="M 250, 250 m -210, 0 a 210,210 0 1,1 420,0 a 210,210 0 1,1 -420,0"/>
                        </defs>
                        <text font-family="JetBrains Mono, monospace" font-size="11" fill="rgba(255,255,255,0.4)" letter-spacing="4">
                            <textPath href="#circle-path-s">RENTEASE · WELCOME ABOARD · EST 2024 · </textPath>
                        </text>
                    </svg>
                </div>

                <div class="max-w-xl">
                    <div class="stagger-in s-3 inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-amber-500/10 border border-amber-400/20 mb-5">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                        <span class="text-[10px] font-mono font-semibold tracking-[0.2em] text-amber-300 uppercase">Join in 60s</span>
                    </div>
                    <h1 class="editorial-headline text-white">
                        <span style="display:block;"><span class="word" style="animation-delay:0.4s;">Start</span> <span class="word" style="animation-delay:0.48s;">your</span></span>
                        <span style="display:block;"><span class="word font-serif italic font-normal text-amber-300" style="animation-delay:0.56s; font-weight: 400;">story.</span></span>
                        <span style="display:block;"><span class="word" style="animation-delay:0.64s;">Live better.</span></span>
                    </h1>
                    <p class="stagger-in s-6 mt-6 text-white/60 text-base sm:text-lg leading-relaxed max-w-md mx-auto lg:ml-auto">
                        Premium furniture, delivered and assembled. No deposits. No commitments. Just effortless living.
                    </p>
                </div>
            </div>
        </div>
    </main>

    <script src="<?= baseUrl('/assets/js/auth-effects.js') ?>" defer></script>
</body>
</html>
