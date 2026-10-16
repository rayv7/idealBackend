<?php
require 'connect.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$response = ['success' => 0, 'message' => '', 'data' => []];

$category_id = $_GET['category_id'] ?? $_POST['category_id'] ?? null;

try {
    if ($category_id) {
        // Fetch a single category by ID
        $stmt = $con->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$category_id]);
        $category = $stmt->fetch();
        
        if ($category) {
            $response['success'] = 1;
            $response['data'] = $category;
        } else {
            $response['message'] = "Category not found";
        }
    } else {
        // Fetch all categories
        $stmt = $con->query("SELECT * FROM categories");
        $categories = $stmt->fetchAll();
        
        $response['success'] = 1;
        $response['data'] = $categories;
    }
} catch (PDOException $e) {
    $response['message'] = "Database Error: " . $e->getMessage();
}

echo json_encode($response);