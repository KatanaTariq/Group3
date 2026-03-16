<?php
require_once __DIR__ . '/../../config.php';
?>

<nav>
    <a href="<?= BASE_URL ?>/admin/inventory">
        <img 
            src="<?= BASE_URL ?>/public/images/logos/athletiq_logo.png"
            alt="Athletiq Logo"
            class="logo-img"
        >
    </a>

    <ul class="nav-links">
        <li><a href="<?= BASE_URL ?>/admin/inventory">Inventory</a></li>
        <li><a href="<?= BASE_URL ?>/admin/inventory/logs">Inventory Logs</a></li>
    </ul>

    <div class="search-box"></div>

    <div class="auth-btns">
        <a href="<?= BASE_URL ?>/admin/logout" class="login-btn">Log Out</a>
    </div>
</nav>