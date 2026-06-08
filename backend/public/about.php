<?php
declare(strict_types=1);

require __DIR__ . '/../bootstrap.php';

$pageTitle = "About Us - RentEase";
require __DIR__ . '/partials/header.php';
?>

<main class="w-full relative bg-canvas">

 <!-- Hero -->
 <section class="relative w-full min-h-[70vh] flex items-center px-6 lg:px-12 pt-32 pb-20 max-w-[1600px] mx-auto overflow-hidden" style="border-bottom: 1px solid rgba(231,229,228,0.6);">
 <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center w-full">
 <div>
 <div class="section-eyebrow mb-8"><span class="dot"></span> Our Story</div>
 <h1 class="text-5xl md:text-7xl font-serif font-medium tracking-tight text-ink leading-[1.05] mb-8">
 Redefining<br><span class="italic text-champagne">ownership.</span>
 </h1>
 <p class="text-lg md:text-xl text-muted font-light leading-relaxed mb-12 max-w-lg">
 At RentEase, we believe that life is about experiences, not just possessions. We're on a mission to make premium living accessible through flexible, sustainable, and hassle-free rentals.
 </p>
 <div class="flex flex-col sm:flex-row gap-5">
 <a href="<?= baseUrl('/shop') ?>" class="btn-primary">Explore Catalog</a>
 <a href="#our-story" class="btn-secondary">Our Story</a>
 </div>
 </div>
 <div class="relative hidden lg:block">
 <div class="aspect-[4/5] bg-surface overflow-hidden">
 <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover" alt="Premium Living Space" loading="lazy" style="filter: grayscale(20%);">
 </div>
 </div>
 </div>
 </section>

 <!-- Story -->
 <section id="our-story" class="py-28 lg:py-36 px-6 lg:px-12 max-w-[1600px] mx-auto" style="border-bottom: 1px solid rgba(231,229,228,0.6);">
 <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">
 <div class="order-2 lg:order-1">
 <div class="aspect-[4/5] bg-surface overflow-hidden">
 <img src="https://images.unsplash.com/photo-1618219904412-62d3a25f9e4e?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover" alt="Design philosophy" loading="lazy" style="filter: grayscale(20%);">
 </div>
 </div>
 <div class="order-1 lg:order-2">
 <h2 class="text-3xl md:text-5xl font-serif font-medium text-ink tracking-tight mb-8">
 Quality over<br><span class="italic text-champagne">quantity.</span>
 </h2>
 <div class="space-y-6 text-muted font-light leading-relaxed">
 <p>Founded in 2023, RentEase was born from a simple observation: why buy furniture when your needs evolve so quickly? We created a service that lets you live in beautifully furnished spaces without the burden of ownership.</p>
 <p>Every piece in our collection is hand-selected by our design team. We partner with ethical manufacturers who share our commitment to sustainability and craftsmanship. From mid-century modern to contemporary minimalism, our catalog spans styles that stand the test of time.</p>
 <p>Today, RentEase serves thousands of members across the country, helping them create spaces they love — on their terms.</p>
 </div>
 </div>
 </div>
 </section>

 <!-- Values -->
 <section class="py-28 lg:py-36 px-6 lg:px-12 max-w-[1600px] mx-auto text-center">
 <div class="max-w-2xl mx-auto mb-20">
 <div class="section-eyebrow mx-auto"><span class="dot"></span> Our Values</div>
 <h2 class="section-title">What we stand for.</h2>
 </div>
 <div class="grid grid-cols-1 md:grid-cols-3 gap-12 lg:gap-16 text-left max-w-5xl mx-auto">
 <div>
 <div class="text-6xl font-serif text-champagne/20 italic font-medium mb-6">01</div>
 <h3 class="text-xl font-serif font-medium text-ink mb-4">Sustainability</h3>
 <p class="text-muted font-light leading-relaxed">By renting instead of buying, we reduce waste and extend the lifecycle of beautifully crafted furniture. Every rental keeps pieces out of landfills.</p>
 </div>
 <div>
 <div class="text-6xl font-serif text-champagne/20 italic font-medium mb-6">02</div>
 <h3 class="text-xl font-serif font-medium text-ink mb-4">Craftsmanship</h3>
 <p class="text-muted font-light leading-relaxed">We partner with makers who prioritize quality materials and timeless design. Our pieces are built to last through multiple rental cycles and homes.</p>
 </div>
 <div>
 <div class="text-6xl font-serif text-champagne/20 italic font-medium mb-6">03</div>
 <h3 class="text-xl font-serif font-medium text-ink mb-4">Accessibility</h3>
 <p class="text-muted font-light leading-relaxed">Premium living shouldn't require a mortgage. Our flexible plans make designer furniture accessible to everyone, no matter where they are in life.</p>
 </div>
 </div>
 </section>

 <!-- CTA -->
 <section class="py-32 px-6 text-center relative" style="background: #18181B;">
 <div class="absolute inset-0 overflow-hidden pointer-events-none">
 <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-champagne/5 rounded-full blur-[100px]"></div>
 </div>
 <div class="relative z-10 max-w-3xl mx-auto">
 <h2 class="text-4xl md:text-6xl font-serif font-medium tracking-tight text-white mb-8">
 Join the<br><span class="italic text-champagne">movement.</span>
 </h2>
 <p class="text-lg text-white/60 font-light mb-14 max-w-lg mx-auto">Thousands of members have already transformed their spaces. Start your story today.</p>
 <a href="<?= baseUrl('/signup') ?>" class="inline-flex items-center justify-center px-12 py-5 bg-champagne text-ink text-[11px] font-medium tracking-[0.2em] uppercase transition-all duration-500 hover:bg-white outline-none">Get Started</a>
 </div>
 </section>

</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
