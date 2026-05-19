<?php

require_once APP_ROOT . '/models/Database.php';

class User {
    /**
     * Start session if not already started
     */
    public static function initSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Login user by validating email and password
     * 
     * @param string $email
     * @param string $password
     * @return array|bool User data on success, false on failure
     */
    public static function login($email, $password) {
        self::initSession();
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM `users` WHERE `email` = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['is_guest'] = false;
                return $user;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error in User::login: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Set the user session to guest mode
     */
    public static function loginAsGuest() {
        self::initSession();
        $_SESSION['user_id'] = null;
        $_SESSION['user_name'] = 'Guest Client';
        $_SESSION['user_email'] = '';
        $_SESSION['user_role'] = 'guest';
        $_SESSION['is_guest'] = true;
    }

    /**
     * Register a new user
     * 
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $role
     * @return bool
     */
    public static function register($name, $email, $password, $role = 'customer') {
        try {
            $db = Database::getConnection();
            $hashedPass = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO `users` (`name`, `email`, `password`, `role`) VALUES (:name, :email, :password, :role)");
            return $stmt->execute([
                'name' => $name,
                'email' => $email,
                'password' => $hashedPass,
                'role' => $role
            ]);
        } catch (PDOException $e) {
            error_log("Error in User::register: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get current authenticated user
     * 
     * @return array|null
     */
    public static function getCurrentUser() {
        self::initSession();
        if (isset($_SESSION['user_role'])) {
            return [
                'id' => $_SESSION['user_id'] ?? null,
                'name' => $_SESSION['user_name'] ?? 'Guest Client',
                'email' => $_SESSION['user_email'] ?? '',
                'role' => $_SESSION['user_role'],
                'is_guest' => $_SESSION['is_guest'] ?? true
            ];
        }
        return null;
    }

    /**
     * Check if user is logged in
     * 
     * @return bool
     */
    public static function isLoggedIn() {
        self::initSession();
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'guest';
    }

    /**
     * Check if user is Admin
     * 
     * @return bool
     */
    public static function isAdmin() {
        self::initSession();
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    /**
     * Log out current user
     */
    public static function logout() {
        self::initSession();
        session_unset();
        session_destroy();
    }
}
