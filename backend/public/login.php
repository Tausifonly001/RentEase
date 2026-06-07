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
$pageTitle = 'Welcome back — RentEase';
$pageDescription = 'Sign in to manage your rentals, track deliveries, and access member rewards.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="theme-color" content="#0a0a0a">
    <link rel="icon" type="image/svg+xml" href="<?= baseUrl('/favicon.svg') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="<?= baseUrl('/assets/css/theme.css') ?>">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#0a0a0a',
                        card: '#111111',
                        accent: '#14b8a6',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-ink text-neutral-200 font-sans selection:bg-accent/30 overflow-x-hidden">
    <div class="flex min-h-screen w-full">
        <!-- Left Side: Form -->
        <div class="w-full lg:w-1/2 flex flex-col px-6 sm:px-12 lg:px-20 py-8 lg:py-12 relative z-10 bg-ink">
            <!-- Header -->
            <header class="flex items-center justify-between mb-auto animate-fade-up">
                <a href="<?= baseUrl('/') ?>" class="text-xl font-serif tracking-tight text-white flex items-center gap-3">
                    <span class="w-8 h-8 flex items-center justify-center bg-white text-black font-bold rounded-sm">R</span>
                    RentEase
                </a>
                <a href="<?= baseUrl('/signup') ?>" class="text-sm font-medium text-neutral-400 hover:text-white transition-colors">
                    New here? <span class="text-accent ml-1">Join</span>
                </a>
            </header>

            <!-- Form Container -->
            <div class="w-full max-w-sm mx-auto py-12 lg:py-0 form-container my-auto">
                <div class="mb-10 animate-fade-up" style="animation-delay: 0.05s;">
                    <h1 class="text-3xl lg:text-4xl font-serif text-white mb-3 tracking-tight">Welcome back</h1>
                    <p class="text-neutral-400 text-sm">Please enter your details to sign in to your account.</p>
                </div>

                <?php if ($error): ?>
                    <div class="mb-8 p-4 bg-red-500/10 border border-red-500/20 text-red-400 text-sm rounded-lg animate-fade-up">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form action="<?= baseUrl('/login') ?>" method="POST" class="space-y-5" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                    <div class="space-y-1.5 animate-fade-up" style="animation-delay: 0.1s;">
                        <label for="email" class="block text-sm font-medium text-neutral-300">Email</label>
                        <input type="email" id="email" name="email" required autocomplete="email"
                               class="w-full bg-card border border-neutral-800 rounded-lg px-4 py-2.5 text-white placeholder-neutral-600 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors shadow-sm"
                               placeholder="you@company.com"
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>

                    <div class="space-y-1.5 animate-fade-up" style="animation-delay: 0.15s;">
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm font-medium text-neutral-300">Password</label>
                            <a href="<?= baseUrl('/forgot-password') ?>" class="text-xs font-medium text-accent hover:text-accent/80 transition-colors">Forgot password?</a>
                        </div>
                        <input type="password" id="password" name="password" required autocomplete="current-password"
                               class="w-full bg-card border border-neutral-800 rounded-lg px-4 py-2.5 text-white placeholder-neutral-600 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors shadow-sm" 
                               placeholder="••••••••">
                    </div>

                    <div class="flex items-center pt-2 animate-fade-up" style="animation-delay: 0.2s;">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-neutral-700 bg-card text-accent focus:ring-accent focus:ring-offset-ink cursor-pointer">
                        <label for="remember" class="ml-3 text-sm text-neutral-400 cursor-pointer select-none hover:text-neutral-300 transition-colors">Keep me signed in for 30 days</label>
                    </div>

                    <button type="submit" class="w-full mt-4 bg-white text-black font-semibold py-3 px-4 rounded-lg hover:bg-neutral-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-ink focus:ring-white transition-all transform active:scale-[0.98] animate-fade-up shadow-lg" style="animation-delay: 0.25s;">
                        Sign In
                    </button>
                </form>

                <?php if (!empty($oauthProviders)): ?>
                <div class="mt-8 animate-fade-up" style="animation-delay: 0.3s;">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-neutral-800"></div>
                        </div>
                        <div class="relative flex justify-center text-xs uppercase tracking-widest font-medium">
                            <span class="px-4 bg-ink text-neutral-600">Or continue with</span>
                        </div>
                    </div>
                    <div class="mt-6 grid grid-cols-<?= min(2, count($oauthProviders)) ?> gap-3">
                        <?php foreach ($oauthProviders as $id => $provider): ?>
                            <a href="<?= baseUrl('/api/auth/oauth?provider=' . $id) ?>" class="flex justify-center items-center gap-3 w-full bg-card border border-neutral-800 rounded-lg py-2.5 hover:bg-neutral-800 transition-colors shadow-sm">
                                <img src="<?= $provider['icon'] ?>" alt="<?= htmlspecialchars($provider['name']) ?>" class="w-4 h-4">
                                <span class="text-sm font-medium text-neutral-300"><?= htmlspecialchars($provider['name']) ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Footer -->
            <footer class="mt-auto text-xs text-neutral-600 flex flex-col sm:flex-row justify-between items-center gap-4 animate-fade-up">
                <span>&copy; <?= date('Y') ?> RentEase. All rights reserved.</span>
                <div class="flex gap-4">
                    <a href="<?= baseUrl('/terms') ?>" class="hover:text-neutral-400 transition-colors">Terms</a>
                    <a href="<?= baseUrl('/privacy') ?>" class="hover:text-neutral-400 transition-colors">Privacy</a>
                </div>
            </footer>
        </div>

        <!-- Right Side: Image -->
        <div class="hidden lg:block lg:w-1/2 relative bg-ink overflow-hidden border-l border-neutral-900">
            <img src="<?= baseUrl('/assets/images/auth/login_bg.png') ?>" alt="Modern Interior" class="absolute inset-0 w-full h-full object-cover opacity-90 image-reveal">
            <div class="absolute inset-0 bg-gradient-to-t from-ink via-transparent to-transparent opacity-80"></div>
            
            <div class="absolute bottom-12 left-12 right-12 text-white reveal-text max-w-lg">
                <blockquote class="text-2xl font-serif leading-snug mb-6 text-neutral-100">
                    "RentEase transformed our empty apartment into a beautifully curated home in just a few hours. The process was entirely effortless."
                </blockquote>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-card rounded-full flex items-center justify-center font-bold text-sm border border-neutral-800 shadow-lg">SM</div>
                    <div>
                        <div class="font-medium text-sm">Sarah Miller</div>
                        <div class="text-xs text-neutral-400">Interior Designer</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof gsap !== 'undefined') {
                gsap.context(() => {
                    const tl = gsap.timeline();
                    
                    // Form elements fade up
                    tl.fromTo('.animate-fade-up', 
                        { y: 20, opacity: 0 }, 
                        { y: 0, opacity: 1, duration: 0.8, stagger: 0.05, ease: 'power2.out' }
                    );

                    // Image reveal
                    tl.fromTo('.image-reveal',
                        { scale: 1.05, opacity: 0 },
                        { scale: 1, opacity: 0.9, duration: 1.5, ease: 'power2.out' },
                        "-=0.6"
                    );

                    // Text reveal over image
                    tl.fromTo('.reveal-text',
                        { y: 15, opacity: 0 },
                        { y: 0, opacity: 1, duration: 0.8, ease: 'power2.out' },
                        "-=1"
                    );
                });
            } else {
                // Fallback if GSAP fails to load
                document.querySelectorAll('.animate-fade-up, .image-reveal, .reveal-text').forEach(el => {
                    el.style.opacity = '1';
                    el.style.transform = 'none';
                });
            }
        });
    </script>
</body>
</html>
