<?php $title = 'Athletiq | Profile'; ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<div class="profilePage">

    <div class="profileHeader">
        <h1>Profile</h1>
    </div>

    <div class="profileCard">

        <?php if (!isset($_SESSION['customer_id'])): ?>

            <h2>You’re not logged in</h2>
            <p>Please log in to access your profile.</p>

            <div class="profileActions">
                <a href="/login" class="btn">Go to Login</a>
            </div>

        <?php else: ?>

            <h2>You're in!!</h2>

            <p class="user">
                Athlete ID: <?php echo htmlspecialchars($_SESSION['customer_id']); ?>
            </p>

            <p>
                You're officially logged in and ready to move.
            </p>

            <div class="profileActions">
                <a href="/logout" class="btn secondary">Log out</a>
            </div>

        <?php endif; ?>

    </div>

</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
