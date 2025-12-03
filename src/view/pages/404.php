<?php
// Correct relative paths from /src/view/pages to /src/view/templates
require __DIR__ . '/../templates/header.php';
require __DIR__ . '/../templates/navbar.php';
?>

<h1>404 not found</h1>
<p>The page you are looking for does not exist.</p>

<ul>
    <li><a href="/Group3/home">go to home</a></li>
    <li><a href="/Group3/login">go to login</a></li>
</ul>

<?php
require __DIR__ . '/../templates/footer.php';
?>
