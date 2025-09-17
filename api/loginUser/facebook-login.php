<?php

declare(strict_types=1);
ob_start();


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

function sendSuccess($bool, $user): void
{
    sendJson(["success" => true, "profile_incomplete" => $bool, "user" => $user]);
}


// Only POST allowed
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = json_decode(file_get_contents("php://input"), true);
    $accessToken = $input["accessToken"] ?? NULL;

    if (!$accessToken) {
        sendError("No access token provided");
    }

    $graphUrl = "https://graph.facebook.com/me?fields=id,name,email,birthday,gender&access_token=" . urlencode($accessToken);
    $fbResponse = file_get_contents($graphUrl);
    $userData = json_decode($fbResponse, true);

    if (isset($userData["error"])) {
        sendError("Invalid Facebook token");
    }

    // get user info
    // $facebookId = $userData["id"];
    $fullName = $userData["name"] ?? "";
    $firstName =  "";
    $lastName = "";
    $userEmail = $userData["email"] ?? null;
    $dateOfBirth = $userData["birthday"] ?? null;
    $userGender = $userData["gender"] ?? null;


    if (!empty($fullName)) {
        $nameParts = explode(" ", $fullName);
        $firstName = $nameParts[0];
        $lastName = count($nameParts) > 1 ? implode(" ", array_slice($nameParts, 1)) : "";
    }


    if (!$userEmail) {
        sendError("Facebook account has no email");
    }


    if ($dateOfBirth) {
        // Facebook birthday is usually MM/DD/YYYY, convert to MySQL YYYY-MM-DD
        $dateOfBirth = date("Y-m-d", strtotime($dateOfBirth));
    } else {
        $dateOfBirth = null; // or set to '0000-00-00'
    }


    $user = get_user($userEmail, $pdo);


    if (is_email_registered($userEmail, $pdo)) {
        $stmt = $pdo->prepare("UPDATE users SET lastLogin = NOW() WHERE id = :id");
        $stmt->bindParam(":id", $user['id']);
        $stmt->execute();
        $userId = $user['id'];
    } else {
        $stmt = $pdo->prepare(
            "INSERT INTO users (firstName, lastName, email, dateOfBirth, gender, lastLogin, isActive)
             VALUES (:firstName, :lastName, :email, :dateOfBirth, :gender,  NOW(), 1)"
        );

        $stmt->bindParam(":firstName", $firstName);
        $stmt->bindParam(":lastName", $lastName);
        $stmt->bindParam(":email", $userEmail);
        $stmt->bindValue(":dateOfBirth", $dateOfBirth, $dateOfBirth ? PDO::PARAM_STR : PDO::PARAM_NULL);
        $stmt->bindValue(":gender", $userGender, $userGender ? PDO::PARAM_STR : PDO::PARAM_NULL);

        $stmt->execute();
        $userId = (int)$pdo->lastInsertId();
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
        sendSuccess(true, $user);
    } else {
        sendSuccess(false, $user);
    }
} else {
    http_response_code(405);
  echo json_encode(["success" => false, "message" => "method not allowed"]);
    exit;
}
