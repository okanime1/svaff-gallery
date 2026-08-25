/**
 * gallery.svaff.org — Gallery JS
 * Handles: lightbox open/close/nav, keyboard, touch swipe.
 */
(function () {
    'use strict';

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
