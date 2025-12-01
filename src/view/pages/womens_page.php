<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Athletiq | Women</title>

<style>
:root {
    --primary: #A8D5BA;
    --black: #000;
    --white: #fff;
}

body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    background: var(--white);
    color: var(--black);
}

nav {
    display: flex;
    align-items: center;
    padding: 15px 40px;
    border-bottom: 1px solid #ccc;
    background: var(--white);
    gap: 20px;
}

.logo-img {
    width: 80px;
    height: auto;
    cursor: pointer;
}

.nav-links {
    display: flex;
    gap: 15px;
    list-style: none;
    font-weight: bold;
    margin-left: 10px;
}

.nav-links a {
    color: inherit;
    text-decoration: none;
}

.nav-links a:hover {
    color: var(--primary);
}

.search-box {
    margin-left: 20px;
}

.search-box input {
    padding: 8px;
    width: 230px;
    border: 2px solid var(--black);
    border-radius: 4px;
}

.auth-btns {
    margin-left: auto;
    display: flex;
    gap: 15px;
}

.signup-btn, .login-btn, .basket-btn {
    background: var(--black);
    color: var(--white);
    padding: 8px 18px;
    border-radius: 4px;
    font-weight: bold;
    border: none;
    cursor: pointer;
}

.signup-btn:hover, .login-btn:hover, .basket-btn:hover {
    background: var(--primary);
    color: var(--black);
}

.women-title {
    text-align: center;
    font-size: 2.2rem;
    margin-top: 40px;
    font-weight: bold;
}

.filter-btn {
    background: var(--primary);
    border: none;
    color: var(--black);
    padding: 8px 15px;
    margin: 3px;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
}
.filter-btn:hover {
    background: #8CCAA0;
}

.products-container {
    display: flex;
    flex-wrap: wrap; 
    justify-content: center;
    gap: 25px;
    padding: 30px 20px;
}

.product-card {
    flex: 0 1 190px; 
    background: #fff;
    border-radius: 10px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: .3s ease;
    margin-bottom: 20px;
}

.product-card:hover {
    transform: translateY(-5px);
}

.product-img {
    width: 100%;
    height: 190px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 10px;
}

.product-name { font-size: 1rem; font-weight: bold; margin-bottom: 8px;}
.price { font-size: .95rem; font-weight: bold; color: #444; margin-bottom: 10px;}


select {
    padding: 6px;
    border-radius: 5px;
    font-weight: bold;
    margin-bottom: 10px;
}

.add-btn {
    background: var(--primary);
    padding: 8px 18px;
    border-radius: 6px;
    border: none;
    font-weight: bold;
    cursor: pointer;
}
.add-btn:hover { background:#8CCAA0; }

#site-footer {
  background-color: #f2f2f2; 
  color: var(--black);
  padding: 40px 20px;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: flex-start;
  font-family: Arial, Helvetica, sans-serif;
  gap: 20px;
}

.footer-nav {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.footer-nav h3 {
  margin: 0 0 10px 0;
  font-size: 1.2rem;
  color: var(--primary);
}

.footer-nav a {
  color: var(--black);
  text-decoration: none;
  font-weight: bold;
  transition: color 0.3s ease;
}

.footer-nav a:hover {
  color: var(--primary);
}

.footer-center {
  flex: 1;
  text-align: center;
  min-width: 200px;
  margin-top: 10px;
}

.footer-center p {
  margin: 0 0 15px 0;
  font-size: 0.95rem;
  line-height: 1.5;
}

.footer-signup-btn {
  padding: 10px 20px;
  background-color: var(--primary);
  border: none;
  border-radius: 6px;
  font-weight: bold;
  color: var(--black);
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.3s ease;
}

.footer-signup-btn:hover {
  background-color: #8CCAA0;
  transform: scale(1.05);
}

.footer-logo {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  margin-top: 10px;
}

.footer-logo img {
  height: 60px;
}

</style>
</head>

</head>

<body>

<nav>
    <img src="/src/view/images/logos/athletiq_logo.png" alt="Athletiq Logo" class="logo-img">

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
        <button class="signup-btn">Sign Up</button>
        <button class="login-btn">Log In</button>
    </div>
</nav>


<h1 class="women-title">Women</h1>

<div style="text-align:center; margin: 20px 0;">
    <button class="filter-btn" onclick="filterProducts('all')">All</button>
    <button class="filter-btn" onclick="filterProducts('hoodies')">Hoodies</button>
    <button class="filter-btn" onclick="filterProducts('tops')">Tops</button>
    <button class="filter-btn" onclick="filterProducts('bottoms')">Bottoms</button>
    <button class="filter-btn" onclick="filterProducts('footwear')">Footwear</button>
    <button class="filter-btn" onclick="filterProducts('headwear')">Headwear</button>
</div>

<section class="products-container" id="all-products">


<div class="product-card" data-category="hoodies">
    <img src="/src/view/images/productImages/womens/women_black_hoodie.png" class="product-img">
    <p class="product-name">Black Athletiq Hoodie</p>
    <p class="price">£30</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="hoodies">
    <img src="/src/view/images/productImages/womens/women_black_green_hoodie.png" class="product-img">
    <p class="product-name">Green & Black Athletiq Hoodie</p>
    <p class="price">£35</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="hoodies">
    <img src="/src/view/images/productImages/womens/women_white_hoodie.png" class="product-img">
    <p class="product-name">White Athletiq Hoodie</p>
    <p class="price">£30</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="hoodies">
    <img src="/src/view/images/productImages/womens/women_green_hoodie.png" class="product-img">
    <p class="product-name">Green Athletiq Hoodie</p>
    <p class="price">£30</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="hoodies">
    <img src="/src/view/images/productImages/womens/women_grey_hoodie.png" class="product-img">
    <p class="product-name">Grey Athletiq Hoodie</p>
    <p class="price">£30</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>



<div class="product-card" data-category="tops">
    <img src="/src/view/images/productImages/womens/polo_tee_women.png" class="product-img">
    <p class="product-name">Athletiq Polo Tee</p>
    <p class="price">£39.99</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="tops">
    <img src="/src/view/images/productImages/womens/women_football_jersey.png" class="product-img">
    <p class="product-name">Athletiq Football Jersey</p>
    <p class="price">£45</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="tops">
    <img src="/src/view/images/productImages/womens/women_compression_top.png" class="product-img">
    <p class="product-name">Athletiq Compression Top</p>
    <p class="price">£40</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="tops">
    <img src="/src/view/images/productImages/womens/women_cami_tank_top.png" class="product-img">
    <p class="product-name">Athletiq Cami-Tanktop</p>
    <p class="price">£25</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="tops">
    <img src="/src/view/images/productImages/womens/women_basketball_jersey.png" class="product-img">
    <p class="product-name">Athletiq Basketball Jersey</p>
    <p class="price">£45</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>



<div class="product-card" data-category="bottoms">
    <img src="/src/view/images/productImages/womens/women_tennis_skort.png" class="product-img">
    <p class="product-name">Athletiq Tennis Skort</p>
    <p class="price">£32</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="bottoms">
    <img src="/src/view/images/productImages/womens/women_leggings.png" class="product-img">
    <p class="product-name">Athletiq Leggings</p>
    <p class="price">£35</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="bottoms">
    <img src="/src/view/images/productImages/womens/women_swimming_shorts.png" class="product-img">
    <p class="product-name">Athletiq Swimming Shorts</p>
    <p class="price">£25</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="bottoms">
    <img src="/src/view/images/productImages/womens/women_joggers.png" class="product-img">
    <p class="product-name">Athletiq Baggy Joggers</p>
    <p class="price">£49.99</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="bottoms">
    <img src="/src/view/images/productImages/womens/women_cycling_shorts.png" class="product-img">
    <p class="product-name">Athletiq Cycling Shorts</p>
    <p class="price">£30</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>



<div class="product-card" data-category="footwear">
    <img src="/src/view/images/productImages/womens/women_running_spikes.png" class="product-img">
    <p class="product-name">Womens Running Spikes</p>
    <p class="price">£85.99</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>3.5</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="footwear">
    <img src="/src/view/images/productImages/womens/women_flip_flops.png" class="product-img">
    <p class="product-name">Womens Flip Flops</p>
    <p class="price">£20</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>3.5</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="footwear">
    <img src="/src/view/images/productImages/womens/women_running_shoes.png" class="product-img">
    <p class="product-name">Womens Running Shoes</p>
    <p class="price">£80</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>3.5</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="footwear">
    <img src="/src/view/images/productImages/womens/women_basketball_shoes.png" class="product-img">
    <p class="product-name">Womens Basketball Shoes</p>
    <p class="price">£90</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>3.5</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="footwear">
    <img src="/src/view/images/productImages/womens/women_football_boots.png" class="product-img">
    <p class="product-name">Womens Football Boots</p>
    <p class="price">£85.99</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>3.5</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>



<div class="product-card" data-category="headwear">
    <img src="/src/view/images/productImages/womens/women_visor_cap.png" class="product-img">
    <p class="product-name">Athletiq Visor</p>
    <p class="price">£25</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="headwear">
    <img src="/src/view/images/productImages/womens/women_sweatband.png" class="product-img">
    <p class="product-name">Athletiq Sweatband</p>
    <p class="price">£15.99</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="headwear">
    <img src="/src/view/images/productImages/womens/women_rugby_helmet.png" class="product-img">
    <p class="product-name">Athletiq Rugby Helmet</p>
    <p class="price">£75</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="headwear">
    <img src="/src/view/images/productImages/womens/women_baseball_cap.png" class="product-img">
    <p class="product-name">Athletiq Baseball Cap</p>
    <p class="price">£35</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="headwear">
    <img src="/src/view/images/productImages/womens/women_swim_cap.png" class="product-img">
    <p class="product-name">Athletiq Swimcap</p>
    <p class="price">£10.99</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

</section>

<script src="/src/view/js/womens_page.js"></script>
</body>
</html>

<footer id="site-footer">
  <div class="footer-nav">
    <h3>Quick Links</h3>
    <a href="/home">Home</a>
    <a href="/about">About Us</a>
    <a href="/contact">Contact Us</a>
    <a href="/login">Sign In</a>
  </div>

  <div class="footer-center">
    <p>Let's stay in touch! Sign up to experience the benefits of Athletiq!</p>
    <a href="/login"><button class="footer-signup-btn">Sign Up</button></a>
  </div>

  <div class="footer-logo">
    <img src="/src/view/images/logos/athletiq_logo_transparent.png" alt="Athletiq Logo">
  </div>
</footer>
