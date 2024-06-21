<?php
include 'server.php';
require 'mail_handler.php';



$result = $conn->query("SHOW TABLES LIKE 'users'");

if ($result->num_rows == 0) {
    $query = "CREATE TABLE users(
                name VARCHAR(20),
                email VARCHAR(50) PRIMARY KEY,
                password TEXT,
                address JSON
            )";

    $result = $conn->query($query);

    if ($result === false) {
        echo "Error creating table: " . mysqli_error($conn);
    } 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['uname']);
    $email = mysqli_real_escape_string($conn, $_POST['mail']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']);

    /*
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../login.php?status=iemail");
        return;
    }
    */


    $hashed_password = hash('sha256', $password);

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");

    if ($result->num_rows > 0) {
        header("Location: ../login.php?status=exist");
        return;
    }

    $query = "INSERT INTO users (name, email, password, address) VALUES ('$name', '$email', '$hashed_password', 'null')";

    if ($conn->query($query)) {

        
        header("Location: ../login.php?status=create");
        $title = 'Your Account Has Been Successfully Registered';
        $body = 'Dear ' . $name . ',<br><br>We are happy to inform you that your account has been created successfully.<br><br>Thank you for registering with us.<br><br>Best regards,<br>Srijuice Team';
        $result = sendEmail($email, $name, $title, $body);
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>
