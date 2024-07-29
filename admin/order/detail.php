<?php
$title = 'Thông Tin Chi Tiết Đơn Hàng';
include('../../admin/layouts/header.php');
include('../../database/config.php');

// Lấy và bảo vệ dữ liệu đầu vào (nên sử dụng câu lệnh chuẩn bị trước để bảo vệ an toàn)
$orderId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Truy vấn để lấy chi tiết đơn hàng
$sql = "SELECT Order_Details.*, Product.title, Product.thumbnail FROM Order_Details LEFT JOIN Product ON Product.id = Order_Details.product_id WHERE Order_Details.order_id = $orderId";
$result = mysqli_query($conn, $sql);

// Truy vấn để lấy thông tin đơn hàng
$sqlOrder = "SELECT * FROM Orders WHERE id = $orderId";
$orderItemResult = mysqli_query($conn, $sqlOrder);
$orderItem = mysqli_fetch_assoc($orderItemResult);

// Kiểm tra xem đơn hàng có tồn tại không
if (!$orderItem) {
    // Xử lý khi không tìm thấy đơn hàng với ID cụ thể
    echo "Đơn hàng không tồn tại.";
    exit;
}
?>

<div class="row" style="margin-top: 50px;">
    <div class="col-md-12">
        <h3>Chi Tiết Đơn Hàng</h3>
    </div>
    <div class="col-md-8 table-responsive">
        <table class="table table-bordered table-hover" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Thumbnail</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Giá</th>
                    <th>Số Lượng</th>
                    <th>Tổng Giá</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 0;
                while ($item = mysqli_fetch_array($result)) {
                    echo '<tr>
                        <td>' . (++$index) . '</td>
                        <td><img src="' . $item['thumbnail'] . '" style="height: 120px"/></td>
                        <td>' . $item['title'] . '</td>
                        <td>' . $item['price'] . '</td>
                        <td>' . $item['num'] . '</td>
                        <td>' . $item['total_money'] . '</td>
                    </tr>';
                }
                ?>
                <tr>
                    <td colspan="4"></td>
                    <th>Tổng Tiền</th>
                    <td><?= $orderItem['total_money'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-4">
        <table class="table table-bordered table-hover" style="margin-top: 20px;">
            <tr>
                <th>Họ & Tên: </th>
                <td><?= $orderItem['fullname'] ?></td>
            </tr>
            <!-- <tr>
                <th>Email: </th>
                <td><?//= $orderItem['email'] ?></td>
            </tr> -->
            <tr>
                <th>Địa Chỉ: </th>
                <td><?= $orderItem['address'] ?></td>
            </tr>
            <tr>
                <th>Điện Thoại: </th>
                <td><?= $orderItem['phone_number'] ?></td>
            </tr>
        </table>
    </div>
</div>

<?php
require_once('../layouts/footer.php');
?>
