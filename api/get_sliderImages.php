<?php

header("Content-Type: application/json");

require_once "./includes/dbh.inc.php";

if ($_SERVER['REQUEST_METHOD'] === "GET") {

    $sql_query = "SELECT * FROM slider_banner";
    $params = [];
    $where = ["visibility = 1"];
    $limit = 6;
    $sortSql = "created_at DESC"; // default sort



    if (isset($_GET["category"])) {

        $category = trim($_GET["category"]);
        $where[] = "category = :category ";
        $params[":category"] = $category;

        // 👉 Special case: limit for home page banner images
        if ($category === "homepage_slider") {
            $limit = 6;
        } elseif ($category === "headerBanner") {
            $limit = 1;
        } elseif ($category === "mobileBanner") {
            $limit = 1;
        } elseif ($category === "sideBanner") {
            $limit = 4;
        } elseif ($category === "mobileSliderImg") {
            $limit = 6;
        } else {
            $limit = 4;
        }
    }

    // Append WHERE clause if needed
    if (!empty($where)) {
        $sql_query .= " WHERE " . implode(" AND ", $where);
    }

    $sql_query .= "ORDER BY $sortSql LIMIT $limit";


    try {
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute($params);

        $banner = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $banner[] = [
                "id" => $row["id"],
                "banner_title" => $row["banner_title"],
                "banner_image" => $row["banner_image"],
            ];
        }

        echo json_encode($banner);
        exit;

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        exit;
    }


} else {
    http_response_code(405);
    echo json_encode(['error' => 'method not allowed']);
    exit;
}