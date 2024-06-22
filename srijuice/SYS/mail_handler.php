<?php


require 'vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($recipientEmail, $recipientName, $subject, $body) {
    $smtp_host= "";
    $smtp_port="587";
    $mail_username="";
    $mail_password= "";


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
        $mail->Body = $body;

        $mail->send();
        return 'Email has been sent successfully';
    } catch (Exception $e) {
        return 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
}
?>
