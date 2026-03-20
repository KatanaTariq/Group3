<?php $title = 'Athletiq | Login'; ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<div class="login-border">

    <div class="login-logo">
        <img
            src="/public/images/logos/athletiq_logo_transparent.png"
            alt="Athletiq logo"
            class="logo-img"
        >
        <h1>Login</h1>
    </div>

    <div class="details">
        <form action="/login" method="post">
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
        <label><input type="checkbox" name="remember_me"> Remember me</label>
        <a href="/forgot-password">Forgot password?</a>
    </div>

    <div class="no-account">
        <p>Don't have an account yet? <a href="/signup">Sign up here</a></p>
    </div>

</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>