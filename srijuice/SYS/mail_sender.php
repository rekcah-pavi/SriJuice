<?php

require 'vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$smtp_host= "";
$smtp_port="";
$mail_username="";
$mail_password= "";

function sendEmail($recipientEmail, $recipientName, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP(); 
        $mail->Host = $smtp_host; 
        $mail->SMTPAuth = true; 
        $mail->Username = $mail_username; 
        $mail->Password = $mail_password;  
        $mail->SMTPSecure = 'tls'; 
        $mail->Port = $smtp_port; 

        $mail->setFrom('srijuic@lk.rk', 'srijuice');
        $mail->addAddress($recipientEmail, $recipientName); 

        $mail->isHTML(true); 
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return 'Email has been sent successfully';
    } catch (Exception $e) {
        return 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
}

if (isset($argv)) {
    $recipientEmail = $argv[1];
    $recipientName = $argv[2];
    $subject = $argv[3];
    $body = $argv[4];

    sendEmail($recipientEmail, $recipientName, $subject, $body);
}
?>
