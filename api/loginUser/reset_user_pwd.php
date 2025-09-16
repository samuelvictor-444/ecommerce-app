<?php

declare(strict_types=1);
ob_start();

require_once "../config_session.php";

ini_set('display_errors', 0); // don't output PHP errors to browser
error_reporting(E_ALL);


header("Content-Type: application/json");

function sendJson(array $response): void
{
    if (ob_get_length()) ob_end_clean(); // remove any previous output
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

function sendError(string $message): void
{
    sendJson(["success" => false, "message" => $message]);
}

function sendSuccess($message): void
{
    sendJson(["success" => true, "message" => $message]);
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $userEmail =  htmlspecialchars(trim($_POST["userEmail"]));

    try {

        require_once "../includes/dbh.inc.php";
        require_once "./includes/logIn_modal.inc.php";
        require_once "./includes/logIn_contr.inc.php";


        if (is_email_valid($userEmail)) {
            sendError("invalid email address");
        }

        if (!is_email_registered($userEmail, $pdo)) {
            sendError("No account found with this email");
        }

        if (is_input_empty($userEmail)) {
            sendError("enter your email");
        }

        $user = get_user($userEmail,  $pdo);

        // ✅ Successful login: store session info

        login_user($user['id'], $user['email'], $user['firstName']);

        // Store email in session for OTP verification
        $_SESSION['otp_email'] = $user['email'];

        // reset last activity
        $_SESSION['LAST_ACTIVITY'] = time();
        session_regenerate_id(true);

        require_once "./mask_email.php";
        require_once "../includes/otp_generate.php";
        require_once "../includes/send_email.php";


        // Send OTP or welcome email after login
        $firstName = htmlspecialchars($user['firstName']);
        $subject = "Security Code to Reset Password";
        $body = "<p>Dear {$firstName} You've asked to reset your Aba Price password. Below is your one time passcode that you need to use to reset your password: <strong>$otp</strong></p>";


        $maskedEmail = maskUserEmail($user['email']);


        if (sendEmail($user['email'], $user['firstName'], $subject, $body)) {
            sendSuccess("Insert the security code we sent to your {$maskedEmail} in order to proceed with the password reset. ");
        } else {
            sendError("We couldn't send your OTP email at the moment. Please try again later.");
        }



        $pdo = null;
        $stmt = null;
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
