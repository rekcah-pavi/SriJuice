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
        $order_items = json_decode($_POST['orderDetails'], true);

        $order_details_formatted = '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Price (LKR)</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
        $total_lkr = 0;
        foreach ($order_items as $item) {
            $order_details_formatted .= '<tr>
                                            <td>' . $item['title'] . '</td>
                                            <td>' . $item['price'] . '</td>
                                            <td>' . $item['quantity'] . '</td>
                                        </tr>';
            $total_lkr += $item['price'] * $item['quantity'];
        }
        $order_details_formatted .= '</tbody></table>';

        $title = 'Your Order Confirmation - Order #' . $order_id;
        $body = '
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; }
                    .container { width: 600px; margin: 0 auto; }
                    .header { background-color: #f8f8f8; padding: 20px; text-align: center; }
                    .content { padding: 20px; }
                    .footer { background-color: #f8f8f8; padding: 10px; text-align: center; font-size: 12px; color: #666; }
                    .order-details { border: 1px solid #ddd; padding: 10px; margin-top: 20px; }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1>Order Confirmation</h1>
                    </div>
                    <div class="content">
                        <p>Dear Customer,</p>
                        <p>We are pleased to inform you that your order has been placed successfully. Here are the details of your order:</p>
                        <div class="order-details">
                            <p><strong>Order ID:</strong> #' . $order_id . '</p>
                            <p><strong>Status:</strong> ' . $status . '</p>
                            <p><strong>Date:</strong> ' . $date . '</p>
                            ' . $order_details_formatted . '
                            <p><strong>Total:</strong> ' . $total_lkr . ' LKR</p>
                        </div>
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
