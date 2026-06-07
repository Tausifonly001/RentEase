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

require __DIR__ . '/partials/header.php';
?>

<div class="flex flex-1 min-h-[calc(100vh-80px)] page-fade">

    <!-- Left: brand panel (dark, atmospheric) -->
    <aside class="hidden lg:flex lg:w-1/2 relative bg-slate-900 items-center justify-center overflow-hidden">
        <!-- Decorative orbs -->
        <div class="absolute top-[-15%] left-[-15%] w-[50%] h-[50%] bg-teal-500/30 rounded-full blur-[140px]"></div>
        <div class="absolute bottom-[-15%] right-[-15%] w-[50%] h-[50%] bg-emerald-500/20 rounded-full blur-[140px]"></div>
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2240%22 height=%2240%22 viewBox=%220 0 40 40%22><circle cx=%2220%22 cy=%2220%22 r=%221%22 fill=%22white%22/></svg>');"></div>

        <div class="relative z-10 text-center px-12 max-w-xl">
            <a href="<?= baseUrl('/') ?>" class="inline-block mb-16 group">
                <span class="text-5xl font-bold text-white tracking-tighter">Rent<span class="text-teal-400 group-hover:text-teal-300 transition-colors">Ease</span><span class="text-teal-400">.</span></span>
            </a>

            <h2 class="text-5xl font-bold text-white mb-6 leading-[1.05] tracking-tight">
                Elevate your<br>living <span class="text-teal-400">experience.</span>
            </h2>
            <p class="text-slate-300 text-lg max-w-md mx-auto leading-relaxed mb-16">
                Access your premium workspace and home subscriptions with one seamless identity.
            </p>

            <div class="grid grid-cols-2 gap-4">
                <div class="p-6 rounded-2xl bg-white/[0.04] border border-white/10 text-left backdrop-blur-sm hover:bg-white/[0.06] transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-teal-500/20 text-teal-300 flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined">bolt</span>
                    </div>
                    <h4 class="text-white font-semibold text-sm mb-1">Instant Access</h4>
                    <p class="text-slate-400 text-xs leading-relaxed">Deploy your workspace in seconds.</p>
                </div>
                <div class="p-6 rounded-2xl bg-white/[0.04] border border-white/10 text-left backdrop-blur-sm hover:bg-white/[0.06] transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-teal-500/20 text-teal-300 flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined">verified_user</span>
                    </div>
                    <h4 class="text-white font-semibold text-sm mb-1">Secure & Private</h4>
                    <p class="text-slate-400 text-xs leading-relaxed">Enterprise-grade encryption & RLS.</p>
                </div>
                <div class="p-6 rounded-2xl bg-white/[0.04] border border-white/10 text-left backdrop-blur-sm hover:bg-white/[0.06] transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-teal-500/20 text-teal-300 flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined">autorenew</span>
                    </div>
                    <h4 class="text-white font-semibold text-sm mb-1">Swap Anytime</h4>
                    <p class="text-slate-400 text-xs leading-relaxed">Upgrade, change, or return items freely.</p>
                </div>
                <div class="p-6 rounded-2xl bg-white/[0.04] border border-white/10 text-left backdrop-blur-sm hover:bg-white/[0.06] transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-teal-500/20 text-teal-300 flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined">workspace_premium</span>
                    </div>
                    <h4 class="text-white font-semibold text-sm mb-1">Members Rewards</h4>
                    <p class="text-slate-400 text-xs leading-relaxed">Earn points on every rental.</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Right: form panel -->
    <main class="flex flex-col justify-center w-full lg:w-1/2 px-5 sm:px-12 lg:px-24 bg-white relative">
        <div class="w-full max-w-md mx-auto py-12">

            <header class="mb-10">
                <span class="badge badge-accent mb-4">Welcome back</span>
                <h1 class="text-4xl font-bold text-slate-900 mb-2 tracking-tight">Sign in to RentEase</h1>
                <p class="text-slate-500">Continue managing your rentals and rewards.</p>
            </header>

            <?php if ($error): ?>
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-100 flex gap-3 items-start text-rose-700 text-sm" role="alert">
                    <span class="material-symbols-outlined text-rose-500 mt-0.5 flex-shrink-0">error</span>
                    <p class="leading-relaxed"><?= htmlspecialchars($error) ?></p>
                </div>
            <?php endif; ?>

            <form action="<?= baseUrl('/login') ?>" method="POST" class="space-y-5" novalidate>
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                <div class="form-field">
                    <label for="email" class="form-label">Email address</label>
                    <div class="input-group">
                        <span class="input-group-icon material-symbols-outlined" aria-hidden="true">mail</span>
                        <input type="email" id="email" name="email" required autocomplete="email"
                               class="form-input"
                               placeholder="name@company.com"
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-field">
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="form-label mb-0">Password</label>
                        <a href="<?= baseUrl('/forgot-password') ?>" class="text-xs font-medium text-teal-600 hover:text-teal-700">Forgot password?</a>
                    </div>
                    <div class="input-group">
                        <span class="input-group-icon material-symbols-outlined" aria-hidden="true">lock</span>
                        <input type="password" id="password" name="password" required autocomplete="current-password"
                               class="form-input"
                               placeholder="••••••••">
                        <button type="button" onclick="const p=document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password'; this.querySelector('span').textContent = p.type === 'password' ? 'visibility_off' : 'visibility';" class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 text-slate-400 hover:text-slate-700 rounded transition-colors" tabindex="-1" aria-label="Toggle password visibility">
                            <span class="material-symbols-outlined text-lg">visibility_off</span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center pt-1">
                    <label class="form-check">
                        <input type="checkbox" id="remember" name="remember">
                        <span class="form-check-label">Keep me signed in for 30 days</span>
                    </label>
                </div>

                <button type="submit" class="btn-pill btn-pill-lg w-full mt-2">
                    Sign in
                    <span class="material-symbols-outlined text-base" aria-hidden="true">arrow_forward</span>
                </button>
            </form>

            <?php if (!empty($oauthProviders)): ?>
            <div class="mt-10">
                <div class="relative flex items-center mb-6">
                    <div class="flex-grow border-t border-slate-200"></div>
                    <span class="flex-shrink mx-4 text-xs font-medium text-slate-400 uppercase tracking-widest">Or continue with</span>
                    <div class="flex-grow border-t border-slate-200"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <?php foreach ($oauthProviders as $id => $provider): ?>
                        <button onclick="window.location.href='<?= baseUrl('/api/auth/oauth?provider=' . $id) ?>'"
                                class="flex items-center justify-center gap-3 px-4 py-3 border border-slate-200 rounded-2xl hover:border-slate-300 hover:bg-slate-50 transition-all group w-full font-medium text-sm text-slate-700">
                            <img src="<?= $provider['icon'] ?>" alt="" class="w-5 h-5 group-hover:scale-110 transition-transform">
                            <?= $provider['name'] ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <footer class="mt-10 pt-8 border-t border-slate-100 text-center">
                <p class="text-slate-500 text-sm">
                    Don't have an account?
                    <a href="<?= baseUrl('/signup') ?>" class="text-teal-600 font-semibold hover:text-teal-700">Create one — it's free</a>
                </p>
            </footer>
        </div>
    </main>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
