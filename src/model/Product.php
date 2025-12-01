<?php

require_once __DIR__ . '/../../config/database.php';

class Product
{
    /** @var PDO */
    private $pdo;

    public function __construct()
    {
        // Use the shared PDO connection created in config/database.php
        global $pdo;
        $this->pdo = $pdo;
    }

    /**
     * Get all products for the catalogue (home / products list).
     * Later we will join Product, ProductImage (main image) and ProductVariant (for min price).
     */
    public function getAllProducts(): array
    {
        // TODO: implement in Day 2
        return [];
    }

    /**
     * Get a single product by its ID, including basic info.
     */
    public function getProductById(int $productId): ?array
    {
        // TODO: implement in Day 2
        return null;
    }

    /**
     * Get all variants (size/colour/sku/price/stock) for a given product.
     */
    public function getVariantsForProduct(int $productId): array
    {
        // TODO: implement in Day 2
        return [];
    }

    /**
     * Get the main image for a product (where ProductImage.is_main = 1).
     */
    public function getMainImageForProduct(int $productId): ?array
    {
        // TODO: implement in Day 2
        return null;
    }

    /**
     * (For your admin role later) Get products that are low on stock.
     * This will use the Inventory + InventoryLog tables.
     */
    public function getLowStockProducts(): array
    {
        // TODO: implement in a later sprint
        return [];
    }
}
