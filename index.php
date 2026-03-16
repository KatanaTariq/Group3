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

define('BASE_URL', '/Group3');

require __DIR__ . '/src/security.php';
send_security_headers();

// ===============================
// ADMIN ROUTE GUARD (Sprint 3)
// ===============================
function requireAdmin(): void
{
    if (empty($_SESSION['admin_id'])) {
        header('Location: /Group3/admin/login?err=session');
        exit;
    }
}

// ===============================
// DATABASE
// ===============================
require __DIR__ . '/config/database.php';

// ===============================
// MODELS (only what we actually use here)
// ===============================
require __DIR__ . '/src/model/Admin.php';
require __DIR__ . '/src/model/Inventory.php';
require __DIR__ . '/src/model/InventoryLog.php';

// ===============================
// CONTROLLERS (only what exists in your repo)
// ===============================
require __DIR__ . '/src/controller/BaseController.php';
require __DIR__ . '/src/controller/Controller.php';
require __DIR__ . '/src/controller/AdminController.php';
require __DIR__ . '/src/controller/InventoryController.php';

// ===============================
// INIT CONTROLLERS
// ===============================
$adminController     = new AdminController($pdo);
$inventoryController = new InventoryController($pdo);

// ===============================
// ROUTES
// ===============================
switch ($requestPath) {

    // -------------------------------
    // PUBLIC PAGES
    // -------------------------------
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

    case '/shop-women':
        require __DIR__ . '/src/view/pages/womens.php';
        break;

    case '/shop-men':
        require __DIR__ . '/src/view/pages/mens.php';
        break;

    case '/basket':
        require __DIR__ . '/src/view/pages/basket.php';
        break;

    case '/checkout':
        require __DIR__ . '/src/view/pages/checkout.php';
        break;

    case '/profile':
        require __DIR__ . '/src/view/pages/profile.php';
        break;

    case '/previous-orders':
        require __DIR__ . '/src/view/pages/previous_orders.php';
        break;

    // -------------------------------
    // CUSTOMER LOGIN/SIGNUP PAGES (NO AUTH CLASS)
    // -------------------------------
    case '/login':
        // Just shows the page (since Auth.php is empty)
        require __DIR__ . '/src/view/pages/login.php';
        break;

    case '/signup':
        // If your repo uses signup.php, keep this
        require __DIR__ . '/src/view/pages/signup.php';
        break;

    case '/logout':
        // If you don't have a customer logout implementation, just redirect home
        header('Location: /Group3/home');
        exit;

    // -------------------------------
    // ✅ ADMIN AUTH (Sprint 3)
    // -------------------------------
    case '/admin/login':
        ($_SERVER['REQUEST_METHOD'] === 'POST')
            ? $adminController->login()
            : $adminController->showLogin();
        break;

    case '/admin/logout':
        $adminController->logout();
        break;

    // -------------------------------
    // ✅ ADMIN INVENTORY (Sprint 3) — PROTECTED
    // -------------------------------
    case '/admin/inventory':
        requireAdmin();
        $inventoryController->index();
        break;

    case '/admin/inventory/update':
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Location: /Group3/admin/inventory');
            exit;
        }

        $inventoryController->updateStock();
        break;

    case '/admin/inventory/logs':
        requireAdmin();
        $inventoryController->logs();
        break;

    // -------------------------------
    // FALLBACK
    // -------------------------------
    default:
        http_response_code(404);
        require __DIR__ . '/src/view/pages/404.php';
        break;
}