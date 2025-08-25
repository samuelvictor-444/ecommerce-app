<?php

header("Content-Type: application/json");

function sendSuccess($msg)
{
    $messages = ["success" => true, "message" => $msg];
    echo json_encode($messages);
}


function sendError($msg)
{
    $messages = ["success" => false, "message" => $msg];
    echo json_encode($messages);
}
require_once "./includes/dbh.inc.php";





if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $userEmail = htmlspecialchars($_POST["mobile_subcribers"]);


    if (empty($userEmail)) {
        sendError("please enter your email server");
        exit;
    }

    if ((!filter_var($userEmail, FILTER_VALIDATE_EMAIL))) {
        sendError("invalid email format");
        exit;
    }


    try {
        $checkUserEmail = "SELECT user_email FROM newsletter WHERE user_email = :user_email";

        $stmt = $pdo->prepare($checkUserEmail);
        $stmt->bindParam(":user_email", $userEmail);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            sendError("you have already subcribe ");
            exit;
        } else {
        
                require_once "./includes/dbh.inc.php";

                $query = "INSERT INTO newsletter (user_email) VALUES(:user_email)";

                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":user_email", $userEmail);

                $stmt->execute();

                if ($stmt) {
                    sendSuccess("subcription successfull");
                    exit;
                }

        }

    } catch (PDOException $e) {
        http_response_code(500);
        sendError("Database error " . $e->getMessage());
        exit;
    }



} else {
    http_response_code(405);
    sendError("method not allowed");
    exit;
}