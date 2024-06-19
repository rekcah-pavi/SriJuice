<?php

function getCards() {
    if (isset($_COOKIE['cards'])) {
        return json_decode($_COOKIE['cards'], true);
    }
    return array();
}

function saveCards($cards) {
    setcookie('cards', json_encode($cards), time() + (86400 * 30), "/"); // 30 days
}


$cards = getCards();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars($_POST['title']);
    $price = htmlspecialchars($_POST['price']);
    $img_path = htmlspecialchars($_POST['img_path']);


    foreach ($cards as $card) {
        if ($card['title'] == $title) {
            echo json_encode(array("message" => "You already added " . $title . " to cart"));
            return;
        }
    }

    $cards[] = array(
        'title' => $title,
        'img_path' => $img_path,
        'price' => $price,
        'quantity' => 1
    );

    saveCards($cards);

    echo json_encode(array("message" => "Added " . $title . " successfully"));
} else {
    echo json_encode($cards);
}
?>
