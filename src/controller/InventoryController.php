<?php

class InventoryController
{
    private PDO $pdo;

    // Base prefix for all redirects on XAMPP
    private string $base = '/Group3/index.php';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // GET /admin/inventory
    public function index()
    {
        $this->requireAdmin();

        $model = new InventoryModel($this->pdo);
        $inventoryItems = $model->getInventoryWithProductDetails();

        $csrf = get_csrf_token();

        $this->view('pages/admin/inventory', [
            'inventoryItems' => $inventoryItems,
            'csrf' => $csrf
        ]);
    }

    // POST /admin/inventory/update
    public function update()
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect("{$this->base}/admin/inventory");
        }

        if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
            $_SESSION['flash_error'] = 'Invalid CSRF token.';
            $this->redirect("{$this->base}/admin/inventory");
        }

        $variantId = filter_input(INPUT_POST, 'variant_id', FILTER_VALIDATE_INT);
        $newStock  = filter_input(INPUT_POST, 'new_stock', FILTER_VALIDATE_INT);
        $reason    = trim($_POST['reason'] ?? '');

        if (!$variantId || $variantId <= 0) {
            $_SESSION['flash_error'] = 'Invalid variant ID.';
            $this->redirect("{$this->base}/admin/inventory");
        }

        if ($newStock === false || $newStock === null || $newStock < 0) {
            $_SESSION['flash_error'] = 'Stock must be 0 or higher.';
            $this->redirect("{$this->base}/admin/inventory");
        }

        if (strlen($reason) > 100) {
            $_SESSION['flash_error'] = 'Reason must be 100 characters or fewer.';
            $this->redirect("{$this->base}/admin/inventory");
        }

        $model = new InventoryModel($this->pdo);

        try {
            $this->pdo->beginTransaction();

            $currentStock = $model->getCurrentStock($variantId);
            if ($currentStock === null) {
                throw new Exception('Inventory record not found.');
            }

            $changeAmount = (int)$newStock - (int)$currentStock;

            $model->updateStock($variantId, (int)$newStock);

            $logReason = ($reason === '') ? 'Manual admin update' : $reason;
            $model->logChange($variantId, $changeAmount, $logReason);

            $this->pdo->commit();

            $_SESSION['flash_success'] = 'Stock updated successfully.';
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            $_SESSION['flash_error'] = 'Failed to update stock.';
        }

        $this->redirect("{$this->base}/admin/inventory");
    }

    // GET /admin/inventory/logs
    public function logs()
    {
        $this->requireAdmin();

        $model = new InventoryModel($this->pdo);
        $logs = $model->getRecentLogs(50);

        $this->view('pages/admin/inventory_logs', [
            'logs' => $logs
        ]);
    }

    // -------------------------
    // Helpers
    // -------------------------
    private function view(string $path, array $data = [])
    {
        extract($data);
        include __DIR__ . '/../view/' . $path . '.php';
    }

    private function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }

    private function requireAdmin(): void
    {
    // Admin keys (future/admin)
    $hasAdmin =
        isset($_SESSION['admin_id']) ||
        isset($_SESSION['admin']['admin_id']) ||
        isset($_SESSION['adminId']);

    // Temporary: allow logged-in customers for local testing
    $hasCustomer = isset($_SESSION['customer_id']);

    if (!$hasAdmin && !$hasCustomer) {
        $this->redirect("{$this->base}/admin/login");
         }
    }

}
