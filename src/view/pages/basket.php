<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athletiq | Basket</title>
    <link rel="icon" href="/images/logos/favicon.png" type="image/png">
    <link rel="apple-touch-icon" href="/images/logos/favicon.png">
    <link rel="stylesheet" href="/css/nav.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/basket.css">
</head>

<body>

<?php include __DIR__ . '/../templates/nav.php'; ?>

<h1 class="basket-title">Your Shopping Basket</h1>

<div class="basket-container" id="basket-items">
    
</div>

<div class="basket-footer">
    <p class="total">Total: £<span id="basket-total">0.00</span></p>
    <button class="checkout-btn">Proceed to Checkout</button>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>

<script src="/js/basket.js"></script>

</body>
</html>