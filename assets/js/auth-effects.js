/* =============================================================================
   RentEase Auth Effects
   - Cinematic background: Ken Burns + film grain + vignette + particles
   - Mouse parallax on background + cursor glow
   - 3D tilt on glass form card
   - Word-by-word headline reveal
   - Number counter for stats
   - Password strength meter
   - Form field focus animations
   - Submit button loading state
   - Respects prefers-reduced-motion
   ============================================================================= */

(function () {
    'use strict';

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const isMobile = window.matchMedia('(max-width: 1023px)').matches;
    const isTouchOnly = window.matchMedia('(hover: none)').matches;

    // ------------------------------------------------------------------
    // 1. Cinematic background — slow Ken Burns zoom + parallax on mouse
    // ------------------------------------------------------------------
    function initCinematicBackground() {
        const img = document.querySelector('.cinematic-bg');
        if (!img) return;

        if (!prefersReducedMotion) {
            // Ken Burns: slow zoom + drift over 40s
            img.style.animation = 'ken-burns 40s ease-in-out infinite alternate';
        }

        if (!isTouchOnly && !isMobile) {
            const wrap = img.parentElement;
            let targetX = 0, targetY = 0, currentX = 0, currentY = 0;
            wrap.addEventListener('mousemove', (e) => {
                const rect = wrap.getBoundingClientRect();
                targetX = ((e.clientX - rect.left) / rect.width - 0.5) * 20;
                targetY = ((e.clientY - rect.top) / rect.height - 0.5) * 20;
            });
            wrap.addEventListener('mouseleave', () => { targetX = 0; targetY = 0; });

            const animate = () => {
                currentX += (targetX - currentX) * 0.06;
                currentY += (targetY - currentY) * 0.06;
                img.style.transform = `scale(1.08) translate(${currentX}px, ${currentY}px)`;
                requestAnimationFrame(animate);
            };
            animate();
        }
    }

    // ------------------------------------------------------------------
    // 2. Floating particles (dust motes)
    // ------------------------------------------------------------------
    function initParticles() {
        if (prefersReducedMotion) return;
        const container = document.querySelector('.particles');
        if (!container) return;
        const count = isMobile ? 12 : 28;
        const fragment = document.createDocumentFragment();

        for (let i = 0; i < count; i++) {
            const p = document.createElement('span');
            p.className = 'particle';
            const size = 2 + Math.random() * 4;
            p.style.width = size + 'px';
            p.style.height = size + 'px';
            p.style.left = (Math.random() * 100) + '%';
            p.style.animationDuration = (15 + Math.random() * 25) + 's';
            p.style.animationDelay = (-Math.random() * 30) + 's';
            p.style.opacity = (0.3 + Math.random() * 0.5).toFixed(2);
            fragment.appendChild(p);
        }
        container.appendChild(fragment);
    }

    // ------------------------------------------------------------------
    // 3. Cursor glow — soft radial gradient following the mouse
    // ------------------------------------------------------------------
    function initCursorGlow() {
        if (isTouchOnly || isMobile) return;
        const glow = document.createElement('div');
        glow.className = 'cursor-glow';
        document.body.appendChild(glow);

        let x = -500, y = -500, tx = -500, ty = -500;
        document.addEventListener('mousemove', (e) => { tx = e.clientX; ty = e.clientY; });
        const animate = () => {
            x += (tx - x) * 0.12;
            y += (ty - y) * 0.12;
            glow.style.transform = `translate(${x}px, ${y}px) translate(-50%, -50%)`;
            requestAnimationFrame(animate);
        };
        animate();
    }

    // ------------------------------------------------------------------
    // 4. 3D tilt on the glass form card
    // ------------------------------------------------------------------
    function initTilt() {
        if (prefersReducedMotion || isTouchOnly) return;
        const card = document.querySelector('.tilt-card');
        if (!card) return;

        const wrap = card.parentElement;
        let rect = card.getBoundingClientRect();
        const updateRect = () => { rect = card.getBoundingClientRect(); };
        window.addEventListener('resize', updateRect);
        window.addEventListener('scroll', updateRect, { passive: true });

        wrap.addEventListener('mousemove', (e) => {
            const x = (e.clientX - rect.left) / rect.width - 0.5;
            const y = (e.clientY - rect.top) / rect.height - 0.5;
            card.style.transform = `perspective(1200px) rotateY(${x * 4}deg) rotateX(${-y * 4}deg) translateZ(0)`;
            // Move the card's internal highlight
            const highlight = card.querySelector('.card-highlight');
            if (highlight) {
                highlight.style.background = `radial-gradient(circle at ${(x + 0.5) * 100}% ${(y + 0.5) * 100}%, rgba(255,255,255,0.15) 0%, transparent 50%)`;
            }
        });
        wrap.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1200px) rotateY(0deg) rotateX(0deg) translateZ(0)';
        });
    }

    // ------------------------------------------------------------------
    // 5. Word-by-word headline reveal
    // ------------------------------------------------------------------
    function initWordReveal() {
        if (prefersReducedMotion) {
            document.querySelectorAll('.word-reveal').forEach(el => {
                el.style.opacity = '1';
                el.style.transform = 'none';
            });
            return;
        }
        document.querySelectorAll('.word-reveal').forEach(el => {
            const text = el.textContent.trim();
            el.textContent = '';
            const words = text.split(/\s+/);
            words.forEach((word, i) => {
                const span = document.createElement('span');
                span.className = 'word';
                span.textContent = word + (i < words.length - 1 ? ' ' : '');
                span.style.animationDelay = (i * 0.08) + 's';
                el.appendChild(span);
            });
        });
    }

    // ------------------------------------------------------------------
    // 6. Number counter animation
    // ------------------------------------------------------------------
    function initCounters() {
        if (prefersReducedMotion) return;
        const counters = document.querySelectorAll('[data-counter]');
        if (counters.length === 0) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                const el = entry.target;
                const target = parseFloat(el.dataset.counter);
                const suffix = el.dataset.suffix || '';
                const duration = 1800;
                const start = performance.now();
                const animate = (now) => {
                    const elapsed = now - start;
                    const progress = Math.min(elapsed / duration, 1);
                    // ease-out cubic
                    const eased = 1 - Math.pow(1 - progress, 3);
                    const value = target * eased;
                    el.textContent = (target % 1 === 0 ? Math.floor(value) : value.toFixed(1)) + suffix;
                    if (progress < 1) requestAnimationFrame(animate);
                };
                requestAnimationFrame(animate);
                observer.unobserve(el);
            });
        }, { threshold: 0.5 });

        counters.forEach(c => observer.observe(c));
    }

    // ------------------------------------------------------------------
    // 7. Form field focus: animated border draw + label float
    // ------------------------------------------------------------------
    function initFormFields() {
        document.querySelectorAll('.auth-field').forEach(field => {
            const input = field.querySelector('.auth-input');
            if (!input) return;
            input.addEventListener('focus', () => field.classList.add('is-focused'));
            input.addEventListener('blur', () => {
                field.classList.remove('is-focused');
                if (input.value.trim()) field.classList.add('has-value');
                else field.classList.remove('has-value');
            });
            // initial state
            if (input.value.trim()) field.classList.add('has-value');
        });
    }

    // ------------------------------------------------------------------
    // 8. Submit button loading state + page transition
    // ------------------------------------------------------------------
    function initSubmitAnimation() {
        document.querySelectorAll('form[data-cinematic-submit]').forEach(form => {
            form.addEventListener('submit', (e) => {
                const btn = form.querySelector('[type="submit"]');
                if (!btn) return;
                // Only animate if form is valid
                if (!form.checkValidity()) return;
                e.preventDefault();
                btn.classList.add('is-loading');
                btn.disabled = true;
                // Trigger cinematic zoom on the background
                document.body.classList.add('is-submitting');
                // Submit after a short delay for the animation to play
                setTimeout(() => form.submit(), 700);
            });
        });
    }

    // ------------------------------------------------------------------
    // 9. Boot
    // ------------------------------------------------------------------
    function boot() {
        initCinematicBackground();
        initParticles();
        initCursorGlow();
        initTilt();
        initWordReveal();
        initCounters();
        initFormFields();
        initSubmitAnimation();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
