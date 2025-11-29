<h1>profile page</h1>

<?php if (!isset($_SESSION['customer_id'])): ?>
    <p>not logged in</p>
    <p><a href="/login">go to login</a></p>
<?php else: ?>
    <p>logged in as customer id: <?php echo $_SESSION['customer_id']; ?></p>
    <p><a href="/logout">logout</a></p>
<?php endif; ?>
