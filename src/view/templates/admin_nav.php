<?php
// Admin nav: matches the exact frontend nav structure/classes (nav.php)
?>

<nav>
    <a href="/admin/inventory">
        <img src="/public/images/logos/athletiq_logo.png" alt="Athletiq Logo" class="logo-img">
    </a>

    <ul class="nav-links">
        <li><a href="/admin/inventory">Inventory</a></li>
        <li><a href="/admin/inventory/logs">Inventory Logs</a></li>
    </ul>

    <!-- Keep spacing consistent with frontend nav layout -->
    <div class="search-box"></div>

    <div class="auth-btns">
        <a href="/admin/logout" class="login-btn">Log Out</a>
    </div>
</nav>