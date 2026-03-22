<?php

/**
 * Shared base controller for all application controllers.
 */
class Controller
{
    protected PDO $pdo;

    /**
     * Initialises the controller with the active database connection.
     * @param PDO $pdo the active database connection object
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Loads a view file and makes the provided data available to it.
     * @param string $path the view path relative to the view directory
     * @param array $data the data to extract into the view
     * @return void
     */
    protected function view(string $path, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        require __DIR__ . '/../view/' . $path . '.php';
    }

    /**
     * Redirects the user to a new URL and stops execution.
     * @param string $url the destination URL
     * @return void
     */
    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
}

/**
 * Handles non-auth page requests and renders standard views.
 */
class PageController extends Controller
{
    /**
     * Displays the home page.
     * @return void
     */
    public function home(): void
    {
        $this->view('pages/home');
    }

    /**
     * Displays the about page.
     * @return void
     */
    public function about(): void
    {
        $this->view('pages/about');
    }

    /**
     * Displays the contact page.
     * @return void
     */
    public function contact(): void
    {
        $this->view('pages/contact');
    }

    /**
     * Displays the customer profile page.
     * @return void
     */
    public function profile(): void
    {
        $this->view('pages/profile');
    }

    /**
     * Displays the previous orders page.
     * @return void
     */
    public function previousOrders(): void
    {
        $this->view('pages/previous_orders');
    }

    /**
     * Displays the basket page.
     * @return void
     */
    public function basket(): void
    {
        $this->view('pages/basket');
    }

    /**
     * Displays the checkout page.
     * @return void
     */
    public function checkout(): void
    {
        $this->view('pages/checkout');
    }

    /**
     * Displays the women's shop page with all women's products.
     * @return void
     */
    public function womens(): void
    {
        $productModel = new ProductModel($this->pdo);

        // women root category_id = 1
        $products = $productModel->getProductsForListing(1, null);

        $this->view('pages/womens', [
            'products' => $products
        ]);
    }

    /**
     * Displays the men's shop page with all men's products.
     * @return void
     */
    public function mens(): void
    {
        $productModel = new ProductModel($this->pdo);

        // men root category_id = 2
        $products = $productModel->getProductsForListing(2, null);

        $this->view('pages/mens', [
            'products' => $products
        ]);
    }

    /**
     * Displays a single product page using the product id from the URL.
     * @return void
     */
    public function product(): void
    {
        $productID = (int) ($_GET['id'] ?? 0);

        if ($productID <= 0) {
            http_response_code(404);
            $this->view('pages/404');
            return;
        }

        $productModel = new ProductModel($this->pdo);
        $productData = $productModel->getProductFull($productID);

        if (!$productData) {
            http_response_code(404);
            $this->view('pages/404');
            return;
        }

        $this->view('pages/product', [
            'product' => $productData['product'],
            'variants' => $productData['variants']
        ]);
    }
}

/**
 * Handles customer authentication and account access.
 */
class AuthController extends Controller
{
    private CustomerModel $customerModel;

    /**
     * Initialises the auth controller and customer model.
     * @param PDO $pdo the active database connection object
     */
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->customerModel = new CustomerModel($pdo);
    }

    /**
     * Displays the registration page.
     * @return void
     */
    public function displayRegister(): void
    {
        $this->view('pages/signup');
    }

    /**
     * Registers a new customer account.
     * @return void
     */
    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->displayRegister();
        }

        if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
            $this->redirect('/signup?error=' . urlencode('Invalid CSRF token'));
        }

        $firstName = sanitise_string($_POST['first_name'] ?? '');
        $lastName  = sanitise_string($_POST['last_name'] ?? '');
        $email     = validate_email($_POST['email'] ?? '');
        $password  = trim($_POST['password'] ?? '');

        if ($email === null) {
            $this->redirect('/signup?error=' . urlencode('Invalid email'));
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
            $this->redirect('/signup?error=' . urlencode(implode(', ', $errors)));
        }

        $customer = $this->customerModel->registerCustomer([
            'email'         => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'first_name'    => $firstName,
            'last_name'     => $lastName,
        ]);

        if (!$customer) {
            $this->redirect('/signup?error=' . urlencode('could not create account'));
        }

        $_SESSION['customer_id'] = $customer->getId();
        $this->redirect('/profile');
    }

    /**
     * Displays the login page.
     * @return void
     */
    public function displayLogin(): void
    {
        $this->view('pages/login');
    }

    /**
     * Logs a customer into their account.
     * @return void
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->displayLogin();
        }

        if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
            $this->redirect('/login?error=' . urlencode('Invalid CSRF token'));
        }

        $email = validate_email($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($email === null || $password === '') {
            $this->redirect('/login?error=' . urlencode('Invalid Credentials'));
        }

        $customer = $this->customerModel->getCustomerByEmail($email);

        if (!$customer || !password_verify($password, $customer->getPasswordHash())) {
            $this->redirect('/login?error=' . urlencode('Invalid Credentials'));
        }

        $_SESSION['customer_id'] = $customer->getId();
        $this->redirect('/profile');
    }

    /**
     * Logs the current customer out of their account.
     * @return void
     */
    public function logout(): void
    {
        session_destroy();
        $this->redirect('/login');
    }
}

/**
 * Handles the customer's basket lifecycle, including display, add, update and remove actions.
 */
class BasketController extends Controller
{
    private ?Basket $basketModel = null;
    private ?int $userId = null;

    /**
     * Initialises the basket controller and basket model for the logged-in user.
     * @param PDO $pdo the active database connection object
     */
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->userId = $_SESSION['customer_id'] ?? null;

        if ($this->userId) {
            $this->basketModel = new Basket($pdo, $this->userId);
        }
    }

    /**
     * Displays the basket page with all items and subtotal.
     * @return void
     */
    public function index(): void
    {
        if (!$this->userId || !$this->basketModel) {
            $this->redirect('/login?error=' . urlencode('Please login to view your basket'));
        }

        $items = $this->basketModel->getContents();
        $subtotal = $this->basketModel->calculateSubtotal();

        $this->view('pages/basket', [
            'items' => $items,
            'subtotal' => $subtotal
        ]);
    }

    /**
     * Adds an item to the basket using the selected product id, size and quantity.
     * @return void
     */
    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/basket');
        }

        $productID = (int) ($_POST['product_id'] ?? 0);

        if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
            $this->redirect('/product?id=' . $productID . '&error=' . urlencode('Invalid CSRF token'));
        }

        if (!$this->userId || !$this->basketModel) {
            $this->redirect('/login?error=' . urlencode('Please login to add items'));
        }

        $size = trim($_POST['size'] ?? '');
        $quantity = (int) ($_POST['quantity'] ?? 1);

        if ($productID <= 0 || $size === '') {
            $this->redirect('/product?id=' . $productID . '&error=' . urlencode('Invalid product or size selection'));
        }

        try {
            $variantID = $this->basketModel->getVariantIdByProductAndSize($productID, $size);

            if ($variantID === null) {
                throw new Exception('That size is not available for this product.');
            }

            $this->basketModel->addItem($variantID, $quantity);
            $this->redirect('/basket?success=' . urlencode('Item added to basket'));
        } catch (Exception $e) {
            $this->redirect('/product?id=' . $productID . '&error=' . urlencode($e->getMessage()));
        }
    }
    /**
     * Updates the quantity of an existing basket item.
     * @return void
     */
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/basket');
        }

        if (!$this->userId || !$this->basketModel) {
            $this->redirect('/login');
        }

        $basketItemID = (int) ($_POST['basket_item_id'] ?? 0);
        $quantity = (int) ($_POST['quantity'] ?? 1);

        try {
            $this->basketModel->updateItemQuantity($basketItemID, $quantity);
            $this->redirect('/basket');
        } catch (Exception $e) {
            $this->redirect('/basket?error=' . urlencode($e->getMessage()));
        }
    }

    /**
     * Removes an item from the current user's basket.
     * @return void
     */
    public function remove(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/basket');
        }

        if (!$this->userId || !$this->basketModel) {
            $this->redirect('/login');
        }

        $basketItemID = (int) ($_POST['basket_item_id'] ?? 0);
        $this->basketModel->removeItem($basketItemID);

        $this->redirect('/basket');
    }
}