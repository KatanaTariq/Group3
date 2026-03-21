<?php

/**
 * Product entity (for product listing + primary image).
 */
class Product
{
    private int $product_id;
    private string $name;
    private ?string $description;
    private int $category_id;
    private float $price;
    private ?string $primary_image_url;

    public function __construct(array $data)
    {
        $this->product_id        = (int) $data['product_id'];
        $this->name              = (string) $data['name'];
        $this->description       = $data['description'] ?? null;
        $this->category_id       = (int) $data['category_id'];
        $this->price             = (float) $data['price'];
        $this->primary_image_url = $data['primary_image_url'] ?? null;
    }

    public function getID(): int { return $this->product_id; }
    public function getName(): string { return $this->name; }
    public function getDescription(): ?string { return $this->description; }
    public function getCategoryID(): int { return $this->category_id; }
    public function getPrice(): float { return $this->price; }
    public function getPrimaryImageUrl(): ?string { return $this->primary_image_url; }
}

/**
 * Variant entity (for the single product page).
 */
class ProductVariant
{
    private int $variant_id;
    private int $product_id;
    private ?string $size;
    private ?string $colour;
    private string $sku;

    private int $current_stock;
    private int $low_stock_threshold;

    public function __construct(array $data)
    {
        $this->variant_id          = (int) $data['variant_id'];
        $this->product_id          = (int) $data['product_id'];
        $this->size                = $data['size'] ?? null;
        $this->colour              = $data['colour'] ?? null;
        $this->sku                 = (string) $data['sku'];
        $this->current_stock       = isset($data['current_stock']) ? (int) $data['current_stock'] : 0;
        $this->low_stock_threshold = isset($data['low_stock_threshold']) ? (int) $data['low_stock_threshold'] : 10;
    }

    public function getID(): int { return $this->variant_id; }
    public function getProductID(): int { return $this->product_id; }
    public function getSize(): ?string { return $this->size; }
    public function getColour(): ?string { return $this->colour; }
    public function getSku(): string { return $this->sku; }
    public function getCurrentStock(): int { return $this->current_stock; }

    public function isInStock(): bool
    {
        return $this->current_stock > 0;
    }
}

/**
 * ProductModel
 *
 * supports:
 * 1) listing page:
 *    - women (all subcategories)
 *    - women > bottoms (single subcategory)
 *    - men (all subcategories)
 *    - men > footwear (single subcategory)
 *
 * 2) single product page:
 *    - product base details
 *    - all variants (clickable)
 */
class ProductModel
{
    private PDO $database;

    public function __construct(PDO $database)
    {
        $this->database = $database;
    }

    /**
     * list products for:
     * - a root section (Women=1, Men=2) -> returns ALL products under that root (all subcategories)
     * - OR a specific subcategory id -> returns ONLY products in that subcategory
     *
     * pass ONE of:
     * - $root_category_id (1 or 2)
     * - $subcategory_id (3-12)
     */
    public function getProductsForListing(?int $root_category_id = null, ?int $subcategory_id = null): array
    {
        // safety: must provide exactly one
        if (($root_category_id === null && $subcategory_id === null) ||
            ($root_category_id !== null && $subcategory_id !== null)) {
            return [];
        }

        $where = "";
        if ($root_category_id !== null) {
            // women/men: include all child categories under the root
            // with your seed data, products live in the subcategories, not in the root
            $where = "c.parent_category_id = :root_category_id";
        } else {
            // women > bottoms etc: exact category match
            $where = "p.category_id = :subcategory_id";
        }

        $query = "
            SELECT
                p.product_id,
                p.name,
                p.description,
                p.category_id,
                p.price,
                (
                    SELECT pi.image_url
                    FROM product_image pi
                    WHERE pi.product_id = p.product_id AND pi.is_main = 1
                    ORDER BY pi.image_id ASC
                    LIMIT 1
                ) AS primary_image_url
            FROM product p
            INNER JOIN category c ON c.category_id = p.category_id
            WHERE $where
            ORDER BY p.product_id ASC
        ";

        $statement = $this->database->prepare($query);

        if ($root_category_id !== null) {
            $statement->bindParam(':root_category_id', $root_category_id, PDO::PARAM_INT);
        } else {
            $statement->bindParam(':subcategory_id', $subcategory_id, PDO::PARAM_INT);
        }

        $products = [];

        if ($statement->execute()) {
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $products[] = new Product($row);
            }
        }

        return $products;
    }

    /**
     * single product base details + primary image
     */
    public function getProductByID(int $product_id): ?Product
    {
        $query = "
            SELECT
                p.product_id,
                p.name,
                p.description,
                p.category_id,
                p.price,
                (
                    SELECT pi.image_url
                    FROM product_image pi
                    WHERE pi.product_id = p.product_id AND pi.is_main = 1
                    ORDER BY pi.image_id ASC
                    LIMIT 1
                ) AS primary_image_url
            FROM product p
            WHERE p.product_id = :product_id
            LIMIT 1
        ";

        $statement = $this->database->prepare($query);
        $statement->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        if ($statement->execute()) {
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return $row ? new Product($row) : null;
        }

        return null;
    }

    /**
     * get variants for the single product page (includes stock from inventory)
     */
    public function getVariantsByProductID(int $product_id): array
    {
        $query = "
            SELECT
                pv.variant_id,
                pv.product_id,
                pv.size,
                pv.colour,
                pv.sku,
                COALESCE(i.current_stock, 0) AS current_stock,
                COALESCE(i.low_stock_threshold, 10) AS low_stock_threshold
            FROM product_variant pv
            LEFT JOIN inventory i ON i.variant_id = pv.variant_id
            WHERE pv.product_id = :product_id
            ORDER BY
                pv.colour ASC,
                CASE
                    WHEN pv.size = 'XS' THEN 1
                    WHEN pv.size = 'S'  THEN 2
                    WHEN pv.size = 'M'  THEN 3
                    WHEN pv.size = 'L'  THEN 4
                    WHEN pv.size = 'XL' THEN 5
                    ELSE 100
                END,
                pv.variant_id ASC
        ";

        $statement = $this->database->prepare($query);
        $statement->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        $variants = [];

        if ($statement->execute()) {
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $variants[] = new ProductVariant($row);
            }
        }

        return $variants;
    }

    /**
     * convenience for single product page
     */
    public function getProductFull(int $product_id): ?array
    {
        $product = $this->getProductByID($product_id);
        if (!$product) {
            return null;
        }

        return [
            'product'  => $product,
            'variants' => $this->getVariantsByProductID($product_id),
        ];
    }
}

?>