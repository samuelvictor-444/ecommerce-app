<?php

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    require_once "./includes/dbh.inc.php";

    if (!isset($_GET['slug']) || empty($_GET['slug'])) {
        echo json_encode(["error" => "No product slug provided"]);
        exit;
    }

    $slug = trim($_GET["slug"]);

    try {
        $query = "SELECT id, subcategory_id FROM products WHERE slug = :slug LIMIT 1";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":slug", $slug);
        $stmt->execute();

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            echo json_encode(["error" => "Product not found"]);
            exit;
        }

        $sub_category = $product["subcategory_id"];

        $relatedProductsQuery = "SELECT * FROM products WHERE subcategory_id = :subcategory_id AND slug != :slug ORDER BY RAND()";
        $stmt2 = $pdo->prepare($relatedProductsQuery);
        $stmt2->bindParam(":subcategory_id", $sub_category);
        $stmt2->bindParam(":slug", $slug);

        $stmt2->execute();

        $related = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode([
            "related" => $related
        ], JSON_PRETTY_PRINT); 
        

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
