<?php

header('Content-Type: application/json');

require_once "./includes/dbh.inc.php";

if ($_SERVER['REQUEST_METHOD']  === "GET") {

    if (isset($_GET['slug'])) {

        $slug = trim($_GET['slug']);

        try {
            $query = 'SELECT name, slug, seo_title, seo_description FROM categories WHERE slug = :slug LIMIT 1';

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':slug', $slug);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $category = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($category);
                exit;
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Category not found"]);
                exit;
            }

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Missing category slug']);
        exit;
    }

} else {
    http_response_code(405);
    echo json_encode(['error' => "Method not allowed"]);
    exit;
}