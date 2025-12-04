<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athletiq | Log In</title>
    <link rel="icon" href="/src/view/images/logos/athletiq_logo.png" type="image/x-icon">
    <link rel="icon" href="/src/view/images/logos/athletiq_logo.png" type="image/x-icon">
    <link rel="stylesheet" href="/src/view/css/nav.css">
    <link rel="stylesheet" href="/src/view/css/footer.css">
    <link rel="stylesheet" href="/src/view/css/login.css">
</head>

<body>

<?php include __DIR__ . '/../templates/nav.php'; ?>

<?php if (!empty($_GET['error'])): ?>
    <p>Login failed: <?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?></p>
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
        <p>Don't have an account yet? <a href="/signup">Sign up here</a></p>
    </div>

</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>

</body>
</html>