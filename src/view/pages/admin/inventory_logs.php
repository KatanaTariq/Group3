<?php
function e($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>

<h1>Inventory Change Log</h1>
<p>Recent stock changes made by admins.</p>

<?php if (empty($logs)): ?>
    <p>No inventory changes have been logged yet.</p>
<?php else: ?>
    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Date</th>
                <th>Product</th>
                <th>SKU</th>
                <th>Variant ID</th>
                <th>Change</th>
                <th>Reason</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= e($log['created_at']) ?></td>
                <td><?= e($log['product_name']) ?></td>
                <td><?= e($log['sku']) ?></td>
                <td><?= e($log['variant_id']) ?></td>
                <td><?= e($log['change_amount']) ?></td>
                <td><?= e($log['reason']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
