<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="icon" href="images/athletiqsimplelogo.png" type = "image/x-icon">
    <link rel='stylesheet' href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css'>
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

    <!-- contact us -->
     <div class="contactUsPage">
        <div class="header">
            <h1>Contact Us</h1>
        </div>
        <div class="container">
            <div class="contact_details">
                <h2>Our contact details</h2>

                <i class='bx  bx-location'></i> 
                <h3 class="header3">Address</h3>
                <p> Aston University
                    <br>Birmingham
                    <br>B4 7ET
                </p>

                <i class='bx  bx-envelope'></i> 
                <h3 class="header3">Email</h3>
                <p>Athletiq@aston.ac.uk</p>

                <i class='bx  bx-phone'></i> 
                <h3 class="header3">Phone</h3>
                <p>0121 204 4007</p>
            </div>

            <div class="contact_form">
                <h2>Write your inquiry</h2>
                <p>Need to get in touch? Fill out this form to send us a message and we'll lend you a hand</p>

                <form action="">
                    <div class="input-box">
                        <input type="text" placeholder="Enter your full name" required>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="Enter your email" required>
                    </div>
                    <div class="message-box">
                        <textarea name="text" placeholder="Enter your message"></textarea>
                    </div>
                </form>
                <div class="submit">
                    <button type="submit" class="send_message">Submit</button> 
                </div>
            </div>
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
            --grey: #e0e0e0;
            --black: #000;
        }

        body{
            background-color: #eee;
        }

        .contactUsPage{
            font-family: Arial, Helvetica, sans-serif;
        }

        .header{
            background-color: rgba(255, 255, 255, 0.233);
            background-image: url(images/m_hoodie5.png);
            background-blend-mode: overlay;
            background-size:cover;
            background-position:center;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header h1{
            animation:slideInLeft 1s;
            background-color: rgba(0, 0, 0, 0.86);
            color: var(--white);
            margin-top: 100px;
            margin-left: 40px;
            margin-bottom: 100px;
            border-radius: 15px;
            padding: 15px 40px;
            font-size: 50px;
        }

        .container{
            display: flex;
            align-items: center;
            background-color: var(--white);
            margin: 50px auto;
            margin-bottom: 50px;           

            border-radius: 25px;
            box-shadow: 0 0 15px #797979;
            width: 80%;
        }
        .contact_details{
            background-color: var(--primary);
            text-align: center;
            width: 25%;
            height: 100%;
            border-radius: 15px;
        }
        .contact_details i{
            font-size: 35px;
            color: var(--white);
        }
        .contact_details h2{
            font-size: 25px;
            font-weight: 600;
        }
        .contact_form{
            text-indent: 20px;
            width: 75%;
            height: 100%;
        }
        .contact_form h2{
            margin-bottom: 10px;
            font-size: 25px;
            font-weight: 600;
        }
        .contact_form p{
            margin-top: 0px;
            margin-bottom: 30px;
        }
        .input-box{
            width: 80%;
            height: 35px;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .input-box input{
            height: 100%;
            width: 100%;
            border: none;
            background: #ebebeb;
            border-radius: 5px;
            padding-left: 15px;
            font-size: 15px;
        }
        .message-box{
            width: 80%;
            height: 150px;
            margin-top: 10px;
            margin-bottom: 0px;
        }
        .message-box textarea{
            height: 100%;
            width: 100%;
            border: none;
            background: #ebebeb;
            border-radius: 5px;
            padding-left: 15px;
            font-size: 15px;
            resize: none;
        }
        .header3{
            margin: 0px;
        }
        .send_message{
            width: 130px;
            height: 35px;
            background-color: #161616  ;
            color: var(--white);
            margin-top: 25px;
            margin-bottom: 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 20px;
            transition: all 0.3s ease ;
        }
        .send_message:hover{
            background: #474747;
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

</body>
</html>