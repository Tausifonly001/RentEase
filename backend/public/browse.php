<?php
declare(strict_types=1);

use RentEase\Services\ProductService;
use RentEase\Services\WishlistService;
use RentEase\Services\AuthService;

require __DIR__ . '/../bootstrap.php';

$productService = new ProductService($config);
$wishlistService = new WishlistService($config);
$authService = new AuthService($config);

$currentUser = null;
$token = $_COOKIE[$config['cookie_name'] ?? ''] ?? '';
if ($token) {
    try {
        $userData = $authService->validateToken($token);
        if ($userData) {
            $currentUser = $userData;
            $currentUser['name'] = $userData['user_metadata']['full_name']
                ?? $userData['name']
                ?? explode('@', $userData['email'])[0]
                ?? 'User';
        }
    } catch (Throwable $ignored) {
    }
}

$category = $_GET['category'] ?? null;
if ($category === '')
    $category = null;

$products = [];
$wishlistIds = [];
$error = null;
$success = null;

// Handle Toggle Wishlist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_wishlist'])) {
    if (!$currentUser) {
        header('Location: login.php');
        exit;
    }

    $pid = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    $csrfToken = $_POST['csrf_token'] ?? '';

    if (!RentEase\Support\Csrf::validate((string) $csrfToken)) {
        $error = "Security validation failed. Please try again.";
    } elseif ($pid) {
        try {
            $wishlistService->toggleItem($currentUser['id'], $pid, $token);
            // Success - refresh list below
        } catch (Throwable $e) {
            $error = "Wishlist update failed: " . $e->getMessage();
        }
    }
}

try {
    $products = $productService->catalog(1, 50, $category);
} catch (Throwable $e) {
    $error = 'Unable to load products. Please try again.';
    $products = [];
    // Detailed logging for debugging
    $logDir = __DIR__ . '/../scratch';
    if (!is_dir($logDir))
        @mkdir($logDir, 0777, true);
    if (is_writable($logDir) || is_writable($logDir . '/error.log')) {
        file_put_contents($logDir . '/error.log', "[" . date('Y-m-d H:i:s') . "] Catalog Error: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n", FILE_APPEND);
    }
}

$wishlistIds = [];
if ($currentUser && empty($error)) {
    try {
        $wishItems = $wishlistService->getItems($currentUser['id'], $token);
        $wishlistIds = array_column($wishItems, 'product_id');
    } catch (Throwable $e) {
        // Log wishlist error but don't block the page
        $logDir = __DIR__ . '/../scratch';
        if (is_writable($logDir) || is_writable($logDir . '/error.log')) {
            file_put_contents($logDir . '/error.log', "[" . date('Y-m-d H:i:s') . "] Wishlist Fetch Error: " . $e->getMessage() . "\n", FILE_APPEND);
        }
    }
}

require __DIR__ . '/partials/header.php';
?>

<!-- Main Content Area -->
<main class="flex-grow w-full max-w-container-max mx-auto px-4 md:px-8 py-lg mb-xl">
    <!-- Breadcrumbs -->
    <nav aria-label="Breadcrumb" class="flex text-on-surface-variant font-body-sm text-body-sm mb-lg">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a class="inline-flex items-center hover:text-secondary transition-colors" href="home.php">
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-[16px] mx-1">chevron_right</span>
                    <a class="hover:text-secondary transition-colors" href="browse.php">Rentals</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-[16px] mx-1">chevron_right</span>
                    <span
                        class="text-on-surface font-medium"><?= $category ? htmlspecialchars($category) : 'All Products' ?></span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="flex flex-col md:flex-row gap-gutter">
        <!-- Sidebar Filters -->
        <aside class="w-full md:w-64 flex-shrink-0">
            <div class="bg-surface rounded-lg border border-outline-variant p-sm sticky top-24">
                <h2 class="font-h3 text-h3 text-on-surface mb-md">Filters</h2>
                <!-- Category Filter -->
                <div class="mb-md">
                    <h3 class="font-button text-button text-on-surface mb-xs">Category</h3>
                    <div class="flex flex-col gap-2">
                        <a href="browse.php" class="flex items-center gap-3 group">
                            <div
                                class="w-5 h-5 rounded border border-outline-variant flex items-center justify-center group-hover:border-secondary transition-colors <?= $category === null ? 'bg-secondary border-secondary' : '' ?>">
                                <?php if ($category === null): ?>
                                    <span class="material-symbols-outlined text-on-secondary text-sm">check</span>
                                <?php endif; ?>
                            </div>
                            <span
                                class="font-body-sm text-body-sm transition-colors <?= $category === null ? 'text-on-surface font-semibold' : 'text-on-surface-variant group-hover:text-on-surface' ?>">All
                                Items</span>
                        </a>
                        <a href="browse.php?category=Furniture" class="flex items-center gap-3 group">
                            <div
                                class="w-5 h-5 rounded border border-outline-variant flex items-center justify-center group-hover:border-secondary transition-colors <?= $category === 'Furniture' ? 'bg-secondary border-secondary' : '' ?>">
                                <?php if ($category === 'Furniture'): ?>
                                    <span class="material-symbols-outlined text-on-secondary text-sm">check</span>
                                <?php endif; ?>
                            </div>
                            <span
                                class="font-body-sm text-body-sm transition-colors <?= $category === 'Furniture' ? 'text-on-surface font-semibold' : 'text-on-surface-variant group-hover:text-on-surface' ?>">Furniture</span>
                        </a>
                        <a href="browse.php?category=Appliances" class="flex items-center gap-3 group">
                            <div
                                class="w-5 h-5 rounded border border-outline-variant flex items-center justify-center group-hover:border-secondary transition-colors <?= $category === 'Appliances' ? 'bg-secondary border-secondary' : '' ?>">
                                <?php if ($category === 'Appliances'): ?>
                                    <span class="material-symbols-outlined text-on-secondary text-sm">check</span>
                                <?php endif; ?>
                            </div>
                            <span
                                class="font-body-sm text-body-sm transition-colors <?= $category === 'Appliances' ? 'text-on-surface font-semibold' : 'text-on-surface-variant group-hover:text-on-surface' ?>">Appliances</span>
                        </a>
                    </div>
                </div>

                <!-- Quick Perks -->
                <div class="border-t border-outline-variant pt-md">
                    <h3 class="font-button text-button text-on-surface mb-xs">Tenure Options</h3>
                    <div class="grid grid-cols-3 gap-2">
                        <button
                            class="px-2 py-1 border border-secondary text-secondary rounded font-label-caps text-label-caps hover:bg-secondary hover:text-on-secondary transition-colors">3
                            Mo</button>
                        <button
                            class="px-2 py-1 border border-outline-variant text-on-surface-variant rounded font-label-caps text-label-caps hover:border-secondary hover:text-secondary transition-colors">6
                            Mo</button>
                        <button
                            class="px-2 py-1 border border-outline-variant text-on-surface-variant rounded font-label-caps text-label-caps hover:border-secondary hover:text-secondary transition-colors">12
                            Mo</button>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Product Grid -->
        <div class="flex-grow">
            <!-- Toolbar -->
            <div class="flex justify-between items-center mb-lg">
                <span class="font-body-sm text-body-sm text-on-surface-variant"><?= count($products) ?> items
                    found</span>
                <div class="flex items-center gap-2">
                    <span class="font-body-sm text-body-sm text-on-surface-variant">Sort by:</span>
                    <select
                        class="form-select font-body-sm text-body-sm border-outline-variant rounded-DEFAULT py-1 pl-2 pr-8 focus:ring-secondary focus:border-secondary text-on-surface bg-surface">
                        <option>Recommended</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Newest Arrivals</option>
                    </select>
                </div>
            </div>

            <?php if ($error): ?>
                <div class="bg-error-container text-on-error-container p-4 rounded-lg flex items-center gap-3">
                    <span class="material-symbols-outlined">error</span>
                    <p><?= htmlspecialchars($error) ?></p>
                </div>
            <?php elseif (empty($products)): ?>
                <div
                    class="py-16 text-center text-on-surface-variant border border-dashed border-outline-variant rounded-xl bg-surface">
                    <span class="material-symbols-outlined text-4xl mb-4">inventory_2</span>
                    <h3 class="font-h3 text-xl mb-2 text-on-surface">No items found</h3>
                    <p>We couldn't find any products in this category.</p>
                </div>
            <?php else: ?>
                <!-- Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-gutter">
                    <?php foreach ($products as $product): ?>
                        <div
                            class="bg-surface rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 border border-outline-variant/50 overflow-hidden flex flex-col group relative">
                            <!-- Wishlist Button -->
                            <form method="POST" class="absolute top-3 right-3 z-10">
                                <input type="hidden" name="csrf_token" value="<?= RentEase\Support\Csrf::token() ?>">
                                <input type="hidden" name="toggle_wishlist" value="1">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <?php $isInWishlist = in_array((int) $product['id'], $wishlistIds); ?>
                                <button type="submit"
                                    class="h-8 w-8 bg-surface/80 backdrop-blur rounded-full flex items-center justify-center transition-colors <?= $isInWishlist ? 'text-error bg-error-container' : 'text-on-surface hover:text-error hover:bg-error-container' ?>">
                                    <span class="material-symbols-outlined text-sm"
                                        style="font-variation-settings: 'FILL' <?= $isInWishlist ? '1' : '0' ?>;">favorite</span>
                                </button>
                            </form>

                            <!-- Image -->
                            <a href="product-detail.php?id=<?= $product['id'] ?>"
                                class="relative h-48 bg-surface-container-low overflow-hidden block">
                                <img alt="<?= htmlspecialchars($product['name']) ?>"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    src="<?= htmlspecialchars($product['image_url'] ?? 'https://via.placeholder.com/400x300?text=No+Image') ?>"
                                    loading="lazy" />
                                <?php if ($product['category'] === 'Appliances'): ?>
                                    <div
                                        class="absolute top-2 left-2 bg-surface-variant text-on-surface-variant px-2 py-1 rounded font-label-caps text-label-caps border border-outline-variant">
                                        Fast Delivery
                                    </div>
                                <?php endif; ?>
                            </a>

                            <!-- Info -->
                            <div class="p-4 flex flex-col flex-grow">
                                <div class="flex justify-between items-start mb-2">
                                    <a href="product-detail.php?id=<?= $product['id'] ?>">
                                        <h3 class="font-h3 text-body-lg text-on-surface font-semibold line-clamp-2">
                                            <?= htmlspecialchars($product['name']) ?></h3>
                                    </a>
                                </div>
                                <div class="mt-auto pt-4 flex flex-col gap-1">
                                    <div class="flex items-baseline gap-1">
                                        <span
                                            class="font-h3 text-h3 text-primary font-bold">$<?= number_format($product['monthly_price'] ?? 0, 0) ?></span>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">/mo</span>
                                    </div>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">Category:
                                        <?= htmlspecialchars($product['category']) ?></span>
                                </div>
                                <form method="POST" action="cart.php" class="mt-4">
                                    <input type="hidden" name="action" value="add">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit"
                                        class="w-full bg-surface-container-high text-primary hover:bg-primary hover:text-on-primary font-button text-button py-2 rounded-DEFAULT transition-colors duration-200 flex items-center justify-center gap-2">
                                        <span class="material-symbols-outlined text-sm">add_shopping_cart</span>
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>