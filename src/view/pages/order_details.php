<?php $title = 'Athletiq | Order Details'; ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<div class="order-details-page">

    <div class="order-details-header">
        <h1>Order Details</h1>
        <p>Review the items and status for this order.</p>
    </div>

    <div class="order-details-summary-card">
        <div class="order-details-summary-grid">
            <div class="order-summary-item">
                <span class="order-summary-label">Order Number</span>
                <span class="order-summary-value"><?php echo htmlspecialchars($order['order_number']); ?></span>
            </div>

            <div class="order-summary-item">
                <span class="order-summary-label">Date ordered</span>
                <span class="order-summary-value"><?php echo htmlspecialchars(date('d/m/Y', strtotime($order['created_at']))); ?></span>
            </div>

            <div class="order-summary-item">
                <span class="order-summary-label">Status</span>
                <span class="order-summary-value">
                    <span class="order-status"><?php echo htmlspecialchars($order['status']); ?></span>
                </span>
            </div>

            <div class="order-summary-item">
                <span class="order-summary-label">Total</span>
                <span class="order-summary-value">£<?php echo number_format((float)$order['total_amount'], 2); ?></span>
            </div>
        </div>
    </div>

    <?php if (!empty($order['items'])): ?>
        <div class="order-details-table-wrap">
            <table class="order-details-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Description</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($order['items'] as $item): ?>
                        <tr>
                            <td data-label="Item">
                                <span class="order-item-name">
                                    <?php echo htmlspecialchars($item['product_name']); ?>
                                </span>
                            </td>

                            <td data-label="Description">
                                <div class="order-item-meta">
                                    <p>Size: <?php echo htmlspecialchars($item['size'] ?? 'N/A'); ?></p>
                                    <p>Colour: <?php echo htmlspecialchars($item['colour'] ?? 'N/A'); ?></p>
                                    <p>SKU: <?php echo htmlspecialchars($item['sku'] ?? 'N/A'); ?></p>
                                </div>
                            </td>

                            <td data-label="Unit Price">
                                £<?php echo number_format((float)$item['unit_price'], 2); ?>
                            </td>

                            <td data-label="Quantity">
                                <?php echo (int)$item['quantity']; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="order-details-empty">
            <p>No items found for this order.</p>
        </div>
    <?php endif; ?>

    <div class="order-details-actions">
        <a class="view-details-button" href="/previous-orders">Back to Orders</a>
    </div>

</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>