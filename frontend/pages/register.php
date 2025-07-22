<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Include database connection
    include_once(__DIR__ . '/../../dbconnect.php');
    // Get the data from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    // Check if the password and confirm password match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Hash the password before saving
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Check if username already exists
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $error = "Username already exists!";
        } else {
            // Insert the new user into the database
            $sql = "INSERT INTO users (username, password) VALUES (?,
?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $username, $hashed_password);
            if ($stmt->execute()) {
                // Redirect to login page after successful registration
                header('Location: login.php');
                exit();
            } else {
                $error = "An error occurred. Please try again later.";
            }
        }
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initialscale=1.0">
    <title>Register</title>
    <?php include_once(__DIR__ . '/../layouts/styles.php'); ?>
    <style>
    body {
        background-color: #f5f5f5;
    }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-itemscenter min-vh-100">
        <div class="col-md-6 bg-white p-4 rounded shadow-sm">
            <h1 class="text-center mb-4">Register</h1>
            <?php if (isset($error)) : ?>
            <div class="alert alert-danger text-center">
                <?= $error ?>
            </div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="formlabel">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label for="password" class="formlabel">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="formlabel">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control"
                        required />
                </div>
                <button type="submit" class="btn btn-primary w100">Register</button>
            </form>
            <p class="text-center mt-3">Already have an account? <a href="/demoshop/frontend/pages/login.php">Login</a>
            </p>
        </div>
    </div>
    <?php include_once(__DIR__ . '/../layouts/partials/footer.php');
    ?>
    <?php include_once(__DIR__ . '/../layouts/scripts.php'); ?>
</body>

</html>