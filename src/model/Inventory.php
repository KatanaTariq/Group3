<?php

class Inventory
{
    private $pdo;

    public function __construct($pdo)
    {
        // Save PDO connection for later (once DB works)
        $this->pdo = $pdo;
    }

    /**
     * TEMP: Returns hard-coded inventory data.
     * Tomorrow we will replace this with a real SELECT query.
     */
    public function getAllInventory()
    {
        // TODO: replace with real database query
        return [
            [
                'variant_id'   => 1,
                'product_name' => 'Athletiq Tee – Black / M',
                'sku'          => 'TEE-BLK-M',
                'current_stock'=> 12,
                'low_stock_threshold' => 5
            ],
            [
                'variant_id'   => 2,
                'product_name' => 'Athletiq Hoodie – Grey / L',
                'sku'          => 'HOOD-GRY-L',
                'current_stock'=> 3,
                'low_stock_threshold' => 5
            ]
        ];
    }

    /**
     * TEMP: simulate updating stock for one variant.
     * Real implementation will run an UPDATE query.
     */
    public function updateStock($variantId, $newQuantity)
    {
        // TODO: implement real UPDATE query when DB is ready
        // For now we just return true to pretend it worked.
        return true;
    }
}
