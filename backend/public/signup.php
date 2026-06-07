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
                $payload = [
                    'email' => $email,
                    'password' => $password,
                    'full_name' => $fullName
                ];
                $authService->signup($payload);

                try {
                    $resend = new \RentEase\Services\Email\ResendService($config);
                    $resend->send(
                        $email,
                        'Welcome to RentEase!',
                        "<h1>Welcome, {$fullName}!</h1><p>Thanks for joining RentEase. You can now browse and rent premium furniture.</p>"
                    );
                } catch (\Throwable $e) {
                    error_log("Welcome email failed: " . $e->getMessage());
                }

                try {
                    $onesignal = new \RentEase\Services\NotificationService($config);
                    $onesignal->sendPush([$email], 'Welcome to RentEase!', 'Your account has been created successfully.');
                } catch (\Throwable $e) {
                    error_log("Push notification failed: " . $e->getMessage());
                }

                $loginResult = $authService->login(['email' => $email, 'password' => $password]);
                $token = (string) ($loginResult['access_token'] ?? '');

                if ($token !== '') {
                    $authService->persistSession($loginResult, true);
                }

                header('Location: ' . baseUrl('/'));
                exit;
            } catch (Throwable $e) {
                $error = 'Signup failed. That email may already be in use or your password is too weak.';
            }
        }
    }
}

$oauthProviders = $config['enabled_oauth_providers'] ?? [];
$pageTitle = 'Create Account — RentEase';
$pageDescription = 'Join RentEase to rent premium furniture, track deliveries, and earn member rewards.';
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
        .pw-meter { height: 4px; border-radius: 9999px; background: rgba(15, 23, 42, 0.08); overflow: hidden; margin-top: 0.5rem; }
        .pw-meter-fill { height: 100%; width: 0%; transition: width 0.3s ease, background 0.3s ease; }
        @media (prefers-reduced-motion: reduce) {
            .reveal-up { opacity: 1; transform: none; animation: none; }
            .floating-shape { animation: none; }
        }
    </style>
</head>
<body class="auth-bg min-h-screen overflow-x-hidden">

    <!-- ============== FULL-BLEED LIFESTYLE BACKGROUND ============== -->
    <div class="fixed inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=2000&q=80&auto=format&fit=crop"
             alt=""
             class="w-full h-full object-cover"
             loading="eager"
             onerror="this.src='https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=2000&q=80&auto=format&fit=crop'">
        <div class="absolute inset-0 bg-gradient-to-l from-ink/40 via-ink/30 to-ink/85"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-ink/30 via-transparent to-ink/60"></div>
    </div>

    <!-- ============== FLOATING DECORATIVE ORBS ============== -->
    <div class="floating-shape bg-amber-400/25 w-96 h-96 top-[-10%] left-[-5%]" style="animation-delay:-3s;"></div>
    <div class="floating-shape bg-teal-400/25 w-80 h-80 bottom-[-10%] right-[20%]" style="animation-delay:-9s;"></div>

    <!-- ============== MINIMAL TOP BAR ============== -->
    <header class="relative z-20 flex items-center justify-between px-6 lg:px-12 py-6">
        <a href="<?= baseUrl('/') ?>" class="flex items-center gap-2 group">
            <div class="w-9 h-9 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center group-hover:bg-white/20 transition-colors">
                <span class="text-white font-bold text-lg">R</span>
            </div>
            <span class="text-white font-semibold text-lg tracking-tight">RentEase<span class="text-teal-400">.</span></span>
        </a>
        <a href="<?= baseUrl('/login') ?>" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white text-sm font-medium transition-all">
            Already a member?
            <span class="text-teal-300">Sign in</span>
            <span class="material-symbols-outlined text-base">arrow_forward</span>
        </a>
    </header>

    <!-- ============== MAIN: LEFT GLASS FORM + RIGHT EDITORIAL ============== -->
    <main class="relative z-10 min-h-[calc(100vh-88px)] flex items-stretch flex-row-reverse">

        <!-- RIGHT (desktop): Editorial brand story -->
        <section class="hidden lg:flex flex-col justify-between w-1/2 px-12 xl:px-20 py-12 text-white">
            <div class="reveal-up delay-1 max-w-lg">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-medium tracking-wide uppercase">
                    <span class="w-1.5 h-1.5 rounded-full bg-teal-400 animate-pulse"></span>
                    Join in 60 seconds
                </span>
                <h1 class="mt-8 text-6xl xl:text-7xl font-bold leading-[0.95] tracking-tighter">
                    Live <span class="font-serif italic font-normal text-teal-300">beautifully</span>,<br>
                    rent<br>
                    effortlessly.
                </h1>
                <p class="mt-6 text-white/70 text-lg leading-relaxed max-w-md">
                    Premium furniture delivered, assembled, and swapped on your schedule. No deposits, no commitments, no hassle.
                </p>
            </div>

            <!-- Value props -->
            <div class="reveal-up delay-3 space-y-4 max-w-md">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-teal-400/20 backdrop-blur-md border border-teal-400/30 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-teal-300">local_shipping</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-white">Free white-glove delivery</h3>
                        <p class="text-white/60 text-sm mt-0.5">Setup included. We handle the heavy lifting.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-teal-400/20 backdrop-blur-md border border-teal-400/30 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-teal-300">autorenew</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-white">Swap, upgrade, or return</h3>
                        <p class="text-white/60 text-sm mt-0.5">Your space evolves with you. Cancel anytime.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-teal-400/20 backdrop-blur-md border border-teal-400/30 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-teal-300">workspace_premium</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-white">Earn member rewards</h3>
                        <p class="text-white/60 text-sm mt-0.5">Points on every rental. Redeem for upgrades.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- LEFT (desktop): Glassmorphic form card -->
        <section class="flex-1 flex items-center justify-center p-6 lg:p-12">
            <div class="glass-card reveal-up delay-2 w-full max-w-md rounded-3xl p-8 lg:p-10">

                <div class="mb-6">
                    <h2 class="text-3xl font-bold text-ink tracking-tight">Create your account</h2>
                    <p class="text-slate-500 mt-1.5 text-sm">Start renting in minutes. No credit card required.</p>
                </div>

                <?php if ($error): ?>
                    <div class="mb-5 p-3.5 rounded-2xl bg-rose-50/90 border border-rose-100 flex gap-2.5 items-start text-rose-700 text-sm" role="alert">
                        <span class="material-symbols-outlined text-rose-500 text-lg mt-0.5 flex-shrink-0">error</span>
                        <p class="leading-relaxed"><?= htmlspecialchars($error) ?></p>
                    </div>
                <?php endif; ?>

                <form action="<?= baseUrl('/signup') ?>" method="POST" class="space-y-3.5" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                    <div>
                        <label for="full_name" class="block text-xs font-semibold text-slate-600 mb-1.5 tracking-wide uppercase">Full name</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xl pointer-events-none">person</span>
                            <input type="text" id="full_name" name="full_name" required autocomplete="name"
                                   class="auth-input"
                                   placeholder="Jane Cooper"
                                   value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">
                        </div>
                    </div>

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
                        <label for="password" class="block text-xs font-semibold text-slate-600 mb-1.5 tracking-wide uppercase">Password</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xl pointer-events-none">lock</span>
                            <input type="password" id="password" name="password" required autocomplete="new-password"
                                   class="auth-input"
                                   placeholder="At least 8 characters"
                                   minlength="8"
                                   oninput="const v=this.value; const m=document.getElementById('pw-meter-fill'); const r=document.getElementById('pw-hint'); if(!v){m.style.width='0%';r.textContent='';return;} let s=0; if(v.length>=8)s++; if(/[A-Z]/.test(v))s++; if(/[0-9]/.test(v))s++; if(/[^a-zA-Z0-9]/.test(v))s++; const pct=[0,30,55,80,100][s]; m.style.width=pct+'%'; const colors=['#ef4444','#f59e0b','#eab308','#10b981','#059669']; const labels=['','Too weak','Fair','Good','Strong']; m.style.background=colors[s]; r.textContent=labels[s]; r.style.color=colors[s];">
                            <button type="button" onclick="const p=document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password'; this.querySelector('span').textContent = p.type === 'password' ? 'visibility_off' : 'visibility';" class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 text-slate-400 hover:text-slate-700 rounded-lg transition-colors" tabindex="-1" aria-label="Toggle password visibility">
                                <span class="material-symbols-outlined text-lg">visibility_off</span>
                            </button>
                        </div>
                        <div class="pw-meter"><div id="pw-meter-fill" class="pw-meter-fill"></div></div>
                        <p id="pw-hint" class="mt-1.5 text-xs font-medium"></p>
                    </div>

                    <label class="flex items-start gap-2.5 pt-1 cursor-pointer select-none">
                        <input type="checkbox" id="terms" name="terms" required class="w-4 h-4 mt-0.5 rounded accent-teal-500 cursor-pointer flex-shrink-0">
                        <span class="text-sm text-slate-600 leading-relaxed">
                            I agree to the
                            <a href="<?= baseUrl('/terms') ?>" class="text-ink font-medium hover:text-teal-600">Terms</a>
                            and
                            <a href="<?= baseUrl('/privacy') ?>" class="text-ink font-medium hover:text-teal-600">Privacy Policy</a>.
                        </span>
                    </label>

                    <button type="submit" class="w-full mt-3 inline-flex items-center justify-center gap-2 py-3.5 bg-ink hover:bg-slate-800 text-white font-semibold rounded-2xl transition-all hover:-translate-y-0.5 active:translate-y-0 shadow-lg shadow-ink/20">
                        Create my account
                        <span class="material-symbols-outlined text-base">arrow_forward</span>
                    </button>
                </form>

                <?php if (!empty($oauthProviders)): ?>
                <div class="mt-6 flex items-center gap-4">
                    <div class="flex-1 h-px bg-slate-200"></div>
                    <span class="text-[11px] font-medium text-slate-400 uppercase tracking-widest">or sign up with</span>
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
                    Already a member?
                    <a href="<?= baseUrl('/login') ?>" class="text-ink font-semibold hover:text-teal-600">Sign in</a>
                </p>
            </div>
        </section>
    </main>

    <!-- No footer on auth pages (intentional, focused experience) -->
</body>
</html>
