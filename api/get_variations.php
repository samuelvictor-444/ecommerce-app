<?php

header("Content-Type: application/json");
require_once "./includes/dbh.inc.php";

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (!isset($_GET['slug'])) {
        http_response_code(400);
        echo json_encode(["error" => "Missing product slug"]);
        exit;
    }

    $slug = trim($_GET['slug']);

    try {
        // Get product price
        $productStmt = $pdo->prepare("SELECT price, old_price FROM products WHERE slug = ?");
        $productStmt->execute([$slug]);
        $product = $productStmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            http_response_code(404);
            echo json_encode(["error" => "Product not found"]);
            exit;
        }

        // Get variations
        $variationStmt = $pdo->prepare("
            SELECT 
                pav.attribute_value_id,
                av.value AS value_name,
                attr.name AS attribute_name
            FROM product_attribute_values pav
            JOIN attribute_values av ON pav.attribute_value_id = av.id
            JOIN attributes attr ON av.attribute_id = attr.id
            WHERE pav.product_slug = ?
        ");
        $variationStmt->execute([$slug]);
        $variations = $variationStmt->fetchAll(PDO::FETCH_ASSOC);

        // Attach product prices
        foreach ($variations as &$var) {
            $var['price'] = $product['price'];
            $var['old_price'] = $product['old_price'];
        }

        echo json_encode($variations);
    
        exit;

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Server error: " . $e->getMessage()]);
        exit;
    }

} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "method not allowed"]);
    exit;
}
