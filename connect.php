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
    $host = getenv('MYSQLHOST');
    $user = getenv('MYSQLUSER');
    $password = getenv('MYSQLPASSWORD');
    $dbname = getenv('MYSQLDATABASE');
    $port = getenv('MYSQLPORT') ?: 3306;
}

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    $con = $pdo; 
} catch (PDOException $e) {
    echo json_encode([
        "error" => "Connection Refused Debug",
        "message" => $e->getMessage(),
        "host_used" => $host,
        "port_used" => $port
    ]);
    exit;
}
?>