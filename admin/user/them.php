<?php
// Chèn header và sidebar từ tệp index.php
include('../../admin/layouts/header.php');
//Gọi kết nối
include("../../database/config.php");
// require("config.php");

?>

<div class="row" style="margin-top: 50px;">
    <!-- Bắt đầu một hàng (row) với khoảng cách trên 50px để tạo không gian -->
    <div class="col-md-12 table-responsive">
        <!-- Bắt đầu một cột rộng 12 đơn vị (full width trên các màn hình trung bình trở lên), với khả năng hiển thị bảng -->
        <h3>Quản Lý Người Dùng</h3>
        <!-- Tiêu đề của trang, hiển thị "Quản Lý Người Dùng" -->

        <!-- Nút quay về trang quản lý tài khoản -->
        <a href="index.php">
            <button class="btn btn-success">Trang quản lí tài khoản</button>
        </a>

        <table class="table table-bordered table-hover" style="margin-top: 20px;">
            <!-- Bảng để hiển thị form thêm người dùng -->
            <thead>
                <!-- Phần đầu của bảng -->
                <tr>
                    <th>Thông tin</th>
                    <!-- Cột tiêu đề cho thông tin -->
                    <th>Giá trị</th>
                    <!-- Cột tiêu đề cho giá trị -->
                </tr>
            </thead>
            <tbody>
                <!-- Phần thân của bảng, nơi chứa dữ liệu -->

                <!-- Form để thêm người dùng mới -->
                <form action="" method="POST">
                    <!-- Phương thức gửi form là POST, gửi dữ liệu đến chính trang này -->

                    <tr>
                        <!-- Dòng trong bảng -->
                        <td>STT</td>
                        <!-- Cột "STT" -->
                        <td>
                            <input type="text" name="txtid" required="true">
                            <!-- Trường nhập dữ liệu cho STT (Số thứ tự), bắt buộc phải nhập -->
                        </td>
                    </tr>
                    <tr>
                        <td>Họ & Tên</td>
                        <td>
                            <input type="text" name="txtname" required="true">
                            <!-- Trường nhập dữ liệu cho Họ và Tên, bắt buộc phải nhập -->
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>
                            <input type="text" name="txtemail" minlength="6" required="true">
                            <!-- Trường nhập dữ liệu cho Email, tối thiểu 6 ký tự, bắt buộc phải nhập -->
                        </td>
                    </tr>
                    <tr>
                        <td>SĐT</td>
                        <td>
                            <input type="text" name="txtphone" minlength="6" required="true">
                            <!-- Trường nhập dữ liệu cho Số điện thoại, tối thiểu 6 ký tự, bắt buộc phải nhập -->
                        </td>
                    </tr>
                    <tr>
                        <td>Địa chỉ</td>
                        <td>
                            <input type="text" name="txtadd" minlength="6" required="true">
                            <!-- Trường nhập dữ liệu cho Địa chỉ, tối thiểu 6 ký tự, bắt buộc phải nhập -->
                        </td>
                    </tr>
                    <tr>
                        <td>Mật khẩu</td>
                        <td>
                            <input type="text" name="txtpass" minlength="6" required="true">
                            <!-- Trường nhập dữ liệu cho Mật khẩu, tối thiểu 6 ký tự, bắt buộc phải nhập -->
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" align="center">
                            <!-- Dòng này chứa các nút để thao tác với form -->
                            <input type="submit" value="Thêm" name="btnThem">
                            <!-- Nút gửi form để thêm người dùng, có giá trị là "Thêm" -->
                            <input type="reset" value="Bỏ qua" name="btnBoqua">
                            <!-- Nút reset để xóa tất cả các dữ liệu đã nhập trong form, có giá trị là "Bỏ qua" -->
                        </td>
                    </tr>
                </form>

            </tbody>
        </table>
    </div>
</div>


<!-- <script type="text/javascript">
    function deleteProduct(id) {
        option = confirm('Bạn có chắc chắn muốn xoá sản phẩm này không?')
        if (!option) return;

        $.post('form_api.php', {
            'id': id,
            'action': 'delete'
        }, function(data) {
            location.reload()
        })
    }
</script> -->
<?php

if (isset($_POST["btnThem"])) {
    $id = $_POST["txtid"];
    $name = $_POST["txtname"];
    $email = $_POST["txtemail"];
    $phone = $_POST["txtphone"];
    $add = $_POST["txtadd"];
    $pass = $_POST["txtpass"];

    // Cập nhật cơ sở dữ liệu
    $sql = "INSERT INTO  users(id,fullname,email,phone_number,address,passwords)VALUE('$id','$name','$email ','$phone','$add','$pass')";
    if (mysqli_query($conn, $sql)) {
        echo "Cập nhật thành công!";
        header("location:index.php");
    } else {
        echo '<div class="alert alert-danger" role="alert">Lỗi: ' . mysqli_error($conn) . '</div>';
    }
}

require_once('../../admin/layouts/footer.php');
?>