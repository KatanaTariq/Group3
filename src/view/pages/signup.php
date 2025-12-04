<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="icon" href="/src/view/images/logos/athletiq_logo.png" type="image/x-icon">
    <link rel="stylesheet" href="/src/view/css/nav.css">
    <link rel="stylesheet" href="/src/view/css/footer.css">
    <link rel="stylesheet" href="/src/view/css/signup.css">
</head>

<body>
    <?php include __DIR__ . '/../templates/nav.php'; ?>

    <!-- Sign Up page -->
    <div class = "signup-border">

        <div class="signup-logo">
            <img src="src/view/images/logos/athletiq_logo_transparent.png" alt="Athletiq logo">
            <h1>Sign Up</h1>
        </div>

        <div class="details">
            <form action="">
                <div class="input-box">
                    <input type="text" placeholder="Full name" required>
                </div>
                <div class="input-box">
                    <input type="text" placeholder="Email address" required>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Password" required>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Re-enter password" required>
                </div>
                   
            </form>
        </div>

        <div class="submit">
            <button type="submit" class="signup-button">Sign Up</button> 
        </div>

       <div class="has-account">
            <p>Already have an account? <a href="signin.html">Login here</a></p>
       </div>
        
        
    </div>

    <?php include __DIR__ . '/../templates/footer.php'; ?>
    
</body>
</html>