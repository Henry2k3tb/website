<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap&subset=vietnamese">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/thuchanh.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-free-6.5.2-web/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>

<body>
    <div class="app">
        <?php include('header.php'); ?>

        <?php
        include('config.php');
        // Lấy thông tin sản phẩm từ database
        $sql = "SELECT * FROM product WHERE id = " . $_GET['id'];
        $result = mysqli_query($conn, $sql);
        ?>

        <div class="app_container">
            <div class="grid">
                <div class="grid__row app_content">

                    <!-- Hiển thị chi tiết sản phẩm -->
                    <div class="main">
                        <?php while ($rows = mysqli_fetch_array($result)) { ?>
                            <div class="main__product">
                                <div class="main__product-img" style="background-image: url(<?php echo $rows['thumbnail']; ?>);">
                                </div>

                                <div class="main__product-info">
                                    <h1 class="main__product-name" style="font-size: 2rem;font-weight: 400;"><?php echo $rows['title']; ?></h1>
                                    <!-- Hiển thị đánh giá và số lượng bán -->
                                    <div class="home-product-item__action">
                                        <div class="home-product-item__rating" style="display: inline;">
                                            <i class="home-product-item__star">5</i>
                                            <i class="home-product-item__star fa-solid fa-star"></i>
                                            <!-- Hiển thị số sao đánh giá -->
                                        </div>
                                        <span class="home-product-item__sold" style="font-size: 1.8rem; color:rgba(0, 0, 0, 0.5)">12.3k đã bán</span>
                                        <!-- Hiển thị số lượng sản phẩm đã bán -->
                                    </div>

                                    <!-- Hiển thị giá sản phẩm -->
                                    <div class="home-product-item__price">
                                        <span class="home-product-item__price-old" style="font-size: 1.8rem;"><?php echo number_format($rows['price'], 0, ',', '.') . 'đ'; ?></span>
                                        <span class="home-product-item__price-current" style="font-size: 2.5rem;"><?php echo number_format($rows['discount'], 0, ',', '.') . 'đ'; ?></span>
                                    </div>

                                    <!-- Form chọn size và số lượng -->
                                    <div style="margin-top: 20px;" class="slecrtsize">
                                        <label for="size">Chọn Size:</label>
                                        <select id="size" name="size" style="max-width: 120px;">
                                            <option value="36">M</option>
                                            <option value="37">L</option>
                                            <option value="38">X</option>
                                            <option value="39">XL</option>
                                        </select>
                                    </div>
                                    <div style="margin: 20px 0 0 10px;font-size: 2rem;font-weight: 400;" >
                                        <h3 style="    font-size: 2rem;font-weight: 400;">Mô tả sản phẩm:</h3>
                                        <p style="font-size: 2rem;font-weight: 400;"><?php echo $rows['pro_discription'];?></p>
                                    </div>
                                    <form action="cart.php?action=add" method="POST">
                                        <!-- Form để thêm sản phẩm vào giỏ hàng -->
                                        <div class="quantity-container" style="margin-left: 11px;">
                                            <h2>Số lượng:</h2>
                                            <button class="btn-decrease" type="button">-</button>
                                            <input type="text" class="quantity-input" value="1" name="quantity[<?php echo $rows['id']; ?>]">
                                            <button class="btn-increase" type="button">+</button>
                                        </div>

                                        <!-- Nút thêm vào giỏ hàng -->
                                        <div class="auth-form__socials" style="justify-content: center;margin-top:138px;background-color: #fff;">
                                            <button class="btn btn--with-icon btn--size-s auth-form__socials--facebook" style="height: 58px;font-size: 19px; background-color:#ed5c3f;" type="submit">
                                                <i class="fa-solid fa-cart-shopping"></i>
                                                <span class="auth-form__socials-title">Thêm vào giỏ hàng</span>
                                            </button>
                                        </div>
                                        <input type="hidden" name="product_added" value="true">
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- Các layout khác (column, feature) có thể điều chỉnh tùy theo nội dung -->
                    <!-- Script JS để xử lý tăng giảm số lượng sản phẩm -->
                    <script>
                        // Đợi cho toàn bộ nội dung của trang được tải xong
                        document.addEventListener('DOMContentLoaded', function() {
                            // Lấy các phần tử cần thiết từ DOM
                            const decreaseBtn = document.querySelector('.btn-decrease'); // Nút giảm số lượng
                            const increaseBtn = document.querySelector('.btn-increase'); // Nút tăng số lượng
                            const quantityInput = document.querySelector('.quantity-input'); // Ô nhập số lượng

                            // Thêm sự kiện 'click' cho nút giảm số lượng
                            decreaseBtn.addEventListener('click', function(event) {
                                event.preventDefault(); // Ngăn chặn hành vi mặc định của nút (nếu có)
                                let currentValue = parseInt(quantityInput.value); // Lấy giá trị hiện tại của ô nhập số lượng
                                if (currentValue > 1) { // Kiểm tra xem số lượng có lớn hơn 1 không
                                    quantityInput.value = currentValue - 1; // Giảm số lượng đi 1
                                }
                            });

                            // Thêm sự kiện 'click' cho nút tăng số lượng
                            increaseBtn.addEventListener('click', function(event) {
                                event.preventDefault(); // Ngăn chặn hành vi mặc định của nút (nếu có)
                                let currentValue = parseInt(quantityInput.value); // Lấy giá trị hiện tại của ô nhập số lượng
                                quantityInput.value = currentValue + 1; // Tăng số lượng đi 1
                            });
                        });
                    </script>
                </div>
            </div>
        </div>

        <?php include('footer.php'); ?>
    </div>
</body>

</html>