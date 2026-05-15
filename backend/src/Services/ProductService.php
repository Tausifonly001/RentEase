<?php

declare(strict_types=1);

namespace RentEase\Services;

final class ProductService extends BaseSupabaseService
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function catalog(int $page = 1, int $perPage = 12, ?string $category = null): array
    {
        $page = max(1, $page);
        $perPage = min(50, max(1, $perPage));
        $offset = ($page - 1) * $perPage;
        $end = $offset + $perPage - 1;

        $path = '/rest/v1/products?select=id,name,category,monthly_price,total_stock,image_url&order=created_at.desc';
        $path .= '&limit=' . $perPage . '&offset=' . $offset;

        if ($category !== null && $category !== '') {
            $safeCategory = rawurlencode(trim($category));
            $path .= '&category=eq.' . $safeCategory;
        }

        $response = $this->request('GET', $path, $this->anonHeaders());
        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new \RuntimeException('Unable to load products');
        }

        return is_array($response['body']) ? $response['body'] : [];
    }

    /** @return array<string, mixed>|null */
    public function findById(int|string $id): ?array
    {
        if ($id < 1) {
            throw new \InvalidArgumentException('Invalid product_id');
        }

        $path = '/rest/v1/products?select=*&id=eq.' . $id . '&limit=1';
        $response = $this->request('GET', $path, $this->anonHeaders());

        if ($response['status'] < 200 || $response['status'] >= 300 || empty($response['body'][0])) {
            return null;
        }

        return $response['body'][0];
    }

    /**
     * Run from a scheduled job/CLI. Do not call on page load.
     * @return array<int, array<string, mixed>>
     */
    public function warmFakeStoreCache(bool $force = false): array
    {
        $cachePath = $this->cachePath();
        $cacheTtl = 60 * 30;

        if (!$force && file_exists($cachePath) && (time() - filemtime($cachePath)) < $cacheTtl) {
            $cached = json_decode((string) file_get_contents($cachePath), true);
            return is_array($cached) ? $cached : [];
        }

        $response = $this->http->request('GET', 'https://fakestoreapi.com/products');
        if ($response['status'] < 200 || $response['status'] >= 300 || !is_array($response['body'])) {
            throw new \RuntimeException('Failed to fetch FakeStoreAPI data');
        }

        if (!is_dir((string) $this->config['cache_dir'])) {
            mkdir((string) $this->config['cache_dir'], 0755, true);
        }

        file_put_contents($cachePath, json_encode($response['body'], JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));
        return $response['body'];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getCachedFakeStoreProducts(): array
    {
        $path = $this->cachePath();
        if (!file_exists($path)) {
            return [];
        }
        $decoded = json_decode((string) file_get_contents($path), true);
        return is_array($decoded) ? $decoded : [];
    }

    private function cachePath(): string
    {
        return (string) $this->config['cache_dir'] . '/fakestore_products.json';
    }
}