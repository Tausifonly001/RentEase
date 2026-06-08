<?php

declare(strict_types=1);

namespace RentEase\Services;

use RentEase\Services\Email\EmailDriverFactory;
use RentEase\Services\Email\EmailInterface;

/**
 * Class MailService
 * Provides a unified API for sending different types of emails via specialized drivers.
 */
class MailService
{
    private array $config;
    private ?EmailInterface $authDriver = null;
    private ?EmailInterface $adminDriver = null;

    /**
     * MailService constructor.
     *
     * @param array<string, mixed> $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Send an authentication-related transactional email (via Resend).
     *
     * @param string $to
     * @param string $subject
     * @param string $body
     * @return bool
     */
    public function sendAuth(string $to, string $subject, string $body): bool
    {
        if ($this->authDriver === null) {
            $this->authDriver = EmailDriverFactory::create('resend', $this->config);
        }
        return $this->authDriver->send($to, $subject, $body);
    }

    /**
     * Send an operational/admin email (via PHPMailer).
     *
     * @param string $to
     * @param string $subject
     * @param string $body
     * @return bool
     */
    public function sendAdmin(string $to, string $subject, string $body): bool
    {
        if ($this->adminDriver === null) {
            $this->adminDriver = EmailDriverFactory::create('phpmailer', $this->config);
        }
        return $this->adminDriver->send($to, $subject, $body);
    }

    /**
     * Generic send method for flexibility.
     *
     * @param string $driver
     * @param string $to
     * @param string $subject
     * @param string $body
     * @return bool
     */
    public function send(string $driver, string $to, string $subject, string $body): bool
    {
        $instance = EmailDriverFactory::create($driver, $this->config);
        return $instance->send($to, $subject, $body);
    }
}
