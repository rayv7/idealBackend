<?php
require 'connect.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$response = ['success' => 0, 'message' => ''];

$category_name = trim($_POST["name"] ?? '');

if (empty($category_name)) {
    $response['message'] = "Category name is required";
    echo json_encode($response);
    exit;
}

try {
    $stmt = $con->prepare("INSERT INTO categories (name) VALUES (?)");
    if ($stmt->execute([$category_name])) {
        $response['success'] = 1;
        $response['message'] = "Category added successfully";
    } else {
        $response['message'] = "Failed to add category";
    }
} catch (PDOException $e) {
    $response['message'] = "Database Error: " . $e->getMessage();
}

echo json_encode($response);