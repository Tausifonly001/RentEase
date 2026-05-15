<?php

declare(strict_types=1);

namespace RentEase\Services;

use RentEase\Support\HttpClient;

final class NotificationService extends BaseSupabaseService
{
    private string $appId;
    private string $apiKey;

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config, ?HttpClient $http = null)
    {
        parent::__construct($config, $http);
        $this->appId = (string)($config['onesignal_app_id'] ?? '');
        $this->apiKey = (string)($config['onesignal_rest_api_key'] ?? '');
    }

    /**
     * Send a push notification to specific users.
     *
     * @param array<string> $externalUserIds
     * @param string $heading
     * @param string $content
     * @param string|null $url
     * @return array<string, mixed>
     */
    public function sendPush(array $externalUserIds, string $heading, string $content, ?string $url = null): array
    {
        $payload = [
            'app_id' => $this->appId,
            'include_external_user_ids' => $externalUserIds,
            'headings' => ['en' => $heading],
            'contents' => ['en' => $content],
        ];

        if ($url) {
            $payload['url'] = $url;
        }

        $headers = [
            'Content-Type' => 'application/json; charset=utf-8',
            'Authorization' => 'Basic ' . $this->apiKey,
        ];

        return $this->http->request('POST', 'https://onesignal.com/api/v1/notifications', $headers, $payload);
    }

    /**
     * Send a push notification to all users.
     *
     * @param string $heading
     * @param string $content
     * @return array<string, mixed>
     */
    public function broadcastPush(string $heading, string $content): array
    {
        $payload = [
            'app_id' => $this->appId,
            'included_segments' => ['All'],
            'headings' => ['en' => $heading],
            'contents' => ['en' => $content],
        ];

        $headers = [
            'Content-Type' => 'application/json; charset=utf-8',
            'Authorization' => 'Basic ' . $this->apiKey,
        ];

        return $this->http->request('POST', 'https://onesignal.com/api/v1/notifications', $headers, $payload);
    }
}
