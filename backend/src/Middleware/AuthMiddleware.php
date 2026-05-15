<?php

declare(strict_types=1);

namespace RentEase\Middleware;

use RentEase\Services\AuthService;

final class AuthMiddleware
{
    /**
     * @param array<string, mixed> $config
     * @return array<string, mixed>
     */
    public static function requireUser(array $config): array
    {
        $token = (string) ($_COOKIE[$config['cookie_name']] ?? '');
        $authService = new AuthService($config);
        $user = $authService->validateToken($token);

        if ($user === null) {
            throw new \RuntimeException('Unauthorized');
        }

        return [
            'token' => $token,
            'user' => $user,
        ];
    }
}