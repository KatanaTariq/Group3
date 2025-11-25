<?php

class ProductController extends BaseController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * handles all product browsing and display features.
     *
     * responsibilities:
     * - search products
     * - apply filters
     * - apply sorting
     * - show product details, variants, and images
     */
}

?>
    