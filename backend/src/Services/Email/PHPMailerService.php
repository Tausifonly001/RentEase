<?php

declare(strict_types=1);

namespace RentEase\Services\Email;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

final class PHPMailerService implements EmailInterface
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function send(string $to, string $subject, string $body, array $options = []): bool
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = (string)($this->config['smtp_host'] ?? 'localhost');
            $mail->SMTPAuth   = true;
            $mail->Username   = (string)($this->config['smtp_user'] ?? '');
            $mail->Password   = (string)($this->config['smtp_pass'] ?? '');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = (int)($this->config['smtp_port'] ?? 587);
            
            // Timeout settings
            $mail->Timeout = 10;

            // Recipients
            $mail->setFrom((string)($this->config['smtp_user'] ?? ''), 'RentEase Admin');
            $mail->addAddress($to);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("PHPMailer Dispatch Error [To: {$to}]: {$mail->ErrorInfo}");
            return false;
        }
    }
}
