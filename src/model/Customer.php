<?php

/**
 * Customer entity represents a single customer.
 */
class Customer
{
    private int $customer_id;
    private string $email;
    private string $password_hash;
    private string $first_name;
    private string $last_name;

    public function __construct(array $data)
    {
        $this->customer_id   = $data['customer_id'];
        $this->email         = $data['email'];
        $this->password_hash = $data['password_hash'];
        $this->first_name    = $data['first_name'];
        $this->last_name     = $data['last_name'];
    }

    public function getID(): int
    {
        return $this->customer_id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->password_hash;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }
}

/**
 * CustomerModel handles all database operations for customers.
 */
class CustomerModel
{
    private PDO $database;

    public function __construct(PDO $database)
    {
        $this->database = $database;
    }

    /**
     * find a customer by email
     */
    public function getCustomerByEmail(string $email): ?Customer
    {
        $query = "SELECT customer_id, email, password_hash, first_name, last_name
                  FROM customer
                  WHERE email = :email
                  LIMIT 1";

        $statement = $this->database->prepare($query);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);

        if ($statement->execute()) {
            $data = $statement->fetch(PDO::FETCH_ASSOC);
            return $data ? new Customer($data) : null;
        }

        return null;
    }

    /**
     * find a customer by ID
     */
    public function getCustomerByID(int $id): ?Customer
    {
        $query = "SELECT customer_id, email, password_hash, first_name, last_name
                  FROM customer
                  WHERE customer_id = :id
                  LIMIT 1";

        $statement = $this->database->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        if ($statement->execute()) {
            $data = $statement->fetch(PDO::FETCH_ASSOC);
            return $data ? new Customer($data) : null;
        }

        return null;
    }

    /**
     * register a new customer
     */
    public function registerCustomer(array $userData): ?Customer
    {
        $query = "INSERT INTO customer (email, password_hash, first_name, last_name)
                  VALUES (:email, :password_hash, :first_name, :last_name)";

        $statement = $this->database->prepare($query);

        $statement->bindParam(':email',         $userData['email'],         PDO::PARAM_STR);
        $statement->bindParam(':password_hash', $userData['password_hash'], PDO::PARAM_STR);
        $statement->bindParam(':first_name',    $userData['first_name'],    PDO::PARAM_STR);
        $statement->bindParam(':last_name',     $userData['last_name'],     PDO::PARAM_STR);

        if ($statement->execute()) {
            return $this->getCustomerByEmail($userData['email']);
        }

        return null;
    }
}

?>