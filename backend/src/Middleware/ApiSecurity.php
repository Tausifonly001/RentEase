<?php

declare(strict_types=1);

namespace RentEase\Middleware;

/**
 * Class ApiSecurity
 *
 * Provides CORS and rate-limiting enforcement for JSON API endpoints.
 * Usage: Call ApiSecurity::enforce($config) at the top of every /api/*.php file.
 */
final class ApiSecurity
{
    /**
     * Enforce CORS headers and basic rate limiting on API endpoints.
     *
     * @param array<string, mixed> $config The application config
     * @param bool $requireAuth Whether the endpoint requires authentication
     */
    public static function enforce(array $config, bool $requireAuth = false): void
    {
        // ---------------------------------------------------------------
        // CORS: Restrict to configured origin (default: same-origin only)
        // ---------------------------------------------------------------
        $appUrl = $config['app_url'] ?? '';
        $parsedUrl = parse_url($appUrl);
        $allowedOrigin = '';
        if ($parsedUrl && isset($parsedUrl['scheme'], $parsedUrl['host'])) {
            $allowedOrigin = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
            if (isset($parsedUrl['port'])) {
                $allowedOrigin .= ':' . $parsedUrl['port'];
            }
        }

        $requestOrigin = $_SERVER['HTTP_ORIGIN'] ?? '';

        if ($requestOrigin !== '' && $allowedOrigin !== '' && $requestOrigin !== $allowedOrigin) {
            http_response_code(403);
            echo json_encode(['error' => 'Origin not allowed: ' . $requestOrigin . ' vs ' . $allowedOrigin]);
            exit;
        }

        header('Access-Control-Allow-Origin: ' . ($allowedOrigin ?: 'null'));
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-CSRF-Token');
        header('Access-Control-Max-Age: 86400');

        // Handle preflight
        if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
            http_response_code(204);
            exit;
        }

        // ---------------------------------------------------------------
        // Rate Limiting: Simple sliding window per IP (file-based)
        // For production, use Redis/Memcached or a dedicated service.
        // ---------------------------------------------------------------
        $clientIp = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $rateLimitKey = 'api_rate_' . md5($clientIp);
        $maxRequests = 60;   // max requests per window
        $windowSeconds = 60; // sliding window in seconds
        $now = time();

        $cacheDir = sys_get_temp_dir() . '/rentease_ratelimit';
        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0777, true);
        }
        $cacheFile = $cacheDir . '/' . $rateLimitKey . '.json';

        $rateData = ['count' => 0, 'window_start' => $now];
        if (file_exists($cacheFile)) {
            $data = json_decode(file_get_contents($cacheFile) ?: '', true);
            if (is_array($data) && isset($data['count'], $data['window_start'])) {
                $rateData = $data;
            }
        }

        if (($now - $rateData['window_start']) >= $windowSeconds) {
            $rateData = ['count' => 0, 'window_start' => $now];
        }

        $rateData['count']++;
        file_put_contents($cacheFile, json_encode($rateData), LOCK_EX);

        if ($rateData['count'] > $maxRequests) {
            http_response_code(429);
            header('Retry-After: ' . ($windowSeconds - ($now - $rateData['window_start'])));
            echo json_encode(['error' => 'Too many requests. Please slow down.']);
            exit;
        }
    }
}
