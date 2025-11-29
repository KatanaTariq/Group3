<h1>login page</h1>

<?php if (!empty($_GET['error'])): ?>
    <p>login failed: <?php echo htmlspecialchars($_GET['error']); ?></p>
<?php endif; ?>

<form method="post" action="/login">
    <label>email</label>
    <input type="email" name="email">

    <label>password</label>
    <input type="password" name="password">

    <button type="submit">login</button>
</form>

<p><a href="/register">go to register</a></p>
