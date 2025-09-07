<?php
require_once "../config_session.php";

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

        function sendSuccess(array $data)
        {
            $message =  array_merge(["success" => true], $data);
            echo json_encode($message);
            exit;
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

        $user = get_user($userEmail,  $pdo);

        if (is_password_wrong($userPwd, $user["userPassword"])) {
            sendError("Incorrect password");
        }

        // ✅ Successful login: store session info
        login_user($user['id'], $user['email'], $user['firstName']);

        // reset last activity
        $_SESSION['LAST_ACTIVITY'] = time();


        $redirect = $_POST['redirect'] ?? 'index.php';
        // Send success + redirect URL
        sendSuccess([
            "message" => "Login successful ✅",
            "redirect" => $_POST['redirect'] ?? 'index.php'
        ]);



        exit;
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
