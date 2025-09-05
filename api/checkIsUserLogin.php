<?php
session_start();
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    if(isset($_SESSION["user_id"])) {
        echo json_encode(["success" => true]);
    }else {
         echo json_encode(["success" => false]);
    }

} else {
    http_response_code(405);
    echo json_encode(["error" => "method not allowed"]);
    exit;
}
