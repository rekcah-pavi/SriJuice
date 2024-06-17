<?php
include 'server.php';


$result = $conn->query("show tables like 'users'");

if($result->num_rows == 0) {
    $query = "create table users(
                name varchar(20),
                email varchar(20) primary key,
                password varchar(20),
                address JSON
            )";

           

    $result = $conn->query($query);

    if($result === false) {
        echo "Error creating table: " . mysqli_error($dbConnection);
    } 
   
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $name = mysqli_real_escape_string($conn, $_POST['uname']);
    $email = mysqli_real_escape_string($conn, $_POST['mail']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']);

    $result = $conn->query("select * from users where email = '$email'");

    if ($result->num_rows  > 0) {
        header("Location: ../login.php?status=exist");
        return;
    }

 
    $query = "insert into users (name, email, password, address) VALUES ('$name', '$email', '$password','null')";

    if ($conn->query($query)) {
        header("Location: ../login.php?status=create");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }


}

?>
