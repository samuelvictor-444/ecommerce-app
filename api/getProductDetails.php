<?php

header("Content-Type: application/json");

require_once "./includes/dbh.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    if (isset($_GET["slug"])) {
        $productSlug = trim($_GET["slug"]);

        try {

            # fetch product 

            $getProductQuery = "SELECT p.*, EXISTS(
                        SELECT 1 
                        FROM product_attribute_values pav 
                        WHERE pav.product_slug = p.slug 
                        LIMIT 1
                     ) AS has_variation 
                     FROM products p 
                     WHERE p.slug = :slug";

            $stmt = $pdo->prepare($getProductQuery);
            $stmt->bindParam(":slug", $productSlug);

            $stmt->execute();

            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                echo json_encode(["error" => "product not found"]);
            }

            # fecth product image Gallary
            $getProductImg = "SELECT image_url , is_main FROM product_images WHERE product_id = :product_id ORDER BY is_main desc, id ASC";
            $stmtImg = $pdo->prepare($getProductImg);

            $stmtImg->bindParam(":product_id", $product['id']);
            $stmtImg->execute();

            $product['images'] = $stmtImg->fetchAll(PDO::FETCH_ASSOC);

            # Fetch all variations for the product

            $getProductVar = "SELECT a.name AS attribute_name, av.value AS attribute_value FROM product_attribute_values pav 
                                JOIN attribute_values av ON pav.attribute_value_id = av.id  JOIN attributes a ON av.attribute_id = a.id
                                WHERE pav.product_slug = :slug ORDER BY a.name; 
                              ";

            $stmtVar = $pdo->prepare($getProductVar);

            $stmtVar->bindParam(":slug", $product['slug']);

            $stmtVar->execute();

            $variationRaw = $stmtVar->fetchAll(PDO::FETCH_ASSOC);

            $variations = [];

            foreach ($variationRaw as $row) {
                $variations[$row['attribute_name']][] = $row['attribute_value'];
            }

            $product["variation"] = $variations;

            echo json_encode($product);






        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    }


} else {
    http_response_code(405);
    echo json_encode(['error' => "Method not allowed"]);
    exit;
}