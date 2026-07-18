function initReveals() {
    const nodes = document.querySelectorAll<HTMLElement>('.reveal, .reveal-scale, .reveal-left');
    if (!nodes.length) return;

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        nodes.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.16, rootMargin: '0px 0px -8% 0px' }
    );

    nodes.forEach((el) => observer.observe(el));

    // Ensure above-the-fold content animates even if observer is delayed
    requestAnimationFrame(() => {
        nodes.forEach((el) => {
            const rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight * 0.92 && rect.bottom > 0) {
                el.classList.add('is-visible');
                observer.unobserve(el);
            }
        });
    });
}

function initHeader() {
    const header = document.getElementById('site-header');
    if (!header) return;

    const onScroll = () => {
        header.classList.toggle('is-scrolled', window.scrollY > 12);
    };

    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
}

function initMobileNav() {
    const toggle = document.getElementById('mobile-nav-toggle');
    const panel = document.getElementById('mobile-nav');
    if (!toggle || !panel) return;

    toggle.addEventListener('click', () => {
        const open = !panel.classList.contains('is-open');
        panel.classList.toggle('is-open', open);
        panel.toggleAttribute('hidden', !open);
        toggle.setAttribute('aria-expanded', String(open));
        toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
        document.body.style.overflow = open ? 'hidden' : '';
    });
}

function initCounters() {
    const counters = document.querySelectorAll<HTMLElement>('[data-counter]');
    if (!counters.length) return;

    const animate = (el: HTMLElement) => {
        const target = Number(el.dataset.counter || 0);
        const suffix = el.dataset.suffix || '';
        const duration = 1400;
        const start = performance.now();

        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            el.textContent = `${target}${suffix}`;
            return;
        }

        const tick = (now: number) => {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = `${Math.round(target * eased)}${suffix}`;
            if (progress < 1) requestAnimationFrame(tick);
        };

        requestAnimationFrame(tick);
    };

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animate(entry.target as HTMLElement);
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.4 }
    );

    counters.forEach((el) => observer.observe(el));
}

function initParallax() {
    const layers = document.querySelectorAll<HTMLElement>('[data-parallax]');
    if (!layers.length || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    let ticking = false;
    const update = () => {
        const y = window.scrollY;
        layers.forEach((layer) => {
            const speed = Number(layer.dataset.parallax || 0.2);
            layer.style.transform = `translate3d(0, ${y * speed}px, 0)`;
        });
        ticking = false;
    };

    window.addEventListener(
        'scroll',
        () => {
            if (!ticking) {
                requestAnimationFrame(update);
                ticking = true;
            }
        },
        { passive: true }
    );
}

function initCursorGlow() {
    const glow = document.getElementById('cursor-glow');
    if (!glow || window.matchMedia('(pointer: coarse)').matches) return;

    let visible = false;
    window.addEventListener(
        'pointermove',
        (e) => {
            glow.style.left = `${e.clientX}px`;
            glow.style.top = `${e.clientY}px`;
            if (!visible) {
                glow.style.opacity = '1';
                visible = true;
            }
        },
        { passive: true }
    );

    document.addEventListener('mouseleave', () => {
        glow.style.opacity = '0';
        visible = false;
    });
}

function init() {
    initReveals();
    initHeader();
    initMobileNav();
    initCounters();
    initParallax();
    initCursorGlow();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}
