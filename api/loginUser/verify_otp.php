<?php

require_once "../config_session.php";

ini_set('display_errors', 0); // don't output PHP errors to browser
error_reporting(E_ALL);

header("Content-Type: application/json");

function sendSuccess($redirect = "../index.php")
{
       $message = [
              "success" => true,
              "message" => "OTP verified successfully ✅",
              "redirect" => $redirect
       ];

       echo json_encode($message);
}

function sendError($errorMgs)
{
       $message = ["success" => false, "message" => $errorMgs];
       echo json_encode($message);
       exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

       $userOtp = trim(implode("", $_POST["otp"]));



       if (empty($userOtp)) {
              sendError("Please enter the OTP.");
       }

       if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_time'])) {
              sendError("OTP expired or not generated.");
       }

       if (time() - $_SESSION['otp_time'] > 300) {
              unset($_SESSION['otp']);
              unset($_SESSION['otp_time']);
              sendError("OTP expired. Please request a new one.");
       }

       // ✅ Compare OTP values
       if ((string)$userOtp !== (string)$_SESSION['otp']) {
              sendError(" This verification code is not valid. Please request a new OTP.");
       }

       // Success → mark OTP as verified
       $_SESSION['otp_verified'] = true;

       unset($_SESSION['otp']);
       unset($_SESSION['otp_time']);
       sendSuccess($_POST['redirect'] ?? '../index.php');
} else {
       http_response_code(405);
      echo json_encode(["success" => false, "message" => "method not allowed"]);
       exit;
}
