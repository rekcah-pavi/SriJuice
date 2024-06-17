<?php
session_start();
include 'server.php';


function isAdmin() {
    return isset($_SESSION['admin']);
}


$result = $conn->query("SHOW TABLES LIKE 'products'");
if ($result->num_rows == 0) {
    $query = "CREATE TABLE products(
                type VARCHAR(50),
                img_path VARCHAR(255),
                name VARCHAR(50) PRIMARY KEY,
                price DOUBLE
              )";

    $result = $conn->query($query);
    if ($result === false) {
        echo json_encode(array("message" => "Error creating table: " . mysqli_error($conn)));
        exit;
    } else {
        $defaultProducts = [
            ["Featured products", "IMG/apple.jpg", "Apple Juice", 500],
            ["Featured products", "IMG/Matcha-Avocado-Mint-Chip.jpg", "Matcha Smoothie", 500],
            ["Featured products", "IMG/Green-Juice-Recipe-007-735x919.webp", "Green Juice", 400],
            ["Featured products", "IMG/Carrot-Juice-003.webp", "Carrot Juice", 300],
            ["Soup products", "IMG/cheese.jpg", "Cheese Soup", 300],
            ["Soup products", "IMG/25097.jpg", "Oliver Soup", 500],
            ["Soup products", "IMG/chicken-soup-recipe-3.jpg", "Chicken Soup", 500],
            ["Soup products", "IMG/Mushroom-Soup-in-bowl-SQ.webp", "Mushroom Soup", 400],
            ["Sugar free products", "IMG/640x64dfg0.jpg", "Sainsbury Juice", 800],
            ["Sugar free products", "IMG/30012218-8_2-real-activ-100-mixed-fruit-juice.webp", "mixed-fruit juice", 400],
            ["Sugar free products", "IMG/beetroot carrot.png", "red juice", 700],
            ["Sugar free products", "IMG/imagessdfsd.jpeg", "Cranberry Juice", 600]
        ];

        foreach ($defaultProducts as $product) {
            $type = mysqli_real_escape_string($conn, $product[0]);
            $img_path = mysqli_real_escape_string($conn, $product[1]);
            $name = mysqli_real_escape_string($conn, $product[2]);
            $price = mysqli_real_escape_string($conn, $product[3]);

            $query = "INSERT INTO products (type, img_path, name, price) VALUES ('$type', '$img_path', '$name', '$price')";
            if (!$conn->query($query)) {
                echo json_encode(array("message" => "Error inserting product: " . $name . " - " . mysqli_error($conn)));
                exit;
            }
        }
    }
}






if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == 'add') {
        $type = mysqli_real_escape_string($conn, $_POST['type']);
        $img_path = mysqli_real_escape_string($conn, $_POST['img_path']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);

        $query = "INSERT INTO products (type, img_path, name, price) VALUES ('$type', '$img_path', '$name', '$price')";

        if ($conn->query($query)) {
            echo json_encode(array("message" => "Added " . $name . " successfully"));
        } else {
            echo json_encode(array("message" => "Error " . mysqli_error($conn)));
        }
    } elseif ($action == 'edit') {
        $original_name = mysqli_real_escape_string($conn, $_POST['original_name']);
        $type = mysqli_real_escape_string($conn, $_POST['type']);
        $img_path = mysqli_real_escape_string($conn, $_POST['img_path']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);

        $query = "UPDATE products SET type='$type', img_path='$img_path', name='$name', price='$price' WHERE name='$original_name'";

        if ($conn->query($query)) {
            echo json_encode(array("message" => "Updated " . $name . " successfully"));
        } else {
            echo json_encode(array("message" => "Error " . mysqli_error($conn)));
        }
    } elseif ($action == 'delete') {
        $name = mysqli_real_escape_string($conn, $_POST['name']);

        $query = "DELETE FROM products WHERE name='$name'";

        if ($conn->query($query)) {
            echo json_encode(array("message" => "Deleted " . $name . " successfully"));
        } else {
            echo json_encode(array("message" => "Error " . mysqli_error($conn)));
        }
    }

    return;


    
} 

elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] == 'fetch_product') {
    $name = mysqli_real_escape_string($conn, $_GET['name']);
    $query = "SELECT * FROM products WHERE name = '$name'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo json_encode($product);
    } else {
        echo json_encode(null);
    }
    return;
}



elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['fetch_types'])) {
    $query = "SELECT DISTINCT type FROM products";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $types = array();
        while ($row = $result->fetch_assoc()) {
            $types[] = $row['type'];
        }
        echo json_encode($types);
    } else {
        echo json_encode(array("message" => "No product types found"));
    }
    return;
}



elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    $type = isset($_GET['type']) ? mysqli_real_escape_string($conn, $_GET['type']) : '';

    $query = "SELECT * FROM products";
    if ($type) {
        $query .= " WHERE type = '$type'";
    }

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $products = array();
        while ($row = $result->fetch_assoc()) {
            $row['isAdmin'] = isAdmin();
            $products[] = $row;
        }
        echo json_encode($products);
    } else {
        echo json_encode(array("message" => "No products found"));
    }
}
?>
