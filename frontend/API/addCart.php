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

$data = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
if (isset($data[$id])) {

    $data[$id]['quantity'] += $quantity;
    $data[$id]['total'] = $data[$id]['quantity'] * $price;
} else {

    $data[$id] = [
        'id' => $id,
        'name' => $name,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $image,
        'category' => $category,
        'total' => ($quantity * $price)
    ];
}
$_SESSION['cart'] = $data;
echo json_encode($_SESSION['cart']);