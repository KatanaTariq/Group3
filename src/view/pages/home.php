<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Athletiq | Sportswear</title>

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

a {
    text-decoration: none;
    color: inherit;
}

/*  -Navigation- */

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

.signup-btn, .login-btn {
    background: var(--black);
    color: var(--white);
    padding: 8px 18px;
    border-radius: 4px;
    font-weight: bold;
    border: none;
}

.signup-btn:hover, .login-btn:hover {
    background: var(--primary);
    color: var(--black);
}

/* -Athletiq welcome- */

.hero {
    display: flex;
    padding: 40px;
    gap: 40px;
    background: #f5f5f5;
    align-items: center; 
}

.hero-img {
    width: 400px;        
    height: 400px;
    background: #d9d9d9;
    border: 5px solid var(--primary);
    border-radius: 10px;
    background-size: contain;   
    background-position: center;
    background-repeat: no-repeat;
    cursor: pointer;
    transition: background-image 0.5s ease-in-out;
}

.hero-text {
    display: flex;
    flex-direction: column;
    justify-content: center; 
    width: 40%;
}

.hero-text h1 {
    font-size: 2.2rem;
    margin-bottom: 15px;
}

.hero-text p {
    font-size: 1.1rem;
    margin-bottom: 25px;
    line-height: 1.5;
}

.learn-more-btn {
    padding: 10px 20px;
    background-color: var(--primary);
    color: #000;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.learn-more-btn:hover {
    background-color: #8CCAA0;
}

.hero-text a {
    text-decoration: none;
}


</style>
</head>

<body>

<!--  Navigation  -->

<nav>
    <img src="/images/logos/athletiqlogo.png" alt="Athletiq Logo" class="logo-img">


    <ul class="nav-links">
        <li><a href="#">Men</a></li>
        <li><a href="#">Women</a></li>
    </ul>

    <div class="search-box">
        <input type="text" placeholder="Search products...">
    </div>

    <div class="auth-btns">
        <button class="signup-btn">Sign Up</button>
        <button class="login-btn">Log In</button>
    </div>
</nav>

<!-- Athletiq welcome -->

<section class="hero">
    <div id="hero-slideshow" class="hero-img"></div>

    <div class="hero-text">
        <h1>Welcome to Athletiq</h1>
        <p>Premium Sportswear. Designed for the Athletiqs, by the Athletes.</p>
        <a href="about.html"><button class="learn-more-btn">Learn more About Us</button></a>
    </div>
</section>

<!-- link js -->

<script src="/js/home.js"></script>
</body>
</html>

<!-- Shop Categories -->

<section class="categories">
    <div class="category-box">
        <a href="shop-men.html">
            <div class="img-container">
                <img src="/images/productImages/homepage/polotankman.png" alt="Shop Men">
                <div class="overlay-text">Shop Men</div>
            </div>
        </a>
    </div>

    <div class="category-box">
        <a href="shop-women.html">
            <div class="img-container">
                <img src="/images/productImages/homepage/poloteewomen.png" alt="Shop Women">
                <div class="overlay-text">Shop Women</div>
            </div>
        </a>
    </div>
</section>

<style>
:root {
    --primary: #A8D5BA;
}

.categories {
    display: flex;
    justify-content: center;
    gap: 60px;
    padding: 60px 0;
    background: var(--primary);
    flex-wrap: wrap;
}

.category-box {
    width: 220px;
    cursor: pointer;
    background: #fff;         
    border: 3px solid #fff;
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.category-box:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 15px rgba(0,0,0,0.2);
}

.img-container {
    position: relative;
    width: 100%;
    height: 220px;
}

.img-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.overlay-text {
    position: absolute;
    bottom: 0;
    width: 100%;
    padding: 10px 0;
    background: rgba(0, 0, 0, 0.5); 
    color: #fff;
    font-weight: bold;
    font-size: 1.2rem;
    text-align: center;
    border-bottom-left-radius: 12px;
    border-bottom-right-radius: 12px;
}

.category-box a {
    text-decoration: none;
    color: inherit;
}
</style>

<!-- Just in section-->
 
<section class="just-in">
    <h2>Just In!</h2>
    <p>Browse our Newest Arrivals at Athletiq.</p>

    <div class="products">
        <div class="product-card">
            <img src="/images/productImages/homepage/womenrunningspikes.png" alt="Women Running Spikes">
            <h3>Women's Running Spikes</h3>
            <a href="product1.html"><button class="product-btn">View Product</button></a>
        </div>

        <div class="product-card">
            <<img src="/images/productImages/homepage/menfootballboot.png" alt="Men Football Boots">
            <h3>Men's Football Boots</h3>
            <a href="product2.html"><button class="product-btn">View Product</button></a>
        </div>

        <div class="product-card">
            <img src="/images/productImages/homepage/womenrunningshoes.png" alt="Women Running Shoes">
            <h3>Women's Running Shoes</h3>
            <a href="product3.html"><button class="product-btn">View Product</button></a>
        </div>
    </div>
</section>

<style>

.just-in {
    background: #f9f9f9; 
    padding: 60px 20px;
    text-align: center;
}

.just-in h2 {
    font-size: 2rem;
    margin-bottom: 10px;
}

.just-in p {
    font-size: 1.1rem;
    margin-bottom: 40px;
    color: #555;
}


.products {
    display: flex;
    justify-content: center;
    gap: 40px;
    flex-wrap: wrap;
}


.product-card {
    background: #fff;
    width: 220px;
    border-radius: 10px;
    padding: 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.2);
}

.product-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 15px;
}

.product-card h3 {
    font-size: 1.1rem;
    font-weight: bold;
    margin-bottom: 15px;
    color: #000;
}

.product-btn {
    padding: 10px 18px;
    background-color: var(--primary); 
    border: none;
    border-radius: 6px;
    font-weight: bold;
    color: #000;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.product-btn:hover {
    background-color: #8CCAA0; 
}

.product-card a {
    text-decoration: none;
}
</style>

<!-- Sign up promo section -->

<section class="signup-promo">
    <h2>Love Athletiq?</h2>
    <p>Join our Athletiq champions and Sign up now! 10% Welcome voucher included and other deals, exclusive to members only.</p>
    <a href="signup.html"><button class="signup-btn">Sign Up Now</button></a>
</section>

<style>.signup-promo {
    background-color: var(--primary); 
    padding: 60px 20px;
    text-align: center;
    color: #000;
}

.signup-promo h2 {
    font-size: 2rem;
    margin-bottom: 15px;
    font-weight: bold;
}

.signup-promo p {
    font-size: 1.1rem;
    margin-bottom: 30px;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.5;
}

.signup-promo .signup-btn {
    padding: 12px 30px;
    background-color: #fff;
    color: #000;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    font-size: 1rem;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    transition: transform 0.3s ease, background-color 0.3s ease;
}

.signup-promo .signup-btn:hover {
    transform: scale(1.05);
    background-color: #f0f0f0;
}
</style>

<!-- Website footer -->
 
<footer id="site-footer">
  <div class="footer-nav">
    <h3>Quick Links</h3>
    <a href="index.html">Home</a>
    <a href="about.html">About Us</a>
    <a href="contact.html">Contact Us</a>
    <a href="signin.html">Sign In</a>
  </div>

  <div class="footer-center">
    <p>Let's stay in touch! Sign up to experience the benefits of Athletiq!</p>
    <a href="signup.html"><button class="footer-signup-btn">Sign Up</button></a>
  </div>

  <div class="footer-logo">
    <img src="/images/logos/athletiqlogotransparent.png" alt="Athletiq Logo">
  </div>
</footer>

<style>
:root {
  --primary: #A8D5BA;
  --white: #fff;
  --grey: #e0e0e0;
  --black: #000;
}

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
