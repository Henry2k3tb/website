<?php
session_start(); // Khởi động session
include("../../database/config.php"); // Kết nối cơ sở dữ liệu

if (isset($_POST['email']) && isset($_POST['password'])) { // Kiểm tra xem có dữ liệu POST từ form đăng nhập không
    function validate($data)
    {
        $data = trim($data); // Loại bỏ khoảng trắng ở đầu và cuối chuỗi
        $data = stripslashes($data); // Loại bỏ các dấu gạch chéo ngược (\)
        $data = htmlspecialchars($data); // Chuyển đổi các ký tự đặc biệt thành dạng HTML
        return $data;
    }

    $email = validate($_POST['email']); // Xử lý email
    $password = validate($_POST['password']); // Xử lý mật khẩu

    if (empty($email)) { // Kiểm tra nếu email rỗng
        header("Location: login.php?error=Email is required"); // Chuyển hướng về trang đăng nhập với thông báo lỗi
        exit();
    } else if (empty($password)) { // Kiểm tra nếu mật khẩu rỗng
        header("Location: login.php?error=Password is required"); // Chuyển hướng về trang đăng nhập với thông báo lỗi
        exit();
    } else {
        // Truy vấn cơ sở dữ liệu để kiểm tra thông tin đăng nhập và địa chỉ
        $sql = "SELECT * FROM users WHERE email='$email' AND passwords='$password' AND address IS NULL";

        $result = mysqli_query($conn, $sql); // Thực hiện truy vấn

        if (mysqli_num_rows($result) === 1) { // Kiểm tra nếu có một kết quả trả về
            $row = mysqli_fetch_assoc($result); // Lấy dữ liệu của người dùng
            if ($row['email'] === $email && $row['passwords'] === $password) { // Kiểm tra email và mật khẩu khớp
                $_SESSION['user'] = $row; // Lưu toàn bộ thông tin người dùng vào session
                header("Location: ../../admin/layouts/index.php"); // Chuyển hướng về trang chính
            } else {
                header("Location: login.php?error=Incorrect Email or password"); // Thông báo lỗi nếu thông tin đăng nhập không khớp
                exit();
            }
        } else {
            header("Location: login.php?error=Incorrect Email or password "); // Thông báo lỗi nếu không tìm thấy thông tin đăng nhập hoặc địa chỉ không phải NULL
            exit();
        }
    }
} else {
    header("Location: login.php"); // Nếu không có dữ liệu POST, chuyển hướng về trang đăng nhập
    exit();
}
?>
