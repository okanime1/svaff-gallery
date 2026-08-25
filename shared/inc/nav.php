<?php
/**
 * SVAFF Global Navigation Component
 * Shared across all micro-sites via the svaff-shared symlink.
 *
 * Link strategy — SEAMLESS ECOSYSTEM (no target="_blank" between SVAFF micro-sites):
 *   - svaff.org pages          → absolute https://svaff.org/...
 *   - films.svaff.org          → absolute https://films.svaff.org/
 *   - boxoffice.svaff.org      → absolute https://boxoffice.svaff.org/
 *   - gallery.svaff.org        → absolute https://gallery.svaff.org/
 *   - External third-party     → absolute with target="_blank" rel="noopener"
 *
 * Usage — set $nav_active before including:
 *   $nav_active = 'about';
 */
declare(strict_types=1);

$nav_active = $nav_active ?? '';

$festival_keys   = ['about', 'films', 'gallery'];
$involved_keys   = ['volunteer', 'vendor', 'advertising', 'sponsor', 'donate', 'ubuntu-circles'];
$programs_keys   = ['annual-film-festival', 'african-cinema-cafe', 'africa-in-the-classroom'];
$festival_active = in_array($nav_active, $festival_keys, true);
$involved_active = in_array($nav_active, $involved_keys, true);
$programs_active = in_array($nav_active, $programs_keys, true);
?>
<a href="#main-content" class="skip-link">Skip to main content</a>

<nav class="svaff-nav" aria-label="Primary navigation">

    <!-- Logo → always svaff.org home -->
    <a href="https://svaff.org/" class="svaff-nav__logo" aria-label="SVAFF — Home">
        <img src="/assets/logos/svaff-logo-dark-bg.svg"
             alt="Silicon Valley African Film Festival"
             height="52" width="auto">
    </a>

    <!-- Mobile hamburger -->
    <button class="svaff-nav__toggle"
            aria-expanded="false"
            aria-controls="svaff-nav-links"
            aria-label="Open navigation menu">
        <span class="svaff-nav__bar"></span>
        <span class="svaff-nav__bar"></span>
        <span class="svaff-nav__bar"></span>
    </button>

    <!-- Nav links -->
    <ul class="svaff-nav__links" id="svaff-nav-links" role="list">

        <!-- Home -->
        <li class="svaff-nav__item">
            <a href="https://svaff.org/"
               class="svaff-nav__link<?= $nav_active === 'home' ? ' svaff-nav__link--active' : '' ?>"
               <?= $nav_active === 'home' ? 'aria-current="page"' : '' ?>>
                Home
            </a>
        </li>

        <!-- Festival dropdown -->
        <li class="svaff-nav__item svaff-nav__item--has-dropdown">
            <button class="svaff-nav__link svaff-nav__dropdown-toggle<?= $festival_active ? ' svaff-nav__link--active' : '' ?>"
                    aria-expanded="false"
                    aria-controls="dropdown-festival">
                Festival
                <svg class="svaff-nav__chevron" width="12" height="12" viewBox="0 0 12 12" aria-hidden="true" focusable="false">
                    <path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/>
                </svg>
            </button>
            <ul class="svaff-nav__dropdown" id="dropdown-festival" role="list">
                <li>
                    <a href="https://svaff.org/about"
                       class="svaff-nav__dropdown-link<?= $nav_active === 'about' ? ' svaff-nav__dropdown-link--active' : '' ?>">
                        About
                    </a>
                </li>
                <li>
                    <a href="https://films.svaff.org/"
                       class="svaff-nav__dropdown-link<?= $nav_active === 'films' ? ' svaff-nav__dropdown-link--active' : '' ?>">
                        Films
                    </a>
                </li>
                <li>
                    <a href="https://gallery.svaff.org/"
                       class="svaff-nav__dropdown-link<?= $nav_active === 'gallery' ? ' svaff-nav__dropdown-link--active' : '' ?>">
                        Gallery
                    </a>
                </li>
            </ul>
        </li>

        <!-- Get Involved dropdown -->
        <li class="svaff-nav__item svaff-nav__item--has-dropdown">
            <button class="svaff-nav__link svaff-nav__dropdown-toggle<?= $involved_active ? ' svaff-nav__link--active' : '' ?>"
                    aria-expanded="false"
                    aria-controls="dropdown-involved">
                Get Involved
                <svg class="svaff-nav__chevron" width="12" height="12" viewBox="0 0 12 12" aria-hidden="true" focusable="false">
                    <path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/>
                </svg>
            </button>
            <ul class="svaff-nav__dropdown" id="dropdown-involved" role="list">
                <li>
                    <a href="https://svaff.org/volunteer"
                       class="svaff-nav__dropdown-link<?= $nav_active === 'volunteer' ? ' svaff-nav__dropdown-link--active' : '' ?>">
                        Volunteer
                    </a>
                </li>
                <li>
                    <a href="https://svaff.org/vendors"
                       class="svaff-nav__dropdown-link<?= $nav_active === 'vendor' ? ' svaff-nav__dropdown-link--active' : '' ?>">
                        Vendor
                    </a>
                </li>
                <li>
                    <a href="https://svaff.org/advertising"
                       class="svaff-nav__dropdown-link<?= $nav_active === 'advertising' ? ' svaff-nav__dropdown-link--active' : '' ?>">
                        Advertising
                    </a>
                </li>
                <li>
                    <a href="https://svaff.org/sponsor"
                       class="svaff-nav__dropdown-link<?= $nav_active === 'sponsor' ? ' svaff-nav__dropdown-link--active' : '' ?>">
                        Sponsor
                    </a>
                </li>
                <li>
                    <a href="https://svaff.org/donate"
                       class="svaff-nav__dropdown-link<?= $nav_active === 'donate' ? ' svaff-nav__dropdown-link--active' : '' ?>">
                        Donate
                    </a>
                </li>
                <li>
                    <!-- circle.svaff.org is an external micro-site — opens in new tab -->
                    <a href="https://circle.svaff.org/"
                       class="svaff-nav__dropdown-link<?= $nav_active === 'ubuntu-circles' ? ' svaff-nav__dropdown-link--active' : '' ?>"
                       target="_blank" rel="noopener noreferrer">
                        Ubuntu Circles
                    </a>
                </li>
            </ul>
        </li>

        <!-- Programs dropdown -->
        <li class="svaff-nav__item svaff-nav__item--has-dropdown">
            <button class="svaff-nav__link svaff-nav__dropdown-toggle<?= $programs_active ? ' svaff-nav__link--active' : '' ?>"
                    aria-expanded="false"
                    aria-controls="dropdown-programs">
                Programs
                <svg class="svaff-nav__chevron" width="12" height="12" viewBox="0 0 12 12" aria-hidden="true" focusable="false">
                    <path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/>
                </svg>
            </button>
            <ul class="svaff-nav__dropdown" id="dropdown-programs" role="list">
                <li>
                    <a href="https://svaff.org/programs/annual-film-festival"
                       class="svaff-nav__dropdown-link<?= $nav_active === 'annual-film-festival' ? ' svaff-nav__dropdown-link--active' : '' ?>">
                        Annual Film Festival
                    </a>
                </li>
                <li>
                    <a href="https://svaff.org/programs/african-cinema-cafe"
                       class="svaff-nav__dropdown-link<?= $nav_active === 'african-cinema-cafe' ? ' svaff-nav__dropdown-link--active' : '' ?>">
                        African Cinema Café
                    </a>
                </li>
                <li>
                    <a href="https://svaff.org/programs/africa-in-the-classroom"
                       class="svaff-nav__dropdown-link<?= $nav_active === 'africa-in-the-classroom' ? ' svaff-nav__dropdown-link--active' : '' ?>">
                        Africa in the Classroom
                    </a>
                </li>
            </ul>
        </li>

        <!-- News -->
        <li class="svaff-nav__item">
            <a href="https://svaff.org/news"
               class="svaff-nav__link<?= $nav_active === 'news' ? ' svaff-nav__link--active' : '' ?>"
               <?= $nav_active === 'news' ? 'aria-current="page"' : '' ?>>
                News
            </a>
        </li>

        <!-- Tickets CTA — box office micro-site, same tab -->
        <li class="svaff-nav__item">
            <a href="https://boxoffice.svaff.org/"
               class="svaff-nav__link svaff-nav__link--cta">
                Tickets
            </a>
        </li>

    </ul>
</nav>

<script>
(function () {
    var toggle = document.querySelector('.svaff-nav__toggle');
    var links  = document.getElementById('svaff-nav-links');

    toggle && toggle.addEventListener('click', function () {
        var open = toggle.getAttribute('aria-expanded') === 'true';
        toggle.setAttribute('aria-expanded', String(!open));
        links && links.classList.toggle('svaff-nav__links--open', !open);
    });

    document.querySelectorAll('.svaff-nav__dropdown-toggle').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var open   = btn.getAttribute('aria-expanded') === 'true';
            var dropId = btn.getAttribute('aria-controls');
            var drop   = document.getElementById(dropId);
            document.querySelectorAll('.svaff-nav__dropdown-toggle').forEach(function (b) {
                if (b !== btn) {
                    b.setAttribute('aria-expanded', 'false');
                    var d = document.getElementById(b.getAttribute('aria-controls'));
                    d && d.classList.remove('svaff-nav__dropdown--open');
                }
            });
            btn.setAttribute('aria-expanded', String(!open));
            drop && drop.classList.toggle('svaff-nav__dropdown--open', !open);
        });
    });

    document.addEventListener('click', function () {
        document.querySelectorAll('.svaff-nav__dropdown-toggle').forEach(function (b) {
            b.setAttribute('aria-expanded', 'false');
            var d = document.getElementById(b.getAttribute('aria-controls'));
            d && d.classList.remove('svaff-nav__dropdown--open');
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        document.querySelectorAll('.svaff-nav__dropdown-toggle').forEach(function (b) {
            b.setAttribute('aria-expanded', 'false');
            var d = document.getElementById(b.getAttribute('aria-controls'));
            d && d.classList.remove('svaff-nav__dropdown--open');
        });
        if (toggle) toggle.setAttribute('aria-expanded', 'false');
        if (links)  links.classList.remove('svaff-nav__links--open');
    });
})();
</script>
