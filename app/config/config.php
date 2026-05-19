<?php

function rare_stones_env($key, $default = null) {
	$value = getenv($key);
	if ($value === false || $value === '') {
		return $default;
	}

	return $value;
}

function rare_stones_bool_env($key, $default = false) {
	$value = getenv($key);
	if ($value === false || $value === '') {
		return $default;
	}

	return in_array(strtolower($value), ['1', 'true', 'yes', 'on'], true);
}

define('APP_ROOT', dirname(dirname(__FILE__)));
define('SITE_NAME', 'Rare Stones | Rare & Exceptional Gemstones');

// Load environment variables from .env at project root before reading config values
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

// Production-aware environment settings
define('APP_ENV', rare_stones_env('APP_ENV', 'production'));
define('APP_DEBUG', rare_stones_bool_env('APP_DEBUG', APP_ENV !== 'production'));

if (!APP_DEBUG) {
	ini_set('display_errors', '0');
	ini_set('display_startup_errors', '0');
	ini_set('log_errors', '1');
	ini_set('expose_php', '0');
} else {
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
}

error_reporting(APP_DEBUG ? E_ALL : E_ALL & ~E_DEPRECATED & ~E_STRICT);
date_default_timezone_set(rare_stones_env('APP_TIMEZONE', 'Asia/Colombo'));

// Dynamically determine the base URL, with an env override for production deployments
$appUrl = rare_stones_env('APP_URL', '');
if ($appUrl !== '') {
	$baseUrl = rtrim($appUrl, '/');
} else {
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
	$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
	$scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
	$scriptDir = str_replace('\\', '/', dirname($scriptName));
	if ($scriptDir === '/' || $scriptDir === '.') {
		$scriptDir = '';
	}
	$baseUrl = $protocol . '://' . $host . $scriptDir;
}

define('BASE_URL', $baseUrl);

// Database Configuration (read from environment; DB_NAME is required)
define('DB_DRIVER', rare_stones_env('DB_DRIVER', 'mysql'));
// Common MySQL settings (used when DB_DRIVER is mysql)
define('DB_HOST', rare_stones_env('DB_HOST', 'localhost'));
define('DB_USER', rare_stones_env('DB_USER', 'root'));
define('DB_PASS', rare_stones_env('DB_PASS', ''));

if (strtolower(DB_DRIVER) === 'sqlite') {
	// SQLite: optional DB_PATH (relative to project root) or default to projectRoot/database/rare_stone.sqlite
	$defaultSqlitePath = $projectRoot . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'rare_stone.sqlite';
	$dbPath = rare_stones_env('DB_PATH', $defaultSqlitePath);
	define('DB_PATH', $dbPath);
	// DB_NAME not required for sqlite, set to empty string for compatibility
	define('DB_NAME', '');
} else {
	// MySQL: require DB_NAME
	$dbName = rare_stones_env('DB_NAME', '');
	if ($dbName === null || $dbName === '') {
		if (APP_DEBUG) {
			trigger_error('Environment variable DB_NAME is not set. Set DB_NAME in your .env or environment.', E_USER_WARNING);
		} else {
			error_log('Missing required environment variable: DB_NAME');
			die('Application configuration error.');
		}
	}
	define('DB_NAME', $dbName);
}

// Session Configuration
define('SESSION_NAME', rare_stones_env('SESSION_NAME', 'RARESTONESSESSID'));
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
           (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
define('SESSION_COOKIE_SECURE', rare_stones_bool_env('SESSION_COOKIE_SECURE', $isHttps));
define('SESSION_COOKIE_HTTPONLY', true);
define('SESSION_COOKIE_SAMESITE', rare_stones_env('SESSION_COOKIE_SAMESITE', 'Lax'));
define('SESSION_LIFETIME', (int) rare_stones_env('SESSION_LIFETIME', 0));

