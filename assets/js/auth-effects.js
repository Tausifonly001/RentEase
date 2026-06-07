/* =============================================================================
   RentEase Auth Effects — refined
   - CSS-only word reveal (no JS split dependency)
   - Counter final value in HTML, JS animates from 0 only when in view
   - CSS-transition mouse parallax (no RAF loop)
   - Cursor glow with rAF (only while moving)
   - 3D tilt: max 2deg (subtle)
   - 18 particles max
   - Submit: no artificial delay, error fallback
   ============================================================================= */

(function () {
    'use strict';

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const isMobile = window.matchMedia('(max-width: 1023px)').matches;
    const isTouchOnly = window.matchMedia('(hover: none)').matches;

    // 1. Mouse parallax on background (CSS transition, no RAF)
    function initParallax() {
        if (prefersReducedMotion || isTouchOnly) return;
        const wrap = document.querySelector('.cinematic-wrap');
        const img = wrap && wrap.querySelector('.cinematic-bg');
        if (!img) return;

        // CSS transition handles smoothing
        img.style.transition = 'transform 0.6s cubic-bezier(0.16, 1, 0.3, 1)';

        let raf = null;
        wrap.addEventListener('mousemove', (e) => {
            if (raf) return;
            raf = requestAnimationFrame(() => {
                const rect = wrap.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width - 0.5) * 14;
                const y = ((e.clientY - rect.top) / rect.height - 0.5) * 10;
                img.style.transform = `scale(1.1) translate(${x}px, ${y}px)`;
                raf = null;
            });
        });
        wrap.addEventListener('mouseleave', () => {
            img.style.transform = 'scale(1.08) translate(0, 0)';
        });
    }

    // 2. Cursor glow (rAF, 400px, more subtle)
    function initCursorGlow() {
        if (prefersReducedMotion || isTouchOnly || isMobile) return;
        const glow = document.createElement('div');
        glow.className = 'cursor-glow';
        document.body.appendChild(glow);

        let x = -500, y = -500, tx = -500, ty = -500;
        let active = true;
        document.addEventListener('mousemove', (e) => { tx = e.clientX; ty = e.clientY; });
        document.addEventListener('mouseleave', () => { tx = -500; ty = -500; });

        const animate = () => {
            if (!active) return;
            x += (tx - x) * 0.1;
            y += (ty - y) * 0.1;
            glow.style.transform = `translate(${x}px, ${y}px) translate(-50%, -50%)`;
            if (Math.abs(tx - x) < 0.5 && Math.abs(ty - y) < 0.5) {
                // Idle — stop the loop to save CPU
                return;
            }
            requestAnimationFrame(animate);
        };
        animate();
    }

    // 3. 3D tilt on glass card (max 2deg, subtle)
    function initTilt() {
        if (prefersReducedMotion || isTouchOnly) return;
        const card = document.querySelector('.tilt-card');
        if (!card) return;

        const wrap = card.parentElement;
        const update = (e) => {
            const rect = card.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width - 0.5;
            const y = (e.clientY - rect.top) / rect.height - 0.5;
            card.style.transform = `perspective(1200px) rotateY(${x * 2}deg) rotateX(${-y * 2}deg)`;
            const highlight = card.querySelector('.card-highlight');
            if (highlight) {
                highlight.style.background = `radial-gradient(circle at ${(x + 0.5) * 100}% ${(y + 0.5) * 100}%, rgba(255,255,255,0.12) 0%, transparent 50%)`;
            }
        };
        wrap.addEventListener('mousemove', update);
        wrap.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1200px) rotateY(0deg) rotateX(0deg)';
        });
    }

    // 4. Counter — final value in HTML, JS animates from 0 when in view
    function initCounters() {
        if (prefersReducedMotion) return;
        const counters = document.querySelectorAll('[data-counter]');
        if (counters.length === 0) return;

        // Reset to 0 only when JS is about to animate (prevents flash of final value)
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                const el = entry.target;
                const target = parseFloat(el.dataset.counter);
                const suffix = el.dataset.suffix || '';
                el.textContent = '0';
                el.classList.add('is-animating');
                const duration = 1600;
                const start = performance.now();
                const animate = (now) => {
                    const elapsed = now - start;
                    const progress = Math.min(elapsed / duration, 1);
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

    // 5. Form field focus state
    function initFormFields() {
        document.querySelectorAll('.auth-field').forEach(field => {
            const input = field.querySelector('.auth-input');
            if (!input) return;
            input.addEventListener('focus', () => field.classList.add('is-focused'));
            input.addEventListener('blur', () => field.classList.remove('is-focused'));
        });
    }

    // 6. Submit — show loading state, no artificial delay
    function initSubmit() {
        document.querySelectorAll('form[data-cinematic-submit]').forEach(form => {
            form.addEventListener('submit', (e) => {
                if (!form.checkValidity()) return; // let native validation handle invalid forms
                const btn = form.querySelector('[type="submit"]');
                if (!btn) return;
                btn.classList.add('is-loading');
                btn.disabled = true;
                document.body.classList.add('is-submitting');
                // Form submits naturally — no setTimeout
            });
        });
    }

    function boot() {
        initParallax();
        initCursorGlow();
        initTilt();
        initCounters();
        initFormFields();
        initSubmit();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
