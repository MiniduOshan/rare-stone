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

$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
$scriptDir = str_replace('\\', '/', dirname($scriptName));
if ($scriptDir === '/' || $scriptDir === '.') {
    $scriptDir = '';
}

if ($scriptDir !== '' && strpos($requestPath, $scriptDir) === 0) {
    $requestPath = substr($requestPath, strlen($scriptDir));
}

$requestPath = trim($requestPath, '/');
$pathSegments = $requestPath === '' ? [] : array_values(array_filter(explode('/', $requestPath), 'strlen'));
if (isset($pathSegments[0]) && $pathSegments[0] === 'index.php') {
    array_shift($pathSegments);
}

if (!isset($_GET['route']) || trim($_GET['route']) === '') {
    $_GET['route'] = $pathSegments[0] ?? 'home';
}

if (!isset($_GET['slug']) && isset($pathSegments[1])) {
    $_GET['slug'] = $pathSegments[1];
}

$route = isset($_GET['route']) ? trim($_GET['route']) : 'home';

if ($route === 'gem' && isset($_GET['slug']) && trim($_GET['slug']) !== '' && isset($pathSegments[0]) && $pathSegments[0] === 'index.php') {
    $cleanGemPath = rtrim(BASE_URL, '/') . '/gem/' . rawurlencode(trim($_GET['slug'])) . '/';
    header('Location: ' . $cleanGemPath);
    exit;
}

$publicRoutePaths = [
    'home' => '/',
    'gemstones' => '/gemstones/',
    'heritage' => '/heritage/',
    'news' => '/news/',
    'article' => '/article/' . rawurlencode($_GET['slug'] ?? '') . '/',
    'discover' => '/discover/',
    'login' => '/login/',
    'logout' => '/logout/',
    'register' => '/register/',
    'gem' => '/gem/' . rawurlencode($_GET['slug'] ?? '') . '/',
];

if (isset($_GET['route']) && isset($publicRoutePaths[$route])) {
    $currentBase = trim($requestPath, '/');
    $expectedPath = trim($publicRoutePaths[$route], '/');

    if ($expectedPath !== '' && $currentBase !== $expectedPath) {
        header('Location: ' . rtrim(BASE_URL, '/') . $publicRoutePaths[$route]);
        exit;
    }
}

// Protect admin routes
if (strpos($route, 'admin') === 0) {
    if (!User::isAdmin()) {
        header('Location: ' . BASE_URL . '/login/');
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
            header('Location: ' . BASE_URL . '/admin/#news');
            exit;
        }
        break;
    case 'admin_heritage':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminController->heritage();
        } else {
            header('Location: ' . BASE_URL . '/admin/#heritage');
            exit;
        }
        break;
    case 'admin_gems':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminController->gems();
        } else {
            header('Location: ' . BASE_URL . '/admin/#gems');
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
            header('Location: ' . BASE_URL . '/admin/#discover');
            exit;
        }
        break;
    case 'admin_contact':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminController->contact();
        } else {
            header('Location: ' . BASE_URL . '/admin/#contact');
            exit;
        }
        break;
        
    case 'home':
    default:
        $homeController->index();
        break;
}
