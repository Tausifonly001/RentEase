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

    /**
     * Perform multiple HTTP requests concurrently.
     * 
     * @param array<string, array{method: string, url: string, headers?: array<string, string>, jsonBody?: array<string, mixed>|null}> $requests
     * @return array<string, array{status: int, body: array<string, mixed>|string}>
     */
    public function requestMulti(array $requests): array
    {
        $multiHandle = curl_multi_init();
        $curlHandles = [];
        $results = [];

        foreach ($requests as $key => $req) {
            $ch = curl_init($req['url']);
            $headers = $req['headers'] ?? [];
            $normalizedHeaders = [];
            foreach ($headers as $hKey => $hVal) {
                $normalizedHeaders[] = $hKey . ': ' . $hVal;
            }

            if (isset($req['jsonBody'])) {
                $normalizedHeaders[] = 'Content-Type: application/json';
            }

            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => strtoupper($req['method']),
                CURLOPT_HTTPHEADER => $normalizedHeaders,
                CURLOPT_TIMEOUT => 15,
                CURLOPT_CONNECTTIMEOUT => 5,
            ]);

            if (isset($req['jsonBody'])) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($req['jsonBody'], JSON_THROW_ON_ERROR));
            }

            curl_multi_add_handle($multiHandle, $ch);
            $curlHandles[$key] = $ch;
        }

        $active = null;
        do {
            $mrc = curl_multi_exec($multiHandle, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);

        while ($active && $mrc == CURLM_OK) {
            if (curl_multi_select($multiHandle) != -1) {
                do {
                    $mrc = curl_multi_exec($multiHandle, $active);
                } while ($mrc == CURLM_CALL_MULTI_PERFORM);
            }
        }

        foreach ($curlHandles as $key => $ch) {
            $rawBody = curl_multi_getcontent($ch);
            $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
            
            $decoded = json_decode((string)$rawBody, true);
            $body = is_array($decoded) ? $decoded : ['raw' => $rawBody];

            $results[$key] = [
                'status' => $status,
                'body' => $body,
            ];
            
            curl_multi_remove_handle($multiHandle, $ch);
            curl_close($ch);
        }

        curl_multi_close($multiHandle);

        return $results;
    }
}