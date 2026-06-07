/* =============================================================================
   RentEase Auth Effects — "The Aperture" concept
   - CSS-driven word reveal (no JS split)
   - Aperture: subtle scale breathing + light ray rotation
   - Form panel: gradient border orbit
   - Mouse parallax: CSS transition
   - Field focus: animated border + icon
   - Submit: stamp animation + cinematic zoom
   - "Live" counter tick
   ============================================================================= */

(function () {
    'use strict';

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const isMobile = window.matchMedia('(max-width: 1023px)').matches;
    const isTouchOnly = window.matchMedia('(hover: none)').matches;

    // 1. Mouse parallax on background (CSS transition)
    function initParallax() {
        if (prefersReducedMotion || isTouchOnly) return;
        const wrap = document.querySelector('.cinematic-wrap');
        const img = wrap && wrap.querySelector('.cinematic-bg');
        if (!img) return;
        img.style.transition = 'transform 0.7s cubic-bezier(0.16, 1, 0.3, 1)';

        let raf = null;
        wrap.addEventListener('mousemove', (e) => {
            if (raf) return;
            raf = requestAnimationFrame(() => {
                const rect = wrap.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width - 0.5) * 18;
                const y = ((e.clientY - rect.top) / rect.height - 0.5) * 12;
                img.style.transform = `scale(1.12) translate(${x}px, ${y}px)`;
                raf = null;
            });
        });
        wrap.addEventListener('mouseleave', () => {
            img.style.transform = 'scale(1.1) translate(0, 0)';
        });
    }

    // 2. Cursor glow (subtle, idle-stops)
    function initCursorGlow() {
        if (prefersReducedMotion || isTouchOnly || isMobile) return;
        const glow = document.createElement('div');
        glow.className = 'cursor-glow';
        document.body.appendChild(glow);
        let x = -500, y = -500, tx = -500, ty = -500;
        document.addEventListener('mousemove', (e) => { tx = e.clientX; ty = e.clientY; });
        const animate = () => {
            x += (tx - x) * 0.08;
            y += (ty - y) * 0.08;
            glow.style.transform = `translate(${x}px, ${y}px) translate(-50%, -50%)`;
            if (Math.abs(tx - x) > 0.5 || Math.abs(ty - y) > 0.5) requestAnimationFrame(animate);
        };
        animate();
    }

    // 3. Aperture light rays — slow rotation
    function initApertureRays() {
        if (prefersReducedMotion) return;
        const rays = document.querySelector('.aperture-rays');
        if (!rays) return;
    }

    // 4. Form field focus state
    function initFormFields() {
        document.querySelectorAll('.auth-field').forEach(field => {
            const input = field.querySelector('.auth-input');
            if (!input) return;
            input.addEventListener('focus', () => field.classList.add('is-focused'));
            input.addEventListener('blur', () => field.classList.remove('is-focused'));
        });
    }

    // 5. Submit — stamp animation, no artificial delay
    function initSubmit() {
        document.querySelectorAll('form[data-cinematic-submit]').forEach(form => {
            form.addEventListener('submit', (e) => {
                if (!form.checkValidity()) return;
                const btn = form.querySelector('[type="submit"]');
                if (!btn) return;
                btn.classList.add('is-loading');
                btn.disabled = true;
                document.body.classList.add('is-submitting');
            });
        });
    }

    // 6. Live counter tick (subtle)
    function initLiveTick() {
        const el = document.querySelector('[data-live-count]');
        if (!el) return;
        let count = parseInt(el.textContent.replace(/\D/g, ''), 10) || 2847;
        setInterval(() => {
            const delta = Math.floor(Math.random() * 3) - 1; // -1, 0, or +1
            count = Math.max(2700, Math.min(2999, count + delta));
            el.textContent = count.toLocaleString();
        }, 4000);
    }

    function boot() {
        initParallax();
        initCursorGlow();
        initApertureRays();
        initFormFields();
        initSubmit();
        initLiveTick();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
