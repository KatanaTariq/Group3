<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Athletiq | Basket</title>

<link rel="stylesheet" href="/src/view/css/basket.css">

</head>

<body>

<?php include __DIR__ . '/../templates/nav.php'; ?>

<h1 class="basket-title">Your Shopping Basket</h1>

<div class="basket-container" id="basket-items"></div>

<div class="basket-footer">
    <p class="total">Total: £<span id="basket-total">0.00</span></p>
    <button class="checkout-btn" onclick="location.href='checkout.html'">Proceed to Checkout</button>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>

<script src="/src/view/js/basket.js"></script>
</body>
</html>
