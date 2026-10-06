/**
 * Site-wide motion: scroll progress bar, sticky nav state, count-up numbers,
 * pointer tilt on cards and light parallax. All of it backs off when the
 * visitor prefers reduced motion.
 */
const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/* Scroll progress + nav state */
const progress = document.createElement('div');
progress.id = 'pg-progress';
document.body.appendChild(progress);

const nav = document.querySelector('[data-site-nav]');
const parallax = reduce ? [] : Array.from(document.querySelectorAll('[data-parallax]'));
let ticking = false;

const onScroll = () => {
    const max = document.documentElement.scrollHeight - window.innerHeight;
    progress.style.setProperty('--pg-progress', max > 0 ? (window.scrollY / max).toFixed(4) : 0);
    nav?.classList.toggle('is-scrolled', window.scrollY > 40);
    parallax.forEach((el) => {
        const speed = Number(el.dataset.parallax || 0.15);
        el.style.transform = `translate3d(0, ${window.scrollY * speed}px, 0)`;
    });
    ticking = false;
};

window.addEventListener('scroll', () => {
    if (!ticking) {
        ticking = true;
        requestAnimationFrame(onScroll);
    }
}, { passive: true });
onScroll();

/* Count-up: <span data-count="1200" data-suffix="+">0</span> */
const counters = document.querySelectorAll('[data-count]');
const runCounter = (el) => {
    const target = Number(el.dataset.count);
    const suffix = el.dataset.suffix || '';
    const decimals = Number(el.dataset.decimals || 0);
    if (reduce) {
        el.textContent = target.toFixed(decimals) + suffix;
        return;
    }
    const start = performance.now();
    const duration = 1600;
    const step = (now) => {
        const t = Math.min(1, (now - start) / duration);
        const eased = 1 - Math.pow(1 - t, 4);
        el.textContent = (target * eased).toLocaleString('en-US', { minimumFractionDigits: decimals, maximumFractionDigits: decimals }) + suffix;
        if (t < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
};

if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                runCounter(entry.target);
                io.unobserve(entry.target);
            }
        });
    }, { threshold: 0.4 });
    counters.forEach((el) => io.observe(el));
} else {
    counters.forEach(runCounter);
}

/* Pointer tilt for [data-tilt] cards (desktop pointers only) */
if (!reduce && window.matchMedia('(hover: hover)').matches) {
    document.querySelectorAll('[data-tilt]').forEach((card) => {
        card.style.transition = 'transform 0.5s cubic-bezier(0.22, 1, 0.36, 1)';
        card.addEventListener('mousemove', (e) => {
            const r = card.getBoundingClientRect();
            const x = (e.clientX - r.left) / r.width - 0.5;
            const y = (e.clientY - r.top) / r.height - 0.5;
            card.style.transform = `perspective(900px) rotateY(${x * 6}deg) rotateX(${-y * 6}deg) translateY(-6px)`;
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = '';
        });
    });
}

/* Keep the active destination tab visible inside its horizontal scroller (mobile). */
document.querySelectorAll('.pg-loc-tab.is-active').forEach((tab) => {
    const scroller = tab.parentElement;
    if (scroller && scroller.scrollWidth > scroller.clientWidth) {
        scroller.scrollLeft = tab.offsetLeft - (scroller.clientWidth - tab.offsetWidth) / 2;
    }
});
