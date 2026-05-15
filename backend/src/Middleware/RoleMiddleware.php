<?php

declare(strict_types=1);

namespace RentEase\Middleware;

use RentEase\Services\AuthService;

/**
 * Class RoleMiddleware
 *
 * Enforces role-based access control (RBAC).
 */
class RoleMiddleware
{
    /**
     * Check if the user has a specific role.
     * Redirects to the homepage if unauthorized.
     *
     * @param string $requiredRole The required role ('admin', 'vendor', etc.)
     * @param array<string, mixed> $config The application config
     */
    public static function requireRole(string $requiredRole, array $config): void
    {
        $token = (string) ($_COOKIE[$config['cookie_name']] ?? '');
        $authService = new AuthService($config);
        $user = $authService->validateToken($token);

        if ($user === null) {
            $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
            header("Location: $base/login");
            exit;
        }

        $role = $user['role'] ?? 'user';

        if ($role !== $requiredRole) {
            http_response_code(403);
            echo "403 Forbidden - You do not have permission to access this resource.";
            exit;
        }
    }
}
