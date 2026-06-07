/* =============================================================================
   RentEase Theme JS
   - GSAP/Lenis smooth scroll + reveals + parallax
   - Scroll progress bar
   - Scroll-to-top button
   - Toast notification system  (window.RentEase.toast)
   - Cookie consent banner
   - Search input wiring
   ============================================================================= */

(function () {
    'use strict';

    const RentEase = window.RentEase = window.RentEase || {};

    // -------------------------------------------------------------------------
    // 1. Toast Notification System
    //    Usage: RentEase.toast.show({ type, title, message, duration })
    // -------------------------------------------------------------------------
    const toastContainer = (() => {
        let c = document.querySelector('.toast-container');
        if (!c) {
            c = document.createElement('div');
            c.className = 'toast-container';
            c.setAttribute('aria-live', 'polite');
            c.setAttribute('aria-atomic', 'true');
            document.body.appendChild(c);
        }
        return c;
    })();

    const TOAST_ICONS = { success: 'check', error: 'error', info: 'info', warning: 'warning' };
    const TOAST_DEFAULT_TITLES = {
        success: 'Success',
        error: 'Something went wrong',
        info: 'Heads up',
        warning: 'Warning'
    };

    RentEase.toast = {
        show({ type = 'info', title, message = '', duration = 4200 } = {}) {
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.setAttribute('role', 'status');
            toast.innerHTML = `
                <div class="toast-icon">
                    <span class="material-symbols-outlined">${TOAST_ICONS[type] || 'info'}</span>
                </div>
                <div class="toast-content">
                    ${title ? `<div class="toast-title">${escapeHtml(title)}</div>` : ''}
                    ${message ? `<div class="toast-message">${escapeHtml(message)}</div>` : ''}
                </div>
                <button class="toast-close" aria-label="Dismiss">
                    <span class="material-symbols-outlined" style="font-size:18px;">close</span>
                </button>
            `;
            toastContainer.appendChild(toast);
            requestAnimationFrame(() => toast.classList.add('is-visible'));

            const dismiss = () => {
                toast.classList.remove('is-visible');
                setTimeout(() => toast.remove(), 400);
            };
            toast.querySelector('.toast-close').addEventListener('click', dismiss);
            if (duration > 0) setTimeout(dismiss, duration);
            return { dismiss };
        },
        success(m, t) { return this.show({ type: 'success', message: m, title: t }); },
        error(m, t)   { return this.show({ type: 'error', message: m, title: t, duration: 6000 }); },
        info(m, t)    { return this.show({ type: 'info', message: m, title: t }); },
        warning(m, t) { return this.show({ type: 'warning', message: m, title: t, duration: 5500 }); }
    };

    // -------------------------------------------------------------------------
    // 2. Scroll Progress + Scroll-to-Top
    // -------------------------------------------------------------------------
    function initScrollUtilities() {
        // Inject scroll progress
        let progress = document.querySelector('.scroll-progress');
        if (!progress) {
            progress = document.createElement('div');
            progress.className = 'scroll-progress';
            progress.innerHTML = '<div class="scroll-progress-bar"></div>';
            document.body.appendChild(progress);
        }
        const progressBar = progress.querySelector('.scroll-progress-bar');

        // Inject scroll-to-top button
        let topBtn = document.querySelector('.scroll-top-btn');
        if (!topBtn) {
            topBtn = document.createElement('button');
            topBtn.className = 'scroll-top-btn';
            topBtn.setAttribute('aria-label', 'Scroll to top');
            topBtn.innerHTML = '<span class="material-symbols-outlined">arrow_upward</span>';
            document.body.appendChild(topBtn);
            topBtn.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        const update = () => {
            const doc = document.documentElement;
            const scrolled = doc.scrollTop || document.body.scrollTop;
            const total = doc.scrollHeight - doc.clientHeight;
            const pct = total > 0 ? Math.min(100, (scrolled / total) * 100) : 0;
            progressBar.style.width = pct + '%';
            if (scrolled > 600) topBtn.classList.add('is-visible');
            else topBtn.classList.remove('is-visible');
        };
        window.addEventListener('scroll', update, { passive: true });
        update();
    }

    // -------------------------------------------------------------------------
    // 3. Cookie Consent Banner
    // -------------------------------------------------------------------------
    function initCookieBanner() {
        if (localStorage.getItem('re_cookie_consent')) return;

        const banner = document.createElement('div');
        banner.className = 'cookie-banner';
        banner.setAttribute('role', 'dialog');
        banner.setAttribute('aria-label', 'Cookie consent');
        banner.innerHTML = `
            <div class="cookie-icon">
                <span class="material-symbols-outlined">cookie</span>
            </div>
            <div class="cookie-content">
                <div class="cookie-title">We use cookies</div>
                <div class="cookie-text">Essential for the cart, login session, and analytics. By continuing, you accept our <a href="/privacy" style="color:var(--re-accent-dark);text-decoration:underline;">privacy policy</a>.</div>
            </div>
            <div class="cookie-actions">
                <button class="btn-pill btn-pill-sm btn-pill-ghost" data-cookie="decline">Decline</button>
                <button class="btn-pill btn-pill-sm" data-cookie="accept">Accept</button>
            </div>
        `;
        document.body.appendChild(banner);

        const dismiss = (value) => {
            localStorage.setItem('re_cookie_consent', value);
            banner.classList.remove('is-visible');
            setTimeout(() => banner.remove(), 500);
        };
        banner.querySelector('[data-cookie="accept"]').addEventListener('click', () => dismiss('accepted'));
        banner.querySelector('[data-cookie="decline"]').addEventListener('click', () => dismiss('declined'));

        setTimeout(() => banner.classList.add('is-visible'), 1500);
    }

    // -------------------------------------------------------------------------
    // 4. Search Input Wiring (header)
    // -------------------------------------------------------------------------
    function initSearch() {
        const input = document.querySelector('input[aria-label="Search products"]');
        if (!input) return;
        const form = input.closest('form') || input.parentElement;
        let timer = null;

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                const q = input.value.trim();
                if (q.length === 0) return;
                window.location.href = (window.baseUrl ? window.baseUrl('/shop') : '/shop') + '?search=' + encodeURIComponent(q);
            }
        });
        input.addEventListener('input', () => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                // hook for live search dropdown if/when API supports it
            }, 250);
        });
    }

    // -------------------------------------------------------------------------
    // 5. Form Enhancements — auto wire error states
    // -------------------------------------------------------------------------
    function enhanceForms() {
        // Required-field highlight on submit
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', (e) => {
                let firstInvalid = null;
                form.querySelectorAll('[required]').forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-error');
                        if (!firstInvalid) firstInvalid = field;
                    } else {
                        field.classList.remove('is-error');
                    }
                });
                if (firstInvalid) {
                    e.preventDefault();
                    firstInvalid.focus();
                }
            });
            form.querySelectorAll('.form-input, .form-select, .form-textarea').forEach(field => {
                field.addEventListener('input', () => field.classList.remove('is-error'));
            });
        });
    }

    // -------------------------------------------------------------------------
    // 6. Lenis smooth scroll + GSAP reveals + parallax
    // -------------------------------------------------------------------------
    function initAiryUX() {
        if (window.gsap && window.ScrollTrigger && window.Lenis) {
            gsap.registerPlugin(ScrollTrigger);

            const lenis = new Lenis({
                duration: 1.2,
                easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
                smooth: true,
            });
            lenis.on('scroll', ScrollTrigger.update);
            gsap.ticker.add((time) => { lenis.raf(time * 1000); });
            gsap.ticker.lagSmoothing(0, 0);
            window.RentEase.lenis = lenis;
        }

        if (window.gsap && window.ScrollTrigger) {
            // Text reveals (slide up from below)
            gsap.utils.toArray('.reveal-text').forEach(text => {
                gsap.to(text, {
                    y: '0%',
                    duration: 1.2,
                    ease: 'power4.out',
                    scrollTrigger: {
                        trigger: text.parentElement,
                        start: 'top 90%'
                    }
                });
            });

            // Simple fade reveals
            gsap.utils.toArray('.reveal-fade').forEach(el => {
                gsap.fromTo(el,
                    { opacity: 0, y: 30 },
                    {
                        opacity: 1, y: 0, duration: 1, ease: 'power3.out',
                        scrollTrigger: { trigger: el, start: 'top 90%' }
                    }
                );
            });

            // Slide-in-from-left
            gsap.utils.toArray('.reveal-slide-left').forEach(el => {
                gsap.fromTo(el,
                    { opacity: 0, x: -40 },
                    {
                        opacity: 1, x: 0, duration: 1, ease: 'power3.out',
                        scrollTrigger: { trigger: el, start: 'top 88%' }
                    }
                );
            });

            // Slide-in-from-right
            gsap.utils.toArray('.reveal-slide-right').forEach(el => {
                gsap.fromTo(el,
                    { opacity: 0, x: 40 },
                    {
                        opacity: 1, x: 0, duration: 1, ease: 'power3.out',
                        scrollTrigger: { trigger: el, start: 'top 88%' }
                    }
                );
            });

            // Scale-up
            gsap.utils.toArray('.reveal-scale').forEach(el => {
                gsap.fromTo(el,
                    { opacity: 0, scale: 0.92 },
                    {
                        opacity: 1, scale: 1, duration: 0.9, ease: 'power3.out',
                        scrollTrigger: { trigger: el, start: 'top 88%' }
                    }
                );
            });

            // Image parallax
            gsap.utils.toArray('.parallax-img').forEach(img => {
                gsap.to(img, {
                    y: '10%',
                    ease: 'none',
                    scrollTrigger: {
                        trigger: img.parentElement,
                        start: 'top bottom',
                        end: 'bottom top',
                        scrub: true
                    }
                });
            });
        }
    }

    // -------------------------------------------------------------------------
    // Utilities
    // -------------------------------------------------------------------------
    function escapeHtml(s) {
        return String(s)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    // -------------------------------------------------------------------------
    // Boot
    // -------------------------------------------------------------------------
    function boot() {
        initScrollUtilities();
        initSearch();
        enhanceForms();
        initCookieBanner();

        // GSAP/Lenis are optional — try to init, retry until loaded
        const tryInit = () => {
            if (window.gsap && window.ScrollTrigger) {
                initAiryUX();
                return true;
            }
            return false;
        };
        if (!tryInit()) {
            const i = setInterval(() => { if (tryInit()) clearInterval(i); }, 80);
            setTimeout(() => clearInterval(i), 5000);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
