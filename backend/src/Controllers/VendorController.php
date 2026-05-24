<?php

declare(strict_types=1);

namespace RentEase\Controllers;

use RentEase\Middleware\RoleMiddleware;
use RentEase\Services\AuthService;
use RentEase\Services\ProductService;
use RentEase\Services\MaintenanceService;
use RentEase\Support\Csrf;

final class VendorController
{
    /** @var array<string, mixed> */
    private array $config;

    /** @var array<string, mixed>|null */
    private ?array $currentUser = null;

    public function __construct()
    {
        global $config;
        $this->config = $config;
    }

    public function dashboard(): void
    {
        $config = $this->config;

        RoleMiddleware::requireAnyRole(['vendor', 'admin'], $config);

        $authService = new AuthService($config);
        $productService = new ProductService($config);
        $maintenanceService = new MaintenanceService($config);

        $token = (string) ($_COOKIE[$config['cookie_name'] ?? ''] ?? '');
        $currentUser = $authService->validateToken($token);
        if ($currentUser === null) {
            header('Location: ' . baseUrl('/login'));
            exit;
        }

        $role = AuthService::resolveRole($currentUser);
        $vendorId = (string) $currentUser['id'];
        $isAdmin = $role === 'admin';

        $error   = $_SESSION['vendor_error'] ?? null;
        $success = $_SESSION['vendor_success'] ?? null;
        unset($_SESSION['vendor_error'], $_SESSION['vendor_success']);

        // Load data
        $products = [];
        $rentals  = [];
        $maintenanceReqs = [];
        $activeRentalsCount = 0;
        $totalRevenue = 0.0;

        try {
            $products = $isAdmin
                ? $productService->catalog(1, 50)
                : $productService->catalogForVendor($vendorId, 1, 50);
        } catch (\Throwable $e) {
            $error = $error ?? 'Could not load products: ' . $e->getMessage();
        }

        try {
            $rentalsPath = '/rest/v1/rentals?select=id,status,created_at,products!inner(name,vendor_id,monthly_price),profiles(email)';
            if (!$isAdmin) {
                $rentalsPath .= '&products.vendor_id=eq.' . rawurlencode($vendorId);
            }
            $rentalsPath .= '&order=created_at.desc&limit=100';
            $response = $this->supabaseGet($rentalsPath, true);
            $rentals = is_array($response) ? $response : [];
            $activeRentalsCount = count(array_filter($rentals, fn($r) => ($r['status'] ?? '') === 'active'));
            foreach ($rentals as $rental) {
                if (($rental['status'] ?? '') === 'active') {
                    $totalRevenue += (float) ($rental['products']['monthly_price'] ?? 0);
                }
            }
        } catch (\Throwable $e) {
            $error = $error ?? 'Could not load rentals.';
        }

        try {
            if ($isAdmin) {
                $maintPath = '/rest/v1/maintenance_requests?select=*,profiles(full_name,email),rentals(products(name))&order=created_at.desc';
                $maintResponse = $this->supabaseGet($maintPath, true);
                $maintenanceReqs = is_array($maintResponse) ? $maintResponse : [];
            } else {
                $maintenanceReqs = $maintenanceService->getVendorRequests($vendorId);
            }
        } catch (\Throwable $e) {
            $error = $error ?? 'Could not load maintenance requests.';
        }

        require __DIR__ . '/../../views/vendor/dashboard.php';
    }

    public function action(): void
    {
        $config = $this->config;

        RoleMiddleware::requireAnyRole(['vendor', 'admin'], $config);

        $authService = new AuthService($config);
        $token = (string) ($_COOKIE[$config['cookie_name'] ?? ''] ?? '');
        $currentUser = $authService->validateToken($token);
        if ($currentUser === null) {
            header('Location: ' . baseUrl('/login'));
            exit;
        }

        $this->currentUser = $currentUser;

        // CSRF check
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!Csrf::validate($csrfToken)) {
            $_SESSION['vendor_error'] = 'Invalid security token. Please try again.';
            header('Location: ' . baseUrl('/vendor-panel'));
            exit;
        }

        $action = $_POST['action'] ?? '';

        try {
            match ($action) {
                'create_product' => $this->handleCreateProduct(),
                'update_product' => $this->handleUpdateProduct(),
                'delete_product' => $this->handleDeleteProduct(),
                'update_rental'  => $this->handleUpdateRental(),
                default          => throw new \InvalidArgumentException("Unknown action: {$action}"),
            };
        } catch (\Throwable $e) {
            $_SESSION['vendor_error'] = $e->getMessage();
        }

        header('Location: ' . baseUrl('/vendor-panel'));
        exit;
    }

    // -------------------------------------------------------------------------
    // Private action handlers
    // -------------------------------------------------------------------------

    private function handleCreateProduct(): void
    {
        $name        = trim($_POST['name'] ?? '');
        $category    = trim($_POST['category'] ?? 'Furniture');
        $price       = (float) ($_POST['monthly_price'] ?? 0);
        $stock       = (int) ($_POST['total_stock'] ?? 0);
        $imageUrl    = trim($_POST['image_url'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($name === '') {
            throw new \InvalidArgumentException('Product name is required.');
        }
        if ($price <= 0) {
            throw new \InvalidArgumentException('Monthly price must be greater than zero.');
        }

        $payload = [
            'name'          => $name,
            'category'      => $category,
            'monthly_price' => $price,
            'total_stock'   => $stock,
            'image_url'     => $imageUrl ?: null,
            'description'   => $description ?: null,
            'vendor_id'     => $this->currentUser['id'] ?? null,
        ];

        $response = $this->supabasePost('/rest/v1/products', $payload, true);

        if (!is_array($response)) {
            throw new \RuntimeException('Failed to create product.');
        }

        $_SESSION['vendor_success'] = "Product \"{$name}\" created successfully.";
    }

    private function handleUpdateProduct(): void
    {
        $id          = (int) ($_POST['id'] ?? 0);
        $name        = trim($_POST['name'] ?? '');
        $category    = trim($_POST['category'] ?? 'Furniture');
        $price       = (float) ($_POST['monthly_price'] ?? 0);
        $stock       = (int) ($_POST['total_stock'] ?? 0);
        $imageUrl    = trim($_POST['image_url'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($id < 1) {
            throw new \InvalidArgumentException('Invalid product ID.');
        }
        if ($name === '') {
            throw new \InvalidArgumentException('Product name is required.');
        }

        $this->assertProductOwnership($id);

        $payload = [
            'name'          => $name,
            'category'      => $category,
            'monthly_price' => $price,
            'total_stock'   => $stock,
            'image_url'     => $imageUrl ?: null,
            'description'   => $description ?: null,
        ];

        $this->supabasePatch('/rest/v1/products?id=eq.' . $id, $payload, true);

        $_SESSION['vendor_success'] = "Product updated successfully.";
    }

    private function handleDeleteProduct(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id < 1) {
            throw new \InvalidArgumentException('Invalid product ID.');
        }

        $this->assertProductOwnership($id);

        $this->supabaseDelete('/rest/v1/products?id=eq.' . $id, true);

        $_SESSION['vendor_success'] = 'Product archived successfully.';
    }

    private function handleUpdateRental(): void
    {
        $id     = trim($_POST['id'] ?? '');
        $status = trim($_POST['status'] ?? '');

        $allowed = ['active', 'return_requested', 'return_inspection', 'completed', 'closed', 'cancelled'];
        if (!in_array($status, $allowed, true)) {
            throw new \InvalidArgumentException('Invalid rental status.');
        }
        if ($id === '') {
            throw new \InvalidArgumentException('Invalid rental ID.');
        }

        $this->assertRentalOwnership($id);

        $this->supabasePatch('/rest/v1/rentals?id=eq.' . rawurlencode($id), ['status' => $status], true);

        $_SESSION['vendor_success'] = 'Rental status updated.';
    }

    // -------------------------------------------------------------------------
    // Ownership guards
    // -------------------------------------------------------------------------

    private function isAdminUser(): bool
    {
        return $this->currentUser !== null && AuthService::resolveRole($this->currentUser) === 'admin';
    }

    private function assertProductOwnership(int $productId): void
    {
        if ($this->isAdminUser()) {
            return;
        }

        $vendorId = (string) ($this->currentUser['id'] ?? '');
        $products = $this->supabaseGet('/rest/v1/products?select=id,vendor_id&id=eq.' . $productId . '&limit=1', true);
        $ownerId = is_array($products) && isset($products[0]['vendor_id']) ? (string) $products[0]['vendor_id'] : '';

        if ($ownerId !== $vendorId) {
            throw new \RuntimeException('You do not have permission to modify this product.');
        }
    }

    private function assertRentalOwnership(string $rentalId): void
    {
        if ($this->isAdminUser()) {
            return;
        }

        $vendorId = (string) ($this->currentUser['id'] ?? '');
        $path = '/rest/v1/rentals?select=id,products!inner(vendor_id)&id=eq.' . rawurlencode($rentalId) . '&limit=1';
        $rentals = $this->supabaseGet($path, true);
        $ownerId = is_array($rentals) && isset($rentals[0]['products']['vendor_id'])
            ? (string) $rentals[0]['products']['vendor_id']
            : '';

        if ($ownerId !== $vendorId) {
            throw new \RuntimeException('You do not have permission to modify this rental.');
        }
    }

    // -------------------------------------------------------------------------
    // Supabase helpers
    // -------------------------------------------------------------------------

    /** @return array<mixed>|null */
    private function supabaseGet(string $path, bool $serviceRole = false): ?array
    {
        $url     = $this->config['supabase_url'] . $path;
        $headers = $serviceRole ? $this->serviceHeaders() : $this->anonHeaders();

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $this->headersToArray($headers),
        ]);
        $body = curl_exec($ch);
        curl_close($ch);

        if (!is_string($body)) {
            return null;
        }
        $decoded = json_decode($body, true);
        return is_array($decoded) ? $decoded : null;
    }

    /** @param array<string, mixed> $payload */
    private function supabasePost(string $path, array $payload, bool $serviceRole = false): mixed
    {
        $url     = $this->config['supabase_url'] . $path;
        $headers = array_merge(
            $serviceRole ? $this->serviceHeaders() : $this->anonHeaders(),
            ['Content-Type' => 'application/json', 'Prefer' => 'return=representation']
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_HTTPHEADER     => $this->headersToArray($headers),
        ]);
        $body = curl_exec($ch);
        curl_close($ch);

        return is_string($body) ? json_decode($body, true) : null;
    }

    /** @param array<string, mixed> $payload */
    private function supabasePatch(string $path, array $payload, bool $serviceRole = false): void
    {
        $url     = $this->config['supabase_url'] . $path;
        $headers = array_merge(
            $serviceRole ? $this->serviceHeaders() : $this->anonHeaders(),
            ['Content-Type' => 'application/json', 'Prefer' => 'return=minimal']
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'PATCH',
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_HTTPHEADER     => $this->headersToArray($headers),
        ]);
        curl_exec($ch);
        curl_close($ch);
    }

    private function supabaseDelete(string $path, bool $serviceRole = false): void
    {
        $url     = $this->config['supabase_url'] . $path;
        $headers = $serviceRole ? $this->serviceHeaders() : $this->anonHeaders();

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'DELETE',
            CURLOPT_HTTPHEADER     => $this->headersToArray($headers),
        ]);
        curl_exec($ch);
        curl_close($ch);
    }

    /** @return array<string, string> */
    private function anonHeaders(): array
    {
        return [
            'apikey'        => (string) $this->config['supabase_anon_key'],
            'Authorization' => 'Bearer ' . $this->config['supabase_anon_key'],
            'Accept'        => 'application/json',
        ];
    }

    /** @return array<string, string> */
    private function serviceHeaders(): array
    {
        $key = (string) $this->config['supabase_service_role_key'];
        return [
            'apikey'        => $key,
            'Authorization' => 'Bearer ' . $key,
            'Accept'        => 'application/json',
        ];
    }

    /**
     * @param array<string, string> $headers
     * @return array<int, string>
     */
    private function headersToArray(array $headers): array
    {
        $out = [];
        foreach ($headers as $k => $v) {
            $out[] = "{$k}: {$v}";
        }
        return $out;
    }
}
