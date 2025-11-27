<?php

class InventoryController extends BaseController
{
    private $inventoryModel;

    public function __construct(PDO $pdo)
    {
        // If BaseController has a constructor, pass the PDO to it
        if (method_exists(get_parent_class($this), '__construct')) {
            parent::__construct($pdo);
        }

        // Attach the Inventory model (src/model/Inventory.php)
        $this->inventoryModel = new Inventory($pdo);
    }

    /**
     * Show the main admin inventory page.
     * Currently uses Inventory::getAllInventory() to fetch data.
     */
    public function index(): void
    {
        // Fetch all inventory rows (you’ll define this in Inventory.php)
        $inventoryItems = $this->inventoryModel->getAllInventory();

        // Load the view: src/view/pages/admin/inventory.php
        require __DIR__ . '/../view/pages/admin/inventory.php';
    }

    /**
     * Placeholder for updating stock from a form submission.
     * Later this will read $_POST and call Inventory::updateStock().
     */
    public function updateStock(): void
    {
        // Example of future logic:
        // $variantId   = $_POST['variant_id'] ?? null;
        // $newQuantity = $_POST['new_quantity'] ?? null;
        //
        // if ($variantId && $newQuantity !== null) {
        //     $this->inventoryModel->updateStock((int)$variantId, (int)$newQuantity);
        // }

        // Redirect back to the inventory page after handling the update
        header('Location: /admin/inventory');
        exit;
    }
}
