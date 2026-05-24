<?php

declare(strict_types=1);

namespace RentEase\Support;

/**
 * Class Csrf
 *
 * CSRF (Cross-Site Request Forgery) protection with per-request token rotation.
 * Tokens are regenerated after each successful validation to prevent replay attacks.
 */
final class Csrf
{
    /**
     * Ensure the session is started with secure defaults.
     */
    public static function ensureSessionStarted(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
            session_start([
                'cookie_httponly' => true,
                'cookie_secure' => $isSecure,
                'cookie_samesite' => 'Lax',
            ]);
        }
    }

    /**
     * Generate or retrieve the current CSRF token.
     *
     * @return string The CSRF token
     */
    public static function token(): string
    {
        self::ensureSessionStarted();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return (string) $_SESSION['csrf_token'];
    }

    /**
     * Validate a submitted CSRF token.
     * On success, the token is rotated to prevent replay attacks.
     *
     * @param string|null $token The submitted token to validate
     * @return bool True if valid
     */
    public static function validate(?string $token): bool
    {
        self::ensureSessionStarted();

        if (!is_string($token) || !isset($_SESSION['csrf_token'])) {
            return false;
        }

        if (!hash_equals((string) $_SESSION['csrf_token'], $token)) {
            return false;
        }

        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return true;
    }
}