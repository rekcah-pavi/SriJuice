<?php
session_start();
include 'server.php';
require 'mail_handler.php';


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


if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    echo json_encode(array("message" => "You need to login as admin first!"));
    return;
}

$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['id'])) {
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
    if (isset($_PUT['id']) && isset($_PUT['status']) && isset($_PUT['email'])) {
        $order_id = mysqli_real_escape_string($conn, $_PUT['id']);
        $status = mysqli_real_escape_string($conn, $_PUT['status']);
        $email = mysqli_real_escape_string($conn, $_PUT['email']);

        $query = "UPDATE orders SET status='$status' WHERE order_id='$order_id'";

        if ($conn->query($query)) {
            $title = 'Update on Your Order Status';
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
                            <h1>Order Status Update</h1>
                        </div>
                        <div class="content">
                            <p>Dear Customer,</p>
                            <p>We are happy to inform you that the status of your order (ID: #' . htmlspecialchars($order_id) . ') has been updated to <strong>' . htmlspecialchars($status) . '</strong>.</p>
                            <p>Thank you for choosing us. We appreciate your business and hope you enjoy your purchase.</p>
                            <p>Best regards,<br>Srijuice Team</p>
                        </div>
                        <div class="footer">
                            <p>&copy; ' . date('Y') . ' Srijuice. All rights reserved.</p>
                        </div>
                    </div>
                </body>
                </html>';

            $result = sendEmail($email, $email, $title, $body);
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
