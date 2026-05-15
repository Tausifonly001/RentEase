<?php

declare(strict_types=1);

namespace RentEase\Controllers;

use RentEase\Services\AuthService;
use RentEase\Services\ProductService;
use RentEase\Services\MaintenanceService;
use RentEase\Support\HttpClient;
use RentEase\Support\Csrf;
use RentEase\Support\Request;

/**
 * Class AdminController
 *
 * Handles administrative actions.
 */
class AdminController
{
    private array $config;
    private HttpClient $http;
    private array $serviceHeaders;

    public function __construct()
    {
        global $config;
        $this->config = $config;
        $this->http = new HttpClient();
        $this->serviceHeaders = [
            'apikey' => (string) $this->config['supabase_service_role_key'],
            'Authorization' => 'Bearer ' . $this->config['supabase_service_role_key'],
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
    }

    /**
     * Display the admin dashboard.
     */
    public function dashboard(): void
    {
        // RoleMiddleware ensures the user is an admin.
        
        $success = Request::get('success');
        $error = Request::get('error');

        $productService = new ProductService($this->config);
        $maintenanceService = new MaintenanceService($this->config);

        // Fetch data for the view
        $products = [];
        try {
            $productsRes = $this->http->request('GET', $this->config['supabase_url'] . '/rest/v1/products?select=*&order=id.desc', $this->serviceHeaders);
            $products = (isset($productsRes['body']) && is_array($productsRes['body']) && !isset($productsRes['body']['raw'])) ? $productsRes['body'] : [];
        } catch (\Exception $e) {
            $error = "Failed to load products: " . $e->getMessage();
        }

        $rentals = [];
        try {
            $rentalsRes = $this->http->request('GET', $this->config['supabase_url'] . '/rest/v1/rentals?select=*,profiles(email,full_name),products(name,category,monthly_price)&order=created_at.desc', $this->serviceHeaders);
            $rentals = (isset($rentalsRes['body']) && is_array($rentalsRes['body']) && !isset($rentalsRes['body']['raw'])) ? $rentalsRes['body'] : [];
        } catch (\Exception $e) {
            $error = $error ?? "Failed to load rentals: " . $e->getMessage();
        }

        $users = [];
        try {
            $usersRes = $this->http->request('GET', $this->config['supabase_url'] . '/rest/v1/profiles?select=*&order=created_at.desc', $this->serviceHeaders);
            $users = (isset($usersRes['body']) && is_array($usersRes['body']) && !isset($usersRes['body']['raw'])) ? $usersRes['body'] : [];
        } catch (\Exception $e) {
            $error = $error ?? "Failed to load users: " . $e->getMessage();
        }

        // Fetch maintenance requests
        $maintenanceReqs = [];
        try {
            $mReqsRes = $this->http->request('GET', $this->config['supabase_url'] . '/rest/v1/maintenance_requests?select=*,profiles(full_name),products(name)', $this->serviceHeaders);
            $maintenanceReqs = (isset($mReqsRes['body']) && is_array($mReqsRes['body']) && !isset($mReqsRes['body']['raw'])) ? $mReqsRes['body'] : [];
        } catch (\Exception $e) {
            $error = $error ?? "Failed to load maintenance requests: " . $e->getMessage();
        }

        // Calculate stats
        $activeRentalsCount = 0;
        $totalRevenue = 0.0;
        foreach ($rentals as $rental) {
            if (($rental['rental_status'] ?? '') === 'active' || ($rental['status'] ?? '') === 'active') {
                $activeRentalsCount++;
            }
            if (($rental['payment_status'] ?? '') === 'paid' || ($rental['payment_status'] ?? '') === 'completed') {
                // Use a simplistic approach: sum up the product price for each paid rental
                $totalRevenue += (float)($rental['products']['monthly_price'] ?? 0);
            }
        }

        // Render the view
        $config = $this->config;
        require __DIR__ . '/../../views/admin/dashboard.php';
    }

    /**
     * Handle POST actions from the admin dashboard
     */
    public function action(): void
    {
        if (!Csrf::validate(Request::post('csrf_token', ''))) {
            $this->redirectWithError("Security validation failed. Please try again.");
        }

        $action = Request::post('action');

        try {
            if ($action === 'create_product') {
                $this->createProduct();
            } elseif ($action === 'update_product') {
                $this->updateProduct();
            } elseif ($action === 'delete_product') {
                $this->deleteProduct();
            } elseif ($action === 'update_lease_status') {
                $this->updateLeaseStatus();
            } elseif ($action === 'update_user_role') {
                $this->updateUserRole();
            } else {
                $this->redirectWithError("Invalid action.");
            }
        } catch (\Exception $e) {
            $this->redirectWithError("Error: " . $e->getMessage());
        }
    }

    private function createProduct(): void
    {
        $data = [
            'name' => Request::post('name'),
            'category' => Request::post('category'),
            'monthly_price' => (float) Request::post('monthly_price'),
            'total_stock' => (int) Request::post('total_stock'),
            'image_url' => Request::post('image_url') ?: null,
            'description' => Request::post('description') ?: null
        ];

        $this->http->request('POST', $this->config['supabase_url'] . '/rest/v1/products', $this->serviceHeaders, $data);
        $this->redirectWithSuccess("Product created successfully.");
    }

    private function updateProduct(): void
    {
        $id = Request::post('id');
        $data = [
            'name' => Request::post('name'),
            'category' => Request::post('category'),
            'monthly_price' => (float) Request::post('monthly_price'),
            'total_stock' => (int) Request::post('total_stock'),
            'image_url' => Request::post('image_url') ?: null,
            'description' => Request::post('description') ?: null
        ];

        $this->http->request('PATCH', $this->config['supabase_url'] . '/rest/v1/products?id=eq.' . urlencode($id), $this->serviceHeaders, $data);
        $this->redirectWithSuccess("Product updated successfully.");
    }

    private function deleteProduct(): void
    {
        $id = Request::post('id');
        $this->http->request('DELETE', $this->config['supabase_url'] . '/rest/v1/products?id=eq.' . urlencode($id), $this->serviceHeaders);
        $this->redirectWithSuccess("Product deleted successfully.");
    }

    private function updateLeaseStatus(): void
    {
        // Mock implementation for lease status based on current logic
        $id = Request::post('rental_id');
        $status = Request::post('status');
        
        $data = [];
        if ($status === 'returned') {
            $data['actual_return_date'] = date('Y-m-d');
        }

        if (!empty($data)) {
            $this->http->request('PATCH', $this->config['supabase_url'] . '/rest/v1/rentals?id=eq.' . urlencode($id), $this->serviceHeaders, $data);
        }
        $this->redirectWithSuccess("Rental status updated.");
    }

    private function updateUserRole(): void
    {
        $id = Request::post('user_id');
        $role = Request::post('role');
        $data = ['role' => $role];

        $this->http->request('PATCH', $this->config['supabase_url'] . '/rest/v1/profiles?id=eq.' . urlencode($id), $this->serviceHeaders, $data);
        $this->redirectWithSuccess("User role updated successfully.");
    }

    private function redirectWithSuccess(string $message, string $url = "/admin"): void
    {
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        $target = $base . '/' . ltrim($url, '/');
        header("Location: $target?success=" . urlencode($message));
        exit;
    }

    private function redirectWithError(string $message, string $url = "/admin"): void
    {
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        $target = $base . '/' . ltrim($url, '/');
        header("Location: $target?error=" . urlencode($message));
        exit;
    }
}
