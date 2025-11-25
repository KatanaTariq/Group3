<?php

class WishlistController extends BaseController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * handles user wishlist functionality.
     *
     * responsibilities:
     * - save products to wishlist
     * - remove products from wishlist
     */
}

?>
