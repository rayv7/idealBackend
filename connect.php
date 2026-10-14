<?php
$database_url = getenv('MYSQL_URL');

if ($database_url) {
    $dbparts = parse_url($database_url);
    $host = $dbparts['host'];
    $port = $dbparts['port'] ?? 3306;
    $user = $dbparts['user'];
    $password = $dbparts['pass'];
    $dbname = ltrim($dbparts['path'], '/');
} else {
    // Local fallback
    $host = 'localhost';
    $port = 3306;
    $user = 'root';
    $password = '';
    $dbname = 'ideal_db';
}

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    $con = $pdo; 
} catch (PDOException $e) {
    die(json_encode(["error" => "Database connection failed: " . $e->getMessage()]));
}
?>