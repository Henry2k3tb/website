<?php
// Kết nối đến cơ sở dữ liệu bằng cách chèn tệp cấu hình
include("../../database/config.php");

// Lấy giá trị 'id' từ URL query string
$layid = $_GET["id"];

// Câu lệnh SQL để xóa bản ghi người dùng có 'id' tương ứng
$sql = "DELETE FROM users WHERE id = '$layid'";

// Thực thi câu lệnh SQL
$result = mysqli_query($conn, $sql);

// Kiểm tra kết quả thực thi câu lệnh SQL
if ($result) {
    // Nếu câu lệnh thực thi thành công, chuyển hướng người dùng về trang quản lý
    header("location:index.php");
} else {
    // Nếu có lỗi trong quá trình xóa, hiển thị thông báo lỗi
    echo "Xóa không thành công";
}
?>
