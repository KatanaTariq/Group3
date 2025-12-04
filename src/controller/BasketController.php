<?php
/*******************************************
Developer: Mokutmfonobong Utuk
University ID: 240240082
Function: - add, remove, update basket items
     * - calculate and display basket subtotal
*******************************************/


namespace AthlETIQ\Controller;
use AthlETIQ\model\Basket;

class BasketController{

    private $basketModel ;

    public function __construct($db){
         if (session_status() == PHP_SESSION_NONE) {
            session_start();
         }
        // Assuming the user is authenticated and $userID is available
        $userID = $this->getCurrentUserId();
        $this->basketModel = new basket($db, $userID);
    }

    /**
     * Displays the full basket page.
     */
    public function index() {
        $basketItem = $this->basketModel->getContents();
        $subtotal = $this->basketModel->calculateSubtotal();

        $this->render('pages/basket', [
            'basketItem' => $basketItem,
            'subtotal' => $subtotal,
            'isBasketEmpty' => empty($basketItem)
        ]);
    }

    /**
     * Handles the request to add an item to the basket
     */
    public function addItem(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['variant_id'])) {
            $variantID = (int)$_POST['variant_id'];
            $quantity = (int)($_POST['quantity'] ?? 1);

            try{
                if ($quantity < 1) {
                    throw new \InvalidArgumentException("Quantity must be at least 1.");
                }
                $this->basketModel->addItem($variantID, $quantity);
                $this->setFlashMessage('success', 'Item added to basket successfully.');
                
            } catch (\InvalidArgumentException $e) {
                // Controller failure message for bad input
                $this->setFlashMessage('error', $e->getMessage());
            } catch (\Exception $e) {
                // Controller failure message for Model errors (e.g., insufficient stock)
                $this->setFlashMessage('error', 'Failed to add item: ' . $e->getMessage());
        }

        header('Location: /basket');
        exit();
    }

    /**
     * handles quantity updates via the input field form on the basket page
     */
    public function updateBasket(){
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'], $_POST['quantity'])) {
            $itemID = (int)$_POST['item_id'];
            $newQuantity = (int)$_POST['quantity'];

            try{
                if ($newQuantity < 1) {
                    //if quantity drops to zero, call the remove method
                    $success = $this->basketModel->removeItem($itemID);
                    $message = $success ? 'Item removed fro basket.' : 'Could not remove item.';
                    $this->setFlashMessage($success ? 'error', $message);
                } else {
                    //update nthe quantity
                    $this->basketModel->updateItemQuantity($itemID, $newQuantity);
                    $this->setFlashMessage('success', 'Basket quantity updated.');
                }
            } catch (\Exception $e) {
                // catches stock error or item not found error thrown by the model
                $this->setFlashMessage('error', 'Update failed; ' . $e->getMessage());
            }
        }
        header('Location: /basket');
        exit();
    }

    /**
     * Handles item removal via the dedicated "Remove" button.
     */
    public function removeItem(){
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
            $itemID = (int)$_POST['item_id'];

            $success = $this->basketModel->removeItem($itemID);

            if($success) {
                $this->setFlashMessage('success', 'Item removed fro basket.');
            } else {
                $this->setFlashMessage('error', 'Coulde not remove item. Please check your basket.');
            }
        }
        header('Location: /basket');
        exit();
    }
    /**
     * Execute the checkout process using the Basket models transactional logic
     */
    public function checkout(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /checkout');
            exit();
        }

        $shippingAddressID = (int)($_POST['shipping_address_id'] ?? 0);
        $billingAddressID = (int)($_POST['billing_address_id'] ?? 0);

        // controller validation of user input
        if($shippingAddressID <= 0 || $billingAddressID <= 0) {
            $this->setFlashMessage('error', 'Invalid address selection. Please ensure you have selected shipping and billing addresses.');
            header('Location: /checkout');
            exit();
        }

        try{
            //model execute the transaction and returns the new order ID
            $orderID = $this->basketModel->finalizeCheckout($shippingAddressID, $billingAddressID);

            // success: controller sets the succes message and redirectsto confirmation/history
            $this->setFlashMessage('sucess', "Thank you! Your order #{$orderID} has been places successfully.");
            header('Location: /order/confirmation?id=' . $orderID);
            exit();
        } catch (\Exception $e) {
            // failure: controller catches the model's exception and sets the user-facing error
            $this->setFlashMessage('error', 'Order failed: ' . $e->getMessage());
            header('Location: /checkout');
            exit();
        }
    }

    *
     * Renders a view template and outputs it to the user.
     * * NOTE: This is a placeholder for a real view rendering system.
     * @param string $viewPath Path to the view file (e.g., 'pages/basket').
     * @param array $data Data to be passed to the view.
     */
    protected function render(string $viewPath, array $data = [])
    {
        // Simulation for compilation purposes:
        echo "--- Rendering View: {$viewPath} ---\n";
        echo "Data passed: " . print_r($data, true) . "\n";
    }

    /**
     * Helper to simulate a flash message(for user feedback)
     */
    private function setFlashMessage($type, $message){
        error_log("FLASH MESSAGE ({$type}): {$message}");
    }

    // mock function for getting the current logged in user ID
    private function getCurrentUserID(): int{
        //Kiera's responsibility: replace with actual session/ auth check
        return 1;
    }
}
    /**
     * handles user shopping basket operations.
     *
     * responsibilities:
     * - add, remove, update basket items
     * - calculate and display basket subtotal
     */

?>
