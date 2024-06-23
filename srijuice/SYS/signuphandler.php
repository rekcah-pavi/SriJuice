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

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../login.php?status=iemail");
        return;
    }

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
        $body = '
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; }
                    .container { width: 600px; margin: 0 auto; }
                    .header { background-color: #f8f8f8; padding: 20px; text-align: center; }
                    .content { padding: 20px; }
                    .footer { background-color: #f8f8f8; padding: 10px; text-align: center; font-size: 12px; color: #666; }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1>Account Registration Successful</h1>
                    </div>
                    <div class="content">
                        <p>Dear ' . htmlspecialchars($name) . ',</p>
                        <p>We are happy to inform you that your account has been created successfully. Thank you for registering with us.</p>
                        <p>If you have any questions or need further assistance, please feel free to contact our support team.</p>
                        <p>Best regards,<br>Srijuice Team</p>
                    </div>
                    <div class="footer">
                        <p>&copy; ' . date('Y') . ' Srijuice. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>';

        $result = sendEmail($email, $name, $title, $body);
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

?>
