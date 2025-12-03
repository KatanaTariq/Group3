<?php
// Admin header + nav
require __DIR__ . '/../../templates/header.php';
require __DIR__ . '/../../templates/admin_nav.php';

// Expecting $inventoryItems from InventoryController::index()
// If opened directly, fallback for development:
if (!isset($inventoryItems) || !is_array($inventoryItems)) {
    $inventoryItems = [
        [
            'variant_id'          => 1,
            'product_name'        => 'Sample Tee – Black',
            'variant_size'        => 'M',
            'variant_colour'      => 'Black',
            'sku'                 => 'SAMPLE-TEE-BLK-M',
            'current_stock'       => 10,
            'low_stock_threshold' => 5
        ]
    ];
}

// Ensure session exists for flash messages
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<main class="admin-content">
    <h1>Inventory Management</h1>
    <p>Here the admin can view and update stock levels for all product variants.</p>

    <!-- ====================== -->
    <!-- FLASH MESSAGES -->
    <!-- ====================== -->

    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="alert alert-danger" style="padding:10px; background:#ffdddd; margin-bottom:15px; border-left:4px solid #d00;">
            <?= htmlspecialchars($_SESSION['flash_error']) ?>
        </div>
        <?php unset($_SESSION['flash_error']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="alert alert-success" style="padding:10px; background:#ddffdd; margin-bottom:15px; border-left:4px solid #0a0;">
            <?= htmlspecialchars($_SESSION['flash_success']) ?>
        </div>
        <?php unset($_SESSION['flash_success']); ?>
    <?php endif; ?>

    <!-- ====================== -->
    <!-- INVENTORY TABLE -->
    <!-- ====================== -->

    <?php if (empty($inventoryItems)): ?>
        <p>No inventory items found.</p>
    <?php else: ?>
        <table class="table" style="width:100%; border-collapse:collapse;">
            <thead>
                <tr>
                    <th>Variant ID</th>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Colour</th>
                    <th>SKU</th>
                    <th>Current Stock</th>
                    <th>Low Stock Threshold</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($inventoryItems as $item): ?>

                <?php
                    $currentStock = isset($item['current_stock']) ? (int)$item['current_stock'] : 0;
                    $threshold    = isset($item['low_stock_threshold']) ? (int)$item['low_stock_threshold'] : 0;
                    $isLow        = $threshold > 0 && $currentStock <= $threshold;
                ?>

                <tr style="<?= $isLow ? 'background:#fff3f3;' : '' ?>">
                    <td><?= htmlspecialchars($item['variant_id']) ?></td>

                    <td><?= htmlspecialchars($item['product_name']) ?></td>

                    <td><?= htmlspecialchars($item['variant_size'] ?? '') ?></td>

                    <td><?= htmlspecialchars($item['variant_colour'] ?? '') ?></td>

                    <td><?= htmlspecialchars($item['sku']) ?></td>

                    <td>
                        <?= $currentStock ?>
                        <?php if ($isLow): ?>
                            <strong style="color:#d00;"> (LOW)</strong>
                        <?php endif; ?>
                    </td>

                    <td><?= $threshold ?></td>

                    <td>
                        <form method="post" action="/admin/inventory/update" style="display:flex; gap:5px;">
                            <input type="hidden" name="variant_id" value="<?= (int)$item['variant_id'] ?>">
                            <input
                                type="number"
                                name="new_quantity"
                                min="0"
                                value="<?= (int)$item['current_stock'] ?>"
                                style="width:70px;"
                            >
                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>

            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>

<?php
require __DIR__ . '/../../templates/footer.php';
?>

