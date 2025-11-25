<?php

class AuthController extends BaseController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * handles all authentication tasks for the mvp.
     *
     * responsibilities:
     * - login
     * - password reset via security question
     * - session creation and validation using customersession
     * - logout
     */
}

?>
