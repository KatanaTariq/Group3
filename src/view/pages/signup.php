<?php $title = 'Athletiq | Sign Up'; ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<div class="signup-border">

    <div class="signup-logo">
        <img 
            src="<?= BASE_URL ?>/public/images/logos/athletiq_logo_transparent.png" 
            alt="Athletiq logo"
            class="logo-img"
        >
        <h1>Sign Up</h1>
    </div>

    <?php if (!empty($_GET['error'])): ?>
        <div class="error-message">
            <?= htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <div class="details">
        <form method="POST" action="<?= BASE_URL ?>/signup">

            <input type="hidden" name="csrf_token"
                   value="<?= htmlspecialchars(get_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">

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
        <p>Already have an account? <a href="<?= BASE_URL ?>/login">Login here</a></p>
    </div>

</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>