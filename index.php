<?php

// Routing
$request = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($request, PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Clean Up the Request Path - Remove index.php
$requestPath = str_replace('/index.php', '', $requestPath);
if ($requestPath === '') {
    $requestPath = '/';
}

// Start Session
session_start();

// Security helper (input validation, CSRF, headers)
require __DIR__ . '/src/security.php';

// Send secure HTTP headers on every request
send_security_headers();

// Create Connection to Database
include __DIR__ . "/config/database.php";

// Include Models (keep these as-is if your project needs them loaded early)
include __DIR__ . '/src/model/Admin.php';
include __DIR__ . '/src/model/Auth.php';
include __DIR__ . '/src/model/Basket.php';
include __DIR__ . '/src/model/Customer.php';
include __DIR__ . '/src/model/Order.php';
include __DIR__ . '/src/model/Product.php';
include __DIR__ . '/src/model/Wishlist.php';

// Include Controllers (your single big controller file)
require __DIR__ . '/src/controller/Controller.php';

/**
 * Route table: METHOD + PATH => [ControllerClass, method]
 */
$routes = [
    'GET' => [
        '/' => [PageController::class, 'home'],
        '/home' => [PageController::class, 'home'],
        '/about' => [PageController::class, 'about'],
        '/contact' => [PageController::class, 'contact'],

        '/profile' => [PageController::class, 'profile'],
        '/previous-orders' => [PageController::class, 'previousOrders'],
        '/basket' => [PageController::class, 'basket'],
        '/checkout' => [PageController::class, 'checkout'],
        '/shop-women' => [PageController::class, 'womens'],
        '/shop-men' => [PageController::class, 'mens'],

        '/signup' => [AuthController::class, 'displayRegister'],
        '/login' => [AuthController::class, 'displayLogin'],
        '/logout' => [AuthController::class, 'logout'],
    ],
    'POST' => [
        '/signup' => [AuthController::class, 'register'],
        '/login' => [AuthController::class, 'login'],
    ],
];

// Find handler
$handler = $routes[$method][$requestPath] ?? null;

if (!$handler) {
    http_response_code(404);
    require __DIR__ . '/src/view/pages/404.php';
    exit;
}

[$controllerClass, $action] = $handler;

// Create controller instance (PDO passed in)
$controller = new $controllerClass($pdo);

// Call action
$controller->$action();
