<?php
session_start();
include_once(__DIR__ . '/../../dbconnect.php');
// get product data
$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];
$image = $_POST['image'];
$category = $_POST['category'];
$quantity = $_POST['quantity'];
if (isset($_SESSION['cart'])) {
    $data = $_SESSION['cart'];
    $data[$id] = [
        'id' => $id,
        'name' => $name,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $image,
        'total' => ($quantity * $price),
        'image' => $image
    ];
} else {
    $data[$id] = [
        'id' => $id,
        'name' => $name,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $image,
        'total' => ($quantity * $price),
        'image' => $image
    ];
}
$SESSION['cart'] = $data;
echo json_encode($_SESSION['cart']);
