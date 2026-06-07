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

$token = (string)($_GET['token'] ?? $_POST['token'] ?? '');
$email = $resetService->validateToken($token);

$error = null;
$message = null;

if (!$email) {
    $error = 'The password reset link is invalid or has expired.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $email) {
    if (!Csrf::validate($_POST['csrf_token'] ?? null)) {
        $error = 'Your session has expired. Please refresh and try again.';
    } else {
        $password = (string)($_POST['password'] ?? '');
        $confirmPassword = (string)($_POST['confirm_password'] ?? '');

        if (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters long.';
        } elseif ($password !== $confirmPassword) {
            $error = 'Passwords do not match.';
        } else {
            try {
                $resetService->resetPassword($token, $password);
                $message = 'Your password has been reset successfully.';
            } catch (Throwable $e) {
                $error = 'Reset failed: ' . $e->getMessage();
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
    <title>Reset Password | RentEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Material+Symbols+Outlined" rel="stylesheet">
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
                        sans: ['Inter', 'sans-serif']
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
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-100 rounded-full blur-[120px] -z-10"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-indigo-100 rounded-full blur-[120px] -z-10"></div>

    <div class="w-full max-w-md" id="reset-password-container">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-primary tracking-tight mb-2">RentEase</h1>
            <p class="text-slate-500 font-normal">Furniture & Appliance Rental Platform</p>
        </div>

        <div class="glass border border-white/40 rounded-[2.5rem] p-8 md:p-12 shadow-2xl shadow-blue-900/5">
            <div class="mb-8">
                <h2 class="text-2xl font-normal text-primary mb-2">New Password</h2>
                <p class="text-slate-500 text-sm leading-relaxed font-light">Please choose a strong password to secure your account.</p>
            </div>

            <?php if ($error && !$email): ?>
                <div class="mb-6 p-6 bg-red-50 border border-red-100 rounded-[2rem] text-center">
                    <span class="material-symbols-outlined text-4xl text-red-500 mb-4">cancel</span>
                    <h3 class="text-red-900 font-normal mb-2">Invalid Link</h3>
                    <p class="text-red-700 text-sm mb-6 font-light"><?= htmlspecialchars($error) ?></p>
                    <a href="forgot-password.php" class="inline-block py-3 px-6 bg-red-600 text-white font-normal rounded-xl hover:bg-red-700 transition-colors">
                        Request New Link
                    </a>
                </div>
            <?php elseif ($message): ?>
                <div class="mb-6 p-6 bg-emerald-50 border border-emerald-100 rounded-[2rem] text-center">
                    <span class="material-symbols-outlined text-4xl text-emerald-500 mb-4">task_alt</span>
                    <h3 class="text-emerald-900 font-normal mb-2">Success!</h3>
                    <p class="text-emerald-700 text-sm mb-6 font-light"><?= htmlspecialchars($message) ?></p>
                    <a href="<?= baseUrl('/login') ?>" class="inline-block py-3 px-6 bg-emerald-600 text-white font-normal rounded-xl hover:bg-emerald-700 transition-colors">
                        Go to Login
                    </a>
                </div>
            <?php elseif ($email): ?>
                <?php if ($error): ?>
                    <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl flex items-center gap-3">
                        <span class="material-symbols-outlined text-red-500">error</span>
                        <p class="text-red-700 text-sm font-light"><?= htmlspecialchars($error) ?></p>
                    </div>
                <?php endif; ?>

                <form action="reset-password.php" method="POST" class="space-y-6">
                    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-light text-primary">New Password</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-xl">lock</span>
                            <input type="password" id="password" name="password" required 
                                class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none text-slate-900"
                                placeholder="••••••••">
                        </div>
                        <p class="text-[10px] text-slate-400">Min. 6 characters with letters and numbers</p>
                    </div>

                    <div class="space-y-2">
                        <label for="confirm_password" class="block text-sm font-light text-primary">Confirm Password</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-xl">verified_user</span>
                            <input type="password" id="confirm_password" name="confirm_password" required 
                                class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none text-slate-900"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-primary hover:bg-slate-800 text-white font-normal rounded-xl shadow-lg shadow-primary/10 transition-all transform hover:-translate-y-0.5 active:scale-[0.98]">
                        Update Password
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <script>
        window.addEventListener('load', () => {
            gsap.from('#reset-password-container', {
                opacity: 0,
                y: 30,
                duration: 1,
                ease: 'power3.out'
            });

            gsap.from('form > div, .rounded-[2rem]', {
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
