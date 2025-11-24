<?php

require_once __DIR__ . '/../model/Product.php';

class ProductController
{
    /**
     * @var Product
     */
    private $productModel;

    public function __construct()
    {
        // The Product model will use the shared PDO connection from config/database.php
        $this->productModel = new Product();
    }

    /**
     * Show the main product listing (e.g. home / catalogue page).
     * Later this will fetch all products and pass them to the home view.
     */
    public function index(): void
    {
        // TODO (Day 2+):
        // 1. Call $this->productModel->getAllProducts()
        // 2. Pass $products to src/view/pages/home.php
        // Example (later):
        // $products = $this->productModel->getAllProducts();
        // include __DIR__ . '/../view/pages/home.php';
    }

    /**
     * Show a single product’s details page.
     * Later this will fetch the product, its variants and main image.
     *
     * @param int $productId
     */
    public function show(int $productId): void
    {
        // TODO (Day 2+):
        // 1. Call $this->productModel->getProductById($productId)
        // 2. Call $this->productModel->getVariantsForProduct($productId)
        // 3. Optionally call $this->productModel->getMainImageForProduct($productId)
        // 4. Pass $product and $variants to src/view/pages/productDetails.php
        // Example (later):
        // $product  = $this->productModel->getProductById($productId);
        // $variants = $this->productModel->getVariantsForProduct($productId);
        // include __DIR__ . '/../view/pages/productDetails.php';
    }
}
