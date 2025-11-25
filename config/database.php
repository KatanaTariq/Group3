<?php

// load database credentials
include __DIR__ . '/../setup/config.php';

try {
    $pdo = new PDO(
        "mysql:host=$db_server;dbname=$db_database_name;charset=utf8mb4;port=3306",
        $db_username,
        $db_password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch (PDOException $e) {
    die("connection failed: " . $e->getMessage());
}

?>
