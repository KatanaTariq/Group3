<?php

/**
 * Shared base controller for all application controllers.
 */
class Controller
{
    protected PDO $pdo;

    /**
     * Initialises the controller with the active database connection.
     *
     * @param PDO $pdo The active database connection object.
     * @return void
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Loads a view file and makes the provided data available to it.
     *
     * @param string $path The view path relative to the view directory.
     * @param array $data The data to extract into the view.
     * @return void
     */
    protected function view(string $path, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        require __DIR__ . '/../view/' . $path . '.php';
    }

    /**
     * Redirects the user to a new URL and stops execution.
     *
     * @param string $url The destination URL.
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
     *
     * @return void
     */
    public function home(): void
    {
        $this->view('pages/home');
    }

    /**
     * Displays the about page.
     *
     * @return void
     */
    public function about(): void
    {
        $this->view('pages/about');
    }

    /**
     * Displays the contact page.
     *
     * @return void
     */
    public function contact(): void
    {
        $this->view('pages/contact');
    }

    /**
     * Displays the customer profile page.
     *
     * @return void
     */
    public function profile(): void
    {
        $this->view('pages/profile');
    }

    /**
     * Displays the basket page.
     *
     * @return void
     */
    public function basket(): void
    {
        $this->view('pages/basket');
    }

    /**
     * Displays the checkout page.
     *
     * @return void
     */
    public function checkout(): void
    {
        if (empty($_SESSION['customer_id'])) {
            $this->redirect('/login?error=' . urlencode('Please login to continue'));
        }

        $customerID = (int) $_SESSION['customer_id'];

        $basketModel = new Basket($this->pdo, $customerID);
        $items = $basketModel->getContents();
        $subtotal = $basketModel->calculateSubtotal();

        $stmt = $this->pdo->prepare("
            SELECT address_id, street, city, post_code
            FROM address
            WHERE customer_id = :customer_id
            ORDER BY created_at DESC
        ");
        $stmt->execute(['customer_id' => $customerID]);
        $addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->view('pages/checkout', [
            'items' => $items,
            'subtotal' => $subtotal,
            'addresses' => $addresses
        ]);
    }

    /**
     * Displays the women's shop page with all women's products.
     *
     * @return void
     */
    public function womens(): void
    {
        $productModel = new ProductModel($this->pdo);

        // Women root category_id = 1.
        $products = $productModel->getProductsForListing(1, null);

        $this->view('pages/womens', [
            'products' => $products
        ]);
    }

    /**
     * Displays the men's shop page with all men's products.
     *
     * @return void
     */
    public function mens(): void
    {
        $productModel = new ProductModel($this->pdo);

        // Men root category_id = 2.
        $products = $productModel->getProductsForListing(2, null);

        $this->view('pages/mens', [
            'products' => $products
        ]);
    }

    /**
     * Displays a single product page using the product ID from the URL.
     *
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

    /**
     * Displays the previous orders page.
     *
     * @return void
     */
    public function previousOrders(): void
    {
        if (empty($_SESSION['customer_id'])) {
            $this->redirect('/login?error=' . urlencode('Please login to view your orders'));
        }

        $customerID = (int) $_SESSION['customer_id'];
        $orderModel = new Order($this->pdo, $customerID);
        $orders = $orderModel->getOrderHistory();

        $this->view('pages/previous_orders', [
            'orders' => $orders
        ]);
    }

    /**
     * Displays a single order with its full item details.
     *
     * @return void
     */
    public function orderDetails(): void
    {
        if (empty($_SESSION['customer_id'])) {
            $this->redirect('/login?error=' . urlencode('Please login'));
        }

        $orderID = (int) ($_GET['id'] ?? 0);

        if ($orderID <= 0) {
            http_response_code(404);
            $this->view('pages/404');
            return;
        }

        $customerID = (int) $_SESSION['customer_id'];
        $orderModel = new Order($this->pdo, $customerID);
        $order = $orderModel->getOrderDetails($orderID);

        if (!$order) {
            http_response_code(404);
            $this->view('pages/404');
            return;
        }

        $this->view('pages/order_details', [
            'order' => $order
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
     *
     * @param PDO $pdo The active database connection object.
     * @return void
     */
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->customerModel = new CustomerModel($pdo);
    }

    /**
     * Displays the registration page.
     *
     * @return void
     */
    public function displayRegister(): void
    {
        $this->view('pages/signup');
    }

    /**
     * Registers a new customer account.
     *
     * @return void
     */
/**
 * Registers a new customer account.
 *
 * @return void
 */
public function register(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $this->displayRegister();
        return;
    }

    if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
        $this->redirect('/signup?error=' . urlencode('Invalid CSRF token'));
    }

    $firstName = sanitise_string($_POST['first_name'] ?? '');
    $lastName = sanitise_string($_POST['last_name'] ?? '');
    $emailInput = trim($_POST['email'] ?? '');
	$email = validate_email($emailInput);

if ($email === null) {
    $this->redirect('/signup?error=' . urlencode('Please enter a valid email address'));
}
    $password = trim($_POST['password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');

    if ($email === null) {
        $this->redirect('/signup?error=' . urlencode('Invalid email'));
    }

    $errors = [];

    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long';
    }

    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = 'Password must contain at least one uppercase letter';
    }

    if (!preg_match('/[\W_]/', $password)) {
        $errors[] = 'Password must contain at least one special character';
    }

    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match';
    }

    if ($errors) {
        $this->redirect('/signup?error=' . urlencode(implode(', ', $errors)));
    }

$existingCustomer = $this->customerModel->getCustomerByEmail($email);

if ($existingCustomer) {
    $this->redirect('/signup?error=' . urlencode('An account with this email already exists'));
}
	
    $customer = $this->customerModel->registerCustomer([
        'email' => $email,
        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        'first_name' => $firstName,
        'last_name' => $lastName,
    ]);

    if (!$customer) {
        $this->redirect('/signup?error=' . urlencode('Could not create account'));
    }

    $_SESSION['customer_id'] = $customer->getId();
    $this->redirect('/profile');
}

    /**
     * Displays the login page.
     *
     * @return void
     */
    public function displayLogin(): void
    {
        $this->view('pages/login');
    }

    /**
     * Logs a customer into their account.
     *
     * @return void
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->displayLogin();
            return;
        }

        if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
            $this->redirect('/login?error=' . urlencode('Invalid CSRF token'));
        }

        $email = validate_email($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($email === null || $password === '') {
            $this->redirect('/login?error=' . urlencode('Invalid credentials'));
        }

        $customer = $this->customerModel->getCustomerByEmail($email);

        if (!$customer || !password_verify($password, $customer->getPasswordHash())) {
            $this->redirect('/login?error=' . urlencode('Invalid credentials'));
        }

        $_SESSION['customer_id'] = $customer->getId();
        $this->redirect('/profile');
    }

    /**
     * Logs the current customer out of their account.
     *
     * @return void
     */
    public function logout(): void
    {
        session_destroy();
        $this->redirect('/login');
    }
}

/**
 * Handles the customer's basket lifecycle, including display, add, update, and remove actions.
 */
class BasketController extends Controller
{
    private ?Basket $basketModel = null;
    private ?int $userId = null;

    /**
     * Initialises the basket controller and basket model for the logged-in user.
     *
     * @param PDO $pdo The active database connection object.
     * @return void
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
     * Renders the product page again so an inline basket error can be shown.
     *
     * @param int $productID The selected product ID.
     * @param string|null $error Optional error message to display.
     * @return void
     */
    private function renderProductPage(int $productID, ?string $error = null): void
    {
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
            'variants' => $productData['variants'],
            'basketError' => $error
        ]);
    }

    /**
     * Displays the basket page with all items and subtotal.
     *
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
     * Adds an item to the basket using the selected product ID, size, and quantity.
     *
     * @return void
     */
    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/basket');
        }

        $productID = (int) ($_POST['product_id'] ?? 0);

        if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
            $this->renderProductPage($productID, 'Something went wrong. Please try again.');
            return;
        }

        if (!$this->userId || !$this->basketModel) {
            $this->renderProductPage($productID, 'Please log in to add items to your basket.');
            return;
        }

        $size = trim($_POST['size'] ?? '');
        $quantity = (int) ($_POST['quantity'] ?? 1);

        if ($productID <= 0) {
            http_response_code(404);
            $this->view('pages/404');
            return;
        }

        if ($size === '') {
            $this->renderProductPage($productID, 'Please select a size.');
            return;
        }

        try {
            $variantID = $this->basketModel->getVariantIdByProductAndSize($productID, $size);

            if ($variantID === null) {
                $this->renderProductPage($productID, 'That size is not available for this product.');
                return;
            }

            $this->basketModel->addItem($variantID, $quantity);
            $this->redirect('/basket?success=' . urlencode('Item added to basket'));
        } catch (Exception $e) {
            $this->renderProductPage($productID, $e->getMessage());
        }
    }

    /**
     * Updates the quantity of an existing basket item.
     *
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

        if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
            $this->redirect('/basket?error=' . urlencode('Invalid CSRF token'));
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
     *
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

        if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
            $this->redirect('/basket?error=' . urlencode('Invalid CSRF token'));
        }

        $basketItemID = (int) ($_POST['basket_item_id'] ?? 0);
        $this->basketModel->removeItem($basketItemID);

        $this->redirect('/basket');
    }
}

/**
 * Handles checkout and address resolution.
 */
class CheckoutController extends Controller
{
    /**
     * Creates a new address for the current customer.
     *
     * @param int $customerID The ID of the current customer.
     * @param string $street The street line of the address.
     * @param string $city The city of the address.
     * @param string $county The county of the address.
     * @param string $postCode The post code of the address.
     * @param string $addressType The address type: SHIPPING, BILLING, or BOTH.
     * @return int The newly created address ID.
     */
    private function createAddress(
        int $customerID,
        string $street,
        string $city,
        string $county,
        string $postCode,
        string $addressType
    ): int {
        $sql = "INSERT INTO address (customer_id, address_type, street, city, county, post_code)
                VALUES (:customer_id, :address_type, :street, :city, :county, :post_code)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'customer_id' => $customerID,
            'address_type' => $addressType,
            'street' => $street,
            'city' => $city,
            'county' => $county !== '' ? $county : null,
            'post_code' => $postCode
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Resolves an address for checkout.
     * Uses an existing selected address if provided; otherwise, creates a new one.
     *
     * @param int $customerID The ID of the current customer.
     * @param int $selectedAddressID The selected saved address ID.
     * @param string $street The submitted street.
     * @param string $city The submitted city.
     * @param string $county The submitted county.
     * @param string $postCode The submitted post code.
     * @param string $addressType The address type: SHIPPING or BILLING.
     * @return int The resolved address ID.
     */
    private function resolveAddress(
        int $customerID,
        int $selectedAddressID,
        string $street,
        string $city,
        string $county,
        string $postCode,
        string $addressType
    ): int {
        if ($selectedAddressID > 0) {
            $sql = "SELECT address_id
                    FROM address
                    WHERE address_id = :address_id
                      AND customer_id = :customer_id
                    LIMIT 1";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'address_id' => $selectedAddressID,
                'customer_id' => $customerID
            ]);

            $addressID = $stmt->fetchColumn();

            if ($addressID === false) {
                throw new Exception('Selected address is invalid.');
            }

            return (int) $addressID;
        }

        if ($street === '' || $city === '' || $postCode === '') {
            throw new Exception('Please select an address or enter a new one.');
        }

        return $this->createAddress(
            $customerID,
            $street,
            $city,
            $county,
            $postCode,
            $addressType
        );
    }

    /**
     * Processes checkout and creates the order from the current basket.
     *
     * @return void
     */
    public function process(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/checkout');
        }

        if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
            $this->redirect('/checkout?error=' . urlencode('Invalid CSRF token'));
        }

        if (empty($_SESSION['customer_id'])) {
            $this->redirect('/login?error=' . urlencode('Please login to continue'));
        }

        $customerID = (int) $_SESSION['customer_id'];

        $selectedShippingAddressID = (int) ($_POST['shipping_address_id'] ?? 0);
        $selectedBillingAddressID = (int) ($_POST['billing_address_id'] ?? 0);

        $shippingStreet = trim($_POST['shipping_street'] ?? '');
        $shippingCity = trim($_POST['shipping_city'] ?? '');
        $shippingCounty = trim($_POST['shipping_county'] ?? '');
        $shippingPostCode = trim($_POST['shipping_post_code'] ?? '');

        $billingStreet = trim($_POST['billing_street'] ?? '');
        $billingCity = trim($_POST['billing_city'] ?? '');
        $billingCounty = trim($_POST['billing_county'] ?? '');
        $billingPostCode = trim($_POST['billing_post_code'] ?? '');

        try {
            $shippingAddressID = $this->resolveAddress(
                $customerID,
                $selectedShippingAddressID,
                $shippingStreet,
                $shippingCity,
                $shippingCounty,
                $shippingPostCode,
                'SHIPPING'
            );

            $billingAddressID = $this->resolveAddress(
                $customerID,
                $selectedBillingAddressID,
                $billingStreet,
                $billingCity,
                $billingCounty,
                $billingPostCode,
                'BILLING'
            );

            $basketModel = new Basket($this->pdo, $customerID);
            $result = $basketModel->finaliseCheckout($shippingAddressID, $billingAddressID);

            if ($result === true) {
                $this->redirect('/previous-orders?success=' . urlencode('Order placed successfully'));
            }

            $this->redirect('/checkout?error=' . urlencode((string) $result));
        } catch (Throwable $e) {
            $this->redirect('/checkout?error=' . urlencode($e->getMessage()));
        }
    }
}

/**
 * Handles admin authentication.
 */
class AdminController extends Controller
{
    /**
     * Initialises the admin controller with the active database connection.
     *
     * @param PDO $pdo The active database connection object.
     * @return void
     */
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Returns the admin CSRF token, creating one if needed.
     *
     * @return string
     */
    private function getCsrfToken(): string
    {
        if (empty($_SESSION['admin_csrf_token'])) {
            $_SESSION['admin_csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['admin_csrf_token'];
    }

    /**
     * Validates the submitted admin CSRF token.
     *
     * @param string|null $token The submitted token.
     * @return bool
     */
    private function validateCsrfToken(?string $token): bool
    {
        return !empty($token)
            && !empty($_SESSION['admin_csrf_token'])
            && hash_equals($_SESSION['admin_csrf_token'], $token);
    }

    /**
     * Displays the admin login page.
     *
     * @return void
     */
    public function showLogin(): void
    {
        if (!empty($_SESSION['admin_id'])) {
            $this->redirect('/admin/inventory');
        }

        $csrf = $this->getCsrfToken();
        $error = $_GET['err'] ?? null;

        require __DIR__ . '/../view/pages/admin/login.php';
    }

    /**
     * Logs an admin into their account.
     *
     * @return void
     */
    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $csrf = $_POST['csrf_token'] ?? '';

        if (!$this->validateCsrfToken($csrf)) {
            $this->redirect('/admin/login?err=csrf');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
            $this->redirect('/admin/login?err=invalid');
        }

        $adminModel = new Admin($this->pdo);
        $admin = $adminModel->findByEmail($email);

        if (
            !$admin ||
            empty($admin['password_hash']) ||
            !password_verify($password, $admin['password_hash'])
        ) {
            $this->redirect('/admin/login?err=invalid');
        }

        $_SESSION['admin_id'] = (int) $admin['admin_id'];

        session_regenerate_id(true);

        $this->redirect('/admin/inventory');
    }

    /**
     * Logs the current admin out of their account.
     *
     * @return void
     */
    public function logout(): void
    {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_csrf_token']);

        $this->redirect('/admin/login?err=loggedout');
    }
}

/**
 * Handles admin inventory pages and stock updates.
 */
class InventoryController extends Controller
{
    private Inventory $inventoryModel;

    /**
     * Initialises the inventory controller and related model.
     *
     * @param PDO $pdo The active database connection object.
     * @return void
     */
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);

        $this->inventoryModel = new Inventory($pdo);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Ensures only logged-in admins can access inventory routes.
     *
     * @return void
     */
    private function requireAdmin(): void
    {
        if (empty($_SESSION['admin_id'])) {
            $this->redirect('/admin/login?err=session');
        }
    }

    /**
     * Displays the main admin inventory page.
     *
     * @return void
     */
    public function index(): void
    {
        $this->requireAdmin();

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $inventoryItems = $this->inventoryModel->getAllInventory();
        require __DIR__ . '/../view/pages/admin/inventory.php';
    }

    /**
     * Displays recent inventory change logs.
     *
     * @return void
     */
    public function logs(): void
    {
        $this->requireAdmin();

        $logs = $this->inventoryModel->getRecentLogs(50);
        require __DIR__ . '/../view/pages/admin/inventory_logs.php';
    }

    /**
     * Updates stock for a product variant.
     *
     * @return void
     */
    public function updateStock(): void
    {
        $this->requireAdmin();

        $csrfToken = $_POST['csrf_token'] ?? '';

        if (
            empty($csrfToken) ||
            empty($_SESSION['csrf_token']) ||
            !hash_equals($_SESSION['csrf_token'], $csrfToken)
        ) {
            $_SESSION['flash_error'] = 'Invalid CSRF token. Please try again.';
            $this->redirect('/admin/inventory');
        }

        $variantId = isset($_POST['variant_id']) ? (int) $_POST['variant_id'] : 0;
        $newQuantity = $_POST['new_quantity'] ?? null;

        if ($variantId <= 0) {
            $_SESSION['flash_error'] = 'Invalid variant ID.';
            $this->redirect('/admin/inventory');
        }

        if (!is_numeric($newQuantity) || (int) $newQuantity < 0) {
            $_SESSION['flash_error'] = 'Quantity must be a non-negative number.';
            $this->redirect('/admin/inventory');
        }

        $newQuantity = (int) $newQuantity;

        $adminId = (int) $_SESSION['admin_id'];
        $success = $this->inventoryModel->updateStock($variantId, $newQuantity, $adminId);

        if ($success) {
            $_SESSION['flash_success'] = 'Stock updated successfully.';
        } else {
            $_SESSION['flash_error'] = 'Failed to update stock. Please try again later.';
        }

        $this->redirect('/admin/inventory');
    }
}