<?php

declare(strict_types=1);

require __DIR__ . '/../bootstrap.php';

use RentEase\Support\HttpClient;

$http = new HttpClient();
$supabaseUrl = rtrim((string)$config['supabase_url'], '/');
$serviceKey = (string)$config['supabase_service_role_key'];

if (empty($supabaseUrl) || empty($serviceKey)) {
    echo "Error: SUPABASE_URL or SUPABASE_SERVICE_ROLE_KEY not set.\n";
    exit(1);
}

$headers = [
    'apikey' => $serviceKey,
    'Authorization' => 'Bearer ' . $serviceKey,
    'Accept' => 'application/json',
    'Content-Type' => 'application/json',
    'Prefer' => 'return=representation'
];

// Check if products exist
$response = $http->request('GET', $supabaseUrl . '/rest/v1/products?select=id&limit=1', $headers);
if ($response['status'] === 200 && is_array($response['body']) && count($response['body']) > 0) {
    echo "Products already exist. Skipping seed.\n";
    exit(0);
}

// Seed data
$products = [
    [
        'name' => 'Premium Modern Sofa',
        'category' => 'Furniture',
        'monthly_price' => 120.00,
        'total_stock' => 5,
        'image_url' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=800&q=80',
        'description' => 'A luxurious modern sofa perfect for any contemporary living room. Upholstered in premium fabric.'
    ],
    [
        'name' => 'Minimalist Dining Table',
        'category' => 'Furniture',
        'monthly_price' => 85.00,
        'total_stock' => 3,
        'image_url' => 'https://images.unsplash.com/photo-1604578762246-41134e37f9cc?auto=format&fit=crop&w=800&q=80',
        'description' => 'Solid oak dining table that seats six comfortably. Simple, elegant, and sturdy.'
    ],
    [
        'name' => 'Ergonomic Office Chair',
        'category' => 'Furniture',
        'monthly_price' => 45.00,
        'total_stock' => 10,
        'image_url' => 'https://images.unsplash.com/photo-1505843490538-5133c6c7d0e1?auto=format&fit=crop&w=800&q=80',
        'description' => 'Fully adjustable ergonomic chair designed for long hours of comfortable remote work.'
    ],
    [
        'name' => 'Stainless Steel Refrigerator',
        'category' => 'Appliances',
        'monthly_price' => 150.00,
        'total_stock' => 4,
        'image_url' => 'https://images.unsplash.com/photo-1584568694244-14fbdf83bd30?auto=format&fit=crop&w=800&q=80',
        'description' => 'Energy-efficient French door refrigerator with ice maker and smart temperature control.'
    ],
    [
        'name' => 'Front-Load Washer',
        'category' => 'Appliances',
        'monthly_price' => 95.00,
        'total_stock' => 6,
        'image_url' => 'https://images.unsplash.com/photo-1626806787461-102c1bfaaea1?auto=format&fit=crop&w=800&q=80',
        'description' => 'High-capacity front-load washing machine with multiple wash cycles and steam cleaning.'
    ],
    [
        'name' => 'Smart Microwave Oven',
        'category' => 'Appliances',
        'monthly_price' => 30.00,
        'total_stock' => 8,
        'image_url' => 'https://images.unsplash.com/photo-1585223146429-07fbf9d332d7?auto=format&fit=crop&w=800&q=80',
        'description' => '1000W smart microwave with built-in sensor cooking and Wi-Fi connectivity.'
    ],
    [
        'name' => 'King Size Bed Frame',
        'category' => 'Furniture',
        'monthly_price' => 110.00,
        'total_stock' => 2,
        'image_url' => 'https://images.unsplash.com/photo-1505693314120-0d443867891c?auto=format&fit=crop&w=800&q=80',
        'description' => 'Sturdy wooden king size bed frame with a sleek, minimalist headboard.'
    ],
    [
        'name' => 'Cordless Vacuum Cleaner',
        'category' => 'Appliances',
        'monthly_price' => 40.00,
        'total_stock' => 7,
        'image_url' => 'https://images.unsplash.com/photo-1558317374-067fb5f30001?auto=format&fit=crop&w=800&q=80',
        'description' => 'Lightweight, powerful cordless vacuum cleaner with HEPA filtration and long battery life.'
    ]
];

$insertResponse = $http->request('POST', $supabaseUrl . '/rest/v1/products', $headers, $products);

if ($insertResponse['status'] >= 200 && $insertResponse['status'] < 300) {
    echo "Successfully seeded " . count($products) . " items.\n";
} else {
    echo "Failed to seed data. Status: " . $insertResponse['status'] . "\n";
    print_r($insertResponse['body']);
}
