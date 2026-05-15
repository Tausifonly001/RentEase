<?php

declare(strict_types=1);

namespace RentEase\Services;

use RentEase\Support\HttpClient;

final class FurnitureApplianceService
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
     * Executes the API pipeline. Fetches from DummyJSON first, falls back to Fake Store if
     * filtered items < 10 or DummyJSON fails. Applies high-res Unsplash image enhancement.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getFilteredProducts(): array
    {
        $products = [];
        $useFallback = false;

        try {
            $dummyJsonData = $this->fetchDummyJsonProducts();
            $products = $this->applyStrictFiltering($dummyJsonData);

            if (count($products) < 10) {
                $useFallback = true;
            }
        } catch (\Throwable $e) {
            $useFallback = true;
        }

        if ($useFallback) {
            try {
                $fakeStoreData = $this->fetchFakeStoreProducts();
                $fakeStoreFiltered = $this->applyStrictFiltering($fakeStoreData);

                // Combine or replace fallback
                $products = array_merge($products, $fakeStoreFiltered);
            } catch (\Throwable $e) {
                // Return whatever we already have if fallback fails
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
    public function fetchDummyJsonProducts(): array
    {
        return $this->fetchAndCache(
            'dummyjson_full',
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
     * @return array<int, array<string, mixed>>
     */
    public function fetchFakeStoreProducts(): array
    {
        return $this->fetchAndCache(
            'fakestore_full',
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
     * Applies precise strict filtering and category inference rules.
     *
     * @param array<int, array<string, mixed>> $products
     * @return array<int, array<string, mixed>>
     */
    private function applyStrictFiltering(array $products): array
    {
        $allowed = ['furniture', 'home-decoration', 'lighting', 'appliances', 'kitchen'];
        $excluded = ['beauty', 'fragrances', 'skincare', 'skin-care', 'groceries'];

        $filtered = [];

        foreach ($products as $p) {
            $cat = strtolower(trim($p['category']));
            $title = strtolower(trim($p['name']));

            // Exclusion Rules
            $isExcluded = false;
            foreach ($excluded as $ex) {
                if (strpos($cat, $ex) !== false) {
                    $isExcluded = true;
                    break;
                }
            }
            if ($isExcluded) {
                continue;
            }

            $isAllowed = false;

            // Check direct category field match
            if ($cat !== '') {
                foreach ($allowed as $al) {
                    if (strpos($cat, $al) !== false) {
                        $isAllowed = true;
                        break;
                    }
                }
            }

            // Keyword title matcher for inference
            if (!$isAllowed || $cat === '') {
                $inferenceKeywords = [
                    'sofa', 'chair', 'table', 'desk', 'bed', 'couch', 'ottoman', 'cabinet', 'stool', 'wardrobe', 'bookshelf',
                    'lamp', 'light', 'bulb', 'decor', 'mirror', 'frame',
                    'fridge', 'refrigerator', 'washing machine', 'appliance', 'microwave', 'oven', 'stove', 'toaster', 'blender', 'cooker', 'freezer'
                ];
                foreach ($inferenceKeywords as $kw) {
                    if (strpos($title, $kw) !== false) {
                        $isAllowed = true;
                        // Assign the inferred category for unified schema consistency
                        if ($cat === '') {
                            if (in_array($kw, ['fridge', 'refrigerator', 'washing machine', 'appliance', 'microwave', 'oven', 'stove', 'toaster', 'blender', 'cooker', 'freezer'])) {
                                $p['category'] = 'appliances';
                            } else if (in_array($kw, ['lamp', 'light', 'bulb', 'decor', 'mirror', 'frame'])) {
                                $p['category'] = 'home-decoration';
                            } else {
                                $p['category'] = 'furniture';
                            }
                        }
                        break;
                    }
                }
            }

            if ($isAllowed) {
                $filtered[] = $p;
            }
        }

        return $filtered;
    }

    /**
     * Enhances image via Unsplash API based on the product type.
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

        // Determine if it's an appliance or furniture to build optimal search query
        $isAppliance = strpos(strtolower($product['category']), 'appliance') !== false ||
                       strpos(strtolower($product['category']), 'kitchen') !== false;
        $allowedTerm = $isAppliance ? 'appliance' : 'furniture';

        $nameWords = array_slice(explode(' ', $product['name']), 0, 2);
        $query = trim(implode(' ', $nameWords)) . ' ' . $allowedTerm;

        $cacheKey = 'unsplash_v2_' . md5(strtolower($query));
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
                return $product;
            }
        }

        if ($imageResponse !== null && isset($imageResponse['width'], $imageResponse['height'], $imageResponse['urls']['regular'])) {
            $w = (int) $imageResponse['width'];
            $h = (int) $imageResponse['height'];
            $aspectRatio = $w / max(1, $h);

            // Replace image ONLY if width >= 800px and aspect ratio is square or 4:3 (between 0.7 and 1.5)
            if ($w >= 800 && $aspectRatio >= 0.7 && $aspectRatio <= 1.5) {
                $product['image'] = (string) $imageResponse['urls']['regular'];
            }
        }

        return $product;
    }

    private function requestWithRetry(string $method, string $url, array $headers = []): array
    {
        $attempts = 2;
        $response = null;

        for ($i = 0; $i < $attempts; $i++) {
            try {
                $response = $this->http->request($method, $url, $headers);
                if ($response['status'] !== 429 && $response['status'] >= 200 && $response['status'] < 300) {
                    return $response;
                }
            } catch (\Throwable $e) {
                if ($i === $attempts - 1) {
                    throw $e;
                }
            }
            usleep(250000);
        }

        return $response ?: ['status' => 500, 'body' => []];
    }

    private function fetchAndCache(string $key, string $url, callable $normalizer): array
    {
        if (isset(self::$inMemoryCache[$key])) {
            return self::$inMemoryCache[$key];
        }

        $cached = $this->getCachedFile($key, 3600);
        if ($cached !== null && is_array($cached)) {
            self::$inMemoryCache[$key] = $cached;
            return $cached;
        }

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
