<?php

// Front Controller / Entry Point
require_once dirname(__FILE__) . '/app/config/config.php';
require_once APP_ROOT . '/controllers/HomeController.php';

$controller = new HomeController();

$route = isset($_GET['route']) ? trim($_GET['route']) : 'home';

switch ($route) {
    case 'inquire':
        $controller->inquire();
        break;
    case 'newsletter':
        $controller->newsletter();
        break;
    case 'heritage':
        $controller->heritage();
        break;
    case 'home':
    default:
        $controller->index();
        break;
}
