<?php
include("../../database/config.php"); // Kết nối đến cơ sở dữ liệu bằng cách bao gồm tệp cấu hình

// Lấy ID sản phẩm từ tham số 'id' trong URL
$layid = $_GET["id"];

// Tạo câu lệnh SQL để xóa sản phẩm có ID tương ứng
$sql = "DELETE FROM product WHERE id = '$layid'";

// Thực hiện câu lệnh SQL
$result = mysqli_query($conn, $sql);

// Kiểm tra kết quả thực hiện câu lệnh
if ($result) {
    // Nếu xóa thành công, chuyển hướng người dùng về trang index.php
    header("location:index.php");
} else {
    // Nếu xóa không thành công, hiển thị thông báo lỗi
    echo "Xóa không thành công";
}
?>
