<?php
session_start();
include 'server.php';

$result = $conn->query("show tables like 'users'");

if($result->num_rows == 0) {
    header("Location: ../login.php?status=wrong");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['mail'];
    $password = $_POST['pass'];

    if ($email == $admin_email && $password == $admin_pass){
        $_SESSION['admin'] = true;
        header("Location: ../admin_account.php");
        return;

    }


    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $result = $conn->query("select * from users where email='$email' and password='$password'");


    if ($result->num_rows > 0) {
        $_SESSION['logged_in'] = $email;
        header("Location: ../account.php");
    } else {
        header("Location: ../login.php?status=wrong");
    }

   
}
?>
