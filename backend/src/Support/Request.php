<?php

declare(strict_types=1);

namespace RentEase\Support;

/**
 * Class Request
 *
 * Provides a secure, object-oriented way to access superglobals.
 * Implements a "Sanity Check" layer for all input data.
 */
class Request
{
    /**
     * Get a sanitized value from $_POST
     *
     * @param string $key The POST key
     * @param mixed $default The default value if the key does not exist
     * @return mixed
     */
    public static function post(string $key, mixed $default = null): mixed
    {
        if (!isset($_POST[$key])) {
            return $default;
        }

        return self::sanitize($_POST[$key]);
    }

    /**
     * Get a sanitized value from $_GET
     *
     * @param string $key The GET key
     * @param mixed $default The default value if the key does not exist
     * @return mixed
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        if (!isset($_GET[$key])) {
            return $default;
        }

        return self::sanitize($_GET[$key]);
    }

    /**
     * Sanitize input data.
     *
     * NOTE: Only trims whitespace. HTML encoding (htmlspecialchars) must be
     * applied at **render time**, not at input time, to avoid double-encoding
     * when data is persisted to the database and later displayed.
     *
     * @param mixed $data The data to sanitize
     * @return mixed
     */
    private static function sanitize(mixed $data): mixed
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::sanitize($value);
            }
            return $data;
        }

        if (is_string($data)) {
            return trim($data);
        }

        return $data;
    }
}
