<?php

session_start();

if(!isset($_SESSION['logged_in'])){
    echo json_encode(array("error" => "User not logged in"));
    return;

} 


include 'server.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$email = $_SESSION['logged_in'];
$sql = "select * from users where email='$email'";


$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response = json_encode($row);
    echo $response;
} else {
    echo json_encode(array("message" => "User not found"));
}

$conn->close();
?>
