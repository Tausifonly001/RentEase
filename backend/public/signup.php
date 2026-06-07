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
    <meta name="theme-color" content="#ffffff">
    <link rel="icon" type="image/svg+xml" href="<?= baseUrl('/favicon.svg') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="<?= baseUrl('/assets/css/theme.css') ?>">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#0a0a0a',
                        surface: '#fafafa',
                        champagne: '#c5b39b',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .clip-reveal { clip-path: inset(0 100% 0 0); }
        .text-mask { overflow: hidden; display: inline-block; vertical-align: bottom; padding-bottom: 0.1em; margin-bottom: -0.1em; }
        .text-mask-inner { display: inline-block; transform: translateY(100%); }
    </style>
</head>
<body class="min-h-screen bg-white text-zinc-500 font-sans selection:bg-champagne/30 selection:text-ink overflow-x-hidden">
    <div class="flex min-h-screen w-full flex-row-reverse">
        <!-- Right Side: Form -->
        <div class="w-full lg:w-1/2 flex flex-col px-6 sm:px-12 lg:px-24 py-10 relative z-10 bg-white">
            <!-- Header -->
            <header class="flex items-center justify-between lg:justify-end mb-auto opacity-0 gsap-fade">
                <a href="<?= baseUrl('/') ?>" class="lg:hidden text-xl font-serif font-medium tracking-tight text-ink flex items-center gap-3 outline-none focus-visible:ring-1 ring-champagne group">
                    <span class="w-8 h-8 flex items-center justify-center bg-ink text-white font-medium group-hover:bg-champagne transition-colors duration-500">R</span>
                </a>
                <p class="text-[11px] font-medium text-zinc-400 uppercase tracking-[0.15em]">
                    Already a member? <a href="<?= baseUrl('/login') ?>" class="text-ink hover:text-champagne transition-colors duration-300 ml-1 outline-none focus-visible:ring-1 ring-champagne">Sign in</a>
                </p>
            </header>

            <!-- Form Container -->
            <div class="w-full max-w-sm mx-auto py-12 lg:py-0 form-container my-auto">
                <div class="mb-12">
                    <div class="hidden lg:inline-flex items-center gap-3 mb-8 opacity-0 gsap-fade group cursor-pointer outline-none focus-visible:ring-1 ring-champagne" tabindex="0">
                        <span class="w-8 h-8 flex items-center justify-center bg-ink text-white font-medium group-hover:bg-champagne transition-colors duration-500">R</span>
                        <span class="font-serif font-medium tracking-tight text-ink text-xl">RentEase.</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-serif text-ink mb-4 tracking-tight leading-tight">
                        <span class="text-mask"><span class="text-mask-inner">Start your</span></span><br>
                        <span class="text-mask"><span class="text-mask-inner italic text-champagne">story.</span></span>
                    </h1>
                    <p class="text-zinc-500 text-sm font-light opacity-0 gsap-fade">Join RentEase to access premium living.</p>
                </div>

                <?php if ($error): ?>
                    <div class="mb-8 p-4 bg-red-50 border border-red-200 text-red-600 text-sm font-light opacity-0 gsap-fade">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form action="<?= baseUrl('/signup') ?>" method="POST" class="space-y-6" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                    <div class="space-y-2 opacity-0 gsap-fade">
                        <label for="full_name" class="block text-[10px] font-medium text-ink uppercase tracking-[0.2em]">Full name</label>
                        <input type="text" id="full_name" name="full_name" required autocomplete="name"
                               class="w-full bg-transparent border-b border-zinc-200 px-0 py-3 text-ink placeholder-zinc-300 focus:outline-none focus:border-champagne focus:ring-0 transition-colors duration-500 font-light rounded-none"
                               placeholder="Jane Cooper"
                               value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">
                    </div>

                    <div class="space-y-2 opacity-0 gsap-fade">
                        <label for="email" class="block text-[10px] font-medium text-ink uppercase tracking-[0.2em]">Email</label>
                        <input type="email" id="email" name="email" required autocomplete="email"
                               class="w-full bg-transparent border-b border-zinc-200 px-0 py-3 text-ink placeholder-zinc-300 focus:outline-none focus:border-champagne focus:ring-0 transition-colors duration-500 font-light rounded-none"
                               placeholder="you@example.com"
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>

                    <div class="space-y-2 opacity-0 gsap-fade">
                        <label for="password" class="block text-[10px] font-medium text-ink uppercase tracking-[0.2em]">Password</label>
                        <input type="password" id="password" name="password" required autocomplete="new-password"
                               class="w-full bg-transparent border-b border-zinc-200 px-0 py-3 text-ink placeholder-zinc-300 focus:outline-none focus:border-champagne focus:ring-0 transition-colors duration-500 font-light rounded-none" 
                               placeholder="At least 8 characters">
                    </div>

                    <div class="flex items-start pt-2 opacity-0 gsap-fade">
                        <div class="flex items-center h-5">
                            <input type="checkbox" id="terms" name="terms" required class="w-4 h-4 rounded-none border-zinc-300 text-champagne focus:ring-champagne focus:ring-offset-white cursor-pointer transition-colors duration-300">
                        </div>
                        <label for="terms" class="ml-3 text-sm font-light text-zinc-500 leading-snug cursor-pointer select-none">
                            I agree to the <a href="<?= baseUrl('/terms') ?>" class="text-ink hover:text-champagne transition-colors duration-300 underline decoration-zinc-300 underline-offset-4">Terms</a> and <a href="<?= baseUrl('/privacy') ?>" class="text-ink hover:text-champagne transition-colors duration-300 underline decoration-zinc-300 underline-offset-4">Privacy Policy</a>.
                        </label>
                    </div>

                    <button type="submit" class="w-full mt-10 bg-ink text-white text-[11px] font-medium tracking-[0.2em] uppercase py-4 outline-none focus-visible:ring-1 focus:ring-offset-2 focus:ring-offset-white focus:ring-champagne hover:bg-champagne hover:text-ink transition-all duration-500 opacity-0 gsap-fade relative overflow-hidden group">
                        <span class="relative z-10">Create Account</span>
                    </button>
                </form>

                <?php if (!empty($oauthProviders)): ?>
                <div class="mt-10 opacity-0 gsap-fade">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-zinc-100"></div>
                        </div>
                        <div class="relative flex justify-center text-[9px] uppercase tracking-[0.25em] font-medium">
                            <span class="px-4 bg-white text-zinc-300">Or continue with</span>
                        </div>
                    </div>
                    <div class="mt-8 grid grid-cols-<?= min(2, count($oauthProviders)) ?> gap-4">
                        <?php foreach ($oauthProviders as $id => $provider): ?>
                            <a href="<?= baseUrl('/api/auth/oauth?provider=' . $id) ?>" class="flex justify-center items-center gap-3 w-full border border-zinc-200 py-3 hover:border-champagne transition-colors duration-500 outline-none focus-visible:ring-1 ring-champagne group">
                                <img src="<?= $provider['icon'] ?>" alt="<?= htmlspecialchars($provider['name']) ?>" class="w-4 h-4 opacity-60 group-hover:opacity-100 transition-opacity duration-500 grayscale group-hover:grayscale-0">
                                <span class="text-[10px] font-medium text-ink uppercase tracking-widest"><?= htmlspecialchars($provider['name']) ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Footer -->
            <footer class="mt-auto text-[10px] uppercase tracking-[0.15em] text-zinc-400 font-medium flex justify-center lg:justify-end opacity-0 gsap-fade">
                <span>&copy; <?= date('Y') ?> RentEase.</span>
            </footer>
        </div>

        <!-- Left Side: Image -->
        <div class="hidden lg:block lg:w-1/2 relative bg-surface overflow-hidden border-r border-zinc-200">
            <div class="absolute inset-0 bg-champagne/10 z-10 clip-reveal" id="image-overlay"></div>
            <img src="<?= baseUrl('/assets/images/auth/signup_bg.png') ?>" alt="Designer Furniture" class="absolute inset-0 w-full h-full object-cover grayscale-[30%] origin-center scale-110" id="hero-image">
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent z-10"></div>
            
            <div class="absolute bottom-16 left-16 right-16 text-white max-w-lg z-20">
                <div class="inline-flex items-center gap-3 px-4 py-2 border border-champagne/50 bg-black/20 backdrop-blur-md text-champagne text-[9px] font-medium uppercase tracking-[0.25em] mb-8 opacity-0 gsap-fade">
                    <span class="w-1.5 h-1.5 bg-champagne animate-pulse"></span>
                    Premium Living
                </div>
                <h2 class="text-3xl font-serif leading-tight mb-8 font-light italic">
                    <span class="text-mask"><span class="text-mask-inner quote-text">Elevate your everyday</span></span><br>
                    <span class="text-mask"><span class="text-mask-inner quote-text">with designer pieces,</span></span><br>
                    <span class="text-mask"><span class="text-mask-inner quote-text text-champagne">curated for you.</span></span>
                </h2>
                <div class="flex gap-12 mt-10 border-t border-white/20 pt-8 opacity-0" id="stats">
                    <div>
                        <div class="text-3xl font-serif text-white mb-2 italic">12k+</div>
                        <div class="text-[9px] text-champagne uppercase tracking-[0.25em] font-medium">Happy Members</div>
                    </div>
                    <div>
                        <div class="text-3xl font-serif text-white mb-2 italic">4.9/5</div>
                        <div class="text-[9px] text-champagne uppercase tracking-[0.25em] font-medium">Average Rating</div>
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
                    
                    // 1. Text Mask Reveals
                    tl.to('.text-mask-inner:not(.quote-text)', {
                        y: '0%',
                        duration: 1.2,
                        ease: 'power4.out',
                        stagger: 0.15
                    });

                    // 2. Image Reveal (Curtain effect)
                    tl.to('#image-overlay', {
                        clipPath: 'inset(0 0 0 100%)',
                        duration: 1.5,
                        ease: 'power4.inOut'
                    }, "-=1.0");

                    // 3. Image Scale down
                    tl.to('#hero-image', {
                        scale: 1,
                        duration: 2.5,
                        ease: 'power2.out'
                    }, "-=1.5");

                    // 4. Form Elements Fade Up
                    tl.to('.gsap-fade', {
                        y: 0,
                        opacity: 1,
                        duration: 1,
                        stagger: 0.1,
                        ease: 'power3.out',
                        clearProps: 'transform'
                    }, "-=2.0");

                    // 5. Quote Text Reveal
                    tl.to('.quote-text', {
                        y: '0%',
                        duration: 1.2,
                        ease: 'power4.out',
                        stagger: 0.15
                    }, "-=1.5");

                    tl.to('#stats', {
                        opacity: 1,
                        y: 0,
                        duration: 1,
                        ease: 'power3.out'
                    }, "-=1.0");
                });
            } else {
                document.querySelectorAll('.gsap-fade, #stats').forEach(el => {
                    el.style.opacity = '1';
                });
                document.querySelectorAll('.text-mask-inner').forEach(el => {
                    el.style.transform = 'translateY(0)';
                });
                const imgOverlay = document.getElementById('image-overlay');
                if(imgOverlay) imgOverlay.style.display = 'none';
                const heroImg = document.getElementById('hero-image');
                if(heroImg) heroImg.style.transform = 'scale(1)';
            }
        });
    </script>
</body>
</html>
