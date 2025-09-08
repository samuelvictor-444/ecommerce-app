<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__  . "/../../vendor/autoload.php";

/**
 * Send an email using PHPMailer
 *
 * @param string $toEmail Recipient email
 * @param string $toName Recipient name
 * @param string $subject Email subject
 * @param string $body HTML body of the email
 * @return void
 */


function sendEmail($toEmail, $toName, $subject, $body)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  // 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'abaprice.store@gmail.com'; // SMTP username
        $mail->Password = 'gftbdfugawdjuofz';        // SMTP password
        $mail->SMTPSecure = 'ssl';                  // Encryption: 'tls' or 'ssl'
        $mail->Port       = 465;                    // SMTP port

        // Email headers
        $mail->setFrom('abaprice.store@gmail.com', 'Aba Price.com');
        $mail->addAddress($toEmail, $toName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
    } catch (Exception $e) {
    error_log("Email sending failed: " . $e->getMessage());


        // Friendly error message for the user
        echo json_encode([
            'success' => false,
            'message' => "We couldn't send your OTP email at the moment. Please try again later."
        ]);
        exit;
    }
}
