<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athletiq | Checkout</title>
    <link rel="stylesheet" href="/src/view/css/nav.css">
    <link rel="stylesheet" href="/src/view/css/footer.css">
    <link rel="stylesheet" href="/src/view/css/checkout.css">
</head>

<body>

<?php include __DIR__ . '/../templates/nav.php'; ?>

<h1 class="checkout-title">Checkout</h1>

<div class="checkout-container" id="checkout-items">
    
</div>

<p class="total">Total: £<span id="checkout-total">0.00</span></p>

<form class="payment-form" id="payment-form">
    <label for="name">Full Name</label>
    <input type="text" id="name" placeholder="Alex Smith" required>

    <label for="email">Email</label>
    <input type="email" id="email" placeholder="example@email.com" required>

    <label for="card">Card Number</label>
    <input type="text" id="card" placeholder="1234 5678 91234567" required>

    <label for="expiry">Expiry Date</label>
    <input type="text" id="expiry" placeholder="MM/YY" required>

    <label for="cvv">CVV</label>
    <input type="text" id="cvv" placeholder="321" required>

    <button type="submit" class="submit-btn">Submit My Order</button>
</form>

<script src="/src/view/js/checkout.js"></script>

<?php include __DIR__ . '/../templates/footer.php'; ?>

</body>
</html>