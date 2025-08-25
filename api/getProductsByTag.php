<?php

header("Content-Type: application/json");

require_once "./includes/dbh.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    if (!isset($_GET['category'])) {
        http_response_code(400);
        echo json_encode(["error" => "Missing category slug"]);
        exit;
    }

    $categorySlug = trim($_GET['category']);

    try {
        # Get the category ID
        $query = "SELECT id FROM categories WHERE slug = :slug LIMIT 1";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":slug", $categorySlug);
        $stmt->execute();

        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$category) {
            http_response_code(404);
            echo json_encode(["error" => "Category not found"]);
            exit;
        }

        $categoryId = $category["id"];

        # Fetch tags linked to products in this category

        $tagQuery = " SELECT DISTINCT t.id, t.name AS tag_name, t.slug AS tag_slug 
            FROM tags t 
            JOIN product_tags pt ON pt.tag_id = t.id
            JOIN products p ON pt.product_id = p.id 
            WHERE p.category_id = :category_id AND p.visibility = 1 ORDER BY RAND() LIMIT 6";

        $stmt = $pdo->prepare($tagQuery);
        $stmt->bindParam("category_id", $categoryId);
        $stmt->execute();

        $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = [];

        foreach ($tags as $tag) {
            # Get products for each tag
            $tagSql = " SELECT DISTINCT p.id, p.name AS product_name, p.slug, p.price, p.old_price, p.image
                FROM products p
                JOIN product_tags pt ON pt.product_id = p.id
                WHERE pt.tag_id = :tag_id AND p.category_id = :category_id AND p.visibility = 1
                ORDER BY RAND() DESC LIMIT 15";

            $tagStmt = $pdo->prepare($tagSql);
            $tagStmt->bindParam(":tag_id", $tag['id']);
            $tagStmt->bindParam(":category_id", $categoryId);
            $tagStmt->execute();

            $products = $tagStmt->fetchAll(PDO::FETCH_ASSOC);

            if ($products) {
                $result[] = [
                    'tag_name' => $tag['tag_name'],
                    'tag_slug' => $tag['tag_slug'],
                    'products' => $products
                ];
            }
        }

        
        echo json_encode($result);
        exit;

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        exit;
    }

} else {
    http_response_code(405);
    echo json_encode(['error' => "Method not allowed"]);
    exit;
}