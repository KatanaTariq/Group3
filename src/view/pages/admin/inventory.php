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

<main style="background:#fff; margin:20px 40px; padding:30px 40px; border-radius:8px; border:1px solid #ddd;">
    <h1 style="margin-top:0;">Inventory Management</h1>
    <p style="margin-bottom:20px;">Here the admin can view and update stock levels for all product variants.</p>

    <!-- FLASH MESSAGES -->
    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div style="padding:12px 14px; background:#ffeded; border:1px solid #ffb3b3; border-left:6px solid #000; border-radius:6px; margin-bottom:15px;">
            <?= htmlspecialchars($_SESSION['flash_error']) ?>
        </div>
        <?php unset($_SESSION['flash_error']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div style="padding:12px 14px; background:#eafff0; border:1px solid #9fe3b5; border-left:6px solid var(--primary); border-radius:6px; margin-bottom:15px;">
            <?= htmlspecialchars($_SESSION['flash_success']) ?>
        </div>
        <?php unset($_SESSION['flash_success']); ?>
    <?php endif; ?>

    <?php if (empty($inventoryItems)): ?>
        <p>No inventory items found.</p>
    <?php else: ?>
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; border:1px solid #ddd;">
                <thead>
                    <tr style="background:#f7f7f7; text-align:left;">
                        <th style="padding:12px; border-bottom:1px solid #ddd;">Variant ID</th>
                        <th style="padding:12px; border-bottom:1px solid #ddd;">Product</th>
                        <th style="padding:12px; border-bottom:1px solid #ddd;">Size</th>
                        <th style="padding:12px; border-bottom:1px solid #ddd;">Colour</th>
                        <th style="padding:12px; border-bottom:1px solid #ddd;">SKU</th>
                        <th style="padding:12px; border-bottom:1px solid #ddd;">Current Stock</th>
                        <th style="padding:12px; border-bottom:1px solid #ddd;">Low Stock Threshold</th>
                        <th style="padding:12px; border-bottom:1px solid #ddd;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($inventoryItems as $item): ?>
                    <?php
                        $currentStock = isset($item['current_stock']) ? (int)$item['current_stock'] : 0;
                        $threshold    = isset($item['low_stock_threshold']) ? (int)$item['low_stock_threshold'] : 0;
                        $isLow        = $threshold > 0 && $currentStock <= $threshold;
                    ?>
                    <tr style="<?= $isLow ? 'background:#fff5f5;' : 'background:#fff;' ?>">
                        <td style="padding:12px; border-bottom:1px solid #eee;"><?= htmlspecialchars($item['variant_id']) ?></td>
                        <td style="padding:12px; border-bottom:1px solid #eee;"><?= htmlspecialchars($item['product_name']) ?></td>
                        <td style="padding:12px; border-bottom:1px solid #eee;"><?= htmlspecialchars($item['variant_size'] ?? '') ?></td>
                        <td style="padding:12px; border-bottom:1px solid #eee;"><?= htmlspecialchars($item['variant_colour'] ?? '') ?></td>
                        <td style="padding:12px; border-bottom:1px solid #eee;"><?= htmlspecialchars($item['sku']) ?></td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <?= $currentStock ?>
                            <?php if ($isLow): ?>
                                <strong style="color:#b00000;"> (LOW)</strong>
                            <?php endif; ?>
                        </td>

                        <td style="padding:12px; border-bottom:1px solid #eee;"><?= $threshold ?></td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <form method="post" action="/admin/inventory/update" style="display:flex; gap:10px; align-items:center;">
                                <input type="hidden" name="variant_id" value="<?= (int)$item['variant_id'] ?>">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                                <input
                                    type="number"
                                    name="new_quantity"
                                    min="0"
                                    value="<?= (int)$item['current_stock'] ?>"
                                    style="padding:8px; width:90px; border:2px solid #000; border-radius:4px;"
                                >

                                <!-- Uses existing nav.css button styling -->
                                <button type="submit" class="login-btn">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>

<?php
require __DIR__ . '/../../templates/footer.php';
?>

