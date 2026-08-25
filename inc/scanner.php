<?php
/**
 * gallery.svaff.org — Photo Scanner
 *
 * Auto-discovers the folder hierarchy:
 *   assets/photos/{year}/{photographer}/{collection}/
 *
 * Special case: if a photographer folder contains images directly
 * (no collection subfolder), it is treated as a single collection
 * labelled "All Images".
 *
 * Results are cached to GALLERY_CACHE_DIR for GALLERY_CACHE_TTL seconds.
 */
declare(strict_types=1);

/** Convert a folder name to a human-readable label. */
function gallery_label(string $folder): string {
    return trim(str_replace(['_', '-'], ' ', $folder));
}

/** Return the first image in a collection as a cover thumbnail. */
function gallery_cover(string $path): string {
    $files = gallery_scan_images($path);
    return !empty($files) ? $files[0] : '';
}

/** Scan a directory for image files, filtering junk. */
function gallery_scan_images(string $path): array {
    if (!is_dir($path)) return [];
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    $files = [];
    foreach (scandir($path) as $f) {
        if ($f[0] === '.') continue;
        $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
        if (in_array($ext, $allowed, true)) {
            $files[] = $f;
        }
    }
    sort($files);
    return $files;
}

/**
 * Scan the full photo hierarchy. Returns:
 * [
 *   year => [
 *     'photographer_slug' => [
 *       'label'       => 'Photographer Name',
 *       'collections' => [
 *         'slug' => [
 *           'label'      => 'Collection Name',
 *           'path'       => '/abs/path/to/collection',
 *           'url_year'   => '2025',
 *           'url_photo'  => 'Asha_Alessandra',
 *           'url_col'    => 'Opening_Night',
 *           'count'      => 170,
 *           'cover'      => 'filename.jpg',
 *         ]
 *       ]
 *     ]
 *   ]
 * ]
 */
function gallery_scan_all(): array {
    $cache_file = GALLERY_CACHE_DIR . '/gallery_index.json';

    // Return cached result if fresh
    if (
        is_file($cache_file) &&
        (time() - filemtime($cache_file)) < GALLERY_CACHE_TTL
    ) {
        $data = json_decode(file_get_contents($cache_file), true);
        if (is_array($data)) return $data;
    }

    $result = [];
    $base   = GALLERY_PHOTOS_DIR;

    foreach (scandir($base) as $year) {
        if ($year[0] === '.' || !is_dir("$base/$year") || !ctype_digit($year)) continue;
        $result[$year] = [];

        foreach (scandir("$base/$year") as $photographer) {
            if ($photographer[0] === '.') continue;
            $photo_path = "$base/$year/$photographer";
            if (!is_dir($photo_path)) continue;

            $photo_slug  = $photographer;
            $photo_label = gallery_label($photographer);
            $collections = [];

            // Does this photographer folder contain images directly (flat)?
            $direct_images = gallery_scan_images($photo_path);
            if (!empty($direct_images)) {
                // Flat photographer folder — treat as single "All Images" collection
                $collections['all'] = [
                    'label'     => 'All Images',
                    'path'      => $photo_path,
                    'url_year'  => $year,
                    'url_photo' => $photo_slug,
                    'url_col'   => 'all',
                    'count'     => count($direct_images),
                    'cover'     => $direct_images[0],
                ];
            } else {
                // Subdirectory collections
                foreach (scandir($photo_path) as $col) {
                    if ($col[0] === '.') continue;
                    $col_path = "$photo_path/$col";
                    if (!is_dir($col_path)) continue;
                    $images = gallery_scan_images($col_path);
                    if (empty($images)) continue;
                    $collections[$col] = [
                        'label'     => gallery_label($col),
                        'path'      => $col_path,
                        'url_year'  => $year,
                        'url_photo' => $photo_slug,
                        'url_col'   => $col,
                        'count'     => count($images),
                        'cover'     => $images[0],
                    ];
                }
            }

            if (!empty($collections)) {
                $result[$year][$photo_slug] = [
                    'label'       => $photo_label,
                    'collections' => $collections,
                ];
            }
        }
    }

    // Sort years descending (newest first)
    krsort($result);

    // Cache result
    if (!is_dir(GALLERY_CACHE_DIR)) {
        mkdir(GALLERY_CACHE_DIR, 0755, true);
    }
    file_put_contents($cache_file, json_encode($result));

    return $result;
}

/** Build the web-accessible URL for a photo file. */
function gallery_photo_url(string $year, string $photographer, string $collection, string $filename): string {
    if ($collection === 'all') {
        return '/assets/photos/' . rawurlencode($year) . '/' . rawurlencode($photographer) . '/' . rawurlencode($filename);
    }
    return '/assets/photos/' . rawurlencode($year) . '/' . rawurlencode($photographer) . '/' . rawurlencode($collection) . '/' . rawurlencode($filename);
}

/** Bust the scanner cache (call after uploading new photos). */
function gallery_bust_cache(): void {
    $f = GALLERY_CACHE_DIR . '/gallery_index.json';
    if (is_file($f)) unlink($f);
}
