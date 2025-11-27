<?php
// Use admin header + nav templates if you have them
require __DIR__ . '/../../templates/header.php';
require __DIR__ . '/../../templates/admin_nav.php';

/**
 * Expecting $inventoryItems from InventoryController::index()
 * For today, if you open this file alone, we’ll just use a fallback.
 */
if (!isset($inventoryItems)) {
    $inventoryItems = [
        [
            'variant_id'   => 1,
            'product_name' => 'Sample Tee – Black / M',
            'sku'          => 'SAMPLE-TEE-BLK-M',
            'current_stock'=> 10,
            'low_stock_threshold' => 5
        ]
    ];
}
?>

<main class="admin-content">
    <h1>Inventory Management</h1>
    <p>This is the admin inventory page. Here the admin can view and update stock levels.</p>

    <table class="table">
        <thead>
            <tr>
                <th>Variant ID</th>
                <th>Product</th>
                <th>SKU</th>
                <th>Current Stock</th>
                <th>Low Stock Threshold</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($inventoryItems as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['variant_id']) ?></td>
                <td><?= htmlspecialchars($item['product_name']) ?></td>
                <td><?= htmlspecialchars($item['sku']) ?></td>
                <td><?= htmlspecialchars($item['current_stock']) ?></td>
                <td><?= htmlspecialchars($item['low_stock_threshold']) ?></td>
                <td>
                    <!-- Placeholder form – logic will be wired up later -->
                    <form method="post" action="/admin/inventory/update">
                        <input type="hidden" name="variant_id" value="<?= htmlspecialchars($item['variant_id']) ?>">
                        <input type="number" name="new_quantity" min="0" placeholder="New qty">
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php
require __DIR__ . '/../../templates/footer.php';
?>
