<?php
include 'server.php';
session_start();
$email = $_SESSION['logged_in'];




if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $name = mysqli_real_escape_string($conn, $_POST['uname']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']);
    $hashed_password = hash('sha256', $password);



    $result = $conn->query("select * from users where email = '$email'");

    if ($result->num_rows  > 0) {

        $query = "UPDATE users SET name = '$name', password = '$hashed_password' WHERE email = '$email'";
        
        if ($conn->query($query)) {
            session_start();
            unset($_SESSION['logged_in']);
            header("Location: ../login.php?status=reset");
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
        return;
    }
    else{
        echo "Data not found";
    }



}

?>
