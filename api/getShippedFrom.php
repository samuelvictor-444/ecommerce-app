<?php

header("Content-Type: application/json");

require_once "./includes/dbh.inc.php";

if ($_SERVER['REQUEST_METHOD'] === "GET") {

    if (isset($_GET["category"])) {

        $category = trim($_GET["category"]);

        try {
            $query = "SELECT DISTINCT p.shipped_from_location FROM  products p JOIN categories c ON p.category_id = c.id WHERE c.slug = :slug AND p.shipped_from_location IS NOT NULL AND p.shipped_from_location != '' ";
            $stmt = $pdo->prepare($query);

            $stmt->bindParam(":slug", $category, PDO::PARAM_STR);

            $stmt->execute();

            $result = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = [
                    "shipped_from_location" => $row["shipped_from_location"],
                ];
            }

            echo json_encode($result);
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