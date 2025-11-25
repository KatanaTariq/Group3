<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h2>Debug Info</h2>";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "<br>";

$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
echo "Parsed Path: " . $requestPath . "<br>";

echo "<br><h2>Testing database connection...</h2>";

if (file_exists(__DIR__ . "/config/database.php")) {
    echo "database.php exists<br>";
    include __DIR__ . "/config/database.php";
    echo "database.php loaded successfully<br>";
    echo "PDO connection exists: " . (isset($pdo) ? "YES" : "NO") . "<br>";
} else {
    echo "database.php NOT FOUND<br>";
}

echo "<br><h2>Checking controller files...</h2>";
$controllers = [
    'BaseController.php',
    'AdminController.php', 
    'AuthController.php'
];

foreach ($controllers as $controller) {
    $path = __DIR__ . '/controller/' . $controller;
    echo $controller . ": " . (file_exists($path) ? "EXISTS" : "MISSING") . "<br>";
}
?>