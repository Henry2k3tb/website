<?php
$conn = mysqli_connect("localhost", "root", "", "web_ban_hang") or die("Kết nối thất bại");
?>

<?php
include('../database/config.php');

// Lấy ID danh mục từ URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Số sản phẩm hiển thị trên mỗi trang
$item_per_page = isset($_GET['per_page']) ? intval($_GET['per_page']) : 5;
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$item_per_page = max(1, $item_per_page); // Đảm bảo số sản phẩm trên mỗi trang không nhỏ hơn 1
$current_page = max(1, $current_page); // Đảm bảo trang hiện tại không nhỏ hơn 1

// Lấy danh sách danh mục
$sql_cate = mysqli_query($conn, "SELECT * FROM category");

// Lấy sản phẩm theo danh mục nếu danh mục được chọn
if ($id) {
    // Đếm tổng số bản ghi trong danh mục
    $totalRecordsQuery = "SELECT COUNT(*) AS total FROM product WHERE category_id = '$id'";
    $totalRecordsResult = mysqli_query($conn, $totalRecordsQuery);

    if (!$totalRecordsResult) {
        die("Lỗi truy vấn: " . mysqli_error($conn));
    }

    $totalRecords = mysqli_fetch_assoc($totalRecordsResult)['total'];
    $totalPages = ceil($totalRecords / $item_per_page);

    // Tính toán OFFSET cho truy vấn SQL
    $offset = ($current_page - 1) * $item_per_page;

    // Truy vấn lấy danh sách sản phẩm theo trang
    $sql_product = mysqli_query($conn, "SELECT * FROM product WHERE category_id = '$id' ORDER BY id DESC LIMIT $item_per_page OFFSET $offset");
}
?>