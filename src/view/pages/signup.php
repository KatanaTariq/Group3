<?php $title = 'Athletiq | Sign Up'; ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<div class="auth-page">
    <div class="signup-border">

        <div class="signup-logo">
            <img 
                src="/public/images/logos/athletiq_logo_transparent.png" 
                alt="Athletiq logo"
                class="logo-img"
            >
            <h1>Create account</h1>
            <p class="auth-subtitle">Join Athletiq and shop the latest drops.</p>
        </div>

        <?php if (!empty($_GET['error'])): ?>
            <div class="error-message">
                <?= htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <div class="details">
            <form method="POST" action="/signup" class="auth-form">

                <input 
                    type="hidden" 
                    name="csrf_token"
                    value="<?= htmlspecialchars(get_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>"
                >

                <div class="name-row">
                    <div class="input-group">
                        <label for="first_name">First name</label>
                        <div class="input-box">
                            <input id="first_name" type="text" name="first_name" placeholder="e.g. Maya" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="last_name">Last name</label>
                        <div class="input-box">
                            <input id="last_name" type="text" name="last_name" placeholder="e.g. Patel" required>
                        </div>
                    </div>
                </div>

                <div class="input-group">
                    <label for="email">Email address</label>
                    <div class="input-box">
                        <input id="email" type="email" name="email" placeholder="you@example.com" required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="input-box">
                        <input id="password" type="password" name="password" placeholder="Create a password" required>
                    </div>
                </div>

                <div class="submit">
                    <button type="submit" class="signup-button">Create account</button> 
                </div>

            </form>
        </div>

        <div class="has-account">
            <p>Already have an account? <a href="/login">Log in</a></p>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>