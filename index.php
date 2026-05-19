<?php

// Front Controller / Entry Point
require_once dirname(__FILE__) . '/app/config/config.php';
require_once APP_ROOT . '/models/User.php';

// Initialize session globally
User::initSession();

require_once APP_ROOT . '/controllers/HomeController.php';
require_once APP_ROOT . '/controllers/AdminController.php';

$homeController = new HomeController();
$adminController = new AdminController();

$route = isset($_GET['route']) ? trim($_GET['route']) : 'home';

// Protect admin routes
if (strpos($route, 'admin') === 0) {
    if (!User::isAdmin()) {
        header('Location: ' . BASE_URL . '/index.php?route=login');
        exit;
    }
}

switch ($route) {
    case 'login':
        $homeController->login();
        break;
    case 'logout':
        $homeController->logout();
        break;
    case 'register':
        $homeController->register();
        break;
    case 'feedback':
        $homeController->feedback();
        break;
    case 'inquire':
        $homeController->inquire();
        break;
    case 'newsletter':
        $homeController->newsletter();
        break;
    case 'heritage':
        $homeController->heritage();
        break;
    case 'news':
        $homeController->news();
        break;
    case 'article':
        $homeController->article();
        break;
    case 'gemstones':
        $homeController->gemstones();
        break;
    case 'gem':
        $homeController->gem();
        break;
    case 'discover':
        $homeController->discover();
        break;
        
    // Administrative Routes
    case 'admin':
        $adminController->index();
        break;
    case 'admin_news':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminController->news();
        } else {
            header('Location: ' . BASE_URL . '/index.php?route=admin#news');
            exit;
        }
        break;
    case 'admin_heritage':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminController->heritage();
        } else {
            header('Location: ' . BASE_URL . '/index.php?route=admin#heritage');
            exit;
        }
        break;
    case 'admin_gems':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminController->gems();
        } else {
            header('Location: ' . BASE_URL . '/index.php?route=admin#gems');
            exit;
        }
        break;
    case 'admin_feedback_status':
        $adminController->feedbackStatus();
        break;
    case 'admin_discover':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminController->discover();
        } else {
            header('Location: ' . BASE_URL . '/index.php?route=admin#discover');
            exit;
        }
        break;
    case 'admin_contact':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminController->contact();
        } else {
            header('Location: ' . BASE_URL . '/index.php?route=admin#contact');
            exit;
        }
        break;
        
    case 'home':
    default:
        $homeController->index();
        break;
}
