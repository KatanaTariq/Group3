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

.product-desc {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 6px;
    height: 32px;
    overflow: hidden;
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

<body>

<nav>
    <img src="athletiq logo.png" alt="Athletiq Logo" class="logo-img">

    <ul class="nav-links">
        <li><a href="../Homepage/index.html">Home</a></li>
        <li><a href="womenspage.html">Women</a></li>
        <li><a href="shop-men.html">Men</a></li>
    </ul>

    <div class="search-box">
        <input type="text" placeholder="Search products...">
    </div>

    <div class="auth-btns">
        <button onclick="location.href='../Homepage/basket.html'" class="basket-btn">View Basket</button>
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
    <img src="WomanBlackhoodie.png" class="product-img">
    <p class="product-name">Black Athletiq Hoodie</p>
    <p class="product-desc">Soft, breathable cotton hoodie to maximize comfort. </p>
    <p class="price">£30</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>
<div class="product-card" data-category="hoodies">
    <img src="Womangreenblackhoodie.png" class="product-img">
    <p class="product-name">Green & Black Athletiq Hoodie</p>
    <p class="product-desc">Stylish two-tone hoodie, ideal for everyday wear.</p>
    <p class="price">£35</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>
<div class="product-card" data-category="hoodies">
    <img src="Womanwhitehoodie.png" class="product-img">
    <p class="product-name">White Athletiq Hoodie</p>
    <p class="product-desc">Lightweight hoodie perfect for any sports activities. </p>
    <p class="price">£30</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>
<div class="product-card" data-category="hoodies">
    <img src="Womangreenhoodie.png" class="product-img">
    <p class="product-name">Green Athletiq Hoodie</p>
    <p class="product-desc">Breathable hoodie perfect for active lifestyles.</p>
    <p class="price">£30</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>
<div class="product-card" data-category="hoodies">
    <img src="Womengreyhoodie.png" class="product-img">
    <p class="product-name">Grey Athletiq Hoodie</p>
    <p class="product-desc">Classic athletiq hoodie built for all-day comfort.</p>
    <p class="price">£30</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>



<div class="product-card" data-category="tops">
    <img src="poloteewomen.png" class="product-img">
    <p class="product-name">Athletiq Polo Tee</p>
    <p class="product-desc">Polo tee made with lightweight fabric for atheltiq comfort.</p>
    <p class="price">£40</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>
<div class="product-card" data-category="tops">
    <img src="footballjerseywomen.png" class="product-img">
    <p class="product-name">Athletiq Football Jersey</p>
    <p class="product-desc">Soft football jersey designed for breathability.</p>
    <p class="price">£45</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>
<div class="product-card" data-category="tops">
    <img src="Compressionshirtwomen.png" class="product-img">
    <p class="product-name">Athletiq Compression Top</p>
    <p class="product-desc">Compression fit top that supports muscles and enhances training performance.</p>
    <p class="price">£40</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>
<div class="product-card" data-category="tops">
    <img src="camitanktopwomen.png" class="product-img">
    <p class="product-name">Athletiq Cami-Tanktop</p>
    <p class="product-desc">Lightweight cami tank perfect for Gym workouts.</p>
    <p class="price">£25</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>
<div class="product-card" data-category="tops">
    <img src="basketballjerseywomen.png" class="product-img">
    <p class="product-name">Athletiq Basketball Jersey</p>
    <p class="product-desc">Loose-fit basketball jersey for smooth movement on court.</p>
    <p class="price">£45</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>



<div class="product-card" data-category="bottoms">
    <img src="tennisskortwomen.png" class="product-img">
    <p class="product-name">Athletiq Tennis Skort</p>
    <p class="product-desc">Flexible tennis skort combining comfort with coverage.</p>
    <p class="price">£32</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>
<div class="product-card" data-category="bottoms">
    <img src="leggingswomen.png" class="product-img">
    <p class="product-name">Athletiq Leggings</p>
    <p class="product-desc">High-stretch leggings ideal for any sport.</p>
    <p class="price">£35</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>
<div class="product-card" data-category="bottoms">
    <img src="swimmingshortswomen.png" class="product-img">
    <p class="product-name">Athletiq Swimming Shorts</p>
    <p class="product-desc">Quick-drying swim shorts designed for easy swimming.</p>
    <p class="price">£25</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>
<div class="product-card" data-category="bottoms">
    <img src="joggerswomen.png" class="product-img">
    <p class="product-name">Athletiq Baggy Joggers</p>
    <p class="product-desc">Relaxed-fit joggers ideal for training and casual wear.</p>
    <p class="price">£45</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>
<div class="product-card" data-category="bottoms">
    <img src="cyclingshortswomen.png" class="product-img">
    <p class="product-name">Athletiq Cycling Shorts</p>
    <p class="product-desc">Comfortable cycling shorts ideal for long cycling journeys.</p>
    <p class="price">£30</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>





<div class="product-card" data-category="footwear">
    <img src="womenrunningspikes.png" class="product-img">
    <p class="product-name">Womens Running Spikes</p>
    <p class="product-desc">Lightweight spikes made for speed and traction.</p>
    <p class="price">£80</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>3.5</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>
<div class="product-card" data-category="footwear">
    <img src="Womenflipflop.png" class="product-img">
    <p class="product-name">Womens Flip Flops</p>
    <p class="product-desc">Easy to wear flip flops ideal for poolside wear.</p>
    <p class="price">£20</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>3.5</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>
<div class="product-card" data-category="footwear">
    <img src="womenrunningshoes.png" class="product-img">
    <p class="product-name">Womens Running Shoes</p>
    <p class="product-desc">Cushioned running shoes ideal for long-distance wear.</p>
    <p class="price">£80</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>3.5</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>
<div class="product-card" data-category="footwear">
    <img src="womenbasketballshoes.png" class="product-img">
    <p class="product-name">Womens Basketball Shoes</p>
    <p class="product-desc">Basketball shoes built for quick movement and stability.</p>
    <p class="price">£90</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>3.5</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>
<div class="product-card" data-category="footwear">
    <img src="womanfootballboots.png" class="product-img">
    <p class="product-name">Womens Football Boots</p>
    <p class="product-desc">Durable football boots made for control on the pitch.</p>
    <p class="price">£70</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>3.5</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>




<div class="product-card" data-category="headwear">
    <img src="womenVisorcap.png" class="product-img">
    <p class="product-name">Athletiq Visor</p>
    <p class="product-desc">Sports visor designed to keep sun and sweat away.</p>
    <p class="price">£25</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="headwear">
    <img src="womensweatband.png" class="product-img">
    <p class="product-name">Athletiq Sweatband</p>
    <p class="product-desc">Comfortable sweatband that absorbs excess moisture.</p>
    <p class="price">£15</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="headwear">
    <img src="womenrugbyhelmet.png" class="product-img">
    <p class="product-name">Athletiq Rugby Helmet</p>
    <p class="product-desc">Protective rugby helmet with safety features for comfort.</p>
    <p class="price">£75</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="headwear">
    <img src="womenbaseballcap.png" class="product-img">
    <p class="product-name">Athletiq Baseball Cap</p>
    <p class="product-desc">Sports cap for style and sun protection.</p>
    <p class="price">£35</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

<div class="product-card" data-category="headwear">
    <img src="Womanswimcap.png" class="product-img">
    <p class="product-name">Athletiq Swimcap</p>
    <p class="product-desc">Swim cap with design to reduce drag in the water.</p>
    <p class="price">£10</p>
    <select>
        <option selected disabled>Select Size</option>
        <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
    </select><br>
    <button class="add-btn">Add to Basket</button>
</div>

</section>

<script src="womenspage.js"></script>
</body>
</html>

<footer id="site-footer">
  <div class="footer-nav">
    <h3>Quick Links</h3>
    <a href="../Homepage/index.html">Home</a>
    <a href="../Homepage/about.html">About Us</a>
    <a href="../Homepage/contact.html">Contact Us</a>
    <a href="../Homepage/signin.html">Sign In</a>
  </div>

  <div class="footer-center">
    <p>Let's stay in touch! Sign up to experience the benefits of Athletiq!</p>
    <a href="../Homepage/signup.html"><button class="footer-signup-btn">Sign Up</button></a>
  </div>

  <div class="footer-logo">
    <img src="../Homepage/athletiqlogotransparent.png" alt="Athletiq Logo">
  </div>
</footer>
