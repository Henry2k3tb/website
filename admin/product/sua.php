<?php
// Chèn header và kết nối cơ sở dữ liệu
$title = 'Chỉnh Sửa Sản Phẩm'; // Đặt tiêu đề trang
include('../../admin/layouts/header.php'); // Chèn header của trang
include('../../database/config.php'); // Kết nối cơ sở dữ liệu

$id = $_GET['id']; // Lấy ID sản phẩm từ URL

// Truy vấn thông tin sản phẩm dựa trên ID
$sql = "SELECT * FROM product WHERE id = $id";
$result = mysqli_query($conn, $sql);

// Truy vấn lấy danh sách danh mục sản phẩm
$sqlCategories = "SELECT * FROM category";
$resultCategories = mysqli_query($conn, $sqlCategories);
$categoryItems = []; // Mảng lưu danh mục sản phẩm
if ($resultCategories->num_rows > 0) {
    while ($row = $resultCategories->fetch_assoc()) {
        $categoryItems[] = $row; // Thêm danh mục vào mảng
    }
}

?>
<!-- Thêm thư viện Summernote cho editor -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<div class="row" style="margin-top: 50px;">
    <div class="col-md-12 table-responsive">
        <h3>Sửa Sản Phẩm</h3>
        <div class="panel panel-primary">
            <div class="panel-body">
                <?php
                while ($rows = mysqli_fetch_array($result)) {
                ?>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-9 col-12">
                                <!-- Các trường chỉnh sửa thông tin sản phẩm -->
                                <div class="form-group">
                                    <label>Tên Sản Phẩm:</label>
                                    <input required="true" type="text" class="form-control" name="txtname" value="<?php echo $rows['title']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Nội Dung:</label>
                                    <textarea class="form-control" rows="5" name="txtdescription" id="description"><?php echo $rows['pro_discription']; ?></textarea>
                                </div>

                                <button type="submit" class="btn btn-success" name="btnSua">Sửa thông tin</button>
                            </div>
                            <div class="col-md-3 col-12" style="border: solid grey 1px; padding-top: 10px; padding-bottom: 10px;">
                                <!-- Các trường chỉnh sửa khác -->
                                <div class="form-group">
                                    <label for="thumbnail">Thumbnail:</label>
                                    <input type="text" class="form-control" name="txtthumbnail" value="<?php echo $rows['thumbnail']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="usr">Danh Mục Sản Phẩm:</label>
                                    <select class="form-control" name="txtcategory_id" id="category_id">
                                        <option value="">-- Chọn --</option>
                                        <?php
                                        // Tạo danh sách chọn danh mục từ mảng $categoryItems
                                        foreach ($categoryItems as $item) {
                                            if ($item['id'] == $rows['category_id']) {
                                                echo '<option selected value="' . $item['id'] . '">' . $item['name'] . '</option>';
                                            } else {
                                                echo '<option value="' . $item['id'] . '">' . $item['name'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="price">Giá:</label>
                                    <input required="true" type="text" class="form-control" name="txtprice" value="<?php echo $rows['price']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="discount">Giảm Giá:</label>
                                    <input required="true" type="text" class="form-control" name="txtdiscount" value="<?php echo $rows['discount']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="Stt">STT</label>
                                    <input required="true" type="text" class="form-control" id="stt" name="txtstt" value="<?php echo $rows['id']; ?>">
                                </div>
                            </div>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Cấu hình Summernote cho trường mô tả -->
<script>
    $('#description').summernote({
        placeholder: 'Nhập nội dung dữ liệu',
        tabsize: 2,
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
</script>

<?php
// Xử lý khi người dùng nhấn nút "Sửa thông tin"
if (isset($_POST["btnSua"])) {
    $id = $_POST["txtstt"];
    $name = $_POST["txtname"];
    $cate = $_POST["txtcategory_id"];
    $price = $_POST["txtprice"];
    $dis = $_POST["txtdiscount"];
    $print = $_POST["txtthumbnail"];
    $prodis = $_POST["txtdescription"];

    // Cập nhật thông tin sản phẩm vào cơ sở dữ liệu
    $sqlUpdate = "UPDATE product SET category_id='$cate', title='$name', price='$price', discount='$dis', thumbnail='$print', pro_discription='$prodis' WHERE id='$id'";

    if (mysqli_query($conn, $sqlUpdate)) {
        echo '<script> window.location.href = "index.php";</script>'; // Điều hướng về trang danh sách sản phẩm sau khi cập nhật thành công
    } else {
        echo "Lỗi: " . mysqli_error($conn); // Hiển thị lỗi nếu có
    }
}

require_once('../../admin/layouts/footer.php'); // Chèn footer của trang
?>
