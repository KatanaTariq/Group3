<?php
$currentPath = strtok($_SERVER['REQUEST_URI'], '?');

$showSearch = str_starts_with($currentPath, '/shop-women')
           || str_starts_with($currentPath, '/shop-men')
           || $currentPath === '/search';

$searchValue = isset($_GET['search']) ? trim($_GET['search']) : '';
?>

<nav class="site-nav">
    <a href="/home" class="nav-brand">
        <img src="/public/images/logos/athletiq_logo.png" alt="Athletiq Logo" class="logo-img">
    </a>

    <ul class="nav-links">
        <li><a href="/home">Home</a></li>
        <li><a href="/shop-women">Women</a></li>
        <li><a href="/shop-men">Men</a></li>
    </ul>

    <?php if ($showSearch): ?>
        <form class="search-box" method="GET" action="/search">
            <input
                type="text"
                name="search"
                placeholder="Search products..."
                value="<?php echo htmlspecialchars($search ?? ''); ?>"
            >
        </form>
    <?php endif; ?>

    <div class="auth-btns">
        <a href="/basket" class="basket-btn">View Basket</a>

        <?php if (isset($_SESSION['customer_id'])): ?>
            <a href="/profile" class="profile-btn">Profile</a>
            <a href="/logout" class="login-btn">Log Out</a>
        <?php else: ?>
            <a href="/signup" class="signup-btn">Sign Up</a>
            <a href="/login" class="login-btn">Log In</a>
        <?php endif; ?>
    </div>
</nav>