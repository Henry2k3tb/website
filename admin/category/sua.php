<?php
$title = 'Quản Lý Danh Mục Sản Phẩm'; // Đặt tiêu đề trang
include('../../admin/layouts/header.php'); // Bao gồm tệp header để hiện thị tiêu đề và các phần tử giao diện
include('../../database/config.php'); // Bao gồm tệp cấu hình kết nối cơ sở dữ liệu

$sql = "SELECT * FROM category"; // Truy vấn để lấy tất cả danh mục sản phẩm
$result = mysqli_query($conn, $sql); // Thực thi truy vấn và lưu kết quả vào biến $result
?>

<div class="row" style="margin-top: 50px;">
	<div class="col-md-12" style="margin-bottom: 20px;">
		<h3>Quản Lý Danh Mục Sản Phẩm</h3> <!-- Tiêu đề trang quản lý danh mục -->
	</div>
	<div class="col-md-6">
		<?php
		if (isset($_GET["id"])) { // Kiểm tra xem có tham số 'id' trong URL không
			$layid = $_GET["id"]; // Lấy ID từ tham số URL
			$sql = "SELECT * FROM category WHERE id = '$layid'"; // Truy vấn để lấy thông tin danh mục theo ID
			$result_detail = mysqli_query($conn, $sql); // Thực thi truy vấn và lưu kết quả
			$row = mysqli_fetch_array($result_detail); // Lấy kết quả của truy vấn dưới dạng mảng
			if ($row) { // Nếu tìm thấy danh mục
		?>
				<form action="" method="POST"> <!-- Form chỉnh sửa danh mục -->
					<input type="text" name="txtid" value="<?php echo $row['id']; ?>" readonly> <!-- Hiển thị ID không thể chỉnh sửa -->
					<input type="text" name="txtname" value="<?php echo $row['name']; ?>" required> <!-- Hiển thị tên danh mục để chỉnh sửa -->
					<button type="submit" class="btn btn-success" name="btnSua">Sửa</button> <!-- Nút lưu chỉnh sửa -->
				</form>
		<?php
			} else {
				echo "Không tìm thấy danh mục sản phẩm"; // Thông báo nếu không tìm thấy danh mục
			}
		} else {
			echo "Vui lòng chọn một danh mục sản phẩm để sửa"; // Thông báo nếu không có tham số ID
		}
		?>
	</div>

	<div class="col-md-6 table-responsive">
		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<thead>
				<tr>
					<th>STT</th> <!-- Cột STT -->
					<th>Tên Danh Mục</th> <!-- Cột tên danh mục -->
					<th style="width: 50px"></th> <!-- Cột cho các liên kết -->
					<th style="width: 50px"></th> <!-- Cột cho các liên kết -->
				</tr>
			</thead>
			<tbody>
				<?php
				while ($rows = mysqli_fetch_array($result)) { // Lặp qua tất cả các danh mục
				?>
					<tr>
						<td><?php echo $rows["id"] ?></td> <!-- Hiển thị ID danh mục -->
						<td><?php echo $rows["name"] ?></td> <!-- Hiển thị tên danh mục -->
						<td>
							<a href="sua.php?id=<?php echo $rows['id'] ?>">Sửa</a> <!-- Liên kết đến trang sửa danh mục -->
						</td>
						<td>
							<a href="xoa.php?id=<?php echo $rows['id'] ?>">Xóa</a> <!-- Liên kết đến trang xóa danh mục -->
						</td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>

</div>

<?php
if (isset($_POST["btnSua"])) { // Kiểm tra xem nút 'Sửa' có được nhấn không
	$id = $_POST["txtid"]; // Lấy ID từ form
	$name = $_POST["txtname"]; // Lấy tên danh mục từ form

	// Cập nhật cơ sở dữ liệu
	$sql_update = "UPDATE category SET name='$name' WHERE id='$id'"; // Truy vấn cập nhật tên danh mục
	if (mysqli_query($conn, $sql_update)) { // Thực thi truy vấn
		echo "Cập nhật thành công!"; // Thông báo thành công
		echo '<script>alert("Cập nhật thành công!"); window.location.href = "index.php";</script>'; // Cảnh báo và chuyển hướng về trang danh mục
	} else {
		echo '<div class="alert alert-danger" role="alert">Lỗi: ' . mysqli_error($conn) . '</div>'; // Hiển thị lỗi nếu có
	}
}
require_once('../../admin/layouts/footer.php'); // Bao gồm tệp footer để kết thúc trang
?>
