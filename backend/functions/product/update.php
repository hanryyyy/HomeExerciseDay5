<?php
include_once(__DIR__ . '/../../layouts/config.php');
include_once(__DIR__ . '/../../../dbconnect.php');

// Lấy ID sản phẩm từ URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: index.php");
    exit();
}

// Lấy dữ liệu sản phẩm
$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

if (!$product) {
    echo "Product not found.";
    exit();
}

// Nếu submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['stock_quantity']);
    $category = $_POST['category'];

    // Xử lý ảnh nếu có upload
    $image_url = $product['image_url'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = '../../../assets/uploads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $target_file = $upload_dir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_url = 'uploads/' . $filename;
        }
    }

    $sqlUpdate = "UPDATE products 
                  SET name='$name', description='$description', price=$price, 
                      stock_quantity=$quantity, image_url='$image_url', category='$category'
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
    <title>Update Product</title>
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
            <main role="main" class="col-md-10 ml-sm-auto px-4 mb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Update Product</h1>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Name:</label>
                                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Description:</label>
                                <textarea name="description" class="form-control" rows="3" required><?= htmlspecialchars($product['description']) ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Price:</label>
                                <input type="number" step="0.01" name="price" class="form-control" value="<?= $product['price'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Stock Quantity:</label>
                                <input type="number" name="stock_quantity" class="form-control" value="<?= $product['stock_quantity'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Category:</label>
                                <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($product['category']) ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Current Image:</label><br>
                                <img src="/demoshop/assets/<?= $product['image_url'] ?>" style="width: 200px;">
                            </div>

                            <div class="form-group">
                                <label>Change Image (optional):</label>
                                <input type="file" name="image" class="form-control-file">
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

    <!-- Footer -->
    <?php include_once(__DIR__ . '/../../layouts/partials/footer.php'); ?>

    <!-- Scripts -->
    <?php include_once(__DIR__ . '/../../layouts/scripts.php'); ?>
</body>
</html>
