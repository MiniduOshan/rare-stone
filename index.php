<?php

// Front Controller / Entry Point
require_once dirname(__FILE__) . '/app/config/config.php';
require_once APP_ROOT . '/models/User.php';
require_once APP_ROOT . '/helpers/Security.php';

// Initialize session globally
User::initSession();

// ─── Security Headers ────────────────────────────────────────────
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
}

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

// Sanitise route to alphanumeric + underscores only
$route = preg_replace('/[^a-zA-Z0-9_]/', '', isset($_GET['route']) ? trim($_GET['route']) : 'home');

// Map clean admin URLs (e.g. /admin/feedback-status/) to their respective controllers/actions
if ($route === 'admin' && isset($pathSegments[1])) {
    $subAction = $pathSegments[1];
    switch ($subAction) {
        case 'feedback-status':
            $route = 'admin_feedback_status';
            break;
        case 'news':
            $route = 'admin_news';
            break;
        case 'headline':
            $route = 'admin_headline';
            break;
        case 'heritage':
            $route = 'admin_heritage';
            break;
        case 'gems':
            $route = 'admin_gems';
            break;
        case 'delete-gem':
            $route = 'admin_delete_gem';
            break;
        case 'delete-news':
            $route = 'admin_delete_news';
            break;
        case 'delete-feedback':
            $route = 'admin_delete_feedback';
            break;
        case 'discover':
            $route = 'admin_discover';
            break;
        case 'backup':
            $route = 'admin_backup';
            break;
        case 'contact':
            $route = 'admin_contact';
            break;
        case 'add-category':
            $route = 'admin_add_category';
            break;
        case 'delete-category':
            $route = 'admin_delete_category';
            break;
    }
}

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
    case 'admin_headline':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminController->headline();
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
            $adminController->viewGems();
        }
        break;
    case 'admin_delete_gem':
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id > 0) {
            if (Gemstone::delete($id)) {
                $_SESSION['admin_success'] = 'Gemstone listing successfully removed from the vault.';
            } else {
                $_SESSION['admin_error'] = 'Failed to remove gemstone from the vault.';
            }
        }
        header('Location: ' . BASE_URL . '/admin/#gems');
        exit;
        break;
    case 'admin_delete_news':
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id > 0) {
            $article = Article::getById($id);
            if ($article && in_array($article['slug'], ['heritage-philosophies', 'discover-page', 'contact-details'])) {
                $_SESSION['admin_error'] = 'Cannot delete internal system pages.';
            } else {
                if (Article::delete($id)) {
                    $_SESSION['admin_success'] = 'Editorial insight article successfully deleted.';
                } else {
                    $_SESSION['admin_error'] = 'Failed to delete article.';
                }
            }
        }
        header('Location: ' . BASE_URL . '/admin/#news');
        exit;
        break;
    case 'admin_feedback_status':
        $adminController->feedbackStatus();
        break;
    case 'admin_delete_feedback':
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id > 0) {
            require_once APP_ROOT . '/models/Feedback.php';
            if (Feedback::delete($id)) {
                $_SESSION['admin_success'] = 'Client reflection successfully cleared from moderation queue.';
            } else {
                $_SESSION['admin_error'] = 'Failed to clear feedback listing.';
            }
        }
        header('Location: ' . BASE_URL . '/admin/#feedbacks');
        exit;
        break;
    case 'admin_discover':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminController->discover();
        } else {
            header('Location: ' . BASE_URL . '/admin/#discover');
            exit;
        }
        break;
    case 'admin_backup':
        $adminController->backup();
        break;
    case 'admin_contact':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminController->contact();
        } else {
            header('Location: ' . BASE_URL . '/admin/#contact');
            exit;
        }
        break;
    case 'admin_add_category':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminController->addCategory();
        } else {
            header('Location: ' . BASE_URL . '/admin/#gems');
            exit;
        }
        break;
    case 'admin_delete_category':
        $adminController->deleteCategory();
        break;

    case 'home':
    default:
        $homeController->index();
        break;
}
