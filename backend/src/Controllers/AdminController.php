<?php

declare(strict_types=1);

namespace RentEase\Controllers;

use RentEase\Services\AuthService;
use RentEase\Services\ProductService;
use RentEase\Services\MaintenanceService;
use RentEase\Middleware\RoleMiddleware;
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
        RoleMiddleware::requireRole('admin', $this->config);

        $success = Request::get('success');
        $error = Request::get('error');

        $productService = new ProductService($this->config);
        $maintenanceService = new MaintenanceService($this->config);

        // Fetch data for the view
        $products = [];
        try {
            $productsRes = $this->http->request('GET', $this->config['supabase_url'] . '/rest/v1/products?select=*&order=id.desc', $this->serviceHeaders);
            $body = $productsRes['body'] ?? [];
            $products = (is_array($body) && array_is_list($body)) ? $body : [];
        } catch (\Exception $e) {
            $error = "Failed to load products: " . $e->getMessage();
        }

        $rentals = [];
        try {
            $rentalsRes = $this->http->request('GET', $this->config['supabase_url'] . '/rest/v1/rentals?select=*,profiles(email,full_name),products(name,category,monthly_price)&order=created_at.desc', $this->serviceHeaders);
            $body = $rentalsRes['body'] ?? [];
            $rentals = (is_array($body) && array_is_list($body)) ? $body : [];
        } catch (\Exception $e) {
            $error = $error ?? "Failed to load rentals: " . $e->getMessage();
        }

        $orders = [];
        try {
            $ordersRes = $this->http->request('GET', $this->config['supabase_url'] . '/rest/v1/orders?select=*,profiles(email,full_name)&order=created_at.desc', $this->serviceHeaders);
            $body = $ordersRes['body'] ?? [];
            $orders = (is_array($body) && array_is_list($body)) ? $body : [];
        } catch (\Exception $e) {
            $error = $error ?? "Failed to load orders: " . $e->getMessage();
        }

        $deliveries = [];
        try {
            $deliveriesRes = $this->http->request('GET', $this->config['supabase_url'] . '/rest/v1/deliveries?select=*,profiles(email,full_name),orders(id),rentals(id)&order=scheduled_date.asc', $this->serviceHeaders);
            $body = $deliveriesRes['body'] ?? [];
            $deliveries = (is_array($body) && array_is_list($body)) ? $body : [];
        } catch (\Exception $e) {
            $error = $error ?? "Failed to load deliveries: " . $e->getMessage();
        }

        $users = [];
        try {
            $usersRes = $this->http->request('GET', $this->config['supabase_url'] . '/rest/v1/profiles?select=*&order=created_at.desc', $this->serviceHeaders);
            $body = $usersRes['body'] ?? [];
            $users = (is_array($body) && array_is_list($body)) ? $body : [];
        } catch (\Exception $e) {
            $error = $error ?? "Failed to load users: " . $e->getMessage();
        }

        // Fetch maintenance requests
        $maintenanceReqs = [];
        try {
            $mReqsRes = $this->http->request('GET', $this->config['supabase_url'] . '/rest/v1/maintenance_requests?select=*,profiles(full_name),rentals(products(name))&order=created_at.desc', $this->serviceHeaders);
            $body = $mReqsRes['body'] ?? [];
            $maintenanceReqs = (is_array($body) && array_is_list($body)) ? $body : [];
        } catch (\Exception $e) {
            $error = $error ?? "Failed to load maintenance requests: " . $e->getMessage();
        }

        // Calculate stats
        $activeRentalsCount = 0;
        $totalRevenue = 0.0;
        
        error_log("AdminController: Data Loaded - Products: " . count($products) . " Rentals: " . count($rentals) . " Orders: " . count($orders));

        foreach ($rentals as $rental) {
            if (($rental['status'] ?? $rental['rental_status'] ?? '') === 'active') {
                $activeRentalsCount++;
            }
        }
        foreach ($orders as $order) {
            if (($order['payment_status'] ?? '') === 'paid' || ($order['payment_status'] ?? '') === 'completed') {
                $totalRevenue += (float)($order['total_amount'] ?? 0);
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
        RoleMiddleware::requireRole('admin', $this->config);

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
            } elseif ($action === 'update_stock') {
                $this->updateStock();
            } elseif ($action === 'update_rental_status') {
                $this->updateRentalStatus();
            } elseif ($action === 'update_order_status') {
                $this->updateOrderStatus();
            } elseif ($action === 'update_delivery_status') {
                $this->updateDeliveryStatus();
            } elseif ($action === 'update_maintenance') {
                $this->updateMaintenanceStatus();
            } elseif ($action === 'update_user_role') {
                $this->updateUserRole();
            } else {
                $this->redirectWithError("Invalid action: " . $action);
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

    private function updateStock(): void
    {
        $id = Request::post('id');
        $stock = (int) Request::post('total_stock');
        
        $this->http->request('PATCH', $this->config['supabase_url'] . '/rest/v1/products?id=eq.' . urlencode((string)$id), $this->serviceHeaders, ['total_stock' => $stock]);
        $this->redirectWithSuccess("Stock level updated.");
    }

    private function updateRentalStatus(): void
    {
        $id = Request::post('rental_id');
        $status = Request::post('status');
        
        $data = ['status' => $status];
        if ($status === 'returned' || $status === 'completed' || $status === 'closed') {
            $data['actual_return_date'] = date('Y-m-d');
        }

        $this->http->request('PATCH', $this->config['supabase_url'] . '/rest/v1/rentals?id=eq.' . urlencode((string)$id), $this->serviceHeaders, $data);
        $this->redirectWithSuccess("Agreement status updated.");
    }

    private function updateOrderStatus(): void
    {
        $id = Request::post('order_id');
        $paymentStatus = Request::post('payment_status');
        $shippingStatus = Request::post('shipping_status');
        $trackingUrl = Request::post('tracking_url');
        
        $data = [
            'payment_status' => $paymentStatus,
            'shipping_status' => $shippingStatus,
            'tracking_url' => $trackingUrl ?: null
        ];

        $this->http->request('PATCH', $this->config['supabase_url'] . '/rest/v1/orders?id=eq.' . urlencode((string)$id), $this->serviceHeaders, $data);
        $this->redirectWithSuccess("Order status updated.");
    }

    private function updateDeliveryStatus(): void
    {
        $id = Request::post('delivery_id');
        $status = Request::post('status');
        $notes = Request::post('agent_notes');
        
        $data = [
            'status' => $status,
            'agent_notes' => $notes ?: null,
            'updated_at' => date('c')
        ];

        $this->http->request('PATCH', $this->config['supabase_url'] . '/rest/v1/deliveries?id=eq.' . urlencode((string)$id), $this->serviceHeaders, $data);
        $this->redirectWithSuccess("Logistics status updated.");
    }

    private function updateMaintenanceStatus(): void
    {
        $id = Request::post('request_id');
        $status = Request::post('status');
        $notes = Request::post('notes');
        
        $data = [
            'status' => $status,
            'notes' => $notes ?: null,
            'updated_at' => date('c')
        ];

        if ($status === 'RESOLVED' || $status === 'CLOSED') {
            $data['resolved_at'] = date('c');
        }

        $this->http->request('PATCH', $this->config['supabase_url'] . '/rest/v1/maintenance_requests?id=eq.' . urlencode((string)$id), $this->serviceHeaders, $data);
        $this->redirectWithSuccess("Maintenance ticket updated.");
    }

    private function updateUserRole(): void
    {
        $id = Request::post('user_id');
        $role = Request::post('role');
        $data = ['role' => $role];

        $this->http->request('PATCH', $this->config['supabase_url'] . '/rest/v1/profiles?id=eq.' . urlencode((string)$id), $this->serviceHeaders, $data);
        AuthService::clearUserCaches((string) $id);
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
