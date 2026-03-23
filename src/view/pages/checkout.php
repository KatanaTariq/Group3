<?php $title = 'Athletiq | Checkout'; ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<?php
$items = $items ?? [];
$addresses = $addresses ?? [];
$subtotal = $subtotal ?? 0;
$old = $old ?? [];
?>

<div class="checkout-page">

    <div class="checkout-header">
        <h1 class="checkout-title">Checkout</h1>
        <p class="checkout-subtitle">Complete your order details below.</p>
    </div>

    <?php if (!empty($_GET['error'])): ?>
        <div class="checkout-message checkout-message-error" aria-live="polite">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_GET['success'])): ?>
        <div class="checkout-message checkout-message-success" aria-live="polite">
            <?php echo htmlspecialchars($_GET['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($items)): ?>
        <div class="checkout-empty">
            <p>Your basket is empty.</p>
        </div>
    <?php else: ?>

        <div class="checkout-layout">

            <div class="checkout-main">
                <form class="payment-form" method="POST" action="/checkout/process" id="checkoutForm">
                    <input
                        type="hidden"
                        name="csrf_token"
                        value="<?php echo htmlspecialchars(get_csrf_token()); ?>"
                    >

                    <section class="checkout-section">
                        <div class="section-heading">
                            <h2>Shipping Address</h2>
                            <p>Choose a saved address or enter a new one.</p>
                        </div>

                        <label for="shipping_address_id">Saved shipping address</label>
                        <select name="shipping_address_id" id="shipping_address_id">
                            <option value="">Use a new shipping address</option>
                            <?php foreach ($addresses as $address): ?>
                                <option
                                    value="<?php echo (int) $address['address_id']; ?>"
                                    <?php echo ((string) ($old['shipping_address_id'] ?? '') === (string) $address['address_id']) ? 'selected' : ''; ?>
                                >
                                    <?php
                                    echo htmlspecialchars(
                                        $address['street'] . ', ' .
                                        $address['city'] . ', ' .
                                        $address['post_code']
                                    );
                                    ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <div class="address-fields" id="shipping-address-fields">
                            <label for="shipping_street">Street</label>
                            <input
                                type="text"
                                name="shipping_street"
                                id="shipping_street"
                                autocomplete="address-line1"
                                maxlength="120"
                                value="<?php echo htmlspecialchars($old['shipping_street'] ?? ''); ?>"
                            >

                            <label for="shipping_city">City</label>
                            <input
                                type="text"
                                name="shipping_city"
                                id="shipping_city"
                                autocomplete="address-level2"
                                maxlength="60"
                                value="<?php echo htmlspecialchars($old['shipping_city'] ?? ''); ?>"
                            >

                            <label for="shipping_county">County</label>
                            <input
                                type="text"
                                name="shipping_county"
                                id="shipping_county"
                                autocomplete="address-level1"
                                maxlength="60"
                                value="<?php echo htmlspecialchars($old['shipping_county'] ?? ''); ?>"
                            >

                            <label for="shipping_post_code">Post Code</label>
                            <input
                                type="text"
                                name="shipping_post_code"
                                id="shipping_post_code"
                                autocomplete="postal-code"
                                maxlength="10"
                                pattern="[A-Za-z0-9 ]{5,10}"
                                title="Enter a valid post code."
                                value="<?php echo htmlspecialchars($old['shipping_post_code'] ?? ''); ?>"
                            >
                        </div>
                    </section>

                    <section class="checkout-section">
                        <div class="section-heading">
                            <h2>Billing Address</h2>
                            <p>Use the same details as shipping or choose another address.</p>
                        </div>

                        <label class="checkbox-row">
                            <input
                                type="checkbox"
                                id="same_as_shipping"
                                name="same_as_shipping"
                                <?php echo !array_key_exists('same_as_shipping', $old) || !empty($old['same_as_shipping']) ? 'checked' : ''; ?>
                            >
                            <span>Billing address is the same as shipping</span>
                        </label>

                        <div id="billing-section-content" class="billing-section-content" style="display: none;">
                            <label for="billing_address_id">Saved billing address</label>
                            <select name="billing_address_id" id="billing_address_id">
                                <option value="">Use a new billing address</option>
                                <?php foreach ($addresses as $address): ?>
                                    <option
                                        value="<?php echo (int) $address['address_id']; ?>"
                                        <?php echo ((string) ($old['billing_address_id'] ?? '') === (string) $address['address_id']) ? 'selected' : ''; ?>
                                    >
                                        <?php
                                        echo htmlspecialchars(
                                            $address['street'] . ', ' .
                                            $address['city'] . ', ' .
                                            $address['post_code']
                                        );
                                        ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <div class="address-fields" id="billing-address-fields">
                                <label for="billing_street">Street</label>
                                <input
                                    type="text"
                                    name="billing_street"
                                    id="billing_street"
                                    autocomplete="address-line1"
                                    maxlength="120"
                                    value="<?php echo htmlspecialchars($old['billing_street'] ?? ''); ?>"
                                >

                                <label for="billing_city">City</label>
                                <input
                                    type="text"
                                    name="billing_city"
                                    id="billing_city"
                                    autocomplete="address-level2"
                                    maxlength="60"
                                    value="<?php echo htmlspecialchars($old['billing_city'] ?? ''); ?>"
                                >

                                <label for="billing_county">County</label>
                                <input
                                    type="text"
                                    name="billing_county"
                                    id="billing_county"
                                    autocomplete="address-level1"
                                    maxlength="60"
                                    value="<?php echo htmlspecialchars($old['billing_county'] ?? ''); ?>"
                                >

                                <label for="billing_post_code">Post Code</label>
                                <input
                                    type="text"
                                    name="billing_post_code"
                                    id="billing_post_code"
                                    autocomplete="postal-code"
                                    maxlength="10"
                                    pattern="[A-Za-z0-9 ]{5,10}"
                                    title="Enter a valid post code."
                                    value="<?php echo htmlspecialchars($old['billing_post_code'] ?? ''); ?>"
                                >
                            </div>
                        </div>
                    </section>

                    <section class="checkout-section">
                        <div class="section-heading">
                            <h2>Payment Details</h2>
                            <p>Enter your payment information below.</p>
                        </div>

                        <label for="name">Full Name</label>
                        <input
                            type="text"
                            id="name"
                            name="cardholder_name"
                            placeholder="Alex Smith"
                            autocomplete="cc-name"
                            maxlength="100"
                            pattern="[A-Za-zÀ-ÿ' -]{2,100}"
                            title="Enter the cardholder name using letters only."
                            value="<?php echo htmlspecialchars($old['cardholder_name'] ?? ''); ?>"
                            required
                        >

                        <label for="email">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="payment_email"
                            placeholder="example@email.com"
                            autocomplete="email"
                            maxlength="254"
                            value="<?php echo htmlspecialchars($old['payment_email'] ?? ''); ?>"
                            required
                        >

                        <label for="card">Card Number</label>
                        <input
                            type="text"
                            id="card"
                            name="card_number"
                            placeholder="1234 5678 9123 4567"
                            inputmode="numeric"
                            autocomplete="cc-number"
                            maxlength="19"
                            pattern="\d{4}\s\d{4}\s\d{4}\s\d{4}"
                            title="Enter a 16-digit card number."
                            value="<?php echo htmlspecialchars($old['card_number'] ?? ''); ?>"
                            required
                        >

                        <div class="payment-row">
                            <div>
                                <label for="expiry">Expiry Date</label>
                                <input
                                    type="text"
                                    id="expiry"
                                    name="expiry"
                                    placeholder="MM/YY"
                                    inputmode="numeric"
                                    autocomplete="cc-exp"
                                    maxlength="5"
                                    pattern="(0[1-9]|1[0-2])\/[0-9]{2}"
                                    title="Enter the expiry date in MM/YY format."
                                    value="<?php echo htmlspecialchars($old['expiry'] ?? ''); ?>"
                                    required
                                >
                            </div>

                            <div>
                                <label for="cvv">CVV</label>
                                <input
                                    type="password"
                                    id="cvv"
                                    name="cvv"
                                    placeholder="123"
                                    inputmode="numeric"
                                    autocomplete="cc-csc"
                                    maxlength="4"
                                    pattern="\d{3,4}"
                                    title="Enter a 3 or 4 digit CVV."
                                    value=""
                                    required
                                >
                            </div>
                        </div>

                        <button type="submit" class="submit-btn">Place Order</button>
                    </section>
                </form>
            </div>

            <aside class="checkout-sidebar">
                <div class="order-summary-card">
                    <h2>Order Summary</h2>

                    <div class="checkout-items">
                        <?php foreach ($items as $item): ?>
                            <div class="checkout-item">
                                <img
                                    src="<?php echo htmlspecialchars($item['image_url']); ?>"
                                    alt="<?php echo htmlspecialchars($item['name']); ?>"
                                >

                                <div class="item-info">
                                    <p class="item-name"><?php echo htmlspecialchars($item['name']); ?></p>
                                    <p>Size: <?php echo htmlspecialchars($item['size']); ?></p>

                                    <?php if (!empty($item['colour'])): ?>
                                        <p>Colour: <?php echo htmlspecialchars($item['colour']); ?></p>
                                    <?php endif; ?>

                                    <p>Qty: <?php echo (int) $item['quantity']; ?></p>
                                </div>

                                <p class="item-price">
                                    £<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="summary-total">
                        <span>Total</span>
                        <strong>£<?php echo number_format($subtotal, 2); ?></strong>
                    </div>
                </div>
            </aside>

        </div>
    <?php endif; ?>
</div>

<script src="/public/js/checkout.js"></script>

<?php include __DIR__ . '/../templates/footer.php'; ?>