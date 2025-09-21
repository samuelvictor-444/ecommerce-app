<?php 

require_once "./config_session.php";
require_once "./includes/dbh.inc.php";

ini_set("display_error", 0);
ini_set("log_errors", 1);
error_reporting(E_ALL);


header('Content-Type: application/json');

$logFile =  __DIR__ . "/logs/payment_errors.log";
if (!file_exists(dirname($logFile))) {
    mkdir(dirname($logFile), 0755, true);
}


function logError($errorMgs, $context = [])
{
    $time = date("Y-m-d H:i:s");
    $userId = $context['user_id'] ?? ($_SESSION['user_id'] ?? 'guest');
    $cart = isset($context['cart']) ? json_encode($context['cart']) : 'N/A';

    $logEntry = "[$time] [Payment Error] User: $userId | Cart: $cart | Error: $errorMgs" . PHP_EOL;

    // Write to separate log file
    $logFile = __DIR__ . '/logs/payment_errors.log';
    error_log($logEntry, 3, $logFile);
}

function sendError($errorMgs, $context = [])
{
    if (ob_get_length()) ob_clean();

    // Log the error with optional context
    logError($errorMgs, $context);

    // Send JSON response
    $message = ["success" => false, "message" => $errorMgs];
    echo json_encode($message);
    exit;
}


function sendSuccess($data)
{
    if (ob_get_length()) ob_clean();

    $message = array_merge(["success" => true], $data);
    echo json_encode($message);
    exit;
}

