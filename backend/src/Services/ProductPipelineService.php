<?php

declare(strict_types=1);

namespace RentEase\Services;

use RentEase\Support\HttpClient;

final class ProductPipelineService
{
    private HttpClient $http;
    private array $config;
    private static array $inMemoryCache = [];

    public function __construct(array $config, ?HttpClient $http = null)
    {
        $this->config = $config;
        $this->http = $http ?? new HttpClient();
    }

    /**
     * Attempts to fetch and normalize from Fake Store first. 
     * Fallbacks to DummyJSON if Fake Store fails or category data is insufficient.
     * Enhances with Unsplash image where possible.
     *
     * @param string|null $category
     * @return array<int, array<string, mixed>>
     */
    public function getUnifiedProducts(?string $category = null): array
    {
        $products = [];
        $useFallback = false;

        try {
            $products = $this->fetchFakeStoreProducts();

            // Filter by category if requested
            if ($category !== null && $category !== '') {
                $categoryLower = strtolower(trim($category));
                $products = array_filter($products, static function (array $p) use ($categoryLower): bool {
                    return strtolower($p['category']) === $categoryLower;
                });
            }

            // Fallback condition: API fails (returns empty) OR category data is insufficient (less than 2 products)
            if (empty($products) || count($products) < 2) {
                $useFallback = true;
            }
        } catch (\Throwable $e) {
            $useFallback = true;
        }

        if ($useFallback) {
            try {
                $products = $this->fetchDummyJsonProducts();

                if ($category !== null && $category !== '') {
                    $categoryLower = strtolower(trim($category));
                    $products = array_filter($products, static function (array $p) use ($categoryLower): bool {
                        return strpos(strtolower($p['category']), $categoryLower) !== false;
                    });
                }
            } catch (\Throwable $e) {
                // If DummyJSON also fails, return empty array (fallback empty state)
                return [];
            }
        }

        // Apply Unsplash Image Enhancement Layer
        $enhancedProducts = [];
        foreach ($products as $p) {
            $enhancedProducts[] = $this->enhanceWithUnsplash($p);
        }

        return array_values($enhancedProducts);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function fetchFakeStoreProducts(): array
    {
        return $this->fetchAndCache(
            'fakestore',
            'https://fakestoreapi.com/products',
            function (array $data): array {
                $normalized = [];
                foreach ($data as $item) {
                    if (!isset($item['id'])) {
                        continue;
                    }
                    $normalized[] = [
                        'id' => (int) $item['id'],
                        'name' => trim(htmlspecialchars((string) ($item['title'] ?? ''))),
                        'category' => trim(htmlspecialchars((string) ($item['category'] ?? ''))),
                        'price' => (float) ($item['price'] ?? 0),
                        'image' => (string) ($item['image'] ?? ''),
                        'source' => 'fakestore',
                    ];
                }
                return $normalized;
            }
        );
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function fetchDummyJsonProducts(): array
    {
        return $this->fetchAndCache(
            'dummyjson',
            'https://dummyjson.com/products?limit=100',
            function (array $data): array {
                $normalized = [];
                $products = $data['products'] ?? [];
                foreach ($products as $item) {
                    if (!isset($item['id'])) {
                        continue;
                    }
                    $normalized[] = [
                        'id' => (int) $item['id'],
                        'name' => trim(htmlspecialchars((string) ($item['title'] ?? ''))),
                        'category' => trim(htmlspecialchars((string) ($item['category'] ?? ''))),
                        'price' => (float) ($item['price'] ?? 0),
                        'image' => (string) ($item['thumbnail'] ?? ''),
                        'source' => 'dummyjson',
                    ];
                }
                return $normalized;
            }
        );
    }

    /**
     * Enhances product with a high-quality Unsplash image.
     *
     * @param array<string, mixed> $product
     * @return array<string, mixed>
     */
    public function enhanceWithUnsplash(array $product): array
    {
        $accessKey = getenv('UNSPLASH_ACCESS_KEY') ?: ($this->config['unsplash_access_key'] ?? '');
        if ($accessKey === '') {
            return $product;
        }

        // Generate query from product name and category
        $nameWords = array_slice(explode(' ', $product['name']), 0, 3);
        $query = trim(implode(' ', $nameWords));
        if (empty($query)) {
            $query = $product['category'];
        }

        $cacheKey = 'unsplash_' . md5(strtolower($query));
        $cachedUnsplash = $this->getCachedFile($cacheKey, 86400); // 24-hour cache for Unsplash images
        
        $imageResponse = null;

        if ($cachedUnsplash !== null) {
            $imageResponse = $cachedUnsplash;
        } else {
            try {
                $url = 'https://api.unsplash.com/search/photos?query=' . urlencode($query) . '&per_page=1';
                $response = $this->requestWithRetry('GET', $url, [
                    'Authorization' => 'Client-ID ' . $accessKey,
                ]);

                if ($response['status'] >= 200 && $response['status'] < 300) {
                    $body = $response['body'];
                    if (is_array($body) && !empty($body['results'][0])) {
                        $imageResponse = $body['results'][0];
                        $this->setCachedFile($cacheKey, $imageResponse);
                    }
                }
            } catch (\Throwable $e) {
                // Return original image if Unsplash fails
                return $product;
            }
        }

        if ($imageResponse !== null && isset($imageResponse['width'], $imageResponse['height'], $imageResponse['urls']['regular'])) {
            $w = (int) $imageResponse['width'];
            $h = (int) $imageResponse['height'];
            $aspectRatio = $w / max(1, $h);

            // Replace image ONLY if resolution is higher (e.g., width * height > 400x400) and aspect ratio is suitable (0.6 to 1.8)
            if (($w * $h) > (400 * 400) && $aspectRatio >= 0.6 && $aspectRatio <= 1.8) {
                $product['image'] = (string) $imageResponse['urls']['regular'];
            }
        }

        return $product;
    }

    /**
     * Executes HTTP requests with 1 retry on network error or rate limit (429).
     *
     * @param string $method
     * @param string $url
     * @param array<string, string> $headers
     * @return array<string, mixed>
     */
    private function requestWithRetry(string $method, string $url, array $headers = []): array
    {
        $attempts = 2;
        $response = null;

        for ($i = 0; $i < $attempts; $i++) {
            try {
                $response = $this->http->request($method, $url, $headers);
                // Return if success OR not rate-limited (anything other than 429)
                if ($response['status'] !== 429 && $response['status'] >= 200 && $response['status'] < 300) {
                    return $response;
                }
            } catch (\Throwable $e) {
                if ($i === $attempts - 1) {
                    throw $e;
                }
            }
            // Basic delay before retry attempt
            usleep(250000);
        }

        return $response ?: ['status' => 500, 'body' => []];
    }

    /**
     * Handles in-memory and file-based caching to prevent duplicate API requests.
     */
    private function fetchAndCache(string $key, string $url, callable $normalizer): array
    {
        // 1. In-memory caching
        if (isset(self::$inMemoryCache[$key])) {
            return self::$inMemoryCache[$key];
        }

        // 2. File-based caching (3600 second TTL = 1 hour)
        $cached = $this->getCachedFile($key, 3600);
        if ($cached !== null && is_array($cached)) {
            self::$inMemoryCache[$key] = $cached;
            return $cached;
        }

        // 3. Perform network call
        $response = $this->requestWithRetry('GET', $url);

        if ($response['status'] < 200 || $response['status'] >= 300 || !is_array($response['body'])) {
            throw new \RuntimeException("Unable to fetch from source: " . $key);
        }

        $normalized = $normalizer($response['body']);
        $this->setCachedFile($key, $normalized);

        self::$inMemoryCache[$key] = $normalized;
        return $normalized;
    }

    private function getCachedFile(string $key, int $ttl): ?array
    {
        $cacheDir = $this->config['cache_dir'] ?? __DIR__ . '/../../storage/cache';
        $file = $cacheDir . '/' . $key . '.json';

        if (file_exists($file) && (time() - filemtime($file)) < $ttl) {
            $contents = file_get_contents($file);
            if ($contents !== false) {
                return json_decode($contents, true);
            }
        }

        return null;
    }

    private function setCachedFile(string $key, array $data): void
    {
        $cacheDir = $this->config['cache_dir'] ?? __DIR__ . '/../../storage/cache';
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }

        $file = $cacheDir . '/' . $key . '.json';
        file_put_contents($file, json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));
    }
}
