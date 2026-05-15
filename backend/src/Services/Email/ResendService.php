<?php

declare(strict_types=1);

namespace RentEase\Services\Email;

use Resend;

final class ResendService implements EmailInterface
{
    private ?string $apiKey;
    private string $fromEmail;

    public function __construct(array $config)
    {
        $this->apiKey = $config['resend_api_key'] ?? null;
        $this->fromEmail = (string)($config['resend_from_email'] ?? 'onboarding@resend.dev');
    }

    public function send(string $to, string $subject, string $body, array $options = []): bool
    {
        if (empty($this->apiKey)) {
            error_log("Resend Error: API Key is missing.");
            return false;
        }

        try {
            $client = Resend::client($this->apiKey);
            $client->emails->send([
                'from' => $this->fromEmail,
                'to' => [$to],
                'subject' => $subject,
                'html' => $body,
            ]);
            return true;
        } catch (\Throwable $e) {
            error_log("Resend Dispatch Error [To: {$to}]: " . $e->getMessage());
            return false;
        }
    }
}
