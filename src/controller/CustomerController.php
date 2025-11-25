<?php

class CustomerController extends BaseController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * handles customer account management after login.
     *
     * responsibilities:
     * - view, add, update, delete personal details
     * - retrieve customer profile data
     */
}

?>
