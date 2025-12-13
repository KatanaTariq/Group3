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

// Include Models
include __DIR__ . '/src/model/Admin.php';
include __DIR__ . '/src/model/Auth.php';
include __DIR__ . '/src/model/Basket.php';
include __DIR__ . '/src/model/Customer.php';
include __DIR__ . '/src/model/Order.php';
include __DIR__ . '/src/model/Product.php';
include __DIR__ . '/src/model/Wishlist.php';

// Include Controllers
require __DIR__ . '/src/controller/Controller.php';

// Initialise Controllers
$auth = new AuthController($pdo);

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

    default:
        handle404Request();
        break;
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

        // Display the Registration Form for GET Requests
        case 'GET':
            $auth->displayRegister();
            break;
        
        // Handle Registration Form Submission for POST Requests
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

        // Display the Login Form for GET Requests
        case 'GET':
            $auth->displayLogin();
            break;
        
        // Handle Login Form Submission for POST Requests
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
 * Handles 404 Page Requests
 * 
 * @return void
 */
function handle404Request() {
    http_response_code(404);
    require __DIR__ . '/src/view/pages/404.php';
}
