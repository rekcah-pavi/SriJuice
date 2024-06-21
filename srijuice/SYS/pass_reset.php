<?php
session_start();
include 'server.php';
require 'mail_handler.php';

function encrypt($plaintext, $key, $cipher = 'AES-128-CTR') {
    $iv_length = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($iv_length);
    $encrypted = openssl_encrypt($plaintext, $cipher, $key, 0, $iv);
    $encoded = urlencode(base64_encode($iv . $encrypted)); 
    return $encoded;
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

        $result = $conn->query("select * from users where email = '$email'");

        if ($result->num_rows == 0) {
            echo json_encode(array('success' => false, 'message' => "Email not found"));
            return;
        }
        
        $current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $text = $email . "-" . time();
        $encryptedText = encrypt($text, $key);
        $title = "Password Reset";
        $body = "Please click the link below to reset your password. Note: The link will expire 10 minutes after this email was sent." . "<br>" . $current_url . '?code=' . $encryptedText;
        $result = sendEmail($email, $email, $title, $body);
        echo json_encode(array('success' => true));
    } catch (Exception $e) {
        echo json_encode(array('success' => false, 'message' => $e->getMessage()));
    }
}


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        $text = $_GET['code'];
        $decryptedText = decrypt($text, $key);
        $words = explode('-', $decryptedText);
        $email = $words[0];
        $otime = $words[1];

        if (time() - $otime > 600){
            header("Location: ../login.php?status=codexp");
            return;

        }

        $result = $conn->query("select * from users where email = '$email'");

        if ($result->num_rows  > 0) {
            $rpass = generateRandomString();
            $hashed_password = hash('sha256', $rpass);
            $query = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";
            
            if ($conn->query($query)) {
                header("Location: ../login.php?email=$email&pass=$rpass&status=resetd");
            } else {
                echo "Error changing pass: " . mysqli_error($conn);
            }
            return;
        }
        else{
            echo "user not found";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }

}


?>


