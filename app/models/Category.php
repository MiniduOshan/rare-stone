<?php

require_once APP_ROOT . '/models/Database.php';

class Category
{
    private static $tableEnsured = false;

    /**
     * Ensure the categories table exists and is seeded with defaults.
     */
    public static function ensureTable()
    {
        if (self::$tableEnsured) {
            return;
        }

        try {
            $db = Database::getConnection();

            // Create Table if not exists
            $db->exec("CREATE TABLE IF NOT EXISTS `categories` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(100) NOT NULL,
                `slug` VARCHAR(100) UNIQUE NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

            // Seed default options if empty
            $stmt = $db->query("SELECT COUNT(*) FROM `categories`");
            if ((int) $stmt->fetchColumn() === 0) {
                $defaults = [
                    ['name' => 'Sapphires', 'slug' => 'sapphire'],
                    ['name' => 'Rubies', 'slug' => 'ruby'],
                    ['name' => 'Emeralds', 'slug' => 'emerald'],
                    ['name' => 'Diamonds', 'slug' => 'diamond'],
                    ['name' => 'Bespoke Jewelry', 'slug' => 'jewelry']
                ];

                $insert = $db->prepare("INSERT INTO `categories` (`name`, `slug`) VALUES (:name, :slug)");
                foreach ($defaults as $cat) {
                    $insert->execute($cat);
                }
            }
        } catch (PDOException $e) {
            error_log("Error in Category::ensureTable: " . $e->getMessage());
        }

        self::$tableEnsured = true;
    }

    /**
     * Fetch all active categories from the database
     * 
     * @return array
     */
    public static function getAll()
    {
        try {
            self::ensureTable();
            return Database::cachedQuery("SELECT * FROM `categories` ORDER BY `id` ASC");
        } catch (PDOException $e) {
            error_log("Error in Category::getAll: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Add a new category filter tag
     * 
     * @param string $name
     * @return bool
     */
    public static function add($name)
    {
        try {
            self::ensureTable();
            $name = trim($name);
            if ($name === '') {
                return false;
            }

            // Generate lowercase URL-safe slug from name
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
            $slug = trim($slug, '-');

            if ($slug === '') {
                return false;
            }

            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO `categories` (`name`, `slug`) VALUES (:name, :slug)");
            $result = $stmt->execute([
                'name' => $name,
                'slug' => $slug
            ]);

            // Clear cache so new filters appear immediately
            Database::clearCache();

            return $result;
        } catch (PDOException $e) {
            error_log("Error in Category::add: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a category filter tag by ID
     * 
     * @param int $id
     * @return bool
     */
    public static function delete($id)
    {
        try {
            self::ensureTable();
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM `categories` WHERE `id` = :id");
            $result = $stmt->execute(['id' => $id]);

            // Clear cache so removed filters disappear immediately
            Database::clearCache();

            return $result;
        } catch (PDOException $e) {
            error_log("Error in Category::delete: " . $e->getMessage());
            return false;
        }
    }
}
