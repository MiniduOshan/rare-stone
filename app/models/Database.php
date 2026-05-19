<?php

class Database {
    private static $instance = null;

    /**
     * Get the PDO database connection instance
     * 
     * @return PDO
     */
    public static function getConnection() {
        if (self::$instance === null) {
            try {
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                if (defined('DB_DRIVER') && strtolower(DB_DRIVER) === 'sqlite') {
                    $path = defined('DB_PATH') ? DB_PATH : (dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'rare_stone.sqlite');
                    // Ensure directory exists
                    $dir = dirname($path);
                    if (!is_dir($dir)) {
                        @mkdir($dir, 0755, true);
                    }
                    $dsn = 'sqlite:' . $path;
                    self::$instance = new PDO($dsn, null, null, $options);
                } else {
                    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
                    self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
                }
            } catch (PDOException $e) {
                error_log("Database connection failed: " . $e->getMessage());
                die("Database connection failed. Please try again later.");
            }
        }
        return self::$instance;
    }
}
