<?php
require 'connect.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$response = ['success' => 0, 'message' => ''];

$fname = trim($_POST["fname"] ?? '');
$sname = trim($_POST["sname"] ?? '');
$phonenum = trim($_POST["phonenum"] ?? '');
$password = trim($_POST["password"] ?? '');
$email = trim($_POST["email"] ?? '');

if (empty($fname) || empty($phonenum) || empty($password)) {
    $response['message'] = "Required fields missing";
    echo json_encode($response);
    exit;
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try {
    // Using PDO prepare and execute
    $stmt = $con->prepare("INSERT INTO users (fname, sname, phonenum, password, email) VALUES (?, ?, ?, ?, ?)");
    
    if ($stmt->execute([$fname, $sname, $phonenum, $hashed_password, $email])) {
        $response['success'] = 1;
        $response['message'] = "User successfully registered";
    } else {
        $response['message'] = "Unable to register user";
    }
} catch (PDOException $e) {
    // Handles duplicate email or phone number entries gracefully
    $response['message'] = "Unable to register user: Phone number or email may already exist";
}

echo json_encode($response);