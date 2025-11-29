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

// Get the current request URL
$request = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($request, PHP_URL_PATH);

// Remove /index.php from path if present
$requestPath = str_replace('/index.php', '', $requestPath);
if ($requestPath === '') {
    $requestPath = '/';
}

// Basic Router
switch ($requestPath) {
    // Home page
    case '/':
    case '/home':
        require __DIR__ . '/src/view/pages/home.php';
        break;

    // Login page
    case '/login':
        require __DIR__ . '/src/view/pages/login.php';
        break;

    // 404 fallback
    default:
        http_response_code(404);
        require __DIR__ . '/src/view/pages/404.php';
        break;
}
