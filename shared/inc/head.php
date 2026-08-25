<?php
/**
 * SVAFF HTML Head Component
 * Include at the top of every page's <head>.
 *
 * Variables to set before including:
 *   $page_title       = 'Page Title';          // required
 *   $page_description = 'Meta description.';   // required
 *   $page_canonical   = 'https://...';         // optional, defaults to current URL
 *   $page_og_image    = 'https://...';         // optional, defaults to SVAFF og image
 *   $extra_css        = '<link ...>';           // optional, site-specific CSS
 */
declare(strict_types=1);

$page_title       = $page_title       ?? 'Silicon Valley African Film Festival 2026';
$page_description = $page_description ?? 'Experience Africa through the African lens. SVAFF — 17th Annual Celebration, October 8-11, 2026.';
$page_og_image    = $page_og_image    ?? 'https://svaff.org/assets/img/svaff-og.webp';
$extra_css        = $extra_css        ?? '';

// Canonical: always the clean path — strip ALL query params.
// Query strings like ?online=...&amp=1 must never appear in canonical/OG
// tags. Google treats amp=1 as an AMP indicator and crawls the URL as AMP,
// which then fails validation and drops the page from search results.
if (!isset($page_canonical)) {
    $host   = $_SERVER['HTTP_HOST'] ?? 'svaff.org';
    $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $path   = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $page_canonical = $scheme . '://' . $host . $path;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($page_description) ?>">

    <!-- Canonical -->
    <link rel="canonical" href="<?= htmlspecialchars($page_canonical) ?>">

    <!-- Open Graph -->
    <meta property="og:type"        content="website">
    <meta property="og:title"       content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($page_description) ?>">
    <meta property="og:image"       content="<?= htmlspecialchars($page_og_image) ?>">
    <meta property="og:url"         content="<?= htmlspecialchars($page_canonical) ?>">
    <meta property="og:site_name"   content="Silicon Valley African Film Festival">

    <!-- Twitter Card -->
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="<?= htmlspecialchars($page_title) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($page_description) ?>">
    <meta name="twitter:image"       content="<?= htmlspecialchars($page_og_image) ?>">

    <!-- Favicons -->
    <link rel="icon" href="/assets/logos/svaff-logo-icon.svg" type="image/svg+xml">
    <link rel="icon" href="/assets/logos/svaff-logo-icon.svg" sizes="any">
    <link rel="icon"             href="/assets/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="apple-touch-icon" href="/assets/favicons/apple-touch-icon.png">
    <link rel="manifest"         href="/assets/favicons/site.webmanifest">
    <meta name="theme-color"     content="#032235">

    <!-- Shared brand styles -->
    <link rel="stylesheet" href="/assets/css/brand-mesh.css">
    <link rel="stylesheet" href="/assets/css/pages.css">

    <!-- Site-specific styles -->
    <?= $extra_css ?>
</head>
<body>
