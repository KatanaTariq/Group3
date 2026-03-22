<?php

/*******************************************
Developer: Mokutmfonobong Utuk
University ID: 240240082
Function: adds, removes, updates items with a checkout function
*******************************************/

class Basket
{
    private PDO $pdo;
    private int $customerID;

    /**
     * Initializes the Basket model with the active database connection and current customer id
     * @param PDO $pdo the active connection object
     * @param int $customerID the unique id of the customer
     */
    public function __construct(PDO $pdo, int $customerID)
    {
        $this->pdo = $pdo;
        $this->customerID = $customerID;
    }

    /**
     * Retrieves the existing basket ID for the customer or creates a new one
     * @return int the basket_id primary key from the basket table
     */
    protected function getOrCreateBasket(): int
    {
        $sql = "SELECT basket_id FROM basket WHERE customer_id = :customer_id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['customer_id' => $this->customerID]);
        $basketID = $stmt->fetchColumn();

        if ($basketID !== false) {
            return (int)$basketID;
        }

        $sql = "INSERT INTO basket (customer_id) VALUES (:customer_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['customer_id' => $this->customerID]);

        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Finds the matching product variant using product id and selected size
     * @param int $productID the id of the parent product
     * @param string $size the selected size from the product page
     * @return int|null the matching variant_id, or null if no match is found
     */
    public function getVariantIdByProductAndSize(int $productID, string $size): ?int
    {
        $sql = "SELECT variant_id
                FROM product_variant
                WHERE product_id = :product_id
                  AND size = :size
                LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'product_id' => $productID,
            'size' => $size
        ]);

        $variantID = $stmt->fetchColumn();

        return $variantID !== false ? (int)$variantID : null;
    }

    // --- FETCHING ITEMS FOR DISPLAY ---

    /**
     * Retrieves all items in the customer's basket with full product details
     * needed for display on the basket page
     * @return array an array of structured basket item data, or an empty array if the basket is empty
     */
    public function getContents(): array
    {
        $basketID = $this->getOrCreateBasket();

        $sql = "SELECT
                    bi.basket_item_id,
                    bi.quantity,
                    bi.variant_id,
                    p.product_id,
                    p.name AS product_name,
                    p.description,
                    p.price,
                    pv.size,
                    pv.colour,
                    pi.image_url,
                    i.current_stock
                FROM basket_item bi
                JOIN product_variant pv ON bi.variant_id = pv.variant_id
                JOIN product p ON pv.product_id = p.product_id
                LEFT JOIN product_image pi 
                    ON p.product_id = pi.product_id 
                   AND pi.is_main = 1
                LEFT JOIN inventory i
                    ON bi.variant_id = i.variant_id
                WHERE bi.basket_id = :basket_id
                ORDER BY bi.basket_item_id ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['basket_id' => $basketID]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($row) {
            $image = $row['image_url'] ?: '/public/images/productImages/placeholder.png';

            if (strpos($image, '/src/view/images/') === 0) {
                $image = str_replace('/src/view/images/', '/public/images/', $image);
            }

            return [
                'item_id' => (int)$row['basket_item_id'],
                'variant_id' => (int)$row['variant_id'],
                'product_id' => (int)$row['product_id'],
                'name' => $row['product_name'],
                'description' => $row['description'],
                'price' => (float)$row['price'],
                'quantity' => (int)$row['quantity'],
                'size' => $row['size'],
                'colour' => $row['colour'],
                'image_url' => $image,
                'current_stock' => (int)($row['current_stock'] ?? 0),
            ];
        }, $rows);
    }

    /**
     * Calculates the total monetary value of all items currently in the basket
     * @return float the basket subtotal rounded to 2 decimal places
     */
    public function calculateSubtotal(): float
    {
        $basketID = $this->getOrCreateBasket();

        $sql = "SELECT SUM(bi.quantity * p.price) AS subtotal
                FROM basket_item bi
                JOIN product_variant pv ON bi.variant_id = pv.variant_id
                JOIN product p ON pv.product_id = p.product_id
                WHERE bi.basket_id = :basket_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['basket_id' => $basketID]);

        $subtotal = $stmt->fetchColumn();

        return round((float)($subtotal ?? 0), 2);
    }

    // --- CORE BASKET FUNCTIONALITY (CRUD) ---

    /**
     * Adds a product variant to the user's basket or updates the quantity if it already exists
     * @param int $variantID the id of the specific product variant
     * @param int $quantity the amount to add, defaults to 1
     * @return bool true on success
     */
    public function addItem(int $variantID, int $quantity = 1): bool
    {
        if ($quantity < 1) {
            throw new InvalidArgumentException('Quantity must be at least 1.');
        }

        $basketID = $this->getOrCreateBasket();

        $sql = "SELECT 
                    i.current_stock,
                    bi.quantity AS basket_quantity
                FROM inventory i
                LEFT JOIN basket_item bi
                    ON bi.variant_id = i.variant_id
                   AND bi.basket_id = :basket_id
                WHERE i.variant_id = :variant_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'basket_id' => $basketID,
            'variant_id' => $variantID
        ]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            throw new Exception('Variant not found in inventory.');
        }

        $currentStock = (int)$data['current_stock'];
        $currentBasketQty = (int)($data['basket_quantity'] ?? 0);
        $newQuantity = $currentBasketQty + $quantity;

        if ($newQuantity > $currentStock) {
            throw new Exception("Only {$currentStock} in stock.");
        }

        if ($currentBasketQty > 0) {
            $sql = "UPDATE basket_item
                    SET quantity = :quantity
                    WHERE basket_id = :basket_id
                      AND variant_id = :variant_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'quantity' => $newQuantity,
                'basket_id' => $basketID,
                'variant_id' => $variantID
            ]);
        } else {
            $sql = "INSERT INTO basket_item (basket_id, variant_id, quantity)
                    VALUES (:basket_id, :variant_id, :quantity)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'basket_id' => $basketID,
                'variant_id' => $variantID,
                'quantity' => $quantity
            ]);
        }

        return true;
    }

    /**
     * Updates the quantity of a specific basket item
     * checks stock before applying the update
     * @param int $basketItemID the primary key of the row in the basket_item table
     * @param int $newQuantity the new requested quantity
     * @return bool true on success
     */
    public function updateItemQuantity(int $basketItemID, int $newQuantity): bool
    {
        if ($newQuantity < 1) {
            throw new InvalidArgumentException('Quantity must be at least 1.');
        }

        $basketID = $this->getOrCreateBasket();

        $sql = "SELECT i.current_stock
                FROM basket_item bi
                JOIN inventory i ON bi.variant_id = i.variant_id
                WHERE bi.basket_item_id = :basket_item_id
                  AND bi.basket_id = :basket_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'basket_item_id' => $basketItemID,
            'basket_id' => $basketID
        ]);
        $stock = $stmt->fetchColumn();

        if ($stock === false) {
            throw new Exception('Basket item not found.');
        }

        if ($newQuantity > (int)$stock) {
            throw new Exception("Only {$stock} in stock.");
        }

        $sql = "UPDATE basket_item
                SET quantity = :quantity
                WHERE basket_item_id = :basket_item_id
                  AND basket_id = :basket_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'quantity' => $newQuantity,
            'basket_item_id' => $basketItemID,
            'basket_id' => $basketID
        ]);

        return true;
    }

    /**
     * Removes a specific item from the basket
     * @param int $basketItemID the id of the item in the basket_item table
     * @return bool true on successful removal, false otherwise
     */
    public function removeItem(int $basketItemID): bool
    {
        $basketID = $this->getOrCreateBasket();

        $sql = "DELETE FROM basket_item
                WHERE basket_item_id = :basket_item_id
                  AND basket_id = :basket_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'basket_item_id' => $basketItemID,
            'basket_id' => $basketID
        ]);

        return $stmt->rowCount() > 0;
    }
}   