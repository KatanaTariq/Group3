<?php

class BasketController extends BaseController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * handles user shopping basket operations.
     *
     * responsibilities:
     * - add, remove, update basket items
     * - calculate and display basket subtotal
     */
}

?>
