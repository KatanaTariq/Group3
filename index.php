<?php

// Create connection to database
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

?>