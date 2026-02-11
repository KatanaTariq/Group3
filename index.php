<?php
// Create database connection
include __DIR__ . "/config/database.php";

// Start session once for the whole app
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load the controllers
require __DIR__ . '/src/controller/BaseController.php';
require __DIR__ . '/src/controller/AdminController.php';
require __DIR__ . '/src/controller/AuthController.php';
require __DIR__ . '/src/controller/BasketController.php';
require __DIR__ . '/src/controller/CustomerController.php';
require __DIR__ . '/src/controller/OrderController.php';
require __DIR__ . '/src/controller/ProductController.php';
require __DIR__ . '/src/controller/ReturnController.php';
require __DIR__ . '/src/controller/ReviewController.php';
require __DIR__ . '/src/controller/WishlistController.php';
require __DIR__ . '/src/controller/InventoryController.php';

// Get the current request URL
$request = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($request, PHP_URL_PATH);

// Remove /index.php from path if present
$requestPath = str_replace('/index.php', '', $requestPath);
if ($requestPath === '') {
    $requestPath = '/';
}

// Remove the /Group3 prefix (project folder) so routing works
$basePath = '/Group3';
if (strpos($requestPath, $basePath) === 0) {
    $requestPath = substr($requestPath, strlen($basePath));
    if ($requestPath === '') {
        $requestPath = '/';
    }
}

// ======================
// GLOBAL ADMIN ROUTE GUARD (PHP 7+ compatible)
// Protect all /admin routes except /admin/login
// ======================
$isAdminRoute = (strpos($requestPath, '/admin') === 0);
$isAdminLogin = ($requestPath === '/admin/login');

if ($isAdminRoute && !$isAdminLogin && empty($_SESSION['admin_id'])) {
    header('Location: /Group3/admin/login?err=session');
    exit;
}

// Simple routers
switch ($requestPath) {

    // ======================
    // PUBLIC PAGES
    // ======================
    case '/':
    case '/home':
        require __DIR__ . '/src/view/pages/home.php';
        break;

    case '/login':
        require __DIR__ . '/src/view/pages/login.php';
        break;

    // ======================
    // ADMIN AUTH
    // ======================
    case '/admin/login':
        $controller = new AdminController($pdo);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->login();
        } else {
            $controller->showLogin();
        }
        break;

    case '/admin/logout':
        $controller = new AdminController($pdo);
        $controller->logout();
        break;

    // ======================
    // ADMIN DASHBOARD
    // ======================
    case '/admin/home':
    case '/admin/dashboard':
        require __DIR__ . '/src/view/pages/admin/dashboard.php';
        break;

    // ======================
    // ADMIN INVENTORY (Tariq)
    // ======================

    case '/admin/inventory':
        $controller = new InventoryController($pdo);
        $controller->index();
        break;

    case '/admin/inventory/update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller = new InventoryController($pdo);
            $controller->updateStock();
        } else {
            header('Location: /Group3/admin/inventory');
            exit;
        }
        break;

    case '/admin/inventory/logs':
        require __DIR__ . '/src/view/pages/admin/inventory_logs.php';
        break;

    // ======================
    // 404 FALLBACK
    // ======================
    default:
        http_response_code(404);
        require __DIR__ . '/src/view/pages/404.php';
        break;
}