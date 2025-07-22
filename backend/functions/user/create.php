<?php
include_once(__DIR__ . '/../../layouts/config.php');
include_once(__DIR__ . '/../../../dbconnect.php');

// Xử lý submit form
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $address = trim($_POST['address']);
    $role = $_POST['role'];

    // Kiểm tra username hoặc email đã tồn tại
    $sqlCheck = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = $conn->query($sqlCheck);
    if ($result->num_rows > 0) {
        $errors[] = "Username or email already exists.";
    } else {
        // Hash mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Thêm vào database
        $sqlInsert = "INSERT INTO users (username, password, email, address, role)
                      VALUES ('$username', '$hashedPassword', '$email', '$address', '$role')";
        if ($conn->query($sqlInsert) === TRUE) {
            header("Location: index.php");
            exit();
        } else {
            $errors[] = "Lỗi thêm user: " . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create User</title>
    <?php include_once(__DIR__ . '/../../layouts/head.php'); ?>
</head>

<body class="d-flex flex-column h-100">
    <?php include_once(__DIR__ . '/../../layouts/partials/header.php'); ?>

    <div class="container-fluid">
        <div class="row">
            <?php include_once(__DIR__ . '/../../layouts/partials/sidebar.php'); ?>

            <main class="col-md-10 ml-sm-auto px-4 mb-4">
                <div class="pt-4 pb-2 mb-3 border-bottom">
                    <h2>Create New User</h2>
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $e): ?>
                            <p><?= $e ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label>Username:</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Email:</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Password:</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Address:</label>
                                <input type="text" name="address" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Role:</label>
                                <select name="role" class="form-control">
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php include_once(__DIR__ . '/../../layouts/partials/footer.php'); ?>
    <?php include_once(__DIR__ . '/../../layouts/scripts.php'); ?>
</body>

</html>