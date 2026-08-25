<?php
/**
 * gallery.svaff.org — Configuration
 */
declare(strict_types=1);

define('GALLERY_ROOT',       __DIR__ . '/..');
define('GALLERY_PHOTOS_DIR', GALLERY_ROOT . '/assets/photos');
define('GALLERY_SITE_URL',   'https://gallery.svaff.org');
define('GALLERY_CACHE_DIR',  GALLERY_ROOT . '/inc/cache');
define('GALLERY_CACHE_TTL',  300); // 5 minutes
