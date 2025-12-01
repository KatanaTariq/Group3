<?php

// Routing
$request = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($request, PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Clean up the request path - remove index
$requestPath = str_replace('/index.php', '', $requestPath);
if ($requestPath === '') {
    $requestPath = '/';
}

// Start session
session_start();

// Create connection to database
include __DIR__ . "/config/database.php";

// Create Models
include __DIR__ . '/src/model/Admin.php';
include __DIR__ . '/src/model/Auth.php';
include __DIR__ . '/src/model/Basket.php';
include __DIR__ . '/src/model/Customer.php';
include __DIR__ . '/src/model/Order.php';
include __DIR__ . '/src/model/Product.php';
include __DIR__ . '/src/model/Wishlist.php';

// Include the controllers
require __DIR__ . '/src/controller/AdminController.php';
require __DIR__ . '/src/controller/AuthController.php';
require __DIR__ . '/src/controller/BasketController.php';
require __DIR__ . '/src/controller/CustomerController.php';
require __DIR__ . '/src/controller/OrderController.php';
require __DIR__ . '/src/controller/ProductController.php';
require __DIR__ . '/src/controller/ReturnController.php';
require __DIR__ . '/src/controller/ReviewController.php';
require __DIR__ . '/src/controller/WishlistController.php';

// Initialise controllers
$auth = new AuthController($pdo);
$auth = new ProductController($pdo);

switch ($requestPath) {

    case '/':
    case '/home':
        handleHomeRequest();
        break;

    case '/about':
        handleAboutRequest();
        break;

    case '/register':
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

    case '/basket':
        handleBasketRequest();
        break;

    case '/checkout':
        handleCheckoutRequest();
        break;

    case '/women':
    case '/womenspage':
        handleWomenPageRequest();
        break;

    default:
        handle404Request();
        break;
}

/**
 * Handles home page requests
 * 
 * @return void
 */
function handleHomeRequest() {
    require __DIR__ . '/src/view/pages/home.php';
}

/**
 * Handles about page requests
 *
 * @return void
 */
function handleAboutRequest() {
    require __DIR__ . '/src/view/pages/about.php';
}

/**
 * Handle registration page requests
 * 
 * @return void
 */
function handleRegisterRequest() {
    global $auth;

    switch ($_SERVER['REQUEST_METHOD']) {

        // display the registration form for GET requests
        case 'GET':
            $auth->displayRegister();
            break;
        
        // handle registration form submission for POST requests
        case 'POST':
            $auth->register();
            break;
    }
}

/**
 * Handle login page requests
 * 
 * @return void
 */
function handleLoginRequest() {
    global $auth;

    switch ($_SERVER['REQUEST_METHOD']) {

        // display the login form for GET requests
        case 'GET':
            $auth->displayLogin();
            break;
        
        // handle login form submission for POST requests
        case 'POST':
            $auth->login();
            break;
    }
}

/**
 * Handle logout requests
 * 
 * @return void
 */
function handleLogoutRequest() {
    global $auth;
    $auth->logout();
}

/**
 * Handle profile page requests
 * 
 * @return void
 */
function handleProfileRequest() {
    require __DIR__ . '/src/view/pages/profile.php';
}

/**
 * Handles basket page requests
 *
 * @return void
 */
function handleBasketRequest() {
    require __DIR__ . '/src/view/pages/basket.php';
}

/**
 * Handles checkout page requests
 *
 * @return void
 */
function handleCheckoutRequest() {
    require __DIR__ . '/src/view/pages/checkout.php';
}

/**
 * Handles women's category page requests
 *
 * @return void
 */
function handleWomenPageRequest() {
    require __DIR__ . '/src/view/pages/womensPage.php';
}

/**
 * Handle 404 page requests
 * 
 * @return void
 */
function handle404Request() {
    http_response_code(404);
    require __DIR__ . '/src/view/pages/404.php';
}