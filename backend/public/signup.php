<?php
declare(strict_types=1);

use RentEase\Services\AuthService;
use RentEase\Support\Csrf;

require __DIR__ . '/../bootstrap.php';

$authService = new AuthService($config);
$csrfToken = Csrf::token();
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Csrf::validate($_POST['csrf_token'] ?? null)) {
        $error = 'Your session has expired. Please refresh and try again.';
    } else {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';
        $fullName = filter_input(INPUT_POST, 'full_name', FILTER_DEFAULT);

        if (!$email || empty($password) || empty($fullName)) {
            $error = 'All fields are required. Please check your inputs.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters long.';
        } else {
            try {
                $payload = [
                    'email' => $email,
                    'password' => $password,
                    'full_name' => $fullName
                ];
                $authService->signup($payload);

                // Send Welcome Email via Resend
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

                // Send Push Notification via OneSignal
                try {
                    $onesignal = new \RentEase\Services\NotificationService($config);
                    $onesignal->sendPush([$email], 'Welcome to RentEase!', 'Your account has been created successfully.');
                } catch (\Throwable $e) {
                    error_log("Push notification failed: " . $e->getMessage());
                }

                $loginResult = $authService->login(['email' => $email, 'password' => $password]);
                $token = (string) ($loginResult['access_token'] ?? '');
                $expires = (int) ($loginResult['expires_in'] ?? 3600);

                if ($token !== '') {
                    $authService->setAuthCookie($token, $expires);
                }

                header('Location: ' . baseUrl('/'));
                exit;
            } catch (Throwable $e) {
                $error = 'Signup failed: ' . $e->getMessage();
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
    <title>Create Account - RentEase Premium</title>
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
                    <span class="text-5xl font-black text-white tracking-tighter">Rent<span class="text-secondary">Ease</span></span>
                </a>
                <h2 class="text-4xl font-bold text-white mb-6 leading-tight">Join the Premium Rental Marketplace.</h2>
                <p class="text-slate-400 text-lg max-w-md mx-auto">Create an account to start your journey with curated furniture and luxury living spaces.</p>
                
                <div class="mt-16 grid grid-cols-2 gap-4">
                    <div class="p-6 rounded-2xl bg-white/5 border border-white/10 text-left backdrop-blur-sm">
                        <span class="material-symbols-outlined text-secondary mb-3">auto_awesome</span>
                        <h4 class="text-white font-bold text-sm mb-1">Curated Styles</h4>
                        <p class="text-slate-500 text-xs">Designer-picked furniture collections.</p>
                    </div>
                    <div class="p-6 rounded-2xl bg-white/5 border border-white/10 text-left backdrop-blur-sm">
                        <span class="material-symbols-outlined text-secondary mb-3">verified_user</span>
                        <h4 class="text-white font-bold text-sm mb-1">Total Security</h4>
                        <p class="text-slate-500 text-xs">Insured rentals and secure payments.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Signup Form -->
        <div class="flex flex-col justify-start sm:justify-center w-full lg:w-1/2 px-5 sm:px-12 lg:px-24 bg-white relative min-w-0">
            <div class="absolute top-8 left-5 lg:hidden">
                <a href="<?= baseUrl('/') ?>" class="text-2xl font-black text-primary tracking-tighter">RentEase</a>
            </div>

            <div id="signup-container" class="w-full max-w-md mx-auto pt-24 pb-12 sm:py-12 min-w-0">
                <header class="mb-10">
                    <h1 class="text-3xl font-bold text-primary mb-2">Create Account</h1>
                    <p class="text-slate-500">Join RentEase and elevate your living space today.</p>
                </header>

                <?php if ($error): ?>
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 flex gap-3 items-center text-red-700 text-sm animate-shake">
                        <span class="material-symbols-outlined text-red-500">error</span>
                        <p><?= htmlspecialchars($error) ?></p>
                    </div>
                <?php endif; ?>

                <form action="<?= baseUrl('/signup') ?>" method="POST" class="space-y-5">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                    
                    <div>
                        <label for="full_name" class="block text-sm font-semibold text-primary mb-2">Full Name</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-xl">person</span>
                            <input type="text" id="full_name" name="full_name" required 
                                class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none text-slate-900"
                                placeholder="John Doe"
                                value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-primary mb-2">Email Address</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-xl">mail</span>
                            <input type="email" id="email" name="email" required 
                                class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none text-slate-900"
                                placeholder="name@company.com"
                                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-primary mb-2">Password</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-xl">lock</span>
                            <input type="password" id="password" name="password" required 
                                class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none text-slate-900"
                                placeholder="At least 6 characters">
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="flex items-center h-5 mt-0.5">
                            <input id="terms" name="terms" type="checkbox" required class="w-4 h-4 text-secondary border-slate-300 rounded focus:ring-secondary cursor-pointer">
                        </div>
                        <div class="text-sm">
                            <label for="terms" class="text-slate-500 leading-relaxed">I agree to the <a href="<?= baseUrl('/terms') ?>" class="text-secondary font-bold hover:underline">Terms of Service</a> and <a href="<?= baseUrl('/privacy') ?>" class="text-secondary font-bold hover:underline">Privacy Policy</a>.</label>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-primary hover:bg-slate-800 text-white font-bold rounded-xl shadow-lg shadow-primary/10 transition-all transform hover:-translate-y-0.5 active:scale-[0.98]">
                        Create Account
                    </button>
                </form>

                <!-- Social Signup -->
                <div class="mt-8">
                    <div class="relative flex items-center mb-8">
                        <div class="flex-grow border-t border-slate-200"></div>
                        <span class="flex-shrink mx-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Or sign up with</span>
                        <div class="flex-grow border-t border-slate-200"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <?php foreach ($oauthProviders as $id => $provider): ?>
                            <button onclick="window.location.href='<?= baseUrl('/api/auth/oauth.php?provider=' . $id) ?>'" 
                                class="flex items-center justify-center gap-3 px-4 py-3 border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors group w-full">
                                <img src="<?= $provider['icon'] ?>" alt="<?= $provider['name'] ?>" class="w-5 h-5 group-hover:scale-110 transition-transform">
                                <span class="text-sm font-bold text-slate-700"><?= $provider['name'] ?></span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <footer class="mt-10 text-center">
                    <p class="text-slate-500 text-sm">
                        Already have an account? 
                        <a href="<?= baseUrl('/login') ?>" class="text-secondary font-bold hover:underline">Sign in instead</a>
                    </p>
                </footer>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', () => {
            gsap.from('#signup-container', {
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
