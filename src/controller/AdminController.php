<?php

class AdminController extends BaseController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        // Session already started in index.php, but safe fallback:
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
        if (!empty($_SESSION['admin_id'])) {
            header('Location: /Group3/admin/inventory');
            exit;
        }

        $csrf = $this->getCsrfToken();
        $error = $_GET['err'] ?? null;

        // ✅ views live under /src/view/...
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

        if (!$this->validateCsrfToken($csrf)) {
            header('Location: /Group3/admin/login?err=csrf');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
            header('Location: /Group3/admin/login?err=invalid');
            exit;
        }

        require_once __DIR__ . '/../model/Admin.php';
        $adminModel = new Admin($this->pdo);

        $admin = $adminModel->findByEmail($email);

        if (!$admin || empty($admin['password_hash']) || !password_verify($password, $admin['password_hash'])) {
            header('Location: /Group3/admin/login?err=invalid');
            exit;
        }

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
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_csrf_token']);

        header('Location: /Group3/admin/login?err=loggedout');
        exit;
    }
}