<?php

/**
 * ==========================================================
 *                    AUTH CONTROLLER
 * ==========================================================
 * Fully implemented and active
 * Developer: Kiera
 */

class AuthController
{
    private CustomerModel $customerModel;

    public function __construct(PDO $pdo)
    {
        $this->customerModel = new CustomerModel($pdo);
    }

    public function displayRegister()
    {
        return $this->view('pages/signup');
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->displayRegister();
        }

        if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
            return $this->redirect('/signup?error=' . urlencode('Invalid CSRF token'));
        }

        $firstName = sanitize_string($_POST['first_name'] ?? '');
        $lastName  = sanitize_string($_POST['last_name'] ?? '');
        $email     = validate_email($_POST['email'] ?? '');
        $password  = trim($_POST['password'] ?? '');

        if ($email === null) {
            return $this->redirect('/signup?error=' . urlencode('Invalid email'));
        }

        $errors = [];

        if (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters long';
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain an uppercase letter';
        }
        if (!preg_match('/[\W_]/', $password)) {
            $errors[] = 'Password must contain a special character';
        }

        if ($errors) {
            return $this->redirect('/signup?error=' . urlencode(implode(', ', $errors)));
        }

        $customer = $this->customerModel->registerCustomer([
            'email'         => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'first_name'    => $firstName,
            'last_name'     => $lastName,
        ]);

        if (!$customer) {
            return $this->redirect('/signup?error=' . urlencode('could not create account'));
        }

        $_SESSION['customer_id'] = $customer->getId();
        return $this->redirect('/profile');
    }

    public function displayLogin()
    {
        return $this->view('pages/login');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->view('pages/login');
        }

        if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
            return $this->redirect('/login?error=' . urlencode('Invalid CSRF token'));
        }

        $email = validate_email($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($email === null || $password === '') {
            return $this->redirect('/login?error=' . urlencode('Invalid Credentials'));
        }

        $customer = $this->customerModel->getCustomerByEmail($email);

        if (!$customer || !password_verify($password, $customer->getPasswordHash())) {
            return $this->redirect('/login?error=' . urlencode('Invalid Credentials'));
        }

        $_SESSION['customer_id'] = $customer->getId();
        return $this->redirect('/profile');
    }

    public function logout()
    {
        session_destroy();
        return $this->redirect('/login');
    }

    private function view(string $path)
    {
        include __DIR__ . '/../view/' . $path . '.php';
    }

    private function redirect(string $url)
    {
        header("Location: $url");
        exit;
    }
}

/* ==========================================================
 * ==========================================================
 *                    BASKET CONTROLLER
 * ==========================================================
 * INTEGRATED
 * Developer: Mokutmfonobong Utuk
 * ==========================================================
 * ========================================================== */

 /*******************************************
 Developer: Mokutmfonobong Utuk
 University ID: 240240082
 Function: - manages the lifecycle of the shopping cart(from adding items to preparing for checkout)
 *******************************************/

 namespace AthlETIQ\Controller;
 use AthlETIQ\Model\Basket;
 use PDO

 class BasketController {

     private $basketModel;
     private ?int userId;

     public function __construct($db){
         if (session_status() === PHP_SESSION_NONE) {
             session_start();
         }
         $this->userId = $_SESSION['customer_id'] ?? null;

         if ($this->userId) {
              $this->basketModel = new Basket($pdo, $this->userId);
             }
     }
     
     /**
      * Displays the basket page with items and subtotal
      */
     public function index() {
          if (!$this->userId) {
              return $this->redirect('login?error=Please login to view your basket');
          }
          $items = $this->baskeModel->getContents();
          $subtotal = $this->baketModel->calculateSubtotal();
          
          return $this->view('pages/basket', [
               'items' => $items,
               'subtotal' => $subtotal
          ]);
         }
     /**
       * Handles adding an item (POST request)
      */
     public function addItem(){
          if (!$this->userId) {
              return $this->redirect('/login');
          }
          
          $variantId = (int)($_POST['variant_id'] ?? 0);
          $quantity = (int)($_POST['quantity'] ?? 1);

          try {
              $this->basketModel->addItem($varientId, $quantity);
              return $this->redirect('/basket?siccess=Item added');
          } catch (\Exception $e) {
              return $this->redirect('/products?error=' . urlencode($e->getMessage()));
          }
  }
     public function updateBasket(){
         $itemId = (int)($_POST['basket_item_id'] ?? 0);
         $newQty = (int)($_POST['quantity'] ?? 1);
  
         try {
             $this->basketModel->updateItemQuantity($itemId, $newQty);
             return $this->redirect('/basket');
          } catch (\Exception $e) {
              return $this->redirect('/basket?error=' . urlencode($e->getMessage()));
          }
      }

     public function removeItem(){
         $itemId = (int)($_POST['basket_item_id'] ?? 0);
         $this->basketModel->removeItem($itemId);
         return $this->redirect('/basket');
     }

     private function view(string $path, array $data = []) {
          extract($data);
          include __DIR__ . '/../view/' . $path . '.php';
     }
     
    private function redirect(string $url) {
          header("Location: $url");
          exit;
     }
}

/* ==========================================================
 * ==========================================================
 *                    ORDER CONTROLLER
 * ==========================================================
 * INTEGRATED
 * Developer: Mokutmfonobong Utuk
 * ==========================================================
 * ========================================================== */

/*******************************************
 Developer: Mokutmfonobong Utuk
 University ID: 240240082
 Function: - handles the checkout flow and the order history, supporting "Returns and Review" responsibilities
*******************************************/
namespace AthlETIQ\Controller;

use AthlETIQ\Model\Basket;
use AthlETIQ\Model\Order;
USE PDO;

class OrderController {
    private Order $orderModel;
    private Basket $baskeModel;
    private ?int $userId;

    public function __construct(PDO $pdo) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userId = $_SESSION['customer_id'] ?? null;

        if ($this->userId) {
            $this->orderModel = new Order($pdo, $this->userId);
            $this->basketModel = new Basket($pdo, $this->userId);
        }
    }

    /**
     * Processes the final checkout
     */
    public function processCheckout() {
        if (!$this->userId) return $this->redirect('/login');

        $shippingId = (int)$_POST['shipping_address_id'];
        $billingId = (int)$_POST['billing_address_id'];

        $result = $this->basketModel->finalizeCheckout($shippingId, $billingId);

        if ($reult === true) {
            return $this->redirect('/orders?success=Order placed successfully');
        } else {
            return $this->redirect('/basket?error=' urlencode($result));
        }
    }

    /**
     * Displays all past orders (Order History)
     */
    public function history() {
        if (!$this->userId) return $this->redirect('/login');

        $orders = $this->orderModel->getOrderHistory();
        return $this->view('pages/previous_orders', ['orders' => $orders]);
    }

    private function view(String $path, array $data = []) {
        extract($data);
        include __DIR__ . '/../view/' . $path . '.php';
    }

    private function redirect(string $url) {
        header("Location: $url");
        exit;
    }
}