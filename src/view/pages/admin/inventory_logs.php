<?php
// Use admin header + nav
require __DIR__ . '/../../templates/header.php';
require __DIR__ . '/../../templates/admin_nav.php';

/**
 * Expecting $logs from InventoryController::logs()
 * If opened directly, we provide an empty default.
 */
if (!isset($logs) || !is_array($logs)) {
    $logs = [];
}
?>

<main class="admin-content">
    <h1>Inventory Change Log</h1>
    <p>Recent stock changes made by admins.</p>

    <?php if (empty($logs)): ?>
        <p>No inventory changes have been logged yet.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Product</th>
                    <th>Variant</th>
                    <th>SKU</th>
                    <th>Old Qty</th>
                    <th>New Qty</th>
                    <th>Change</th>
                    <th>Admin ID</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?= htmlspecialchars($log['created_at'] ?? '') ?></td>
                    <td><?= htmlspecialchars($log['product_name'] ?? '') ?></td>
                    <td>
                        <?= htmlspecialchars($log['variant_size'] ?? '') ?>
                        <?= isset($log['variant_colour']) ? ' / ' . htmlspecialchars($log['variant_colour']) : '' ?>
                    </td>
                    <td><?= htmlspecialchars($log['sku'] ?? '') ?></td>
                    <td><?= htmlspecialchars($log['old_quantity'] ?? '') ?></td>
                    <td><?= htmlspecialchars($log['new_quantity'] ?? '') ?></td>
                    <td><?= htmlspecialchars($log['change_amount'] ?? '') ?></td>
                    <td><?= htmlspecialchars($log['admin_id'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($log['reason'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>

<?php
require __DIR__ . '/../../templates/footer.php';
?>
