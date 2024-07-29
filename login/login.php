<!DOCTYPE html>
<html lang="en"> <!-- Khai báo loại tài liệu và ngôn ngữ sử dụng là tiếng Anh -->

<head>
    <meta charset="UTF-8"> <!-- Đặt bộ ký tự là UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Đặt viewport cho thiết bị di động -->
    <title>Đăng Nhập</title> <!-- Tiêu đề của tài liệu -->
    <link rel="stylesheet" href="./logindb.css"> <!-- Liên kết đến file CSS tùy chỉnh -->
    <link rel="stylesheet" href="../assets//fonts//fontawesome-free-6.5.2-web/css/all.min.css"> <!-- Liên kết đến Font Awesome CSS -->
</head>

<body>
    <form action="../login/logindb.php" method="POST"> <!-- Form gửi dữ liệu đến file logindb.php bằng phương thức POST -->
        <div class="modal"> <!-- Div cho modal -->
            <div class="modal__overlay"></div> <!-- Overlay cho modal -->
            <div class="modal__body"> <!-- Body của modal -->
                <div class="auth-form"> <!-- Div chứa form xác thực -->
                    <div class="auth-form__container"> <!-- Container của form -->
                        <div class="auth_-form__header">
                            <h3 class="auth_form__heading">Đăng nhập</h3> <!-- Tiêu đề đăng nhập -->
                            <span class="auth-form__swich-btn">
                                <a href="../login/register.php" style="text-decoration: none; color:var(--primary-color)">Đăng kí</a> <!-- Link đến trang đăng ký -->
                            </span>
                        </div>
                        <?php if (isset($_GET['error'])) { ?> <!-- Kiểm tra xem có thông báo lỗi không -->
                            <p class="loi">
                                <?php echo $_GET['error']; ?> <!-- Hiển thị lỗi nếu có -->
                            </p>
                        <?php } ?>
                        <div class="auth-form__form">
                            <div class="auth-form__group">
                                <input type="text" class="auth-form__input" placeholder="Email của bạn" name="uname" required="true"> <!-- Input cho email -->
                            </div>
                            <div class="auth-form__group">
                                <input type="password" class="auth-form__input" placeholder="Nhập mật khẩu" name="password" required="true"> <!-- Input cho mật khẩu -->
                            </div>
                        </div>
                        <div class="auth-form__aside">
                            <div class="auth-form__help">
                                <a href="../layout/index.php" class="auth-form__link auth-form__help-forgot ">Về trang chủ</a> <!-- Link về trang chủ -->
                                <spann class="auth-form__help-sperater"></spann>
                                <a href="" class="auth-form__link">Cần trợ giúp?</a> <!-- Link cần trợ giúp -->
                            </div>
                        </div>
                        <div class="auth-form__controls">
                            <button class="btn auth-form__controls-back " type="reset">Trở lại</button> <!-- Nút trở lại -->
                            <button class="btn btn--primary ">Đăng nhập</button> <!-- Nút đăng nhập -->
                        </div>
                    </div>
                    <div class="auth-form__socials">
                        <a href="" class="btn btn--with-icon btn--size-s auth-form__socials--facebook">
                            <i class="fa-brands fa-facebook"></i>
                            <span class="auth-form__socials-title">Kết nối với facebook</span> <!-- Nút kết nối với Facebook -->
                        </a>
                        <a href="" class="btn btn--with-icon btn--size-s auth-form__socials--google">
                            <i class="fa-brands fa-google"></i>
                            <span class="auth-form__socials-title">Kết nối với Google</span> <!-- Nút kết nối với Google -->
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>