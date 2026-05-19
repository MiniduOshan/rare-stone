<?php
/**
 * PHP Built-in Server Router
 * Usage: php -S localhost:8000 router.php
 *
 * Serves static files directly, routes everything else through index.php
 */
$requestUri = $_SERVER['REQUEST_URI'];
$filePath = __DIR__ . parse_url($requestUri, PHP_URL_PATH);

// If the request is for an existing static file (CSS, JS, images, etc.), serve it directly
if (is_file($filePath)) {
    return false;
}

// Otherwise, route through the front controller
require_once __DIR__ . '/index.php';
