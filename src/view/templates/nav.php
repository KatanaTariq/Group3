<nav>
    <a href="/home">
        <img src="/public/images/logos/athletiq_logo.png" alt="Athletiq Logo" class="logo-img">
    </a>

    <ul class="nav-links">
        <li><a href="/home">Home</a></li>
        <li><a href="/shop-women">Women</a></li>
        <li><a href="/shop-men">Men</a></li>
    </ul>

    <div class="search-box">
        <input type="text" placeholder="Search products...">
    </div>

    <div class="auth-btns">
        <a href="/basket" class="basket-btn">View Basket</a>
        <?php if (isset($_SESSION['customer_id'])): ?>
            <a href="/logout" class="login-btn">Log Out</a>
        <?php else: ?>
            <a href="/signup" class="signup-btn">Sign Up</a>
            <a href="/login" class="login-btn">Log In</a>
        <?php endif; ?>
    </div>
</nav>