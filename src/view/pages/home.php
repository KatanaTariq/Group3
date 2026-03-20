<?php $title = 'Athletiq | Home'; ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<section class="hero">
    <div id="hero-slideshow" class="hero-img"></div>
    <div class="hero-text">
        <h1>Welcome to Athletiq</h1>
        <p>Premium sportswear. Designed for the Athletiqs, by the athletes.</p>
        <a href="/about">
            <button class="learn-more-btn">Learn more about us</button>
        </a>
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
    <h2>Just In!</h2>
    <p>Browse our newest arrivals at Athletiq.</p>

    <div class="products">

        <div class="product-card">
            <img src="/public/images/productImages/home_women_running_spikes.png" alt="Women Running Spikes">
            <h3>Women's Running Spikes</h3>
            <a href="/shop-women">
                <button class="product-btn">View Product</button>
            </a>
        </div>

        <div class="product-card">
            <img src="/public/images/productImages/home_men_football_boot.png" alt="Men Football Boots">
            <h3>Men's Football Boots</h3>
            <a href="/shop-men">
                <button class="product-btn">View Product</button>
            </a>
        </div>

        <div class="product-card">
            <img src="/public/images/productImages/home_women_running_shoes.png" alt="Women Running Shoes">
            <h3>Women's Running Shoes</h3>
            <a href="/shop-women">
                <button class="product-btn">View Product</button>
            </a>
        </div>

    </div>
</section>

<section class="signup-promo">
    <h2>Love Athletiq?</h2>
    <p>Join our Athletiq champions and sign up now. 10% welcome voucher included, plus exclusive member deals.</p>
    <a href="/signup">
        <button class="signup-btn">Sign Up Now</button>
    </a>
</section>

<script src="/public/js/home.js"></script>
<?php include __DIR__ . '/../templates/footer.php'; ?>
