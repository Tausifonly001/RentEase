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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="theme-color" content="#041527">
    <link rel="icon" type="image/svg+xml" href="<?= baseUrl('/favicon.svg') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="<?= baseUrl('/assets/css/theme.css') ?>">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#041527',
                        accent: '#14b8a6',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['"Instrument Serif"', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; -webkit-font-smoothing: antialiased; }
        .auth-bg { background-color: #041527; }
        .glass-card {
            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(28px) saturate(180%);
            -webkit-backdrop-filter: blur(28px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow:
                0 1px 0 rgba(255, 255, 255, 0.9) inset,
                0 30px 80px -20px rgba(0, 0, 0, 0.4),
                0 10px 30px -10px rgba(0, 0, 0, 0.25);
        }
        .auth-input {
            width: 100%; padding: 0.95rem 1rem 0.95rem 3rem;
            background: rgba(255, 255, 255, 0.6);
            border: 1.5px solid rgba(15, 23, 42, 0.08);
            border-radius: 14px;
            color: #0f172a;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            outline: none;
        }
        .auth-input::placeholder { color: #94a3b8; }
        .auth-input:hover { border-color: rgba(15, 23, 42, 0.15); }
        .auth-input:focus {
            border-color: #14b8a6;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.12);
        }
        .auth-input.is-error { border-color: #f43f5e; box-shadow: 0 0 0 4px rgba(244, 63, 94, 0.1); }
        .floating-shape {
            position: absolute; border-radius: 9999px;
            filter: blur(40px); opacity: 0.5;
            animation: float 18s ease-in-out infinite;
            pointer-events: none;
        }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(20px, -30px) scale(1.1); }
        }
        .reveal-up { opacity: 0; transform: translateY(24px); animation: revealUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes revealUp { to { opacity: 1; transform: translateY(0); } }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
        .delay-5 { animation-delay: 0.5s; }
        @media (prefers-reduced-motion: reduce) {
            .reveal-up { opacity: 1; transform: none; animation: none; }
            .floating-shape { animation: none; }
        }
    </style>
</head>
<body class="auth-bg min-h-screen overflow-x-hidden">

    <!-- ============== FULL-BLEED LIFESTYLE BACKGROUND ============== -->
    <div class="fixed inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=2000&q=80&auto=format&fit=crop"
             alt=""
             class="w-full h-full object-cover"
             loading="eager"
             onerror="this.src='https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?w=2000&q=80&auto=format&fit=crop'">
        <!-- Soft dark gradient overlay (right side darker for form legibility) -->
        <div class="absolute inset-0 bg-gradient-to-r from-ink/40 via-ink/30 to-ink/85"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-ink/30 via-transparent to-ink/60"></div>
    </div>

    <!-- ============== FLOATING DECORATIVE ORBS ============== -->
    <div class="floating-shape bg-teal-400/30 w-96 h-96 top-[-10%] right-[-5%]" style="animation-delay:-2s;"></div>
    <div class="floating-shape bg-emerald-400/20 w-80 h-80 bottom-[-10%] left-[20%]" style="animation-delay:-8s;"></div>

    <!-- ============== MINIMAL TOP BAR ============== -->
    <header class="relative z-20 flex items-center justify-between px-6 lg:px-12 py-6">
        <a href="<?= baseUrl('/') ?>" class="flex items-center gap-2 group">
            <div class="w-9 h-9 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center group-hover:bg-white/20 transition-colors">
                <span class="text-white font-bold text-lg">R</span>
            </div>
            <span class="text-white font-semibold text-lg tracking-tight">RentEase<span class="text-teal-400">.</span></span>
        </a>
        <a href="<?= baseUrl('/signup') ?>" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white text-sm font-medium transition-all">
            New here?
            <span class="text-teal-300">Create an account</span>
            <span class="material-symbols-outlined text-base">arrow_forward</span>
        </a>
    </header>

    <!-- ============== MAIN: LEFT EDITORIAL + RIGHT GLASS FORM ============== -->
    <main class="relative z-10 min-h-[calc(100vh-88px)] flex items-stretch">

        <!-- LEFT: Editorial brand story -->
        <section class="hidden lg:flex flex-col justify-between w-1/2 px-12 xl:px-20 py-12 text-white">
            <div class="reveal-up delay-1 max-w-lg">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-medium tracking-wide uppercase">
                    <span class="w-1.5 h-1.5 rounded-full bg-teal-400 animate-pulse"></span>
                    Member sign in
                </span>
                <h1 class="mt-8 text-6xl xl:text-7xl font-bold leading-[0.95] tracking-tighter">
                    Your space,<br>
                    <span class="font-serif italic font-normal text-teal-300">effortlessly</span><br>
                    curated.
                </h1>
                <p class="mt-6 text-white/70 text-lg leading-relaxed max-w-md">
                    Continue managing your rentals, tracking deliveries, and unlocking member rewards — all in one place.
                </p>
            </div>

            <!-- Stats strip -->
            <div class="reveal-up delay-3 grid grid-cols-3 gap-6 max-w-lg">
                <div>
                    <div class="text-3xl font-bold tracking-tight">12k+</div>
                    <div class="text-white/50 text-xs uppercase tracking-widest mt-1">Happy members</div>
                </div>
                <div>
                    <div class="text-3xl font-bold tracking-tight">98%</div>
                    <div class="text-white/50 text-xs uppercase tracking-widest mt-1">On-time delivery</div>
                </div>
                <div>
                    <div class="text-3xl font-bold tracking-tight">4.9<span class="text-teal-400">★</span></div>
                    <div class="text-white/50 text-xs uppercase tracking-widest mt-1">Avg. rating</div>
                </div>
            </div>
        </section>

        <!-- RIGHT: Glassmorphic form card -->
        <section class="flex-1 flex items-center justify-center p-6 lg:p-12">
            <div class="glass-card reveal-up delay-2 w-full max-w-md rounded-3xl p-8 lg:p-10">

                <div class="mb-7">
                    <h2 class="text-3xl font-bold text-ink tracking-tight">Welcome back</h2>
                    <p class="text-slate-500 mt-1.5 text-sm">Sign in to continue to your dashboard.</p>
                </div>

                <?php if ($error): ?>
                    <div class="mb-5 p-3.5 rounded-2xl bg-rose-50/90 border border-rose-100 flex gap-2.5 items-start text-rose-700 text-sm" role="alert">
                        <span class="material-symbols-outlined text-rose-500 text-lg mt-0.5 flex-shrink-0">error</span>
                        <p class="leading-relaxed"><?= htmlspecialchars($error) ?></p>
                    </div>
                <?php endif; ?>

                <form action="<?= baseUrl('/login') ?>" method="POST" class="space-y-4" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-600 mb-1.5 tracking-wide uppercase">Email</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xl pointer-events-none">mail</span>
                            <input type="email" id="email" name="email" required autocomplete="email"
                                   class="auth-input"
                                   placeholder="you@company.com"
                                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-semibold text-slate-600 tracking-wide uppercase">Password</label>
                            <a href="<?= baseUrl('/forgot-password') ?>" class="text-xs font-medium text-teal-600 hover:text-teal-700">Forgot?</a>
                        </div>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xl pointer-events-none">lock</span>
                            <input type="password" id="password" name="password" required autocomplete="current-password"
                                   class="auth-input"
                                   placeholder="Enter your password">
                            <button type="button" onclick="const p=document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password'; this.querySelector('span').textContent = p.type === 'password' ? 'visibility_off' : 'visibility';" class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 text-slate-400 hover:text-slate-700 rounded-lg transition-colors" tabindex="-1" aria-label="Toggle password visibility">
                                <span class="material-symbols-outlined text-lg">visibility_off</span>
                            </button>
                        </div>
                    </div>

                    <label class="flex items-center gap-2.5 pt-1 cursor-pointer select-none">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded accent-teal-500 cursor-pointer">
                        <span class="text-sm text-slate-600">Keep me signed in for 30 days</span>
                    </label>

                    <button type="submit" class="w-full mt-2 inline-flex items-center justify-center gap-2 py-3.5 bg-ink hover:bg-slate-800 text-white font-semibold rounded-2xl transition-all hover:-translate-y-0.5 active:translate-y-0 shadow-lg shadow-ink/20">
                        Sign in
                        <span class="material-symbols-outlined text-base">arrow_forward</span>
                    </button>
                </form>

                <?php if (!empty($oauthProviders)): ?>
                <div class="mt-6 flex items-center gap-4">
                    <div class="flex-1 h-px bg-slate-200"></div>
                    <span class="text-[11px] font-medium text-slate-400 uppercase tracking-widest">or continue with</span>
                    <div class="flex-1 h-px bg-slate-200"></div>
                </div>

                <div class="mt-5 grid grid-cols-<?= min(2, count($oauthProviders)) ?> gap-2.5">
                    <?php foreach ($oauthProviders as $id => $provider): ?>
                        <a href="<?= baseUrl('/api/auth/oauth?provider=' . $id) ?>"
                           class="flex items-center justify-center gap-2.5 py-2.5 px-3 bg-white border border-slate-200 hover:border-slate-300 hover:bg-slate-50 rounded-2xl transition-all group">
                            <img src="<?= $provider['icon'] ?>" alt="" class="w-4 h-4 group-hover:scale-110 transition-transform">
                            <span class="text-sm font-medium text-slate-700"><?= $provider['name'] ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <p class="mt-7 text-center text-sm text-slate-500">
                    New to RentEase?
                    <a href="<?= baseUrl('/signup') ?>" class="text-ink font-semibold hover:text-teal-600">Create an account</a>
                </p>
            </div>
        </section>
    </main>

    <!-- No footer on auth pages (intentional, focused experience) -->
</body>
</html>
