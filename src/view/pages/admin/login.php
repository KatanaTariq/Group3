<?php
require_once __DIR__ . '/../../templates/header.php';
require_once __DIR__ . '/../../templates/admin_nav.php';
?>

<main style="background:#fff; margin:20px 40px; padding:30px 40px; border-radius:8px; border:1px solid #ddd; max-width:700px;">
    <h1 style="margin-top:0;">Admin Login</h1>
    <p>Log in to manage inventory and view audit logs.</p>

    <?php if (!empty($error)): ?>
        <div style="padding:12px 14px; background:#ffeded; border:1px solid #ffb3b3; border-left:6px solid #000; border-radius:6px; margin:15px 0;">
            <?php
                $messages = [
                    'invalid'   => 'Invalid email or password.',
                    'csrf'      => 'Security check failed. Please refresh and try again.',
                    'session'   => 'Your session expired. Please log in again.',
                    'loggedout' => 'You have been logged out.'
                ];
                echo htmlspecialchars($messages[$error] ?? 'Login error.');
            ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/admin/login" autocomplete="off" style="max-width:520px;">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf ?? '') ?>">

        <label for="email" style="display:block; margin:14px 0 6px; font-weight:600;">Email</label>
        <input type="email" name="email" id="email" required
               style="width:100%; padding:10px; border:2px solid #000; border-radius:6px;">

        <label for="password" style="display:block; margin:14px 0 6px; font-weight:600;">Password</label>
        <input type="password" name="password" id="password" required
               style="width:100%; padding:10px; border:2px solid #000; border-radius:6px;">

        <div style="margin-top:16px;">
            <button type="submit" class="login-btn">Log in</button>
        </div>
    </form>
</main>

<?php require_once __DIR__ . '/../../templates/footer.php'; ?>