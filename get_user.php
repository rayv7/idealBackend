<?php
require 'connect.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$response = ['success' => 0, 'message' => '', 'data' => []];

$id = $_GET['id'] ?? $_POST['id'] ?? null;

try {
    if ($id) {
        $stmt = $con->prepare("SELECT id, fname, sname, phonenum, email FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        
        if ($user) {
            $response['success'] = 1;
            $response['data'] = $user;
        } else {
            $response['message'] = "User not found";
        }
    } else {
        $stmt = $con->query("SELECT id, fname, sname, phonenum, email FROM users");
        $users = $stmt->fetchAll();
        
        $response['success'] = 1;
        $response['data'] = $users;
    }
} catch (PDOException $e) {
    $response['message'] = "Database Error: " . $e->getMessage();
}

echo json_encode($response);