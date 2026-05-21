<?php

declare(strict_types=1);

namespace RentEase\Controllers;

use RentEase\Services\AuthService;
use RentEase\Support\Request;
use RentEase\Support\HttpClient;

/**
 * Class VendorController
 *
 * Handles vendor dashboard and inventory management.
 */
class VendorController
{
    private array $config;
    private AuthService $authService;
    private HttpClient $http;
    private array $serviceHeaders;

    public function __construct()
    {
        global $config;
        $this->config = $config;
        $this->authService = new AuthService($config);
        $this->http = new HttpClient();
        $this->serviceHeaders = [
            'apikey' => (string) $config['supabase_service_role_key'],
            'Authorization' => 'Bearer ' . $config['supabase_service_role_key'],
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation'
        ];
    }

    /**
     * Common method to validate admin or vendor auth.
     */
    private function validateVendorOrAdmin(): ?array
    {
        $token = $_COOKIE[$this->config['cookie_name'] ?? 'rentease_access_token'] ?? '';
        if (empty($token)) {
            error_log("VendorController: No token found in cookies.");
            $this->redirectWithError("Please log in first.", "/login");
        }

        try {
            $user = $this->authService->validateToken($token);
            if (!$user) {
                error_log("VendorController: Token validation failed or profile not found.");
                $this->redirectWithError("Invalid session. Please log in again.", "/login");
            }
            
            // The role is already validated by AuthService and returned in the user array
            if (!in_array($user['role'] ?? '', ['vendor', 'admin'])) {
                error_log("[Auth Diagnostic] Access Denied. User ID: " . $user['id'] . " Role: " . ($user['role'] ?? 'null'));
                $this->redirectWithError("Access Denied: Vendor privileges required.", "/home");
            }
            
            return $user;

        } catch (\Exception $e) {
            error_log("VendorController Exception: " . $e->getMessage());
            $this->redirectWithError("Session error: " . $e->getMessage(), "/login");
        }
    }

    /**
     * Display the vendor dashboard.
     */
    public function dashboard(): void
    {
        $user = $this->validateVendorOrAdmin();
        
        $error = Request::get('error');
        $success = Request::get('success');
        
        // Fetch vendor's products
        $products = [];
        try {
            $productsRes = $this->http->request('GET', $this->config['supabase_url'] . '/rest/v1/products?vendor_id=eq.' . urlencode($user['id']) . '&select=*&order=id.desc', $this->serviceHeaders);
            $body = $productsRes['body'] ?? [];
            $products = (is_array($body) && array_is_list($body)) ? $body : [];
        } catch (\Exception $e) {
            $error = "Failed to load inventory: " . $e->getMessage();
        }

        // Fetch vendor's orders/rentals (rentals where the product belongs to this vendor)
        $rentals = [];
        $totalRevenue = 0.0;
        $activeRentalsCount = 0;
        
        try {
            // Because Supabase REST doesn't natively do easy multi-level reverse joins with filters on the child cleanly for all setups,
            // we first get products, then get rentals for those products.
            if (!empty($products)) {
                $productIds = array_column($products, 'id');
                $idList = implode(',', $productIds);
                $rentalsRes = $this->http->request('GET', $this->config['supabase_url'] . '/rest/v1/rentals?product_id=in.(' . urlencode($idList) . ')&select=*,profiles(email,full_name),products(name,category,monthly_price,image_url,sku)&order=created_at.desc', $this->serviceHeaders);
                $body = $rentalsRes['body'] ?? [];
                $rentals = (is_array($body) && array_is_list($body)) ? $body : [];
                
                foreach ($rentals as $r) {
                    if (($r['rental_status'] ?? $r['status'] ?? '') === 'active') {
                        $activeRentalsCount++;
                    }
                    if (($r['payment_status'] ?? '') === 'paid' || ($r['payment_status'] ?? '') === 'completed') {
                        $totalRevenue += (float)($r['products']['monthly_price'] ?? 0);
                    }
                }
            }
        } catch (\Exception $e) {
            $error = $error ?? "Failed to load orders: " . $e->getMessage();
        }
        $config = $this->config;
        require __DIR__ . '/../../views/vendor/dashboard.php';
    }

    /**
     * Handle POST actions for vendor dashboard
     */
    public function action(): void
    {
        $user = $this->validateVendorOrAdmin();
        $action = Request::post('action');
        $csrfToken = Request::post('csrf_token', '');

        if (!\RentEase\Support\Csrf::validate($csrfToken)) {
            $this->redirectWithError("Security validation failed.");
        }

        try {
            switch ($action) {
                case 'create_product':
                    $this->createProduct($user['id']);
                    break;
                case 'update_product':
                    $this->updateProduct($user['id']);
                    break;
                case 'delete_product':
                    $this->deleteProduct($user['id']);
                    break;
                case 'update_rental':
                    $this->updateRentalStatus($user['id']);
                    break;
                default:
                    $this->redirectWithError("Invalid action.");
            }
        } catch (\Exception $e) {
            $this->redirectWithError("Action failed: " . $e->getMessage());
        }
    }

    private function createProduct(string $vendorId): void
    {
        $data = [
            'vendor_id' => $vendorId,
            'name' => Request::post('name'),
            'category' => Request::post('category'),
            'monthly_price' => (float) Request::post('monthly_price'),
            'security_deposit' => (float) Request::post('security_deposit'),
            'stock_quantity' => (int) Request::post('stock_quantity', 1),
            'availability_status' => Request::post('availability_status') ?: 'available',
            'image_url' => Request::post('image_url') ?: null,
            'description' => Request::post('description') ?: null,
            'vendor_status' => 'active'
        ];

        $this->http->request('POST', $this->config['supabase_url'] . '/rest/v1/products', $this->serviceHeaders, $data);
        $this->redirectWithSuccess("Product added to inventory.");
    }

    private function updateProduct(string $vendorId): void
    {
        $id = Request::post('id');
        
        // Ensure the product belongs to the vendor
        $verifyRes = $this->http->request('GET', $this->config['supabase_url'] . '/rest/v1/products?id=eq.' . urlencode($id) . '&select=vendor_id', $this->serviceHeaders);
        $verify = isset($verifyRes['body']) ? $verifyRes['body'] : [];
        if (empty($verify) || $verify[0]['vendor_id'] !== $vendorId) {
             $this->redirectWithError("Unauthorized access to product.");
        }

        $data = [
            'name' => Request::post('name'),
            'category' => Request::post('category'),
            'monthly_price' => (float) Request::post('monthly_price'),
            'security_deposit' => (float) Request::post('security_deposit'),
            'stock_quantity' => (int) Request::post('stock_quantity', 1),
            'availability_status' => Request::post('availability_status') ?: 'available',
            'image_url' => Request::post('image_url') ?: null,
            'description' => Request::post('description') ?: null
        ];

        $this->http->request('PATCH', $this->config['supabase_url'] . '/rest/v1/products?id=eq.' . urlencode($id), $this->serviceHeaders, $data);
        $this->redirectWithSuccess("Product updated successfully.");
    }

    private function deleteProduct(string $vendorId): void
    {
        $id = Request::post('id');
        
        // Ensure the product belongs to the vendor
        $verifyRes = $this->http->request('GET', $this->config['supabase_url'] . '/rest/v1/products?id=eq.' . urlencode($id) . '&select=vendor_id', $this->serviceHeaders);
        $verify = isset($verifyRes['body']) ? $verifyRes['body'] : [];
        if (empty($verify) || $verify[0]['vendor_id'] !== $vendorId) {
             $this->redirectWithError("Unauthorized access to product.");
        }

        $this->http->request('DELETE', $this->config['supabase_url'] . '/rest/v1/products?id=eq.' . urlencode($id), $this->serviceHeaders);
        $this->redirectWithSuccess("Product removed from inventory.");
    }

    private function updateRentalStatus(string $vendorId): void
    {
        $id = Request::post('id');
        $status = Request::post('status');
        
        // Ensure the rental belongs to a product owned by the vendor
        $verifyRes = $this->http->request('GET', $this->config['supabase_url'] . '/rest/v1/rentals?id=eq.' . urlencode($id) . '&select=product_id,products!inner(vendor_id)', $this->serviceHeaders);
        $verify = isset($verifyRes['body']) ? $verifyRes['body'] : [];
        if (empty($verify) || $verify[0]['products']['vendor_id'] !== $vendorId) {
             $this->redirectWithError("Unauthorized access to rental order.");
        }

        $data = ['rental_status' => $status];
        if ($status === 'returned') {
            $data['actual_return_date'] = gmdate('Y-m-d\TH:i:s\Z');
        }

        $this->http->request('PATCH', $this->config['supabase_url'] . '/rest/v1/rentals?id=eq.' . urlencode($id), $this->serviceHeaders, $data);
        $this->redirectWithSuccess("Rental status updated.");
    }

    private function redirectWithError(string $message, string $url = "/vendor-panel"): void
    {
        $target = baseUrl($url);
        header("Location: $target?error=" . urlencode($message));
        exit;
    }

    private function redirectWithSuccess(string $message, string $url = "/vendor-panel"): void
    {
        $target = baseUrl($url);
        header("Location: $target?success=" . urlencode($message));
        exit;
    }
}
