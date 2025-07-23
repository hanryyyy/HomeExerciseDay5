<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Shop</title>

    <?php include_once(__DIR__ . '/layouts/styles.php'); ?>

</head>

<body>
    <?php include_once(__DIR__ . '/layouts/partials/header.php'); ?>

    <main>
        <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" aria-label="Slide 1"
                    class="active" aria-current="true"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"
                    class=""></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/demoshop/assets/uploads/slider/slider1.png" alt="">
                    <div class="container">
                        <div class="carousel-caption text-start">
                            <h1>Example headline.</h1>
                            <p class="opacity-75">Some representative placeholder content for the first slide of the
                                carousel.</p>
                            <p><a class="btn btn-lg btn-primary" href="#">Sign up today</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/demoshop/assets/uploads/slider/slider2.png" alt="">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>Another example headline.</h1>
                            <p>Some representative placeholder content for the second slide of the carousel.</p>
                            <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="container marketing">
            <!-- Three columns of text below the carousel -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="icon">
                        <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                    </div>

                    <h2 class="fw-normal">Purchase Subscription</h2>
                    <p>Select a plan that fits your needs and get access to exclusive features.</p>
                </div><!-- /.col-lg-4 -->
                <div class="col-lg-4">
                    <div class="icon">
                        <i class="fa fa-archive" aria-hidden="true"></i>
                    </div>
                    <h2 class="fw-normal">Add Products</h2>
                    <p>Upload new products with descriptions, prices, and images to expand your offerings and attract
                        customers.</p>
                </div><!-- /.col-lg-4 -->
                <div class="col-lg-4">
                    <div class="icon">
                        <i class="fa fa-line-chart" aria-hidden="true"></i>
                    </div>
                    <h2 class="fw-normal">Manage Orders</h2>
                    <p>Track, process, and update customer orders efficiently to ensure timely fulfillment and
                        satisfaction.</p>
                </div><!-- /.col-lg-4 -->
            </div><!-- /.row -->
            <!-- START THE FEATURETTES -->
            <hr class="featurette-divider">
            <div class="row featurette">
                <div class="col-md-7">
                    <h2 class="featurette-heading fw-normal lh-1">First featurette heading. <span
                            class="text-body-secondary">It’ll blow your mind.</span></h2>
                    <p class="lead">Some great placeholder content for the first featurette here. Imagine some exciting
                        prose here.</p>
                </div>
                <div class="col-md-5"> <img src="/demoshop/assets/uploads/imgbody/img1.jpg"
                        class="featurette-image img-fluid mx-auto" alt="Featurette 1" width="500" height="500"
                        style="object-fit: cover;"> </div>
            </div>
            <hr class="featurette-divider">
            <div class="row featurette">
                <div class="col-md-7 order-md-2">
                    <h2 class="featurette-heading fw-normal lh-1">Oh yeah, it’s that good. <span
                            class="text-body-secondary">See for yourself.</span></h2>
                    <p class="lead">Another featurette? Of course. More placeholder content here to give you an idea of
                        how this layout would work with some actual real-world content in place.</p>
                </div>
                <div class="col-md-5 order-md-1"> <img src="/demoshop/assets/uploads/imgbody/img2.jpg"
                        class="featurette-image img-fluid mx-auto" alt="Featurette 1" width="500" height="500"
                        style="object-fit: cover;"> </div>
            </div>

            <hr class="featurette-divider"> <!-- /END THE FEATURETTES -->
        </div><!-- /.container -->
        <?php
        // PHÂN TRANG ALL PRODUCTS
        include_once(__DIR__ . '/../dbconnect.php');
        $productsPerPage = 4;
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $offset = ($page - 1) * $productsPerPage;

        // Đếm tổng số sản phẩm
        $totalResult = $conn->query("SELECT COUNT(*) as total FROM products");
        $totalRow = $totalResult->fetch_assoc();
        $totalProducts = $totalRow['total'];
        $totalPages = ceil($totalProducts / $productsPerPage);


        ?>
        <div class="container mt-5 mb-5">
            <h2 class="text-center mb-4">All Products</h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                <?php
                include_once(__DIR__ . '/../dbconnect.php');
                $sql = "SELECT id, name, price, image_url FROM products ORDER BY id DESC LIMIT $productsPerPage OFFSET $offset";

                $result = $conn->query($sql);
                $products = [];

                while ($row = $result->fetch_assoc()) {
                    $products[] = $row;
                }

                $conn->close();
                ?>

                <?php foreach ($products as $prod): ?>
                    <div class="col">
                        <div class="card shadow-sm h-100">
                            <!-- Click vào ảnh chuyển trang -->
                            <a href="pagedetail.php?id=<?= $prod['id'] ?>">
                                <img src="/demoshop/assets/<?= $prod['image_url'] ?>" class="card-img-top"
                                    alt="<?= htmlspecialchars($prod['name']) ?>" style="height: 200px; object-fit: cover;">
                            </a>

                            <div class="card-body">
                                <!-- Click vào tên sản phẩm chuyển trang -->
                                <h5 class="card-title">
                                    <a href="/demoshop/frontend/pages/detail.php?id=<?= $prod['id'] ?>"
                                        class="text-decoration-none text-dark">
                                        <?= htmlspecialchars($prod['name']) ?>
                                    </a>
                                </h5>
                                <p class="card-text text-muted">vnđ <?= number_format($prod['price'], 2) ?></p>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="/demoshop/frontend/pages/detail.php?id=<?= $prod['id'] ?>"
                                            class="btn btn-sm btn-outline-primary">View details</a>
                                        <button class="btn btn-sm btn-success btn-add-cart" data-id="<?= $prod['id'] ?>"
                                            data-name="<?= htmlspecialchars($prod['name']) ?>"
                                            data-price="<?= $prod['price'] ?>" data-image="<?= $prod['image_url'] ?>"
                                            data-category="" data-quantity="1" title="Add to Cart">
                                            <i class="fa fa-cart-plus"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">New</small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
        <!-- PHÂN TRANG -->
        <nav aria-label="Product pagination" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item<?= $page <= 1 ? ' disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>" tabindex="-1">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item<?= $i == $page ? ' active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item<?= $page >= $totalPages ? ' disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                </li>
            </ul>
        </nav>
        <div class="mb-5"></div>
    </main>

    <?php include_once(__DIR__ . '/layouts/partials/footer.php'); ?>
    <?php include_once(__DIR__ . '/layouts/scripts.php'); ?>
    <script>
        $(document).ready(function() {
            $('.btn-add-cart').click(function(e) {
                e.preventDefault();
                // Kiểm tra đăng nhập
                <?php if (!isset($_SESSION['user_id'])): ?>
                    window.location.href = "/demoshop/frontend/pages/login.php";
                    return;
                <?php endif; ?>

                // Lấy dữ liệu sản phẩm
                var data = {
                    id: $(this).data('id'),
                    name: $(this).data('name'),
                    price: $(this).data('price'),
                    image: $(this).data('image'),
                    category: $(this).data('category'),
                    quantity: $(this).data('quantity')
                };

                $.ajax({
                    url: '/demoshop/frontend/API/addCart.php',
                    method: "POST",
                    dataType: 'json',
                    data: data
                    // Không cần xử lý success/error để hiện thông báo
                });
            });
        });
    </script>
</body>

</html>