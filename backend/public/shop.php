<?php
declare(strict_types=1);

require __DIR__ . '/../bootstrap.php';

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

<main class="bg-ink text-white min-h-screen pt-32 pb-32 relative overflow-hidden">
    <!-- Cinematic Background Texture -->
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none mix-blend-overlay" style="background-image: url('https://www.transparenttextures.com/patterns/stardust.png');"></div>
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-champagne/5 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-rose/5 rounded-full blur-[100px] pointer-events-none"></div>

    <!-- Header -->
    <section class="max-w-[1600px] mx-auto px-6 lg:px-12 relative z-10 pt-10 mb-20 text-center">
        <div class="mb-16">
            <div class="section-eyebrow inline-flex mx-auto mb-6 border-white/10 text-champagne bg-champagne/10"><span class="dot"></span> Curated Selection</div>
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-serif font-medium text-white tracking-tight leading-[1.05] mb-6">
                <?= htmlspecialchars($category === 'All' ? 'The Collection' : $category) ?>.
            </h1>
            <p class="text-white/50 text-lg font-light">Curated pieces for the modern home.</p>
        </div>

        <!-- Filter Nav -->
        <div class="flex justify-center gap-10 filter-nav opacity-0 translate-y-10 border-b border-white/10 pb-6">
            <a href="<?= baseUrl('/shop') ?>" class="<?= $category === 'All' ? 'text-champagne' : 'text-white/40 hover:text-white' ?> text-[11px] uppercase tracking-[0.2em] font-medium transition-colors outline-none relative pb-2 <?= $category === 'All' ? 'after:absolute after:bottom-[-1.5rem] after:left-0 after:w-full after:h-[2px] after:bg-champagne' : '' ?>">All Pieces</a>
            <a href="<?= baseUrl('/shop?category=Furniture') ?>" class="<?= $category === 'Furniture' ? 'text-champagne' : 'text-white/40 hover:text-white' ?> text-[11px] uppercase tracking-[0.2em] font-medium transition-colors outline-none relative pb-2 <?= $category === 'Furniture' ? 'after:absolute after:bottom-[-1.5rem] after:left-0 after:w-full after:h-[2px] after:bg-champagne' : '' ?>">Furniture</a>
            <a href="<?= baseUrl('/shop?category=Appliances') ?>" class="<?= $category === 'Appliances' ? 'text-champagne' : 'text-white/40 hover:text-white' ?> text-[11px] uppercase tracking-[0.2em] font-medium transition-colors outline-none relative pb-2 <?= $category === 'Appliances' ? 'after:absolute after:bottom-[-1.5rem] after:left-0 after:w-full after:h-[2px] after:bg-champagne' : '' ?>">Appliances</a>
        </div>
    </section>

    <!-- Product Grid -->
    <section class="max-w-[1600px] mx-auto px-6 lg:px-12 relative z-10">
        <?php if ($error): ?>
            <div class="p-8 border border-white/10 text-white/60 text-sm text-center bg-white/5">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php elseif (empty($products)): ?>
            <div class="py-32 text-center border border-white/10 bg-white/[0.02]">
                <span class="material-symbols-outlined text-4xl text-white/20 mb-4">inventory_2</span>
                <h2 class="text-2xl font-serif font-medium text-white mb-2">No pieces found</h2>
                <p class="text-sm text-white/40 font-light">Try exploring another category.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-24 product-grid">
                <?php foreach ($products as $index => $product):
                    $offsetClass = '';
                    if ($index % 3 === 1) $offsetClass = 'lg:translate-y-24';
                    if ($index % 3 === 2) $offsetClass = 'lg:translate-y-12';
                ?>
                <a href="<?= baseUrl('/product-detail?id=' . ($product['id'] ?? 0)) ?>" class="product-card group flex flex-col relative outline-none focus-visible:ring-2 ring-champagne/50 <?= $offsetClass ?>">
                    <div class="relative aspect-[3/4] overflow-hidden mb-6 bg-white/5">
                        <img alt="<?= htmlspecialchars((string)($product['name'] ?? 'Product')) ?>"
                             src="<?= htmlspecialchars((string)($product['image_url'] ?? 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&q=80&w=600')) ?>"
                             class="absolute inset-0 w-full h-full object-cover transition-all duration-[1.5s] group-hover:scale-110 opacity-80 group-hover:opacity-100"
                             loading="lazy"
                             style="filter: grayscale(20%);" />

                        <div class="absolute inset-0 bg-gradient-to-t from-ink/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>

                        <!-- Hover Reveal -->
                        <div class="absolute inset-x-0 bottom-0 p-8 flex items-end justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            <span class="px-8 py-3 bg-white/10 backdrop-blur-md text-white border border-white/20 text-[10px] uppercase tracking-[0.2em] font-medium transform translate-y-4 group-hover:translate-y-0 transition-all duration-500">View Details</span>
                        </div>
                    </div>

                    <div class="flex flex-col px-1">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-serif font-medium text-xl text-white pr-4 group-hover:text-champagne transition-colors duration-500">
                                <?= htmlspecialchars((string)($product['name'] ?? 'Premium Piece')) ?>
                            </h3>
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-white/60 font-light text-lg tracking-wide">$<?= number_format((float)($product['monthly_price'] ?? 0), 0) ?><span class="text-sm text-white/30">/mo</span></span>
                            <span class="text-[10px] uppercase tracking-[0.2em] text-white/30 px-3 py-1.5 border border-white/10">
                                <?= htmlspecialchars((string)($product['category'] ?? 'Collection')) ?>
                            </span>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <div class="mt-32 flex justify-center load-more opacity-0">
                <button class="px-12 py-5 bg-transparent border border-white/20 text-white hover:border-champagne hover:text-champagne transition-all duration-500 font-medium text-[11px] uppercase tracking-[0.2em] outline-none">
                    Load More
                </button>
            </div>
        <?php endif; ?>
    </section>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        const tl = gsap.timeline();

        tl.from('h1', { y: 40, opacity: 0, duration: 1.2, ease: 'power4.out' }, 0)
          .from('.section-eyebrow', { y: 20, opacity: 0, duration: 0.8, ease: 'power3.out' }, 0)
          .to('.filter-nav', { opacity: 1, y: 0, duration: 1, ease: 'power3.out' }, 0.4);

        gsap.utils.toArray('.product-card').forEach((card, i) => {
            gsap.from(card, {
                scrollTrigger: { trigger: card, start: 'top 85%' },
                y: 80,
                opacity: 0,
                duration: 1.2,
                ease: 'power3.out',
                delay: i * 0.08
            });
        });

        gsap.to('.load-more', {
            scrollTrigger: { trigger: '.load-more', start: 'top 90%' },
            opacity: 1,
            y: -20,
            duration: 1,
            ease: 'power3.out'
        });
    }
});
</script>

<?php include_once __DIR__ . '/partials/footer.php'; ?>
