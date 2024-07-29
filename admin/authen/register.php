<?php
	include("../../database/config.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Đăng Ký</title>
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
		<div class="container">
			<div class="panel panel-primary" style="width: 480px; background-color: white; padding: 10px; border-radius: 5px; box-shadow: 2px 2px #9ac9f5;">
				<div class="panel-heading">
					<h2 class="text-center">Đăng Ký Tài Khoản</h2>
					<h5 style="color: red;" class="text-center">
                        <?php // Hiển thị thông báo lỗi nếu có ?>
                        <?php if (isset($msg)) echo $msg; ?>
                    </h5>
				</div>
				<div class="panel-body">
					<form method="POST" onsubmit="return validateForm();">
						<div class="form-group">
							<label for="usr">Họ & Tên:</label>
							<input required="true" type="text" class="form-control" id="usr" name="fullname" placeholder="Họ tên">
						</div>
						<div class="form-group">
							<label for="email">Email:</label>
							<input required="true" type="email" class="form-control" id="email" name="email" placeholder="Email của bạn">
						</div>
						<div class="form-group">
							<label for="pwd">Mật Khẩu:</label>
							<input required="true" type="password" class="form-control" id="pwd" name="password" minlength="6" placeholder="Nhập mật khẩu">
						</div>
						<p>
							<a href="../../admin/authen/logindb.php">Tôi đã có tài khoản</a>
						</p>
						<button class="btn btn-success" name="btnThem" type="submit">Đăng Ký</button>
					</form>
				</div>
			</div>
		</div>
	</div>
    
    <?php
    if (isset($_POST["btnThem"])) { // Kiểm tra nếu nút "Đăng kí" được nhấn
        $full = $_POST["fullname"]; // Lấy giá trị họ tên từ form
        $em = $_POST["email"]; // Lấy giá trị email từ form
        $pw = $_POST["password"]; // Lấy giá trị mật khẩu từ form
        // Thêm vào cơ sở dữ liệu
        $sql = "INSERT INTO users(fullname, email, passwords) VALUES ('$full', '$em', '$pw')"; // Câu lệnh SQL thêm dữ liệu vào bảng users
        if (mysqli_query($conn, $sql)) { // Thực hiện câu lệnh SQL
            echo "<p class='text-success text-center'>Đăng ký thành công!</p>"; // Thông báo đăng ký thành công
        } else {
            echo "<p class='text-danger text-center'>Có lỗi xảy ra, vui lòng thử lại.</p>"; // Thông báo lỗi
        }
    }
    ?>
</body>
</html>
