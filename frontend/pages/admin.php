<?php
session_start();

// Nếu chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: /demoshop/frontend/pages/login.php?redirect=admin");
    exit();
}

// Nếu không phải admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>403 - Forbidden</title>
    <link rel="stylesheet" href="/demoshop/assets/css/bootstrap.min.css">
    <style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    .error-container {
        margin-top: 10%;
        text-align: center;
    }
    </style>
</head>

<body>
    <div class="container error-container">
        <h1 class="display-4 text-danger">403 - Không có quyền truy cập</h1>
        <p class="lead">Bạn không có quyền truy cập khu vực quản trị.</p>
        <p>
            Hãy <a href="/demoshop/frontend/pages/login.php?redirect=admin" class="btn btn-sm btn-outline-primary">
                đăng nhập bằng tài khoản quản trị viên
            </a>.
        </p>
    </div>
</body>

</html>

<?php
    exit();
}

// ✅ Nếu là admin → chuyển đến dashboard
header("Location: /demoshop/backend/pages/dashboard.php");
exit();