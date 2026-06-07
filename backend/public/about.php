<?php
declare(strict_types=1);

require __DIR__ . '/../bootstrap.php';

$pageTitle = "About Us - RentEase";
require __DIR__ . '/partials/header.php';
?>

<main class="flex-grow">
    <!-- Hero Section -->
    <section class="relative py-24 bg-surface overflow-hidden">
        <div class="max-w-container-max mx-auto px-4 md:px-8 relative z-10">
            <div class="max-w-3xl">
                <h1 class="font-h1 text-h1 md:text-6xl text-on-surface mb-6 leading-tight">
                    Redefining <span class="text-secondary">Ownership</span> for the Modern World.
                </h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant mb-8 leading-relaxed">
                    At RentEase, we believe that life is about experiences, not just possessions. We're on a mission to make premium living accessible to everyone through flexible, sustainable, and hassle-free rentals.
                </p>
                <div class="flex gap-4">
                    <a href="browse.php" class="bg-primary text-on-primary px-8 py-3 rounded-full font-button hover:shadow-lg transition-all">Explore Catalog</a>
                    <a href="#our-story" class="border border-outline text-on-surface px-8 py-3 rounded-full font-button hover:bg-surface-container-low transition-all">Our Story</a>
                </div>
            </div>
        </div>
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-1/2 h-full bg-secondary/5 -skew-x-12 translate-x-1/4"></div>
    </section>

    <!-- Our Values -->
    <section class="py-20 bg-surface-container-lowest">
        <div class="max-w-container-max mx-auto px-4 md:px-8">
            <div class="text-center mb-16">
                <h2 class="font-h2 text-h2 text-on-surface mb-4">The Values that Drive Us</h2>
                <div class="w-20 h-1 bg-secondary mx-auto rounded-full"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 bg-surface rounded-2xl border border-outline-variant hover:border-secondary transition-colors group">
                    <div class="w-12 h-12 bg-secondary/10 text-secondary rounded-lg flex items-center justify-center mb-6 group-hover:bg-secondary group-hover:text-on-secondary transition-all">
                        <span class="material-symbols-outlined">sustainability</span>
                    </div>
                    <h3 class="font-h3 text-xl text-on-surface mb-3">Sustainability</h3>
                    <p class="text-on-surface-variant leading-relaxed">Reducing waste by promoting a circular economy. Why buy when you can share?</p>
                </div>
                <div class="p-8 bg-surface rounded-2xl border border-outline-variant hover:border-secondary transition-colors group">
                    <div class="w-12 h-12 bg-secondary/10 text-secondary rounded-lg flex items-center justify-center mb-6 group-hover:bg-secondary group-hover:text-on-secondary transition-all">
                        <span class="material-symbols-outlined">bolt</span>
                    </div>
                    <h3 class="font-h3 text-xl text-on-surface mb-3">Flexibility</h3>
                    <p class="text-on-surface-variant leading-relaxed">Life changes fast. Our rental terms adapt to your needs, whether it's 3 months or 3 years.</p>
                </div>
                <div class="p-8 bg-surface rounded-2xl border border-outline-variant hover:border-secondary transition-colors group">
                    <div class="w-12 h-12 bg-secondary/10 text-secondary rounded-lg flex items-center justify-center mb-6 group-hover:bg-secondary group-hover:text-on-secondary transition-all">
                        <span class="material-symbols-outlined">verified</span>
                    </div>
                    <h3 class="font-h3 text-xl text-on-surface mb-3">Quality</h3>
                    <p class="text-on-surface-variant leading-relaxed">We only offer premium, well-maintained products that meet our rigorous standards.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="py-20 bg-primary text-on-primary">
        <div class="max-w-container-max mx-auto px-4 md:px-8 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-normal mb-2">10k+</div>
                <div class="text-primary-container/80 uppercase tracking-widest text-sm font-light">Active Users</div>
            </div>
            <div>
                <div class="text-4xl font-normal mb-2">500+</div>
                <div class="text-primary-container/80 uppercase tracking-widest text-sm font-light">Premium Items</div>
            </div>
            <div>
                <div class="text-4xl font-normal mb-2">24/7</div>
                <div class="text-primary-container/80 uppercase tracking-widest text-sm font-light">Support</div>
            </div>
            <div>
                <div class="text-4xl font-normal mb-2">4.9/5</div>
                <div class="text-primary-container/80 uppercase tracking-widest text-sm font-light">User Rating</div>
            </div>
        </div>
    </section>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
