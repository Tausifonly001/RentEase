<?php
$pageTitle = 'RentEase - Browse Premium Rentals';
$pageDescription = 'Explore our catalog of premium furniture and appliances with flexible monthly plans. Free delivery and easy returns.';
require __DIR__ . '/../../public/partials/header.php';
?>

<!-- Main Content Area -->
<main class="flex-grow w-full max-w-[1600px] mx-auto px-6 lg:px-12 pt-32 pb-32">
    <!-- Hero & Breadcrumbs -->
    <div class="relative mb-16 text-center">
        <div class="mb-12">
            <div class="section-eyebrow inline-flex mx-auto mb-6"><span class="dot"></span> Curated Selection</div>
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-serif font-medium tracking-tight leading-[1.05] mb-6 reveal-fade">
                <?= $category ? htmlspecialchars($category) : 'The Collection' ?>.
            </h1>
            <p class="text-muted text-lg font-light reveal-fade" style="transition-delay: 100ms;">
                Explore our catalog of premium pieces. Elevate your space with flexible, commitment-free monthly plans.
            </p>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-12">
        <!-- Sidebar Filters -->
        <aside class="w-full lg:w-64 flex-shrink-0">
            <div class="bg-surface border border-border p-8 sticky top-24 reveal-fade" style="transition-delay: 200ms;">
                <h2 class="text-lg font-serif font-medium text-ink mb-8 flex items-center gap-2">
                    <span class="material-symbols-outlined text-muted text-sm">tune</span> Filters
                </h2>

                <!-- Category Filter -->
                <div class="mb-10">
                    <h3 class="text-[10px] font-medium text-muted uppercase tracking-[0.2em] mb-5">Categories</h3>
                    <div class="flex flex-col gap-4">
                        <a href="<?= baseUrl('/shop') ?>" class="spa-link flex items-center justify-between group outline-none" data-category="">
                            <span class="text-sm transition-colors <?= $category === null || $category === '' ? 'text-ink font-medium' : 'text-muted font-light group-hover:text-ink' ?>">All Items</span>
                            <?php if ($category === null || $category === ''): ?>
                                <div class="w-1.5 h-1.5 rounded-full bg-champagne"></div>
                            <?php endif; ?>
                        </a>
                        <a href="<?= baseUrl('/shop?category=Furniture') ?>" class="spa-link flex items-center justify-between group outline-none" data-category="Furniture">
                            <span class="text-sm transition-colors <?= $category === 'Furniture' ? 'text-ink font-medium' : 'text-muted font-light group-hover:text-ink' ?>">Furniture</span>
                            <?php if ($category === 'Furniture'): ?>
                                <div class="w-1.5 h-1.5 rounded-full bg-champagne"></div>
                            <?php endif; ?>
                        </a>
                        <a href="<?= baseUrl('/shop?category=Appliances') ?>" class="spa-link flex items-center justify-between group outline-none" data-category="Appliances">
                            <span class="text-sm transition-colors <?= $category === 'Appliances' ? 'text-ink font-medium' : 'text-muted font-light group-hover:text-ink' ?>">Appliances</span>
                            <?php if ($category === 'Appliances'): ?>
                                <div class="w-1.5 h-1.5 rounded-full bg-champagne"></div>
                            <?php endif; ?>
                        </a>
                    </div>
                </div>

                <!-- Tenure Options -->
                <div class="pt-8 border-t border-border">
                    <h3 class="text-[10px] font-medium text-muted uppercase tracking-[0.2em] mb-5">Tenure (Months)</h3>
                    <div class="flex gap-2">
                        <button class="flex-1 py-2 text-xs font-medium border border-champagne bg-champagne-soft text-champagne-dark transition-colors outline-none">3</button>
                        <button class="flex-1 py-2 text-xs font-medium border border-border text-muted hover:border-champagne hover:text-champagne transition-colors outline-none">6</button>
                        <button class="flex-1 py-2 text-xs font-medium border border-border text-muted hover:border-champagne hover:text-champagne transition-colors outline-none">12</button>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Product Grid -->
        <div class="flex-grow">
            <!-- Toolbar -->
            <div class="flex justify-between items-center mb-10 pb-6 border-b border-border reveal-fade" style="transition-delay: 300ms;">
                <span class="text-muted font-light text-sm"><span id="item-count"><?= count($products) ?></span> items found</span>
                <div class="flex items-center gap-4">
                    <?php if ($category): ?>
                        <input type="hidden" id="current-category" value="<?= htmlspecialchars($category) ?>">
                    <?php endif; ?>
                    <label for="sort" class="text-muted font-light text-xs uppercase tracking-[0.1em] hidden sm:block">Sort by:</label>
                    <select name="sort" id="sort-select" class="bg-surface border border-border text-ink text-sm focus:ring-1 focus:ring-champagne focus:border-champagne block py-2.5 pl-4 pr-10 font-light outline-none cursor-pointer appearance-none transition-colors">
                        <?php $currentSort = $_GET['sort'] ?? ''; ?>
                        <option value="" <?= $currentSort === '' ? 'selected' : '' ?>>Recommended</option>
                        <option value="price_asc" <?= $currentSort === 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
                        <option value="price_desc" <?= $currentSort === 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
                        <option value="newest" <?= $currentSort === 'newest' ? 'selected' : '' ?>>Newest Arrivals</option>
                    </select>
                </div>
            </div>

            <div id="ajax-grid-container" class="relative min-h-[400px] transition-opacity duration-300">
                <?php require __DIR__ . '/partials/product-grid.php'; ?>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const gridContainer = document.getElementById('ajax-grid-container');
    const sortSelect = document.getElementById('sort-select');
    let currentCategory = new URLSearchParams(window.location.search).get('category') || '';

    // Initialize GSAP for reveal-fade elements on page load
    const initGsap = setInterval(() => {
        if (window.gsap && window.ScrollTrigger) {
            clearInterval(initGsap);
            gsap.registerPlugin(ScrollTrigger);
            const fades = document.querySelectorAll('.reveal-fade');
            fades.forEach((el, index) => {
                gsap.fromTo(el,
                    { opacity: 0, y: 30 },
                    {
                        opacity: 1, y: 0,
                        duration: 1.2,
                        ease: "power3.out",
                        delay: el.style.transitionDelay ? parseFloat(el.style.transitionDelay)/1000 : index * 0.05,
                        scrollTrigger: { trigger: el, start: "top 90%" }
                    }
                );
            });
        }
    }, 100);

    // Function to fetch and update products
    async function fetchProducts(category, sort) {
        // Build URL
        const url = new URL(window.location.origin + window.location.pathname);
        if (category) url.searchParams.set('category', category);
        if (sort) url.searchParams.set('sort', sort);

        gridContainer.style.opacity = '0.5';
        gridContainer.style.pointerEvents = 'none';

        window.history.pushState({}, '', url);

        try {
            url.searchParams.set('ajax', '1');
            const response = await fetch(url);
            const html = await response.text();

            gridContainer.innerHTML = html;

            // Re-trigger GSAP animations
            if (window.ScrollTrigger) {
                ScrollTrigger.refresh();
                const productCards = gridContainer.querySelectorAll('.reveal-fade');
                productCards.forEach((el, i) => {
                    gsap.fromTo(el,
                        { opacity: 0, y: 30 },
                        {
                            opacity: 1, y: 0,
                            duration: 1,
                            ease: "power3.out",
                            delay: i * 0.05,
                            scrollTrigger: { trigger: el, start: "top 90%" }
                        }
                    );
                });
            }
        } catch (err) {
            console.error("Failed to load products:", err);
            window.location.reload();
        } finally {
            gridContainer.style.opacity = '1';
            gridContainer.style.pointerEvents = 'auto';
        }
    }

    if (sortSelect) {
        sortSelect.addEventListener('change', (e) => {
            fetchProducts(currentCategory, e.target.value);
        });
    }

    const categoryLinks = document.querySelectorAll('.spa-link');
    categoryLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const newCategory = link.getAttribute('data-category');
            currentCategory = newCategory;

            categoryLinks.forEach(l => {
                const textSpan = l.querySelector('span.text-sm');
                const dot = l.querySelector('div\\.w-1\\.5');
                if (dot) dot.remove();
                textSpan.className = 'text-sm transition-colors text-muted font-light group-hover:text-ink';
            });

            const textSpan = link.querySelector('span.text-sm');
            textSpan.className = 'text-sm transition-colors text-ink font-medium';
            link.insertAdjacentHTML('beforeend', '<div class="w-1.5 h-1.5 rounded-full bg-champagne"></div>');

            fetchProducts(newCategory, sortSelect ? sortSelect.value : '');
        });
    });

    window.addEventListener('popstate', () => {
        window.location.reload();
    });
});
</script>

<?php require __DIR__ . '/../../public/partials/footer.php'; ?>