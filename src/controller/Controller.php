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