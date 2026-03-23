<?php $title = 'Athletiq | Home'; ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<section class="hero">
    <div id="hero-slideshow" class="hero-img"></div>

    <div class="hero-text">
        <p class="hero-eyebrow">PERFORMANCE / STYLE / EVERYDAY MOVEMENT</p>
        <h1>Welcome to Athletiq</h1>
        <p>Premium sportswear built for performance, confidence, and everyday movement.</p>
        <a href="/about" class="learn-more-btn">Learn more about us</a>
    </div>
</section>

<section class="categories">
    <div class="category-box">
        <a href="/shop-men">
            <div class="img-container">
                <img src="/public/images/productImages/home_men_polo_tank.png" alt="Shop Men">
                <div class="overlay-text">Shop Men</div>
            </div>
        </a>
    </div>

    <div class="category-box">
        <a href="/shop-women">
            <div class="img-container">
                <img src="/public/images/productImages/women_polo_tee.png" alt="Shop Women">
                <div class="overlay-text">Shop Women</div>
            </div>
        </a>
    </div>
</section>

<section class="just-in">
    <div class="just-in-header">
        <p class="section-eyebrow">NEW ARRIVALS</p>
        <h2>Just In</h2>
        <p>Browse the latest drops landing at Athletiq.</p>
    </div>

    <div class="products">
        <div class="product-card">
            <img src="/public/images/productImages/home_women_running_spikes.png" alt="Women's Running Spikes">
            <div class="product-card-body">
                <h3>Women's Running Spikes</h3>
                <a href="/shop-women" class="product-btn">View Product</a>
            </div>
        </div>

        <div class="product-card">
            <img src="/public/images/productImages/home_men_football_boot.png" alt="Men's Football Boots">
            <div class="product-card-body">
                <h3>Men's Football Boots</h3>
                <a href="/shop-men" class="product-btn">View Product</a>
            </div>
        </div>

        <div class="product-card">
            <img src="/public/images/productImages/home_women_running_shoes.png" alt="Women's Running Shoes">
            <div class="product-card-body">
                <h3>Women's Running Shoes</h3>
                <a href="/shop-women" class="product-btn">View Product</a>
            </div>
        </div>
    </div>
</section>

<section class="signup-promo">
    <div class="signup-promo-inner">
        <h2>Love Athletiq?</h2>
        <p>Sign up today for a 10% welcome voucher, exclusive member offers, and first access to new drops.</p>
        <a href="/signup" class="signup-btn">Sign Up Now</a>
    </div>
</section>

<script src="/public/js/home.js"></script>
<?php include __DIR__ . '/../templates/footer.php'; ?>