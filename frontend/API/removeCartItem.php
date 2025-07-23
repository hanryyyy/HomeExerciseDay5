<?php
session_start();
include_once(__DIR__ . '/../../dbconnect.php');
$id = $_POST['id'];
if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
    // Đảm bảo key là đúng kiểu
    if (isset($cart[$id])) {
        unset($cart[$id]);
    }
    $_SESSION['cart'] = $cart;
}
echo json_encode($_SESSION['cart']);
