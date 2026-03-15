<?php

class InventoryLog
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Get the most recent stock changes, joined with product + variant details.
     *
     * Uses your actual table names:
     *  - inventorylog
     *  - productvariant
     *  - product
     *
     * Note: your current logging (Inventory::updateStock) only stores:
     *  variant_id, change_amount, reason, created_at
     * so old_quantity/new_quantity/admin_id will be returned as NULL.
     */
    public function getRecentLogs(int $limit = 50): array
    {
        try {
            $sql = "
                SELECT
                    l.variant_id,
                    NULL AS old_quantity,
                    NULL AS new_quantity,
                    l.change_amount,
                    NULL AS admin_id,
                    l.reason,
                    l.created_at,
                    p.name    AS product_name,
                    pv.size   AS variant_size,
                    pv.colour AS variant_colour,
                    pv.sku    AS sku
                FROM inventorylog l
                INNER JOIN productvariant pv
                    ON pv.variant_id = l.variant_id
                INNER JOIN product p
                    ON p.product_id = pv.product_id
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