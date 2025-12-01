<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Athletiq | Checkout</title>

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
    background: var(--white);
    border-bottom: 1px solid #ccc;
    gap: 20px;
}

.logo-img { width: 80px; height: auto; cursor: pointer; }

.nav-links {
    display: flex; 
    list-style: none; 
    gap: 15px;
    font-weight: bold;
    margin-left: 10px;
}

.nav-links a { text-decoration: none; color: inherit; }
.nav-links a:hover { color: var(--primary); }

.auth-btns { margin-left: auto; display: flex; gap: 15px; }

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

.checkout-title { text-align: center; font-size: 2rem; margin-top: 35px; font-weight: bold; }

.checkout-container {
    width: 85%;
    max-width: 1000px;
    margin: 30px auto;
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.checkout-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #ddd;
    padding: 15px 10px;
}

.checkout-item img {
    width: 100px;
    height: 100px;
    border-radius: 10px;
    object-fit: cover;
}

.item-info { 
    width: 40%; 
    font-size: 1rem; 
    font-weight: bold; 
}

.item-info p { margin: 5px 0; }

.item-price { font-size: 1.1rem; font-weight: bold; }

.total { text-align: right; font-size: 1.3rem; font-weight: bold; margin: 20px 0; }

.payment-form {
    max-width: 500px;
    margin: 0 auto 50px;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.payment-form label { font-weight: bold; }
.payment-form input {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 1rem;
}

.submit-btn {
    padding: 12px 22px;
    background: var(--primary);
    border: none;
    border-radius: 8px;
    font-weight: bold;
    font-size: 1.1rem;
    cursor: pointer;
}
.submit-btn:hover { background: #8CCAA0; }


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

.footer-nav h3 { margin: 0 0 10px 0; font-size: 1.2rem; color: var(--primary); }

.footer-nav a { color: var(--black); text-decoration: none; font-weight: bold; }
.footer-nav a:hover { color: var(--primary); }

.footer-center { flex: 1; text-align: center; min-width: 200px; margin-top: 10px; }
.footer-center p { margin: 0 0 15px 0; font-size: 0.95rem; line-height: 1.5; }

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

.footer-signup-btn:hover { background-color: #8CCAA0; transform: scale(1.05); }

.footer-logo { display: flex; justify-content: flex-end; align-items: center; margin-top: 10px; }
.footer-logo img { height: 60px; }

@media (max-width: 700px) {
    .checkout-item { flex-direction: column; align-items: flex-start; gap: 10px; }
}
</style>
</head>

<body>


<nav>
    <img src="../images/logos/athletiqlogo.png" class="logo-img" alt="Logo">
    <ul class="nav-links">
        <li><a href="index.html">Home</a></li>
        <li><a href="../Womensproductpage/womenspage.html">Women</a></li>
        <li><a href="shop-men.html">Men</a></li>
    </ul>
    <div class="auth-btns">
        <button onclick="location.href='basket.html'" class="basket-btn">View Basket</button>
        <button class="signup-btn">Sign Up</button>
        <button class="login-btn">Log In</button>
    </div>
</nav>

<h1 class="checkout-title">Checkout</h1>

<div class="checkout-container" id="checkout-items">
    
</div>

<p class="total">Total: Â£<span id="checkout-total">0.00</span></p>

<form class="payment-form" id="payment-form">
    <label for="name">Full Name</label>
    <input type="text" id="name" placeholder="Alex Smith" required>

    <label for="email">Email</label>
    <input type="email" id="email" placeholder="example@email.com" required>

    <label for="card">Card Number</label>
    <input type="text" id="card" placeholder="1234 5678 91234567" required>

    <label for="expiry">Expiry Date</label>
    <input type="text" id="expiry" placeholder="MM/YY" required>

    <label for="cvv">CVV</label>
    <input type="text" id="cvv" placeholder="321" required>

    <button type="submit" class="submit-btn">Submit My Order</button>
</form>



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
    <img src="athletiqlogotransparent.png" alt="Athletiq Logo">
  </div>
</footer>

<script src="src\view\js\checkout.js"></script>
</body>
</html>
