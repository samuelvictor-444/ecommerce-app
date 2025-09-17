<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

require_once "./includes/dbh.inc.php";

try {
    if ($_SERVER['REQUEST_METHOD'] === "GET") {
        if (isset($_GET["category"])) {
            $category_slug = trim($_GET["category"]);

            $query = "SELECT * FROM categories WHERE slug = :slug";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":slug", $category_slug);
            $stmt->execute();

            $desc = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $desc[] = [
                    "name" => $row["name"],
                    "description" => $row["description"] ?? null,
                    "success" => true,
                ];
            }

            if (empty($desc)) {
                echo json_encode([[
                    "success" => false,
                    "error" => "No category found for slug: $category_slug"
                ]]);
                exit;
            }

            echo json_encode($desc);
            exit;
        }
    }

    http_response_code(405);
   echo json_encode(["success" => false, "message" => "method not allowed"]);
    exit;

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}


