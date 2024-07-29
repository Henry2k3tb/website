<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Đăng Nhập</title>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <style>
        /* Đảm bảo hình nền phủ toàn bộ màn hình */
        body, html {
            height: 100%;
            margin: 0;
        }
        .background {
            background-image: url('https://i.pinimg.com/236x/ab/83/11/ab83116888adc27ede9a3f1bbdff2d9b.jpg');
            background-size: cover; /* Bao phủ toàn bộ phần tử */
            background-position: center; /* Căn giữa hình nền */
            background-repeat: no-repeat; /* Không lặp lại hình nền */
            height: 100vh; /* Đảm bảo chiều cao của phần tử phủ toàn bộ màn hình */
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="background">
        <form method="POST" action="logindb.php">
            <div class="panel panel-primary" style="width: 480px; background-color: white; padding: 10px; border-radius: 5px; box-shadow: 2px 2px #9ac9f5;">
                <div class="panel-heading">
                    <h2 class="text-center">Đăng Nhập</h2>
                    <?php if (isset($_GET['error'])) { ?>
                        <p class="loi">
                            <?php echo $_GET['error']; ?>
                        </p>
                    <?php } ?>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input required="true" type="email" class="form-control" id="email" name="email" placeholder="Email của bạn">
                    </div>
                    <div class="form-group">
                        <label for="password">Mật Khẩu:</label>
                        <input required="true" type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu">
                    </div>
                    <button class="btn btn-success" name="btnLogin" type="submit">Đăng Nhập</button>
                    <p>
                        <a href="register.php">Tạo tài khoản mới</a>
                    </p>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
