<?php

require_once __DIR__ . '/../model/Admin.php';

class AdminController extends BaseController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // -----------------------
    // CSRF helpers (admin login only)
    // -----------------------
    private function getCsrfToken(): string
    {
        if (empty($_SESSION['admin_csrf_token'])) {
            $_SESSION['admin_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['admin_csrf_token'];
    }

    private function validateCsrfToken(?string $token): bool
    {
        return !empty($token)
            && !empty($_SESSION['admin_csrf_token'])
            && hash_equals($_SESSION['admin_csrf_token'], $token);
    }

    // -----------------------
    // GET: show admin login
    // -----------------------
    public function showLogin(): void
    {
        // If already logged in as admin, go to inventory
        if (!empty($_SESSION['admin_id'])) {
            header('Location: /Group3/admin/inventory');
            exit;
        }

        $csrf  = $this->getCsrfToken();
        $error = $_GET['err'] ?? null;

        require __DIR__ . '/../view/pages/admin/login.php';
    }

    // -----------------------
    // POST: admin login
    // -----------------------
    public function login(): void
    {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $csrf     = $_POST['csrf_token'] ?? '';

        // CSRF check
        if (!$this->validateCsrfToken($csrf)) {
            header('Location: /Group3/admin/login?err=csrf');
            exit;
        }

        // Input validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
            header('Location: /Group3/admin/login?err=invalid');
            exit;
        }

        // Authenticate admin
        $adminModel = new Admin($this->pdo);
        $admin = $adminModel->findByEmail($email);

        if (
            !$admin ||
            empty($admin['password_hash']) ||
            !password_verify($password, $admin['password_hash'])
        ) {
            header('Location: /Group3/admin/login?err=invalid');
            exit;
        }

        // Set session
        $_SESSION['admin_id'] = (int)$admin['admin_id'];

        // Reduce session fixation risk
        session_regenerate_id(true);

        header('Location: /Group3/admin/inventory');
        exit;
    }

    // -----------------------
    // GET: admin logout
    // -----------------------
    public function logout(): void
    {
        // Clear all session data
        $_SESSION = [];

        // Invalidate the session cookie
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        // Destroy session
        session_destroy();

        header('Location: /Group3/admin/login?err=loggedout');
        exit;
    }
}