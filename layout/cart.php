<?php
session_start(); // Khởi động session để theo dõi người dùng

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user'])) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
    header("Location: ../login/login.php");
    exit(); // Dừng thực thi script sau khi chuyển hướng
}

include('config.php'); // Kết nối đến cơ sở dữ liệu

// Lấy thông tin ID của người dùng từ session
$user_id = $_SESSION['user']['id'];
echo 'User ID: ' . $user_id; // Hiển thị ID người dùng (chỉ để kiểm tra)

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = array(); // Khởi tạo giỏ hàng là một mảng trống
}

$error = false; // Biến lưu lỗi
$success = false; // Biến lưu thông báo thành công

// Kiểm tra hành động từ URL
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "add":
            // Xử lý khi thêm sản phẩm vào giỏ hàng
            if (isset($_POST['quantity']) && is_array($_POST['quantity'])) {
                // Duyệt qua từng sản phẩm và số lượng từ POST
                foreach ($_POST['quantity'] as $id => $quantity) {
                    // Cập nhật số lượng sản phẩm trong giỏ hàng
                    $_SESSION["cart"][$id] = intval($quantity); // Chuyển đổi số lượng thành số nguyên
                }
                header("Location: cart.php"); // Chuyển hướng đến trang giỏ hàng
                exit; // Dừng thực thi script sau khi chuyển hướng
            }
            break;
        case "delete":
            // Xử lý khi xóa sản phẩm khỏi giỏ hàng
            if (isset($_GET['id'])) {
                $id = $_GET['id']; // Lấy ID sản phẩm từ URL
                unset($_SESSION["cart"][$id]); // Xóa sản phẩm khỏi giỏ hàng
                header("Location: cart.php"); // Chuyển hướng đến trang giỏ hàng
                exit(); // Dừng thực thi script sau khi chuyển hướng
            }
            break;
        case "update":
            // Xử lý khi cập nhật giỏ hàng hoặc đặt hàng
            if (isset($_POST['update_click'])) {
                // Cập nhật số lượng sản phẩm trong giỏ hàng
                if (isset($_POST['quantity']) && is_array($_POST['quantity'])) {
                    foreach ($_POST['quantity'] as $id => $quantity) {
                        $_SESSION["cart"][$id] = intval($quantity); // Cập nhật số lượng
                    }
                    header("Location: cart.php"); // Chuyển hướng đến trang giỏ hàng
                    exit(); // Dừng thực thi script sau khi chuyển hướng
                }
            } elseif (isset($_POST['order_click'])) {
                // Xử lý khi đặt hàng
                if (empty($_POST['name'])) {
                    $error = "Bạn chưa nhập tên"; // Lỗi nếu chưa nhập tên
                } elseif (empty($_POST['address'])) {
                    $error = "Bạn chưa nhập địa chỉ"; // Lỗi nếu chưa nhập địa chỉ
                } elseif (empty($_POST['phone'])) {
                    $error = "Bạn chưa nhập số điện thoại"; // Lỗi nếu chưa nhập số điện thoại
                } elseif (empty($_POST['note'])) {
                    $error = "Bạn chưa nhập email"; // Lỗi nếu chưa nhập email
                } elseif (empty($_POST['quantity'])) {
                    $error = "Bạn chưa có sản phẩm"; // Lỗi nếu giỏ hàng rỗng
                }

                // Nếu không có lỗi và giỏ hàng không rỗng
                if ($error == false && !empty($_POST['quantity'])) {
                    // Lấy danh sách ID sản phẩm từ giỏ hàng
                    $productIds = implode(",", array_keys($_SESSION["cart"]));
                    $sql = "SELECT * FROM product WHERE id IN ($productIds)"; // Truy vấn thông tin sản phẩm
                    $result = mysqli_query($conn, $sql); // Thực hiện truy vấn

                    if ($result) {
                        $total = 0; // Biến lưu tổng tiền đơn hàng
                        $orderProduct = array(); // Mảng lưu thông tin sản phẩm trong đơn hàng

                        // Duyệt qua các sản phẩm trong kết quả truy vấn
                        while ($rows = mysqli_fetch_array($result)) {
                            $orderProduct[] = $rows; // Thêm sản phẩm vào mảng
                            $quantity = $_SESSION["cart"][$rows['id']]; // Lấy số lượng sản phẩm
                            $subtotal = $rows['price'] * $quantity; // Tính tổng tiền của sản phẩm
                            $total += $subtotal; // Cộng dồn tổng tiền
                        }

                        // Lấy thông tin người dùng từ session
                        $user_id = $_SESSION['user']['id'];
                        $email = $_SESSION['user']['email'];

                        if (isset($_POST['order_click'])) {
                            $name = $_POST['name'];
                            $phone = $_POST['phone'];
                            $address = $_POST['address'];
                            $note = $_POST['note'];
                        }

                        // Thực hiện câu lệnh INSERT vào bảng orders
                        $insertOrder = mysqli_query($conn, "INSERT INTO orders (user_id, fullname, email, phone_number, address, notes, order_date, status, total_money) VALUES ('$user_id', '$name', '$email', '$phone', '$address', '$note', NOW(), '0', '$total')");

                        if ($insertOrder) {
                            // Nếu đơn hàng được lưu thành công, lấy ID đơn hàng
                            $order_id = $conn->insert_id;
                            $insertString = "";

                            // Tạo chuỗi giá trị để thêm chi tiết đơn hàng
                            foreach ($orderProduct as $key => $result) {
                                $insertString .= "('$order_id', '" . $result['id'] . "', '" . $result['price'] . "', '" . $_POST['quantity'][$result['id']] . "', '" . $_POST['quantity'][$result['id']] * $result['price'] . "')";
                                if ($key != count($orderProduct) - 1) {
                                    $insertString .= ","; // Thêm dấu phẩy phân cách các giá trị
                                }
                            }

                            // Thực hiện câu lệnh INSERT vào bảng order_details
                            $insertOrderDetails = mysqli_query($conn, "INSERT INTO order_details (order_id, product_id, price, num, total_money) VALUES " . $insertString . ";");

                            if ($insertOrderDetails) {
                                $success = "ĐẶT HÀNG THÀNH CÔNG"; // Thông báo thành công
                                unset($_SESSION['cart']); // Xóa giỏ hàng sau khi đặt hàng thành công
                            } else {
                                $error = "Có lỗi xảy ra khi thêm chi tiết đơn hàng."; // Lỗi nếu không thêm được chi tiết đơn hàng
                            }
                        } else {
                            $error = "Có lỗi xảy ra khi thêm đơn hàng."; // Lỗi nếu không thêm được đơn hàng
                        }
                    } else {
                        $error = "Không lấy được thông tin sản phẩm."; // Lỗi nếu không lấy được thông tin sản phẩm
                    }
                }
            }
            break;
    }
}

// Nếu giỏ hàng không rỗng, lấy danh sách sản phẩm từ cơ sở dữ liệu
if (!empty($_SESSION["cart"])) {
    // Lấy danh sách các ID sản phẩm từ giỏ hàng
    $productIds = implode(",", array_keys($_SESSION["cart"]));
    $sql = "SELECT * FROM product WHERE id IN ($productIds)"; // Truy vấn thông tin sản phẩm
    $result = mysqli_query($conn, $sql); // Thực hiện truy vấn
} else {
    $result = null; // Nếu giỏ hàng rỗng, đặt kết quả truy vấn là null
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"> <!-- Định dạng ký tự là UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Đảm bảo trang hiển thị đúng trên các thiết bị di động -->
    <title>Giỏ Hàng</title> <!-- Tiêu đề của trang web hiển thị trên tab trình duyệt -->

    <!-- Liên kết đến các tệp CSS để thiết lập kiểu dáng cho trang -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"> <!-- Normalize CSS để đồng nhất kiểu dáng trên các trình duyệt -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap&subset=vietnamese"> <!-- Liên kết đến font chữ Roboto với hỗ trợ tiếng Việt -->
    <link rel="stylesheet" href="../assets/css/base.css"> <!-- Tệp CSS cơ bản của trang web -->
    <link rel="stylesheet" href="../assets/css/main.css"> <!-- Tệp CSS chính của trang web -->
    <link rel="stylesheet" href="../assets/fonts/fontawesome-free-6.5.2-web/css/all.min.css"> <!-- Font Awesome cho các biểu tượng -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> <!-- Bootstrap CSS cho bố cục và kiểu dáng -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> <!-- Bootstrap JS cho các tính năng động -->
</head>

<body>
    <!-- Bao gồm phần đầu của trang, thường chứa thanh điều hướng -->
    <?php include('header.php'); ?>

    <!-- Tiêu đề của trang giỏ hàng -->
    <h2 class="text-center" style="margin-top: 100px;">GIỎ HÀNG</h2>
    <div class="container">
        <!-- Hiển thị thông báo lỗi hoặc thành công -->
        <?php if (!empty($error)) { ?>
            <div id="notify-msg">
                <?= $error ?>. <a href="javascript:history.back()">Quay lại</a>
            </div>
        <?php } elseif ((!empty($success))) { ?>
            <div id="notify-msg">
                <?= $success ?>. <a href="index.php">Tiếp tục mua hàng</a>
            </div>
        <?php } else { ?>
            <!-- Form xử lý giỏ hàng, gửi yêu cầu cập nhật -->
            <form action="cart.php?action=update" method="POST">
                <table id="cart" class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th style="width:50%">Tên sản phẩm</th> <!-- Cột tên sản phẩm -->
                            <th style="width:10%">Đơn giá</th> <!-- Cột đơn giá sản phẩm -->
                            <th style="width:8%">Số lượng</th> <!-- Cột số lượng sản phẩm -->
                            <th style="width:22%" class="text-center">Số tiền</th> <!-- Cột tổng tiền cho sản phẩm -->
                            <th style="width:10%">
                                <!-- Nút cập nhật giỏ hàng -->
                                <button class="btn btn-success btn-block" type="submit" name="update_click">
                                    Cập nhật giỏ hàng <i class="fa fa-angle-right"></i>
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0; // Biến lưu tổng số tiền của giỏ hàng
                        if ($result) {
                            // Duyệt qua các sản phẩm trong kết quả truy vấn
                            while ($rows = mysqli_fetch_array($result)) {
                                $quantity = $_SESSION["cart"][$rows['id']]; // Lấy số lượng sản phẩm từ giỏ hàng
                                $subtotal = $rows['price'] * $quantity; // Tính tổng tiền cho sản phẩm
                                $total += $subtotal; // Cộng dồn tổng tiền giỏ hàng
                        ?>
                                <tr>
                                    <td data-th="Product">
                                        <div class="row">
                                            <!-- Hiển thị ảnh sản phẩm -->
                                            <div class="col-sm-2 hidden-xs">
                                                <img src="<?php echo $rows['thumbnail'] ?>" alt="Sản phẩm" class="img-responsive" width="100">
                                            </div>
                                            <div class="col-sm-10">
                                                <h4 class="nomargin"><?php echo $rows['title'] ?></h4> <!-- Tên sản phẩm -->
                                            </div>
                                        </div>
                                    </td>
                                    <td data-th="Price"><?php echo number_format($rows['price'], 0, ',', '.') . 'đ'; ?></td> <!-- Đơn giá sản phẩm -->
                                    <td>
                                        <!-- Phần điều chỉnh số lượng sản phẩm -->
                                        <div class="quantity-container">
                                            <button class="btn-decrease" type="button">-</button> <!-- Nút giảm số lượng -->
                                            <input type="text" class="quantity-input" value="<?= $quantity ?>" name="quantity[<?php echo $rows['id'] ?>]"> <!-- Ô nhập số lượng -->
                                            <button class="btn-increase" type="button">+</button> <!-- Nút tăng số lượng -->
                                        </div>
                                    </td>
                                    <td data-th="Subtotal" class="text-center"><?php echo number_format($subtotal, 0, ',', '.') . 'đ'; ?></td> <!-- Tổng tiền cho sản phẩm -->
                                    <td class="actions" data-th="">
                                        <!-- Nút xóa sản phẩm khỏi giỏ hàng -->
                                        <div>
                                            <a class="btn btn-danger btn-sm" href="cart.php?action=delete&id=<?= $rows['id'] ?>">
                                                <i class="fa-solid fa-trash-can"></i>Xóa</a>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            // Nếu giỏ hàng trống, hiển thị thông báo
                            echo '<tr><td colspan="5" class="text-center">Giỏ hàng của bạn đang trống.</td></tr>';
                        }
                        ?>

                        <!-- Hiển thị tổng tiền giỏ hàng -->
                        <tr class="visible-xs">
                            <td class="text-center" colspan="5"><strong>Tổng <?php echo number_format($total, 0, ',', '.') . 'đ'; ?></strong></td>
                        </tr>
                        <tr>
                            <td><a href="../layout/index.php" class="btn btn-warning"><i class="fa fa-angle-left"></i> Tiếp tục mua hàng</a></td>
                            <td colspan="2" class="hidden-xs"> </td>
                            <td class="hidden-xs text-center"><strong>Tổng tiền <?php echo number_format($total, 0, ',', '.') . 'đ'; ?></strong></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <!-- Form nhập thông tin đặt hàng -->
                                <form action="xulydonhang.php" method="post">
                                    <div class="form-group">
                                        <label for="ten-nguoi-nhan">Tên người nhận:</label>
                                        <input type="text" class="form-control" id="" name="name"> <!-- Ô nhập tên người nhận -->
                                    </div>
                                    <div class="form-group">
                                        <label for="sdt">Số điện thoại:</label>
                                        <input type="tel" class="form-control" id="" name="phone"> <!-- Ô nhập số điện thoại -->
                                    </div>
                                    <div class="form-group">
                                        <label for="dia-chi">Địa chỉ:</label>
                                        <textarea class="form-control" id="" name="address" rows="3"></textarea> <!-- Ô nhập địa chỉ -->
                                    </div>
                                    <div class="form-group">
                                        <label for="ghi-chu">Ghi chú:</label>
                                        <textarea class="form-control" id="" name="note" rows="3"></textarea> <!-- Ô nhập ghi chú -->
                                    </div>
                                    <!-- Nút gửi đơn hàng -->
                                    <button type="submit" class="btn btn-success btn-block" name="order_click">Thanh toán</button>
                                </form>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        <?php } ?>
    </div>

    <!-- Bao gồm phần chân trang -->
    <?php include('footer.php'); ?>

    <!-- Script JavaScript để điều chỉnh số lượng sản phẩm -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const decreaseBtns = document.querySelectorAll('.btn-decrease'); // Lấy tất cả các nút giảm số lượng
            const increaseBtns = document.querySelectorAll('.btn-increase'); // Lấy tất cả các nút tăng số lượng
            const quantityInputs = document.querySelectorAll('.quantity-input'); // Lấy tất cả các ô nhập số lượng

            // Thêm sự kiện click cho các nút giảm số lượng
            decreaseBtns.forEach((btn, index) => {
                btn.addEventListener('click', function(event) {
                    event.preventDefault(); // Ngăn chặn hành động mặc định
                    let currentValue = parseInt(quantityInputs[index].value); // Lấy giá trị hiện tại của ô nhập
                    if (currentValue > 1) { // Đảm bảo giá trị không giảm dưới 1
                        quantityInputs[index].value = currentValue - 1; // Giảm giá trị của ô nhập
                    }
                });
            });

            // Thêm sự kiện click cho các nút tăng số lượng
            increaseBtns.forEach((btn, index) => {
                btn.addEventListener('click', function(event) {
                    event.preventDefault(); // Ngăn chặn hành động mặc định
                    let currentValue = parseInt(quantityInputs[index].value); // Lấy giá trị hiện tại của ô nhập
                    quantityInputs[index].value = currentValue + 1; // Tăng giá trị của ô nhập
                });
            });
        });
    </script>
</body>

</html>