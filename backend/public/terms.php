<?php
declare(strict_types=1);

require __DIR__ . '/../bootstrap.php';

$pageTitle = "Terms of Service - RentEase";
require __DIR__ . '/partials/header.php';
?>

<main class="flex-grow py-20 bg-surface-container-lowest">
 <div class="max-w-4xl mx-auto px-4 md:px-8">
 <div class="bg-surface p-8 md:p-12 rounded-3xl border border-outline-variant shadow-sm">
 <h1 class="font-h1 text-4xl text-on-surface mb-8">Terms of Service</h1>

 <div class="prose prose-slate max-w-none text-on-surface-variant leading-relaxed space-y-6">
 <p>Last Updated: October 2023</p>

 <section>
 <h2 class="text-2xl font-normal text-on-surface mb-4">1. Acceptance of Terms</h2>
 <p>By accessing and using this website, you accept and agree to be bound by the terms and provision of this agreement. Any participation in this service will constitute acceptance of this agreement.</p>
 </section>

 <section>
 <h2 class="text-2xl font-normal text-on-surface mb-4">2. Rental Conditions</h2>
 <p>All items rented through RentEase remain the property of RentEase. You are responsible for the items during the rental period and must return them in the condition they were received, subject to normal wear and tear.</p>
 </section>

 <section>
 <h2 class="text-2xl font-normal text-on-surface mb-4">3. Payment Terms</h2>
 <p>Subscription payments are billed monthly. Failure to pay may result in the termination of the rental agreement and retrieval of the rented items.</p>
 </section>

 <section>
 <h2 class="text-2xl font-normal text-on-surface mb-4">4. Limitation of Liability</h2>
 <p>RentEase shall not be liable for any special or consequential damages that result from the use of, or the inability to use, the materials on this site or the performance of the products.</p>
 </section>
 </div>
 </div>
 </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
