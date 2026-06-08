<?php

declare(strict_types=1);

namespace RentEase\Services;

use RentEase\Services\MailService;
use RentEase\Support\MailTemplate;
use RentEase\Support\Validator;

/**
 * Service to handle password reset logic.
 */
final class PasswordResetService extends BaseSupabaseService
{
    private MailService $mailService;
    private AuthService $auth;

    /**
     * @param array<string, mixed> $config
     * @param MailService $mailService
     * @param AuthService $auth
     */
    public function __construct(array $config, MailService $mailService, AuthService $auth)
    {
        parent::__construct($config);
        $this->mailService = $mailService;
        $this->auth = $auth;
    }

    /**
     * Request a password reset link.
     *
     * @param string $email
     * @return bool
     */
    public function requestReset(string $email): bool
    {
        // 1. Check if user exists
        $userId = $this->auth->getUserIdByEmail($email);
        if (!$userId) {
            // Return true anyway to prevent email enumeration
            return true;
        }

        // 2. Check rate limit (3 requests per hour)
        if ($this->isRateLimited($email)) {
            throw new \RuntimeException('Too many reset requests. Please wait before trying again.');
        }

        // 3. Generate secure token
        $rawToken = bin2hex(random_bytes(32));
        $hashedToken = hash('sha256', $rawToken);
        $expiresAt = (new \DateTimeImmutable())->modify('+1 hour')->format('Y-m-d H:i:sP');

        // 4. Save to DB
        $this->request('POST', '/rest/v1/password_resets', $this->serviceHeaders(), [
            'email' => $email,
            'token' => $hashedToken,
            'expires_at' => $expiresAt
        ]);

        // 5. Send email via Resend (Auth transactional)
        $resetLink = rtrim((string) $this->config['app_url'], '/') . '/reset-password?token=' . rawurlencode($rawToken);
        $subject = "RentEase - Password Reset Request";

        $body = MailTemplate::basic(
            "Reset Your Password",
            "<p>We received a request to reset your password for your RentEase account. If you did not request this, you can safely ignore this email.</p>
             <div style='text-align: center; margin: 35px 0;'>
                <a href='{$resetLink}' style='background-color: #2d3748; color: #ffffff; padding: 14px 28px; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-block;'>Reset Password</a>
             </div>
             <p style='font-size: 14px; color: #718096;'>This link will expire in <strong>1 hour</strong> for your security.</p>"
        );

        return $this->mailService->sendAuth($email, $subject, $body);
    }

    /**
     * Validate a reset token and return the associated email.
     *
     * @param string $rawToken
     * @return string|null
     */
    public function validateToken(string $rawToken): ?string
    {
        if (empty($rawToken)) {
            return null;
        }

        $hashedToken = hash('sha256', $rawToken);
        $path = '/rest/v1/password_resets?select=email,expires_at&token=eq.' . $hashedToken . '&limit=1';
        $response = $this->request('GET', $path, $this->serviceHeaders());

        if ($response['status'] >= 200 && $response['status'] < 300 && !empty($response['body'][0])) {
            $reset = $response['body'][0];
            $expiresAt = new \DateTimeImmutable($reset['expires_at']);
            if ($expiresAt > new \DateTimeImmutable()) {
                return $reset['email'];
            }
        }

        return null;
    }

    /**
     * Reset the user password and invalidate the token.
     *
     * @param string $rawToken
     * @param string $newPassword
     * @return void
     */
    public function resetPassword(string $rawToken, string $newPassword): void
    {
        $email = $this->validateToken($rawToken);
        if (!$email) {
            throw new \RuntimeException('Invalid or expired reset token.');
        }

        $userId = $this->auth->getUserIdByEmail($email);
        if (!$userId) {
            throw new \RuntimeException('User account no longer exists.');
        }

        // Update password in Supabase Auth
        $this->auth->adminUpdatePassword($userId, $newPassword);

        // Invalidate all tokens for this email
        $this->request('DELETE', '/rest/v1/password_resets?email=eq.' . urlencode($email), $this->serviceHeaders());
    }

    /**
     * Check if an email is rate limited for password resets.
     *
     * @param string $email
     * @return bool
     */
    private function isRateLimited(string $email): bool
    {
        $oneHourAgo = (new \DateTimeImmutable())->modify('-1 hour')->format('Y-m-d H:i:sP');
        $path = '/rest/v1/password_resets?select=id&email=eq.' . urlencode($email) . '&created_at=gt.' . urlencode($oneHourAgo);
        $response = $this->request('GET', $path, $this->serviceHeaders());

        return $response['status'] >= 200 && $response['status'] < 300 && count($response['body'] ?? []) >= 3;
    }
}
