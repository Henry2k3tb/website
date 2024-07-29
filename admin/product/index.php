<?php
// Chèn header và sidebar từ tệp index.php
include('../../admin/layouts/header.php'); // Nhúng file header.php để chèn phần đầu trang và thanh điều hướng

// Gọi kết nối
include("../../database/config.php"); // Nhúng file config.php để thiết lập kết nối cơ sở dữ liệu

// Số sản phẩm trên mỗi trang
$so_san_pham_moi_trang = 4; // Xác định số lượng sản phẩm hiển thị trên mỗi trang

// Xác định trang hiện tại
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $trang_hien_tai = (int)$_GET['page']; // Lấy số trang từ URL, nếu hợp lệ
} else {
    $trang_hien_tai = 1; // Nếu không có trang trong URL, mặc định là trang 1
}

// Tính offset cho query
$offset = ($trang_hien_tai - 1) * $so_san_pham_moi_trang; // Tính toán vị trí bắt đầu lấy dữ liệu trong cơ sở dữ liệu

// Truy vấn lấy dữ liệu sản phẩm với phân trang
$sql = "SELECT * FROM product LIMIT $offset, $so_san_pham_moi_trang"; // Câu lệnh SQL để lấy dữ liệu sản phẩm với phân trang

$result = mysqli_query($conn, $sql); // Thực hiện câu lệnh SQL và lưu kết quả vào biến $result

?>

<div class="row" style="margin-top: 50px;">
    <div class="col-md-12 table-responsive">
        <h3>Quản Lý Sản Phẩm</h3> <!-- Tiêu đề của trang quản lý sản phẩm -->

        <a href="../../admin/product/themsp.php"><button class="btn btn-success">Thêm Sản Phẩm</button></a> <!-- Nút để thêm sản phẩm mới -->

        <table class="table table-bordered table-hover" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Danh mục</th>
                    <th>Thumbnail</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Giá</th>
                    <th style="width: 50px">Sửa</th>
                    <th style="width: 50px">Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($rows = mysqli_fetch_array($result)) { ?> <!-- Lặp qua các sản phẩm được lấy từ cơ sở dữ liệu -->
                    <tr>
                        <td><?php echo $rows["id"] ?></td> <!-- Hiển thị ID sản phẩm -->
                        <td><?php echo $rows["category_id"] ?></td> <!-- Hiển thị ID danh mục của sản phẩm -->
                        <td style="text-align: center; vertical-align: middle; height: 150px; display: table-cell; padding:0;">
                            <img src="<?php echo $rows["thumbnail"]; ?>" alt="Thumbnail Image" style="max-width: 100%; height: 100px;"> <!-- Hiển thị hình thu nhỏ của sản phẩm -->
                        </td>
                        <td><?php echo $rows["title"] ?></td> <!-- Hiển thị tên sản phẩm -->
                        <td><?php echo $rows["price"] ?></td> <!-- Hiển thị giá sản phẩm -->
                        <td><a href="sua.php?id=<?php echo $rows['id'] ?>">sửa</a></td> <!-- Liên kết đến trang sửa sản phẩm -->
                        <td><a href="xoa.php?id=<?php echo $rows['id'] ?>">xóa</a></td> <!-- Liên kết đến trang xóa sản phẩm -->
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php
        // Tạo các liên kết phân trang
        $sql_count = "SELECT COUNT(*) AS total_records FROM product"; // Câu lệnh SQL để đếm tổng số bản ghi sản phẩm
        $result_count = mysqli_query($conn, $sql_count); // Thực hiện câu lệnh SQL
        $row_count = mysqli_fetch_assoc($result_count); // Lấy kết quả đếm tổng số bản ghi
        $total_records = $row_count['total_records']; // Lưu tổng số bản ghi vào biến
        $total_pages = ceil($total_records / $so_san_pham_moi_trang); // Tính tổng số trang

        if ($total_pages > 1) {
            echo '<ul class="pagination">'; // Nếu có nhiều hơn một trang, tạo danh sách phân trang
            for ($i = 1; $i <= $total_pages; $i++) { // Lặp qua tất cả các trang
                if ($i == $trang_hien_tai) {
                    echo '<li class="page-item active"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>'; // Trang hiện tại được đánh dấu là "active"
                } else {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>'; // Liên kết đến các trang khác
                }
            }
            echo '</ul>'; // Đóng danh sách phân trang
        }
        ?>

    </div>
</div>

<?php
// Chèn footer
require_once('../../admin/layouts/footer.php'); // Nhúng file footer.php để chèn phần chân trang
?>