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
}
