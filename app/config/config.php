<?php

// Dynamically determine the base URL for robust server support
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$baseUrl = $protocol . '://' . $host . ($scriptDir === '\\' || $scriptDir === '/' ? '' : $scriptDir);

define('BASE_URL', rtrim($baseUrl, '/'));
define('APP_ROOT', dirname(dirname(__FILE__)));
define('SITE_NAME', 'Rare Stones | Rare & Exceptional Gemstones');

// Load environment variables from .env at project root (if present)
$projectRoot = dirname(APP_ROOT);
$envPath = $projectRoot . DIRECTORY_SEPARATOR . '.env';
if (file_exists($envPath)) {
	$lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($lines as $line) {
		$line = trim($line);
		if ($line === '' || strpos($line, '#') === 0) {
			continue;
		}
		if (strpos($line, '=') === false) {
			continue;
		}
		list($name, $value) = explode('=', $line, 2);
		$name = trim($name);
		$value = trim($value);
		if ($name === '') {
			continue;
		}
		if (getenv($name) === false) {
			putenv($name . '=' . $value);
		}
		if (!isset($_ENV[$name])) {
			$_ENV[$name] = $value;
		}
	}
}

// Database Configuration (read from environment with sensible defaults)
define('DB_HOST', getenv('DB_HOST') !== false ? getenv('DB_HOST') : 'localhost');
define('DB_USER', getenv('DB_USER') !== false ? getenv('DB_USER') : 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
define('DB_NAME', getenv('DB_NAME') !== false ? getenv('DB_NAME') : 'rare_stone_db');

