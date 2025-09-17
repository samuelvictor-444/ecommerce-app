<?php

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    if (
        !isset($_GET['state']) || empty(trim($_GET['state'])) ||
        !isset($_GET['lga']) || empty(trim($_GET['lga']))
    ) {
        echo json_encode(["error" => "No Location provided"]);
        exit;
    }

    if (isset($_GET["state"]) && isset($_GET['lga'])) {
        require_once "./includes/dbh.inc.php";

        $state = trim($_GET["state"]);
        $LGAs = trim($_GET["lga"]);

        try {
            $query = "SELECT * FROM delivery_options WHERE state = :state AND lga = :lga AND is_active = 1";

            $stmt = $pdo->prepare($query);

            $stmt->bindParam(":state" , $state);
            $stmt->bindParam(":lga" , $LGAs);

            $stmt->execute();

            $options = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($options ?: []);


        } catch (PDOException $e) {
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