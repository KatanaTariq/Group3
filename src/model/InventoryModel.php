<?php

/**
 * ==========================================================
 *                    INVENTORY MODEL
 * ==========================================================
 * Uses existing schema exactly as provided.
 *
 * Tables:
 *  - Inventory(variant_id, current_stock, low_stock_threshold, ...)
 *  - InventoryLog(variant_id, change_amount, reason, created_at)
 *  - ProductVariant, Product
 */

class InventoryModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getInventoryWithProductDetails(): array
    {
        $sql = "
            SELECT 
                i.inventory_id,
                i.variant_id,
                i.current_stock,
                i.low_stock_threshold,
                pv.sku,
                pv.size,
                pv.colour,
                p.name AS product_name
            FROM Inventory i
            INNER JOIN ProductVariant pv ON i.variant_id = pv.variant_id
            INNER JOIN Product p ON pv.product_id = p.product_id
            ORDER BY p.name ASC, pv.sku ASC
        ";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getCurrentStock(int $variantId): ?int
    {
        $stmt = $this->pdo->prepare(
            "SELECT current_stock FROM Inventory WHERE variant_id = ? LIMIT 1"
        );
        $stmt->execute([$variantId]);

        $val = $stmt->fetchColumn();
        if ($val === false) {
            return null;
        }
        return (int)$val;
    }

    public function updateStock(int $variantId, int $newStock): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE Inventory SET current_stock = ? WHERE variant_id = ?"
        );
        return $stmt->execute([$newStock, $variantId]);
    }

    public function logChange(int $variantId, int $changeAmount, string $reason): bool
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO InventoryLog (variant_id, change_amount, reason, created_at)
             VALUES (?, ?, ?, NOW())"
        );
        return $stmt->execute([$variantId, $changeAmount, $reason]);
    }

    public function getRecentLogs(int $limit = 50): array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                il.log_id,
                il.variant_id,
                il.change_amount,
                il.reason,
                il.created_at,
                pv.sku,
                p.name AS product_name
            FROM InventoryLog il
            INNER JOIN ProductVariant pv ON il.variant_id = pv.variant_id
            INNER JOIN Product p ON pv.product_id = p.product_id
            ORDER BY il.created_at DESC
            LIMIT ?
        ");

        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}
