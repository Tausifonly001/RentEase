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
        $password = Validator::requiredString($payload, 'password', 6, 128);
        $fullName = Validator::requiredString($payload, 'full_name', 2, 100);

        $response = $this->request('POST', '/auth/v1/signup', $this->anonHeaders(), [
            'email' => $email,
            'password' => $password,
            'data' => ['full_name' => $fullName],
        ]);

        $msg = strtolower((string)($response['body']['msg'] ?? $response['body']['message'] ?? $response['body']['error'] ?? ''));
        $isRateLimited = ($response['status'] === 429) || (strpos($msg, 'rate limit') !== false);

        if ($isRateLimited) {
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

        $this->assertSuccess($response, 'Signup failed');
        return $response['body'];
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function login(array $payload): array
    {
        $email = Validator::email($payload, 'email');
        $password = Validator::requiredString($payload, 'password', 6, 128);

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
            return null;
        }

        $response = $this->request('GET', '/auth/v1/user', $this->userHeaders($jwt));
        if ($response['status'] >= 200 && $response['status'] < 300) {
            $user = $response['body'];
            
            // Fetch role from profiles table
            $profilePath = '/rest/v1/profiles?select=role&id=eq.' . $user['id'] . '&limit=1';
            $profileRes = $this->request('GET', $profilePath, $this->serviceHeaders());
            
            error_log("AuthService: Profile Fetch - Status: " . ($profileRes['status'] ?? 'N/A') . " ID: " . $user['id']);
            
            if ($profileRes['status'] >= 200 && $profileRes['status'] < 300 && !empty($profileRes['body'][0])) {
                $user['role'] = $profileRes['body'][0]['role'] ?? 'user';
                error_log("AuthService: Profile Found - Role: " . $user['role']);
            } else {
                error_log("AuthService: Profile NOT Found or Fetch Failed. Response: " . json_encode($profileRes['body'] ?? []));
                $user['role'] = 'user'; // Fallback
            }
            
            return $user;
        }

        return null;
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

    public function clearAuthCookie(): void
    {
        setcookie((string) $this->config['cookie_name'], '', [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => (bool) $this->config['cookie_secure'],
            'httponly' => true,
            'samesite' => (string) $this->config['cookie_samesite'],
        ]);
    }

    /**
     * Get the OAuth authorization URL.
     *
     * @param string $provider
     * @param string $redirectUrl
     * @return string
     */
    public function getOAuthUrl(string $provider, string $redirectUrl): string
    {
        return $this->config['supabase_url'] . '/auth/v1/authorize?provider=' . $provider . '&redirect_to=' . urlencode($redirectUrl);
    }

    /**
     * Exchange a code for a session (PKCE or standard OAuth).
     *
     * @param string $code
     * @return array<string, mixed>
     */
    public function exchangeCodeForSession(string $code): array
    {
        $response = $this->request('POST', '/auth/v1/token?grant_type=pkce', $this->anonHeaders(), [
            'auth_code' => $code,
        ]);

        $this->assertSuccess($response, 'OAuth exchange failed');
        return $response['body'];
    }
    
    /**
     * Check if an email exists in the profiles table and return the user ID.
     *
     * @param string $email
     * @return string|null
     */
    public function getUserIdByEmail(string $email): ?string
    {
        $path = '/rest/v1/profiles?select=id&email=eq.' . urlencode($email) . '&limit=1';
        $response = $this->request('GET', $path, $this->serviceHeaders());
        
        if ($response['status'] >= 200 && $response['status'] < 300 && !empty($response['body'][0])) {
            return $response['body'][0]['id'];
        }
        
        return null;
    }

    /**
     * Update a user's password using the Admin API.
     *
     * @param string $userId
     * @param string $newPassword
     * @return void
     */
    public function adminUpdatePassword(string $userId, string $newPassword): void
    {
        $path = '/auth/v1/admin/users/' . $userId;
        $response = $this->request('PUT', $path, $this->serviceHeaders(), [
            'password' => $newPassword
        ]);

        $this->assertSuccess($response, 'Failed to update user password');
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