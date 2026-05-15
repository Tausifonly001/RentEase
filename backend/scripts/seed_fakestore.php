<?php
declare(strict_types=1);

require __DIR__ . '/../bootstrap.php';

use RentEase\Support\HttpClient;

$http = new HttpClient();
echo "Fetching data from FakeStoreAPI...\n";

try {
    $response = $http->request('GET', 'https://fakestoreapi.com/products');
    if ($response['status'] < 200 || $response['status'] >= 300 || !is_array($response['body'])) {
        throw new RuntimeException('Failed to fetch FakeStoreAPI data');
    }

    $rawProducts = $response['body'];
    $toSeed = [];

    foreach ($rawProducts as $item) {
        $cat = (string) ($item['category'] ?? '');
        if ($cat === 'electronics') {
            $toSeed[] = [
                'name' => (string) $item['title'],
                'category' => 'Appliances',
                'monthly_price' => round((float) $item['price'] * 0.1, 2) ?: 19.0, // 10% of price as monthly
                'total_stock' => 12,
                'image_url' => (string) $item['image'],
                'description' => (string) $item['description'],
            ];
        }
    }

    // Since we also need high-quality Furniture, let's include some curated mock items
    $toSeed[] = [
        'name' => 'Minimalist Scandinavian Sofa',
        'category' => 'Furniture',
        'monthly_price' => 59.0,
        'total_stock' => 10,
        'image_url' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=800&q=80',
        'description' => 'Cozy scandinavian oak sofa with fabric cushions. Minimalist styling, high quality material.',
    ];
    $toSeed[] = [
        'name' => 'Oak Wood Study Desk',
        'category' => 'Furniture',
        'monthly_price' => 29.0,
        'total_stock' => 15,
        'image_url' => 'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?auto=format&fit=crop&w=800&q=80',
        'description' => 'Perfect minimalist desk for home office. Features real oak wood and iron metal frame.',
    ];
    $toSeed[] = [
        'name' => 'Ergonomic Task Chair',
        'category' => 'Furniture',
        'monthly_price' => 24.0,
        'total_stock' => 25,
        'image_url' => 'https://images.unsplash.com/photo-1505797149-43b0069ec26b?auto=format&fit=crop&w=800&q=80',
        'description' => 'Modern task chair with lumbar support. Mesh backing and height adjustable.',
    ];
    $toSeed[] = [
        'name' => 'Rustic Coffee Table',
        'category' => 'Furniture',
        'monthly_price' => 19.0,
        'total_stock' => 8,
        'image_url' => 'https://images.unsplash.com/photo-1538694014760-577cb7ebf1d6?auto=format&fit=crop&w=800&q=80',
        'description' => 'Teak coffee table with metal legs. Beautiful rustic grain that adds a homely touch.',
    ];

    echo "Fetching existing products from local DB...\n";
    $anonHeaders = [
        'apikey' => (string) $config['supabase_anon_key'],
        'Accept' => 'application/json',
    ];

    $dbResponse = $http->request('GET', $config['supabase_url'] . '/rest/v1/products?select=name', $anonHeaders);
    $existingNames = [];
    if ($dbResponse['status'] >= 200 && $dbResponse['status'] < 300 && is_array($dbResponse['body'])) {
        foreach ($dbResponse['body'] as $row) {
            $existingNames[] = strtolower(trim((string)($row['name'] ?? '')));
        }
    }

    $serviceHeaders = [
        'apikey' => (string) $config['supabase_service_role_key'],
        'Authorization' => 'Bearer ' . $config['supabase_service_role_key'],
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
        'Prefer' => 'return=minimal'
    ];

    $added = 0;
    foreach ($toSeed as $product) {
        if (in_array(strtolower(trim($product['name'])), $existingNames, true)) {
            continue;
        }

        $res = $http->request('POST', $config['supabase_url'] . '/rest/v1/products', $serviceHeaders, $product);
        if ($res['status'] >= 200 && $res['status'] < 300) {
            $added++;
        } else {
            echo "Failed to seed " . $product['name'] . ": Status " . $res['status'] . "\n";
        }
    }

    echo "Successfully seeded {$added} new products into Supabase!\n";

} catch (Throwable $e) {
    echo "Seeding failed: " . $e->getMessage() . "\n";
}
