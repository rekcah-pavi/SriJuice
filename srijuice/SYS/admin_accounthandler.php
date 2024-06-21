<?php
session_start();
header('Content-Type: application/json');

include 'server.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    echo json_encode(array("message" => "You need to login as admin first!"));
    return;
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT name, email, address FROM users";
    $result = $conn->query($sql);

    $accounts = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $row['address'] = json_decode($row['address']);
            $accounts[] = $row;
        }
    } else {
        echo json_encode([]);
        exit();
    }

    echo json_encode($accounts);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    $email = $data['email'];


    $stmt = $conn->prepare("DELETE FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false, "message" => "Failed to delete account"));
    }

    $stmt->close();
}

$conn->close();
?>

