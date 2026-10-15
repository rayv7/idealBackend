<?php
require 'connect.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$response = ['success' => 0, 'message' => '', 'user' => null];

$phonenum = trim($_POST["phonenum"] ?? '');
$password = trim($_POST["password"] ?? '');

if (empty($phonenum) || empty($password)) {
    $response['message'] = "Phone number and password are required";
    echo json_encode($response);
    exit;
}

try {
    $stmt = $con->prepare("SELECT * FROM users WHERE phonenum = ?");
    $stmt->execute([$phonenum]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        unset($user['password']); // Strip the password hash before sending data back
        $response['success'] = 1;
        $response['message'] = "Login successful";
        $response['user'] = $user;
    } else {
        $response['message'] = "Invalid phone number or password";
    }
} catch (PDOException $e) {
    $response['message'] = "Database Error: " . $e->getMessage();
}

echo json_encode($response);