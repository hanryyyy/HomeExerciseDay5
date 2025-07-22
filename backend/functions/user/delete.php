<?php
include_once(__DIR__ . '/../../layouts/config.php');
include_once(__DIR__ . '/../../../dbconnect.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: index.php");
    exit();
}

// Nếu là POST thì xoá
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "DELETE FROM users WHERE id = $id";
    $conn->query($sql);
    $conn->close();
    header("Location: index.php");
    exit();
}

// Nếu là GET, hiển thị thông tin xác nhận
$sql = "SELECT * FROM users WHERE id = $id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
$conn->close();

if (!$user) {
    echo "User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete User</title>
    <?php include_once(__DIR__ . '/../../layouts/head.php'); ?>
</head>
<body class="d-flex flex-column h-100">
<?php include_once(__DIR__ . '/../../layouts/partials/header.php'); ?>
<div class="container-fluid">
    <div class="row">
        <?php include_once(__DIR__ . '/../../layouts/partials/sidebar.php'); ?>

        <main class="col-md-10 ml-sm-auto px-4 mb-4">
            <div class="pt-4 pb-2 mb-3 border-bottom">
                <h2 class="text-danger">⚠️ Confirm Delete</h2>
            </div>
            <div class="card border-danger">
                <div class="card-body">
                    <p>Are you sure you want to delete this user?</p>
                    <ul class="list-group mb-3">
                        <li class="list-group-item"><strong>ID:</strong> <?= $user['id'] ?></li>
                        <li class="list-group-item"><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></li>
                        <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></li>
                        <li class="list-group-item"><strong>Role:</strong> <?= $user['role'] ?></li>
                    </ul>
                    <form method="POST">
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
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
