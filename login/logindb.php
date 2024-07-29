<?php
session_start(); // Khởi động session
include("../database/config.php"); // Kết nối cơ sở dữ liệu

if (isset($_POST['uname']) && isset($_POST['password'])) { // Kiểm tra xem có dữ liệu POST từ form đăng nhập không
    function validate($data) {
        $data = trim($data); // Loại bỏ khoảng trắng ở đầu và cuối chuỗi
        $data = stripslashes($data); // Loại bỏ các dấu gạch chéo ngược (\)
        $data = htmlspecialchars($data); // Chuyển đổi các ký tự đặc biệt thành dạng HTML
        return $data;
    }

    $uname = validate($_POST['uname']); // Xử lý tên đăng nhập
    $pass = validate($_POST['password']); // Xử lý mật khẩu

    if (empty($uname)) { // Kiểm tra nếu tên đăng nhập rỗng
        header("Location: login.php?error=User Name is required"); // Chuyển hướng về trang đăng nhập với thông báo lỗi
        exit();
    } else if (empty($pass)) { // Kiểm tra nếu mật khẩu rỗng
        header("Location: login.php?error=Password is required"); // Chuyển hướng về trang đăng nhập với thông báo lỗi
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE email='$uname' AND passwords='$pass'"; // Truy vấn cơ sở dữ liệu để kiểm tra thông tin đăng nhập

        $result = mysqli_query($conn, $sql); // Thực hiện truy vấn

        if (mysqli_num_rows($result) === 1) { // Kiểm tra nếu có một kết quả trả về
            $row = mysqli_fetch_assoc($result); // Lấy dữ liệu của người dùng
            if ($row['email'] === $uname && $row['passwords'] === $pass) { // Kiểm tra tên đăng nhập và mật khẩu khớp
                $_SESSION['user'] = $row; // Lưu toàn bộ thông tin người dùng vào session
                header("Location: ../layout/index.php"); // Chuyển hướng về trang chính
                exit();
            } else {
                header("Location: login.php?error=Incorrect User name or password"); // Thông báo lỗi nếu thông tin đăng nhập không khớp
                exit();
            }
        } else {
            header("Location: login.php?error=Incorrect User name or password"); // Thông báo lỗi nếu không tìm thấy thông tin đăng nhập
            exit();
        }
    }
} else {
    header("Location: login.php"); // Nếu không có dữ liệu POST, chuyển hướng về trang đăng nhập
    exit();
}
?>
