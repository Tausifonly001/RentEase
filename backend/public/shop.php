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
        shuffle($products); // Mix them up for the editorial grid
    } else {
        $products = $productService->catalog($page, $limit, $category);
    }
} catch (Throwable $e) {
    $error = 'Unable to load products at this time.';
}

$pageTitle = "Shop " . htmlspecialchars($category) . " | RentEase";
include_once __DIR__ . '/partials/header.php';
?>

<main class="bg-primary text-surface min-h-screen pt-32 pb-32 relative overflow-hidden" id="smooth-wrapper">
    <!-- Atmospheric Background -->
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-10 pointer-events-none mix-blend-overlay"></div>
    <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-accent/5 rounded-full blur-[120px] pointer-events-none"></div>

    <div id="smooth-content">
        <!-- Hero / Header -->
        <section class="max-w-[1400px] mx-auto px-6 lg:px-12 relative z-10 pt-10 mb-20 text-center collection-header">
            <div class="mb-16">
                <h1 class="text-6xl md:text-8xl font-display font-medium text-surface tracking-tight leading-[1.1] mb-6 cinematic-text drop-shadow-lg">
                    <?= htmlspecialchars($category === 'All' ? 'The Collection' : $category) ?>.
                </h1>
                <p class="text-surface/70 font-sans text-xl font-light cinematic-text">Curated pieces for the modern home.</p>
            </div>
            
            <!-- Cinematic Filters -->
            <div class="flex justify-center gap-10 border-b border-surface/20 pb-6 filter-nav opacity-0 translate-y-10">
                <a href="<?= baseUrl('/shop') ?>" class="<?= $category === 'All' ? 'text-accent border-b-2 border-accent pb-2' : 'text-surface/60 hover:text-surface' ?> text-[11px] uppercase tracking-[0.2em] font-sans font-medium transition-colors outline-none">All Pieces</a>
                <a href="<?= baseUrl('/shop?category=Furniture') ?>" class="<?= $category === 'Furniture' ? 'text-accent border-b-2 border-accent pb-2' : 'text-surface/60 hover:text-surface' ?> text-[11px] uppercase tracking-[0.2em] font-sans font-medium transition-colors outline-none">Furniture</a>
                <a href="<?= baseUrl('/shop?category=Appliances') ?>" class="<?= $category === 'Appliances' ? 'text-accent border-b-2 border-accent pb-2' : 'text-surface/60 hover:text-surface' ?> text-[11px] uppercase tracking-[0.2em] font-sans font-medium transition-colors outline-none">Appliances</a>
            </div>
        </section>

        <!-- Asymmetrical Grid -->
        <section class="max-w-[1400px] mx-auto px-6 lg:px-12 relative z-10">
            <?php if ($error): ?>
                <div class="p-8 border border-red-900/50 text-red-400 font-sans text-sm bg-red-950/20 rounded-sm text-center backdrop-blur-sm">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php elseif (empty($products)): ?>
                <div class="py-32 text-center border border-surface/10 bg-surface/5 rounded-sm backdrop-blur-sm">
                    <span class="material-symbols-outlined text-4xl text-surface/50 mb-4">inventory_2</span>
                    <h2 class="text-2xl font-display font-medium text-surface mb-2">No pieces found</h2>
                    <p class="text-sm text-surface/50 font-sans">Try exploring another category.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-24 product-grid">
                    <?php foreach ($products as $index => $product): 
                        // Create asymmetrical rhythm
                        $offsetClass = '';
                        if ($index % 3 === 1) $offsetClass = 'lg:translate-y-24';
                        if ($index % 3 === 2) $offsetClass = 'lg:translate-y-12';
                    ?>
                    <a href="<?= baseUrl('/product-detail?id=' . ($product['id'] ?? 0)) ?>" class="group flex flex-col relative outline-none focus-visible:ring-2 ring-accent ring-offset-8 ring-offset-primary product-card <?= $offsetClass ?>">
                        <!-- Image Container -->
                        <div class="relative aspect-[3/4] overflow-hidden bg-surface/5 mb-6 cinematic-image rounded-sm border border-surface/10">
                            <img alt="<?= htmlspecialchars((string)($product['name'] ?? 'Product')) ?>"
                                 src="<?= htmlspecialchars((string)($product['image_url'] ?? 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&q=80&w=600')) ?>"
                                 class="absolute inset-0 w-full h-full object-cover transition-transform duration-[2s] ease-[cubic-bezier(0.25,1,0.5,1)] group-hover:scale-110 opacity-80 group-hover:opacity-100" />
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-primary/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                            
                            <!-- Hover Quick View (Subtle) -->
                            <div class="absolute inset-x-0 bottom-0 p-8 flex items-end justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                <span class="bg-surface/10 backdrop-blur-md text-surface border border-surface/20 px-8 py-3 font-sans uppercase tracking-[0.2em] font-medium text-[10px] transform translate-y-4 group-hover:translate-y-0 transition-all duration-500 ease-[cubic-bezier(0.25,1,0.5,1)]">View Details</span>
                            </div>
                        </div>

                        <!-- Text Content -->
                        <div class="flex flex-col px-2">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-display font-medium text-2xl text-surface truncate pr-4 group-hover:text-accent transition-colors duration-500">
                                    <?= htmlspecialchars((string)($product['name'] ?? 'Premium Piece')) ?>
                                </h3>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-surface/70 font-sans font-light text-lg tracking-wide">$<?= number_format((float)($product['monthly_price'] ?? 0), 0) ?>/mo</span>
                                <span class="text-[10px] uppercase tracking-[0.2em] text-surface/50 font-sans px-3 py-1.5 border border-surface/20 rounded-sm">
                                    <?= htmlspecialchars((string)($product['category'] ?? 'Collection')) ?>
                                </span>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
                
                <!-- Pagination (Editorial Style) -->
                <div class="mt-32 flex justify-center load-more-container opacity-0">
                    <button class="px-12 py-5 bg-transparent border border-surface/30 text-surface hover:border-accent hover:text-accent transition-all duration-500 font-sans font-medium text-[11px] uppercase tracking-[0.2em] outline-none">
                        Load More
                    </button>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script src="https://unpkg.com/split-type"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        const tl = gsap.timeline();

        // Split text intro
        const splitTexts = document.querySelectorAll('.cinematic-text');
        if (typeof SplitType !== 'undefined' && splitTexts.length) {
            splitTexts.forEach(text => {
                const split = new SplitType(text, { types: 'lines' });
                tl.from(split.lines, {
                    y: 40,
                    opacity: 0,
                    duration: 1.2,
                    stagger: 0.1,
                    ease: 'power4.out',
                }, 0);
            });
        }

        tl.to('.filter-nav', {
            opacity: 1,
            y: 0,
            duration: 1,
            ease: 'power3.out'
        }, 0.6);

        // Product Cards Scroll Reveal
        gsap.utils.toArray('.product-card').forEach((card, i) => {
            gsap.from(card, {
                scrollTrigger: {
                    trigger: card,
                    start: 'top 85%',
                },
                y: 100,
                opacity: 0,
                duration: 1.5,
                ease: 'power3.out'
            });
        });

        // Load More Reveal
        gsap.to('.load-more-container', {
            scrollTrigger: {
                trigger: '.load-more-container',
                start: 'top 90%'
            },
            opacity: 1,
            y: -20,
            duration: 1,
            ease: 'power3.out'
        });
    }
});
</script>

<?php include_once __DIR__ . '/partials/footer.php'; ?>
