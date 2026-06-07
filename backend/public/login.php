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

        if (!$email || empty($password)) {
            $error = 'Both email and password are required fields.';
        } else {
            try {
                $loginResult = $authService->login(['email' => $email, 'password' => $password]);
                $token = (string) ($loginResult['access_token'] ?? '');

                if ($token !== '') {
                    $rememberMe = !empty($_POST['remember']);
                    $authService->persistSession($loginResult, $rememberMe);
                    header('Location: ' . baseUrl('/'));
                    exit;
                } else {
                    $error = 'Authentication failed. Please verify your email and password.';
                }
            } catch (Throwable $e) {
                $error = 'Login failed. Please verify your credentials and try again.';
            }
        }
    }
}

$oauthProviders = $config['enabled_oauth_providers'] ?? [];
$pageTitle = 'Sign In — RentEase';
$pageDescription = 'Sign in to manage your rentals, track deliveries, and access member rewards.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="theme-color" content="#041527">
    <link rel="icon" type="image/svg+xml" href="<?= baseUrl('/favicon.svg') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="<?= baseUrl('/assets/css/theme.css') ?>">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { ink: '#041527', accent: '#14b8a6' },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['"Instrument Serif"', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        html, body { height: 100%; overscroll-behavior: none; }
        body { font-family: 'Inter', sans-serif; -webkit-font-smoothing: antialiased; background: #041527; color: #fff; }

        /* ========== CINEMATIC BACKGROUND ========== */
        .cinematic-wrap { position: fixed; inset: 0; z-index: 0; overflow: hidden; }
        .cinematic-bg {
            position: absolute; inset: -8%;
            width: 116%; height: 116%;
            object-fit: cover;
            transform: scale(1.08);
            will-change: transform;
        }
        @keyframes ken-burns {
            0%   { transform: scale(1.08) translate(0%, 0%); }
            100% { transform: scale(1.16) translate(-1%, -0.5%); }
        }
        .grade-overlay {
            position: absolute; inset: 0; pointer-events: none;
            background:
                radial-gradient(ellipse at 30% 30%, rgba(20, 184, 166, 0.08) 0%, transparent 60%),
                radial-gradient(ellipse at 70% 70%, rgba(245, 158, 11, 0.06) 0%, transparent 60%),
                linear-gradient(90deg, rgba(4, 21, 39, 0.55) 0%, rgba(4, 21, 39, 0.30) 50%, rgba(4, 21, 39, 0.80) 100%);
        }
        .vignette {
            position: absolute; inset: 0; pointer-events: none;
            background: radial-gradient(ellipse at center, transparent 45%, rgba(0,0,0,0.45) 100%);
        }
        .grain {
            position: absolute; inset: 0; pointer-events: none; opacity: 0.06; mix-blend-mode: overlay;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'><filter id='n'><feTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='2'/></filter><rect width='100%' height='100%' filter='url(%23n)'/></svg>");
        }
        .letterbox { position: absolute; left: 0; right: 0; height: 5vh; max-height: 48px; min-height: 24px; background: #000; z-index: 5; }
        .letterbox-top { top: 0; }
        .letterbox-bottom { bottom: 0; }
        @media (max-width: 1023px) { .letterbox { display: none; } }

        .particles { position: absolute; inset: 0; pointer-events: none; overflow: hidden; }
        .particle {
            position: absolute; bottom: -10px;
            background: radial-gradient(circle, rgba(255,255,255,0.85) 0%, rgba(255,255,255,0) 70%);
            border-radius: 9999px;
            animation: drift linear infinite;
            will-change: transform;
        }
        @keyframes drift {
            0%   { transform: translate(0, 0) scale(1); }
            50%  { transform: translate(15px, -50vh) scale(0.7); }
            100% { transform: translate(-8px, -110vh) scale(0.3); }
        }

        .cursor-glow {
            position: fixed; left: 0; top: 0;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(20, 184, 166, 0.08) 0%, transparent 60%);
            border-radius: 9999px; pointer-events: none;
            z-index: 1; will-change: transform;
            transform: translate(-500px, -500px);
        }

        /* ========== WORD REVEAL (CSS-only, no JS split) ========== */
        .word { display: inline-block; opacity: 0; transform: translateY(24px); animation: wordIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes wordIn { to { opacity: 1; transform: translateY(0); } }

        /* ========== GLASS CARD ========== */
        .tilt-card {
            background: rgba(255, 255, 255, 0.74);
            backdrop-filter: blur(28px) saturate(180%);
            -webkit-backdrop-filter: blur(28px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow:
                0 1px 0 rgba(255, 255, 255, 0.9) inset,
                0 30px 80px -20px rgba(0, 0, 0, 0.4),
                0 10px 30px -10px rgba(0, 0, 0, 0.2);
            transform-style: preserve-3d;
            transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: transform;
            position: relative;
            overflow: hidden;
        }
        .card-highlight {
            position: absolute; inset: 0; pointer-events: none;
            opacity: 0; transition: opacity 0.4s;
        }
        .tilt-card:hover .card-highlight { opacity: 1; }

        /* ========== FORM FIELDS ========== */
        .auth-field { position: relative; }
        .auth-input {
            width: 100%; padding: 1.05rem 1rem 1.05rem 3rem;
            background: rgba(255, 255, 255, 0.55);
            border: 1.5px solid rgba(15, 23, 42, 0.08);
            border-radius: 14px;
            color: #0f172a;
            font-size: 0.95rem;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            outline: none;
        }
        .auth-input::placeholder { color: #94a3b8; transition: opacity 0.2s; }
        .auth-field.is-focused .auth-input::placeholder { opacity: 0.4; }
        .auth-input:hover { border-color: rgba(15, 23, 42, 0.18); background: rgba(255, 255, 255, 0.7); }
        .auth-field.is-focused .auth-input {
            border-color: #14b8a6;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.12);
        }
        .auth-field .field-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 20px; pointer-events: none;
            transition: color 0.25s, transform 0.25s;
        }
        .auth-field.is-focused .field-icon { color: #14b8a6; transform: translateY(-50%) scale(1.1); }

        /* ========== SUBMIT BUTTON ========== */
        .btn-cinematic {
            position: relative; overflow: hidden;
            background: #041527; color: #fff;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .btn-cinematic::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }
        .btn-cinematic:hover { background: #0f172a; transform: translateY(-2px); box-shadow: 0 12px 30px -8px rgba(4,21,39,0.5); }
        .btn-cinematic:hover::before { transform: translateX(100%); }
        .btn-cinematic:active { transform: translateY(0); }
        .btn-cinematic.is-loading { pointer-events: none; opacity: 0.95; }
        .btn-cinematic .btn-text, .btn-cinematic .btn-loader { transition: all 0.25s; }
        .btn-cinematic .btn-loader {
            position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;
            opacity: 0; transform: translateY(8px);
        }
        .btn-cinematic.is-loading .btn-text { opacity: 0; transform: translateY(-8px); }
        .btn-cinematic.is-loading .btn-loader { opacity: 1; transform: translateY(0); }
        .spinner {
            width: 16px; height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 9999px;
            animation: spin 0.7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ========== SUBMIT TRANSITION ========== */
        .is-submitting .cinematic-bg { transform: scale(1.25) !important; filter: blur(6px) brightness(0.7); transition: transform 0.7s, filter 0.7s; }
        .is-submitting .tilt-card { opacity: 0.7; transform: scale(0.98); transition: all 0.4s; }

        /* ========== STAGGER ANIMATIONS ========== */
        .stagger-in { opacity: 0; transform: translateY(16px); animation: staggerIn 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes staggerIn { to { opacity: 1; transform: translateY(0); } }
        .s-1 { animation-delay: 0.05s; }
        .s-2 { animation-delay: 0.15s; }
        .s-3 { animation-delay: 0.25s; }
        .s-4 { animation-delay: 0.35s; }
        .s-5 { animation-delay: 0.45s; }
        .s-6 { animation-delay: 0.55s; }
        .s-7 { animation-delay: 0.65s; }

        /* Counter (hidden until JS animates) */
        [data-counter] { opacity: 0; transition: opacity 0.3s; }
        [data-counter].is-animating { opacity: 1; }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1023px) {
            .editorial-panel { display: none !important; }
            .cinematic-wrap::after {
                content: ''; position: absolute; inset: 0;
                background: linear-gradient(180deg, rgba(4,21,39,0.82) 0%, rgba(4,21,39,0.65) 100%);
            }
        }
        @media (min-width: 1024px) and (max-width: 1279px) {
            .editorial-headline { font-size: 4.25rem !important; line-height: 0.95 !important; }
        }
        @media (max-width: 640px) {
            .auth-form-card { padding: 1.75rem !important; border-radius: 1.5rem !important; }
            .editorial-mobile-headline { font-size: 2.5rem !important; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
            .cinematic-bg { animation: none !important; transform: scale(1.05) !important; }
            .stagger-in, .word { opacity: 1; transform: none; }
            .particle, .cursor-glow { display: none; }
            .grain { opacity: 0.03; }
        }
    </style>
</head>
<body class="min-h-screen overflow-x-hidden">

    <!-- ============ CINEMATIC BACKGROUND ============ -->
    <div class="cinematic-wrap">
        <img class="cinematic-bg"
             src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=2200&q=85&auto=format&fit=crop"
             alt=""
             loading="eager"
             onerror="this.src='https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?w=2200&q=85&auto=format&fit=crop'">
        <div class="grade-overlay"></div>
        <div class="vignette"></div>
        <div class="grain"></div>
        <div class="particles"></div>
        <div class="letterbox letterbox-top"></div>
        <div class="letterbox letterbox-bottom"></div>
    </div>

    <!-- ============ EDITORIAL BRAND PANEL (LEFT, DESKTOP) ============ -->
    <aside class="editorial-panel relative z-10 hidden lg:flex flex-col justify-between w-1/2 px-12 xl:px-20 py-14 text-white">

        <!-- Top: brand mark + tagline pill -->
        <div class="stagger-in s-1 flex items-center gap-3">
            <a href="<?= baseUrl('/') ?>" class="flex items-center gap-2.5 group">
                <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center group-hover:bg-white/20 group-hover:scale-105 transition-all duration-300">
                    <span class="text-white font-bold text-lg">R</span>
                </div>
                <span class="text-white font-semibold text-lg tracking-tight">RentEase<span class="text-teal-400">.</span></span>
            </a>
            <span class="ml-3 inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-[11px] font-medium tracking-widest uppercase text-white/80">
                <span class="w-1.5 h-1.5 rounded-full bg-teal-400 animate-pulse"></span>
                Member sign in
            </span>
        </div>

        <!-- Center: massive headline + subhead -->
        <div class="max-w-2xl">
            <h1 class="editorial-headline text-7xl xl:text-8xl font-bold leading-[0.92] tracking-tighter">
                <span style="display:block;"><span class="word" style="animation-delay:0.2s;">Your</span> <span class="word" style="animation-delay:0.28s;">space,</span></span>
                <span style="display:block;"><span class="word font-serif italic font-normal text-teal-300" style="animation-delay:0.36s;">effortlessly</span></span>
                <span style="display:block;"><span class="word" style="animation-delay:0.44s;">curated.</span></span>
            </h1>
            <p class="stagger-in s-4 mt-7 text-white/70 text-lg leading-relaxed max-w-md">
                Continue managing your rentals, tracking deliveries, and unlocking member rewards — all in one place.
            </p>
        </div>

        <!-- Bottom: stats strip with animated counters -->
        <div class="stagger-in s-5 grid grid-cols-3 gap-5 max-w-xl pt-7 border-t border-white/10">
            <div>
                <div class="text-3xl xl:text-4xl font-bold tracking-tight"><span data-counter="12" data-suffix="k+">12k+</span></div>
                <div class="text-white/50 text-[10px] xl:text-[11px] uppercase tracking-widest mt-2">Happy members</div>
            </div>
            <div>
                <div class="text-3xl xl:text-4xl font-bold tracking-tight"><span data-counter="98" data-suffix="%">98%</span></div>
                <div class="text-white/50 text-[10px] xl:text-[11px] uppercase tracking-widest mt-2">On-time delivery</div>
            </div>
            <div>
                <div class="text-3xl xl:text-4xl font-bold tracking-tight"><span data-counter="4.9">4.9</span><span class="text-teal-400">★</span></div>
                <div class="text-white/50 text-[10px] xl:text-[11px] uppercase tracking-widest mt-2">Avg. rating</div>
            </div>
        </div>
    </aside>

    <!-- ============ FORM PANEL (RIGHT) ============ -->
    <main class="relative z-10 flex-1 flex flex-col">

        <header class="stagger-in s-1 flex items-center justify-between px-6 lg:px-12 py-6">
            <a href="<?= baseUrl('/') ?>" class="lg:hidden flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center">
                    <span class="text-white font-bold">R</span>
                </div>
                <span class="text-white font-semibold tracking-tight">RentEase<span class="text-teal-400">.</span></span>
            </a>
            <div class="hidden lg:block"></div>
            <a href="<?= baseUrl('/signup') ?>" class="group inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white text-sm font-medium transition-all duration-300 hover:scale-[1.02]">
                <span class="hidden sm:inline">New here?</span>
                <span class="text-teal-300">Create an account</span>
                <span class="material-symbols-outlined text-base group-hover:translate-x-0.5 transition-transform duration-300">arrow_forward</span>
            </a>
        </header>

        <div class="flex-1 flex items-center justify-center p-5 sm:p-8 lg:p-12">
            <div class="w-full max-w-md">

                <div class="lg:hidden mb-8 text-center text-white stagger-in s-1">
                    <h1 class="editorial-mobile-headline text-4xl sm:text-5xl font-bold leading-[1.05] tracking-tight">
                        Welcome <span class="font-serif italic text-teal-300">back</span>
                    </h1>
                    <p class="mt-3 text-white/60 text-sm">Sign in to continue your journey</p>
                </div>

                <div class="tilt-card auth-form-card rounded-3xl p-7 sm:p-9 lg:p-10 stagger-in s-2">
                    <div class="card-highlight"></div>

                    <div class="relative mb-6">
                        <span class="inline-block text-[11px] font-bold tracking-widest uppercase text-teal-600 mb-2">Sign in</span>
                        <h2 class="text-3xl font-bold text-ink tracking-tight">Welcome back</h2>
                        <p class="text-slate-500 mt-1.5 text-sm">Enter your credentials to access your dashboard.</p>
                    </div>

                    <?php if ($error): ?>
                        <div class="relative mb-5 p-3.5 rounded-2xl bg-rose-50/95 border border-rose-100 flex gap-2.5 items-start text-rose-700 text-sm stagger-in s-1" role="alert">
                            <span class="material-symbols-outlined text-rose-500 text-lg mt-0.5 flex-shrink-0">error</span>
                            <p class="leading-relaxed"><?= htmlspecialchars($error) ?></p>
                        </div>
                    <?php endif; ?>

                    <form action="<?= baseUrl('/login') ?>" method="POST" class="relative space-y-4" novalidate data-cinematic-submit>
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                        <div class="stagger-in s-3 auth-field">
                            <span class="material-symbols-outlined field-icon">mail</span>
                            <input type="email" id="email" name="email" required autocomplete="email"
                                   class="auth-input"
                                   placeholder="you@company.com"
                                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                        </div>

                        <div class="stagger-in s-4 auth-field">
                            <span class="material-symbols-outlined field-icon">lock</span>
                            <input type="password" id="password" name="password" required autocomplete="current-password"
                                   class="auth-input"
                                   placeholder="Enter your password">
                            <button type="button" onclick="const p=this.previousElementSibling; p.type = p.type === 'password' ? 'text' : 'password'; this.querySelector('span').textContent = p.type === 'password' ? 'visibility_off' : 'visibility';" class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 text-slate-400 hover:text-slate-700 rounded-lg transition-colors z-10" tabindex="-1" aria-label="Toggle password visibility">
                                <span class="material-symbols-outlined text-lg">visibility_off</span>
                            </button>
                        </div>

                        <div class="stagger-in s-5 flex items-center justify-between pt-1">
                            <label class="flex items-center gap-2.5 cursor-pointer select-none group">
                                <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded accent-teal-500 cursor-pointer">
                                <span class="text-sm text-slate-600 group-hover:text-ink transition-colors">Keep me signed in</span>
                            </label>
                            <a href="<?= baseUrl('/forgot-password') ?>" class="text-xs font-semibold text-teal-600 hover:text-teal-700 transition-colors">Forgot password?</a>
                        </div>

                        <button type="submit" class="stagger-in s-6 btn-cinematic w-full mt-2 inline-flex items-center justify-center gap-2 py-4 font-semibold rounded-2xl text-sm tracking-wide">
                            <span class="btn-text inline-flex items-center gap-2">
                                Sign in to your account
                                <span class="material-symbols-outlined text-base">arrow_forward</span>
                            </span>
                            <span class="btn-loader">
                                <span class="spinner"></span>
                                <span class="ml-2 text-sm">Signing you in…</span>
                            </span>
                        </button>
                    </form>

                    <?php if (!empty($oauthProviders)): ?>
                    <div class="relative mt-6 stagger-in s-7 flex items-center gap-4">
                        <div class="flex-1 h-px bg-slate-200"></div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">or continue with</span>
                        <div class="flex-1 h-px bg-slate-200"></div>
                    </div>

                    <div class="relative mt-4 stagger-in s-7 grid grid-cols-<?= min(2, count($oauthProviders)) ?> gap-2.5">
                        <?php foreach ($oauthProviders as $id => $provider): ?>
                            <a href="<?= baseUrl('/api/auth/oauth?provider=' . $id) ?>"
                               class="flex items-center justify-center gap-2.5 py-3 px-3 bg-white border border-slate-200 hover:border-ink hover:bg-slate-50 rounded-2xl transition-all duration-200 group">
                                <img src="<?= $provider['icon'] ?>" alt="" class="w-4 h-4 group-hover:scale-110 transition-transform duration-200">
                                <span class="text-sm font-semibold text-slate-700"><?= $provider['name'] ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <p class="relative mt-6 text-center text-sm text-slate-500 stagger-in s-7">
                        New to RentEase?
                        <a href="<?= baseUrl('/signup') ?>" class="text-ink font-semibold hover:text-teal-600 transition-colors">Create an account</a>
                    </p>
                </div>
            </div>
        </div>
    </main>

    <script src="<?= baseUrl('/assets/js/auth-effects.js') ?>" defer></script>
</body>
</html>
