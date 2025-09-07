<?php
require_once "../config_session.php";

ini_set('display_errors', 0); // don't output PHP errors to browser
error_reporting(E_ALL);

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $userEmail = trim($_POST["userEmail"]);
    $userPwd = trim($_POST["password"]);

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

        if (is_pwd_empty($userPwd)) {
            sendError("Please provide your password to access your account");
        }

        if (is_input_empty($userEmail)) {
            sendError("enter your email");
        }

        if (is_email_valid($userEmail)) {
            sendError("invalid email address");
        }

        if (!is_email_registered($userEmail, $pdo)) {
            sendError("No account found with this email");
        }

        $user = get_user($userEmail,  $pdo);

        if (is_password_wrong($userPwd, $user["userPassword"])) {
            sendError("Incorrect password. Double-check and try again.");
        }


        // ✅ Successful login: store session info

        login_user($user['id'], $user['email'], $user['firstName']);

        // reset last activity
        $_SESSION['LAST_ACTIVITY'] = time();
        session_regenerate_id(true);


        require_once "../includes/otp_generate.php";
        require_once "../includes/send_email.php";

        // Send OTP or welcome email after login
        $subject = "Your OTP Code";
        $body = "<p>Your OTP code is: <strong>$otp</strong></p>";


        sendEmail($user['email'], $user['firstName'], $subject, $body);

        sendSuccess("Login successful. OTP sent to your email.");

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
