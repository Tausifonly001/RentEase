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

require __DIR__ . '/partials/header.php';
?>

<div class="flex flex-1 min-h-[calc(100vh-80px)] page-fade">

    <!-- Right (signup places brand on right to differentiate from login): form panel on left -->
    <main class="flex flex-col justify-center w-full lg:w-1/2 px-5 sm:px-12 lg:px-24 bg-white relative order-2 lg:order-1">
        <div class="w-full max-w-md mx-auto py-12">

            <header class="mb-8">
                <span class="badge badge-accent mb-4">Create your account</span>
                <h1 class="text-4xl font-bold text-slate-900 mb-2 tracking-tight">Join RentEase</h1>
                <p class="text-slate-500">Start renting premium furniture in minutes. No commitments, cancel anytime.</p>
            </header>

            <?php if ($error): ?>
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-100 flex gap-3 items-start text-rose-700 text-sm" role="alert">
                    <span class="material-symbols-outlined text-rose-500 mt-0.5 flex-shrink-0">error</span>
                    <p class="leading-relaxed"><?= htmlspecialchars($error) ?></p>
                </div>
            <?php endif; ?>

            <form action="<?= baseUrl('/signup') ?>" method="POST" class="space-y-4" novalidate>
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                <div class="form-field">
                    <label for="full_name" class="form-label">Full name</label>
                    <div class="input-group">
                        <span class="input-group-icon material-symbols-outlined" aria-hidden="true">person</span>
                        <input type="text" id="full_name" name="full_name" required autocomplete="name"
                               class="form-input"
                               placeholder="Jane Cooper"
                               value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">
                    </div>
                </div>

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
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-icon material-symbols-outlined" aria-hidden="true">lock</span>
                        <input type="password" id="password" name="password" required autocomplete="new-password"
                               class="form-input"
                               placeholder="At least 8 characters"
                               minlength="8"
                               oninput="const v=this.value; const r=/^(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/; document.getElementById('pw-strength').textContent = !v ? '' : (r.test(v) ? '✓ Strong password' : 'Use 8+ chars, 1 number, 1 special character'); document.getElementById('pw-strength').className = 'mt-2 text-xs ' + (r.test(v) ? 'text-emerald-600' : 'text-amber-600');">
                        <button type="button" onclick="const p=document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password'; this.querySelector('span').textContent = p.type === 'password' ? 'visibility_off' : 'visibility';" class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 text-slate-400 hover:text-slate-700 rounded transition-colors" tabindex="-1" aria-label="Toggle password visibility">
                            <span class="material-symbols-outlined text-lg">visibility_off</span>
                        </button>
                    </div>
                    <p id="pw-strength" class="mt-2 text-xs text-slate-500"></p>
                </div>

                <div class="pt-1">
                    <label class="form-check items-start">
                        <input type="checkbox" id="terms" name="terms" required class="mt-0.5">
                        <span class="form-check-label leading-relaxed">
                            I agree to the
                            <a href="<?= baseUrl('/terms') ?>" class="text-teal-600 font-medium hover:text-teal-700">Terms of Service</a>
                            and
                            <a href="<?= baseUrl('/privacy') ?>" class="text-teal-600 font-medium hover:text-teal-700">Privacy Policy</a>.
                        </span>
                    </label>
                </div>

                <button type="submit" class="btn-pill btn-pill-lg w-full mt-3">
                    Create account
                    <span class="material-symbols-outlined text-base" aria-hidden="true">arrow_forward</span>
                </button>
            </form>

            <?php if (!empty($oauthProviders)): ?>
            <div class="mt-10">
                <div class="relative flex items-center mb-6">
                    <div class="flex-grow border-t border-slate-200"></div>
                    <span class="flex-shrink mx-4 text-xs font-medium text-slate-400 uppercase tracking-widest">Or sign up with</span>
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
                    Already have an account?
                    <a href="<?= baseUrl('/login') ?>" class="text-teal-600 font-semibold hover:text-teal-700">Sign in instead</a>
                </p>
            </footer>
        </div>
    </main>

    <!-- Brand panel (right side on desktop) -->
    <aside class="hidden lg:flex lg:w-1/2 relative bg-slate-900 items-center justify-center overflow-hidden order-1 lg:order-2">
        <div class="absolute top-[-15%] right-[-15%] w-[50%] h-[50%] bg-teal-500/30 rounded-full blur-[140px]"></div>
        <div class="absolute bottom-[-15%] left-[-15%] w-[50%] h-[50%] bg-emerald-500/20 rounded-full blur-[140px]"></div>
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2240%22 height=%2240%22 viewBox=%220 0 40 40%22><circle cx=%2220%22 cy=%2220%22 r=%221%22 fill=%22white%22/></svg>');"></div>

        <div class="relative z-10 text-center px-12 max-w-xl">
            <a href="<?= baseUrl('/') ?>" class="inline-block mb-16 group">
                <span class="text-5xl font-bold text-white tracking-tighter">Rent<span class="text-teal-400 group-hover:text-teal-300 transition-colors">Ease</span><span class="text-teal-400">.</span></span>
            </a>

            <h2 class="text-5xl font-bold text-white mb-6 leading-[1.05] tracking-tight">
                Rent premium<br>furniture, <span class="text-teal-400">frictionlessly.</span>
            </h2>
            <p class="text-slate-300 text-lg max-w-md mx-auto leading-relaxed mb-16">
                Join thousands of urban professionals furnishing their homes without the commitment.
            </p>

            <div class="grid grid-cols-2 gap-4">
                <div class="p-6 rounded-2xl bg-white/[0.04] border border-white/10 text-left backdrop-blur-sm hover:bg-white/[0.06] transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-teal-500/20 text-teal-300 flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined">auto_awesome</span>
                    </div>
                    <h4 class="text-white font-semibold text-sm mb-1">Curated Styles</h4>
                    <p class="text-slate-400 text-xs leading-relaxed">Designer-picked collections.</p>
                </div>
                <div class="p-6 rounded-2xl bg-white/[0.04] border border-white/10 text-left backdrop-blur-sm hover:bg-white/[0.06] transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-teal-500/20 text-teal-300 flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined">verified_user</span>
                    </div>
                    <h4 class="text-white font-semibold text-sm mb-1">Total Security</h4>
                    <p class="text-slate-400 text-xs leading-relaxed">Insured rentals & RLS.</p>
                </div>
                <div class="p-6 rounded-2xl bg-white/[0.04] border border-white/10 text-left backdrop-blur-sm hover:bg-white/[0.06] transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-teal-500/20 text-teal-300 flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined">local_shipping</span>
                    </div>
                    <h4 class="text-white font-semibold text-sm mb-1">Free Delivery</h4>
                    <p class="text-slate-400 text-xs leading-relaxed">White-glove setup included.</p>
                </div>
                <div class="p-6 rounded-2xl bg-white/[0.04] border border-white/10 text-left backdrop-blur-sm hover:bg-white/[0.06] transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-teal-500/20 text-teal-300 flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined">workspace_premium</span>
                    </div>
                    <h4 class="text-white font-semibold text-sm mb-1">Member Rewards</h4>
                    <p class="text-slate-400 text-xs leading-relaxed">Earn on every rental.</p>
                </div>
            </div>
        </div>
    </aside>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
