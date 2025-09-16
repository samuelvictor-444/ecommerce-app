<?php 

require_once "../config_session.php"; // your session config

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    logout_user(true); // clears session and cookie
//    echo json_encode(["success" => true, "message" => "Logged out successfully"]);
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
}