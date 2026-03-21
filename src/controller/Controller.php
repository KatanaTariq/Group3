<?php

/**
 * ==========================================================
 *                    BASE CONTROLLER
 * ==========================================================
 * Shared helpers for all controllers
 */

class Controller
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    protected function view(string $path, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        require __DIR__ . '/../view/' . $path . '.php';
    }

    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
}

/**
 * ==========================================================
 *                    PAGE CONTROLLER
 * ==========================================================
 * Handles non-auth pages (views only)
 */

class PageController extends Controller
{
    public function home(): void { $this->view('pages/home'); }
    public function about(): void { $this->view('pages/about'); }
    public function contact(): void { $this->view('pages/contact'); }

    public function profile(): void { $this->view('pages/profile'); }
    public function previousOrders(): void { $this->view('pages/previous_orders'); }

    public function basket(): void { $this->view('pages/basket'); }
    public function checkout(): void { $this->view('pages/checkout'); }

        public function womens(): void
    {
        $productModel = new ProductModel($this->pdo);

        // your model assumes: women root category_id = 1
        $products = $productModel->getProductsForListing(1, null);

        $this->view('pages/womens', [
            'products' => $products
        ]);
    }

    public function mens(): void { $this->view('pages/mens'); }
}

/**
 * ==========================================================
 *                    AUTH CONTROLLER
 * ==========================================================
 * Implemented and active
 * Developer: Kiera
 */

class AuthController extends Controller
{
    private CustomerModel $customerModel;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->customerModel = new CustomerModel($pdo);
    }

    public function displayRegister(): void
    {
        $this->view('pages/signup');
    }

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

    public function displayLogin(): void
    {
        $this->view('pages/login');
    }

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

    public function logout(): void
    {
        session_destroy();
        $this->redirect('/login');
    }
}