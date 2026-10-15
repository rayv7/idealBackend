<?php
require 'connect.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$response = ['success' => 0, 'message' => ''];

$name = trim($_POST["name"] ?? '');
$price = trim($_POST["price"] ?? '');
$category_id = trim($_POST["category_id"] ?? '');
$description = trim($_POST["description"] ?? '');
$image_url = trim($_POST["image_url"] ?? '');

if (empty($name) || empty($price)) {
    $response['message'] = "Product name and price are required";
    echo json_encode($response);
    exit;
}

try {
    $stmt = $con->prepare("INSERT INTO products (name, price, category_id, description, image_url) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$name, $price, $category_id, $description, $image_url])) {
        $response['success'] = 1;
        $response['message'] = "Product added successfully";
    } else {
        $response['message'] = "Failed to add product";
    }
} catch (PDOException $e) {
    $response['message'] = "Database Error: " . $e->getMessage();
}

echo json_encode($response);