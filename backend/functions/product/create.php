<?php
include_once(__DIR__ . '/../../layouts/config.php');
include_once(__DIR__ . '/../../../dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['stock_quantity']);
    $category = $_POST['category'];

    $image_url = '';
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

    $sql = "INSERT INTO products (name, description, price, stock_quantity, image_url, category)
            VALUES ('$name', '$description', $price, $quantity, '$image_url', '$category')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Product</title>
    <?php include_once(__DIR__ . '/../../layouts/head.php'); ?>
</head>
<body class="d-flex flex-column h-100">
    <!-- Header -->
    <?php include_once(__DIR__ . '/../../layouts/partials/header.php'); ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include_once(__DIR__ . '/../../layouts/partials/sidebar.php'); ?>

            <!-- Main Content -->
            <main role="main" class="col-md-10 ml-sm-auto px-4 mb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Create Product</h1>
                </div>

                <!-- Form Content -->
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name">Product Name:</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea name="description" class="form-control" rows="4" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="price">Price:</label>
                                <input type="number" step="0.01" name="price" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="stock_quantity">Stock Quantity:</label>
                                <input type="number" name="stock_quantity" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="category">Category:</label>
                                <input type="text" name="category" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="image">Image:</label>
                                <input type="file" name="image" class="form-control-file" required>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-success">Save</button>
                                <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                                </div>
                        </form>
                    </div>
                </div>
                <!-- End Form Content -->
            </main>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once(__DIR__ . '/../../layouts/partials/footer.php'); ?>

    <!-- Scripts -->
    <?php include_once(__DIR__ . '/../../layouts/scripts.php'); ?>
</body>
</html>
