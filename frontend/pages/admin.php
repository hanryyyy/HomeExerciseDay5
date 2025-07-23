<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['username'] !== 'admin') {
    // Chưa đăng nhập hoặc không phải admin, chuyển hướng về trang login
    header('Location: /demoshop/frontend/pages/login.php?redirect=admin');
    exit();
}
// ...admin content...