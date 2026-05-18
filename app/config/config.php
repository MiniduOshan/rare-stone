<?php

// Dynamically determine the base URL for robust XAMPP / server support
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$baseUrl = $protocol . '://' . $host . ($scriptDir === '\\' || $scriptDir === '/' ? '' : $scriptDir);

define('BASE_URL', rtrim($baseUrl, '/'));
define('APP_ROOT', dirname(dirname(__FILE__)));
define('SITE_NAME', 'AETHERIA | Rare & Exceptional Gemstones');
