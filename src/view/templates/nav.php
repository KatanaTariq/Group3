<nav>
    <img src="/src/view/images/logos/athletiq_logo.png" alt="Athletiq Logo" class="logo-img" onclick="location.href='/home'">

    <ul class="nav-links">
        <li><a href="/home">Home</a></li>
        <li><a href="/shop-women">Women</a></li>
        <li><a href="/shop-men">Men</a></li>
    </ul>

    <div class="search-box">
        <input type="text" placeholder="Search products...">
    </div>

    <div class="auth-btns">
        <button onclick="location.href='/basket'" class="basket-btn">View Basket</button>
        <?php if (isset($_SESSION['user_id'])): ?>
            <button onclick="location.href='/logout'" class="login-btn">Log Out</button>
        <?php else: ?>
            <button onclick="location.href='/login'" class="signup-btn">Sign Up</button>
            <button onclick="location.href='/login'" class="login-btn">Log In</button>
        <?php endif; ?>
    </div>
</nav>