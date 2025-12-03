<?php
// Create database connection
include __DIR__ . "/config/database.php";

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
    // ADMIN AUTH / DASHBOARD
    // ======================
    case '/admin/login':
        require __DIR__ . '/src/view/pages/admin/login.php';
        break;

    case '/admin/home':
    case '/admin/dashboard':
        require __DIR__ . '/src/view/pages/admin/home.php';
        break;

    // ======================
    // ADMIN INVENTORY (Tariq)
    // ======================

    // Main inventory management page
    case '/admin/inventory':
        $controller = new InventoryController($pdo);
        $controller->index();
        break;

    // Handle stock update form submissions (POST only)
    case '/admin/inventory/update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller = new InventoryController($pdo);
            $controller->updateStock();
        } else {
            header('Location: /admin/inventory');
            exit;
        }
        break;

    // Inventory change log page
    case '/admin/inventory/logs':
        $controller = new InventoryController($pdo);
        $controller->logs();
        break;

    // ======================
    // 404 FALLBACK
    // ======================
    default:
        http_response_code(404);
        require __DIR__ . '/src/view/pages/404.php';
        break;
}


