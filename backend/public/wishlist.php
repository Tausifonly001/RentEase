<?php
/**
 * Your Wishlist / Saved Items
 * 
 * Displays items that the user has saved for later.
 */

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../src/Support/Csrf.php';

use RentEase\Services\AuthService;
use RentEase\Services\WishlistService;
use RentEase\Support\Csrf;

$authService = new AuthService($config);
$wishlistService = new WishlistService($config);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$currentUser = null;
$token = '';
try {
    $token = $_COOKIE[$config['cookie_name'] ?? ''] ?? '';
    if ($token) {
        $userData = $authService->validateToken($token);
        if ($userData) {
            $currentUser = $userData;
        }
    }
} catch (Throwable $ignored) {}

if (!$currentUser) {
    header('Location: ' . baseUrl('/login'));
    exit;
}

$error = null;
$success = null;

// Handle Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if (!Csrf::validate((string)($_POST['csrf_token'] ?? ''))) {
        $error = "Security validation failed.";
    } else {
        $action = $_POST['action'];
        $productId = $_POST['product_id'] ?? null;
        
        if ($action === 'remove' && $productId) {
            try {
                $wishlistService->removeFromWishlist($currentUser['id'], (string)$productId, $token);
                $success = "Item removed from wishlist.";
            } catch (Throwable $e) {
                $error = "Failed to remove item: " . $e->getMessage();
            }
        }
    }
}

// Fetch wishlist items
$wishlistItems = [];
try {
    $wishlistItems = $wishlistService->getWishlistByUserId($currentUser['id'], $token);
} catch (Throwable $e) {
    $error = "Failed to load wishlist items.";
}

$pageTitle = 'Your Wishlist - RentEase';
require_once __DIR__ . '/partials/header.php';
?>

<main class="flex-grow max-w-7xl mx-auto px-4 md:px-8 py-12 w-full">
    <!-- Feedback Messages -->
    <?php if ($error): ?>
        <div class="mb-8 bg-rose/10 text-rose p-4 flex items-center gap-3 reveal-element" style="border-color: rgba(231,229,228,0.6); border-radius: 0.75rem;">
            <span class="material-symbols-outlined">error</span>
            <p><?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="mb-8 bg-champagne/10 text-champagne-dark p-4 flex items-center gap-3 reveal-element" style="border-color: rgba(231,229,228,0.6); border-radius: 0.75rem;">
            <span class="material-symbols-outlined">check_circle</span>
            <p><?= htmlspecialchars($success) ?></p>
        </div>
    <?php endif; ?>

    <!-- Wishlist Header -->
    <div class="flex flex-col md:flex-row justify-between items-end md:items-center mb-12 gap-6 reveal-element">
        <div>
            <h1 class="text-4xl font-normal text-ink tracking-tight">Your Wishlist</h1>
            <p class="text-lg text-muted mt-2"><?= count($wishlistItems) ?> items saved for your dream home.</p>
        </div>
        <button class="bg-ink text-white font-normal px-8 py-4 flex items-center gap-2 hover:scale-[1.02] active:scale-95 transition-all" style="border-radius: 0.75rem;">
            <span class="material-symbols-outlined">shopping_cart_checkout</span>
            Move All to Cart
        </button>
    </div>

    <!-- Wishlist Items Grid -->
    <?php if (empty($wishlistItems)): ?>
        <div class="bg-canvas rounded-3xl border-2 border-dashed p-20 text-center reveal-element" style="border-color: rgba(231,229,228,0.6);">
            <div class="w-20 h-20 bg-surface flex items-center justify-center mx-auto mb-6 text-muted-light" style="border-radius: 9999px;">
                <span class="material-symbols-outlined text-4xl">favorite</span>
            </div>
            <h2 class="text-2xl font-normal text-ink mb-2">Your wishlist is empty</h2>
            <p class="text-muted mb-8">Start exploring and save items you love for later.</p>
            <a href="browse.php" class="bg-ink text-white px-10 py-4 font-normal hover:opacity-90 transition-all inline-block" style="border-radius: 0.75rem;">Browse Products</a>
        </div>
    <?php else: ?>
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16 reveal-element">
            <?php foreach ($wishlistItems as $item): 
                $product = $item['products'] ?? $item; // Handle different mapping if needed
            ?>
                <div class="group bg-surface overflow-hidden hover:-translate-y-1 transition-all duration-300 flex flex-col" style="border-color: rgba(231,229,228,0.6);">
                    <div class="relative aspect-[4/5] overflow-hidden bg-canvas">
                        <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" 
                             src="<?= htmlspecialchars((string)($product['image_url'] ?? 'https://via.placeholder.com/400x500')) ?>" 
                             alt="<?= htmlspecialchars((string)($product['name'] ?? 'Furniture')) ?>"/>
                        
                        <form action="wishlist.php" method="POST" class="absolute top-4 right-4">
                            <input type="hidden" name="csrf_token" value="<?= Csrf::token() ?>">
                            <input type="hidden" name="action" value="remove">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars((string)$product['id']) ?>">
                            <button type="submit" class="bg-surface/90 backdrop-blur-sm p-2.5 text-rose hover:bg-rose hover:text-white transition-all" style="border-radius: 9999px;">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </form>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <span class="text-[10px] font-normal text-champagne-dark uppercase tracking-widest mb-1"><?= htmlspecialchars((string)($product['category'] ?? 'Furniture')) ?></span>
                        <h3 class="text-xl font-normal text-ink mb-2 line-clamp-1"><?= htmlspecialchars((string)($product['name'] ?? 'Untitled Item')) ?></h3>
                        <p class="text-lg font-normal text-ink mb-6">From $<?= number_format((float)($product['monthly_price'] ?? 0), 0) ?><span class="text-xs font-light text-muted-light">/mo</span></p>
                        
                        <form action="cart.php" method="POST" class="mt-auto">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars((string)$product['id']) ?>">
                            <button type="submit" class="w-full border-2 text-champagne-dark font-normal py-3 hover:bg-champagne hover:text-white transition-all flex justify-center items-center gap-2" style="border-color: #D4A574; border-radius: 0.75rem;">
                                <span class="material-symbols-outlined text-[20px]">add_shopping_cart</span>
                                Move to Cart
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

    <!-- Saved Collections (Bento) -->
    <section class="mb-16 reveal-element">
        <div class="flex items-center gap-6 mb-10">
            <h2 class="text-2xl font-normal text-ink tracking-tight shrink-0">Saved Collections</h2>
            <div class="h-[1px] flex-grow" style="background: rgba(231,229,228,0.6);"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 h-[450px]">
            <div class="md:col-span-2 group relative overflow-hidden rounded-3xl cursor-pointer shadow-sm">
                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBAHOn30UOmoB9MDZ8O9iox2j1ryE0wcvS6oJH4X7IVJ_-9lYsW8UOmxuZ_aGtSR23Xsb2W3zS9vlUNTf2vZiuFZFK5mnBifkUZKbftB7hdDni6xXsTg97wv06vGJIStJnGsiFE13y3GY9MIH-8GzI-kBNboWV6MKFvwcRihlDsmxMI6NiruZjRBFjh0-4JQBC2E2uhgTSDGZ5N3WWTPEDb0H-EeFygOlK2b9eS1t-KnGNVNzxmGp_poRYZy7hsXdHY8jQCArjjLh6e" alt="Living Room"/>
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent p-10 flex flex-col justify-end">
                    <h4 class="text-3xl font-normal text-white mb-1">Living Room Setup</h4>
                    <p class="text-white/60 font-normal">12 items curated for comfort</p>
                </div>
            </div>
            <div class="grid grid-rows-2 gap-8">
                <div class="group relative overflow-hidden rounded-3xl cursor-pointer shadow-sm">
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA4Kgcf0Mma_rlUHnYFBrUq_ELgpYm-VTOV6wus6fCjLB3PweXJ56RK5ZXpCKQnZ9hUPKMKFftGMGSwKuLCLA3_9fO-CEOGYTE7qJCuAtHvYxaYLE7muU2f2XVo8ZYmBUz4yYViEpt0EM9U20pyQJvoQZ4fQWH3YzKhSNIyLbCMoeXwvqMB_0pGSIk7SjtAbEj6cyy9uxs4jWJxUGQEtUSSAODxqcmwbeSBGUk6dJpa7WRVn-lALg_6Qspl9TA57iecds3h8yiOaPXi" alt="Office"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent p-6 flex flex-col justify-end">
                        <h4 class="text-lg font-normal text-white">Home Office</h4>
                        <p class="text-xs text-white/60 font-light">5 essentials</p>
                    </div>
                </div>
                <div class="group relative overflow-hidden rounded-3xl cursor-pointer shadow-sm">
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBHXG53xMmD8LBSwB52M3xbw3YSE2C8zaK6hYkLTK1muFQohgAzbry8FngWDNRNETlS49C0IUUXV0Fsj_Erj5bzaH9bu5ius4cauJpSOagsEnfam0ba4bSTpyO4R0oDNVhjQi7AYlSK44UoqwAKXMTTYfR6t6mivGSr0dxZTaQ46GB6oUN_NbbV4rgxEgIJiRt8VYxBsd5Kot2m16at7S6FdyXHO7A27FfA47EV_meBUq4T3cPVyJr6EYAI7-vPOnaIYgJyEnwMc5aS" alt="Bedroom"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent p-6 flex flex-col justify-end">
                        <h4 class="text-lg font-normal text-white">Guest Suite</h4>
                        <p class="text-xs text-white/60 font-light">8 pieces</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recommendation Strip -->
    <section class="bg-canvas rounded-[2rem] p-12 reveal-element">
        <div class="flex justify-between items-center mb-10">
            <h2 class="text-2xl font-normal text-ink tracking-tight">Recommended for You</h2>
            <a class="text-champagne-dark font-light text-sm flex items-center gap-1 hover:underline" href="browse.php">
                View All Explore
                <span class="material-symbols-outlined text-lg">chevron_right</span>
            </a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            <?php
            // Sample recommendations if needed, or pull from ProductService
            $recoms = [
                ['name' => 'Nordic Side Table', 'price' => 8, 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCfPvGnhveYe1qlS4wdJdWBVgpUwIbAJ6XgQfK1rEP3Y0wxNzvmcTTuB7uMa46Z082Rd_0XDbeVbijKNT0kcbembhjcmuA31whHJsJPeKD_9jHSQ54LS_T4Tlfqn-ZOoVrMquWP8mIhaXTk6TMbCmW4CkeNrwNNQLV0ka9iF6Hhbuz6HhT5_hyBAHdaY-XlrFh5Lo4emcjXHH_uMaNAPDyT9s5VXpyBs1LLJTR51xA9XQdPFB8AgtMNGfQ0laBgKuuKBuchjYiLVUur'],
                ['name' => 'Lounge Armchair', 'price' => 18, 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBIjeLvfDga_YZEqaH8PpBM5rGij2n_EsWqLEE12oZu0bdW3XRPMJFzUB-JKyuecvh9uYu_7sG0fHMyG5PRDYuCjKH0mKvD4AWNfvCDZ4VAxsuGg0RYWiquwgiek1TDYAcloWzkqZD-2AH7cVUe8wo_D4Lkn0mrw107Lf0DCDSkD9zbuGXl355w7mPHiD7Ucp9icH4b5eohVrGwoA1x45xeerLja7nyTcfxdvcXwIIuwBp2qWTUxQd0U0Dy2WxpuRe1GQz2z-OUFcgc'],
                ['name' => 'Ceramic Floor Vase', 'price' => 5, 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC2JkBcnvA6WOQhehl2361DrMvqoOsAxChokGf4Jmt3zSAWyKc4zEgLsb76yXth6KrhU1NP0rS_6NzdvAfNlO0uT9bk3HruWimvRJMmrrmPy5pl6O52EwBDE8LhSGRHFX77WcTgCHwpfWE-hqSAl71JGuFD6YAYJMIqPJEoFSGgFxucXXLEvpKRz1WCQOmSOC0vZI81rxBH399IXmyXx6_XU_vVlihUlfvXtXvgJLCvo37-Lq2AUl_EQePjPA63OdzyGkQtOsj2xbX1'],
                ['name' => 'Patterned Area Rug', 'price' => 15, 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBjk93zYstDhhdFVWesrNxKp7vD_477Tl-uwiLpbhyD4qGXRf4pGTKiWZoeOdr_06AJzJfsVRZhntWyBEgY00Ruvl868bRBNsvSFt25T35bxuBf8YdYMqnyu_UUeN5mYJqNOmuvw7oXRZC7PGU6aAaobwusG__U5dd3EiiQSw0d29tsE93HisdBNxYYsvO2HTa6p1RvweHfdzhI7K_Hxxu1d4k-Qm7RCYSoqT2jeSriihlWwnmBkH5k_IuLaw3bYq_ek8R8M9FTI3y'],
                ['name' => 'Glass Coffee Table', 'price' => 12, 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCd9bZw2I-HIdMMXcJ2aRag0SQ0FfXTynvCiYSsJXSMqq-pCszhxCCbNWiRUAwwwznQ34SYcEvcB_e83CJubM01omZgrcaJL6LYz_Q-ArBcdbV4KVJSaRBmH0-B4wB7iVJ1ql1fkG5gfw5Fh23kPCn1vg188OsaQY74fL5ctsZTNpAnTnkBbmRCQB5ZT4OciTxLV7p47sDN8S-382yZN34xU7dnyoZJRuuOpy0FW9iYx1RBsUnmlfCIFcBxjmYCr9woXiKQ6UDKa5Qi'],
                ['name' => 'Floating Wall Shelves', 'price' => 7, 'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBJfHC_1zZLwuTNbtvmjlLbCwWLLmb8sLVfxqOU_CCoP-3mMzVvyZMP8rK7ZKw-5hoS2FvA_9LzeQjLxUo-mwQ3hObD8FPfCmIB3BRQZK-F2SsDg-scEV6BZMKrZ8WCLr8-MXAUU-pgeC2cQ7tbnPyRvbuEfxiXtqRcwQ_8F70TjcXEAo1jv-Ln-uA1oSygC4qIcqBlJHpFoSgtQ70YKFzp9K9obrfdHujH7FeTnjY9NmysmI4a6EKYpvyY_PxOxIt2JX2ajE-P4FRk']
            ];
            foreach ($recoms as $recom): ?>
                <div class="group cursor-pointer">
                    <div class="aspect-square overflow-hidden mb-3 bg-surface p-2" style="border-color: rgba(231,229,228,0.6);">
                        <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="<?= $recom['img'] ?>" alt="<?= $recom['name'] ?>" style="border-radius: 0.75rem;"/>
                    </div>
                    <p class="text-xs font-light text-ink truncate"><?= $recom['name'] ?></p>
                    <p class="text-[10px] font-normal text-muted-light uppercase tracking-widest">$<?= $recom['price'] ?>/mo</p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    gsap.from('.reveal-element', {
        opacity: 0,
        y: 20,
        duration: 0.8,
        stagger: 0.1,
        ease: 'power3.out'
    });
});
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
