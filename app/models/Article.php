<?php

require_once APP_ROOT . '/models/Database.php';

class Article {
    /**
     * Get all articles ordered by creation date
     * 
     * @return array
     */
    public static function getAll() {
        try {
            self::ensureHeadlineColumnExists();
            $db = Database::getConnection();
            $stmt = $db->query("SELECT * FROM `articles` ORDER BY `created_at` DESC");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error in Article::getAll: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get a specific article by its slug
     * 
     * @param string $slug
     * @return array|null
     */
    public static function getBySlug($slug) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM `articles` WHERE `slug` = :slug");
            $stmt->execute(['slug' => $slug]);
            $article = $stmt->fetch();
            return $article ? $article : null;
        } catch (PDOException $e) {
            error_log("Error in Article::getBySlug: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get a specific article by its numeric ID
     *
     * @param int $id
     * @return array|null
     */
    public static function getById($id) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM `articles` WHERE `id` = :id");
            $stmt->execute(['id' => $id]);
            $article = $stmt->fetch();
            return $article ? $article : null;
        } catch (PDOException $e) {
            error_log("Error in Article::getById: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Add a new article / news item
     * 
     * @param string $slug
     * @param string $meta
     * @param string $title
     * @param string $subtitle
     * @param string $image
     * @param string $author
     * @param string $author_role
     * @param string $content
     * @return bool
     */
    public static function add($slug, $meta, $title, $subtitle, $image, $author, $author_role, $content) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO `articles` 
                (`slug`, `meta`, `title`, `subtitle`, `image`, `author`, `author_role`, `content`) 
                VALUES (:slug, :meta, :title, :subtitle, :image, :author, :author_role, :content)");
            return $stmt->execute([
                'slug' => $slug,
                'meta' => $meta,
                'title' => $title,
                'subtitle' => $subtitle,
                'image' => $image,
                'author' => $author,
                'author_role' => $author_role,
                'content' => $content
            ]);
        } catch (PDOException $e) {
            error_log("Error in Article::add: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update an existing article's content or details
     * 
     * @param int $id
     * @param string $slug
     * @param string $meta
     * @param string $title
     * @param string $subtitle
     * @param string $image
     * @param string $author
     * @param string $author_role
     * @param string $content
     * @return bool
     */
    public static function update($id, $slug, $meta, $title, $subtitle, $image, $author, $author_role, $content) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("UPDATE `articles` SET 
                `slug` = :slug, 
                `meta` = :meta, 
                `title` = :title, 
                `subtitle` = :subtitle, 
                `image` = :image, 
                `author` = :author, 
                `author_role` = :author_role, 
                `content` = :content 
                WHERE `id` = :id");
            return $stmt->execute([
                'id' => $id,
                'slug' => $slug,
                'meta' => $meta,
                'title' => $title,
                'subtitle' => $subtitle,
                'image' => $image,
                'author' => $author,
                'author_role' => $author_role,
                'content' => $content
            ]);
        } catch (PDOException $e) {
            error_log("Error in Article::update: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete an article
     * 
     * @param int $id
     * @return bool
     */
    public static function delete($id) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM `articles` WHERE `id` = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Error in Article::delete: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Check and ensure the is_headline column exists in the articles table.
     * Self-heals the database schema if tables were created before this column was introduced.
     */
    public static function ensureHeadlineColumnExists() {
        try {
            $db = Database::getConnection();
            
            // Check if column exists
            $stmt = $db->query("SHOW COLUMNS FROM `articles` LIKE 'is_headline'");
            $column = $stmt->fetch();
            if (!$column) {
                // Column is missing, add it!
                $db->exec("ALTER TABLE `articles` ADD COLUMN `is_headline` TINYINT(1) DEFAULT 0");
                error_log("Self-healed database schema: added 'is_headline' column to 'articles' table.");
            }
        } catch (PDOException $e) {
            error_log("Failed to ensure 'is_headline' column exists: " . $e->getMessage());
        }
    }

    /**
     * Set a specific article as the headline
     * 
     * @param int $id
     * @return bool
     */
    public static function setHeadline($id) {
        try {
            self::ensureHeadlineColumnExists();
            
            $db = Database::getConnection();
            $db->beginTransaction();
            // Remove headline from all
            $db->exec("UPDATE `articles` SET `is_headline` = 0");
            // Set for specific
            $stmt = $db->prepare("UPDATE `articles` SET `is_headline` = 1 WHERE `id` = :id");
            $stmt->execute(['id' => $id]);
            $db->commit();
            return true;
        } catch (PDOException $e) {
            $db->rollBack();
            error_log("Error in Article::setHeadline: " . $e->getMessage());
            return false;
        }
    }
}
