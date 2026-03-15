<?php

require_once __DIR__ . '/../model/Inventory.php';
require_once __DIR__ . '/../model/InventoryLog.php';

class InventoryController extends BaseController
{
    private Inventory $inventoryModel;
    private InventoryLog $inventoryLogModel;

    public function __construct(PDO $pdo)
    {
        if (is_callable('parent::__construct')) {
            parent::__construct();
        }

        $this->inventoryModel    = new Inventory($pdo);
        $this->inventoryLogModel = new InventoryLog($pdo);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * GET /admin/inventory
     * Show the main admin inventory page.
     */
    public function index(): void
    {
        $inventoryItems = $this->inventoryModel->getAllInventory();
        require __DIR__ . '/../view/pages/admin/inventory.php';
    }

    /**
     * GET /admin/inventory/logs
     * Show recent inventory change logs.
     */
    public function logs(): void
    {
        $logs = $this->inventoryLogModel->getRecentLogs(50);
        require __DIR__ . '/../view/pages/admin/inventory_logs.php';
    }

    /**
     * POST /admin/inventory/update
     * Handle a stock update request from the admin inventory page.
     *
     * Includes:
     *  - CSRF protection
     *  - Input validation
     *  - Flash messages
     *
     * NOTE:
     * Logging is handled inside Inventory::updateStock() (writes to inventorylog),
     * so we do NOT log here to avoid duplicate entries.
     */
    public function updateStock(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // ======================
        // CSRF PROTECTION
        // ======================
        $csrfToken = $_POST['csrf_token'] ?? '';

        if (
            empty($csrfToken) ||
            empty($_SESSION['csrf_token']) ||
            !hash_equals($_SESSION['csrf_token'], $csrfToken)
        ) {
            http_response_code(403);
            $_SESSION['flash_error'] = 'Invalid CSRF token. Please try again.';
            header('Location: /Group3/admin/inventory');
            exit;
        }

        // ======================
        // INPUTS
        // ======================
        $variantId   = isset($_POST['variant_id']) ? (int)$_POST['variant_id'] : 0;
        $newQuantity = $_POST['new_quantity'] ?? null;

        if ($variantId <= 0) {
            $_SESSION['flash_error'] = 'Invalid variant ID.';
            header('Location: /Group3/admin/inventory');
            exit;
        }

        if (!is_numeric($newQuantity) || (int)$newQuantity < 0) {
            $_SESSION['flash_error'] = 'Quantity must be a non-negative number.';
            header('Location: /Group3/admin/inventory');
            exit;
        }

        $newQuantity = (int)$newQuantity;

        // ======================
        // UPDATE DB
        // ======================
        $success = $this->inventoryModel->updateStock($variantId, $newQuantity);

        if ($success) {
            $_SESSION['flash_success'] = 'Stock updated successfully.';
        } else {
            $_SESSION['flash_error'] = 'Failed to update stock. Please try again later.';
        }

        // PRG pattern
        header('Location: /Group3/admin/inventory');
        exit;
    }
}