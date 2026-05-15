<?php

declare(strict_types=1);

namespace RentEase\Services\Email;

/**
 * Class EmailDriverFactory
 * Responsible for creating instances of email drivers.
 */
class EmailDriverFactory
{
    /**
     * Create a driver instance based on the provided type.
     *
     * @param string $driver 'resend' or 'phpmailer'
     * @param array<string, mixed> $config Configuration array
     * @return EmailInterface
     * @throws \InvalidArgumentException If driver type is unknown
     */
    public static function create(string $driver, array $config): EmailInterface
    {
        return match (strtolower($driver)) {
            'resend' => new ResendService($config),
            'phpmailer' => new PHPMailerService($config),
            default => throw new \InvalidArgumentException("Unknown email driver: {$driver}"),
        };
    }
}
