<?php

class Database {
    private static $instance = null;

    /** @var array In-memory query result cache (per-request) */
    private static $queryCache = [];

    /** @var int Maximum cache entries to prevent memory bloat */
    private static $maxCacheSize = 100;

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

    /**
     * Execute a cacheable read query (SELECT). Results are cached in-memory
     * for the duration of the request to avoid duplicate DB hits.
     *
     * @param string $sql       The SQL query
     * @param array  $params    Bound parameters
     * @param int    $ttl       Not used (in-memory only), kept for future file cache
     * @return array
     */
    public static function cachedQuery($sql, $params = [], $ttl = 0) {
        $cacheKey = md5($sql . serialize($params));

        if (isset(self::$queryCache[$cacheKey])) {
            return self::$queryCache[$cacheKey];
        }

        try {
            $db = self::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetchAll();

            // Store in cache (evict oldest if full)
            if (count(self::$queryCache) >= self::$maxCacheSize) {
                array_shift(self::$queryCache);
            }
            self::$queryCache[$cacheKey] = $result;

            return $result;
        } catch (PDOException $e) {
            error_log("Database cached query failed: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Invalidate all cached queries (call after INSERT/UPDATE/DELETE).
     */
    public static function clearCache() {
        self::$queryCache = [];
    }
}
