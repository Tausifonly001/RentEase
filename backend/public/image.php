<?php
declare(strict_types=1);

use RentEase\Support\ImageOptimizer;

require_once __DIR__ . '/../bootstrap.php';

$file = $_GET['file'] ?? '';

$map = [
    'home_hero.png' => __DIR__ . '/../../assets/images/home_hero.png',
    'login_bg.png'  => __DIR__ . '/../../assets/images/auth/login_bg.png',
    'signup_bg.png' => __DIR__ . '/../../assets/images/auth/signup_bg.png',
];

if (!isset($map[$file])) {
    http_response_code(404);
    exit;
}

$imagePath = $map[$file];
if (!file_exists($imagePath)) {
    http_response_code(404);
    exit;
}

$optimizer = new ImageOptimizer();
$optimizer->serveWebP($imagePath);
