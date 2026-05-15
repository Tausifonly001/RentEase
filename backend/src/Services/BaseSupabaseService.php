<?php

declare(strict_types=1);

namespace RentEase\Services;

use RentEase\Support\HttpClient;

abstract class BaseSupabaseService
{
    protected HttpClient $http;

    /** @var array<string, mixed> */
    protected array $config;

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config, ?HttpClient $http = null)
    {
        $this->config = $config;
        $this->http = $http ?? new HttpClient();
    }

    /**
     * @param array<string, string> $headers
     * @param array<string, mixed>|null $body
     * @return array<string, mixed>
     */
    protected function request(string $method, string $path, array $headers = [], ?array $body = null): array
    {
        $url = $this->config['supabase_url'] . $path;
        return $this->http->request($method, $url, $headers, $body);
    }

    /** @return array<string, string> */
    protected function anonHeaders(): array
    {
        return [
            'apikey' => (string) $this->config['supabase_anon_key'],
            'Accept' => 'application/json',
        ];
    }

    /** @return array<string, string> */
    protected function userHeaders(string $jwt): array
    {
        return [
            'apikey' => (string) $this->config['supabase_anon_key'],
            'Authorization' => 'Bearer ' . $jwt,
            'Accept' => 'application/json',
        ];
    }

    /** @return array<string, string> */
    protected function serviceHeaders(): array
    {
        return [
            'apikey' => (string) $this->config['supabase_service_role_key'],
            'Authorization' => 'Bearer ' . $this->config['supabase_service_role_key'],
            'Accept' => 'application/json',
        ];
    }
}