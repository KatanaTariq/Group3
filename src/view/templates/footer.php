<footer id="site-footer">
    <div class="footer-nav">
        <h3>Quick Links</h3>
        <a href="<?= BASE_URL ?>/home">Home</a>
        <a href="<?= BASE_URL ?>/about">About Us</a>
        <a href="<?= BASE_URL ?>/contact">Contact Us</a>
        <a href="<?= BASE_URL ?>/login">Sign In</a>
        <?php if (($_SERVER['REQUEST_URI'] === BASE_URL . '/home' || $_SERVER['REQUEST_URI'] === '/')): ?>
            <a href="<?= BASE_URL ?>/admin/login">Admin</a>
        <?php endif; ?>
    </div>

    <div class="footer-center">
        <p>Let's stay in touch! Sign up to experience the benefits of Athletiq!</p>
        <a href="<?= BASE_URL ?>/signup">
            <button class="footer-signup-btn">Sign Up</button>
        </a>
    </div>

    <div class="footer-logo">
        <img
            src="<?= BASE_URL ?>/public/images/logos/athletiq_logo.png"
            alt="Athletiq Logo"
            class="logo-img"
        >
    </div>
</footer>

</body>
</html>