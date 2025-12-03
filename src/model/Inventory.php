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
     * If DB is unavailable, falls back to dummy data for development.
     */
    public function getAllInventory(): array
    {
        try {
            $sql = "
                SELECT
                    pv.variant_id,
                    p.name           AS product_name,
                    pv.size          AS variant_size,
                    pv.colour        AS variant_colour,
                    pv.sku           AS sku,
                    i.current_stock,
                    i.low_stock_threshold
                FROM product_variant pv
                INNER JOIN product p
                    ON pv.product_id = p.product_id
                LEFT JOIN inventory i
                    ON i.variant_id = pv.variant_id
                ORDER BY p.name, pv.size, pv.colour
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$rows) {
                return [];
            }

            return $rows;

        } catch (Throwable $e) {

            // Fallback dummy data for when MySQL/XAMPP is down.
            return [
                [
                    'variant_id'          => 1,
                    'product_name'        => 'Athletiq Tee – Black',
                    'variant_size'        => 'M',
                    'variant_colour'      => 'Black',
                    'sku'                 => 'TEE-BLK-M',
                    'current_stock'       => 12,
                    'low_stock_threshold' => 5
                ],
                [
                    'variant_id'          => 2,
                    'product_name'        => 'Athletiq Hoodie – Grey',
                    'variant_size'        => 'L',
                    'variant_colour'      => 'Grey',
                    'sku'                 => 'HOOD-GRY-L',
                    'current_stock'       => 3,
                    'low_stock_threshold' => 5
                ]
            ];
        }
    }

    /**
     * Update stock for a specific variant.
     * (Real SQL will run once DB is working again.)
     */
    public function updateStock(int $variantId, int $newQuantity): bool
    {
        try {
            $sql = "
                UPDATE inventory
                SET current_stock = :qty,
                    updated_at = CURRENT_TIMESTAMP
                WHERE variant_id = :variant_id
            ";

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':qty'        => $newQuantity,
                ':variant_id' => $variantId
            ]);

        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Get the current stock for a variant (used before logging changes).
     */
    public function getCurrentStock(int $variantId): ?int
    {
        try {
            $sql = "
                SELECT current_stock
                FROM inventory
                WHERE variant_id = :variant_id
                LIMIT 1
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':variant_id' => $variantId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row === false) {
                return null;
            }

            return (int)$row['current_stock'];

        } catch (Throwable $e) {
            return null;
        }
    }
}

