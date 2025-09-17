<?php

declare(strict_types=1);
ob_start();

require_once "../config_session.php";

ini_set('display_errors', 1); // don't output PHP errors to browser
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

    $userNewPwd = trim($_POST["newPassword"]);
    $userEmail = $_SESSION["user_email"];

    try {
        require_once "../includes/dbh.inc.php";
        require_once "./includes/logIn_modal.inc.php";
        require_once "./includes/logIn_contr.inc.php";

        if (is_pwd_empty($userNewPwd)) {
            sendError("Please provide your password to access your account");
        }

        if (is_input_empty($userEmail)) {
            sendError("No Email provided ");
        }

        if (is_email_valid($userEmail)) {
            sendError("invalid email address");
        }

        if (!is_email_registered($userEmail, $pdo)) {
            sendError("No account found with this email");
        }

        $user = get_user($userEmail,  $pdo);

        $hashedPwd = password_hash($userNewPwd, PASSWORD_DEFAULT);

        $query = "UPDATE users SET userPassword = :newPassword  WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":newPassword", $hashedPwd);
        $stmt->bindParam(":email", $userEmail);
        $stmt->execute();

        // ✅ Successful login: store session info
        login_user($user['id'], $user['email'], $user['firstName']);

        // reset last activity
        $_SESSION['LAST_ACTIVITY'] = time();
        session_regenerate_id(true);

        sendSuccess("Your password has been updated successfully");


        $pdo = null;
        $stmt = null;
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
