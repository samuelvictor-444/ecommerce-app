<?php

header( "Content-Type: application/json");


if ($_SERVER['REQUEST_METHOD'] === "GET") {

    function getLimitedCategory()
    {
        if (isset($_GET["categoryProduct"])) {

            require_once "./includes/dbh.inc.php";
            try {
                $sql_query = "SELECT DISTINCT name , slug , seo_title , seo_description  FROM categories ORDER BY Rand() LIMIT 5";

                $stmt = $pdo->prepare($sql_query);
                $stmt->execute();

                $category = [];

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $category[] = [
                        "ProductCategory" => $row["name"],
                        "productSlug" => $row["slug"],
                    ];
                }


                echo json_encode($category);
                exit;

            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
                exit;
            }

        } # ends if isset($_GET["categoryProduct"];

    } # ends function getCategory();


    getLimitedCategory();

    function getLimitedNavCategory()
    {

        if (isset($_GET['NavLinkCategory'])) {
            require_once "./includes/dbh.inc.php";

            try {
                $sql_query = "SELECT DISTINCT name , slug FROM categories ORDER BY Rand() LIMIT 8";

                $stmt = $pdo->prepare($sql_query);
                $stmt->execute();

                $category = [];

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $category[] = [
                        "ProductCategory" => $row["name"],
                        "productSlug" => $row["slug"],
                    ];
                }

                echo json_encode($category);
                exit;

            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
                exit;
            }
        }
    }

    getLimitedNavCategory();

    function getAllCategory()
    {

    } # ends function getAllCategory;


} else {
    http_response_code(405);
    echo json_encode(['error' => "Method not allowed"]);
    exit;
}