<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Athletiq | Sportswear</title>
<link rel="stylesheet" href="/src/view/css/home.css">
</head>

<body>

<?php include __DIR__ . '/../templates/nav.php'; ?>


<section class="hero">
    <div id="hero-slideshow" class="hero-img"></div>
    <div class="hero-text">
        <h1>Welcome to Athletiq</h1>
        <p>Premium Sportswear. Designed for the Athletiqs, by the Athletes.</p>
        <a href="about.php">
            <button class="learn-more-btn">Learn more About Us</button>
        </a>
    </div>
</section>


<section class="categories">
    <div class="category-box">
        <a href="#">
            <div class="img-container">
                <img src="/src/view/images/productImages/home_men_polo_tank.png" alt="Shop Men">
                <div class="overlay-text">Shop Men</div>
            </div>
        </a>
    </div>

    <div class="category-box">
        <a href="/shop-women"> 
            <div class="img-container">
                <img src="/src/view/images/productImages/womens/women_polo_tee.png" alt="Shop Women">
                <div class="overlay-text">Shop Women</div>
            </div>
        </a>
    </div>
</section>


<section class="just-in">
    <h2>Just In!</h2>
    <p>Browse our Newest Arrivals at Athletiq.</p>

    <div class="products">

        <div class="product-card">
            <img src="/src/view/images/productImages/home_women_running_spikes.png" alt="Women Running Spikes">
            <h3>Women's Running Spikes</h3>
            <a href="/shop-women">
                <button class="product-btn">View Product</button>
            </a>
        </div>

        <div class="product-card">
            <img src="/src/view/images/productImages/home_men_football_boot.png" alt="Men Football Boots">
            <h3>Men's Football Boots</h3>
            <a href="#">
                <button class="product-btn">View Product</button>
            </a>
        </div>

        <div class="product-card">
            <img src="/src/view/images/productImages/home_women_running_shoes.png" alt="Women Running Shoes">
            <h3>Women's Running Shoes</h3>
            <a href="/shop-women">
                <button class="product-btn">View Product</button>
            </a>
        </div>

    </div>
</section>


<section class="signup-promo">
    <h2>Love Athletiq?</h2>
    <p>Join our Athletiq champions and Sign up now! 10% Welcome voucher included and other deals, exclusive to members only.</p>
    <a href="register.php">
        <button class="signup-btn">Sign Up Now</button>
    </a>
</section>


<?php include __DIR__ . '/../templates/footer.php'; ?>

<script src="/src/view/js/home.js"></script>
</body>
</html>