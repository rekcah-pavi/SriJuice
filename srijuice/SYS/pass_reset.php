<?php
session_start();
include 'server.php';
require 'mail_handler.php';

function encrypt($plaintext, $key, $cipher = 'AES-128-CTR') {
    $iv_length = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($iv_length);
    $encrypted = openssl_encrypt($plaintext, $cipher, $key, 0, $iv);
    $encoded = base64_encode($iv . $encrypted);
    return urlencode($encoded);
}

function decrypt($ciphertext, $key, $cipher = 'AES-128-CTR') {
    $decoded = base64_decode(urldecode($ciphertext));
    $iv_length = openssl_cipher_iv_length($cipher);
    $iv = substr($decoded, 0, $iv_length);
    $encrypted = substr($decoded, $iv_length);
    return openssl_decrypt($encrypted, $cipher, $key, 0, $iv);
}

function generateRandomString($length = 5) {
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$key = 'pavi';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        $result = $conn->query("SELECT * FROM users WHERE email = '$email'");

        if ($result->num_rows == 0) {
            echo json_encode(array('success' => false, 'message' => "Email not found"));
            return;
        }
        
        $current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $text = $email . "-" . time();
        $encryptedText = encrypt($text, $key);
        $reset_link = $current_url . '?code=' . $encryptedText;

        $title = "Password Reset";
        $body = '
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; }
                    .container { width: 600px; margin: 0 auto; }
                    .header { background-color: #f8f8f8; padding: 20px; text-align: center; }
                    .content { padding: 20px; }
                    .footer { background-color: #f8f8f8; padding: 10px; text-align: center; font-size: 12px; color: #666; }
                    .button { background-color: #4CAF50; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 16px; }
                    .link { color: #4CAF50; text-decoration: none; }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1>Password Reset Request</h1>
                    </div>
                    <div class="content">
                        <p>Dear User,</p>
                        <p>You have requested to reset your password. Please click the button below to reset your password. Note: The link will expire 10 minutes after this email was sent.</p>
                        <p><a href="' . $reset_link . '" class="button">Reset Password</a></p>
                        <p>If the button above does not work, please click on the link below or copy and paste it into your browser:</p>
                        <p><a href="' . $reset_link . '" class="link">' . $reset_link . '</a></p>
                        <p>If you did not request a password reset, please ignore this email.</p>
                        <p>Best regards,<br>Srijuice Team</p>
                    </div>
                    <div class="footer">
                        <p>&copy; ' . date('Y') . ' Srijuice. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>';

        $result = sendEmail($email, $email, $title, $body);
        echo json_encode(array('success' => true));
    } catch (Exception $e) {
        echo json_encode(array('success' => false, 'message' => $e->getMessage()));
    }
}


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        if (!isset($_GET['code'])) {
            echo "Invalid request";
            return;
        }

        $ttext = $_GET['code'];
        $text = urlencode($ttext);

        
        $decryptedText = decrypt($text, $key);
        if ($decryptedText === false) {
            echo "Invalid or expired code";
            return;
        }

        $words = explode('-', $decryptedText);
        if (count($words) !== 2) {
            echo "Invalid  data";
            return;
        }

        $email = $words[0];
        $otime = $words[1];


        if (time() - $otime > 600) {
            header("Location: ../login.php?status=codexp");
            return;
        }

        $result = $conn->query("SELECT * FROM users WHERE email = '$email'");

        if ($result->num_rows > 0) {
            $rpass = generateRandomString();
            $hashed_password = hash('sha256', $rpass);
            $query = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";
            
            if ($conn->query($query)) {
                header("Location: ../login.php?email=$email&pass=$rpass&status=resetd");
            } else {
                echo "Error changing pass: " . $conn->error;
            }
        } else {
            echo "User not found";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>
