<?php

require_once "./config_session.php";
require_once "./includes/dbh.inc.php";


header('Content-Type: application/json');

function sendError($errorMgs)
{
    if (ob_get_length()) ob_clean();

    $message = ["success" => false, "message" => $errorMgs];
    echo json_encode($message);
    exit;
}

function sendSuccess($successMgs)
{
    if (ob_get_length()) ob_clean();

    $message = ["success" => true, "message" => $successMgs];
    echo json_encode($message);
    exit;
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (is_logged_in()) {

        

    } else {
        http_response_code(401);
        echo json_encode(["success" => false, "message" => "User not logged in"]);
        exit;
    }
} else {


    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        // AJAX request → JSON response
        http_response_code(405);
        echo json_encode(["success" => false, "message" => "Method not allowed"]);
    } else {
        // Normal request → redirect to homepage
        http_response_code(302); // temporary redirect
        header("Location: ../index.php");
    }



    exit;
}
