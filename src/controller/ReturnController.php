<?php

class ReturnController extends BaseController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * handles customer return requests.
     *
     * responsibilities:
     * - submit and manage product return requests
     */
}

?>
