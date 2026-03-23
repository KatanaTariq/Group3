<?php 
$title = 'Athletiq | Login';
$extraCSS = '<link rel="stylesheet" href="/public/css/login.css">';

$message = $message ?? ($_GET['message'] ?? null);
$error = $error ?? ($_GET['error'] ?? null);
$redirectTo = $redirectTo ?? ($_GET['redirect'] ?? '/profile');
?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<div class="login-page">
    <div class="login-border">

        <div class="login-logo">
            <img 
                src="/public/images/logos/athletiq_logo_transparent.png" 
                alt="Athletiq logo"
                class="logo-img"
            >
            <h1>Welcome back</h1>
            <p class="login-subtitle">Log in to your Athletiq account and keep shopping the latest drops.</p>
        </div>

        <div class="details">
            <?php if (!empty($message)): ?>
                <div class="login-message">
                    <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="login-error">
                    <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>

            <form action="/login" method="post">
                <input 
                    type="hidden" 
                    name="csrf_token"
                    value="<?php echo htmlspecialchars(get_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>"
                >

                <input 
                    type="hidden" 
                    name="redirect"
                    value="<?php echo htmlspecialchars($redirectTo, ENT_QUOTES, 'UTF-8'); ?>"
                >

                <div class="input-group">
                    <label for="email">Email address</label>
                    <div class="input-box">
                        <input 
                            id="email" 
                            type="text" 
                            name="email" 
                            placeholder="athletiq@example.com" 
                            required
                            value="<?php echo htmlspecialchars($_GET['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                        >
                    </div>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="input-box">
                        <input id="password" type="password" name="password" placeholder="Enter your password" required>
                    </div>
                </div>

                <div class="remember-forgotten">
                    <label for="remember_me">
                        <input id="remember_me" type="checkbox" name="remember_me"> Remember me
                    </label>
                    <a href="/forgot-password">Forgot password?</a>
                </div>

                <button type="submit" class="login-button">Log in</button>
            </form>
        </div>

        <div class="no-account">
            <p>Don’t have an account yet? <a href="/signup">Sign up here</a></p>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>