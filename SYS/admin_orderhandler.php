<?php
session_start();
include 'server.php';

// Ensure the orders table exists
$result = $conn->query("SHOW TABLES LIKE 'orders'");
if ($result->num_rows == 0) {
    $query = "CREATE TABLE orders (
                order_id VARCHAR(10) PRIMARY KEY,
                order_details JSON,
                total DOUBLE,
                count INT,
                status VARCHAR(20),
                date VARCHAR(20),
                email VARCHAR(50)
            )";

    $result = $conn->query($query);
    if ($result === false) {
        echo json_encode(array("message" => "Error creating table: " . mysqli_error($conn)));
        return;
    }
}

// Check if user or admin is logged in
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    echo json_encode(array("message" => "You need to login as admin first!"));
    return;
}

$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['id'])) {
        // Fetch details of a specific order
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

    $query = "SELECT * FROM orders";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        echo json_encode($orders);
    } else {
        echo json_encode(array("message" => "No orders found"));
    }
    return;
}

if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    parse_str(file_get_contents("php://input"), $_PUT);
    if (isset($_PUT['id']) && isset($_PUT['status'])) {
        $order_id = mysqli_real_escape_string($conn, $_PUT['id']);
        $status = mysqli_real_escape_string($conn, $_PUT['status']);
        $query = "UPDATE orders SET status='$status' WHERE order_id='$order_id'";

        if ($conn->query($query)) {
            echo json_encode(array("message" => "Order status updated successfully!"));
        } else {
            echo json_encode(array("message" => "Error updating status: " . mysqli_error($conn)));
        }
    } else {
        echo json_encode(array("message" => "Invalid request"));
    }
    return;
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    parse_str(file_get_contents("php://input"), $_DELETE);
    if (isset($_DELETE['id'])) {
        $order_id = mysqli_real_escape_string($conn, $_DELETE['id']);
        $query = "DELETE FROM orders WHERE order_id='$order_id'";

        if ($conn->query($query)) {
            echo json_encode(array("message" => "Order deleted successfully!"));
        } else {
            echo json_encode(array("message" => "Error deleting order: " . mysqli_error($conn)));
        }
    } else {
        echo json_encode(array("message" => "Invalid request"));
    }
    return;
}
?>
