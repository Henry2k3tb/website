<?php
// Chèn header và sidebar từ tệp index.php
include('../../admin/layouts/header.php');
// Gọi kết nối đến cơ sở dữ liệu từ tệp config.php
include("../../database/config.php");
// Lấy giá trị 'id' từ URL query string
$layid = $_GET["id"];
// Truy vấn cơ sở dữ liệu để lấy thông tin người dùng với 'id' cụ thể
$sql_fetch = "SELECT * FROM users WHERE id = '$layid'";
// Thực thi truy vấn và lưu kết quả vào biến $result
$result = mysqli_query($conn, $sql_fetch);
// echo "Kết quả:".$sql; // (Dòng này bị chú thích)
?>

<div class="row" style="margin-top: 50px;">
    <!-- Bắt đầu một hàng (row) với khoảng cách trên 50px để tạo không gian -->
    <div class="col-md-12 table-responsive">
        <!-- Bắt đầu một cột rộng 12 đơn vị (full width trên các màn hình trung bình trở lên), với khả năng hiển thị bảng -->
        <h3>Quản Lý Sản Phẩm</h3>
        <!-- Tiêu đề của trang, hiển thị "Quản Lý Sản Phẩm" -->

        <!-- Nút thêm tài khoản mới -->
        <a href="../../admin/user/them.php">
            <button class="btn btn-success">Thêm Tài Khoản</button>
        </a>

        <table class="table table-bordered table-hover" style="margin-top: 20px;">
            <!-- Bảng để hiển thị form chỉnh sửa người dùng -->
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
                <?php
                // Lặp qua tất cả các dòng kết quả từ truy vấn
                while ($rows = mysqli_fetch_array($result)) {
                ?>
                    <!-- Form để chỉnh sửa thông tin người dùng -->
                    <form action="" method="POST">
                        <!-- Phương thức gửi form là POST, gửi dữ liệu đến chính trang này -->

                        <tr>
                            <!-- Dòng trong bảng -->
                            <td>STT</td>
                            <!-- Cột "STT" -->
                            <td><input type="text" name="txtid" value="<?php echo $rows['id']; ?>" required="true" readonly></td>
                            <!-- Trường nhập dữ liệu cho STT, giá trị được điền từ cơ sở dữ liệu và trường này chỉ đọc -->
                        </tr>
                        <tr>
                            <td>Họ & Tên</td>
                            <td><input type="text" name="txtname" value="<?php echo $rows['fullname']; ?>" required="true"></td>
                            <!-- Trường nhập dữ liệu cho Họ và Tên, giá trị được điền từ cơ sở dữ liệu -->
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><input type="text" name="txtemail" value="<?php echo $rows['email']; ?>" minlength="6" required="true"></td>
                            <!-- Trường nhập dữ liệu cho Email, giá trị được điền từ cơ sở dữ liệu, tối thiểu 6 ký tự -->
                        </tr>
                        <tr>
                            <td>SĐT</td>
                            <td><input type="text" name="txtphone" value="<?php echo $rows['phone_number']; ?>" minlength="6" required="true"></td>
                            <!-- Trường nhập dữ liệu cho Số điện thoại, giá trị được điền từ cơ sở dữ liệu, tối thiểu 6 ký tự -->
                        </tr>
                        <tr>
                            <td>Địa chỉ</td>
                            <td><input type="text" name="txtadd" value="<?php echo $rows['address']; ?>" minlength="6" required="true"></td>
                            <!-- Trường nhập dữ liệu cho Địa chỉ, giá trị được điền từ cơ sở dữ liệu, tối thiểu 6 ký tự -->
                        </tr>
                        <tr>
                            <td>Mật khẩu</td>
                            <td><input type="text" name="txtpass" value="<?php echo $rows['passwords']; ?>" minlength="6" required="true"></td>
                            <!-- Trường nhập dữ liệu cho Mật khẩu, giá trị được điền từ cơ sở dữ liệu, tối thiểu 6 ký tự -->
                        </tr>

                        <tr>
                            <td colspan="2" align="center">
                                <!-- Dòng này chứa các nút để thao tác với form -->
                                <input type="submit" value="Sửa" name="btnSua">
                                <!-- Nút gửi form để lưu thay đổi, có giá trị là "Sửa" -->
                                <input type="reset" value="Bỏ qua" name="btnBoqua">
                                <!-- Nút reset để xóa tất cả các dữ liệu đã nhập trong form, có giá trị là "Bỏ qua" -->
                            </td>
                        </tr>
                    </form>
                <?php
                }
                ?>
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
// Xử lý khi nút "Sửa" được nhấn
if (isset($_POST["btnSua"])) {
    // Lấy dữ liệu từ form
    $id = $_POST["txtid"];
    $name = $_POST["txtname"];
    $email = $_POST["txtemail"];
    $phone = $_POST["txtphone"];
    $add = $_POST["txtadd"];
    $pass = $_POST["txtpass"];

    // Cập nhật cơ sở dữ liệu với các thông tin mới
    $sql = "UPDATE users SET id='$id', fullname='$name', email='$email', phone_number='$phone', address ='$add', passwords='$pass' WHERE id = '$layid'";
    if (mysqli_query($conn, $sql)) {
        // Nếu câu lệnh SQL thực hiện thành công, thông báo thành công và chuyển hướng về trang quản lý
        echo "Cập nhật thành công!";
        header("location:index.php");
    } else {
        // Nếu có lỗi trong câu lệnh SQL, hiển thị thông báo lỗi
        echo "Lỗi: " . mysqli_error($conn);
    }
}

// Chèn footer từ tệp index.php
require_once('../../admin/layouts/footer.php');
?>
