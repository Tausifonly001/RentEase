<?php
/**
 * Post-Delivery Survey
 *
 * Customer feedback for delivery and product quality.
 */

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use RentEase\Services\AuthService;

$authService = new AuthService($config);

if (session_status() !== PHP_SESSION_ACTIVE) {
 session_start();
}

$currentUser = null;
try {
 $token = $_COOKIE[$config['cookie_name'] ?? ''] ?? '';
 if ($token) {
 $userData = $authService->validateToken($token);
 if ($userData) {
 $currentUser = $userData;
 }
 }
} catch (Throwable $ignored) {}

$deliveryId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$title = 'Tell us how we did | RentEase';
require_once __DIR__ . '/partials/header.php';
?>

<main class="pt-24 pb-16 max-w-4xl mx-auto px-8 min-h-screen flex flex-col justify-center">
 <div class="bg-white rounded-3xl shadow-xl shadow-sm border border-border overflow-hidden reveal-element">
 <!-- Progress Bar -->
 <div class="h-1.5 w-full bg-surface">
 <div id="survey-progress" class="h-full w-1/3 bg-champagne rounded-r-full transition-all duration-1000"></div>
 </div>

 <div class="p-8 md:p-12">
 <!-- Header -->
 <div class="text-center mb-12">
 <div class="w-20 h-20 bg-champagne/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
 <span class="material-symbols-outlined text-champagne-dark text-4xl" style="font-variation-settings: 'FILL' 1;">celebration</span>
 </div>
 <h1 class="text-3xl md:text-4xl font-normal text-ink mb-4 tracking-tight">Your delivery is complete!</h1>
 <p class="text-lg text-muted max-w-lg mx-auto">We'd love to hear about your experience and your new items.</p>
 </div>

 <!-- Survey Content -->
 <form id="survey-form" class="space-y-12">
 <input type="hidden" name="delivery_id" value="<?= $deliveryId ?>">

 <!-- Delivery Experience -->
 <section>
 <h3 class="text-[10px] font-normal text-muted-light uppercase tracking-[0.2em] mb-8 text-center">DELIVERY EXPERIENCE</h3>
 <div class="flex flex-col items-center gap-8">
 <div class="flex justify-center gap-4">
 <?php for($i=1; $i<=5; $i++): ?>
 <button type="button" class="star-btn group flex flex-col items-center gap-2" data-value="<?= $i ?>">
 <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-surface border-2 border-transparent hover:border-secondary hover:bg-white transition-all flex items-center justify-center group-active:scale-95 shadow-sm">
 <span class="material-symbols-outlined text-3xl text-muted-light group-hover:text-secondary transition-colors" style="font-variation-settings: 'FILL' 0;">star</span>
 </div>
 <span class="text-[10px] font-normal text-muted-light opacity-0 group-hover:opacity-100 transition-opacity uppercase"><?= ['Terrible','Poor','Average','Great','Amazing'][$i-1] ?></span>
 </button>
 <?php endfor; ?>
 </div>
 <p class="text-sm font-light text-ink">How would you rate the professionalism?</p>
 </div>
 </section>

 <!-- Feedback Text -->
 <section>
 <label class="block text-[10px] font-normal text-muted-light uppercase tracking-[0.2em] mb-4 text-center">ANY SPECIFIC COMMENTS?</label>
 <textarea id="comments" class="w-full p-6 bg-surface border border-border rounded-2xl focus:ring-4 focus:ring-secondary/10 focus:border-secondary outline-none transition-all text-ink font-normal min-h-[150px] placeholder:text-muted-light" placeholder="Everything was great, thank you!"></textarea>
 </section>

 <!-- Tags -->
 <section>
 <p class="text-sm font-light text-ink text-center mb-6">What went well?</p>
 <div class="flex flex-wrap justify-center gap-3">
 <?php foreach(['On-time', 'Polite', 'Careful', 'Professional', 'Fast Setup', 'Clean'] as $tag): ?>
 <button type="button" onclick="toggleTag(this)" class="tag-btn px-6 py-2 rounded-full border-2 border-border text-sm font-light text-muted hover:border-secondary hover:text-secondary transition-all active:scale-95"><?= $tag ?></button>
 <?php endforeach; ?>
 </div>
 </section>

 <!-- Submit -->
 <div class="pt-6">
 <button type="submit" id="submit-btn" class="w-full bg-ink text-white font-normal py-5 rounded-2xl shadow-xl shadow-primary/20 hover:opacity-95 transition-all active:scale-95 text-lg">
 Submit Feedback
 </button>
 <a href="<?= baseUrl('/dashboard') ?>" class="block w-full text-center text-muted-light font-light py-4 mt-2 hover:text-ink transition-all text-sm">
 Maybe Later
 </a>
 </div>
 </form>
 </div>
 </div>
</main>

<script>
let currentRating = 0;
let selectedTags = [];

function toggleTag(el) {
 el.classList.toggle('border-champagne');
 el.classList.toggle('text-champagne-dark');
 el.classList.toggle('bg-secondary/5');

 const tag = el.textContent.trim();
 const index = selectedTags.indexOf(tag);
 if (index === -1) {
 selectedTags.push(tag);
 } else {
 selectedTags.splice(index, 1);
 }
}

document.addEventListener('DOMContentLoaded', () => {
 gsap.from('.reveal-element', {
 opacity: 0,
 y: 30,
 duration: 1,
 ease: 'power4.out'
 });

 const stars = document.querySelectorAll('.star-btn');
 stars.forEach((btn, index) => {
 btn.addEventListener('click', () => {
 currentRating = index + 1;
 stars.forEach((s, i) => {
 const icon = s.querySelector('.material-symbols-outlined');
 icon.style.fontVariationSettings = "'FILL' " + (i <= index ? "1" : "0");
 icon.classList.toggle('text-champagne-dark', i <= index);
 icon.classList.toggle('text-muted-light', i > index);
 });
 document.getElementById('survey-progress').style.width = '66%';
 });
 });

 document.getElementById('survey-form').addEventListener('submit', async (e) => {
 e.preventDefault();

 if (currentRating === 0) {
 alert('Please select a rating before submitting.');
 return;
 }

 const btn = document.getElementById('submit-btn');
 btn.disabled = true;
 btn.innerHTML = '<span class="material-symbols-outlined animate-spin">sync</span> Submitting...';

 const deliveryId = <?= $deliveryId ?? 'null' ?>;
 const comments = document.getElementById('comments').value;

 try {
 const response = await fetch('api/logistics/survey.php', {
 method: 'POST',
 headers: { 'Content-Type': 'application/json' },
 body: JSON.stringify({
 delivery_id: deliveryId,
 rating: currentRating,
 comments: comments,
 tags: selectedTags
 })
 });

 const result = await response.json();
 if (result.success) {
 document.getElementById('survey-progress').style.width = '100%';
 setTimeout(() => {
 window.location.href = '<?= baseUrl('/dashboard') ?>?msg=feedback_submitted';
 }, 1000);
 } else {
 alert(result.error || 'Failed to submit feedback.');
 btn.disabled = false;
 btn.innerHTML = 'Submit Feedback';
 }
 } catch (e) {
 console.error(e);
 alert('An unexpected error occurred.');
 btn.disabled = false;
 btn.innerHTML = 'Submit Feedback';
 }
 });
});
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>