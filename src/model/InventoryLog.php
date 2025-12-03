<?php

class InventoryLog
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Record a stock change for a variant.
     *
     * Assumes an inventory_log table roughly like:
     *  - id (PK, auto)
     *  - variant_id (FK)
     *  - old_quantity
     *  - new_quantity
     *  - change_amount
     *  - admin_id (nullable)
     *  - reason (text)
     *  - created_at (timestamp)
     */
    public function createLog(
        int $variantId,
        int $oldQuantity,
        int $newQuantity,
        ?int $adminId = null,
        string $reason = 'Manual admin stock update'
    ): bool {
        try {
            $changeAmount = $newQuantity - $oldQuantity;

            $sql = "
                INSERT INTO inventory_log
                    (variant_id, old_quantity, new_quantity, change_amount, admin_id, reason, created_at)
                VALUES
                    (:variant_id, :old_quantity, :new_quantity, :change_amount, :admin_id, :reason, NOW())
            ";

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':variant_id'    => $variantId,
                ':old_quantity'  => $oldQuantity,
                ':new_quantity'  => $newQuantity,
                ':change_amount' => $changeAmount,
                ':admin_id'      => $adminId,
                ':reason'        => $reason,
            ]);
        } catch (Throwable $e) {
            // When DB is down we just fail quietly – can add error_log later.
            return false;
        }
    }

    /**
     * Get the most recent stock changes, joined with product + variant details.
     */
    public function getRecentLogs(int $limit = 50): array
    {
        try {
            $sql = "
                SELECT 
                    l.id,
                    l.variant_id,
                    l.old_quantity,
                    l.new_quantity,
                    l.change_amount,
                    l.admin_id,
                    l.reason,
                    l.created_at,
                    p.name       AS product_name,
                    pv.size      AS variant_size,
                    pv.colour    AS variant_colour,
                    pv.sku       AS sku
                FROM inventory_log l
                INNER JOIN product_variant pv ON l.variant_id = pv.variant_id
                INNER JOIN product p        ON pv.product_id = p.product_id
                ORDER BY l.created_at DESC
                LIMIT :limit
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            return [];
        }
    }
}
