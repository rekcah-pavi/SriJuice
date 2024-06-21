<?php
session_start();

include 'server.php';

$result = $conn->query("SHOW TABLES LIKE 'orders'");

if ($result->num_rows == 0) {
    $query = "CREATE TABLE orders (
            order_id VARCHAR(10) PRIMARY KEY,
            order_details JSON,
            total DOUBLE,
            count INT,
            status VARCHAR(20),
            date VARCHAR(20),
            email VARCHAR(50),
            FOREIGN KEY (email) REFERENCES users(email) ON DELETE CASCADE
    )";

    $result = $conn->query($query);

    if ($result === false) {
        echo "Error creating table: " . mysqli_error($conn);
        return;
    }
}

if (!isset($_SESSION['logged_in'])) {
    echo json_encode(array("message" => "You need to login first!"));
    return;
}

$email = $_SESSION['logged_in'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = rand(1000, 9999);
    $status = 'processing';
    date_default_timezone_set('Asia/Colombo');
    $date = date('j/n/Y');
    $order_details = mysqli_real_escape_string($conn, $_POST['orderDetails']);
    $total = mysqli_real_escape_string($conn, $_POST['total']);
    $count = mysqli_real_escape_string($conn, $_POST['count']);

    $query = "INSERT INTO orders (order_id, email, status, date, order_details, total, count) 
              VALUES ('$order_id', '$email', '$status', '$date', '$order_details', '$total', '$count')";

    if ($conn->query($query)) {
        echo json_encode(array("message" => "Order #".$order_id." Placed Sucessfully!"));
    } else {
        echo json_encode(array("message" => "Error: " . mysqli_error($conn)));
    }
    return;
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $order_id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM orders WHERE order_id = '$order_id'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $order_details = $result->fetch_assoc();
        echo json_encode($order_details);
    } else {
        echo json_encode(array("message" => "Order not found"));
    }
    return;
}


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = "SELECT * FROM orders WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }

        echo json_encode($orders);
        
    } else {
        echo json_encode(array("message" => "Order not found"));
    }
    return;
}

?>
