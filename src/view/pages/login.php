<?php
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/nav.php';
?>

<div class="login-border">

    <div class="login-logo">
        <img
            src="<?= BASE_URL ?>/public/images/logos/athletiq_logo_transparent.png"
            alt="Athletiq logo"
            class="logo-img"
        >
        <h1>Login</h1>
    </div>

    <div class="details">
        <form action="<?= BASE_URL ?>/login" method="post">
            <input type="hidden" name="csrf_token"
                   value="<?= htmlspecialchars(get_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">

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
        <a href="<?= BASE_URL ?>/forgot-password">Forgot Password?</a>
    </div>

    <div class="no-account">
        <p>Don't have an account yet? <a href="<?= BASE_URL ?>/signup">Sign up here</a></p>
    </div>

</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>