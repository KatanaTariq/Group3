<footer id="site-footer">
    <div class="footer-nav">
        <h3>Quick Links</h3>
        <a href="/home">Home</a>
        <a href="/about">About Us</a>
        <a href="/contact">Contact Us</a>
        <a href="/login">Sign In</a>

        <?php if ($_SERVER['REQUEST_URI'] === '/home' || $_SERVER['REQUEST_URI'] === '/'): ?>
            <a href="/admin/login">Admin</a>
        <?php endif; ?>
    </div>

    <div class="footer-center">
        <p>Let's stay in touch! Sign up to experience the benefits of Athletiq!</p>
        <a href="/signup">
            <button class="footer-signup-btn">Sign Up</button>
        </a>
    </div>

    <div class="footer-logo">
        <img src="/public/images/logos/athletiq_logo_transparent.png" alt="Athletiq Logo">
    </div>
</footer>

</body>
</html>