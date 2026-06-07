document.addEventListener('DOMContentLoaded', () => {
    
    // Check for GSAP & Lenis
    const checkDeps = setInterval(() => {
        if (window.gsap && window.ScrollTrigger && window.Lenis) {
            clearInterval(checkDeps);
            gsap.registerPlugin(ScrollTrigger);
            initAiryUX();
        }
    }, 50);

    function initAiryUX() {
        
        // 1. Lenis Smooth Scrolling (Crucial for the airy, premium feel)
        const lenis = new Lenis({
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)), 
            smooth: true,
        });
        lenis.on('scroll', ScrollTrigger.update);
        gsap.ticker.add((time)=>{ lenis.raf(time * 1000) });
        gsap.ticker.lagSmoothing(0, 0);

        // 2. Global Text Reveal Animations (Slide Up)
        const revealTexts = document.querySelectorAll('.reveal-text');
        if (revealTexts.length > 0) {
            revealTexts.forEach(text => {
                gsap.to(text, {
                    y: "0%",
                    duration: 1.2,
                    ease: "power4.out",
                    scrollTrigger: {
                        trigger: text.parentElement,
                        start: "top 90%",
                    }
                });
            });
        }

        // 3. Global Simple Fade Reveals
        const fades = document.querySelectorAll('.reveal-fade');
        if (fades.length > 0) {
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

        // 4. Global Image Parallax
        const parallaxImgs = document.querySelectorAll('.parallax-img');
        if (parallaxImgs.length > 0) {
            parallaxImgs.forEach(img => {
                gsap.to(img, {
                    y: "10%",
                    ease: "none",
                    scrollTrigger: {
                        trigger: img.parentElement,
                        start: "top bottom",
                        end: "bottom top",
                        scrub: true
                    }
                });
            });
        }
    }
});
