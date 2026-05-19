<?php

/**
 * Security Helper — CSRF, Input Sanitisation, Brute-force Protection
 */
class Security {

    // ─── CSRF Token ───────────────────────────────────────────────

    /**
     * Generate or retrieve the current CSRF token for the session.
     *
     * @return string
     */
    public static function csrfToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Output a hidden <input> containing the CSRF token.
     */
    public static function csrfField() {
        echo '<input type="hidden" name="csrf_token" value="' . self::csrfToken() . '">';
    }

    /**
     * Validate a submitted CSRF token against the session token.
     *
     * @param string|null $token  Token from POST data. If null, reads $_POST['csrf_token'].
     * @return bool
     */
    public static function verifyCsrf($token = null) {
        if ($token === null) {
            $token = $_POST['csrf_token'] ?? '';
        }
        return isset($_SESSION['csrf_token'])
            && is_string($token)
            && $token !== ''
            && hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Enforce CSRF on current request — aborts with 403 on failure.
     */
    public static function requireCsrf() {
        if (!self::verifyCsrf()) {
            http_response_code(403);
            if (self::isAjax()) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Invalid security token. Please refresh the page and try again.']);
            } else {
                die('Security verification failed. Please go back and try again.');
            }
            exit;
        }
    }

    // ─── Input Sanitisation ───────────────────────────────────────

    /**
     * Sanitise a string: trim, strip tags, limit length.
     *
     * @param string $input
     * @param int    $maxLength
     * @return string
     */
    public static function sanitizeString($input, $maxLength = 1000) {
        if (!is_string($input)) return '';
        $input = trim($input);
        $input = strip_tags($input);
        // Remove null bytes
        $input = str_replace("\0", '', $input);
        if ($maxLength > 0) {
            $input = mb_substr($input, 0, $maxLength, 'UTF-8');
        }
        return $input;
    }

    /**
     * Sanitise HTML content (allows safe HTML tags for articles).
     *
     * @param string $input
     * @param int    $maxLength
     * @return string
     */
    public static function sanitizeHtml($input, $maxLength = 50000) {
        if (!is_string($input)) return '';
        $input = trim($input);
        // Remove null bytes
        $input = str_replace("\0", '', $input);
        // Strip dangerous tags but keep formatting ones
        $allowed = '<p><br><strong><em><b><i><u><ul><ol><li><h1><h2><h3><h4><h5><h6><a><span><div><blockquote><img><table><tr><td><th><thead><tbody>';
        $input = strip_tags($input, $allowed);
        // Remove event handlers from allowed tags
        $input = preg_replace('/\bon\w+\s*=\s*["\'][^"\']*["\']|javascript\s*:/i', '', $input);
        if ($maxLength > 0) {
            $input = mb_substr($input, 0, $maxLength, 'UTF-8');
        }
        return $input;
    }

    /**
     * Sanitise an integer input.
     *
     * @param mixed $input
     * @param int   $min
     * @param int   $max
     * @return int
     */
    public static function sanitizeInt($input, $min = 0, $max = PHP_INT_MAX) {
        $val = filter_var($input, FILTER_VALIDATE_INT);
        if ($val === false) return $min;
        return max($min, min($max, $val));
    }

    /**
     * Sanitise and validate an email address.
     *
     * @param string $input
     * @return string  Empty string if invalid.
     */
    public static function sanitizeEmail($input) {
        $input = trim((string) $input);
        $input = mb_substr($input, 0, 254, 'UTF-8');
        $email = filter_var($input, FILTER_SANITIZE_EMAIL);
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : '';
    }

    /**
     * Sanitise a URL slug (letters, digits, hyphens only).
     *
     * @param string $input
     * @param int    $maxLength
     * @return string
     */
    public static function sanitizeSlug($input, $maxLength = 200) {
        $input = trim((string) $input);
        $input = strtolower($input);
        $input = preg_replace('/[^a-z0-9\-]/', '-', $input);
        $input = preg_replace('/-+/', '-', $input);
        $input = trim($input, '-');
        return mb_substr($input, 0, $maxLength, 'UTF-8');
    }

    /**
     * Sanitise a filename to prevent directory traversal.
     *
     * @param string $filename
     * @return string
     */
    public static function sanitizeFilename($filename) {
        $filename = basename((string) $filename);
        $filename = preg_replace('/[^a-zA-Z0-9_.\-]/', '_', $filename);
        return $filename;
    }

    // ─── Login Brute-force Protection ─────────────────────────────

    /**
     * Check if a login attempt is allowed (max 5 per 15 min).
     *
     * @return bool
     */
    public static function canAttemptLogin() {
        $maxAttempts = 5;
        $windowSeconds = 900; // 15 minutes
        $now = time();

        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = [];
        }

        $_SESSION['login_attempts'] = array_values(array_filter(
            $_SESSION['login_attempts'],
            function ($ts) use ($now, $windowSeconds) {
                return ($now - $ts) < $windowSeconds;
            }
        ));

        return count($_SESSION['login_attempts']) < $maxAttempts;
    }

    /**
     * Record a login attempt.
     */
    public static function recordLoginAttempt() {
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = [];
        }
        $_SESSION['login_attempts'][] = time();
    }

    /**
     * Get remaining lockout time in seconds (0 if not locked).
     *
     * @return int
     */
    public static function loginLockoutRemaining() {
        if (self::canAttemptLogin()) return 0;
        $oldest = min($_SESSION['login_attempts']);
        return max(0, ($oldest + 900) - time());
    }

    /**
     * Reset login attempt counter (call on successful login).
     */
    public static function resetLoginAttempts() {
        $_SESSION['login_attempts'] = [];
    }

    // ─── Utility ──────────────────────────────────────────────────

    /**
     * Detect AJAX/fetch requests.
     *
     * @return bool
     */
    public static function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
