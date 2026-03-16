<?php
// BASE_URL should already be defined in index.php (router).
// This is just a safety fallback — it will NOT override it.
if (!defined('BASE_URL')) {
    define('BASE_URL', '/Group3');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athletiq</title>

    <!-- Global CSS (always loaded) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/nav.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/footer.css">

    <!-- Page-specific CSS (safe to load all for a uni project) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/home.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/login.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/signup.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/about.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/contact.css">

    <!-- Boxicons (used in contact page) -->
    <link rel="stylesheet" href="https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css">
</head>
<body>