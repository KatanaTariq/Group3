<?php

// Routing
$request = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($request, PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Clean Up the Request Path - Remove index.php
$requestPath = str_replace('/index.php', '', $requestPath);

// Remove base folder for XAMPP
$basePath = '/Group3';
if (stripos($requestPath, $basePath) === 0) {
    $requestPath = substr($requestPath, strlen($basePath));
}

// Normalise Request Path
if ($requestPath === '' || $requestPath[0] !== '/') {
    $requestPath = '/' . ltrim($requestPath, '/');
}
if ($requestPath !== '/') {
    $requestPath = rtrim($requestPath, '/');
}
if ($requestPath === '') {
    $requestPath = '/';
}

// Start Session
session_start();

// Base URL
define('BASE_URL', '/Group3');

// Security helper (input validation, CSRF, headers)
require __DIR__ . '/src/security.php';

// Send secure HTTP headers on every request
send_security_headers();

// Create Connection to Database
require __DIR__ . "/config/database.php";

// Include Models
require __DIR__ . '/src/model/Admin.php';
require __DIR__ . '/src/model/Auth.php';
require __DIR__ . '/src/model/Basket.php';
require __DIR__ . '/src/model/Customer.php';
require __DIR__ . '/src/model/Inventory.php';
require __DIR__ . '/src/model/InventoryLog.php';
require __DIR__ . '/src/model/Order.php';
require __DIR__ . '/src/model/Product.php';
require __DIR__ . '/src/model/Wishlist.php';

// Include Controllers
require __DIR__ . '/src/controller/BaseController.php';
require __DIR__ . '/src/controller/Controller.php';
require __DIR__ . '/src/controller/AdminController.php';
require __DIR__ . '/src/controller/InventoryController.php';

// Initialise Controllers
$auth = new AuthController($pdo);
$adminController = new AdminController($pdo);
$inventoryController = new InventoryController($pdo);

switch ($requestPath) {

    case '/':
    case '/home':
        handleHomeRequest();
        break;

    case '/about':
        handleAboutRequest();
        break;

    case '/contact':
        handleContactRequest();
        break;

    case '/signup':
        handleRegisterRequest();
        break;

    case '/login':
        handleLoginRequest();
        break;

    case '/logout':
        handleLogoutRequest();
        break;

    case '/profile':
        handleProfileRequest();
        break;

    case '/previous-orders':
        handlePreviousOrdersRequest();
        break;

    case '/basket':
        handleBasketRequest();
        break;

    case '/checkout':
        handleCheckoutRequest();
        break;

    case '/shop-women':
        handleWomenPageRequest();
        break;

    case '/shop-men':
        handleMenPageRequest();
        break;

    case '/admin/login':
        handleAdminLoginRequest();
        break;

    case '/admin/logout':
        handleAdminLogoutRequest();
        break;

    case '/admin/inventory':
        handleAdminInventoryRequest();
        break;

    case '/admin/inventory/update':
        handleAdminInventoryUpdateRequest();
        break;

    case '/admin/inventory/logs':
        handleAdminInventoryLogsRequest();
        break;

    default:
        handle404Request();
        break;
}

/**
 * Restricts access to admin-only routes
 *
 * @return void
 */
function requireAdmin() {
    if (empty($_SESSION['admin_id'])) {
        header('Location: ' . BASE_URL . '/admin/login?err=session');
        exit;
    }
}

/**
 * Handles Home Page Requests
 * 
 * @return void
 */
function handleHomeRequest() {
    require __DIR__ . '/src/view/pages/home.php';
}

/**
 * Handles About Page Requests
 * 
 * @return void
 */
function handleAboutRequest() {
    require __DIR__ . '/src/view/pages/about.php';
}

/**
 * Handles Contact Page Requests
 *
 * @return void
 */
function handleContactRequest() {
    require __DIR__ . '/src/view/pages/contact.php';
}

/**
 * Handles Registration Page Requests
 * 
 * @return void
 */
function handleRegisterRequest() {
    global $auth;

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $auth->displayRegister();
            break;

        case 'POST':
            $auth->register();
            break;
    }
}

/**
 * Handles Login Page Requests
 * 
 * @return void
 */
function handleLoginRequest() {
    global $auth;

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $auth->displayLogin();
            break;

        case 'POST':
            $auth->login();
            break;
    }
}

/**
 * Handles Logout Requests
 * 
 * @return void
 */
function handleLogoutRequest() {
    global $auth;
    $auth->logout();
}

/**
 * Handles Profile Page Requests
 * 
 * @return void
 */
function handleProfileRequest() {
    require __DIR__ . '/src/view/pages/profile.php';
}

/**
 * Handles Previous Orders Page Requests
 *
 * @return void
 */
function handlePreviousOrdersRequest() {
    require __DIR__ . '/src/view/pages/previous_orders.php';
}

/**
 * Handles Basket Page Requests
 *
 * @return void
 */
function handleBasketRequest() {
    require __DIR__ . '/src/view/pages/basket.php';
}

/**
 * Handles Checkout Page Requests
 *
 * @return void
 */
function handleCheckoutRequest() {
    require __DIR__ . '/src/view/pages/checkout.php';
}

/**
 * Handles Women's Category Page Requests
 *
 * @return void
 */
function handleWomenPageRequest() {
    require __DIR__ . '/src/view/pages/womens.php';
}

/**
 * Handles Men's Category Page Requests
 *
 * @return void
 */
function handleMenPageRequest() {
    require __DIR__ . '/src/view/pages/mens.php';
}

/**
 * Handles Admin Login Requests
 *
 * @return void
 */
function handleAdminLoginRequest() {
    global $adminController;

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $adminController->showLogin();
            break;

        case 'POST':
            $adminController->login();
            break;
    }
}

/**
 * Handles Admin Logout Requests
 *
 * @return void
 */
function handleAdminLogoutRequest() {
    global $adminController;
    $adminController->logout();
}

/**
 * Handles Admin Inventory Page Requests
 *
 * @return void
 */
function handleAdminInventoryRequest() {
    global $inventoryController;
    requireAdmin();
    $inventoryController->index();
}

/**
 * Handles Admin Inventory Update Requests
 *
 * @return void
 */
function handleAdminInventoryUpdateRequest() {
    global $inventoryController;

    requireAdmin();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        header('Location: ' . BASE_URL . '/admin/inventory');
        exit;
    }

    $inventoryController->updateStock();
}

/**
 * Handles Admin Inventory Logs Requests
 *
 * @return void
 */
function handleAdminInventoryLogsRequest() {
    global $inventoryController;
    requireAdmin();
    $inventoryController->logs();
}

/**
 * Handles 404 Page Requests
 * 
 * @return void
 */
function handle404Request() {
    http_response_code(404);
    require __DIR__ . '/src/view/pages/404.php';
}