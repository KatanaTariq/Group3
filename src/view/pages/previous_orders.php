<?php $title = 'Athletiq | Previous Orders'; ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<div class="orders">
    <h1>
        Your Order History
    </h1>
</div>

<?php if (!empty($_GET['success'])): ?>
    <p style="text-align:center; color:green;">
        <?php echo htmlspecialchars($_GET['success']); ?>
    </p>
<?php endif; ?>

<?php if (empty($orders ?? [])): ?>
    <p style="text-align:center;">You have no orders yet.</p>
<?php else: ?>
    <table class="orders-table">
        <div class="table-headings">
            <thead>
                <tr>
                    <th>Date ordered</th>
                    <th>Order Number</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </div>

        <div class="table-content">
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
                            <?php echo htmlspecialchars($order['status']); ?>
                        </td>
                        <td data-label="Action">
                            <a class="view-details-button" href="/order-details?id=<?php echo (int)$order['order_id']; ?>">
                                View Details
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </div>
    </table>
<?php endif; ?>

<style>
    
</style>

<?php include __DIR__ . '/../templates/footer.php'; ?>