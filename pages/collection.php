<?php
/**
 * gallery.svaff.org — Collection Page
 * Displays all images in a single collection with lightbox.
 *
 * Variables from index.php: $year, $photographer, $collection
 */
declare(strict_types=1);

$gallery = gallery_scan_all();

// Validate route params
if (
    !isset($gallery[$year][$photographer]) ||
    (
        $collection !== 'all' &&
        !isset($gallery[$year][$photographer]['collections'][$collection])
    ) ||
    (
        $collection === 'all' &&
        !isset($gallery[$year][$photographer]['collections']['all'])
    )
) {
    http_response_code(404);
    $page_title = '404 — Gallery';
    $page_description = 'Collection not found.';
    $extra_css = '<link rel="stylesheet" href="/assets/css/gallery.css">';
    $nav_active = 'gallery';
    require GALLERY_ROOT . '/shared/inc/head.php';
    require GALLERY_ROOT . '/shared/inc/nav.php';
    echo '<main id="main-content"><div style="padding:4rem 2rem;text-align:center;color:#fff"><h1>Collection not found</h1><p><a href="/" style="color:#bfa854">← Back to Gallery</a></p></div></main>';
    require GALLERY_ROOT . '/shared/inc/footer.php';
    echo '</body></html>';
    exit;
}

$col_data       = $gallery[$year][$photographer]['collections'][$collection];
$photo_label    = $gallery[$year][$photographer]['label'];
$col_label      = $col_data['label'];
$col_path       = $col_data['path'];
$images         = gallery_scan_images($col_path);
$total          = count($images);

// Build image URLs
$image_urls = [];
foreach ($images as $img) {
    $image_urls[] = gallery_photo_url($year, $photographer, $collection, $img);
}

$page_title       = $col_label . ' — ' . $photo_label . ' ' . $year . ' — SVAFF Gallery';
$page_description = $col_label . ' photos by ' . $photo_label . ' from SVAFF ' . $year . '. ' . $total . ' images.';
$page_canonical   = GALLERY_SITE_URL . '/collection/' . rawurlencode($year) . '/' . rawurlencode($photographer) . '/' . rawurlencode($collection);
$extra_css        = '<link rel="stylesheet" href="/assets/css/gallery.css">';

$nav_active = 'gallery';
require GALLERY_ROOT . '/shared/inc/head.php';
require GALLERY_ROOT . '/shared/inc/nav.php';
?>

<main id="main-content">

    <!-- Breadcrumb + header -->
    <section class="col-header">
        <div class="col-header__inner">
            <nav class="col-breadcrumb" aria-label="Breadcrumb">
                <a href="/" class="col-breadcrumb__link">Gallery</a>
                <span class="col-breadcrumb__sep" aria-hidden="true">›</span>
                <span class="col-breadcrumb__current"><?= htmlspecialchars($col_label) ?></span>
            </nav>
            <h1 class="col-header__title"><?= htmlspecialchars($col_label) ?></h1>
            <p class="col-header__meta">
                <?= htmlspecialchars($photo_label) ?> &middot; <?= htmlspecialchars($year) ?> &middot;
                <span class="col-header__count"><?= $total ?> photos</span>
            </p>
            <a href="/" class="col-header__back">← All Collections</a>
        </div>
    </section>

    <!-- Photo grid -->
    <section class="col-grid-section">
        <div class="col-grid">
            <?php foreach ($image_urls as $i => $url): ?>
            <button
                class="col-thumb"
                aria-label="Open photo <?= $i + 1 ?> of <?= $total ?>"
                data-index="<?= $i ?>"
                data-src="<?= htmlspecialchars($url) ?>"
                type="button"
            >
                <img
                    src="<?= htmlspecialchars($url) ?>"
                    alt="<?= htmlspecialchars($col_label . ' photo ' . ($i + 1)) ?>"
                    loading="lazy"
                    decoding="async"
                >
            </button>
            <?php endforeach; ?>
        </div>
    </section>

</main>

<!-- Lightbox -->
<div class="lb" id="lb" role="dialog" aria-modal="true" aria-label="Photo viewer" hidden>
    <button class="lb__close" id="lb-close" aria-label="Close photo viewer" type="button">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </button>
    <button class="lb__nav lb__nav--prev" id="lb-prev" aria-label="Previous photo" type="button">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>
    <div class="lb__stage">
        <img class="lb__img" id="lb-img" src="" alt="" draggable="false">
    </div>
    <button class="lb__nav lb__nav--next" id="lb-next" aria-label="Next photo" type="button">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>
    <div class="lb__counter" id="lb-counter" aria-live="polite"></div>
</div>

<?php require GALLERY_ROOT . '/shared/inc/footer.php'; ?>
<script>
// Pass image list to JS
const GALLERY_IMAGES = <?= json_encode($image_urls, JSON_UNESCAPED_SLASHES) ?>;
</script>
<script src="/assets/js/gallery.js" defer></script>
</body>
</html>
