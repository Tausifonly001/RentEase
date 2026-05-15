<?php

declare(strict_types=1);

namespace RentEase\Support;

/**
 * Class MailTemplate
 * Handles email template rendering with variable substitution.
 */
class MailTemplate
{
    /**
     * Render a template with provided data.
     *
     * @param string $templatePath Absolute path to the template file
     * @param array<string, mixed> $data Data to inject into the template
     * @return string Rendered HTML
     * @throws \RuntimeException If template file is not found
     */
    public static function render(string $templatePath, array $data): string
    {
        if (!file_exists($templatePath)) {
            throw new \RuntimeException("Email template not found at: {$templatePath}");
        }

        $content = file_get_contents($templatePath);
        
        foreach ($data as $key => $value) {
            $content = str_replace('{{ ' . $key . ' }}', (string)$value, $content);
            $content = str_replace('{{' . $key . '}}', (string)$value, $content);
        }

        return $content;
    }

    /**
     * Get a default wrapper for simple emails.
     * 
     * @param string $title
     * @param string $content
     * @return string
     */
    public static function basic(string $title, string $content): string
    {
        return "
            <div style='font-family: sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 8px;'>
                <h2 style='color: #2d3748;'>{$title}</h2>
                <div style='color: #4a5568; line-height: 1.6;'>{$content}</div>
                <hr style='margin: 20px 0; border: 0; border-top: 1px solid #edf2f7;' />
                <p style='font-size: 12px; color: #a0aec0;'>This is an automated message from RentEase.</p>
            </div>
        ";
    }
}
