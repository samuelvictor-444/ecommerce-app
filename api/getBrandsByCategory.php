<?php

header("Content-Type: application/json");

require_once "./includes/dbh.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {


    if (isset($_GET["slug"])) {
        $category = trim($_GET["slug"]);

        try{
            $query = "SELECT name , slug FROM brands WHERE category_slug = :category_slug";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":category_slug" , $category);

            $stmt->execute();

            $brands = [];

            while($row=  $stmt->fetch(PDO::FETCH_ASSOC)) {
                $brands[] = [
                    "name" => $row['name'],
                    "slug" => $row["slug"],
                ];
            }

            

            echo json_encode($brands);
            exit;

        }catch(PDOException $e) {
             http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    }

} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "method not allowed"]);
    exit;
}