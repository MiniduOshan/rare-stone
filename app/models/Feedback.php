<?php

require_once APP_ROOT . '/models/Database.php';

class Feedback {
    /**
     * Submit customer feedback
     * 
     * @param int $userId
     * @param int $rating
     * @param string $message
     * @return bool
     */
    public static function add($userId, $rating, $message) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO `feedbacks` (`user_id`, `rating`, `message`, `status`) VALUES (:user_id, :rating, :message, 'pending')");
            return $stmt->execute([
                'user_id' => $userId,
                'rating' => $rating,
                'message' => $message
            ]);
        } catch (PDOException $e) {
            error_log("Error in Feedback::add: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Fetch approved feedbacks for public reviews
     * 
     * @return array
     */
    public static function getApproved() {
        try {
            return Database::cachedQuery(
                "SELECT f.*, u.name as user_name, u.email as user_email 
                 FROM `feedbacks` f 
                 JOIN `users` u ON f.user_id = u.id 
                 WHERE f.status = 'approved' 
                 ORDER BY f.created_at DESC"
            );
        } catch (PDOException $e) {
            error_log("Error in Feedback::getApproved: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetch all feedbacks (pending/approved/rejected) for administrative moderation
     * 
     * @return array
     */
    public static function getAll() {
        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT f.*, u.name as user_name, u.email as user_email 
                                FROM `feedbacks` f 
                                JOIN `users` u ON f.user_id = u.id 
                                ORDER BY f.created_at DESC");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error in Feedback::getAll: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Update the approval status of a feedback
     * 
     * @param int $id
     * @param string $status ('approved', 'rejected', 'pending')
     * @return bool
     */
    public static function updateStatus($id, $status) {
        if (!in_array($status, ['pending', 'approved', 'rejected'])) {
            return false;
        }
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("UPDATE `feedbacks` SET `status` = :status WHERE `id` = :id");
            return $stmt->execute([
                'id' => $id,
                'status' => $status
            ]);
        } catch (PDOException $e) {
            error_log("Error in Feedback::updateStatus: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a feedback record
     * 
     * @param int $id
     * @return bool
     */
    public static function delete($id) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM `feedbacks` WHERE `id` = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Error in Feedback::delete: " . $e->getMessage());
            return false;
        }
    }
}
