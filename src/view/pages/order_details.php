<?php $title = 'Athletiq | Order Details'; ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<div class="orders">
    <h1>Order Details</h1>
</div>

<div class="order-summary">
    <p><strong>Order Number:</strong> <?php echo htmlspecialchars($order['order_number']); ?></p>
    <p><strong>Date ordered:</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($order['created_at']))); ?></p>
    <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
    <p><strong>Total:</strong> £<?php echo number_format((float)$order['total_amount'], 2); ?></p>
</div>

<?php if (!empty($order['items'])): ?>
    <table class="orders-table">
        <div class="table-headings">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                </tr>
            </thead>
        </div>

        <div class="table-content">
            <tbody>
                <?php foreach ($order['items'] as $item): ?>
                    <tr>
                        <td data-label="Item">
                            <?php echo htmlspecialchars($item['product_name']); ?>
                        </td>
                        <td data-label="Description">
                            Size: <?php echo htmlspecialchars($item['size'] ?? 'N/A'); ?>
                            <br>
                            Colour: <?php echo htmlspecialchars($item['colour'] ?? 'N/A'); ?>
                            <br>
                            SKU: <?php echo htmlspecialchars($item['sku'] ?? 'N/A'); ?>
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
        </div>
    </table>
<?php else: ?>
    <p style="text-align:center;">No items found for this order.</p>
<?php endif; ?>

<p style="text-align:center; margin-top:20px;">
    <a class="view-details-button" href="/previous-orders">Back to Orders</a>
</p>

<style>
    
</style>

<?php include __DIR__ . '/../templates/footer.php'; ?>