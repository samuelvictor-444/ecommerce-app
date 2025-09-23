<?php

require_once "../config_session.php";

ini_set('display_errors', 0); // don't output PHP errors to browser
error_reporting(E_ALL);

header('Content-Type: application/json');

function sendSuccess($successMgs, $userEmail)
{
    if (ob_get_length()) ob_clean();
    $message = ["success" => true, "message" => $successMgs, "user_email" => $userEmail];
    echo json_encode($message);
}

function sendError($errorMgs)
{
    if (ob_get_length()) ob_clean();
    $message = ["success" => false, "message" => $errorMgs];
    echo json_encode($message);
    exit;
}

if (is_logged_in()) {
    if (isset($_SESSION['user_email'])) {
        $input = json_decode(file_get_contents("php://input"), true);
        $type = $input["type"] ?? "email";

        $userEmail = $_SESSION['user_email'];

        require_once "../includes/dbh.inc.php";
        require_once "./includes/logIn_modal.inc.php";
        require_once "./includes/logIn_contr.inc.php";
        require_once "../includes/otp_generate.php";
        require_once "../includes/send_email.php";
        require_once "../includes/send_otpSms.php";
        require_once "./mask_email.php";

        $user = get_user($userEmail,  $pdo);

        if (!$user) {
            echo json_encode([
                'success' => false,
                'message' => 'User not found'
            ]);
            exit;
        }


        if ($type === "email") {
            $subject = "Your OTP Code resend";
            $body = "<p>Your OTP code is: <strong>$otp</strong></p>";

            $maskedEmail = maskUserEmail($user['email']);


            if (sendEmail($user['email'], $user['firstName'], $subject, $body)) {
                sendSuccess("We have resent a verification code to {$maskedEmail}", $user['email']);
            } else {
                sendError("We couldn't resend your OTP email at the moment. Please try again later.");
            }

            $pdo = null;
        } elseif ($type === "sms") {
            sendError("SMS OTP not implemented yet. Will be enabled once wallet is funded.");
        }
    } else {

        sendError("Email not provided");
    }
} else {
    sendError("user not logged in");
}
