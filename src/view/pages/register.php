<h1>register page</h1>

<?php if (!empty($_GET['error'])): ?>
    <p>registration failed: <?php echo htmlspecialchars($_GET['error']); ?></p>
<?php endif; ?>

<form method="post" action="/register">
    <!-- CSRF token -->
    <input type="hidden" name="csrf_token"
           value="<?php echo htmlspecialchars(get_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
    <label>first name</label>
    <input type="text" name="first_name">

    <label>last name</label>
    <input type="text" name="last_name">

    <label>email</label>
    <input type="email" name="email">

    <label>password</label>
    <input type="password" name="password">

    <button type="submit">register</button>
</form>

<p><a href="/login">go to login</a></p>
