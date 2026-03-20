<?php

class Inventory
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Get all inventory items with product + variant info.
     *
     * Uses your LOCAL table names:
     *  - product
     *  - productvariant
     *  - inventory
     */
    public function getAllInventory(): array
    {
        $sql = "
            SELECT
                pv.variant_id,
                p.name AS product_name,
                pv.size,
                pv.colour,
                pv.sku,
                COALESCE(i.current_stock, 0)        AS current_stock,
                COALESCE(i.low_stock_threshold, 0)  AS low_stock_threshold
            FROM productvariant pv
            INNER JOIN product p
                ON p.product_id = pv.product_id
            LEFT JOIN inventory i
                ON i.variant_id = pv.variant_id
            ORDER BY p.name, pv.size, pv.colour
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update the stock for a given variant_id and log the change.
     *
     * Uses your LOCAL table names:
     *  - inventory
     *  - inventorylog
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
    $stmt->execute([':variant_id' => $variantId]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? (int)$row['current_stock'] : null;
    }
    
    public function updateStock(int $variantId, int $newQuantity): bool
    {
        try {
            $this->pdo->beginTransaction();

            // Lock the row and read old quantity
            $currentSql = "
                SELECT current_stock
                FROM inventory
                WHERE variant_id = :variant_id
                FOR UPDATE
            ";
            $currentStmt = $this->pdo->prepare($currentSql);
            $currentStmt->execute([':variant_id' => $variantId]);
            $row = $currentStmt->fetch(PDO::FETCH_ASSOC);

            $oldQty       = $row ? (int)$row['current_stock'] : 0;
            $changeAmount = $newQuantity - $oldQty;

            // Insert or update inventory row
            if ($row) {
                $updateSql = "
                    UPDATE inventory
                    SET current_stock = :qty,
                        updated_at    = NOW()
                    WHERE variant_id = :variant_id
                ";
            } else {
                $updateSql = "
                    INSERT INTO inventory (variant_id, current_stock, low_stock_threshold, created_at, updated_at)
                    VALUES (:variant_id, :qty, 0, NOW(), NOW())
                ";
            }

            $updateStmt = $this->pdo->prepare($updateSql);
            $updateStmt->execute([
                ':variant_id' => $variantId,
                ':qty'        => $newQuantity,
            ]);

            // Log change in inventorylog
            $logSql = "
                INSERT INTO inventorylog (variant_id, change_amount, reason, created_at)
                VALUES (:variant_id, :change_amount, :reason, NOW())
            ";
            $logStmt = $this->pdo->prepare($logSql);
            $logStmt->execute([
                ':variant_id'    => $variantId,
                ':change_amount' => $changeAmount,
                ':reason'        => 'Manual admin update',
            ]);

            $this->pdo->commit();
            return true;

        } catch (PDOException $e) {
            $this->pdo->rollBack();
            // For debugging you can temporarily echo $e->getMessage();
            return false;
        }
    }
}
