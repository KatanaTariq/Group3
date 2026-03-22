<?php $title = 'Athletiq | Checkout'; ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<h1 class="checkout-title">Checkout</h1>

<?php if (!empty($_GET['error'])): ?>
    <p style="text-align:center; color:red;">
        <?php echo htmlspecialchars($_GET['error']); ?>
    </p>
<?php endif; ?>

<?php if (!empty($_GET['success'])): ?>
    <p style="text-align:center; color:green;">
        <?php echo htmlspecialchars($_GET['success']); ?>
    </p>
<?php endif; ?>

<div class="checkout-container" id="checkout-items">
    <?php if (empty($items ?? [])): ?>
        <p style="text-align:center; font-weight:bold; margin:20px 0;">Your basket is empty</p>
    <?php else: ?>
        <?php foreach ($items as $item): ?>
            <div class="checkout-item">
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

                    <p>Quantity: <?php echo (int)$item['quantity']; ?></p>
                </div>

                <p class="item-price">
                    £<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                </p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<p class="total">Total: £<span id="checkout-total"><?php echo number_format($subtotal ?? 0, 2); ?></span></p>

<?php if (!empty($items ?? [])): ?>
    <form class="payment-form" method="POST" action="/checkout/process">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(get_csrf_token()); ?>">

        <h2>Shipping Address</h2>

        <label for="shipping_address_id">Select a saved shipping address</label>
        <select name="shipping_address_id" id="shipping_address_id">
            <option value="">Use a new shipping address</option>
            <?php foreach (($addresses ?? []) as $address): ?>
                <option value="<?php echo (int)$address['address_id']; ?>">
                    <?php echo htmlspecialchars($address['street'] . ', ' . $address['city'] . ', ' . $address['post_code']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <p style="margin-top:15px;"><strong>Or enter a new shipping address</strong></p>

        <label for="shipping_street">Street</label>
        <input type="text" name="shipping_street" id="shipping_street">

        <label for="shipping_city">City</label>
        <input type="text" name="shipping_city" id="shipping_city">

        <label for="shipping_county">County</label>
        <input type="text" name="shipping_county" id="shipping_county">

        <label for="shipping_post_code">Post Code</label>
        <input type="text" name="shipping_post_code" id="shipping_post_code">

        <h2 style="margin-top:30px;">Billing Address</h2>

        <label for="billing_address_id">Select a saved billing address</label>
        <select name="billing_address_id" id="billing_address_id">
            <option value="">Use a new billing address</option>
            <?php foreach (($addresses ?? []) as $address): ?>
                <option value="<?php echo (int)$address['address_id']; ?>">
                    <?php echo htmlspecialchars($address['street'] . ', ' . $address['city'] . ', ' . $address['post_code']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <p style="margin-top:15px;"><strong>Or enter a new billing address</strong></p>

        <label for="billing_street">Street</label>
        <input type="text" name="billing_street" id="billing_street">

        <label for="billing_city">City</label>
        <input type="text" name="billing_city" id="billing_city">

        <label for="billing_county">County</label>
        <input type="text" name="billing_county" id="billing_county">

        <label for="billing_post_code">Post Code</label>
        <input type="text" name="billing_post_code" id="billing_post_code">

        <h2 style="margin-top:30px;">Payment Details</h2>

        <label for="name">Full Name</label>
        <input type="text" id="name" name="cardholder_name" placeholder="Alex Smith" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="payment_email" placeholder="example@email.com" required>

        <label for="card">Card Number</label>
        <input type="text" id="card" name="card_number" placeholder="1234 5678 9123 4567" required>

        <label for="expiry">Expiry Date</label>
        <input type="text" id="expiry" name="expiry" placeholder="MM/YY" required>

        <label for="cvv">CVV</label>
        <input type="text" id="cvv" name="cvv" placeholder="321" required>

        <button type="submit" class="submit-btn">Submit My Order</button>
    </form>
<?php endif; ?>

<?php include __DIR__ . '/../templates/footer.php'; ?>