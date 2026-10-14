<?
header('Content-Type: application/json');
echo json_encode([
    "host" => getenv('MYSQLHOST'),
    "user" => getenv('MYSQLUSER'),
    "database" => getenv('MYSQLDATABASE'),
    "port" => getenv('MYSQLPORT'),
    "has_password" => getenv('MYSQLPASSWORD') ? true : false
]);
?>