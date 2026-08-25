<?php
/**
 * SVAFF Global Footer Component
 * Shared across all micro-sites via the svaff-shared symlink.
 *
 * Link strategy — SEAMLESS ECOSYSTEM (no target="_blank" between SVAFF micro-sites):
 *   - svaff.org pages          → absolute https://svaff.org/...
 *   - Other SVAFF micro-sites  → absolute, same tab
 *   - External third-party     → absolute with target="_blank" rel="noopener"
 */
declare(strict_types=1);

$current_year = date('Y');
?>
<footer class="svaff-footer" aria-label="Site footer">
    <div class="svaff-footer__inner">
        <div class="svaff-footer__brand">
            <a href="https://svaff.org/" aria-label="SVAFF Home">
                <img
                    src="/assets/logos/svaff-logo-dark-bg.svg"
                    alt="Silicon Valley African Film Festival"
                    height="32"
                    width="auto"
                >
            </a>
            <p class="svaff-footer__tagline">
                Experience Africa through the African lens.
            </p>
        </div>

        <nav class="svaff-footer__links" aria-label="Footer navigation">
            <a href="https://svaff.org/about"        class="svaff-footer__link">About</a>
            <a href="https://films.svaff.org/"        class="svaff-footer__link">Films</a>
            <a href="https://boxoffice.svaff.org/"    class="svaff-footer__link">Box Office</a>
            <a href="https://gallery.svaff.org/"      class="svaff-footer__link">Gallery</a>
            <a href="https://svaff.org/news"          class="svaff-footer__link">News</a>
            <a href="https://svaff.org/volunteer"     class="svaff-footer__link">Volunteer</a>
            <a href="https://svaff.org/vendors"       class="svaff-footer__link">Vendor</a>
            <a href="https://svaff.org/donate"        class="svaff-footer__link">Donate</a>
            <a href="https://svaff.org/sponsor"       class="svaff-footer__link">Sponsor</a>
            <a href="https://circle.svaff.org/"       class="svaff-footer__link" target="_blank" rel="noopener noreferrer">Ubuntu Circles</a>
            <a href="https://svaff.org/contact"       class="svaff-footer__link">Contact</a>
        </nav>
    </div>

    <div class="svaff-footer__bottom">
        <p class="svaff-footer__copy">
            &copy; <?= $current_year ?> Silicon Valley African Film Festival. All rights reserved.
        </p>
        <p class="svaff-footer__copy">
            17th Annual Celebration &mdash; October 8&ndash;11, 2026
        </p>
    </div>
</footer>
<script src="/assets/js/motion.js" defer></script>
