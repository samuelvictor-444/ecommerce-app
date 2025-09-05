<?php

header("Content-Type: application");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once "./includes/dbh.inc.php";

    $firstName = htmlspecialchars(trim($_POST["firstName"]));
    $lastName = htmlspecialchars(trim($_POST["LastName"]));
} else {
    http_response_code(405);
    echo json_encode(["error" => "method not allowed"]);
    exit;
}
