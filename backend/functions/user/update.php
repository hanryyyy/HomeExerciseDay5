<?php
include_once(__DIR__ . '/../../layouts/config.php');
include_once(__DIR__ . '/../../../dbconnect.php');

// Lấy ID từ URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: index.php");
    exit();
}

// Lấy thông tin user
$sql = "SELECT * FROM users WHERE id = $id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit();
}

// Xử lý khi submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $role = $_POST['role'];

    $sqlUpdate = "UPDATE users 
                  SET username='$username', email='$email', address='$address', role='$role'
                  WHERE id = $id";

    if ($conn->query($sqlUpdate) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update User</title>
    <?php include_once(__DIR__ . '/../../layouts/head.php'); ?>
</head>
<body class="d-flex flex-column h-100">
<?php include_once(__DIR__ . '/../../layouts/partials/header.php'); ?>
<div class="container-fluid">
    <div class="row">
        <?php include_once(__DIR__ . '/../../layouts/partials/sidebar.php'); ?>

        <main class="col-md-10 ml-sm-auto px-4 mb-4">
            <div class="pt-4 pb-2 mb-3 border-bottom">
                <h2>Update User</h2>
            </div>
            <div class="card">
                <div class="card-body">
                    <form method="POST">
                        <div class="form-group">
                            <label>Username:</label>
                            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Address:</label>
                            <input type="text" name="address" value="<?= htmlspecialchars($user['address']) ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Role:</label>
                            <select name="role" class="form-control">
                                <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Update</button>
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
