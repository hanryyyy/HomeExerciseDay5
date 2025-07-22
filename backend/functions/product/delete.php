<?php
include_once(__DIR__ . '/../../layouts/config.php');
include_once(__DIR__ . '/../../../dbconnect.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: index.php");
    exit();
}

// Nếu là POST thì xử lý xoá
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sqlSelect = "SELECT image_url FROM products WHERE id = $id";
    $result = $conn->query($sqlSelect);
    $product = $result->fetch_assoc();

    if ($product) {
        $imagePath = '../../../assets/' . $product['image_url'];
        if (file_exists($imagePath)) {
            unlink($imagePath); // Xoá ảnh
        }

        $sqlDelete = "DELETE FROM products WHERE id = $id";
        $conn->query($sqlDelete);
    }

    $conn->close();
    header("Location: index.php");
    exit();
}

// Lấy thông tin để hiển thị xác nhận
$sql = "SELECT id, name, category FROM products WHERE id = $id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

if (!$product) {
    echo "Product not found.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Product</title>
    <?php include_once(__DIR__ . '/../../layouts/head.php'); ?>
</head>
<body class="d-flex flex-column h-100">
    <!-- Header -->
    <?php include_once(__DIR__ . '/../../layouts/partials/header.php'); ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include_once(__DIR__ . '/../../layouts/partials/sidebar.php'); ?>

            <!-- Main content -->
            <main role="main" class="col-md-10 ml-sm-auto px-4 mb-4">
                <div class="pt-4 pb-2 mb-3 border-bottom">
                    <h1 class="h3 text-danger">⚠️ Confirm Delete</h1>
                </div>

                <div class="card border-danger">
                    <div class="card-body">
                        <p class="mb-4">Are you sure you want to delete the following product?</p>
                        <ul class="list-group mb-3">
                            <li class="list-group-item"><strong>ID:</strong> <?= $product['id'] ?></li>
                            <li class="list-group-item"><strong>Name:</strong> <?= htmlspecialchars($product['name']) ?></li>
                            <li class="list-group-item"><strong>Category:</strong> <?= htmlspecialchars($product['category']) ?></li>
                        </ul>

                        <form method="POST">
                            <div class="mt-3">
                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once(__DIR__ . '/../../layouts/partials/footer.php'); ?>

    <!-- Scripts -->
    <?php include_once(__DIR__ . '/../../layouts/scripts.php'); ?>
</body>
</html>
