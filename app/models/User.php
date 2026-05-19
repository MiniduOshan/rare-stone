<?php

require_once APP_ROOT . '/models/Database.php';

class User {
    /**
     * Start session if not already started
     */
    public static function initSession() {
        if (session_status() == PHP_SESSION_NONE) {
            $cookieParams = [
                'lifetime' => SESSION_LIFETIME,
                'path' => '/',
                'domain' => '',
                'secure' => SESSION_COOKIE_SECURE,
                'httponly' => SESSION_COOKIE_HTTPONLY,
                'samesite' => SESSION_COOKIE_SAMESITE,
            ];
            session_name(SESSION_NAME);
            session_set_cookie_params($cookieParams);
            ini_set('session.use_strict_mode', '1');
            ini_set('session.use_only_cookies', '1');
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
				session_regenerate_id(true);
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
        $_SESSION = [];
		if (ini_get('session.use_cookies')) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
		}
        session_unset();
        session_destroy();
    }
}
