<?php
function e($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>

<?php if (!empty($_SESSION['flash_success'])): ?>
    <p style="color: green; font-weight: bold;">
        <?= e($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?>
    </p>
<?php endif; ?>

<?php if (!empty($_SESSION['flash_error'])): ?>
    <p style="color: red; font-weight: bold;">
        <?= e($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?>
    </p>
<?php endif; ?>

<h1>Inventory Management</h1>
<p>Here the admin can view and update stock levels for all product variants.</p>

<?php if (empty($inventoryItems)): ?>
    <p>No inventory items found.</p>
<?php else: ?>
    <table border="1" cellpadding="8" cellspacing="0" width="100%">
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
            <tr>
                <td><?= e($item['variant_id']) ?></td>
                <td><?= e($item['product_name']) ?></td>
                <td><?= e($item['size']) ?></td>
                <td><?= e($item['colour']) ?></td>
                <td><?= e($item['sku']) ?></td>
                <td><?= e($item['current_stock']) ?></td>
                <td><?= e($item['low_stock_threshold']) ?></td>
                <td>
                    <form method="POST" action="/Group3/index.php/admin/inventory/update" style="display:inline;">
                        <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
                        <input type="hidden" name="variant_id" value="<?= e($item['variant_id']) ?>">

                        <input type="number" name="new_stock" min="0" required value="<?= e($item['current_stock']) ?>">
                        <button type="submit">Update</button>

                        <br><br>
                        <input type="text" name="reason" maxlength="100" placeholder="Reason (optional)">
                    </form>

                    <br><br>
                    
                    <a href="/Group3/index.php/admin/inventory/logs">View Logs</a>

                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
