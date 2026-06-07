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
                $error = 'Login failed: ' . $e->getMessage();
            }
        }
    }
}

// OAuth Providers from configuration
$oauthProviders = $config['enabled_oauth_providers'] ?? [];

?>
<!DOCTYPE html>
<html lang="en" class="min-h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - RentEase Premium</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#041627",
                        secondary: "#006a65",
                        background: "#f8f9ff",
                        "surface-container": "#e5eeff",
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .auth-card {
            box-shadow: 0 20px 50px rgba(4, 22, 39, 0.08);
        }
    </style>
</head>
<body class="min-h-full bg-background font-sans antialiased text-primary">
    
    <div class="flex min-h-full">
        <!-- Left Side: Interactive Branding -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-primary items-center justify-center overflow-hidden">
            <div class="absolute inset-0 opacity-20">
                <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-secondary rounded-full blur-[120px]"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-teal-500 rounded-full blur-[120px]"></div>
            </div>
            
            <div class="relative z-10 text-center px-12">
                <a href="<?= baseUrl('/') ?>" class="inline-block mb-12">
                    <span class="text-5xl font-normal text-white tracking-tighter">Rent<span class="text-secondary">Ease</span></span>
                </a>
                <h2 class="text-4xl font-normal text-white mb-6 leading-tight">Elevate Your Living Experience.</h2>
                <p class="text-slate-400 text-lg max-w-md mx-auto">Access your premium workspace and home subscriptions with one seamless identity.</p>
                
                <div class="mt-16 grid grid-cols-2 gap-4">
                    <div class="p-6 rounded-2xl bg-white/5 border border-white/10 text-left backdrop-blur-sm">
                        <span class="material-symbols-outlined text-secondary mb-3">speed</span>
                        <h4 class="text-white font-light text-sm mb-1">Instant Access</h4>
                        <p class="text-slate-500 text-xs font-light">Deploy your workspace in seconds.</p>
                    </div>
                    <div class="p-6 rounded-2xl bg-white/5 border border-white/10 text-left backdrop-blur-sm">
                        <span class="material-symbols-outlined text-secondary mb-3">security</span>
                        <h4 class="text-white font-light text-sm mb-1">Secure & Private</h4>
                        <p class="text-slate-500 text-xs font-light">Enterprise-grade encryption.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="flex flex-col justify-start sm:justify-center w-full lg:w-1/2 px-5 sm:px-12 lg:px-24 bg-white relative min-w-0">
            <div class="absolute top-8 left-5 lg:hidden">
                <a href="<?= baseUrl('/') ?>" class="text-2xl font-normal text-primary tracking-tighter">RentEase</a>
            </div>

            <div id="login-container" class="w-full max-w-md mx-auto pt-24 pb-12 sm:py-12 min-w-0">
                <header class="mb-10">
                    <h1 class="text-3xl font-normal text-primary mb-2">Welcome Back</h1>
                    <p class="text-slate-500">Sign in to continue managing your rentals.</p>
                </header>

                <?php if ($error): ?>
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 flex gap-3 items-center text-red-700 text-sm animate-shake font-light">
                        <span class="material-symbols-outlined text-red-500">error</span>
                        <p><?= htmlspecialchars($error) ?></p>
                    </div>
                <?php endif; ?>

                <form action="<?= baseUrl('/login') ?>" method="POST" class="space-y-6">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                    
                    <div>
                        <label for="email" class="block text-sm font-light text-primary mb-2">Email Address</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-xl">mail</span>
                            <input type="email" id="email" name="email" required 
                                class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none text-slate-900"
                                placeholder="name@company.com"
                                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-sm font-light text-primary">Password</label>
                            <a href="<?= baseUrl('/forgot-password') ?>" class="text-xs font-light text-secondary hover:underline">Forgot password?</a>
                        </div>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-xl">lock</span>
                            <input type="password" id="password" name="password" required 
                                class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none text-slate-900"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="remember" class="w-4 h-4 text-secondary border-slate-300 rounded focus:ring-secondary cursor-pointer">
                        <label for="remember" class="ml-2 text-sm text-slate-500 cursor-pointer font-light">Remember me for 30 days</label>
                    </div>

                    <button type="submit" class="w-full py-4 bg-primary hover:bg-slate-800 text-white font-normal rounded-xl shadow-lg shadow-primary/10 transition-all transform hover:-translate-y-0.5 active:scale-[0.98]">
                        Sign In
                    </button>
                </form>

                <!-- Social Login -->
                <div class="mt-8">
                    <div class="relative flex items-center mb-8">
                        <div class="flex-grow border-t border-slate-200"></div>
                        <span class="flex-shrink mx-4 text-xs font-light text-slate-400 uppercase tracking-widest">Or continue with</span>
                        <div class="flex-grow border-t border-slate-200"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <?php foreach ($oauthProviders as $id => $provider): ?>
                            <button onclick="window.location.href='<?= baseUrl('/api/auth/oauth?provider=' . $id) ?>'" 
                                class="flex items-center justify-center gap-3 px-4 py-3 border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors group w-full">
                                <img src="<?= $provider['icon'] ?>" alt="<?= $provider['name'] ?>" class="w-5 h-5 group-hover:scale-110 transition-transform">
                                <span class="text-sm font-light text-slate-700"><?= $provider['name'] ?></span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <footer class="mt-10 text-center">
                    <p class="text-slate-500 text-sm font-light">
                        Don't have an account? 
                        <a href="<?= baseUrl('/signup') ?>" class="text-secondary font-normal hover:underline">Create an account</a>
                    </p>
                </footer>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', () => {
            gsap.from('#login-container', {
                opacity: 0,
                x: 20,
                duration: 1,
                ease: 'power3.out'
            });

            gsap.from('form > div, .relative.flex', {
                opacity: 0,
                y: 10,
                stagger: 0.1,
                duration: 0.8,
                ease: 'power3.out',
                delay: 0.3
            });
        });
    </script>
</body>
</html>
