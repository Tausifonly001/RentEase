/**
 * RentEase — Shared GSAP Animation Utilities
 * Luxury cinematic motion library
 */

window.RentEase = window.RentEase || {};

(function() {
    'use strict';

    const RE = window.RentEase;

    // === Toast System ===
    RE.toast = {
        show: function(title, message, type) {
            type = type || 'success';
            const container = document.getElementById('toast-container') || (function() {
                const el = document.createElement('div');
                el.id = 'toast-container';
                el.className = 'toast-container';
                document.body.appendChild(el);
                return el;
            })();

            const toast = document.createElement('div');
            toast.className = 'toast toast-' + type;
            toast.innerHTML = `
                <div class="toast-icon">
                    <span class="material-symbols-outlined">${type === 'success' ? 'check' : type === 'error' ? 'close' : type === 'warning' ? 'warning' : 'info'}</span>
                </div>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    ${message ? '<div class="toast-message">' + message + '</div>' : ''}
                </div>
                <button class="toast-close" onclick="this.closest('.toast').classList.remove('is-visible'); setTimeout(() => this.closest('.toast').remove(), 300);">
                    <span class="material-symbols-outlined" style="font-size:18px;">close</span>
                </button>
            `;

            container.appendChild(toast);
            requestAnimationFrame(() => toast.classList.add('is-visible'));

            setTimeout(() => {
                toast.classList.remove('is-visible');
                setTimeout(() => toast.remove(), 400);
            }, 4000);
        },

        success: function(title, message) { this.show(title, message, 'success'); },
        error: function(title, message) { this.show(title, message, 'error'); },
        info: function(title, message) { this.show(title, message, 'info'); },
        warning: function(title, message) { this.show(title, message, 'warning'); }
    };

    // === GSAP Boot (Promise-based, no polling) ===
    RE.gsapReady = new Promise(function(resolve) {
        if (window.gsap) return resolve(window.gsap);
        Object.defineProperty(window, 'gsap', {
            configurable: true,
            set: function(v) { resolve(v); Object.defineProperty(window, 'gsap', { value: v, writable: true }); },
            get: function() { return undefined; }
        });
        setTimeout(function() {
            // fallback after 5s: make all hidden elements visible
            document.querySelectorAll('.text-mask-inner').forEach(function(el) { el.style.transform = 'translateY(0)'; });
            document.querySelectorAll('[class*="reveal-"], .gsap-fade, .gsap-fade-up').forEach(function(el) { el.style.opacity = '1'; el.style.transform = 'none'; });
            document.querySelectorAll('.clip-reveal').forEach(function(el) { el.style.clipPath = 'inset(0 0% 0 0)'; });
            resolve(null);
        }, 5000);
    });

    // === Text Mask Reveal ===
    RE.revealTextMasks = function(gsap, container, options) {
        options = options || {};
        const selector = options.selector || '.text-mask-inner';
        const targets = (container || document).querySelectorAll(selector);
        if (targets.length === 0) return gsap.timeline();

        return gsap.to(targets, {
            y: '0%',
            duration: options.duration || 1.2,
            ease: options.ease || 'power4.out',
            stagger: options.stagger || 0.15
        });
    };

    // === Curtain Reveal ===
    RE.curtainReveal = function(gsap, el, options) {
        options = options || {};
        if (!el) return gsap.timeline();
        return gsap.to(el, {
            clipPath: options.direction === 'left' ? 'inset(0 0 0 100%)' : 'inset(0 0 0 100%)',
            duration: options.duration || 1.5,
            ease: options.ease || 'power4.inOut'
        });
    };

    // === Scale In ===
    RE.scaleIn = function(gsap, el, options) {
        options = options || {};
        if (!el) return gsap.timeline();
        return gsap.to(el, {
            scale: 1,
            duration: options.duration || 2.5,
            ease: options.ease || 'power2.out'
        });
    };

    // === Fade Up ===
    RE.fadeUp = function(gsap, targets, options) {
        options = options || {};
        return gsap.to(targets, {
            y: 0,
            opacity: 1,
            duration: options.duration || 1,
            stagger: options.stagger || 0.1,
            ease: options.ease || 'power3.out',
            clearProps: 'transform'
        });
    };

    // === Scroll Reveal ===
    RE.scrollReveal = function(gsap, targets, options) {
        options = options || {};
        if (!window.ScrollTrigger) return;
        gsap.registerPlugin(ScrollTrigger);

        if (targets instanceof Element || targets instanceof NodeList || Array.isArray(targets)) {
            gsap.utils.toArray(targets).forEach(function(el) {
                gsap.from(el, {
                    scrollTrigger: {
                        trigger: el,
                        start: options.start || 'top 85%'
                    },
                    y: options.y || 40,
                    opacity: 0,
                    duration: options.duration || 1.2,
                    ease: options.ease || 'power3.out',
                    stagger: options.stagger || 0
                });
            });
        }
    };

    // === Parallax Init ===
    RE.parallaxInit = function(gsap) {
        if (!window.ScrollTrigger) return;
        gsap.registerPlugin(ScrollTrigger);

        document.querySelectorAll('.parallax-section').forEach(function(section) {
            const img = section.querySelector('img');
            if (!img) return;
            gsap.fromTo(img, {
                y: '-10%',
                scale: 1.1
            }, {
                y: '10%',
                scale: 1,
                ease: 'none',
                scrollTrigger: {
                    trigger: section,
                    scrub: true,
                    start: 'top bottom',
                    end: 'bottom top'
                }
            });
        });
    };

    // === Mobile Nav ===
    RE.initMobileNav = function() {
        const btn = document.getElementById('mobile-menu-btn');
        const nav = document.getElementById('mobile-nav');
        const overlay = document.getElementById('mobile-overlay');

        if (btn && nav) {
            btn.addEventListener('click', function() {
                const isOpen = nav.classList.contains('flex');
                nav.classList.toggle('hidden');
                nav.classList.toggle('flex');
                if (overlay) overlay.classList.toggle('hidden');
                document.body.style.overflow = isOpen ? '' : 'hidden';

                const icon = btn.querySelector('.material-symbols-outlined');
                if (icon) icon.textContent = isOpen ? 'menu' : 'close';
            });
        }
    };

    // === Scroll Progress ===
    RE.initScrollProgress = function() {
        const bar = document.getElementById('scroll-progress-bar');
        if (!bar) return;

        window.addEventListener('scroll', function() {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const scrollPercent = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
            bar.style.width = scrollPercent + '%';
        });
    };

    // === Navbar Hide/Show on Scroll ===
    RE.initNavScroll = function() {
        const nav = document.getElementById('main-nav');
        if (!nav) return;

        let lastScroll = 0;
        window.addEventListener('scroll', function() {
            const currentScroll = window.scrollY;
            if (currentScroll > 120) {
                if (currentScroll > lastScroll) {
                    nav.style.transform = 'translateY(-100%)';
                } else {
                    nav.style.transform = 'translateY(0)';
                }
            } else {
                nav.style.transform = 'translateY(0)';
            }
            lastScroll = currentScroll;
        }, { passive: true });
    };

    // === Image Error Fallback ===
    RE.initImageFallbacks = function() {
        document.querySelectorAll('img').forEach(function(img) {
            img.addEventListener('error', function() {
                this.src = 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&q=80&w=600';
                this.style.opacity = '0.8';
            });
        });
    };

    // === Lazy Load with IntersectionObserver ===
    RE.initLazyLoad = function() {
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                        }
                        observer.unobserve(img);
                    }
                });
            }, { rootMargin: '200px' });

            document.querySelectorAll('img[data-src]').forEach(function(img) {
                observer.observe(img);
            });
        }
    };

    // === Init on DOM Ready ===
    document.addEventListener('DOMContentLoaded', function() {
        RE.initMobileNav();
        RE.initImageFallbacks();
        RE.initLazyLoad();
    });

})();
