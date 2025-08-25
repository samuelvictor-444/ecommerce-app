<?php

header("Content-Type: application/json");

require_once "./includes/dbh.inc.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $input = json_decode(file_get_contents("php://input"), true);
    $slugs = $input["slugs"] ?? [];

    if (!is_array($slugs) || count($slugs) === 0) {
        echo json_encode([]);
        exit;
    }

    # Prepare placeholders for PDO
    $placeholders = implode(',', array_fill(0, count($slugs), '?'));

    $query = "SELECT id, slug, name , price , old_price , image , old_price FROM products WHERE slug IN ($placeholders)";

    $stmt = $pdo->prepare($query);
    $stmt->execute($slugs);

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $slugIndexMap = array_flip($slugs);

    usort($products, function ($a, $b) use ($slugIndexMap) {
        return $slugIndexMap[$a['slug']] <=> $slugIndexMap[$b['slug']];
    });

    echo json_encode($products);

} else {
    http_response_code(405);
    echo json_encode(['error' => "Method not allowed"]);
    exit;
}
