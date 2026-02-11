<?php
// expects: $csrf, $error
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }
        .container {
            max-width: 420px;
            margin: 60px auto;
            background: #fff;
            padding: 24px;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 16px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 14px;
        }
        button {
            padding: 10px 16px;
            cursor: pointer;
        }
        .error {
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            background: #fbeaea;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Login</h2>

    <?php if (!empty($error)): ?>
        <div class="error">
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

    <form method="POST" action="/Group3/admin/login" autocomplete="off">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Log in</button>
    </form>
</div>

</body>
</html>