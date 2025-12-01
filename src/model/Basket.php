<?php

/*******************************************
Developer: Mokutmfonobong Utuk
University ID: 240240082
Function: adds, removes, updates items with a checkout function
*******************************************/

namespace AthLETIQ\Model;

class Basket {
    private \PDO $pdo;
    private int $customerID;

    /**
     * Initializes the Basket model with the active database connection and current customer id
     * @param \PDO $pdo the active connection object
     * @param int $customerID the unique id of the customer
     */
    public function __construct(\PDO $pdo, int $customerID){
        $this->pdo = $pdo;
        $this->customerID = $customerID;
    }

    /**
     * Retrieves the existing basket ID for the customer or creates a new one.
     * @return int The basket_id(primary key from the 'Basket' table)
     */
    protected function getOrCreateBasket(): int{
        //1. search for an existing basket linked to the customer_id
        $sql = "SELECT basket_id FROM basket WHERE customer_id = :customer_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['customer_id' => $this->customerID]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result) {
            return (int) $result['basket_id'];
        }

        // 2. If no basket is found, create a new record in the 'Basket' table
        $insertSql = "INSERT INTO basket (customer_id) VALUES (:customer_id)";
        $stmt = $this->pdo->prepare($insertSql);
        $stmt->execute(['customer_id' => $this->customerID]);

        return (int) $this->pdo->lastInsertID();
        
    }


    // --- FETCHING ITEMS FOR DISPLAY ---

    /**
     * Retrieves all items in the customer's basket with full product details
     * needed for display on the cart page (name, price, quantity, stock)
     * @return array an array of structured item data, or an empty if the basket is empty
     */
    public function getContents(): array{
        $basketID = $this->getOrCreateBasket();
        $sql = "SELECT bi.basket_item_id, bi.quantity, bi.variant_id, p.name AS product_name, p.base_price AS price, pv.variant_name, i.current_stock
                FROM basket_item bi
                JOIN product_variant pv ON bi.variant_id = pv.variant_id
                JOIN product p ON pv.product_id = p.product_id
                LEFT JOIN inventory i ON bi.variant_id = i.variant_id
                WHERE bi.basket_id = :basket_id
                ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['basket_id' => $basketID]);
        $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        //map data to structure it for the view controller
        return array_map(function($item) {
            // combine product name and variant name for a clean display name
            $fullName = $item['product_name'] . ' - ' . $item['variant_name'];
            return ['item_id' => (int)$item['basket_item_id'],
                    'name' => htmlspecialchars($fullName),
                    'price' => (float)$item['price'],
                    'quantity' => (int)$item['quantity'],
                    'variant_id' => (int)$item['variant_id'],
                    'current_stock' => (int)($item['current_stock'] ?? 0)
                ];
        }, $items); 
    }

    /**
     * calculates the total monetary value of all items currently in the basket
     * @return float the total subtotal amount, rounded to 2 decimal places
     */
    public function calculateSubtotal(): float{
        $basketID = $this->getOrCreateBasket();

        $sql = "SELECT SUM(bi.quantity * p.base_price) AS subtotal
                FROM basket_item bi
                JOIN product_variant pv ON bi.variant_id = pv.variant_id
                JOIN product p ON pv.product_id = p.product_id
                WHERE bi.basket_id = :basket_id
                ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['basket_id' => $basketID]);
        $result = $stmt->fetchAll(\PDO::FETCH_COLUMN);

        return round((float)$result, 2);
    }

    // --- Core Basket Functionality (CRUD) ---

    /**
     * Adds a product variant to the user's baskeet or updates the quantity if it already exists
     * @param int $variantID the id of the specific product variant (e.g size M, color red)
     * @param int $quantity the amount to add(defaults to 1)
     * @return bool|string true on success, error message string on failure
     */
    public function addItem(int $variantID, int $quantity = 1): string|bool {
        if($quantity < 1) {
            throw new \InvalidArgumentException("Quantity must be at least 1.");
        }

        $basketID = $this->getOrCreateBasket();
        // 1. get current stock and current quantity in basket
        $stockCheckSql = "SELECT i.current_stock, bi.quantity
                            FROM inventory i
                            LEFT JOIN basket_item bi ON bi.variant_id = i.variant_id AND bi.basket_id = :basket_id
                            WHERE i.variant_id = :variant_id
                        ";
        $stmt = $this->pdo->prepare($stockCheckSql);
        $stmt->execute(['basket_id' => $basketID, 'variant_id' => $variantID]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            throw new \Exception("Product variant ID {$variantID} not found in the inventory.");

        }

        $currentStock = (int)$data['current_stock'];
        $currentBasketQty = (int)($data['basket_quantity'] ?? 0);
        $newTotalQuantity = $currentBasketQty + $quantity;

        // 2 check if the new total quantity exceeds available stock
        if ($newTotalQuantity > $currentStock) {
            throw new \Exception("Insufficient stock. Available: {$currentStock}. Current in basket: {$currentBasketQty}.");

        }
        // 3. update or insert the item
        
            if ($currentBasketQty > 0){
                //item exists: UPDATE quantity
                $updateSql = "UPDATE basket_item SET quantity = :new_quantity WHERE basket_id = :basket_id AND variant_id = :variant_id
                ";
                $stmt = $this->pdo->prepare($updateSql);
                $stmt->execute(['new_quantity' => $newTotalQuantity,
                                'basket_id' => $basketID,
                                'variant_id' => $variantID
                ]);

            } else {
                //item does not exist: insert new record
                $insertSql = "INSERT INTO basket_item (basket_id, variant_id, quantity)
                                VALUES (:basket_id, :variant_id, :quantity)
                ";
                $stmt = $this->pdo->prepare($insertSql);
                $stmt->execute(['basket_id' => $basketID,
                                'variant_id' => $variantID,
                                'quantity' => $quantity
                ]);
            }
            return true;
    }

    /**
     * updates the quantity of a specific basket item
     * must check inventory against $newQuantity
     * @param int $basketItemID the primary key of the row in the basket_items table
     * @return bool|string true on success, error message string on failure or stock error
     */
    public function updateItemQuantity(int $basketItemID, int $newQuantity): string|bool{

        if ($newQuantity < 1) {
            throw new \InvalidArgumentException("New quantity must be at least 1 for update.");
        }
        $basketID = $this->getOrCreateBasket();

        // 1. check current stock for the variant linked to the basket item
        // this query joins basket_item, product_variant (to get the variant_id), and inventory
        $stockCheckSql = "SELECT i.current_stock, bi.variant_id
                          FROM inventory i JOIN basket_item bi ON bi.variant_id = i.variant_id
                          WHERE bi.basket_item_id = :basket_item_id AND bi.basket_id = :basket_id
                          ";
        $stmt = $this->pdo->prepare($stockCheckSql);
        $stmt->execute([
            'basket_item_id' => $basketItemID,
            'basket_id' => $basketID
        ]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!data) {
            throw new \Exception("Basket item not found or does not belong to your basket.");
        }

        $currentStock = (int)$data['current_stock'];

        //2. check if the new quantity exceeds available stock
        if ($newQuantity > $currentStock) {
            throw new \Exception("Stock limit reached. Only {$currentStock} units of this item are currently available.");
        }

        //3. execute the update
        
        $updateSql = "UPDATE basket_item SET quantity = :new_qunatity, updated_at =NOW()
                      WHERE basket_item_id = :basket_item_id AND basket_id = :basket_id
                      ";
        $stmt = $this->pdo->prepare($updateSql);
        $stmt->execute(['new_quantity' => $newQuantity,
                        'basket_item_id' => $basketItemID,
                        'basket_id' => $basketID
        ]);
        return $stmt->rowCount() > 0;
        
    } 

    /**
     * Removed a specific item from the basket
     * @param int $basketItemID the id of the item in the basket_item table
     * @return bool true on successful removal, false otherwise
     */
    public function removeItem(int $basketItemID): bool{
        //security check: ensure the basket item belongs to the customers active basket
        $basketID = $this->getOrCreateBasket();

        $deleteSql = "DELETE FROM basket_item
                      WHERE basket_item_id = :basket_item_id
                      AND basket_id = :basket_id
                      ";
        
        $stmt = $this->pdo->prepare($deleteSql);
        $stmt->execute(['basket_item_id' => $basketItemID,
                            'basket_id' => $basketID
                        ]);
        // check if any rows were affected(meaning the item was deleted)
        return $stmt->rowCount() > 0;
    }

    /**
     * Fetches all items in the current basket, including the current price from productvariant
     * Used exclusively within the finalizeCheckout process
     * @param int $basketID the ID of the customer's active basket
     * @return array|null An array of basket item data, or null if the basket is empty
     */
   protected function getBasketItemsForCheckout(int $basketID): ?array {
        $sql = "SELECT bi.variant_id, bi.quantity, pv.price
                FROM basket_item bi
                JOIN product pv ON pv.product_id = (SELECT product_id FROM product_variant WHERE variant_id = bi.variant_id LIMIT 1)
                WHERE bi.basket_id = :basket_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['basket_id' => $basketID]);
        $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $items ?: null;
    }

    /**
     * Generates a unique, short order number for the Order table
     * @return string A unique number string
    */
    protected function generateOrderNumber(): string{
        //simple 8-character unique string based on time and a random value
            return strtoupper(substr(uniqid(), -4) . bin2hex(random_bytes(2)));
    }

    /**
     * Execute the entire checkout process atomically within a database transaction.
     * creates the order record
     * transfers items to OrderLine
     * decrements inventory stock
     * clears the basket
     * @param int $shippingAddressID the id of the chosen shipping address
     * @param int $billingAddressID the id of the chosen billing address
     * @return bool|string true on succes, error message string on failure 
     */
    public function finalizeCheckout(int $shippingAddressID, int $billingAddressID): string|bool {
        $basketID = $this->getOrCreateBasket();

        //Start transaction
        $this->pdo->beginTransaction();

        try {
            $basketItem = $this->getBasketItemsForCheckout($basketID);

            if (empty($basketItem)) {
                $this->pdo->rollBack();
                throw new \Exception("Basket is empty.");

            }
            $totalAmount = 0.0;

            // calculate total amount and re-check stock
            foreach ($basketItem as $item) {
                $unitPrice = (float)$item['price'];
                $quantity = (int)$item['quantity'];
                $variantID = (int)$item['variant_id'];
                
                //get current stock
                $stockSql = "SELECT current_stock FROM inventory WHERE variant_id = :variant_id";
                $stmt = $this->pdo->prepare($stockSql);
                $stmt->execute(['variant_id' => $variantID]);
                $stockResult = $stmt->fetchColumn();

                if ($stockResult === false || $quantity >(int)$stockResult){
                    $this->pdo->rollBack();
                    throw new \Exception("Stock check failed for variant ID " . $variantID . ". Only " . (int)$stockResult . " remaining.");
                }
                $totalAmount += ($unitPrice * $quantity);       
            }
            //create the main order record
            $orderNumber = $this->generateOrderNumber();
            $orderSql = "INSERT INTO `Order` (customer_id, order_number, total_amount, shipping_address_id, billing_address_id, status)
                         VALUES (:customer_id, :order_number, :total_amount, :shipping_address_id, :billing_address_id, 'Processing')
                         ";
            $stmt = $this->pdo->prepare($orderSql);
            $stmt->execute(['customer_id' => $this->customerID,
                             'order_number' => $orderNumber,
                             'total_amount' => $totalAmount,
                             'shipping_address_id' => $shippingAddressID,
                             'billing_address_id' => $billingAddressID
            ]);
            $orderID = $this->pdo->lastInsertID();

            //transfer to OrderLine and Decrement Inventory
            $orderLineSql = "INSERT INTO OrderLine (order_id, variant_id, quantity, unit_price, subtotal)
                             VALUES (:order_id, :variant_id, :quantity, :unit_price, :subtotal)
                             ";
            $updateStockSql = "UPDATE inventory
                               SET current_stock = current_stock - :quantity
                               WHERE variant_id = :variant_id
                               ";
            foreach ($basketItem as $item) {
                $unitPrice = (float)$item['price'];
                $quantity = (int)$item['quantity'];
                $variantID = (int)$item['variant_id'];
                $subtotal = $unitPrice * $quantity;

                // insert into OrderLine
                $stmt = $this->pdo->prepare($orderLineSql);
                $stmt->execute(['order_id' => $orderID,
                                 'variant_id' => $variantID,
                                 'quantity' => $quantity,
                                 'unit_price' => $unitPrice,
                                 'subtotal' => $subtotal
                ]);

                //decrement inventory stock
                $stmt = $this->pdo->prepare($updateStockSql);
                $stmt->execute(['quantity' => $quantity,
                                 'variant_id' => $variantID
                ]);
            }

            //clear the basket
            $deleteBasketSql = "DELETE FROM basket_item WHERE basket_id = :basket_id";
            $stmt = $this->pdo->prepare($deleteBasketSql);
            $stmt->execute(['basket_id' => $basketID]);

            //commit transaction
            $this->pdo->commit();
            return true;
        } catch (\PDOException $e) {
            //Rollback on any failure
            $this->pdo->rollBack();
            error_log("Checkout transaction failed: " . $e->getMessage());
            return "An unexpected error occured during checkout. Please contact support.";
        }
    }

}