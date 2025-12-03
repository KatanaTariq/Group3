<?php


$db_server        = '127.0.0.1';    // or 'localhost'
$db_database_name = 'athletiq';   // <-- change to your real DB name
$db_username      = 'root';
$db_password      = '';             // XAMPP default is empty password
$db_port          = 3306;           // you're back on 3306

try {
    $pdo = new PDO(
        "mysql:host={$db_server};dbname={$db_database_name};charset=utf8mb4;port={$db_port}",
        $db_username,
        $db_password
    );

    // Throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Use real prepared statements
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch (PDOException $e) {
    // In a real app you'd log this somewhere, but for dev this is fine
    die('Database connection failed: ' . $e->getMessage());
}

