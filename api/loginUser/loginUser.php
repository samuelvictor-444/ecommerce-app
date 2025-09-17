<?php
require_once "../config_session.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $userEmail = trim($_POST["userEmail"]);

    try {
        function sendError($errorMgs)
        {
            $message = ["success" => false, "message" => $errorMgs];
            echo json_encode($message);
            exit;
        }

        function sendSuccess($successMgs)
        {
            $message = ["success" => true, "message" => $successMgs];
            echo json_encode($message);
        }

        require_once "../includes/dbh.inc.php";
        require_once "./includes/logIn_modal.inc.php";
        require_once "./includes/logIn_contr.inc.php";

        if (is_input_empty($userEmail)) {
            sendError("enter your email");
        }


        if (is_email_valid($userEmail)) {
            sendError("invalid email address");
        }

        if (!is_email_registered($userEmail, $pdo)) {
            sendError("No account found with this email");
        }

        sendSuccess("email is registered ");

        $pdo = null;
        $stmt = null;

        die();
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
