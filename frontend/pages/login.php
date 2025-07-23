<?php
session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: /demoshop/backend/pages/dashboard.php');
    } else {
        header('Location: /demoshop/frontend/index.php');
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include_once(__DIR__ . '/../../dbconnect.php');
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if (isset($_GET['redirect']) && $_GET['redirect'] === 'admin' && $user['role'] !== 'admin') {
                $error = "Bạn không có quyền truy cập khu vực quản trị.";
            } else {
                if ($user['role'] === 'admin') {
                    header('Location: /demoshop/backend/pages/dashboard.php');
                } else {
                    header('Location: /demoshop/frontend/index.php');
                }
                exit();
            }
        } else {
            $error = "Invalid Username or Password!";
        }
    } else {
        $error = "Invalid Username or Password!";
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php include_once(__DIR__ . '/../layouts/styles.php'); ?>
    <style>
        body {
            background-color: #f5f5f5;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 bg-white p-4 rounded shadow-sm">
            <h2 class="text-center">Login</h2>

            <?php if (isset($error)) : ?>
                <div class="alert alert-danger text-center">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required />
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required />
                </div>
                <div class="mb-4"></div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <p class="text-center mt-3">
                Not a member? <a href="/demoshop/frontend/pages/register.php">Register</a>
            </p>
        </div>
    </div>

    <?php include_once(__DIR__ . '/../layouts/partials/footer.php'); ?>
    <?php include_once(__DIR__ . '/../layouts/scripts.php'); ?>
</body>

</html>