<?php
$host = getenv('MYSQLHOST') ?: '127.0.0.1';
$user = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: '';
$dbname = getenv('MYSQLDATABASE') ?: 'ideal_db';
$port = getenv('MYSQLPORT') ?: 3306;

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    $con = $pdo; 
} catch (PDOException $e) {
    echo json_encode(["error" => "Detailed PDO Error: " . $e->getMessage()]);
    exit;
}
?>