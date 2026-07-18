<?php

declare(strict_types=1);

namespace RentEase\Services;

use RentEase\Support\Validator;

final class AuthService extends BaseSupabaseService
{
    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function signup(array $payload): array
    {
        $email = Validator::email($payload, 'email');
        $password = Validator::password($payload, 'password');
        $fullName = Validator::requiredString($payload, 'full_name', 2, 100);

        $response = $this->request('POST', '/auth/v1/signup', $this->anonHeaders(), [
            'email' => $email,
            'password' => $password,
            'data' => ['full_name' => $fullName],
        ]);

        $msg = strtolower((string)($response['body']['msg'] ?? $response['body']['message'] ?? $response['body']['error'] ?? ''));
        $isRateLimited = ($response['status'] === 429) || (strpos($msg, 'rate limit') !== false);

        // When email confirmation is required, the anonymous signup creates
        // the user but returns no session. Confirm the address through the
        // admin API so the new account is immediately usable without relying
        // on email delivery (the usual reason a fresh signup "fails").
        $user = $response['body']['user'] ?? null;
        if ($response['status'] >= 200 && $response['status'] < 300 && is_array($user)) {
            $isConfirmed = !empty($user['email_confirmed_at']) || !empty($response['body']['access_token']);
            if (!$isConfirmed && !empty($user['id'])) {
                try {
                    $this->request('PUT', '/auth/v1/admin/users/' . $user['id'], $this->serviceHeaders(), [
                        'email_confirm' => true,
                    ]);
                    $user['email_confirmed_at'] = date('c');
                    $response['body']['user'] = $user;
                } catch (Throwable $e) {
                    // Ignore — caller surfaces a clear error if login fails.
                }
            }
        }

        $allowAdminFallback = (bool) ($this->config['allow_signup_admin_fallback'] ?? false);
        if ($isRateLimited && $allowAdminFallback) {
            $adminResponse = $this->request('POST', '/auth/v1/admin/users', $this->serviceHeaders(), [
                'email' => $email,
                'password' => $password,
                'email_confirm' => true,
                'user_metadata' => ['full_name' => $fullName],
            ]);
            if ($adminResponse['status'] >= 200 && $adminResponse['status'] < 300) {
                return $adminResponse['body'];
            }
        }

        // Recovery: if the email is already registered (e.g. from a previous
        // unconfirmed attempt), confirm it and sign in so the user is never
        // blocked from reaching the application.
        if ($response['status'] < 200 || $response['status'] >= 300) {
            $body = strtolower((string)($response['body']['msg'] ?? $response['body']['message'] ?? $response['body']['error'] ?? $response['body']['error_description'] ?? ''));
            $alreadyExists = strpos($body, 'already registered') !== false
                || strpos($body, 'already been registered') !== false
                || strpos($body, 'user already') !== false;
            if ($alreadyExists) {
                $recovered = $this->recoverExistingAccount($email, $password);
                if ($recovered !== null) {
                    return $recovered;
                }
            }
        }

        $this->assertSuccess($response, 'Signup failed');

        // If signup did not already issue a session, exchange the credentials
        // for one so the caller is authenticated straight away.
        if (empty($response['body']['access_token'])) {
            try {
                $session = $this->login(['email' => $email, 'password' => $password]);
                if (!empty($session['access_token'])) {
                    $response['body'] = array_merge($response['body'], $session);
                }
            } catch (Throwable $e) {
                // Account exists; the user can sign in manually.
            }
        }

        return $response['body'];
    }

    /**
     * Best-effort recovery for an email that is already registered: try a
     * direct login, and if that fails because the account is unconfirmed,
     * confirm it via the admin API and log in again.
     *
     * @return array<string, mixed>|null
     */
    private function recoverExistingAccount(string $email, string $password): ?array
    {
        try {
            $session = $this->login(['email' => $email, 'password' => $password]);
            if (!empty($session['access_token'])) {
                return $session;
            }
        } catch (Throwable $e) {
            // Account likely unconfirmed; attempt confirmation below.
        }

        try {
            $listResponse = $this->request('GET', '/auth/v1/admin/users?email=' . urlencode($email) . '&per_page=1', $this->serviceHeaders());
            $users = $listResponse['body']['users'] ?? [];
            $userId = is_array($users) && !empty($users[0]['id']) ? (string) $users[0]['id'] : '';
            if ($userId !== '') {
                $this->request('PUT', '/auth/v1/admin/users/' . $userId, $this->serviceHeaders(), [
                    'email_confirm' => true,
                ]);
                $session = $this->login(['email' => $email, 'password' => $password]);
                if (!empty($session['access_token'])) {
                    return $session;
                }
            }
        } catch (Throwable $e) {
            // Fall through to the original signup error.
        }

        return null;
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function login(array $payload): array
    {
        $email = Validator::email($payload, 'email');
        $password = Validator::password($payload, 'password');

        $response = $this->request(
            'POST',
            '/auth/v1/token?grant_type=password',
            $this->anonHeaders(),
            ['email' => $email, 'password' => $password]
        );

        $this->assertSuccess($response, 'Authentication failed');
        return $response['body'];
    }

    /** @return array<string, mixed>|null */
    public function validateToken(string $jwt): ?array
    {
        if ($jwt === '') {
            return $this->attemptRefreshFromCookie();
        }

        $user = $this->fetchUser($jwt);
        if ($user !== null) {
            return $this->attachRole($user);
        }

        return $this->attemptRefreshFromCookie();
    }

    /**
     * Persist access + optional refresh tokens after login/OAuth.
     *
     * @param array<string, mixed> $session
     */
    public function persistSession(array $session, bool $remember = false): void
    {
        $token = (string) ($session['access_token'] ?? '');
        if ($token === '') {
            return;
        }

        $expiresIn = (int) ($session['expires_in'] ?? 3600);
        if ($remember) {
            $expiresIn = max($expiresIn, 60 * 60 * 24 * 30);
        }

        $this->setAuthCookie($token, $expiresIn);
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['_auth_current_jwt'] = $token;

        $refresh = (string) ($session['refresh_token'] ?? '');
        if ($remember && $refresh !== '') {
            $this->setRefreshCookie($refresh, 60 * 60 * 24 * 30);
        }
    }

    public function setAuthCookie(string $token, int $expiresIn): void
    {
        $maxAge = max(60, $expiresIn);
        setcookie((string) $this->config['cookie_name'], $token, [
            'expires' => time() + $maxAge,
            'path' => '/',
            'secure' => (bool) $this->config['cookie_secure'],
            'httponly' => true,
            'samesite' => (string) $this->config['cookie_samesite'],
        ]);
    }

    public function setRefreshCookie(string $refreshToken, int $expiresIn): void
    {
        $name = (string) ($this->config['refresh_cookie_name'] ?? 'rentease_refresh_token');
        setcookie($name, $refreshToken, [
            'expires' => time() + max(60, $expiresIn),
            'path' => '/',
            'secure' => (bool) $this->config['cookie_secure'],
            'httponly' => true,
            'samesite' => (string) $this->config['cookie_samesite'],
        ]);
    }

    public function clearAuthCookie(): void
    {
        setcookie((string) $this->config['cookie_name'], '', [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => (bool) $this->config['cookie_secure'],
            'httponly' => true,
            'samesite' => (string) $this->config['cookie_samesite'],
        ]);

        $refreshName = (string) ($this->config['refresh_cookie_name'] ?? 'rentease_refresh_token');
        setcookie($refreshName, '', [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => (bool) $this->config['cookie_secure'],
            'httponly' => true,
            'samesite' => (string) $this->config['cookie_samesite'],
        ]);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['_auth_current_jwt']);
    }

    /**
     * OAuth authorize URL (PKCE when $codeChallenge is provided).
     */
    public function getOAuthUrl(string $provider, string $redirectUrl, ?string $codeChallenge = null): string
    {
        $query = [
            'provider' => $provider,
            'redirect_to' => $redirectUrl,
        ];

        if ($codeChallenge !== null && $codeChallenge !== '') {
            $query['code_challenge'] = $codeChallenge;
            $query['code_challenge_method'] = 's256';
        }

        return $this->config['supabase_url'] . '/auth/v1/authorize?' . http_build_query($query);
    }

    /**
     * @return array<string, mixed>
     */
    public function exchangeCodeForSession(string $code, string $codeVerifier): array
    {
        $response = $this->request('POST', '/auth/v1/token?grant_type=pkce', $this->anonHeaders(), [
            'auth_code' => $code,
            'code_verifier' => $codeVerifier,
        ]);

        $this->assertSuccess($response, 'OAuth exchange failed');
        return $response['body'];
    }

    /**
     * Generate PKCE verifier + S256 challenge for OAuth.
     *
     * @return array{0: string, 1: string}
     */
    public static function generatePkcePair(): array
    {
        $verifier = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
        $challenge = rtrim(strtr(base64_encode(hash('sha256', $verifier, true)), '+/', '-_'), '=');

        return [$verifier, $challenge];
    }

    /**
     * Clear cached role/auth data for a user (call after role changes).
     */
    public static function clearUserCaches(string $userId): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        unset($_SESSION['user_role_' . $userId]);

        if (isset($_SESSION['_auth_cached_user']['id']) && $_SESSION['_auth_cached_user']['id'] === $userId) {
            unset(
                $_SESSION['_auth_cached_user'],
                $_SESSION['_auth_cached_token'],
                $_SESSION['_auth_cache_expiry']
            );
        }
    }

    /** @return array<string, mixed>|null */
    public function getUserIdByEmail(string $email): ?string
    {
        $path = '/rest/v1/profiles?select=id&email=eq.' . urlencode($email) . '&limit=1';
        $response = $this->request('GET', $path, $this->serviceHeaders());

        if ($response['status'] >= 200 && $response['status'] < 300 && !empty($response['body'][0])) {
            return $response['body'][0]['id'];
        }

        return null;
    }

    public function adminUpdatePassword(string $userId, string $newPassword): void
    {
        Validator::password(['password' => $newPassword], 'password');

        $path = '/auth/v1/admin/users/' . $userId;
        $response = $this->request('PUT', $path, $this->serviceHeaders(), [
            'password' => $newPassword,
        ]);

        $this->assertSuccess($response, 'Failed to update user password');
    }

    /**
     * Resolve role from profiles table (source of truth).
     *
     * @param array<string, mixed> $user
     */
    public static function resolveRole(array $user): string
    {
        return (string) ($user['role'] ?? 'user');
    }

    /** @return array<string, mixed>|null */
    private function fetchUser(string $jwt): ?array
    {
        $response = $this->request('GET', '/auth/v1/user', $this->userHeaders($jwt));
        if ($response['status'] >= 200 && $response['status'] < 300) {
            return is_array($response['body']) ? $response['body'] : null;
        }

        return null;
    }

    /**
     * @param array<string, mixed> $user
     * @return array<string, mixed>
     */
    private function attachRole(array $user): array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = (string) ($user['id'] ?? '');
        if ($userId !== '' && isset($_SESSION['user_role_' . $userId])) {
            $user['role'] = $_SESSION['user_role_' . $userId];
            return $user;
        }

        $profilePath = '/rest/v1/profiles?select=role&id=eq.' . rawurlencode($userId) . '&limit=1';
        $profileRes = $this->request('GET', $profilePath, $this->serviceHeaders());

        if ($profileRes['status'] >= 200 && $profileRes['status'] < 300 && !empty($profileRes['body'][0])) {
            $user['role'] = $profileRes['body'][0]['role'] ?? 'user';
        } else {
            $user['role'] = 'user';
        }

        if ($userId !== '') {
            $_SESSION['user_role_' . $userId] = $user['role'];
        }

        return $user;
    }

    /** @return array<string, mixed>|null */
    private function attemptRefreshFromCookie(): ?array
    {
        $refreshName = (string) ($this->config['refresh_cookie_name'] ?? 'rentease_refresh_token');
        $refreshToken = (string) ($_COOKIE[$refreshName] ?? '');
        if ($refreshToken === '') {
            return null;
        }

        $response = $this->request(
            'POST',
            '/auth/v1/token?grant_type=refresh_token',
            $this->anonHeaders(),
            ['refresh_token' => $refreshToken]
        );

        if ($response['status'] < 200 || $response['status'] >= 300) {
            return null;
        }

        $body = $response['body'];
        if (!is_array($body)) {
            return null;
        }

        $this->persistSession($body, true);

        $newJwt = (string) ($body['access_token'] ?? '');
        if ($newJwt === '') {
            return null;
        }

        $user = $this->fetchUser($newJwt);
        return $user !== null ? $this->attachRole($user) : null;
    }

    /**
     * @param array<string, mixed> $response
     */
    private function assertSuccess(array $response, string $message): void
    {
        if ($response['status'] < 200 || $response['status'] >= 300) {
            $error = (string) ($response['body']['msg'] ?? $response['body']['error_description'] ?? $message);
            throw new \RuntimeException($error);
        }
    }
}
