<?php
// No config include here.
// BASE_URL is defined in index.php (router).
?>

<nav>
    <a href="<?= BASE_URL ?>/home">
        <img 
            src="<?= BASE_URL ?>/public/images/logos/athletiq_logo.png"
            alt="Athletiq Logo"
            class="logo-img"
        >
    </a>

    <ul class="nav-links">
        <li><a href="<?= BASE_URL ?>/home">Home</a></li>
        <li><a href="<?= BASE_URL ?>/shop-women">Women</a></li>
        <li><a href="<?= BASE_URL ?>/shop-men">Men</a></li>
    </ul>

    <div class="search-box">
        <input type="text" placeholder="Search products...">
    </div>

    <div class="auth-btns">
        <?php if (isset($_SESSION['customer_id'])): ?>
            <a href="<?= BASE_URL ?>/basket" class="basket-btn">View Basket</a>
            <a href="<?= BASE_URL ?>/logout" class="login-btn">Log Out</a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>/signup" class="signup-btn">Sign Up</a>
            <a href="<?= BASE_URL ?>/login" class="login-btn">Log In</a>
        <?php endif; ?>
    </div>
</nav>