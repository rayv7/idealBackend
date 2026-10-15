<?php
require 'connect.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$response = ['success' => 0, 'message' => '', 'data' => []];

$product_id = $_GET['id'] ?? $_POST['id'] ?? null;
$category_id = $_GET['category_id'] ?? $_POST['category_id'] ?? null;

try {
    if ($product_id) {
        $stmt = $con->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
        
        if ($product) {
            $response['success'] = 1;
            $response['data'] = $product;
        } else {
            $response['message'] = "Product not found";
        }
    } elseif ($category_id) {
        $stmt = $con->prepare("SELECT * FROM products WHERE category_id = ?");
        $stmt->execute([$category_id]);
        $products = $stmt->fetchAll();
        
        $response['success'] = 1;
        $response['data'] = $products;
    } else {
        $stmt = $con->query("SELECT * FROM products");
        $products = $stmt->fetchAll();
        
        $response['success'] = 1;
        $response['data'] = $products;
    }
} catch (PDOException $e) {
    $response['message'] = "Database Error: " . $e->getMessage();
}

echo json_encode($response);
?>