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
    <div class="signup-border">

        <div class="signup-logo">
            <img src="src/view/images/logos/athletiq_logo_transparent.png" alt="Athletiq logo">
            <h1>Sign Up</h1>
        </div>

        <div class="error-message">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>


        <div class="details">
            <form method="POST" action="/signup">

                <!-- CSRF token -->
                <input type="hidden" name="csrf_token"
                       value="<?php echo htmlspecialchars(get_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">

                <div class="input-box">
                    <input type="text" name="first_name" placeholder="First name" required>
                </div>

                <div class="input-box">
                    <input type="text" name="last_name" placeholder="Last name" required>
                </div>

                <div class="input-box">
                    <input type="email" name="email" placeholder="Email address" required>
                </div>

                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <div class="submit">
                    <button type="submit" class="signup-button">Sign Up</button> 
                </div>

            </form>
        </div>

       <div class="has-account">
            <p>Already have an account? <a href="/login">Login here</a></p>
       </div>

    </div>

    <?php include __DIR__ . '/../templates/footer.php'; ?>
    
</body>
</html>
