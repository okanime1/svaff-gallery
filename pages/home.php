<?php
/**
 * gallery.svaff.org — Home Page
 * Browse by year → photographer → collection
 */
declare(strict_types=1);

$gallery = gallery_scan_all();

$page_title       = 'Gallery — Silicon Valley African Film Festival';
$page_description = 'Official photo gallery of the Silicon Valley African Film Festival. Browse images from photographers Asha Alessandra and Drew Altizer.';
$page_canonical   = GALLERY_SITE_URL . '/';
$extra_css        = '<link rel="stylesheet" href="/assets/css/gallery.css">';

$nav_active = 'gallery';
require GALLERY_ROOT . '/shared/inc/head.php';
require GALLERY_ROOT . '/shared/inc/nav.php';
?>

<main id="main-content">

    <!-- Hero -->
    <section class="gallery-hero">
        <div class="gallery-hero__inner">
            <p class="gallery-hero__eyebrow">Silicon Valley African Film Festival</p>
            <h1 class="gallery-hero__title">Photo Gallery</h1>
            <p class="gallery-hero__lead">Behind the lens at SVAFF — official images from our photographers.</p>
        </div>
    </section>

    <!-- Gallery Index -->
    <section class="gallery-index">
        <div class="gallery-index__inner">

            <?php foreach ($gallery as $year => $photographers): ?>
            <?php $year = (string)$year; ?>
            <div class="gallery-year" id="year-<?= htmlspecialchars($year) ?>">
                <h2 class="gallery-year__heading"><?= htmlspecialchars($year) ?></h2>

                <?php foreach ($photographers as $photo_slug => $photographer): ?>
                <div class="gallery-photographer">
                    <h3 class="gallery-photographer__name">
                        <?= htmlspecialchars($photographer['label']) ?>
                    </h3>

                    <div class="gallery-collections">
                        <?php foreach ($photographer['collections'] as $col_slug => $col): ?>
                        <?php
                            $cover_url = $col_slug === 'all'
                                ? '/assets/photos/' . rawurlencode($year) . '/' . rawurlencode($photo_slug) . '/' . rawurlencode($col['cover'])
                                : '/assets/photos/' . rawurlencode($year) . '/' . rawurlencode($photo_slug) . '/' . rawurlencode($col_slug) . '/' . rawurlencode($col['cover']);
                            $col_url = '/collection/' . rawurlencode($year) . '/' . rawurlencode($photo_slug) . '/' . rawurlencode($col_slug);
                        ?>
                        <a href="<?= htmlspecialchars($col_url) ?>" class="gallery-card">
                            <div class="gallery-card__thumb">
                                <img
                                    data-src="<?= htmlspecialchars($cover_url) ?>"
                                    alt="<?= htmlspecialchars($col['label'] . ' — ' . $photographer['label'] . ' ' . $year) ?>"
                                    loading="eager"
                                    decoding="async"
                                >
                                <div class="gallery-card__overlay">
                                    <span class="gallery-card__count"><?= $col['count'] ?> photos</span>
                                </div>
                            </div>
                            <div class="gallery-card__info">
                                <p class="gallery-card__title"><?= htmlspecialchars($col['label']) ?></p>
                                <p class="gallery-card__meta">
                                    <?= htmlspecialchars($photographer['label']) ?> &middot; <?= htmlspecialchars($year) ?>
                                </p>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>

        </div>
    </section>

</main>

<?php require GALLERY_ROOT . '/shared/inc/footer.php'; ?>
<script src="/assets/js/gallery.js" defer></script>
</body>
</html>
