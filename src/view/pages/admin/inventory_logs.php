<?php
require_once __DIR__ . '/../../templates/header.php';
require_once __DIR__ . '/../../templates/admin_nav.php';

// Expecting $logs from InventoryController::logs()
// If opened directly, fallback to empty list
if (!isset($logs) || !is_array($logs)) {
    $logs = [];
}
?>

<main style="background:#fff; margin:20px 40px; padding:30px 40px; border-radius:8px; border:1px solid #ddd;">
    <h1 style="margin-top:0;">Inventory Change Log</h1>
    <p style="margin-bottom:20px;">Recent stock changes made by admins.</p>

    <?php if (empty($logs)): ?>
        <p>No inventory changes have been logged yet.</p>
    <?php else: ?>
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; border:1px solid #ddd;">
                <thead>
                    <tr style="background:#f7f7f7; text-align:left;">
                        <th style="padding:12px; border-bottom:1px solid #ddd;">Time</th>
                        <th style="padding:12px; border-bottom:1px solid #ddd;">Product</th>
                        <th style="padding:12px; border-bottom:1px solid #ddd;">Variant</th>
                        <th style="padding:12px; border-bottom:1px solid #ddd;">SKU</th>
                        <th style="padding:12px; border-bottom:1px solid #ddd;">Old Qty</th>
                        <th style="padding:12px; border-bottom:1px solid #ddd;">New Qty</th>
                        <th style="padding:12px; border-bottom:1px solid #ddd;">Change</th>
                        <th style="padding:12px; border-bottom:1px solid #ddd;">Admin ID</th>
                        <th style="padding:12px; border-bottom:1px solid #ddd;">Reason</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($logs as $log): ?>
                    <?php
                        $change = (int)($log['change_amount'] ?? 0);
                        $rowStyle = $change < 0 ? 'background:#fff5f5;' : 'background:#fff;';
                    ?>
                    <tr style="<?= $rowStyle ?>">
                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <?= htmlspecialchars($log['created_at'] ?? '') ?>
                        </td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <?= htmlspecialchars($log['product_name'] ?? '') ?>
                        </td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <?= htmlspecialchars($log['variant_size'] ?? '') ?>
                            <?= isset($log['variant_colour']) && $log['variant_colour'] !== '' ? ' / ' . htmlspecialchars($log['variant_colour']) : '' ?>
                        </td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <?= htmlspecialchars($log['sku'] ?? '') ?>
                        </td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <?= htmlspecialchars($log['old_quantity'] ?? '') ?>
                        </td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <?= htmlspecialchars($log['new_quantity'] ?? '') ?>
                        </td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <?php if ($change < 0): ?>
                                <strong style="color:#b00000;">
                                    <?= htmlspecialchars($log['change_amount'] ?? '') ?>
                                </strong>
                            <?php else: ?>
                                <strong style="color:#0a7a2f;">
                                    <?= htmlspecialchars($log['change_amount'] ?? '') ?>
                                </strong>
                            <?php endif; ?>
                        </td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <?= htmlspecialchars($log['admin_id'] ?? '—') ?>
                        </td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <?= htmlspecialchars($log['reason'] ?? '') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../../templates/footer.php'; ?>