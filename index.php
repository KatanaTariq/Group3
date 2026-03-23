<?php

$request = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($request, PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$requestPath = str_replace('/index.php', '', $requestPath);
if ($requestPath === '') {
    $requestPath = '/';
}

session_start();

require __DIR__ . '/src/security.php';
send_security_headers();

include __DIR__ . "/config/database.php";

include __DIR__ . '/src/model/Admin.php';
include __DIR__ . '/src/model/Basket.php';
include __DIR__ . '/src/model/Customer.php';
include __DIR__ . '/src/model/Order.php';
include __DIR__ . '/src/model/Product.php';
include __DIR__ . '/src/model/Inventory.php';

require __DIR__ . '/src/controller/Controller.php';

function requireAdmin(): void
{
    if (empty($_SESSION['admin_id'])) {
        header('Location: /admin/login?err=session');
        exit;
    }
}

/**
 * Route table mapping METHOD + PATH to a [ControllerClass, action] pair.
 * All POST routes are expected to handle their own CSRF validation.
 */
$routes = [
    'GET' => [
        '/' => [PageController::class, 'home'],
        '/home' => [PageController::class, 'home'],
        '/about' => [PageController::class, 'about'],
        '/contact' => [PageController::class, 'contact'],
        '/profile' => [PageController::class, 'profile'],
        '/previous-orders' => [PageController::class, 'previousOrders'],
        '/order-details' => [PageController::class, 'orderDetails'],
        '/basket' => [BasketController::class, 'index'],
        '/checkout' => [PageController::class, 'checkout'],
        '/shop-women' => [PageController::class, 'womens'],
        '/shop-men' => [PageController::class, 'mens'],
        '/product' => [PageController::class, 'product'],
        '/signup' => [AuthController::class, 'displayRegister'],
        '/login' => [AuthController::class, 'displayLogin'],
        '/logout' => [AuthController::class, 'logout'],

        '/admin/login' => [AdminController::class, 'showLogin'],
        '/admin/logout' => [AdminController::class, 'logout'],
        '/admin/inventory' => [InventoryController::class, 'index'],
        '/admin/inventory/logs' => [InventoryController::class, 'logs'],
    ],
    'POST' => [
        '/signup' => [AuthController::class, 'register'],
        '/login' => [AuthController::class, 'login'],
        '/basket/add' => [BasketController::class, 'add'],
        '/basket/update' => [BasketController::class, 'update'],
        '/basket/remove' => [BasketController::class, 'remove'],
        '/basket/update-size' => [BasketController::class, 'updateSize'],
        '/checkout/process' => [CheckoutController::class, 'process'],
        '/admin/login' => [AdminController::class, 'login'],
        '/admin/inventory/update' => [InventoryController::class, 'updateStock'],
    ],
];

$handler = $routes[$method][$requestPath] ?? null;

// Unmatched routes go to a 404
if (!$handler) {
    http_response_code(404);
    require __DIR__ . '/src/view/pages/404.php';
    exit;
}

if (in_array($requestPath, [
    '/admin/inventory',
    '/admin/inventory/update',
    '/admin/inventory/logs',
], true)) {
    requireAdmin();
}

[$controllerClass, $action] = $handler;

$controller = new $controllerClass($pdo);
$controller->$action();