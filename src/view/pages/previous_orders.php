<?php $title = 'Athletiq | Previous Orders'; ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<div class="orders-page">
    <div class="orders-header">
        <h1>Your Order History</h1>
        <p>View your previous orders and check their status.</p>
    </div>

    <?php if (!empty($_GET['success'])): ?>
        <div class="orders-message orders-message-success">
            <?php echo htmlspecialchars($_GET['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($orders ?? [])): ?>
        <div class="orders-empty">
            <p>You have no orders yet.</p>
        </div>
    <?php else: ?>
        <div class="orders-table-wrap">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Date ordered</th>
                        <th>Order Number</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td data-label="Date ordered">
                                <?php echo htmlspecialchars(date('d/m/Y', strtotime($order['created_at']))); ?>
                            </td>
                            <td data-label="Order Number">
                                <?php echo htmlspecialchars($order['order_number']); ?>
                            </td>
                            <td data-label="Total">
                                £<?php echo number_format((float)$order['total_amount'], 2); ?>
                            </td>
                            <td data-label="Status">
                                <span class="order-status">
                                    <?php echo htmlspecialchars($order['status']); ?>
                                </span>
                            </td>
                            <td data-label="Action">
                                <a class="view-details-button" href="/order-details?id=<?php echo (int)$order['order_id']; ?>">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>