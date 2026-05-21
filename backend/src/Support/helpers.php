<?php
declare(strict_types=1);

if (!function_exists('e')) {
    /**
     * Escape HTML entities in a string.
     */
    function e(mixed $value): string
    {
        return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('baseUrl')) {
    /**
     * Get the base URL of the application.
     */
    function baseUrl(string $path = ''): string
    {
        $base = dirname($_SERVER['SCRIPT_NAME']);
        // Handle root cases and normalize slashes
        $base = str_replace('\\', '/', $base);
        if ($base === '/') {
            $base = '';
        }
        return rtrim($base, '/') . '/' . ltrim($path, '/');
    }
}
