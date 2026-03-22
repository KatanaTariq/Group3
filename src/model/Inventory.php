<?php

class Inventory
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Get all inventory items with product and variant details.
     *
     * @return array
     */
    public function getAllInventory(): array
    {
        $sql = "
            SELECT
                i.inventory_id,
                pv.variant_id,
                p.name AS product_name,
                pv.size AS variant_size,
                pv.colour AS variant_colour,
                pv.sku,
                i.current_stock,
                i.low_stock_threshold
            FROM inventory i
            INNER JOIN product_variant pv
                ON i.variant_id = pv.variant_id
            INNER JOIN product p
                ON pv.product_id = p.product_id
            ORDER BY p.name ASC, pv.size ASC, pv.colour ASC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get current stock for one variant.
     *
     * @param int $variantId
     * @return int|null
     */
    public function getCurrentStock(int $variantId): ?int
    {
        $sql = "
            SELECT current_stock
            FROM inventory
            WHERE variant_id = :variant_id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':variant_id' => $variantId
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? (int)$row['current_stock'] : null;
    }

    /**
     * Update stock and log the change.
     *
     * @param int $variantId
     * @param int $newQuantity
     * @return bool
     */
    public function updateStock(int $variantId, int $newQuantity): bool
    {
        try {
            $this->pdo->beginTransaction();

            $currentSql = "
                SELECT current_stock
                FROM inventory
                WHERE variant_id = :variant_id
                FOR UPDATE
            ";
            $currentStmt = $this->pdo->prepare($currentSql);
            $currentStmt->execute([
                ':variant_id' => $variantId
            ]);

            $row = $currentStmt->fetch(PDO::FETCH_ASSOC);

            $oldQty = $row ? (int)$row['current_stock'] : 0;
            $changeAmount = $newQuantity - $oldQty;

            if ($row) {
                $updateSql = "
                    UPDATE inventory
                    SET current_stock = :qty,
                        updated_at = NOW()
                    WHERE variant_id = :variant_id
                ";
            } else {
                $updateSql = "
                    INSERT INTO inventory (
                        variant_id,
                        current_stock,
                        low_stock_threshold,
                        created_at,
                        updated_at
                    )
                    VALUES (
                        :variant_id,
                        :qty,
                        0,
                        NOW(),
                        NOW()
                    )
                ";
            }

            $updateStmt = $this->pdo->prepare($updateSql);
            $updateStmt->execute([
                ':variant_id' => $variantId,
                ':qty' => $newQuantity
            ]);

            $logSql = "
                INSERT INTO inventory_log (
                    variant_id,
                    change_amount,
                    reason,
                    created_at
                )
                VALUES (
                    :variant_id,
                    :change_amount,
                    :reason,
                    NOW()
                )
            ";

            $logStmt = $this->pdo->prepare($logSql);
            $logStmt->execute([
                ':variant_id' => $variantId,
                ':change_amount' => $changeAmount,
                ':reason' => 'Manual admin update'
            ]);

            $this->pdo->commit();
            return true;

        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            return false;
        }
    }

    /**
     * Get recent inventory log entries.
     *
     * @param int $limit
     * @return array
     */
    public function getRecentLogs(int $limit = 50): array
    {
        $sql = "
            SELECT
                il.log_id,
                il.variant_id,
                il.change_amount,
                il.reason,
                il.created_at,
                p.name AS product_name,
                pv.size AS variant_size,
                pv.colour AS variant_colour,
                pv.sku
            FROM inventory_log il
            INNER JOIN product_variant pv
                ON il.variant_id = pv.variant_id
            INNER JOIN product p
                ON pv.product_id = p.product_id
            ORDER BY il.created_at DESC
            LIMIT :limit
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}