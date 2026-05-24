<?php

declare(strict_types=1);

use RentEase\Services\ProductPipelineService;

require_once __DIR__ . '/../../bootstrap.php';

header('Content-Type: application/json; charset=UTF-8');

$allowedOrigin = (string) ($config['app_url'] ?? '');
if ($allowedOrigin !== '') {
    header('Access-Control-Allow-Origin: ' . $allowedOrigin);
}

$category = $_GET['category'] ?? null;
if ($category === '') {
    $category = null;
}

try {
    $service = new ProductPipelineService($config);
    $products = $service->getUnifiedProducts($category);

    echo json_encode([
        'status' => 'success',
        'count' => count($products),
        'products' => $products
    ], JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ], JSON_THROW_ON_ERROR);
}
