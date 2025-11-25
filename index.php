<?php
// Create database connection
include __DIR__ . "/config/database.php";

// Load the controllers
require __DIR__ . '/controller/BaseController.php';
require __DIR__ . '/controller/AdminController.php';
require __DIR__ . '/controller/AuthController.php';
require __DIR__ . '/controller/BasketController.php';
require __DIR__ . '/controller/CustomerController.php';
require __DIR__ . '/controller/OrderController.php';
require __DIR__ . '/controller/ProductController.php';
require __DIR__ . '/controller/ReturnController.php';
require __DIR__ . '/controller/ReviewController.php';
require __DIR__ . '/controller/WishlistController.php';

// Get the current request URL
$request = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($request, PHP_URL_PATH);

// Simple routers
switch ($requestPath) {

    // Home page
    case '/':
        require __DIR__ . '/view/home.php';
        break;

    // Login page
    case '/login':
        require __DIR__ . '/view/login.php';
        break;

    // 404 fallback
    default:
        http_response_code(404);
        require __DIR__ . '/view/404.php';
        break;
}

