<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WEB BÁN ĐỒ THỂ THAO</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap&subset=vietnamese">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-free-6.5.2-web/css/all.min.css">
    <style></style>
</head>

<body>
    <?php
    include('config.php')
    ?>
    <div class="app">
        <!-- Header -->
        <?php
        include('header.php')
        ?>
        <!-- Container -->
        <div class="app_container">
            <div class="Feature-layout">
                <div class="feature-item">
                    <img class="feature-item-team " src="https://i.pinimg.com/564x/95/08/5b/95085b5b2470c508fb7d24efad560c63.jpg" alt="">
                </div>
                <div class="feature-item">
                    <img class="feature-item-team " src="https://i.pinimg.com/564x/d2/2b/bb/d22bbb9473dfaa9aadbc647fc1805564.jpg" alt="">
                </div>
                <div class="feature-item">
                    <img class="feature-item-team " src="https://i.pinimg.com/736x/de/cf/d6/decfd64d89d27a3c6fc40ef072281beb.jpg" alt="">
                </div>
            </div>
            <div class="grid">
                <!-- column layout -->

                <!--  Featur-layout-->
                <div class="grid__row app_content">

                    <div class="grid__column-2">
                        <nav class="category">
                            <h3 class="category_heading">Danh Mục</h3>
                            <?php
                            // Reset pointer của $sql_cate về vị trí đầu tiên
                            mysqli_data_seek($sql_cate, 0);
                            while ($row_cate = mysqli_fetch_array($sql_cate)) {
                                $id_categore = $row_cate['id'];
                            ?>
                                <ul class="category-list">
                                    <li class="category-item <?php echo ($id == $id_categore) ? 'category-item-active' : ''; ?>" value="<?php echo $id_categore ?>">
                                        <a href="?id=<?php echo $id_categore ?>" class="category-item_link"><?php echo $row_cate['name'] ?></a>
                                    </li>
                                </ul>
                            <?php } ?>
                        </nav>
                    </div>

                    <!-- phần Danh mục sản phẩm -->
                    <div class="grid__column-10">
                        <div class="home-filter">
                            <span class="home-filter__label">Danh mục sản phẩm</span>
                            <?php
                            // Kiểm tra nếu có danh mục để hiển thị
                            mysqli_data_seek($sql_cate, 0); // Reset lại pointer của $sql_cate
                            if (mysqli_num_rows($sql_cate) > 0) {
                                echo '<div class="category-buttons">';
                                while ($row_cate = mysqli_fetch_array($sql_cate)) {
                                    $id_categore = $row_cate['id'];
                                    $category_name = $row_cate['name'];
                                    // Đối với mỗi danh mục, tạo một liên kết
                                    echo '<a href="?id=' . $id_categore . '" class="home-filter__btn btn btncolor">' . $category_name . '</a>';
                                }
                                echo '</div>';
                            } else {
                                // Xử lý trường hợp không có danh mục
                                echo '<p>Không có danh mục nào được tìm thấy.</p>';
                            }
                            ?>
                        </div>

                        <?php
                        // Kiểm tra nếu có tham số 'id' trong URL
                        if (isset($_GET['id'])) {
                            // Hiển thị các mục tương ứng với 'id'
                            include('category.php');
                        } else {
                            // Nếu không có 'id', hiển thị sản phẩm
                            include('product.php');
                        }
                        ?>
                    </div>

                </div>
            </div>
            <?php
            include('footer.php')
            ?>
        </div>
</body>

</html>