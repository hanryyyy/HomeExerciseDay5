<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initialscale=1.0">
    <title>Demo Shop</title>
    <!-- Nhúng file Quản lý các Liên kết CSS dùng chung cho toàn bộ
trang web -->
    <?php include_once(__DIR__ . '/../layouts/styles.php'); ?>
    <link href="/demoshop/assets/frontend/css/style.css" type="text/css" rel="stylesheet" />
    <style>
        .image {
            width: 100px;
            height: 100px;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <!-- header -->
    <?php include_once(__DIR__ . '/../layouts/partials/header.php');
    ?>
    <!-- end header -->
    <main role="main" class="mb-2">
        <!-- Block content -->
        <?php
        include_once(__DIR__ . '/../../dbconnect.php');
        $cart = [];
        if (isset($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];
        } else {
            $cart = [];
        }
        ?>
        <div class="container mt-4">
            <!-- Vùng ALERT hiển thị thông báo -->
            <div id="alert-container" class="alert alert-warning
alert-dismissible fade d-none" role="alert">
                <div id="message">&nbsp;</div>
                <button type="button" class="close" datadismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <h1 class="text-center">Cart</h1>
            <div class="row">
                <div class="col col-md-12">
                    <?php if (!empty($cart)) : ?>
                        <table id="tblCart" class="table tablebordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Sub Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="datarow">
                                <?php $no = 1; ?>
                                <?php foreach ($cart as $item) : ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td>
                                            <?php if (empty($item['image'])) : ?>
                                                <img src="/demoshop/assets/shared/img/default-image_600.png"
                                                    class="imgfluid image" />
                                            <?php else : ?>
                                                <img src="/demoshop/assets/<?= $item['image'] ?>" class="img-fluid image" />
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $item['name'] ?></td>
                                        <td>
                                            <input type="number" class="form-control" id="quantity_<?= $item['id'] ?>"
                                                name="quantity" value="<?= $item['quantity'] ?>" />
                                            <button class="btn btnprimary btn-sm btn-update-quantity" data-id="<?= $item['id']
                                                                                                                ?>">Update</button>
                                        </td>
                                        <td><?=
                                            number_format($item['price'], 2, ".", ",") ?> vnđ</td>
                                        <td><?=
                                            number_format($item['quantity'] * $item['price'], 2, ".", ",") ?>
                                            vnđ</td>
                                        <td>
                                            <a id="delete_<?= $no ?>" data-id="<?= $item['id'] ?>"
                                                class="btn btn-danger btn-delete-product">
                                                <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <h2>Cart Empty</h2>
                    <?php endif; ?>
                    <a href="/demoshop/frontend" class="btn btnwarning btn-md"><i class="fa fa-arrow-left"
                            aria-hidden="true"></i>
                        Continue Shopping</a>
                    <a href="/demoshop/frontend/pages/checkout.php" class="btn btn-primary btn-md"><i
                            class="fa fa-shopping-cart" ariahidden="true"></i> Checkout</a>
                </div>
            </div>
        </div>
        <!-- End block content -->
    </main>
    <!-- footer -->
    <?php include_once(__DIR__ . '/../layouts/partials/footer.php');
    ?>
    <!-- end footer -->
    <!-- Nhúng file quản lý phần SCRIPT JAVASCRIPT -->
    <?php include_once(__DIR__ . '/../layouts/scripts.php'); ?>
    <!-- Các file Javascript sử dụng riêng cho trang này, liên kết tại
đây -->
    <script>
        $(document).ready(function() {
            function removeProductItem(id) {
                var data = {
                    id: id
                };
                $.ajax({
                    url: '/demoshop/frontend/API/removeCartItem.php',
                    method: "POST",
                    dataType: 'json',
                    data: data,
                    success: function(data) {
                        // Refresh lại trang
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                        var htmlString = `<h1>Can not delete
item</h1>`;
                        $('#message').html(htmlString);
                        $('.alert').removeClass('dnone').addClass('show');
                    }
                });
            };
            // Đăng ký sự kiện cho các nút đang sử dụng class .btndelete-sanpham
            $('#tblCart').on('click', '.btn-delete-product',
                function(event) {
                    event.preventDefault();
                    var id = $(this).data('id');
                    if (confirm('Bạn có chắc chắn muốn xoá sản phẩm này khỏi giỏ hàng?')) {
                        removeProductItem(id);
                    }
                });
            // Cập nhật số lượng trong Giỏ hảng
            function updateCartItem(id, quantity) {
                // Dữ liệu gởi
                var data = {
                    id: id,
                    quantity: quantity
                };
                $.ajax({
                    url: '/demoshop/frontend/API/updateCartItem.php',
                    method: "POST",
                    dataType: 'json',
                    data: data,
                    success: function(data) {
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                        var htmlString = `<h1>Can not update
item</h1>`;
                        $('#message').html(htmlString);
                        $('.alert').removeClass('dnone').addClass('show');
                    }
                });
            };
            $('#tblCart').on('click', '.btn-update-quantity',
                function(event) {
                    event.preventDefault();
                    var id = $(this).data('id');
                    var quantity = $('#quantity_' + id).val();
                    updateCartItem(id, quantity);
                });
        });
    </script>
</body>

</html>