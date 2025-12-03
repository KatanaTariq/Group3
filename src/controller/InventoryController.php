<?php

require_once __DIR__ . '/../model/Inventory.php';
require_once __DIR__ . '/../model/InventoryLog.php';

class InventoryController extends BaseController
{
    private Inventory $inventoryModel;
    private InventoryLog $inventoryLogModel;

    public function __construct(PDO $pdo)
    {
        // Call parent constructor if BaseController defines one
        if (is_callable('parent::__construct')) {
            parent::__construct();
        }

        $this->inventoryModel    = new Inventory($pdo);
        $this->inventoryLogModel = new InventoryLog($pdo);

        // Ensure session is available for flash messages
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Show the main admin inventory page.
     */
    public function index(): void
    {
        $inventoryItems = $this->inventoryModel->getAllInventory();

        // View: src/view/pages/admin/inventory.php
        require __DIR__ . '/../view/pages/admin/inventory.php';
    }

    /**
     * Show recent inventory change logs.
     * Route: /admin/inventory/logs
     */
    public function logs(): void
    {
        $logs = $this->inventoryLogModel->getRecentLogs(50);

        // View: src/view/pages/admin/inventory_logs.php
        require __DIR__ . '/../view/pages/admin/inventory_logs.php';
    }

    /**
     * Handle a stock update request from the admin inventory page.
     * Route: /admin/inventory/update (POST)
     *
     * Includes:
     *  - Input validation
     *  - Flash messages (success/error)
     *  - Inventory logging (old vs new quantity)
     */
    public function updateStock(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $variantId   = isset($_POST['variant_id']) ? (int)$_POST['variant_id'] : null;
        $newQuantity = $_POST['new_quantity'] ?? null;

        // Validate variant ID
        if ($variantId === null || $variantId <= 0) {
            $_SESSION['flash_error'] = 'Invalid variant ID.';
            header('Location: /admin/inventory');
            exit;
        }

        // Validate quantity
        if (!is_numeric($newQuantity) || (int)$newQuantity < 0) {
            $_SESSION['flash_error'] = 'Quantity must be a non-negative number.';
            header('Location: /admin/inventory');
            exit;
        }

        $newQuantity = (int)$newQuantity;

        // Get previous stock (null if record doesn't exist yet)
        $oldStock = $this->inventoryModel->getCurrentStock($variantId);
        if ($oldStock === null) {
            $oldStock = 0;
        }

        // Attempt to update the stock in the database
        $success = $this->inventoryModel->updateStock($variantId, $newQuantity);

        if ($success) {
            // Optional: track which admin did this (if your auth sets admin_id in session)
            $adminId = $_SESSION['admin_id'] ?? null;

            // Best-effort log: if DB is down, this will just fail silently
            $this->inventoryLogModel->createLog(
                $variantId,
                $oldStock,
                $newQuantity,
                $adminId
            );

            $_SESSION['flash_success'] = 'Stock updated successfully.';
        } else {
            $_SESSION['flash_error'] = 'Failed to update stock. Please try again later.';
        }

        // Always redirect back to inventory page (Post/Redirect/Get pattern)
        header('Location: /admin/inventory');
        exit;
    }
}
