
<?php
// Chèn header và sidebar từ tệp index.php
include('../../admin/layouts/header.php');
//Gọi kết nối
include("../../database/config.php");
// require("config.php");
$sql ="SELECT * FROM users";

$result = mysqli_query($conn,$sql);
// echo "Kết quả:".$sql;
?>

<div class="row" style="margin-top: 50px;">
    <div class="col-md-12 table-responsive">
        <h3>Quản Lý Khách Hàng</h3>

        <a href="them.php"><button class="btn btn-success">Thêm Tài Khoản</button></a>

        <table class="table table-bordered table-hover" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Họ & Tên</th>
                    <th>Email</th>
                    <th>SĐT/th></th>
                    <th>Địa chỉ</th>
                    <th>Mật khẩu</th>
                    <th style="width: 50px">Sửa</th>
                    <th style="width: 50px">Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($rows = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td>
                            <?php echo $rows["id"] ?>
                        </td>
                        <td>
                            <?php echo $rows["fullname"] ?>
                        </td>
                        <td>
                            <?php echo $rows["email"] ?>
                        </td>
                        <td>
                            <?php echo $rows["phone_number"] ?>
                        </td>
                        <td>
                            <?php echo $rows["address"] ?>
                        </td>
                        <td>
                            <?php echo $rows["passwords"] ?>
                        </td>
                       
                        <td>
                            <a href="suathongtin.php?id=<?php echo $rows['id'] ?>"> sua</a>
                        </td>
                        <td>
                            <a href="xoa.php?id=<?php echo $rows['id'] ?>"> xoa</a>
                        </td>
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
require_once('../../admin/layouts/footer.php');
?>