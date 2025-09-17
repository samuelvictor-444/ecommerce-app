<?php
header("Content-Type: application/json");

require_once "./includes/dbh.inc.php";

if ($_SERVER['REQUEST_METHOD'] === "GET") {

    try {
        $query = "SELECT * FROM promoted_ads WHERE visibility = 1 ORDER BY created_at DESC LIMIT 2";

        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $ads = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ads[] = [
                "storeSlug" => $row["store_slug"],
                "image" => $row["image"],
                "title" => $row["title"],
            ];
        }

        echo json_encode($ads);
        exit;



    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        exit;
    }

} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "method not allowed"]);
    exit;
}