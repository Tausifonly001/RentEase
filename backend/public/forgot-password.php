<?php
declare(strict_types=1);

use RentEase\Services\AuthService;
use RentEase\Services\PasswordResetService;
use RentEase\Services\MailService;
use RentEase\Support\Csrf;

require __DIR__ . '/../bootstrap.php';

$authService = new AuthService($config);
$mailService = new MailService($config);
$resetService = new PasswordResetService($config, $mailService, $authService);
$csrfToken = Csrf::token();

$message = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Csrf::validate($_POST['csrf_token'] ?? null)) {
        $error = 'Your session has expired. Please refresh and try again.';
    } else {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $error = 'Please enter a valid email address.';
        } else {
            try {
                $resetService->requestReset($email);
                $message = 'If an account exists with that email, we have sent a password reset link.';
            } catch (Throwable $e) {
                $error = 'Request failed: ' . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="min-h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | RentEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Material+Symbols+Outlined" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0F172A',
                        secondary: '#3B82F6',
                        accent: '#F59E0B'
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-[#F8FAFC] font-sans min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Abstract background elements -->
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-100 rounded-full blur-[120px] -z-10"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-indigo-100 rounded-full blur-[120px] -z-10"></div>

    <div class="w-full max-w-md" id="forgot-password-container">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-primary tracking-tight mb-2">RentEase</h1>
            <p class="text-slate-500 font-medium">Furniture & Appliance Rental Platform</p>
        </div>

        <div class="glass border border-white/40 rounded-[2.5rem] p-8 md:p-12 shadow-2xl shadow-blue-900/5">
            <div class="mb-8">
                <a href="<?= baseUrl('/login') ?>" class="inline-flex items-center text-sm font-bold text-secondary hover:gap-2 transition-all mb-6 group">
                    <span class="material-symbols-outlined text-base mr-1 transition-transform group-hover:-translate-x-1">arrow_back</span>
                    Back to Login
                </a>
                <h2 class="text-2xl font-bold text-primary mb-2">Forgot Password?</h2>
                <p class="text-slate-500 text-sm leading-relaxed">Enter your email address and we'll send you a link to reset your password.</p>
            </div>

            <?php if ($error): ?>
                <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl flex items-center gap-3 animate-shake">
                    <span class="material-symbols-outlined text-red-500">error</span>
                    <p class="text-red-700 text-sm font-medium"><?= htmlspecialchars($error) ?></p>
                </div>
            <?php endif; ?>

            <?php if ($message): ?>
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3">
                    <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                    <p class="text-emerald-700 text-sm font-medium"><?= htmlspecialchars($message) ?></p>
                </div>
            <?php else: ?>
                <form action="forgot-password.php" method="POST" class="space-y-6">
                    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                    
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-primary">Email Address</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-xl">mail</span>
                            <input type="email" id="email" name="email" required 
                                class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none text-slate-900"
                                placeholder="name@company.com"
                                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-primary hover:bg-slate-800 text-white font-bold rounded-xl shadow-lg shadow-primary/10 transition-all transform hover:-translate-y-0.5 active:scale-[0.98]">
                        Send Reset Link
                    </button>
                </form>
            <?php endif; ?>

            <footer class="mt-10 text-center">
                <p class="text-slate-500 text-sm">
                    Remember your password? 
                    <a href="<?= baseUrl('/login') ?>" class="text-secondary font-bold hover:underline">Sign In</a>
                </p>
            </footer>
        </div>
    </div>

    <script>
        window.addEventListener('load', () => {
            gsap.from('#forgot-password-container', {
                opacity: 0,
                y: 30,
                duration: 1,
                ease: 'power3.out'
            });

            gsap.from('form > div, .animate-shake', {
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
