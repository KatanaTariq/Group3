<?php $title = 'Athletiq | Basket'; ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<h1 class="basket-title">Your Shopping Basket</h1>

<div class="basket-container" id="basket-items">
    
</div>

<div class="basket-footer">
    <p class="total">Total: £<span id="basket-total">0.00</span></p>
    <button class="checkout-btn">Proceed to Checkout</button>
</div>

<script src="public/js/basket.js"></script>
<?php include __DIR__ . '/../templates/footer.php'; ?>