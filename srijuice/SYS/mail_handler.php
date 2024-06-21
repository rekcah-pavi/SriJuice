<?php
function sendEmail($recipientEmail, $recipientName, $subject, $body) {
    $recipientEmail = escapeshellarg($recipientEmail);
    $recipientName = escapeshellarg($recipientName);
    $subject = escapeshellarg($subject);
    $body = escapeshellarg($body);

    $command = "php mail_sender.php $recipientEmail $recipientName $subject $body > /dev/null &";
    exec($command);
}

?>
