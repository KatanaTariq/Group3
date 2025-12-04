<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 | Page Not Found</title>
    <link rel="icon" href="/src/view/images/logos/athletiq_logo.png" type="image/x-icon">
    <link rel="icon" href="/src/view/images/logos/athletiq_logo.png">
    <link rel="stylesheet" href="/src/view/css/nav.css">
    <link rel="stylesheet" href="/src/view/css/footer.css">
    <link rel="stylesheet" href="/src/view/css/404.css">
</head>
<body>

<?php include __DIR__ . '/../templates/nav.php'; ?>

<div class="errorPage">

    <div class="errorHeader">
        <h1>404</h1>
    </div>

    <div class="errorCard">

        <h2>Woah athlete!! wrong lane.</h2>

        <p class="subtitle">
            Looks like you sprinted into a page that doesn’t exist.
        </p>

        <p class="joke">
            Don’t worry, happens to the best of us.
        </p>

        <div class="actions">
            <a href="/" class="btn">Return Home</a>
            <a href="/login" class="btn secondary">Go to Login</a>
        </div>

    </div>

</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>

</body>
</html>
