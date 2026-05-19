<?php

class Controller {
    /**
     * Render a view within the standard header and footer layout.
     * Includes output buffering for cleaner output and optional page caching.
     * 
     * @param string $view Path to the view file relative to views/
     * @param array $data Associative array of data to extract for the view
     */
    public function render($view, $data = []) {
        // Sanitise view path to prevent directory traversal
        $view = str_replace(['..', "\0"], '', $view);

        // Extract data to make keys available as variables
        extract($data);

        $headerPath = APP_ROOT . '/views/layouts/header.php';
        $viewPath = APP_ROOT . '/views/' . $view . '.php';
        $footerPath = APP_ROOT . '/views/layouts/footer.php';

        // Start output buffering for cleaner output
        ob_start();

        if (file_exists($headerPath)) {
            require $headerPath;
        } else {
            error_log("Header view not found: " . $headerPath);
            die("A required page component is missing.");
        }

        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            error_log("View file not found: " . $viewPath);
            die("A required page component is missing.");
        }

        if (file_exists($footerPath)) {
            require $footerPath;
        } else {
            error_log("Footer view not found: " . $footerPath);
            die("A required page component is missing.");
        }

        $output = ob_get_clean();

        // Minify HTML in production (strip excessive whitespace)
        if (defined('APP_DEBUG') && !APP_DEBUG) {
            $output = preg_replace('/\s{2,}/', ' ', $output);
            $output = preg_replace('/>\s+</', '><', $output);
        }

        echo $output;
    }
}
