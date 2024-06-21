<?php
session_start();
include 'server.php';


$result = $conn->query("SHOW TABLES LIKE 'users'");

if ($result->num_rows == 0) {
    header("Location: ../login.php?status=wrong");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['mail'];
    $password = $_POST['pass'];


    if ($email == $admin_email && $password == $admin_pass){
        $_SESSION['admin'] = true;
        setcookie('admin', 'true', time() + (86400 * 30), "/");
        header("Location: ../admin_account.php");
        exit();
    }

    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $result = $conn->query("SELECT password FROM users WHERE email='$email'");
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        if (hash('sha256', $password) == $hashed_password) {
            $_SESSION['logged_in'] = $email;
            header("Location: ../account.php");
            exit();
        } else {
            header("Location: ../login.php?status=wrong");
            exit();
        }
    } else {
        header("Location: ../login.php?status=wrong");
        exit();
    }
}
?>
