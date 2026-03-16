<?php
    
class Admin
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Find admin record by email.
     * Expects columns: admin_id, email, password_hash
     * Table: admin
     */
    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT admin_id, email, password_hash FROM admin WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
}

?>
