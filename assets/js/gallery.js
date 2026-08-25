/**
 * gallery.svaff.org — Gallery JS
 * Handles: lightbox open/close/nav, keyboard, touch swipe,
 *          intersection-observer lazy loading for home cards + collection grids.
 */
(function () {
    'use strict';

    // ---- IntersectionObserver lazy loading ----
    // Targets both .gallery-card__thumb img (home) and .col-thumb img.lazy (collection)
    function initLazyLoad() {
        if (!('IntersectionObserver' in window)) {
            // Fallback: load all immediately
            document.querySelectorAll('img[data-src]').forEach(function (img) {
                img.src = img.dataset.src;
                img.classList.remove('lazy');
            });
            return;
        }

        const obs = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    img.classList.remove('lazy');
                }
                obs.unobserve(img);
            });
        }, { rootMargin: '600px' });

        document.querySelectorAll('img[data-src]').forEach(function (img) {
            obs.observe(img);
        });
    }

    initLazyLoad();

    // ---- Lightbox (collection page only) ----
    const lb       = document.getElementById('lb');
    const lbImg    = document.getElementById('lb-img');
    const lbClose  = document.getElementById('lb-close');
    const lbPrev   = document.getElementById('lb-prev');
    const lbNext   = document.getElementById('lb-next');
    const lbCounter = document.getElementById('lb-counter');

    if (!lb || typeof GALLERY_IMAGES === 'undefined') return;

    let current = 0;
    let images  = GALLERY_IMAGES;
    let total   = images.length;
    let touchStartX = 0;

    function open(idx) {
        current = ((idx % total) + total) % total;
        lbImg.src = images[current];
        lbImg.alt = 'Photo ' + (current + 1) + ' of ' + total;
        lbCounter.textContent = (current + 1) + ' / ' + total;
        lb.hidden = false;
        lb.focus();
        document.body.style.overflow = 'hidden';
    }

    function close() {
        lb.hidden = true;
        lbImg.src = '';
        document.body.style.overflow = '';
    }

    function prev() { open(current - 1); }
    function next() { open(current + 1); }

    // Open on thumb click
    document.querySelectorAll('.col-thumb').forEach(function (btn) {
        btn.addEventListener('click', function () {
            open(parseInt(btn.dataset.index, 10));
        });
    });

    // Controls
    lbClose.addEventListener('click', close);
    lbPrev.addEventListener('click', prev);
    lbNext.addEventListener('click', next);

    // Click backdrop to close
    lb.addEventListener('click', function (e) {
        if (e.target === lb) close();
    });

    // Keyboard
    document.addEventListener('keydown', function (e) {
        if (lb.hidden) return;
        if (e.key === 'Escape')      close();
        if (e.key === 'ArrowLeft')   prev();
        if (e.key === 'ArrowRight')  next();
    });

    // Touch swipe
    lb.addEventListener('touchstart', function (e) {
        touchStartX = e.changedTouches[0].clientX;
    }, { passive: true });

    lb.addEventListener('touchend', function (e) {
        const dx = e.changedTouches[0].clientX - touchStartX;
        if (Math.abs(dx) > 50) {
            dx < 0 ? next() : prev();
        }
    }, { passive: true });

})();
