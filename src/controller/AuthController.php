<?php
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

        // CSRF check
        if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
            return $this->redirect('/signup?error=' . urlencode('Invalid CSRF token'));
        }

        // Raw inputs
        $firstNameRaw = $_POST['first_name'] ?? '';
        $lastNameRaw  = $_POST['last_name'] ?? '';
        $emailRaw     = $_POST['email'] ?? '';
        $passwordRaw  = $_POST['password'] ?? '';

        // Sanitize / validate
        $firstName = sanitize_string($firstNameRaw);
        $lastName  = sanitize_string($lastNameRaw);
        $email     = validate_email($emailRaw);

        if ($email === null) {
            return $this->redirect('/signup?error=' . urlencode('Invalid email'));
        }

        // Password validation
        $password = trim($passwordRaw);
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

        if (!empty($errors)) {
            $errorString = urlencode(implode(', ', $errors));
            return $this->redirect('/signup?error=' . $errorString);
        }

        // Password hashing (NEVER store plain text)
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Create the customer (CustomerModel uses prepared statements)
        $customer = $this->customerModel->registerCustomer([
            'email'         => $email,
            'password_hash' => $passwordHash,
            'first_name'    => $firstName,
            'last_name'     => $lastName,
        ]);

        if ($customer === null) {
            return $this->redirect('/signup?error=' . urlencode('could not create account'));
        }

        // Log the user in
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

        // CSRF check
        if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
            return $this->redirect('/login?error=' . urlencode('Invalid CSRF token'));
        }

        $emailRaw = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $email = validate_email($emailRaw);
        $password = trim($password);

        if ($email === null || $password === '') {
            return $this->redirect('/login?error=' . urlencode('Invalid Credentials'));
        }

        // Retrieve user by email
        $customer = $this->customerModel->getCustomerByEmail($email);

        // Use password_verify to compare plaintext to hash
        if (!$customer || !password_verify($password, $customer->getPasswordHash())) {
            return $this->redirect('/login?error=' . urlencode('Invalid Credentials'));
        }

        // Success: store session data
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

?>