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
    <div class="flex min-h-screen w-full flex-row-reverse">
        <!-- Right Side: Form -->
        <div class="w-full lg:w-1/2 flex flex-col px-6 sm:px-12 lg:px-20 py-8 lg:py-12 relative z-10 bg-ink">
            <!-- Header -->
            <header class="flex items-center justify-between lg:justify-end mb-auto animate-fade-up">
                <a href="<?= baseUrl('/') ?>" class="lg:hidden text-xl font-serif tracking-tight text-white flex items-center gap-3">
                    <span class="w-8 h-8 flex items-center justify-center bg-white text-black font-bold rounded-sm">R</span>
                </a>
                <p class="text-sm text-neutral-400">
                    Already a member? <a href="<?= baseUrl('/login') ?>" class="text-accent hover:text-accent/80 font-medium transition-colors ml-1">Sign in</a>
                </p>
            </header>

            <!-- Form Container -->
            <div class="w-full max-w-sm mx-auto py-12 lg:py-0 form-container my-auto">
                <div class="mb-10 animate-fade-up" style="animation-delay: 0.05s;">
                    <div class="hidden lg:inline-flex items-center gap-2 mb-6">
                        <span class="w-8 h-8 flex items-center justify-center bg-white text-black font-bold rounded-sm">R</span>
                        <span class="font-serif tracking-tight text-white text-xl">RentEase</span>
                    </div>
                    <h1 class="text-3xl lg:text-4xl font-serif text-white mb-3 tracking-tight">Start your story</h1>
                    <p class="text-neutral-400 text-sm">Join RentEase to access premium furniture and effortless living.</p>
                </div>

                <?php if ($error): ?>
                    <div class="mb-8 p-4 bg-red-500/10 border border-red-500/20 text-red-400 text-sm rounded-lg animate-fade-up">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form action="<?= baseUrl('/signup') ?>" method="POST" class="space-y-5" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                    <div class="space-y-1.5 animate-fade-up" style="animation-delay: 0.1s;">
                        <label for="full_name" class="block text-sm font-medium text-neutral-300">Full name</label>
                        <input type="text" id="full_name" name="full_name" required autocomplete="name"
                               class="w-full bg-card border border-neutral-800 rounded-lg px-4 py-2.5 text-white placeholder-neutral-600 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors shadow-sm"
                               placeholder="Jane Cooper"
                               value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">
                    </div>

                    <div class="space-y-1.5 animate-fade-up" style="animation-delay: 0.15s;">
                        <label for="email" class="block text-sm font-medium text-neutral-300">Email</label>
                        <input type="email" id="email" name="email" required autocomplete="email"
                               class="w-full bg-card border border-neutral-800 rounded-lg px-4 py-2.5 text-white placeholder-neutral-600 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors shadow-sm"
                               placeholder="you@example.com"
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>

                    <div class="space-y-1.5 animate-fade-up" style="animation-delay: 0.2s;">
                        <label for="password" class="block text-sm font-medium text-neutral-300">Password</label>
                        <input type="password" id="password" name="password" required autocomplete="new-password"
                               class="w-full bg-card border border-neutral-800 rounded-lg px-4 py-2.5 text-white placeholder-neutral-600 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors shadow-sm" 
                               placeholder="At least 8 characters">
                    </div>

                    <div class="flex items-start pt-2 animate-fade-up" style="animation-delay: 0.25s;">
                        <div class="flex items-center h-5">
                            <input type="checkbox" id="terms" name="terms" required class="w-4 h-4 rounded border-neutral-700 bg-card text-accent focus:ring-accent focus:ring-offset-ink cursor-pointer">
                        </div>
                        <label for="terms" class="ml-3 text-xs text-neutral-400 leading-snug cursor-pointer select-none">
                            I agree to the <a href="<?= baseUrl('/terms') ?>" class="text-white hover:text-accent transition-colors underline decoration-neutral-700 underline-offset-2">Terms</a> and <a href="<?= baseUrl('/privacy') ?>" class="text-white hover:text-accent transition-colors underline decoration-neutral-700 underline-offset-2">Privacy Policy</a>.
                        </label>
                    </div>

                    <button type="submit" class="w-full mt-4 bg-accent text-ink font-semibold py-3 px-4 rounded-lg hover:bg-teal-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-ink focus:ring-accent transition-all transform active:scale-[0.98] animate-fade-up shadow-lg" style="animation-delay: 0.3s;">
                        Create Account
                    </button>
                </form>

                <?php if (!empty($oauthProviders)): ?>
                <div class="mt-8 animate-fade-up" style="animation-delay: 0.35s;">
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
            <footer class="mt-auto text-xs text-neutral-600 flex justify-center lg:justify-end animate-fade-up">
                <span>&copy; <?= date('Y') ?> RentEase. All rights reserved.</span>
            </footer>
        </div>

        <!-- Left Side: Image -->
        <div class="hidden lg:block lg:w-1/2 relative bg-ink overflow-hidden border-r border-neutral-900">
            <img src="<?= baseUrl('/assets/images/auth/signup_bg.png') ?>" alt="Designer Furniture" class="absolute inset-0 w-full h-full object-cover opacity-90 image-reveal">
            <div class="absolute inset-0 bg-gradient-to-t from-ink/90 via-ink/20 to-transparent"></div>
            
            <div class="absolute bottom-12 left-12 right-12 text-white reveal-text max-w-lg">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-white/10 bg-black/40 backdrop-blur-md text-white text-xs font-medium uppercase tracking-wider mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-accent animate-pulse"></span>
                    Premium Living
                </div>
                <h2 class="text-3xl font-serif leading-tight mb-4 text-neutral-100">
                    Elevate your everyday with designer pieces, curated exclusively for you.
                </h2>
                <div class="flex gap-8 mt-8 border-t border-white/10 pt-6">
                    <div>
                        <div class="text-2xl font-serif text-white">12k+</div>
                        <div class="text-xs text-neutral-400 mt-1 uppercase tracking-wider">Happy Members</div>
                    </div>
                    <div>
                        <div class="text-2xl font-serif text-white">4.9/5</div>
                        <div class="text-xs text-neutral-400 mt-1 uppercase tracking-wider">Average Rating</div>
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
                        { scale: 1.05, opacity: 0, x: -15 },
                        { scale: 1, opacity: 0.9, x: 0, duration: 1.5, ease: 'power2.out' },
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
