<?php 
$pageTitle = 'RentEase - Browse Premium Rentals';
$pageDescription = 'Explore our catalog of premium furniture and appliances with flexible monthly plans. Free delivery and easy returns.';
require __DIR__ . '/../../public/partials/header.php'; 
?>

<!-- Main Content Area -->
<main class="flex-grow w-full max-w-container-max mx-auto px-4 md:px-8 py-lg mb-xl">
    <!-- Hero & Breadcrumbs -->
    <div class="relative bg-slate-900 rounded-[2.5rem] p-10 md:p-16 mb-12 overflow-hidden reveal-fade">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=2000&q=80" class="w-full h-full object-cover opacity-40 mix-blend-luminosity" alt="Browse Hero">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/80 to-transparent"></div>
        </div>
        <div class="relative z-10">
            <nav aria-label="Breadcrumb" class="flex text-white/60 font-light text-sm mb-6">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a class="inline-flex items-center hover:text-white transition-colors" href="<?= baseUrl('/') ?>">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <span class="material-symbols-outlined text-[16px] mx-1">chevron_right</span>
                            <a class="hover:text-white transition-colors" href="<?= baseUrl('/browse') ?>">Rentals</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <span class="material-symbols-outlined text-[16px] mx-1">chevron_right</span>
                            <span class="text-white font-normal"><?= $category ? htmlspecialchars($category) : 'All Products' ?></span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-4xl md:text-6xl font-normal text-white mb-4 tracking-tight">
                <?= $category ? htmlspecialchars($category) : 'Curated Collection' ?>
            </h1>
            <p class="text-white/70 text-lg md:text-xl font-light max-w-xl">
                Explore our catalog of premium pieces. Elevate your space with flexible, commitment-free monthly plans.
            </p>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-gutter">
        <!-- Sidebar Filters -->
        <aside class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white rounded-[2rem] border border-slate-100 p-6 shadow-sm sticky top-24 reveal-fade" style="transition-delay: 100ms;">
                <h2 class="text-xl font-normal text-slate-900 mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-teal-500">tune</span> Filters
                </h2>
                
                <!-- Category Filter -->
                <div class="mb-8">
                    <h3 class="text-xs font-normal text-slate-400 uppercase tracking-widest mb-4">Categories</h3>
                    <div class="flex flex-col gap-3">
                        <a href="<?= baseUrl('/browse') ?>" class="spa-link flex items-center justify-between group" data-category="">
                            <span class="text-sm transition-colors <?= $category === null ? 'text-slate-900 font-normal' : 'text-slate-500 font-light group-hover:text-slate-900' ?>">All Items</span>
                            <?php if ($category === null): ?>
                                <div class="w-1.5 h-1.5 rounded-full bg-teal-500"></div>
                            <?php endif; ?>
                        </a>
                        <a href="<?= baseUrl('/browse?category=Furniture') ?>" class="spa-link flex items-center justify-between group" data-category="Furniture">
                            <span class="text-sm transition-colors <?= $category === 'Furniture' ? 'text-slate-900 font-normal' : 'text-slate-500 font-light group-hover:text-slate-900' ?>">Furniture</span>
                            <?php if ($category === 'Furniture'): ?>
                                <div class="w-1.5 h-1.5 rounded-full bg-teal-500"></div>
                            <?php endif; ?>
                        </a>
                        <a href="<?= baseUrl('/browse?category=Appliances') ?>" class="spa-link flex items-center justify-between group" data-category="Appliances">
                            <span class="text-sm transition-colors <?= $category === 'Appliances' ? 'text-slate-900 font-normal' : 'text-slate-500 font-light group-hover:text-slate-900' ?>">Appliances</span>
                            <?php if ($category === 'Appliances'): ?>
                                <div class="w-1.5 h-1.5 rounded-full bg-teal-500"></div>
                            <?php endif; ?>
                        </a>
                    </div>
                </div>

                <!-- Tenure Options -->
                <div class="pt-6 border-t border-slate-100">
                    <h3 class="text-xs font-normal text-slate-400 uppercase tracking-widest mb-4">Tenure (Months)</h3>
                    <div class="flex gap-2">
                        <button class="flex-1 py-2 text-xs font-normal border border-teal-500 bg-teal-50 text-teal-700 rounded-xl transition-colors">3</button>
                        <button class="flex-1 py-2 text-xs font-normal border border-slate-200 text-slate-500 rounded-xl hover:border-teal-500 hover:text-teal-600 transition-colors">6</button>
                        <button class="flex-1 py-2 text-xs font-normal border border-slate-200 text-slate-500 rounded-xl hover:border-teal-500 hover:text-teal-600 transition-colors">12</button>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Product Grid -->
        <div class="flex-grow">
            <!-- Toolbar -->
            <div class="flex justify-between items-center mb-10 reveal-fade">
                <span class="text-slate-500 font-light"><?= count($products) ?> items found</span>
                <div class="flex items-center gap-3">
                    <?php if ($category): ?>
                        <input type="hidden" id="current-category" value="<?= htmlspecialchars($category) ?>">
                    <?php endif; ?>
                    <label for="sort" class="text-slate-500 font-light text-sm hidden sm:block">Sort by:</label>
                    <select name="sort" id="sort-select" class="bg-white border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-teal-500 focus:border-teal-500 block py-2.5 pl-4 pr-10 font-light shadow-sm outline-none cursor-pointer appearance-none relative">
                        <?php $currentSort = $_GET['sort'] ?? ''; ?>
                        <option value="" <?= $currentSort === '' ? 'selected' : '' ?>>Recommended</option>
                        <option value="price_asc" <?= $currentSort === 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
                        <option value="price_desc" <?= $currentSort === 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
                        <option value="newest" <?= $currentSort === 'newest' ? 'selected' : '' ?>>Newest Arrivals</option>
                    </select>
                </div>
            </div>

            <div id="ajax-grid-container" class="relative min-h-[400px] transition-opacity duration-300">
                <!-- Top Toolbar items found goes here if we want to update it, but for simplicity let's include it in the partial or update it separately. Actually the count is above. Let's just include the grid -->
                <?php require __DIR__ . '/partials/product-grid.php'; ?>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const gridContainer = document.getElementById('ajax-grid-container');
    const sortSelect = document.getElementById('sort-select');
    const itemCountSpan = document.getElementById('item-count');
    let currentCategory = new URLSearchParams(window.location.search).get('category') || '';
    
    // Function to fetch and update products
    async function fetchProducts(category, sort) {
        // Build URL
        const url = new URL(window.location.origin + window.location.pathname);
        if (category) url.searchParams.set('category', category);
        if (sort) url.searchParams.set('sort', sort);
        
        // Add visual loading state
        gridContainer.style.opacity = '0.5';
        gridContainer.style.pointerEvents = 'none';
        
        // Push State
        window.history.pushState({}, '', url);
        
        try {
            // Fetch partial
            url.searchParams.set('ajax', '1');
            const response = await fetch(url);
            
            // To update the item count, we can get it from a custom header or parse the HTML
            // In our case we can just let it be, or update the controller to return JSON. 
            // For simplicity, we'll fetch the HTML. We'll update the item count on full page loads.
            
            const html = await response.text();
            
            // Update DOM
            gridContainer.innerHTML = html;
            
            // Re-trigger GSAP animations
            if (window.ScrollTrigger) {
                ScrollTrigger.refresh();
                const fades = gridContainer.querySelectorAll('.reveal-fade');
                fades.forEach(el => {
                    gsap.fromTo(el, 
                        { opacity: 0, y: 30 },
                        {
                            opacity: 1, y: 0,
                            duration: 1,
                            ease: "power3.out",
                            scrollTrigger: {
                                trigger: el,
                                start: "top 90%",
                            }
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
    
    // Sort Event Listener
    if (sortSelect) {
        sortSelect.addEventListener('change', (e) => {
            fetchProducts(currentCategory, e.target.value);
        });
    }
    
    // Category Event Listeners
    const categoryLinks = document.querySelectorAll('.spa-link');
    categoryLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const newCategory = link.getAttribute('data-category');
            currentCategory = newCategory;
            
            // Update Active UI State for Categories
            categoryLinks.forEach(l => {
                const textSpan = l.querySelector('span.text-sm');
                const dot = l.querySelector('div\\.w-1\\.5');
                if (dot) dot.remove(); // Remove active dot
                textSpan.className = 'text-sm transition-colors text-slate-500 font-light group-hover:text-slate-900';
            });
            
            const textSpan = link.querySelector('span.text-sm');
            textSpan.className = 'text-sm transition-colors text-slate-900 font-normal';
            link.insertAdjacentHTML('beforeend', '<div class="w-1.5 h-1.5 rounded-full bg-teal-500"></div>');
            
            fetchProducts(newCategory, sortSelect ? sortSelect.value : '');
        });
    });
    
    // Handle Browser Back/Forward
    window.addEventListener('popstate', () => {
        window.location.reload();
    });
});
</script>

<style>
@keyframes heartbeat {
    0%, 100% { transform: scale(1); }
    25% { transform: scale(1.1); }
    50% { transform: scale(1); }
    75% { transform: scale(1.1); }
}
.heart-beat { animation: heartbeat 1s ease-in-out; }
</style>

<?php require __DIR__ . '/../../public/partials/footer.php'; ?>