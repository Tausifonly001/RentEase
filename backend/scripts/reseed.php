<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

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

echo "Deleting old products...\n";
$deleteResponse = $http->request('DELETE', $supabaseUrl . '/rest/v1/products?id=gt.0', $headers);
if ($deleteResponse['status'] >= 200 && $deleteResponse['status'] < 300) {
    echo "Old products deleted successfully.\n";
} else {
    echo "Failed to delete old products. Status: " . $deleteResponse['status'] . "\n";
    exit(1);
}

echo "Seeding 40 high-quality realistic products...\n";

$baseParams = '?auto=format&fit=crop&w=800&q=80';

$products = [
    // --- FURNITURE (20 ITEMS) ---
    [
        'name' => 'Premium Modern Sofa',
        'category' => 'Furniture',
        'monthly_price' => 120.00,
        'total_stock' => 5,
        'image_url' => "https://images.unsplash.com/photo-1555041469-a586c61ea9bc{$baseParams}",
        'description' => 'A luxurious modern sofa perfect for any contemporary living room. Upholstered in premium fabric.'
    ],
    [
        'name' => 'Minimalist Dining Table',
        'category' => 'Furniture',
        'monthly_price' => 85.00,
        'total_stock' => 3,
        'image_url' => "https://images.unsplash.com/photo-1604578762246-41134e37f9cc{$baseParams}",
        'description' => 'Solid oak dining table that seats six comfortably. Simple, elegant, and sturdy.'
    ],
    [
        'name' => 'Ergonomic Office Chair',
        'category' => 'Furniture',
        'monthly_price' => 45.00,
        'total_stock' => 10,
        'image_url' => "https://images.unsplash.com/photo-1505843490538-5133c6c7d0e1{$baseParams}",
        'description' => 'Fully adjustable ergonomic chair designed for long hours of comfortable remote work.'
    ],
    [
        'name' => 'King Size Bed Frame',
        'category' => 'Furniture',
        'monthly_price' => 110.00,
        'total_stock' => 2,
        'image_url' => "https://images.unsplash.com/photo-1505693314120-0d443867891c{$baseParams}",
        'description' => 'Sturdy wooden king size bed frame with a sleek, minimalist headboard.'
    ],
    [
        'name' => 'Scandinavian Accent Chair',
        'category' => 'Furniture',
        'monthly_price' => 35.00,
        'total_stock' => 8,
        'image_url' => "https://images.unsplash.com/photo-1524758631624-e2822e304c36{$baseParams}",
        'description' => 'A stylish and comfortable accent chair with wooden legs and plush cushioning.'
    ],
    [
        'name' => 'Rustic Coffee Table',
        'category' => 'Furniture',
        'monthly_price' => 40.00,
        'total_stock' => 6,
        'image_url' => "https://images.unsplash.com/photo-1538694014760-577cb7ebf1d6{$baseParams}",
        'description' => 'A charming rustic coffee table made from reclaimed wood with a metal frame.'
    ],
    [
        'name' => 'Executive Task Chair',
        'category' => 'Furniture',
        'monthly_price' => 55.00,
        'total_stock' => 12,
        'image_url' => "https://images.unsplash.com/photo-1505797149-43b0069ec26b{$baseParams}",
        'description' => 'Premium task chair featuring mesh back, lumbar support, and adjustable armrests.'
    ],
    [
        'name' => 'Oak Study Desk',
        'category' => 'Furniture',
        'monthly_price' => 60.00,
        'total_stock' => 7,
        'image_url' => "https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd{$baseParams}",
        'description' => 'Spacious and durable oak wood desk, perfect for your home office setup.'
    ],
    [
        'name' => 'Velvet Lounge Chair',
        'category' => 'Furniture',
        'monthly_price' => 48.00,
        'total_stock' => 5,
        'image_url' => "https://images.unsplash.com/photo-1580480055273-228ff5388ef8{$baseParams}",
        'description' => 'Luxurious velvet lounge chair adding a touch of elegance to any room.'
    ],
    [
        'name' => 'Mid-Century TV Stand',
        'category' => 'Furniture',
        'monthly_price' => 45.00,
        'total_stock' => 4,
        'image_url' => "https://images.unsplash.com/photo-1595514535415-84e5b3b05f24{$baseParams}",
        'description' => 'A sleek mid-century modern TV stand with ample storage space for media.'
    ],
    [
        'name' => 'Contemporary Bookshelf',
        'category' => 'Furniture',
        'monthly_price' => 38.00,
        'total_stock' => 6,
        'image_url' => "https://images.unsplash.com/photo-1594620302200-9a762244a156{$baseParams}",
        'description' => 'Tall, modern bookshelf featuring asymmetric shelves for a unique display.'
    ],
    [
        'name' => 'Leather Recliner',
        'category' => 'Furniture',
        'monthly_price' => 85.00,
        'total_stock' => 3,
        'image_url' => "https://images.unsplash.com/photo-1508215885820-4585e56135c8{$baseParams}",
        'description' => 'Premium genuine leather recliner offering ultimate comfort and relaxation.'
    ],
    [
        'name' => 'Glass Dining Table',
        'category' => 'Furniture',
        'monthly_price' => 75.00,
        'total_stock' => 4,
        'image_url' => "https://images.unsplash.com/photo-1577140917170-285929fb55b7{$baseParams}",
        'description' => 'Elegant round glass dining table with a striking metallic geometric base.'
    ],
    [
        'name' => 'Upholstered Bed Frame (Queen)',
        'category' => 'Furniture',
        'monthly_price' => 95.00,
        'total_stock' => 5,
        'image_url' => "https://images.unsplash.com/photo-1522771731472-31030e463a56{$baseParams}",
        'description' => 'Queen bed frame with a beautifully tufted upholstered headboard in grey.'
    ],
    [
        'name' => 'L-Shaped Sectional Sofa',
        'category' => 'Furniture',
        'monthly_price' => 160.00,
        'total_stock' => 2,
        'image_url' => "https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e{$baseParams}",
        'description' => 'Spacious and cozy L-shaped sectional sofa, perfect for family living rooms.'
    ],
    [
        'name' => 'Wooden Nightstand',
        'category' => 'Furniture',
        'monthly_price' => 15.00,
        'total_stock' => 15,
        'image_url' => "https://images.unsplash.com/photo-1532372320572-cda25653a26d{$baseParams}",
        'description' => 'Simple yet elegant solid wood nightstand with a single spacious drawer.'
    ],
    [
        'name' => 'Rattan Outdoor Chair',
        'category' => 'Furniture',
        'monthly_price' => 25.00,
        'total_stock' => 10,
        'image_url' => "https://images.unsplash.com/photo-1592078615290-033ee584e267{$baseParams}",
        'description' => 'Weather-resistant rattan chair designed for patios and outdoor seating.'
    ],
    [
        'name' => 'Industrial Bar Stools (Set of 2)',
        'category' => 'Furniture',
        'monthly_price' => 30.00,
        'total_stock' => 8,
        'image_url' => "https://images.unsplash.com/photo-1519947486511-46149fa0a254{$baseParams}",
        'description' => 'Set of two counter-height industrial bar stools with rustic wood seats.'
    ],
    [
        'name' => 'Entryway Console Table',
        'category' => 'Furniture',
        'monthly_price' => 35.00,
        'total_stock' => 6,
        'image_url' => "https://images.unsplash.com/photo-1550581190-9c1c48d21d6c{$baseParams}",
        'description' => 'Narrow profile console table ideal for entryways and hallways, featuring a modern design.'
    ],
    [
        'name' => 'Boho Woven Pouf',
        'category' => 'Furniture',
        'monthly_price' => 12.00,
        'total_stock' => 20,
        'image_url' => "https://images.unsplash.com/photo-1533090481720-856c6e3c1fdc{$baseParams}",
        'description' => 'Comfortable and stylish hand-woven boho pouf, versatile as a seat or footrest.'
    ],

    // --- APPLIANCES (20 ITEMS) ---
    [
        'name' => 'Stainless Steel Refrigerator',
        'category' => 'Appliances',
        'monthly_price' => 150.00,
        'total_stock' => 4,
        'image_url' => "https://images.unsplash.com/photo-1584568694244-14fbdf83bd30{$baseParams}",
        'description' => 'Energy-efficient French door refrigerator with ice maker and smart temperature control.'
    ],
    [
        'name' => 'Front-Load Washer',
        'category' => 'Appliances',
        'monthly_price' => 95.00,
        'total_stock' => 6,
        'image_url' => "https://images.unsplash.com/photo-1626806787461-102c1bfaaea1{$baseParams}",
        'description' => 'High-capacity front-load washing machine with multiple wash cycles and steam cleaning.'
    ],
    [
        'name' => 'Smart Microwave Oven',
        'category' => 'Appliances',
        'monthly_price' => 30.00,
        'total_stock' => 8,
        'image_url' => "https://images.unsplash.com/photo-1585223146429-07fbf9d332d7{$baseParams}",
        'description' => '1000W smart microwave with built-in sensor cooking and Wi-Fi connectivity.'
    ],
    [
        'name' => 'Cordless Vacuum Cleaner',
        'category' => 'Appliances',
        'monthly_price' => 40.00,
        'total_stock' => 7,
        'image_url' => "https://images.unsplash.com/photo-1558317374-067fb5f30001{$baseParams}",
        'description' => 'Lightweight, powerful cordless vacuum cleaner with HEPA filtration and long battery life.'
    ],
    [
        'name' => '4K Ultra HD Smart TV (65")',
        'category' => 'Appliances',
        'monthly_price' => 110.00,
        'total_stock' => 5,
        'image_url' => "https://images.unsplash.com/photo-1593359677879-a4bb92f829d1{$baseParams}",
        'description' => 'Stunning 65-inch 4K Smart TV featuring HDR10, built-in voice assistant, and streaming apps.'
    ],
    [
        'name' => 'Espresso Machine Pro',
        'category' => 'Appliances',
        'monthly_price' => 50.00,
        'total_stock' => 8,
        'image_url' => "https://images.unsplash.com/photo-1517256064527-09c73fc73e38{$baseParams}",
        'description' => 'Professional-grade home espresso machine with an integrated burr grinder and milk frother.'
    ],
    [
        'name' => 'Air Purifier Max',
        'category' => 'Appliances',
        'monthly_price' => 25.00,
        'total_stock' => 15,
        'image_url' => "https://images.unsplash.com/photo-1596484552834-6a58f850e0a1{$baseParams}",
        'description' => 'High-efficiency True HEPA air purifier that removes 99.97% of airborne particles.'
    ],
    [
        'name' => 'Robot Vacuum & Mop',
        'category' => 'Appliances',
        'monthly_price' => 65.00,
        'total_stock' => 6,
        'image_url' => "https://images.unsplash.com/photo-1620188467120-5042ed1ce5ea{$baseParams}",
        'description' => 'Intelligent robot vacuum that simultaneously sweeps and mops with LiDAR navigation.'
    ],
    [
        'name' => 'Electric Convection Oven',
        'category' => 'Appliances',
        'monthly_price' => 85.00,
        'total_stock' => 4,
        'image_url' => "https://images.unsplash.com/photo-1584622650111-993a426fbf0a{$baseParams}",
        'description' => 'Freestanding electric range oven with true convection and smooth ceramic glass cooktop.'
    ],
    [
        'name' => 'Ventless Heat Pump Dryer',
        'category' => 'Appliances',
        'monthly_price' => 105.00,
        'total_stock' => 3,
        'image_url' => "https://images.unsplash.com/photo-1610557892470-55d9e80c0bce{$baseParams}",
        'description' => 'Ultra-efficient ventless heat pump dryer, perfect for apartments and sustainable living.'
    ],
    [
        'name' => 'Countertop Dishwasher',
        'category' => 'Appliances',
        'monthly_price' => 45.00,
        'total_stock' => 5,
        'image_url' => "https://images.unsplash.com/photo-1581093458791-9f3c3900df4b{$baseParams}",
        'description' => 'Compact and portable countertop dishwasher with a built-in water tank.'
    ],
    [
        'name' => 'Smart Thermostat',
        'category' => 'Appliances',
        'monthly_price' => 15.00,
        'total_stock' => 20,
        'image_url' => "https://images.unsplash.com/photo-1567924675637-28ed145ce43e{$baseParams}",
        'description' => 'Wi-Fi enabled smart thermostat that learns your habits and saves energy.'
    ],
    [
        'name' => 'Electric Standing Fan',
        'category' => 'Appliances',
        'monthly_price' => 18.00,
        'total_stock' => 12,
        'image_url' => "https://images.unsplash.com/photo-1561336313-0bd5e0b27ec8{$baseParams}",
        'description' => 'Quiet and powerful oscillating pedestal fan with remote control and sleep mode.'
    ],
    [
        'name' => 'Dyson Airblade Heater',
        'category' => 'Appliances',
        'monthly_price' => 45.00,
        'total_stock' => 8,
        'image_url' => "https://images.unsplash.com/photo-1631520113177-33630f9d9e4d{$baseParams}",
        'description' => 'Premium bladeless fan heater offering rapid and even room heating.'
    ],
    [
        'name' => 'Blender Pro Series',
        'category' => 'Appliances',
        'monthly_price' => 22.00,
        'total_stock' => 10,
        'image_url' => "https://images.unsplash.com/photo-1570222094114-d054a817e56b{$baseParams}",
        'description' => 'High-performance blender designed for smoothies, hot soups, and frozen desserts.'
    ],
    [
        'name' => 'Stand Mixer (Artisan)',
        'category' => 'Appliances',
        'monthly_price' => 35.00,
        'total_stock' => 7,
        'image_url' => "https://images.unsplash.com/photo-1595183371900-53bc3a7e58a2{$baseParams}",
        'description' => 'Iconic artisan stand mixer with a 5-quart capacity and multiple attachments.'
    ],
    [
        'name' => 'Toaster Oven Air Fryer',
        'category' => 'Appliances',
        'monthly_price' => 28.00,
        'total_stock' => 9,
        'image_url' => "https://images.unsplash.com/photo-1621252179027-94459d278660{$baseParams}",
        'description' => 'Versatile multi-function toaster oven with built-in air frying capabilities.'
    ],
    [
        'name' => 'Coffee Maker (Drip)',
        'category' => 'Appliances',
        'monthly_price' => 12.00,
        'total_stock' => 15,
        'image_url' => "https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd{$baseParams}",
        'description' => 'Programmable 12-cup drip coffee maker with an automatic keep-warm function.'
    ],
    [
        'name' => 'Mini Fridge with Freezer',
        'category' => 'Appliances',
        'monthly_price' => 40.00,
        'total_stock' => 5,
        'image_url' => "https://images.unsplash.com/photo-1605348532760-6753d2c43329{$baseParams}",
        'description' => 'Compact mini fridge featuring a separate freezer compartment, perfect for dorms or offices.'
    ],
    [
        'name' => 'Electric Kettle (Glass)',
        'category' => 'Appliances',
        'monthly_price' => 10.00,
        'total_stock' => 20,
        'image_url' => "https://images.unsplash.com/photo-1594213114663-d94af9fcaf7b{$baseParams}",
        'description' => 'Fast-boiling glass electric kettle with blue LED illumination and auto shut-off.'
    ]
];

$chunkedProducts = array_chunk($products, 10);
$totalInserted = 0;

foreach ($chunkedProducts as $chunk) {
    $insertResponse = $http->request('POST', $supabaseUrl . '/rest/v1/products', $headers, $chunk);
    if ($insertResponse['status'] >= 200 && $insertResponse['status'] < 300) {
        $totalInserted += count($chunk);
    } else {
        echo "Failed to seed chunk. Status: " . $insertResponse['status'] . "\n";
        echo json_encode($insertResponse['body'], JSON_PRETTY_PRINT) . "\n";
    }
}

echo "Successfully seeded {$totalInserted} items.\n";
