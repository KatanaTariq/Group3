<?php

namespace AthLETIQ\Controller;

use AthLETIQ\Model\Cart;
// use AthLETIQ\Service\BasketService;

class CartController extends BaseController{
    private $cartModel;
    private $basketService;

    public function __construct($db){
        parent:: __construct();
        // Assume user is authenticated and $userID is available
        $userID = $this->getCurrentUserID();

        $this->cartModel = new Cart($db, $userID);
        //$this->basketService = new BasketService($db);

    }

    /**Displays the full cart page */

    public function index(){
        //methods too fetch basket data for display
        $carItems = $this->cartModel->getContents();
        $subtotal = $this->cartModel->calculateSubtotal();

        $this->render('pages/cart', ['cartItems' => $cartItems, 'subtotal' => $subtotal, 'isCartEmpty' => empty($cartItems)]);
    }

    /**handles the request to add an item to the cart (e.g, from a product detail page) */
    public function addItem(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['variant_id'])) {
            $variantID = (int)$_POST['variant_id'];
            $quantity = (int)($_POST['quantity'] ?? 1);

            // calling core logic
            $result = $this->cartModel->addItem($variantID, $quantity);

            if ($result !== true) {
                $this->setFlashMessage('error', $result);
            } else {
                $this->setFlashMessage('success', 'Item added to basket successfully.');
            }
            header('Location: /cart');
            exit();
        }
    }

    /**  Handles quantity updates via the input field form on the cart page */
    public function updateCart(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'], $_POST['quantity'])) {
            $itemID = (int)$_POST['item_id'];
             $newQuantity = (int)$_POST['quantity'];

            if ($newQuantity < 1) {
                // if quantity drops to zero or below, remove the item
                $result = $this->cartModel->removeItem($itemID);
                $message = $result ? 'Item removed from basket.' : 'Could not remove item.';
            } else {
                //update the quantity
                $result = 4this->cartModel->updateItemQuantity($itemID, $newQuantity);
                $message = ($result === true) ? 'Basket qunatity updated.' : $result;
            }

            if ($result !== true) {
                $this->setFlashMessage('error', $message);
            } else {
                $this->setFlashMessage('success', $message);    
            }
        }
        header('Location: /cart');
        exit();
    }

   /** Handles item removal via the designated "Remove" button form. */
   public function removeItem(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
        $itemID = (int)$_POST['item_id'];

        $result = $this->cartModel->removeItem($itemID);

        if ($result) {
              $this->setFlashMessage('Success', 'Item has been removed from basket.');
        } else {
            $this->setFlashMessage('Error', 'Could not remve item. Please check your basket.');
        }
    }
    header('Location: /cart');
    exit();  
   }

   //mock foundation for getting the curent logged in user ID
   private function getCurrentUserID(): int{
    // this would rely on Kiera's session/authentication system
    return 1;
   }

   /**
    * Helper to simulate flash message (for user feedback).
    * @param string $tmessage the message content
    * @param string $type success or error
    */
   private fuction setFlashMessage($type, $message){
    //placeholder implementation
    // for development, logging to the error file/console.
    error_log("FLASH MESSAGE ({$type}): {$message}");
   }
}



