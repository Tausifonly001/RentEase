<?php

declare(strict_types=1);

namespace RentEase\Controllers;

use RentEase\Services\ProductService;
use RentEase\Services\WishlistService;
use RentEase\Services\AuthService;
use RentEase\Support\Request;

/**
 * Class ShopController
 *
 * Handles public browsing and shopping endpoints.
 */
class ShopController
{
    private array $config;
    private ProductService $productService;
    private WishlistService $wishlistService;
    private AuthService $authService;

    public function __construct()
    {
        global $config;
        $this->config = $config;
        $this->productService = new ProductService($config);
        $this->wishlistService = new WishlistService($config);
        $this->authService = new AuthService($config);
    }

    /**
     * Display the browse/shop page.
     */
    public function browse(): void
    {
        // Sanitize GET parameters
        $query = Request::get('q', '');
        $category = Request::get('category', '');
        $minPrice = (float) Request::get('min_price', 0);
        $maxPrice = (float) Request::get('max_price', 0);
        $page = max(1, (int) Request::get('page', 1));

        $perPage = 12;

        try {
            // Check if we need to search or just list
            $products = $this->productService->catalog($page, $perPage, $category);

            // Supabase doesn't easily return total count without a specific query, mock it or fetch all
            $totalCount = count($products) === $perPage ? $page * $perPage + 1 : ($page - 1) * $perPage + count($products);

            // Filtering in memory for category/price if needed (since basic service might not support it)
            if ($query) {
                $products = array_filter($products, fn($p) => stripos($p['name'], $query) !== false || stripos($p['description'] ?? '', $query) !== false);
            }
            if ($maxPrice > 0) {
                $products = array_filter($products, fn($p) => $p['monthly_price'] >= $minPrice && $p['monthly_price'] <= $maxPrice);
            }

            // Sorting logic
            $sort = Request::get('sort', '');
            if ($sort === 'price_asc') {
                usort($products, fn($a, $b) => $a['monthly_price'] <=> $b['monthly_price']);
            } elseif ($sort === 'price_desc') {
                usort($products, fn($a, $b) => $b['monthly_price'] <=> $a['monthly_price']);
            } elseif ($sort === 'newest') {
                // If there's a created_at or id we can use that, otherwise default to id descending
                usort($products, fn($a, $b) => $b['id'] <=> $a['id']);
            }

            // Wishlist Logic
            $wishlistIds = [];
            $error = null;
            $currentUser = null;
            $token = $_COOKIE[$this->config['cookie_name'] ?? ''] ?? '';
            if ($token) {
                try {
                    $userData = $this->authService->validateToken($token);
                    if ($userData) {
                        $currentUser = $userData;
                        $currentUser['name'] = $userData['user_metadata']['full_name']
                            ?? $userData['name']
                            ?? explode('@', $userData['email'])[0]
                            ?? 'User';

                        // Fetch wishlist
                        $wishItems = $this->wishlistService->getItems($currentUser['id'], $token);
                        $wishlistIds = array_column($wishItems, 'product_id');
                    }
                } catch (\Throwable $ignored) {
                    // Ignore auth/wishlist errors for public browsing
                }
            }

            // Check for toggle wishlist action in query or flash (for simplicity if redirected)
            // But since POST is used, we'll handle it in an action method.

        } catch (\Exception $e) {
            $error = "Unable to load catalog: " . $e->getMessage();
            $products = [];
            $totalCount = 0;
            $wishlistIds = [];
        }

        if (Request::get('ajax') === '1') {
            require __DIR__ . '/../../views/shop/partials/product-grid.php';
            exit;
        }

        require __DIR__ . '/../../views/shop/browse.php';
    }

    /**
     * Handle POST actions like adding to wishlist.
     */
    public function action(): void
    {
        if (Request::post('toggle_wishlist')) {
            $token = $_COOKIE[$this->config['cookie_name'] ?? ''] ?? '';
            $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
            if (!$token) {
                header("Location: $base/login");
                exit;
            }

            try {
                $userData = $this->authService->validateToken($token);
                if (!$userData) {
                    header("Location: $base/login");
                    exit;
                }

                $pid = (int) Request::post('product_id');
                $csrfToken = Request::post('csrf_token', '');

                if (!\RentEase\Support\Csrf::validate($csrfToken)) {
                    $_SESSION['error'] = "Security validation failed. Please try again.";
                } elseif ($pid) {
                    $this->wishlistService->toggleItem($userData['id'], $pid, $token);
                }
            } catch (\Throwable $e) {
                $_SESSION['error'] = "Wishlist update failed: " . $e->getMessage();
            }
        }

        // Redirect back to browse
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        header("Location: $base/browse");
        exit;
    }
}
