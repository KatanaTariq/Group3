<?php

class ReviewController extends BaseController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * handles product reviews.
     *
     * responsibilities:
     * - submit ratings and written reviews
     * - retrieve reviews for product pages
     */
}

?>
