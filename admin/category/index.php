<?php
$title = 'Quản Lý Danh Mục Sản Phẩm'; // Xác định tiêu đề trang
include('../../admin/layouts/header.php'); // Bao gồm tiêu đề và sidebar
include('../../database/config.php'); // Kết nối cơ sở dữ liệu

$sql = "SELECT * FROM category"; // Câu lệnh SQL để chọn tất cả danh mục sản phẩm
$result = mysqli_query($conn, $sql); // Thực thi câu lệnh SQL và lưu kết quả

?>

<div class="row" style="margin-top: 50px;">
    <div class="col-md-12" style="margin-bottom: 20px;">
        <h3>Quản Lý Danh Mục Sản Phẩm</h3> <!-- Tiêu đề chính của trang -->
    </div>

    <div class="col-md-6 table-responsive">
        <table class="table table-bordered table-hover" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th>STT</th> <!-- Cột số thứ tự -->
                    <th>Tên Danh Mục</th> <!-- Cột tên danh mục -->
                    <th style="width: 50px"></th> <!-- Cột sửa -->
                    <th style="width: 50px"></th> <!-- Cột xóa -->
                </tr>
            </thead>
            <tbody>
                <?php
                while ($rows = mysqli_fetch_array($result)) { // Lặp qua các dòng kết quả
                ?>
                    <tr>
                        <td><?php echo $rows["id"] ?></td> <!-- Hiển thị ID của danh mục -->
                        <td><?php echo $rows["name"] ?></td> <!-- Hiển thị tên danh mục -->
                        <td><a href="sua.php?id=<?php echo $rows['id'] ?>">Sửa</a></td> <!-- Liên kết đến trang sửa -->
                        <td><a href="xoa.php?id=<?php echo $rows['id'] ?>">Xóa</a></td> <!-- Liên kết đến trang xóa -->
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <form method="POST" action="index.php" onsubmit="return validateForm();"> <!-- Form thêm danh mục -->
            <tr>
                <td>STT</td>
                <td><input type="text" name="txtid" required="true" readonly></td> <!-- Trường ID -->
            </tr>
            <tr>
                <td>Tên Danh Mục</td>
                <td><input type="text" name="txtname" required="true"></td> <!-- Trường tên danh mục -->
            </tr>
            <button class="btn btn-success" name="btnThem">Lưu</button> <!-- Nút lưu -->
        </form>
    </div>
</div>

<?php
if (isset($_POST["btnThem"])) { // Kiểm tra nếu nút lưu được nhấn
    $id = $_POST["txtid"]; // Lấy ID từ form
    $name = $_POST["txtname"]; // Lấy tên danh mục từ form

    $sql = "INSERT INTO category(id, name) VALUES('$id', '$name')"; // Câu lệnh SQL để thêm danh mục mới
    if (mysqli_query($conn, $sql)) { // Thực thi câu lệnh SQL
        echo "Cập nhật thành công!"; // Thông báo thành công
        echo '<script>window.location.reload();</script>'; // Tải lại trang
    } else {
        // echo '<div class="alert alert-danger" role="alert">Lỗi: ' . mysqli_error($conn) . '</div>'; // Thông báo lỗi nếu có
    }
}
require_once('../../admin/layouts/footer.php'); // Bao gồm footer của trang
?>
