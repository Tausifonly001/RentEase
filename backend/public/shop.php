<?php
declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use RentEase\Services\ProductService;

$productService = new ProductService($config);
$category = $_GET['category'] ?? 'All';
$page = (int)($_GET['page'] ?? 1);
$limit = 12;

$products = [];
$error = null;

try {
    if ($category === 'All') {
        $furniture = $productService->catalog($page, 6, 'Furniture');
        $appliances = $productService->catalog($page, 6, 'Appliances');
        $products = array_merge($furniture, $appliances);
        shuffle($products);
    } else {
        $products = $productService->catalog($page, $limit, $category);
    }
} catch (Throwable $e) {
    $error = 'Unable to load products at this time.';
}

$pageTitle = "Shop " . htmlspecialchars($category) . " | RentEase";
include_once __DIR__ . '/partials/header.php';
?>

<main class="w-full relative bg-canvas text-ink pt-32 pb-32 min-h-screen">
    <!-- Header -->
    <section class="max-w-[1600px] mx-auto px-6 lg:px-12 relative z-10 mb-16 text-center">
        <div class="mb-12">
            <div class="section-eyebrow inline-flex mx-auto mb-6"><span class="dot"></span> Curated Selection</div>
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-serif font-medium tracking-tight leading-[1.05] mb-6" id="shop-title">
                <?= htmlspecialchars($category === 'All' ? 'The Collection' : $category) ?>.
            </h1>
            <p class="text-muted text-lg font-light">Curated pieces for the modern home.</p>
        </div>

        <!-- Filter Nav -->
        <div class="flex justify-center gap-10 filter-nav opacity-0 translate-y-10 border-b border-border pb-6">
            <a href="<?= baseUrl('/shop') ?>" class="<?= $category === 'All' ? 'text-ink after:w-full' : 'text-muted hover:text-ink after:w-0' ?> text-[11px] uppercase tracking-[0.2em] font-medium transition-colors outline-none relative pb-2 after:absolute after:bottom-[-1.5rem] after:left-0 after:h-[2px] after:bg-champagne after:transition-all after:duration-500 hover:after:w-full">All Pieces</a>
            <a href="<?= baseUrl('/shop?category=Furniture') ?>" class="<?= $category === 'Furniture' ? 'text-ink after:w-full' : 'text-muted hover:text-ink after:w-0' ?> text-[11px] uppercase tracking-[0.2em] font-medium transition-colors outline-none relative pb-2 after:absolute after:bottom-[-1.5rem] after:left-0 after:h-[2px] after:bg-champagne after:transition-all after:duration-500 hover:after:w-full">Furniture</a>
            <a href="<?= baseUrl('/shop?category=Appliances') ?>" class="<?= $category === 'Appliances' ? 'text-ink after:w-full' : 'text-muted hover:text-ink after:w-0' ?> text-[11px] uppercase tracking-[0.2em] font-medium transition-colors outline-none relative pb-2 after:absolute after:bottom-[-1.5rem] after:left-0 after:h-[2px] after:bg-champagne after:transition-all after:duration-500 hover:after:w-full">Appliances</a>
        </div>
    </section>

    <!-- Product Grid -->
    <section class="max-w-[1600px] mx-auto px-6 lg:px-12 relative z-10">
        <?php if ($error): ?>
            <div class="p-8 border border-border text-muted text-sm text-center bg-surface">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php elseif (empty($products)): ?>
            <div class="py-32 text-center border border-border bg-surface">
                <span class="material-symbols-outlined text-4xl text-muted-light mb-4">inventory_2</span>
                <h2 class="text-2xl font-serif font-medium text-ink mb-2">No pieces found</h2>
                <p class="text-sm text-muted font-light">Try exploring another category.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-20 product-grid">
                <?php foreach ($products as $index => $product): ?>
                <a href="<?= baseUrl('/product-detail?id=' . ($product['id'] ?? 0)) ?>" class="product-card group block relative w-full outline-none focus-visible:ring-1 ring-champagne p-2 -m-2">
                    <div class="aspect-[4/5] bg-surface relative overflow-hidden mb-6">
                        <img alt="<?= htmlspecialchars((string)($product['name'] ?? 'Product')) ?>"
                             src="<?= htmlspecialchars((string)($product['image_url'] ?? 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&q=80&w=600')) ?>"
                             class="absolute inset-0 w-full h-full object-cover transition-all duration-1000 group-hover:scale-105"
                             loading="lazy"
                             style="filter: grayscale(10%);" />
                        <div class="absolute inset-0 bg-ink/0 group-hover:bg-ink/5 transition-colors duration-700"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-canvas/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                            <span class="text-[11px] font-medium tracking-[0.2em] uppercase text-ink">View Details</span>
                        </div>
                    </div>
                    <div class="flex flex-col px-1">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-serif font-medium text-ink group-hover:text-champagne transition-colors duration-500">
                                <?= htmlspecialchars((string)($product['name'] ?? 'Premium Piece')) ?>
                            </h3>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-muted uppercase tracking-[0.15em] font-medium text-[10px]">
                                <?= htmlspecialchars((string)($product['category'] ?? 'Collection')) ?>
                            </span>
                            <span class="font-mono text-ink font-medium">
                                $<?= number_format((float)($product['monthly_price'] ?? 0), 0) ?><span class="text-muted-light font-sans text-[10px]">/mo</span>
                            </span>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <div class="mt-32 flex justify-center load-more opacity-0">
                <button class="btn-secondary">Load More</button>
            </div>
        <?php endif; ?>
    </section>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    (window.RentEase ? RentEase.gsapReady : Promise.resolve(null)).then(function(gsap) {
        if (!gsap || !window.ScrollTrigger) return;
        gsap.registerPlugin(ScrollTrigger);

        const tl = gsap.timeline();
        tl.from('#shop-title', { y: 40, opacity: 0, duration: 1.2, ease: 'power4.out' }, 0)
          .from('.section-eyebrow', { y: 20, opacity: 0, duration: 0.8, ease: 'power3.out' }, 0)
          .to('.filter-nav', { opacity: 1, y: 0, duration: 1, ease: 'power3.out' }, 0.4);

        gsap.utils.toArray('.product-card').forEach((card, i) => {
            gsap.from(card, { scrollTrigger: { trigger: card, start: 'top 85%' }, y: 60, opacity: 0, duration: 1.2, ease: 'power3.out', delay: i * 0.08 });
        });
        gsap.to('.load-more', { scrollTrigger: { trigger: '.load-more', start: 'top 90%' }, opacity: 1, y: -20, duration: 1, ease: 'power3.out' });
    });
});
</script>

<?php include_once __DIR__ . '/partials/footer.php'; ?>
