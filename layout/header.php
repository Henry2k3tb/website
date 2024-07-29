<?php
session_start();
include('config.php'); // Trong đó chứa kết nối CSDL và khởi động phiên

if (isset($_POST['logout'])) {
    session_destroy();

    // Chuyển hướng về trang register.php sau khi đăng xuất
    header("Location: ../layout/index.php");
    exit();
}

?>

<header class="header">
    <div class="grid">
        <nav class="header__navbar">
            <ul class="header__navbar-list">
                <li class="header__navbar-item header__navbar-item--has-qr  header__navbar-item-separate">
                    Vào cửa hàng trên ứng dụng
                    <!-- Header qr code -->
                    <div class="header__qr">
                        <img src="../assets/img/qrr.png" alt="Qr CoDE" class="header__qr-img">
                        <div class="header__qr-apps">
                            <a href="" class="header__qr-link">
                                <img src="../assets/img/gg.png" alt="Google play" class="header__qr-dowload-img">
                            </a>
                            <a href="" class="header__qr-link">
                                <img src="../assets/img/app.png" alt="App store" class="header__qr-dowload-img">
                            </a>
                        </div>
                    </div>
                </li>
                <li class="header__navbar-item">
                    <span class="header__navbar-title--ni-pointer"> Kết nối</span>
                    <a href="" class="header__navbar-icon-link">
                        <i class="header__navbar-icon fa-brands fa-facebook"></i>
                    </a>
                    <a href="" class="header__navbar-icon-link">
                        <i class="header__navbar-icon fa-brands fa-instagram"></i>
                    </a>
                </li>
            </ul>

            <ul class="header__navbar-list">
                <li class="header__navbar-item"><a href="" class="header__navbar-item-link">
                        <i class="header__navbar-icon fa-regular fa-bell"></i>
                        Thông báo</a></li>

                <li class="header__navbar-item"><a href="" class="header__navbar-item-link">
                        <i class="header__navbar-icon fa-regular fa-circle-question"></i>
                        Trợ giúp
                    </a>
                </li>

                <li class="header__navbar-item header__navbar-item--strong header__navbar-item-separate">
                    <a href="../login/register.php" style="text-decoration: none; color:var(--white-color)">Đăng kí</a>
                </li>

                <?php if (isset($_SESSION['user'])) : ?>
                    <li class="header__navbar-item header_navbar-user">
                        <img src="https://tse4.mm.bing.net/th?id=OIP.Uxi-87aG4t2GvhRVmse3OAHaIN&pid=Api&P=0&h=180" alt="" class="header__navbar-user-img">
                        <span class="header__navbar-user-name">
                            <?php echo $_SESSION['user']['fullname']; ?>
                        </span>
                    </li>
                    <li>
                        <form method="post" class="header__navbar-item header__navbar-item--strong">
                            <button type="submit" name="logout" style="border: none;background: none;color: #fff;">Đăng xuất</button>
                        </form>
                    </li>
                <?php else : ?>
                    <li class="header__navbar-item header__navbar-item--strong">
                        <a href="../login/login.php" style="text-decoration: none; color:var(--white-color)">Đăng nhập</a>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>
        <!-- header-with-search-->
        <div class="header-with-search">
            <div class="header__logo">
                <a href="../layout/index.php" class="header__logo-link">
                    <img viewBox="0 0 192 65" class="header__logo-img" src="../assets/img/LOGO_tachnen.png">
                </a>
            </div>

            <div class="header__search">
                <input type="text" class="header__search-input" placeholder="Nhập để tìm kiếm sản phẩm">
                <button class="header__search-btn">
                    <i class="fa-solid fa-magnifying-glass header__search-btn-icon"></i>
                </button>

            </div>
            <!-- Cart layout -->
            <div class="header__cart">
                <div class="header__cart-wrap">
                    <i class="header__cart-icon fa-solid fa-cart-shopping"></i>
                    <?php
                    // Kiểm tra nếu session đã được khởi tạo và có sản phẩm trong giỏ hàng
                    if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                        // Đếm số lượng sản phẩm trong giỏ hàng
                        $totalItems = count($_SESSION['cart']);
                        echo '<span class="header__cart-notice">' . $totalItems . '</span>';
                    } else {
                        // Nếu không có sản phẩm, hiển thị số lượng là 0
                        echo '<span class="header__cart-notice">0</span>';
                    }
                    ?>
                    <div class="header__cart-list">
                        <?php
                        // Kiểm tra nếu có sản phẩm trong giỏ hàng để hiển thị
                        if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                            echo '<h4 class="header__cart-heading">Sản phẩm đã thêm</h4>';
                            echo '<ul class="header__cart-list-item">';
                            foreach ($_SESSION['cart'] as $id => $quantity) {
                                // Thực hiện truy vấn để lấy thông tin sản phẩm từ cơ sở dữ liệu
                                $productQuery = "SELECT * FROM product WHERE id = $id";
                                $productResult = mysqli_query($conn, $productQuery);
                                $product = mysqli_fetch_array($productResult);
                        ?>
                                <li class="header__cart-item">
                                    <img src="<?php echo $product['thumbnail']; ?>" alt="" class="header__cart-img">
                                    <div class="header__cart-item-info">
                                        <div class="header__cart-item-head">
                                            <h3 class="header__cart-item-name"><?php echo $product['title']; ?></h3>
                                            <div class="header__cart-item_price-wrap">
                                                <span class="header__cart-item-price"><?php echo number_format($product['price'], 0, ',', '.') . 'đ'; ?></span>
                                                <span class="header__cart-item-multiply">x</span>
                                                <span class="header__cart-item-qnt"><?php echo $quantity; ?></span>
                                            </div>
                                        </div>
                                        <div class="header__cart-item-body">
                                            <span class="header__cart-item-dscr">Sản phẩm chất lượng</span>
                                            <a href="cart.php?action=delete&id=<?php echo $product['id']; ?>" class="header__cart-item-remove">Xóa</a>
                                        </div>
                                    </div>
                                </li>
                            <?php
                            }
                            echo '</ul>';
                            echo '<a href="../layout/cart.php" class="header__cart-view btn btn--primary">Xem giỏ hàng</a>';
                        } else {
                            // Nếu không có sản phẩm, hiển thị thông báo
                            ?>
                            <img src="./assets/img/stro.png" alt="" class="header__cart--no-cart-img">
                            <span class="header__cart-list-no-cart-msg">Chưa có sản phẩm</span>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>


        </div>
    </div>
</header>