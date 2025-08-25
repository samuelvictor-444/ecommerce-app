<?php

header("Content-Type: application/json");

require_once "./includes/dbh.inc.php";

if ($_SERVER['REQUEST_METHOD'] === "GET") {

    if (isset($_GET["category"])) {
        $category_slug = trim($_GET["category"]);

        try {
            $query = "SELECT * FROM categories WHERE slug = :slug";

            $stmt= $pdo->prepare($query);
            $stmt->bindParam(":slug" , $category_slug);

            $stmt->execute();

            $desc = [];

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $desc[]  = [
                    "name" => $row["name"],
                    "description" => $row["description"],
                    "success" => true,
                ];
            }

            echo json_encode($desc);
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
