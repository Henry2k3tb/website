<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng kí</title>
    <link rel="stylesheet" href="./logindb.css">
    <link rel="stylesheet" href="../assets//fonts//fontawesome-free-6.5.2-web/css/all.min.css">
    <style>
        .success-message {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php
    include("../database/config.php") // Kết nối đến cơ sở dữ liệu
    ?>
    <form action="" method="POST"> <!-- Khởi đầu form với phương thức POST -->
        <!-- modal -->
        <!-- đầu tiên tạo ra một lớp modal để nó phủ lên -->
        <!-- sau đó tạo tiếp lớp modal__overlay để phủ màn hình -->
        <!-- để làm nổi lên lớp body -->
        <!-- còn lớp inner là để css cho đê -->
        <div class="modal">
            <div class="modal__overlay"></div> <!-- Lớp phủ nền tối -->
            <div class="modal__body"> <!-- Phần thân của modal -->
                <!-- register form -->
                <div class="auth-form">
                    <!-- <form action="" method="POST"> -->
                    <div class="auth-form__container">
                        <div class="auth_-form__header">
                            <h3 class="auth_form__heading">Đăng kí</h3>
                            <span class="auth-form__swich-btn">
                                <a href="../login/login.php" style="text-decoration: none; color:var(--primary-color)">Đăng nhập</a>
                            </span>
                        </div>
                        <div class="auth-form__form">
                            <div class="auth-form__group">
                                <input type="text" class="auth-form__input" placeholder="Họ tên" name="txtname" required="true"> <!-- Trường nhập họ tên -->
                            </div>
                            <div class="auth-form__group">
                                <input type="text" class="auth-form__input" placeholder="Email của bạn" name="txtemail" required="true"> <!-- Trường nhập email -->
                            </div>
                            <div class="auth-form__group">
                                <input type="text" class="auth-form__input" placeholder="Nhập số điện thoại" name="txtsdt" required="true"> <!-- Trường nhập số điện thoại -->
                            </div>
                            <div class="auth-form__group">
                                <input type="text" class="auth-form__input" placeholder="Nhập địa chỉ" name="txtdiachi" required="true"> <!-- Trường nhập địa chỉ -->
                            </div>
                            <div class="auth-form__group">
                                <input type="text" class="auth-form__input" placeholder="Nhập lại mật khẩu" name="txtmk" minlength="6" required="true"> <!-- Trường nhập mật khẩu -->
                            </div>
                        </div>
                        <div class="auth-form__aside">
                            <p class="auth-form__policy-text">
                                Bằng việc đăng kí, bạn đồng ý với chính sách
                                <a href="" class="auth-form__policy-link">điều khoản chính sách</a> <!-- Link điều khoản chính sách -->
                                <a href="" class="auth-form__policy-link">chính sách bảo mật</a> <!-- Link chính sách bảo mật -->
                            </p>
                        </div>
                        <div class="auth-form__controls">
                            <button class="btn auth-form__controls-back" type="reset" name="btnBoqua">Trở lại</button> <!-- Nút trở lại (reset form) -->
                            <button class="btn btn--primary" name="btnThem" type="submit">Đăng kí</button> <!-- Nút đăng ký (submit form) -->
                        </div>
                    </div>
                    <div class="auth-form__socials">
                        <a href="" class="btn btn--with-icon btn--size-s auth-form__socials--facebook">
                            <i class="fa-brands fa-facebook"></i>
                            <span class="auth-form__socials-title">
                                Kết nối với facebook <!-- Nút kết nối với Facebook -->
                            </span>
                        </a>
                        <a href="" class="btn btn--with-icon btn--size-s auth-form__socials--google">
                            <i class="fa-brands fa-google"></i>
                            <span class="auth-form__socials-title">
                                Kết nối với Google <!-- Nút kết nối với Google -->
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php
    if (isset($_POST["btnThem"])) { // Kiểm tra nếu nút "Đăng kí" được nhấn
        $full = $_POST["txtname"]; // Lấy giá trị họ tên từ form
        $em = $_POST["txtemail"]; // Lấy giá trị email từ form
        $sdt = $_POST["txtsdt"]; // Lấy giá trị số điện thoại từ form
        $add = $_POST["txtdiachi"]; // Lấy giá trị địa chỉ từ form
        $pw = $_POST["txtmk"]; // Lấy giá trị mật khẩu từ form
        //thêm vào cơ sở dữ liệu
        $sql = "INSERT INTO  users(fullname,email,phone_number,address,passwords) VALUE ('$full','$em','$sdt','$add','$pw')"; // Câu lệnh SQL thêm dữ liệu vào bảng users
        if (mysqli_query($conn, $sql)) { // Thực hiện câu lệnh SQL
            echo"<p class='success-message'>Đăng kí thành công!</p>"; // Thông báo đăng ký thành công
        }
    }
    ?>

</body>

</html>