<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Athletiq | About Us </title>

<style>
:root {
    --primary: #A8D5BA;
    --black: #000;
    --white: #fff;
}

body {
    margin: 0;
    background: #fff;
    font-family: Arial, Helvetica, sans-serif;
    color: var(--black);
}

a { text-decoration: none; color: inherit; }

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
    display: flex; list-style: none; gap: 15px;
    font-weight: bold;
    margin-left: 10px;
}

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

.about-hero {
    background: url('athlete-banner.jpg') center/cover no-repeat;
    height: 350px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: #fff;
    background-color: #222;
}

.about-hero h1 {
    font-size: 3rem;
    background: rgba(0,0,0,0.55);
    padding: 12px 25px;
    border-radius: 6px;
}

.about-info {
    max-width: 900px;
    margin: 60px auto;
    text-align: center;
    padding: 0 25px;
}

.about-info h2 { font-size: 2rem; margin-bottom: 15px; }

.about-info p {
    font-size: 1.1rem;
    line-height: 1.6;
    margin-bottom: 22px;
    color: #444;
}

.athlete-section {
    background: var(--primary);
    padding: 60px 25px;
    text-align: center;
}

.athlete-section h2 { font-size: 2rem; margin-bottom: 10px; }
.athlete-section p {
    max-width: 700px;
    margin: auto;
    font-size: 1.1rem;
    line-height: 1.6;
}


.team-grid {
    margin-top: 45px;
    display: flex;
    justify-content: center;
    gap: 40px;
    flex-wrap: wrap;
}

.athlete-card {
    background: #fff;
    width: 260px;           
    border-radius: 10px;
    padding: 15px;
    box-shadow: 0 5px 12px rgba(0,0,0,0.15);
    text-align: center;
    height: auto;        
}

.athlete-card img {
    width: 100%;
    height: 220px;           
    border-radius: 10px;
    object-fit: cover;
}
.athlete-card {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.athlete-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}


.athlete-card h3 {
    margin: 10px 0 5px;
}

.athlete-card p {
    font-size: 0.95rem;
    color: #333;
    line-height: 1.4;
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

<div class="about-hero">
    <h1>About Athletiq</h1>
</div>

<section class="about-info">
    <h2>Performative Wear for Upcoming Sports Enthusiasts</h2>
    <p>
        Over at Athletiq, clothing is created with concept. We've designed and refined
        Sportswear with a Story. 
    </p>
    <p>
        Our products are proudly designed by Athletes, putting a meaning behind 
        each item built. With dedication, real performance and training, our Athletes know
        what it takes to compete, and that all starts with what they wear.
    </p>
    <p>
        We've collaborated with Sports Enthusiasts, ranging from competetive Sprinters to Elite 
        Footballers who have helped us tailor Sportwears to reach maximum comfortablity, enhanced
        flexibility and reduced friction to ensure our Athletiq Champions reach Peak Performance. 
        
    </p>
</section>

<section class="athlete-section">
    <h2>Athletes have designed them so our Athletiqs can wear them.</h2>
    <p>Meet the Athletes and Players who have collaborated and helped build Athletiq Sportwear to what we are today.</p>

    <div class="team-grid">
        <div class="athlete-card">
            <img src="aboutusrugby.png">
            <h3>Jae</h3>
            <p>Professional Rugby Player — Designer of Athletiqs Protective Rugby Helmet, 
                with earpadding and ventilation holes.</p>
        </div>

        <div class="athlete-card">
            <img src="aboutusrunningshoes.png">
            <h3>Alayaa</h3>
            <p>Competetive Long-distance Runner — Creator of Athletiqs running shoes with breathable soles.</p>
        </div>

        <div class="athlete-card">
            <img src="aboutusbasketballjersey.png">
            <h3>Miyaz</h3>
            <p>Pro Basketballer — Worked on Athletiqs Basketball Jersey, LightWeight and Moisture-wicking.</p>
        </div>
    </div>
</section>

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

</body>
</html>