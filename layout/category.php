<div class="home-product">
    <div class="grid__row">
        <!--product-item -->
        <?php
        // Kiểm tra xem biến $id và $sql_product có tồn tại không
        if ($id && $sql_product) {
            // Lặp qua các hàng dữ liệu trả về từ truy vấn SQL
            while ($rows = mysqli_fetch_array($sql_product)) {
        ?>
                <!-- Hiển thị từng sản phẩm trong lưới -->
                <div class="grid__column-2-4">
                    <a class="home-product-item" href="detail.php?id=<?= $rows['id'] ?>">
                        <!-- Hiển thị hình ảnh sản phẩm -->
                        <div class="home-product-item__img" style="background-image: url('<?php echo $rows["thumbnail"] ?>');">
                        </div>

                        <!-- Hiển thị tên sản phẩm -->
                        <h4 class="home-product-item__name"><?php echo $rows["title"] ?></h4>

                        <!-- Hiển thị giá cũ và giá hiện tại của sản phẩm -->
                        <div class="home-product-item__price">
                            <span class="home-product-item__price-old"><?php echo number_format($rows["price"], 0, ",", ".") ?>đ</span>
                            <span class="home-product-item__price-current"><?php echo number_format($rows["discount"], 0, ",", ".") ?>đ</span>
                        </div>

                        <!-- Hiển thị các biểu tượng tương tác như yêu thích, đánh giá và số lượng đã bán -->
                        <div class="home-product-item__action">
                            <!-- Biểu tượng yêu thích (đã được yêu thích) -->
                            <span class="home-product-item__like home-product-item__like--liked">
                                <i class="home-product-item__like-icon-empty fa-regular fa-heart"></i>
                                <i class="home-product-item__like-icon-fill fa-solid fa-heart"></i>
                            </span>
                            <!-- Đánh giá sao của sản phẩm -->
                            <div class="home-product-item__rating">
                                <i class="home-product-item__star-gold fa-solid fa-star"></i>
                                <i class="home-product-item__star-gold fa-solid fa-star"></i>
                                <i class="home-product-item__star-gold fa-solid fa-star"></i>
                                <i class="home-product-item__star-gold fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <!-- Số lượng đã bán -->
                            <span class="home-product-item__sold">88 đã bán</span>
                        </div>

                        <!-- Hiển thị thông tin xuất xứ sản phẩm -->
                        <div class="home-product-item__origin">
                            <span class="home-product-item__brand">whoo</span>
                            <span class="home-product-item__origin-name">Nhật bản</span>
                        </div>

                        <!-- Hiển thị biểu tượng yêu thích -->
                        <div class="home-product-item__favorite">
                            <i class="fa-solid fa-check"></i>
                            <span>Yêu thích</span>
                        </div>

                        <!-- Hiển thị thông tin giảm giá -->
                        <div class="home-product-item__sele-off">
                            <span class="home-product-item___sele-off-percent">
                                43%
                            </span>
                            <span class="home-product-item___sele-off-labal">
                                Giảm
                            </span>
                        </div>
                    </a>
                </div>

        <?php
            }
        }
        ?>

    </div>
</div>

<!-- Phần phân trang -->
<?php if (isset($totalPages) && $totalPages > 1) { ?>
    <ul class="pagination home-product__pagination">
        <!-- Nút phân trang trước -->
        <li class="pagination-item">
            <a href="?id=<?= $id ?>&per_page=<?= $item_per_page ?>&page=<?= ($current_page > 1) ? ($current_page - 1) : 1 ?>" class="pagination-item__link">
                <i class="pagination-item__icon fa-solid fa-angle-left"></i>
            </a>
        </li>

        <!-- Các số trang -->
        <?php for ($num = 1; $num <= $totalPages; $num++) { ?>
            <li class="pagination-item <?= ($num == $current_page) ? 'pagination-item--active' : '' ?>">
                <a href="?id=<?= $id ?>&per_page=<?= $item_per_page ?>&page=<?= $num ?>" class="pagination-item__link"><?= $num ?></a>
            </li>
        <?php } ?>

        <!-- Nút phân trang tiếp theo -->
        <li class="pagination-item">
            <a href="?id=<?= $id ?>&per_page=<?= $item_per_page ?>&page=<?= ($current_page < $totalPages) ? ($current_page + 1) : $totalPages ?>" class="pagination-item__link">
                <i class="pagination-item__icon fa-solid fa-angle-right"></i>
            </a>
        </li>
    </ul>
<?php } ?>