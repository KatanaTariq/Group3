<footer id="site-footer">
    <div class="footer-col footer-links-col">
        <h3>Quick Links</h3>
        <div class="footer-links">
            <a href="/home">Home</a>
            <a href="/about">About Us</a>
            <a href="/contact">Contact Us</a>
            <a href="/login">Sign In</a>

            <?php $current = strtok($_SERVER['REQUEST_URI'], '?'); ?>
            <?php if ($current === '/home' || $current === '/'): ?>
                <a href="/admin/login">Admin</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer-col footer-center">
        <p>Let's stay in touch! Sign up to experience the benefits of Athletiq!</p>
        <a href="/signup" class="footer-signup-btn">Sign Up</a>
    </div>

    <div class="footer-col footer-logo">
        <img src="/public/images/logos/athletiq_logo_transparent.png" alt="Athletiq Logo">
    </div>
</footer>