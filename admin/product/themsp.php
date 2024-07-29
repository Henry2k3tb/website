<?php

include('../../admin/layouts/header.php');
//Gọi kết nối
include("../../database/config.php");
$sql = "SELECT * FROM Category";
$result = mysqli_query($conn, $sql);

$categoryItems = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $categoryItems[] = $row;
    }
}

?>
<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<div class="row" style="margin-top: 50px;">
    <div class="col-md-12 table-responsive">
        <h3>Thêm/Sửa Sản Phẩm</h3>
        <div class="panel panel-primary">
            <div class="panel-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-9 col-12">
                            <div class="form-group">
                                <label for="usr">Tên Sản Phẩm:</label>
                                <input required="true" type="text" class="form-control" id="usr" name="txtname">
                            </div>
                            <div class="form-group">
                                <label for="pwd">Nội Dung:</label>
                                <textarea class="form-control" rows="5" name="txtdescription" id="description"></textarea>
                            </div>

                            <button class="btn btn-success" name="btnThem">Lưu Sản Phẩm</button>
                        </div>
                        <div class="col-md-3 col-12" style="border: solid grey 1px; padding-top: 10px; padding-bottom: 10px;">


                            <div class="form-group">
                                <label for="thumbnail">Thumbnail:</label>
                                <input type="text" class="form-control" id="thumbnail" name="txtthumbnail" oninput="updateThumbnail()">
                                <img id="thumbnail_img" src="" style="max-height: 160px; margin-top: 5px; margin-bottom: 15px;">
                            </div>

                            <div class="form-group">
                                <label for="usr">Danh Mục Sản Phẩm:</label>
                                <select class="form-control" name="txtcategory_id" id="category_id">
                                    <option value="">-- Chọn --</option>
                                    <?php
                                    foreach ($categoryItems as $item) {
                                        if ($item['id'] == $category_id) {
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
                                <input required="true" type="text" class="form-control" id="price" name="txtprice">
                            </div>
                            <div class="form-group">
                                <label for="discount">Giảm Giá:</label>
                                <input required="true" type="text" class="form-control" id="discount" name="txtdiscount">
                            </div>
                            <div class="form-group">
                                <label for="Stt">STT</label>
                                <input required="true" type="text" class="form-control" id="stt" name="txtstt">
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- summernote hỗ trợ code -->
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

//data
if (isset($_POST["btnThem"])) {
    $id = $_POST["txtstt"];
    $name = $_POST["txtname"];
    $cate = $_POST["txtcategory_id"];
    $price = $_POST["txtprice"];
    $dis = $_POST["txtdiscount"];
    $print = $_POST["txtthumbnail"];
    $prodis = $_POST["txtdescription"];

    // Cập nhật cơ sở dữ liệu
    $sql = "INSERT INTO product (id,category_id, title, price,discount, thumbnail, pro_discription)VALUE('$id','$cate','$name','$price','$dis','$print','$prodis')";
    if (mysqli_query($conn, $sql)) {
        echo "Cập nhật thành công!";
        echo '<script>alert("Cập nhật thành công!"); window.location.href = "index.php";</script>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Lỗi: ' . mysqli_error($conn) . '</div>';
    }
}


require_once('../layouts/footer.php');
?>