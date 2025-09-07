<?php

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $firstName = htmlspecialchars(trim($_POST["firstName"]));
    $lastName = htmlspecialchars(trim($_POST["lastName"]));
    $userEmail = $_POST["email"];
    $userPhone = $_POST["phone"];
    $userDateOfBirth = $_POST["dateOfBirth"];
    $userGender = $_POST["gender"];
    $userPwd = $_POST["password"];


    try {
        // handle error 
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
        require_once "./includes/signUp_modal.inc.php";
        require_once "./includes/signUp_contr.inc.php";

        if (is_input_empty($firstName, $lastName, $userEmail, $userPhone, $userDateOfBirth, $userGender, $userPwd)) {
            sendError("please fill in all input fields");
        }

        if (is_email_vaild($userEmail)) {
            sendError("invalid email address");
        }

        if (is_email_registered($userEmail, $pdo)) {
            sendError("email already exits");
        }

        if (is_phoneNumber_registered($userPhone, $pdo)) {
            sendError("phone Number already exits");
        }

        create_user($pdo, $firstName, $lastName, $userEmail, $userPhone, $userDateOfBirth, $userGender, $userPwd);
        sendSuccess("account created succefully");

        $stmt = null;
        $pdo = null;

        die();
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "method not allowed"]);
    exit;
}
