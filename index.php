<?php
/**
 * gallery.svaff.org — Front Controller
 * Routes: / → home, /collection/{year}/{photographer}/{collection} → collection view
 */
declare(strict_types=1);

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/scanner.php';

// --------------------------------------------------------------------------
// Routing
// --------------------------------------------------------------------------
$request = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$request = rtrim($request, '/') ?: '/';
$segments = array_values(array_filter(explode('/', $request)));

// /collection/{year}/{photographer}/{collection}
if (count($segments) === 4 && $segments[0] === 'collection') {
    [, $year, $photographer, $collection] = $segments;
    $year         = preg_replace('/[^0-9]/', '', $year);
    $photographer = preg_replace('/[^A-Za-z0-9_\-]/', '', $photographer);
    $collection   = preg_replace('/[^A-Za-z0-9_\-]/', '', $collection);
    require __DIR__ . '/pages/collection.php';
    exit;
}

// / — gallery home
require __DIR__ . '/pages/home.php';
