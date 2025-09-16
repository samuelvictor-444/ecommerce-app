<?php

require_once "../config_session.php";



header("Content-Type: application/json");


function sendError($errorMgs)
{
    if (ob_get_length()) ob_clean();

    $message = ["success" => false, "message" => $errorMgs];
    echo json_encode($message);
    exit;
}

function sendSuccess($successMgs, $user)
{
    if (ob_get_length()) ob_clean();

    $message = ["success" => true, "message" => $successMgs, "user" => $user];
    echo json_encode($message);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (is_logged_in()) {

        if ($_SESSION["otp_verified"] === true) {

            $userEmail = $_SESSION["user_email"];

            require_once "../includes/dbh.inc.php";
            require_once "./includes/logIn_modal.inc.php";

            $user = get_user($userEmail, $pdo);
    
            sendSuccess($user);

        }

    } else {
        sendError("User not loggedin, Please login");
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    exit;
}
