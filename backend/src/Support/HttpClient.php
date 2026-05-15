<?php

declare(strict_types=1);

namespace RentEase\Support;

final class HttpClient
{
    /**
     * @param array<string, string> $headers
     * @param array<string, mixed>|null $jsonBody
     * @return array<string, mixed>
     */
    public function request(string $method, string $url, array $headers = [], ?array $jsonBody = null): array
    {
        $ch = curl_init($url);

        if ($ch === false) {
            throw new \RuntimeException('Unable to initialize HTTP client');
        }

        $normalizedHeaders = [];
        foreach ($headers as $key => $value) {
            $normalizedHeaders[] = $key . ': ' . $value;
        }

        if ($jsonBody !== null) {
            $normalizedHeaders[] = 'Content-Type: application/json';
        }

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_HTTPHEADER => $normalizedHeaders,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_CONNECTTIMEOUT => 5,
        ]);

        if ($jsonBody !== null) {
            $encoded = json_encode($jsonBody, JSON_THROW_ON_ERROR);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);
        }

        $rawBody = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

        if ($rawBody === false) {
            $err = curl_error($ch);
            curl_close($ch);
            throw new \RuntimeException('HTTP request failed: ' . $err);
        }

        curl_close($ch);

        $decoded = json_decode($rawBody, true);
        $body = is_array($decoded) ? $decoded : ['raw' => $rawBody];

        return [
            'status' => $status,
            'body' => $body,
        ];
    }
}