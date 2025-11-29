<?php

/**
 * handles all authentication tasks for the mvp.
 *
 * responsibilities:
 * - login and logout
 * - register
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
        return $this->view('pages/register');
    }

    public function register()
    {
        $email      = trim($_POST['email'] ?? '');
        $password   = trim($_POST['password'] ?? '');
        $firstName  = trim($_POST['first_name'] ?? '');
        $lastName   = trim($_POST['last_name'] ?? '');

        if (!$email || !$password || !$firstName || !$lastName) {
            return $this->redirect('/register?error=missing');
        }

        if ($this->customerModel->getCustomerByEmail($email)) {
            return $this->redirect('/register?error=exists');
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $customer = $this->customerModel->registerCustomer([
            'email'         => $email,
            'password_hash' => $passwordHash,
            'first_name'    => $firstName,
            'last_name'     => $lastName
        ]);

        if (!$customer) {
            return $this->redirect('/register?error=failed');
        }

        $_SESSION['customer_id'] = $customer->getID();
        return $this->redirect('/profile');
    }

    public function displayLogin()
    {
        return $this->view('pages/login');
    }

    public function login()
    {
        $email    = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $customer = $this->customerModel->getCustomerByEmail($email);

        if (!$customer || !password_verify($password, $customer->getPasswordHash())) {
            return $this->redirect('/login?error=invalid');
        }

        $_SESSION['customer_id'] = $customer->getID();
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