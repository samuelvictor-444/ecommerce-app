<?php

header("Content-Type: application/json");

require_once "./includes/dbh.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    if (isset($_GET["slug"])) {
        $category = trim($_GET["slug"]);

        try {
             # FIRST GET THE CATEGORY FROM THE SLUG
             $query = "SELECT slug FROM categories WHERE slug = :slug";

             $stmt = $pdo->prepare($query);

             $stmt->bindParam(":slug", $category);

             $stmt->execute();

             $category_slug = $stmt->fetch(PDO::FETCH_ASSOC);
            
             if(!$category_slug) {
                 http_response_code(404);
                echo json_encode(['error' => 'Category not found']);
                exit;
             }

             $categorySlug = $category_slug['slug'];
             
              # NOW FETCH OFFICIAL STORES UNDER THAT CATEGORY

              $stmt = $pdo->prepare("SELECT store_name, store_slug, store_img FROM store WHERE category_slug = :category_slug AND is_official_store = 1 ORDER BY RAND() LIMIT 6");
              $stmt->bindParam(":category_slug", $categorySlug);

              $stmt->execute();

               $officialStores = []; 

             while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                 $officialStores[] = [
                    "store_name" => $row["store_name"],
                    "store_slug" => $row["store_slug"],
                    "store_img" => $row["store_img"],
                 ];
             }

             echo json_encode($officialStores);
             exit;

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