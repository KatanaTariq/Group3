<?php
namespace AthLETIQ\Model;


class Cart {
    private \PDO $pdo;/** the active database connection object */
    private string $customerID;/** the unique ID of the customer that has been currently authenticated */

    /**
     * Initializes the model with the active database connection and current customer ID.
     */
    public function __construct(\PDO $pdo, string $customerID){
        $this->pdo = $pdo;
        $this->customerID = $customerID;
    }

    /**Retreives (or creates) the exsisting basket ID for the customer  
     * @return int The basket_id(primary key from the 'Basket' table).
    */
    protected function getOrCreateBasket(): int{

        // i. search for an exsisting basket linked to the customer_id
        $sql = "SELECT basket_id FROM Basket WHERE customer_id = :customer_id";
        $stmt = $this->pdo->prepare($sql);
        // using $this->customerID
        $stmt->execute(['customer_id' => $this->customerID]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result) {
            return (int) $result['basket_id'];
        }
        // ii. if no basket is found, then a new record is created in the 'Basket table'
        $insertSql = "INSERT INTO Basket (customer_id) VALUES (:customer_id)";
        $stmt = $this->pdo->prepare($insertSql);
        $stmt->execute(['customer_id' => $this->customerID]);

        $basketID = $this->pdo->lastInsertId();
        return(int) $basketID;
    }

    /**Fetches all items in the current basket and the current price from Product Variant */
    protected fuction getBasketItemsForCheckout(int $basketID):{
        $sql = "SELECT bi.variant_id, bi.quantity, pv.price FROM BasketItems bi JOIN Prodoct pv ON pv.prodoct_id = (SELECT product_id FROM ProductVariant WHERE variant_id = bi.variant_id LIMIT 1)
                WHERE bi.basket_id = :basket_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['basket_id' => $basketID]);
        $items = $stmt->fetchALL(\PDO::FETCH_ASSOC);

        return $items ?: null;
    }

    /** Generates a unique, short order number for the Order table. */
    protected function generatedOrderNumber(): string{
        // generats a simple 8 character string based order number based on time and a random value
        return strtoupper(substr(uniqid(), -4) . bin2hex(random_bytes(2)));
    }

    /**fetches all items in the customers nasket with product details to display on the cart page (name, price, quantity, stock). */
    public funtion getContents(): array{
        $basketID = $this->getOrCreateBasket();
        $sql = "SELECT bi.basket_item_id, bi.quantity, bi.variant_id,p.name AS product_name,p.base_price AS price, pv.variant_name, i.current_stock
                FROM BasketItems bi JOIN ProductVariant pv ON bi.variant_id = pv.variant_id
                JOIN Product p ON pv.product_id = p.product_id LEFT JOIN Inventory i ON bi.variant_id = i.variant_id WHERE bi.basket_id = :basket_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['basket_id' => $basketID]);
        $items = $stmt->fetchAll(\PDO::FETCH-ASSOC);

        // MAP DATA TO STRUCTURE IT FOR THE VIEW CONTROLLER
        return array_map(function($item) {
            //combine product name and variant name for a neat display name
            $fullName = $item['product_name'] . ' - ' . $item['variant_name'];
            return ['item_id' => (int)$item['basket_item_id'],
                    'name' => htmlspecialchars($fullName),
                    'price' => (float)$item['price'],
                    'quantity' => (int)$item['quantity'],
                    'variant_id' => (int)$item['variant_id'],
                    'current_stock' => (int)($item['current_stock'] ?? 0)];
        }, $items);
    }

    /** Calculates the total monetary value of all items in the customers basket */
    public function calculateSubtotal(): float{
        $basketID = $this->getOrCreateBasket();
        $sql = "SELECT SUM(bi.quantity * p.base_price) AS subtotal FROM BasketItems bi JOIN ProductVariant pv ON bi.variant_id = pv.variant_id
                JOIN Product p ON pv.ptoduvt_id = p.product_id WHERE bi.basket_id = :basket_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['basket_id' => $basketID]);
        $result = $stmt->fetch(\PDO::FETCH_COLUMN);
        return round((float)$result, 2);
    }     
    

    /** Executes the entire checkout process atomically within a database transaction
     * i.calculate total ammount and recheck stock (security check)
     * ii. creates the order record
     * iii. transfers items to OrderLine
     * iv. decrements inventory stock
     * v. clear the basket
     */

    public function finalizeCheckout(int $shippingAddressID, int $billingAddressID): string|bool{
            $basketID = $this->getOrCreateBasket();

            // start transaction
            $this->pdo->beginTransaction();

            try{
                $basketItems = $this->getBasketItemsForCheckout($basketID);

                if (empty($basketItems)) {
                    $this->pdo->rollBack();
                    return "Your basket it empty. Cannot finalize checkout.";
                }

                $totalAmount = 0.0;

                // i.
                foreach ($basketItems as $item) {
                    $unitPrice = (float)$item['price'];
                    $quantity = (int)$item['quantity'];
                    $variantID = (int)$it6em['variant_id'];

                    // get curent stock (final check before commiting the order)
                    $stockSql = "SELECT current_stock FROM Inventory WHERE variant_id = :variant_id";
                    $stmt = this->pdo->prepare($stockSql);
                    $stmt->execute(['variant_id' => $variantID]);
                    $stockResult = $stmt->fetchColumn();

                    if($stockResult === false || $quantity > (int)$stockResult) {
                        $this->pdo->rollBack();
                        return "Stock check failed for variant ID " . $variantID . ". Only " . (int)$stockResult . " remaining.";
                     } 
                     $totalAmount += ($unitPrice * $quantity);
                }

                // ii.
                $ordrNumber = $this->generateOrderNumber();
                $orderSql = "INSERT INTO `Order`(customer_id, order_number, total_amount, shipping_address_id, status)
                            VALUES (:customer_id, :order_number, :total_amount, :shipping_address_id,  :billing_address_id, 'Processing')";
                $stmt = $this->pdo->prepare($orderSql);
                $stmt->execute(['customer_id' => $this->customerID, 
                                'order_number' => $orderNumber, 
                                'total_amount' => $totalAmount, 
                                'shipping_address_id' => $shippingAddressID, 
                                'billing_address_id' => $billingAddressID ]);
                $orderID = $this->pdo->lastInsertID();

                // iii & iv.

                $orderLineSql = "INSERT INTO OrderLine (order_id, variant_id, quantity, unit_price, subtotal) VALUES (:order_id, :variant_id, :quantity, :unit_price, :subtotal)";
                $updateStockSql = "UPDATE Inventory SET current_stock = current_stock - :quantity WHERE variant_id = :variant_id";

                foreach ($basketItems as $item) {
                    $unitPrice = (float)$item['price'];
                    $quantity = (int)$item['quantity'];
                    $variantID = (int)$item['variant_id'];
                    $subtotal = $unitPrice * $quantity;

                    //insert into OrderLine
                    $stmt = $this->pdo->prepare($orderLineSql);
                    $stmt->execute([
                        'order_id' => $orderID,
                        'variant_id' => $variantID,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'subtotal' => $subtotal
                    ]);
                }
                
                // clear the basket
                $deleteBasketSql = "DELETE FROM BasketItems WHERE basket_id = :basket_id";
                $stmt = $this->pdo->prepare($deleteBasketSql);
                $stmt->execute(['basket_id => $basketID']);

                // commit transaction
                $this->pdo->commit();
                return true; // checkout succesful

            } catch (/PDOException $e) {
                 $this->pdo->rollBack();
                 error_log("Checkout transaction failed: " . $e->getMessage());
                 return "An unexpected error occurred during checkout. Please contact support";
            }


    }




    /**Adds a product variant to the customers basket or updates the quantity if a product is already in the basket */
    public function addItem(int $variantID, int $quantity = 1): string|bool{
        if ($quantity < 1) {
            return "Quantity must be at least 1.";
        }

        $basketID = $this->getOrCreateBasket();

        // i.get current stock and current quantity in basket
        $stockCheckSql = "SELECT i.current_stock, bi.quantity AS basket_quantity FROM Inventory i LEFT JOIN BasketItems bi ON bi.variant_id = i.variant_id = ;basket_id WHERE i.variant_id = :variant_id";
        $stmt = $this->pdo->prepare($stockCheckSql);
        $stmt->execute(['basket_id' => $basketID, 'variant_id' => $variantID]);
        $data = $stmt-fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return "Error: Product variant is unavailable.";
        }

        $currentStock = (int)$data['current)stock'];
        $currentBasketQty = (int)($data['basket_quantity']?? 0);
        $newTotalQuantity = $currentBasketQty + $quantity;
        // ii. check if the new total quantity is more than available stock
        if ($newTotalQuantity > $currentStock) {
            return "There are only " . $currentStock . " units of this item available and you have " . $currentBasketQty . " in your basket.";
        }

        // iii. Update or Insert the item
        try {
            if ($currentBasketQty > 0) {
                // Item exist: UPDATE quantity
                $updateSql = "UPDATE BasketItems SET quantity = :new_quantity WHERE basket_id = :basket_id AND variant_id = :variant_id";
                $stmt = $this->pdo->prepare($updateSql);
                $stmt->execute([
                    'new_quantity' => $newTotalQuantity,
                    'basket_id' => $basketID,
                    'variant_id' => $variantID
                ]);
            } else {
                // in the case that the item does not exist: INSERT new record
                $insertSql = "INSERT INTO BasketItems (basket_id, variant_id, quantity) VALUES (:basket_id, :variant_id, :quantity)";
                $stmt = $this->pdo->prepare($insertSql);
                $stmt->execute([
                    'basket_id' => $basketID,
                    'variant_id' => $variantID,
                    'quantity' => $quantity
                ]);
            }
            return true; // Success

        } catch(\PDOException $e) {
            error_log("Database error during addItem: " . $e->getMessage());
            return "A database error occured while item was being added. Please try again.";
        }
    }

    /**Updates the quatity of a specific basket item */
    public function updateItemQuantity(int $itemID, int $newQuantity): string|bool {
        if ($newQuantity < 1) {
            // Deleting an item is done by removeItem(), so it will return an error
            return "Quantity must be one or more. Use the remove button to delete the item.";
        }
        $basketID = $this->getOrCreateBasket();
        // i. check current stock for the variant linked to the basket item
        // this query joins BasketItems, ProductVariant(to get the variant_id), and iventory
        $stockCheckSql = "SELECT i.current_stock, bi.variant_id FROM Inventory i JOIN BasketItems bi ON bi.variant_id = i.variant_id WHERE bi.basket_item_id = :basket_item_id AND bi.basket_id = :basket_id WHERE bi.basket_item_id = :basket_item_id AND bi.basket_id = :basket_id";
        $stmt = $this->pdo->prepare($stockCheckSql);
        $stmt->execute(['basket_item_id' => $basketItemID, 'basket_id' => $basketID]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if(!$data) {
            return "Error: Basket item not found"
        }

        $currentStock = (int)$data['current_stock'];

        // ii. check if the new quantity is more than the available stock
        if  ($newQuantity > $currentStock) {
            return "Stock limit reached. Only " . $currentStock . " units of this item are currently available.";     
        }

        // iii. execute the update
        try {
            $updateSql = "UPDATE BasketItems SET quantity = :new_quantity, updated_at = NOW() WHERE basket_item_id = :basket_item_id AND basket_id = :basket_id";
            $stmt = $this->pdo->prepare($updateSql);
            $stmt->execute(['new_quantity' => $newQuantity, 'basket_item_id' => $basketItemID, 'basket_id' => $basketID]);
            return true; // success
        } catch (/PDOException $e) {
            error_log("Database error during updateItemQuantity: " . $e->getMessage());
            return "A database error occured while updating the quantity. Please try again.";
        }
    }
    
    /** Removes a specific item from the basket*/
    public function removeItem(int $basketItemID): bool{
        //Ensure the basket item belongs to the customer's active basket(this is a security check)
        $basketID = $this->getOrCreateBasket();
        $deleteSql = "DELETE FROM BasketItems WHERE basket_item_id = :basket_item_id AND basket_id = :basket_id";

        try{
            $stmt = $this->pdo->prepare($deleteSql);
            $stmt->execute(['basket_item_id' => $basketItemID, 'basket_id' => $basketID]);

            //check if the item has been deleted
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            error_log("Database error during removeItem: " . $e->getMessage());
            return false;
        }
    }

    


}