<?php

declare(strict_types=1);

return [
    'supabase_url' => rtrim((string) getenv('SUPABASE_URL'), '/'),
    'supabase_anon_key' => (string) getenv('SUPABASE_ANON_KEY'),
    'supabase_service_role_key' => (string) getenv('SUPABASE_SERVICE_ROLE_KEY'),
    'app_url' => (string) getenv('APP_URL'),
    'cookie_name' => 'rentease_access_token',
    'refresh_cookie_name' => 'rentease_refresh_token',
    'csrf_cookie_name' => 'rentease_csrf_token',
    'allow_signup_admin_fallback' => filter_var(
        getenv('ALLOW_SIGNUP_ADMIN_FALLBACK') ?: 'false',
        FILTER_VALIDATE_BOOLEAN
    ),
    'cache_dir' => __DIR__ . '/../storage/cache',
    'cookie_secure' => isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'localhost') === false,
    'cookie_samesite' => 'Lax',
    'stripe_secret_key' => (string) (getenv('STRIPE_SECRET_KEY') ?: getenv('STRIPE_SECRET')),
    'stripe_webhook_secret' => (string) getenv('STRIPE_WEBHOOK_SECRET'),
    'smtp_host' => (string) getenv('SMTP_HOST'),
    'smtp_port' => (int) (getenv('SMTP_PORT') ?: 587),
    'smtp_user' => (string) getenv('SMTP_USER'),
    'smtp_pass' => (string) getenv('SMTP_PASS'),
    'resend_api_key' => (string) getenv('RESEND_API_KEY'),
    'resend_from_email' => (string) getenv('RESEND_FROM_EMAIL'),
    'onesignal_app_id' => (string) getenv('ONESIGNAL_APP_ID'),
    'onesignal_rest_api_key' => (string) getenv('ONESIGNAL_REST_API_KEY'),
    'onesignal_safari_web_id' => (string) getenv('ONESIGNAL_SAFARI_WEB_ID'),
    'google_maps_api_key' => (string) getenv('GOOGLE_MAPS_API_KEY'),
    'groq_api_key' => (string) getenv('GROQ_API_KEY'),
    'unsplash_access_key' => (string) getenv('UNSPLASH_ACCESS_KEY'),
    'shiprocket_email' => (string) getenv('SHIPROCKET_EMAIL'),
    'shiprocket_password' => (string) getenv('SHIPROCKET_PASSWORD'),
    'enabled_oauth_providers' => [
        'google' => ['name' => 'Google', 'icon' => 'https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png'],
        'github' => ['name' => 'GitHub', 'icon' => 'https://github.githubassets.com/images/modules/logos_page/GitHub-Mark.png'],
    ],
];