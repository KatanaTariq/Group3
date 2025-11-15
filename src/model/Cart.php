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