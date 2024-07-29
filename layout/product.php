<?php
include("config.php");

// Mặc định số lượng sản phẩm trên mỗi trang và trang hiện tại nếu không có trong URL
$item_per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10; // Giả sử mặc định là 10 sản phẩm mỗi trang
$current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Mặc định là trang đầu tiên

$offset = ($current_page - 1) * $item_per_page;

// Thực hiện truy vấn để lấy tổng số bản ghi
$sql_total = "SELECT COUNT(*) AS total FROM product";
$result_total = mysqli_query($conn, $sql_total);
$totalRecords = mysqli_fetch_array($result_total)['total'];
$totalPages = ceil($totalRecords / $item_per_page);

// Thực hiện truy vấn để lấy dữ liệu sản phẩm
$sql = "SELECT * FROM product ORDER BY id ASC LIMIT $item_per_page OFFSET $offset";
$result = mysqli_query($conn, $sql);

?>

<!-- Hiển thị danh sách sản phẩm -->
<div class="grid__row">

    <?php
    if ($result && mysqli_num_rows($result) > 0) {
        while ($rows = mysqli_fetch_array($result)) {
            // Tạo đường dẫn chi tiết sản phẩm với tham số id
            $detail_url = "detail.php?id=" . $rows["id"];
    ?>
            <div class="grid__column-2-4">
                <a class="home-product-item" href="<?php echo $detail_url ?>">
                    <div class="home-product-item__img" style="background-image: url('<?php echo $rows["thumbnail"] ?>');">
                    </div>

                    <h4 class="home-product-item__name"><?php echo $rows["title"] ?></h4>
                    <div class="home-product-item__price">
                        <span class="home-product-item__price-old"><?php echo number_format($rows["price"], 0, ",", ".") ?>đ</span>
                        <span class="home-product-item__price-current"><?php echo number_format($rows["discount"], 0, ",", ".") ?>đ</span>
                    </div>

                    <div class="home-product-item__action">
                        <span class="home-product-item__like home-product-item__like--liked">
                            <i class="home-product-item__like-icon-empty fa-regular fa-heart"></i>
                            <i class="home-product-item__like-icon-fill fa-solid fa-heart"></i>
                        </span>
                        <div class="home-product-item__rating">
                            <i class="home-product-item__star-gold fa-solid fa-star"></i>
                            <i class="home-product-item__star-gold fa-solid fa-star"></i>
                            <i class="home-product-item__star-gold fa-solid fa-star"></i>
                            <i class="home-product-item__star-gold fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <span class="home-product-item__sold">88 đã bán</span>
                    </div>

                    <div class="home-product-item__origin">
                        <span class="home-product-item__brand">whoo</span>
                        <span class="home-product-item__origin-name">Nhật bản</span>
                    </div>

                    <div class="home-product-item__favorite">
                        <i class="fa-solid fa-check"></i>
                        <span>Yêu thích</span>
                    </div>
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
    } else {
        echo "<p>Không có sản phẩm nào.</p>";
    }
    ?>
</div>

<!-- Hiển thị phân trang -->
<?php if ($totalPages > 1) { ?>
    <ul class="pagination home-product__pagination">
        <li class="pagination-item">
            <a href="?per_page=<?= $item_per_page ?>&page=<?= ($current_page > 1) ? ($current_page - 1) : 1 ?>" class="pagination-item__link">
                <i class="pagination-item__icon fa-solid fa-angle-left"></i>
            </a>
        </li>

        <?php for ($num = 1; $num <= $totalPages; $num++) { ?>
            <li class="pagination-item <?= ($num == $current_page) ? 'pagination-item--active' : '' ?>">
                <a href="?per_page=<?= $item_per_page ?>&page=<?= $num ?>" class="pagination-item__link"><?= $num ?></a>
            </li>
        <?php } ?>

        <li class="pagination-item">
            <a href="?per_page=<?= $item_per_page ?>&page=<?= ($current_page < $totalPages) ? ($current_page + 1) : $totalPages ?>" class="pagination-item__link">
                <i class="pagination-item__icon fa-solid fa-angle-right"></i>
            </a>
        </li>
    </ul>
<?php } ?>