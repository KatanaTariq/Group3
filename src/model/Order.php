<?php
class Order
{
    private PDO $pdo;
    private int $customerID;

    /**
     * Initialises the Order model
     * @param PDO $pdo the active database connection
     * @param int $customerID the unique id of the customer
     */
    public function __construct(PDO $pdo, int $customerID)
    {
        $this->pdo = $pdo;
        $this->customerID = $customerID;
    }

    /**
     * Retrieves the complete order history for the logged-in customer.
     * Used for the "Order History" account page.
     * @return array List of orders sorted by most recent
     */
    public function getOrderHistory(): array
    {
        $sql = "SELECT order_id, order_number, total_amount, status, created_at
                FROM `order`
                WHERE customer_id = :customer_id
                ORDER BY created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['customer_id' => $this->customerID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves detailed information for a single order, including all items purchased.
     * This supports your "Returns and Review system" responsibility by identifying specific variants.
     * @param int $orderID
     * @return array|bool Order details with items, or false if unauthorised
     */
    public function getOrderDetails(int $orderID): array|bool
    {
        // Security check: Ensure the order actually belongs to this customer
        $sql = "SELECT o.*, sa.street AS shipping_address, ba.street AS billing_address
                FROM `order` o
                LEFT JOIN address sa ON o.shipping_address_id = sa.address_id
                LEFT JOIN address ba ON o.billing_address_id = ba.address_id
                WHERE o.order_id = :order_id AND o.customer_id = :customer_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'order_id' => $orderID,
            'customer_id' => $this->customerID
        ]);

        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            return false;
        }

        // Retrieve the individual items (order_line rows) for this order
        $itemSql = "SELECT ol.*, p.name AS product_name, pv.size, pv.colour, pv.sku
                    FROM order_line ol
                    JOIN product_variant pv ON ol.variant_id = pv.variant_id
                    JOIN product p ON pv.product_id = p.product_id
                    WHERE ol.order_id = :order_id";

        $itemStmt = $this->pdo->prepare($itemSql);
        $itemStmt->execute(['order_id' => $orderID]);
        $order['items'] = $itemStmt->fetchAll(PDO::FETCH_ASSOC);

        return $order;
    }

    /**
     * Updates the status of an existing order.
     * Supports backend logic for 'Cancelled' or 'Shipped' states.
     * @param int $orderID
     * @param string $newStatus
     * @return bool
     */
    public function updateOrderStatus(int $orderID, string $newStatus): bool
    {
        $allowedStatuses = ['PENDING', 'PROCESSING', 'SHIPPED', 'DELIVERED', 'CANCELLED'];

        if (!in_array($newStatus, $allowedStatuses, true)) {
            throw new InvalidArgumentException("Invalid order status.");
        }

        $sql = "UPDATE `order`
                SET status = :status, updated_at = NOW()
                WHERE order_id = :order_id AND customer_id = :customer_id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'status' => $newStatus,
            'order_id' => $orderID,
            'customer_id' => $this->customerID
        ]);
    }

    /**
     * Helper method to verify if a customer has purchased a specific variant.
     * Useful for the "Review system" to ensure only verified buyers can leave feedback.
     * @param int $variantID
     * @return bool
     */
    public function hasPurchasedVariant(int $variantID): bool
    {
        $sql = "SELECT COUNT(*)
                FROM order_line ol
                JOIN `order` o ON ol.order_id = o.order_id
                WHERE o.customer_id = :customer_id
                AND ol.variant_id = :variant_id
                AND o.status = 'DELIVERED'";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'customer_id' => $this->customerID,
            'variant_id' => $variantID
        ]);

        return (int)$stmt->fetchColumn() > 0;
    }
}
?>