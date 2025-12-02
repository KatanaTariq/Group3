<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="icon" href="images/athletiqsimplelogo.png" type = "image/x-icon">
</head>

<body>
    <!--  Navigation  -->

    <nav>
        <img src="images/athletiq_logo.png" alt="Athletiq Logo" class="logo-img">


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

    <style>
        nav {
            font-family: Arial, Helvetica, sans-serif;
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
        .nav-links a{
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
    </style>

<!-- Log in page -->
<?php if (!empty($_GET['error'])): ?>
    <p>login failed: <?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>

<div class="login-border">

    <div class="login-logo">
        <img src="/src/view/images/logos/athletiq_logo_transparent.png" alt="Athletiq logo">
        <h1>Login</h1>
    </div>

    <div class="details">
        <form action="/login" method="post">
            <input type="hidden" name="csrf_token"
                   value="<?php echo htmlspecialchars(get_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">

            <div class="input-box">
                <input type="text" name="email" placeholder="Email address" required>
            </div>

            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="login-button">Login</button>
        </form>
    </div>

    <div class="remember-forgotten">
        <label><input type="checkbox" name="remember_me"> Remember Me</label>
        <a href="/forgot-password">Forgot Password?</a>
    </div>

    <div class="no-account">
        <p>Don't have an account yet? <a href="/register">Sign up here</a></p>
    </div>

</div>

    <style>
        @keyframes slideInLeft {
            from{
                transform: translateX(-300px);
            }
            to{
                transform: translateX(0px);
            }
        }

        :root{
        --primary: #A8D5BA;
        --white: #fff;
        --darkgrey: #888888;
        --black: #000;
        }
        
        body{
            background-color: #eee;
        }

        .login-border{
            animation:slideInLeft 1s;
            margin: 50px auto;
            margin-bottom: 50px;           
            background-color: var(--primary);
            padding: 30px;
            border-radius: 25px;
            box-shadow: 0 0 15px #797979;
            width: 350px;
            font-family: Arial, Helvetica, sans-serif;

        }
        .input-box{
            width: 300px;
            height: 30px;
            margin-left: 10px;
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .input-box input{
            width:100%;
            height:100%;
            border: 2px solid #000;
            border-radius: 40px;
            padding-left: 15px;
            padding-right: 15px;
        }

        .login-logo{
            text-align: center;
        }
        .login-logo img {
            height: 70px;
            margin: 0px;
        }
        .login-logo h1 {
            margin: 0px;
            margin-bottom: 25px;
            font-size: 50px;
        }

        .remember-forgotten{
            display: flex;
            justify-content: space-between;
        }
        .remember-forgotten label input{
            accent-color: var(--white);
        }
        .remember-forgotten a{
            color: var(--black);
            text-decoration: none;
        }
        .remember-forgotten a:hover{
            text-decoration: underline;
        }

        .no-account a{
            color: var(--white);
            text-decoration: none;
        }
        .no-account a:hover{
            text-decoration: underline;
        }

        .submit{
            text-align: center;
            margin: 15px auto;
        }

        .login-button{
            width: 150px;
            height: 50px;
            background-color: #000000  ;
            color: var(--white);
            margin-top: 25px;
            margin-bottom: 15px;
            border: 2px solid #000;
            border-radius: 6px;
            cursor: pointer;
            font-size: 25px;
            transition: transform 0.3s ease ;
        }
        .login-button:hover{
            transform: scale(1.1);
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
            <img src="images/athletiqlogotransparent.png" alt="Athletiq Logo">
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
        background-color: #ffffff; 
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
    
</body>
</html>