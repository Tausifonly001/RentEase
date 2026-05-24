<?php

declare(strict_types=1);

namespace RentEase\Middleware;

use RentEase\Services\AuthService;

/**
 * Enforces role-based access control (RBAC).
 */
final class RoleMiddleware
{
    /**
     * @param array<string, mixed> $config
     */
    public static function requireRole(string $requiredRole, array $config): void
    {
        $token = (string) ($_COOKIE[$config['cookie_name']] ?? '');
        $authService = new AuthService($config);
        $user = $authService->validateToken($token);

        if ($user === null) {
            header('Location: ' . baseUrl('/login'));
            exit;
        }

        $role = AuthService::resolveRole($user);

        if ($role !== $requiredRole) {
            http_response_code(403);
            echo '403 Forbidden - You do not have permission to access this resource.';
            exit;
        }
    }

    /**
     * @param array<string> $allowedRoles
     * @param array<string, mixed> $config
     */
    public static function requireAnyRole(array $allowedRoles, array $config, string $redirectPath = '/dashboard'): void
    {
        $token = (string) ($_COOKIE[$config['cookie_name']] ?? '');
        $authService = new AuthService($config);
        $user = $authService->validateToken($token);

        if ($user === null) {
            header('Location: ' . baseUrl('/login'));
            exit;
        }

        $role = AuthService::resolveRole($user);

        if (!in_array($role, $allowedRoles, true)) {
            header('Location: ' . baseUrl($redirectPath));
            exit;
        }
    }
}
