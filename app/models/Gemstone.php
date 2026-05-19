<?php

require_once APP_ROOT . '/models/Database.php';

class Gemstone {
    private static $locationColumnEnsured = false;

    /**
     * Ensure the gemstones table has a dedicated location column.
     */
    public static function ensureLocationColumn() {
        if (self::$locationColumnEnsured) {
            return;
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'gemstones' AND COLUMN_NAME = 'location'");
            $stmt->execute();

            if ((int) $stmt->fetchColumn() === 0) {
                $db->exec("ALTER TABLE `gemstones` ADD COLUMN `location` VARCHAR(150) NOT NULL DEFAULT '' AFTER `origin`");
            }
        } catch (PDOException $e) {
            error_log("Error ensuring gemstone location column: " . $e->getMessage());
        }

        self::$locationColumnEnsured = true;
    }
    /**
     * Build a URL-safe gemstone slug from the stone name and location.
     *
     * @param array $gem
     * @return string
     */
    public static function buildSlug(array $gem) {
        $parts = [];

        if (!empty($gem['title'])) {
            $parts[] = $gem['title'];
        }

        $location = self::getDisplayLocation($gem);
        if (!empty($location)) {
            $parts[] = $location;
        }

        $parts[] = isset($gem['id']) ? $gem['id'] : '';
        $slug = strtolower(trim(implode(' ', $parts)));
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        return trim($slug, '-');
    }

    /**
     * Get the user-facing location for a gemstone.
     *
     * @param array $gem
     * @return string
     */
    public static function getDisplayLocation(array $gem) {
        $location = trim($gem['location'] ?? '');
        if ($location !== '') {
            return $location;
        }

        return trim($gem['origin'] ?? '');
    }

    /**
     * Get list of curated gemstone acquisitions from DB
     * 
     * @return array
     */
    public static function getCuratedAcquisitions() {
        try {
            self::ensureLocationColumn();
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
            self::ensureLocationColumn();
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
     * Get a specific gemstone by its slug.
     *
     * @param string $slug
     * @return array|null
     */
    public static function getBySlug($slug) {
        $slug = trim($slug);
        if ($slug === '') {
            return null;
        }

        if (preg_match('/-(\d+)$/', $slug, $matches)) {
            return self::getById((int) $matches[1]);
        }

        if (ctype_digit($slug)) {
            return self::getById((int) $slug);
        }

        try {
            $db = Database::getConnection();
            $rows = self::getCuratedAcquisitions();
            foreach ($rows as $gem) {
                if (self::buildSlug($gem) === $slug) {
                    return $gem;
                }
            }

            return null;
        } catch (PDOException $e) {
            error_log("Error in getBySlug: " . $e->getMessage());
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
    public static function add($title, $origin, $location, $carats, $cut, $status, $image, $description, $price_tier) {
        try {
            self::ensureLocationColumn();
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO `gemstones` 
                (`title`, `origin`, `location`, `carats`, `cut`, `status`, `image`, `description`, `price_tier`) 
                VALUES (:title, :origin, :location, :carats, :cut, :status, :image, :description, :price_tier)");
            return $stmt->execute([
                'title' => $title,
                'origin' => $origin,
                'location' => $location,
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
            self::ensureLocationColumn();
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM `gemstones` WHERE `id` = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Error in delete Gemstone: " . $e->getMessage());
            return false;
        }
    }
}
