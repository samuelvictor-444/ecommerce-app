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

function sendSuccess($successMgs)
{
    if (ob_get_length()) ob_clean();

    $message = ["success" => true, "message" => $successMgs];
    echo json_encode($message);
    exit;
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (is_logged_in()) {

        if ($_SESSION["otp_verified"] === true) {

            $userEmail = $_SESSION["user_email"];
            $userfirstName = htmlspecialchars(trim($_POST['userFirstName']));
            $userLastName = htmlspecialchars(trim($_POST['userLastName']));
            $middleName = htmlspecialchars(trim($_POST['userMiddleName']));
            $userGender = htmlspecialchars(trim($_POST['user_gender']));
            $userDOB = trim($_POST['userDOB']);
            $userPhone = trim($_POST['userPhone']);

            require_once "../includes/dbh.inc.php";
            require_once "./includes/logIn_modal.inc.php";

            $user = get_user($userEmail, $pdo);

            if ($user) {
                $updated_user = update_user_info($userfirstName, $userLastName, $middleName, $userGender, $userDOB, $userPhone, $userEmail, $pdo);

                if ($updated_user) {
                    sendSuccess("Great! Your information was updated");
                } else {
                    sendError("Your profile is already up to date. No changes were necessary.");
                }
            } else {
                sendError("No user account found. Please log in to continue.");
            }


            $stmt = null;
            $pdo = null;
        }
    } else {
        sendError("User not loggedin, Please login");
    }
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "method not allowed"]);
    exit;
}
