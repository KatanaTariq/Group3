<?php

// ===============================
// ROUTING SETUP
// ===============================
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

// Remove index.php from URL
$requestPath = str_replace('/index.php', '', $requestPath);

// Remove base folder (/Group3) for XAMPP
$basePath = '/Group3';
if (stripos($requestPath, $basePath) === 0) {
    $requestPath = substr($requestPath, strlen($basePath));
}

// Normalise path
if ($requestPath === '' || $requestPath[0] !== '/') {
    $requestPath = '/' . ltrim($requestPath, '/');
}
if ($requestPath !== '/') {
    $requestPath = rtrim($requestPath, '/');
}

// ===============================
// SESSION + SECURITY
// ===============================
session_start();

require __DIR__ . '/src/security.php';
send_security_headers();

// ===============================
// DATABASE
// ===============================
include __DIR__ . '/config/database.php';

// ===============================
// MODELS
// ===============================
include __DIR__ . '/src/model/Admin.php';
include __DIR__ . '/src/model/Auth.php';
include __DIR__ . '/src/model/Basket.php';
include __DIR__ . '/src/model/Customer.php';
include __DIR__ . '/src/model/Order.php';
include __DIR__ . '/src/model/Product.php';
include __DIR__ . '/src/model/Wishlist.php';

// ✅ Inventory (Sprint 1 – Tariq)
include __DIR__ . '/src/model/InventoryModel.php';

// ===============================
// CONTROLLERS
// ===============================
require __DIR__ . '/src/controller/Controller.php';
require __DIR__ . '/src/controller/InventoryController.php';

// ===============================
// INIT CONTROLLERS
// ===============================
$auth = new AuthController($pdo);

// ===============================
// ROUTES
// ===============================
switch ($requestPath) {

    case '/':
    case '/home':
        require __DIR__ . '/src/view/pages/home.php';
        break;

    case '/about':
        require __DIR__ . '/src/view/pages/about.php';
        break;

    case '/contact':
        require __DIR__ . '/src/view/pages/contact.php';
        break;

    case '/signup':
        ($_SERVER['REQUEST_METHOD'] === 'POST')
            ? $auth->register()
            : $auth->displayRegister();
        break;

    case '/login':
        ($_SERVER['REQUEST_METHOD'] === 'POST')
            ? $auth->login()
            : $auth->displayLogin();
        break;

    case '/logout':
        $auth->logout();
        break;

    case '/profile':
        require __DIR__ . '/src/view/pages/profile.php';
        break;

    case '/previous-orders':
        require __DIR__ . '/src/view/pages/previous_orders.php';
        break;

    case '/basket':
        require __DIR__ . '/src/view/pages/basket.php';
        break;

    case '/checkout':
        require __DIR__ . '/src/view/pages/checkout.php';
        break;

    case '/shop-women':
        require __DIR__ . '/src/view/pages/womens.php';
        break;

    case '/shop-men':
        require __DIR__ . '/src/view/pages/mens.php';
        break;

    case '/admin/login':
    // TEMP: Admin login page not present in this repo snapshot.
    // Using standard login page so Inventory redirects don't 404.
    require __DIR__ . '/src/view/pages/login.php';
    break;



    // ===============================
    // ✅ ADMIN INVENTORY (Sprint 1 – Tariq)
    // ===============================
    case '/admin/inventory':
        (new InventoryController($pdo))->index();
        break;

    case '/admin/inventory/update':
        (new InventoryController($pdo))->update();
        break;

    case '/admin/inventory/logs':
        (new InventoryController($pdo))->logs();
        break;

    default:
        http_response_code(404);
        require __DIR__ . '/src/view/pages/404.php';
        break;
}
