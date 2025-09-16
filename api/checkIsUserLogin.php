<?php
require_once "./config_session.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "GET") {


    if (is_logged_in()) {

        if ($_SESSION["otp_verified"] === true) {
            echo json_encode(["success" => true, "userFirstName" => $_SESSION['user_firstName']]);
        } else {
            // User logged in but OTP not verified
            echo json_encode([
                "success" => false, "message" => "User logged in but OTP not verified"
            ]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "User not loggedin"]);
    }
} else {
    http_response_code(405);
    echo json_encode( ["success" => false, "message" => "method not allowed"]);
    exit;
}
