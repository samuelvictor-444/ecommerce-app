<?php

header("Content-Type: application/json");


if ($_SERVER["REQUEST_METHOD"] == "GET") {


    require_once "./includes/dbh.inc.php";

    if (isset($_GET["slug"])) {

        $slug = trim($_GET["slug"]);

        try {
            # FIRST GET THE CATEGORY ID FROM THE SLUG
            $query = "SELECT id FROM categories WHERE slug = :slug LIMIT 1";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":slug", $slug);

            $stmt->execute();

            $category = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$category) {
                http_response_code(404);
                echo json_encode(['error' => 'Category not found']);
                exit;
            }

            $categoryId = $category['id'];

            # NOW FETCH ALL SUB CATEGORY UNDER THAT CATEGORY

            $stmt = $pdo->prepare("SELECT name , slug , sub_cate_logo FROM subcategories WHERE category_id = :category_id ORDER BY name ASC");
            $stmt->bindParam(":category_id", $categoryId);

            $stmt->execute();

            $subCategories = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $subCategories[] = [
                    "name" => $row["name"],
                    "slug" => $row["slug"],
                    "sub_cate_logo" => $row["sub_cate_logo"],
                ];
            }

            echo json_encode($subCategories);
            exit;

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
            exit;
        }

    } elseif (isset($_GET["slugB"])) {
        $slug = trim($_GET["slugB"]);

        try {
            # FIRST GET THE CATEGORY ID FROM THE SLUG
            $query = "SELECT id FROM categories WHERE slug = :slug LIMIT 1";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":slug", $slug);

            $stmt->execute();

            $category = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$category) {
                http_response_code(404);
                echo json_encode(['error' => 'Category not found']);
                exit;
            }

            $categoryId = $category['id'];

            # NOW FETCH LIMITED SUB CATEGORY UNDER THAT CATEGORY

            $stmt = $pdo->prepare("SELECT slug , subCate_banner , mSubCate_banner FROM subcategories WHERE category_id = :category_id ORDER BY RAND() DESC LIMIT 12");
            $stmt->bindParam(":category_id", $categoryId);

            $stmt->execute();

            $subCategories = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $subCategories[] = [
                    "slug" => $row["slug"],
                    "subCate_banner" => $row["subCate_banner"],
                    "mSubCate_banner" => $row["mSubCate_banner"],
                ];
            }

            echo json_encode($subCategories);
            exit;

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    } elseif (isset($_GET["slugC"])) {
       $slug = trim($_GET['slugC']);

          try {
            # FIRST GET THE CATEGORY ID FROM THE SLUG
            $query = "SELECT id FROM categories WHERE slug = :slug LIMIT 1";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":slug", $slug);

            $stmt->execute();

            $category = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$category) {
                http_response_code(404);
                echo json_encode(['error' => 'Category not found']);
                exit;
            }

            $categoryId = $category['id'];

            # NOW FETCH LIMITED SUB CATEGORY UNDER THAT CATEGORY

            $stmt = $pdo->prepare("SELECT DISTINCT name, slug FROM subcategories WHERE category_id = :category_id ORDER BY RAND() DESC LIMIT 7");
            $stmt->bindParam(":category_id", $categoryId);

            $stmt->execute();

            $subCategories = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $subCategories[] = [
                    "name" => $row["name"],
                    "slug" => $row["slug"],
                ];
            }

            echo json_encode($subCategories);
            exit;

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
            exit;
        }

    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Missing subCategory slug']);
        exit;
    }


} else {
    http_response_code(405);
    echo json_encode(['error' => "Method not allowed"]);
    exit;
}