<?php

require_once APP_ROOT . '/models/Database.php';

class Gemstone {
    /**
     * Get list of curated gemstone acquisitions from DB
     * 
     * @return array
     */
    public static function getCuratedAcquisitions() {
        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT * FROM `gemstones` ORDER BY `id` DESC");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error in getCuratedAcquisitions: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get a specific gemstone by ID from DB
     * 
     * @param int $id
     * @return array|null
     */
    public static function getById($id) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM `gemstones` WHERE `id` = :id");
            $stmt->execute(['id' => $id]);
            $gem = $stmt->fetch();
            return $gem ? $gem : null;
        } catch (PDOException $e) {
            error_log("Error in getById: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Add a new gemstone to the database
     * 
     * @param string $title
     * @param string $origin
     * @param string $carats
     * @param string $cut
     * @param string $status
     * @param string $image
     * @param string $description
     * @param string $price_tier
     * @return bool
     */
    public static function add($title, $origin, $carats, $cut, $status, $image, $description, $price_tier) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO `gemstones` 
                (`title`, `origin`, `carats`, `cut`, `status`, `image`, `description`, `price_tier`) 
                VALUES (:title, :origin, :carats, :cut, :status, :image, :description, :price_tier)");
            return $stmt->execute([
                'title' => $title,
                'origin' => $origin,
                'carats' => $carats,
                'cut' => $cut,
                'status' => $status,
                'image' => $image,
                'description' => $description,
                'price_tier' => $price_tier
            ]);
        } catch (PDOException $e) {
            error_log("Error in add Gemstone: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a gemstone
     * 
     * @param int $id
     * @return bool
     */
    public static function delete($id) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM `gemstones` WHERE `id` = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Error in delete Gemstone: " . $e->getMessage());
            return false;
        }
    }
}
