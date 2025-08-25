<?php

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === "GET") {

    function getLimitedStores()
    {

        if (isset($_GET["limitedStores"])) {
            require_once "./includes/dbh.inc.php";

            try {
                $sql_query = "SELECT id, store_name, store_slug  FROM store WHERE visibility = 1 AND is_official_store = 0 GROUP BY id, store_name, store_slug Order By rand() LIMIT 5";

                $stmt = $pdo->prepare($sql_query);
                $stmt->execute();

                $stores = [];

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $stores[] = [
                        "store_id" => $row["id"],
                        "storeName" => $row["store_name"],
                        "storeSlug" => $row["store_slug"],
                    ];
                }

                echo json_encode($stores);
                exit;

            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
                exit;
            }
        }
    } # ends function getLimitedStores();


    getLimitedStores();


    function getAllStores()
    {

        if (isset($_GET["allStores"])) {
            require_once "./includes/dbh.inc.php";

            try {
                $sql_query = "SELECT * FROM store WHERE visibility = 1 AND is_official_store = 0 GROUP BY store_name, store_slug Order By rand()";

                $stmt = $pdo->prepare($sql_query);
                $stmt->execute();

                $allstores = [];

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $allstores[] = [
                        "store_id" => $row["id"],
                        "storeName" => $row["store_name"],
                        "storeSlug" => $row["store_slug"],
                        "storelogo" => $row["store_logo"],
                    ];
                }

                echo json_encode($allstores);
                exit;

            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
                exit;
            }
        }

    } # ends function get getAllStores();

    getAllStores();

    function getVisibleStores()
    {
        if (isset($_GET['VisibleStores'])) {
            require_once "./includes/dbh.inc.php";

            try {
                $sql_query = "SELECT * FROM store WHERE visibility = 1 GROUP BY store_name, store_slug Order By rand() LIMIT 6";

                $stmt = $pdo->prepare($sql_query);
                $stmt->execute();

                $visibleStores = [];

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $visibleStores[] = [
                        "store_id" => $row["id"],
                        "store_name" => $row["store_name"],
                        "store_slug" => $row["store_slug"],
                        "store_img" => $row["store_img"],
                        "store_description" => $row["description"],
                    ];
                }

                echo json_encode($visibleStores);
                exit;

            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
                exit;
            }
        }
    } # ends function getVisiableStores();

    getVisibleStores();

} else {
    http_response_code(405);
    echo json_encode(["error" => "methos not allowed"]);
    exit;
}