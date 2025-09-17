<?php

header("Content-Type: application/json");

require_once "./includes/dbh.inc.php";

if ($_SERVER['REQUEST_METHOD'] === "GET") {

    $sql_query = "SELECT * FROM products";
    $params = [];
    $where = ["visibility = 1"];
    $limit = 6;
    $sortSql = "created_at DESC"; // default sort
    $useRandom = false;


    // search by name 
    if (isset($_GET['search'])) {

        $searchTerm = trim($_GET['search']);
        $where[] = "(name LIKE :search OR description LIKE :search OR category LIKE :search)";
        $params[":search"] = "%$searchTerm%";
        $useRandom = true;
    }

    // filter by category
    if (isset($_GET["category"])) {

        $category = trim($_GET['category']);
        $where[] = "category = :category ";
        $params[":category"] = $category;

        // 👉 Special case: limit for today_deal
        $limit = ($category === "today_deal") ? 6 : 12;
        $useRandom = true;

    }

    // filter by store
    $storeKeys = ["nike", "myStore", "neiva"];
    foreach ($storeKeys as $key) {
        if (isset($_GET[$key])) {
            $category = trim($_GET[$key]); // use the same $category var
            $where[] = "category = :category"; // use same placeholder
            $params[":category"] = $category;  // overwrite if needed
            $limit = 7;
            $useRandom = true;
            break;
        }
    }

    // Sorting
    $allowedSorts = [
        'price_asc' => 'price ASC',
        'price_desc' => 'price DESC',
        'oldest' => 'created_at ASC',
        'newest' => 'created_at DESC',
    ];


    // Append WHERE clause if needed
    if (!empty($where)) {
        $sql_query .= " WHERE " . implode(" AND ", $where);
    }


    // Final ORDER BY clause
    $sql_query .= $useRandom ? " ORDER BY RAND()" : " ORDER BY $sortSql";

    // if it is not a search request set $limit, LIMIT (skip for search)
    if (!isset($_GET['search'])) {
        $sql_query .= " LIMIT $limit";
    }

    try {

        $stmt = $pdo->prepare($sql_query);
        $stmt->execute($params);

        $products = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = [
                'productId' => $row['id'],
                'productSlug' => $row['slug'],
                'productName' => $row['name'],
                'productPrice' => $row['price'],
                'productOldPrice' => $row['old_price'],
                'productImgSrc' => $row['image'],
                'category' => $row['category'],
                'description' => $row['description']
            ];

        }

        echo json_encode($products);
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
