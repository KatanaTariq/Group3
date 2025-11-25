<?php

class OrderController extends BaseController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * handles checkout and order processing.
     *
     * responsibilities:
     * - checkout flow and mock payment
     * - create orders and orderlines
     * - show order history and order details
     */
}

?>
