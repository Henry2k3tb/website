<?php
session_start();
include('config.php'); // Trong đó chứa kết nối CSDL và khởi động phiên

// Lưu trang hiện tại vào phiên
$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];

if (isset($_POST['logout'])) {
    session_destroy();

    // Kiểm tra và chuyển hướng về trang đã lưu trước đó sau khi đăng xuất
    if (isset($_SESSION['current_page'])) {
        $redirect_page = $_SESSION['current_page'];
        unset($_SESSION['current_page']); // Xóa biến phiên để tránh trường hợp lỗi vòng lặp
        header("Location: " . $redirect_page);
    } else {
        header("Location: index.php"); // Chuyển hướng về trang chính
    }

    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="<?= $baseUrl ?>../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../assets/css/main.css">
    <style>
        .navbar-nav {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .navbar-nav li {
            padding: 0 10px;
            /* Điều chỉnh khoảng cách giữa các mục */
        }

        .header__navbar-item {
            display: flex;
            align-items: center;
        }

        .header__navbar-item a,
        .header__navbar-item button {
            color: var(--white-color);
            text-decoration: none;
        }

        .header__navbar-item button {
            background: none;
            border: none;
            cursor: pointer;
        }

        .sidebar {
            position: relative;
        }

        .sidebar nav ul li {
            padding: 0px !important;
        }

        .header__navbar-user-img {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">ShopQT</a>

        <ul class="navbar-nav px-3">
        

            <?php if (isset($_SESSION['user'])) : ?>
                <li class="header__navbar-item header_navbar-user">
                    <img src="https://tse4.mm.bing.net/th?id=OIP.Uxi-87aG4t2GvhRVmse3OAHaIN&pid=Api&P=0&h=180" alt="" class="header__navbar-user-img">
                    <span class="header__navbar-user-name"style="color:honeydew" >
                        <?php echo $_SESSION['user']['fullname']; ?>
                    </span>
                </li>
                <li class="header__navbar-item header__navbar-item--strong">
                    <form method="post" action="../../admin/authen/logout.php">
                        <button type="submit" name="logout" style="color:honeydew">Đăng xuất</button>
                    </form>
                </li>
            <?php else : ?>
                <li class="header__navbar-item header__navbar-item--strong">
                    <a href="../../admin/authen/login.php" style="color:honeydew">Đăng nhập</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block sidebar" style="min-height: 600px;
    margin-top: 52px; background-color: #243c53 !important;">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="../../admin/layouts/index.php">
                                <i class="bi bi-house-fill"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../category/index.php">
                                <i class="bi bi-folder"></i>
                                Danh Mục Sản Phẩm
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../product/index.php">
                                <i class="bi bi-file-earmark-text"></i>
                                Sản Phẩm
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../order/index.php">
                                <i class="bi bi-minecart"></i>
                                Quản Lý Đơn Hàng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../user/index.php">
                                <i class="bi bi-people-fill"></i>
                                Quản Lý Người Dùng
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>


            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4" style="margin-top: 50px;">
                <!-- Quản lý sản phẩm START -->