<?php
include 'server.php';
session_start();
$email = $_SESSION['logged_in'];



$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);


$email = $_SESSION['logged_in'];


$sql = "UPDATE users SET address = ? WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", json_encode($data), $email);

if ($stmt->execute()) {
    $response = array("status" => "success", "message" => "Address updated successfully");
    echo json_encode($response);
} else {
    $response = array("status" => "error", "message" => "Error updating address: " . $conn->error);
    echo json_encode($response);
}

$stmt->close();
$conn->close();
?>
