<?php

declare(strict_types=1);
ob_start();

require_once __DIR__ . "/../../vendor/autoload.php";
require_once "../config_session.php";
require_once "../includes/dbh.inc.php";
require_once "./includes/logIn_modal.inc.php";
require_once "./includes/logIn_contr.inc.php";

// Ensure session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// JSON header
header("Content-Type: application/json; charset=UTF-8");

// Suppress PHP output
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

// Helper functions
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

function sendSuccess($bool): void
{
    sendJson(["success" => true, "profile_incomplete" => $bool]);
}

// Only POST allowed
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    sendError("Method not allowed");
}

// Read input
$input = file_get_contents("php://input");
$data = json_decode($input, true);

$id_token = $data['id_token'] ?? null;
if (!$id_token) {
    sendError("No token received");
}

try {
    $client = new Google_Client([
        'client_id' => '1006726004609-t3lqnhbig902h5kschcde6kkp8ep7oj0.apps.googleusercontent.com'
    ]);

    $payload = $client->verifyIdToken($id_token);
    if (!$payload || empty($payload['email'])) {
        sendError("Invalid token or email not available");
    }

    $userEmail = $payload['email'];
    $fullName = $payload['name'] ?? '';
    $firstName = "";
    $lastName = "";

    if (!empty($fullName)) {
        $nameParts = explode(" ", $fullName);
        $firstName = $nameParts[0];
        $lastName = count($nameParts) > 1 ? implode(" ", array_slice($nameParts, 1)) : "";
    }

    if (is_email_registered($userEmail, $pdo)) {
        $user = get_user($userEmail, $pdo);
        $stmt = $pdo->prepare("UPDATE users SET lastLogin = NOW() WHERE id = :id");
        $stmt->bindParam(":id", $user['id']);
        $stmt->execute();
        $userId = $user['id'];
    } else {
        $stmt = $pdo->prepare(
            "INSERT INTO users (firstName, lastName, email,lastLogin, isActive)
             VALUES (:firstName, :lastName, :email, NOW(), 1)"
        );
        $stmt->bindParam(":firstName", $firstName);
        $stmt->bindParam(":lastName", $lastName);
        $stmt->bindParam(":email", $userEmail);
        $stmt->execute();
        $userId = (int)$pdo->lastInsertId();

        $user = get_user($userEmail, $pdo);
    }
    $user = get_user($userEmail, $pdo);
    // Set session
    $_SESSION['user_id'] = $userId;
    $_SESSION['user_email'] = $userEmail;
    $_SESSION['user_firstName'] = $firstName;
    $_SESSION['otp_verified'] = true;
    $_SESSION['logged_in'] = true;

    // check if profile is complete
    $needsProfile = empty($user['lastName']) ||  empty($user['dateOfBirth']) || empty($user['phoneNumber']) || empty($user['gender']) || empty($user['userPassword']);

    if ($needsProfile) {
        sendSuccess(true);
    } else {
        sendSuccess(false);
    }
} catch (\Exception $e) {
    sendError("Server error: " . $e->getMessage());
}
