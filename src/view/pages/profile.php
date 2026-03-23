<?php $title = 'Athletiq | Profile'; ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<div class="profilePage">

    <div class="profileCard">

        <?php if (!isset($_SESSION['customer_id'])): ?>

            <p class="profile-eyebrow">ATHLETIQ ACCOUNT</p>
            <h2>You’re not logged in</h2>
            <p class="profile-subtitle">Log in to access your orders, account details, and personalised shopping.</p>

            <div class="profileActions">
                <a href="/login" class="btn">Log In</a>
            </div>

        <?php else: ?>

            <p class="profile-eyebrow">ATHLETIQ MEMBER HUB</p>

            <h1 class="welcome">
                Welcome back, <?php echo htmlspecialchars($customer ? $customer->getFirstName() : 'Athlete'); ?>!
            </h1>

            <p class="profile-subtitle">
                Ready for your next session?
            </p>

            <div class="profileActions">
                <a href="/home" class="profile-action-card">
                    <span class="profile-action-title">Shop</span>
                    <span class="profile-action-text">Browse the latest drops</span>
                </a>

                <a href="/previous-orders" class="profile-action-card">
                    <span class="profile-action-title">Previous Orders</span>
                    <span class="profile-action-text">Track and review your purchases</span>
                </a>

                <a href="/logout" class="profile-action-card profile-action-card-secondary">
                    <span class="profile-action-title">Log Out</span>
                    <span class="profile-action-text">Sign out of your account</span>
                </a>
            </div>

        <?php endif; ?>

    </div>

</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>