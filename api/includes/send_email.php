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
        $mail->SMTPSecure = 'tls';                  // Encryption: 'tls' or 'ssl'
        $mail->Port       = 587;                    // SMTP port

        // Email headers
        $mail->setFrom('abaprice.store@gmail.com', 'Aba Price.com');
        $mail->addAddress($toEmail, $toName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => "Mailer Error: {$mail->ErrorInfo}"
        ]);
        exit;
    }
}
