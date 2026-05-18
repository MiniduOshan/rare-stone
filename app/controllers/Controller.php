<?php

class Controller {
    /**
     * Render a view within the standard header and footer layout
     * 
     * @param string $view Path to the view file relative to views/
     * @param array $data Associative array of data to extract for the view
     */
    public function render($view, $data = []) {
        // Extract data to make keys available as variables
        extract($data);

        $headerPath = APP_ROOT . '/views/layouts/header.php';
        $viewPath = APP_ROOT . '/views/' . $view . '.php';
        $footerPath = APP_ROOT . '/views/layouts/footer.php';

        if (file_exists($headerPath)) {
            require_once $headerPath;
        } else {
            die("Header view not found: " . $headerPath);
        }

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("View file not found: " . $viewPath);
        }

        if (file_exists($footerPath)) {
            require_once $footerPath;
        } else {
            die("Footer view not found: " . $footerPath);
        }
    }
}
