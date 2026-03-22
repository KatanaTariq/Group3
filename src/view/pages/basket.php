<?php $title = 'Athletiq | Basket'; ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<h1 class="basket-title">Your Shopping Basket</h1>

<?php if (!empty($_GET['success'])): ?>
    <p style="text-align:center; color:green;">
        <?php echo htmlspecialchars($_GET['success']); ?>
    </p>
<?php endif; ?>

<?php if (!empty($_GET['error'])): ?>
    <p style="text-align:center; color:red;">
        <?php echo htmlspecialchars($_GET['error']); ?>
    </p>
<?php endif; ?>

<div class="basket-container" id="basket-items">
    <?php if (empty($items ?? [])): ?>
        <p id="empty-message">Your basket is empty</p>
    <?php else: ?>
        <?php foreach ($items as $item): ?>
            <div class="basket-item">
                <img
                    src="<?php echo htmlspecialchars($item['image_url']); ?>"
                    alt="<?php echo htmlspecialchars($item['name']); ?>"
                >

                <div class="item-info">
                    <p><?php echo htmlspecialchars($item['name']); ?></p>
                    <p>Size: <?php echo htmlspecialchars($item['size']); ?></p>
                    <?php if (!empty($item['colour'])): ?>
                        <p>Colour: <?php echo htmlspecialchars($item['colour']); ?></p>
                    <?php endif; ?>
                </div>

                <p class="item-price">£<?php echo number_format($item['price'], 2); ?></p>

                <form method="POST" action="/basket/update" class="quantity-control">
                    <input type="hidden" name="basket_item_id" value="<?php echo (int)$item['item_id']; ?>">

                    <button
                        type="submit"
                        class="quantity-btn"
                        name="quantity"
                        value="<?php echo max(1, $item['quantity'] - 1); ?>"
                    >-</button>

                    <input
                        type="number"
                        class="quantity-input"
                        name="quantity"
                        min="1"
                        max="<?php echo (int)$item['current_stock']; ?>"
                        value="<?php echo (int)$item['quantity']; ?>"
                    >

                    <button
                        type="submit"
                        class="quantity-btn"
                        name="quantity"
                        value="<?php echo min($item['current_stock'], $item['quantity'] + 1); ?>"
                    >+</button>
                </form>

                <p class="item-subtotal">
                    £<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                </p>

                <form method="POST" action="/basket/remove">
                    <input type="hidden" name="basket_item_id" value="<?php echo (int)$item['item_id']; ?>">
                    <button class="remove-btn" type="submit">Remove</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="basket-footer">
    <p class="total">Total: £<span id="basket-total"><?php echo number_format($subtotal ?? 0, 2); ?></span></p>

    <?php if (!empty($items ?? [])): ?>
        <a href="/checkout" class="checkout-btn">Proceed to Checkout</a>
    <?php else: ?>
        <button class="checkout-btn" disabled style="opacity:0.5;">Proceed to Checkout</button>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>