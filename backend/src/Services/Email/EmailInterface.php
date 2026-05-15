<?php

declare(strict_types=1);

namespace RentEase\Services\Email;

interface EmailInterface
{
    /**
     * Send an email.
     *
     * @param string $to
     * @param string $subject
     * @param string $body
     * @param array<string, mixed> $options
     * @return bool
     */
    public function send(string $to, string $subject, string $body, array $options = []): bool;
}
