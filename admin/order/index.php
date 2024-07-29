<?php
	// $title = 'Quản Lý Đơn Hàng';
    include('../../admin/layouts/header.php');
    include('../../database/config.php');
	//pending, approved, cancel
	$sql = "select * from Orders order by status asc, order_date desc";
	$result = mysqli_query($conn,$sql);
?>

<div class="row" style="margin-top: 50px;">
	<div class="col-md-12 table-responsive">
		<h3>Quản Lý Đơn Hàng</h3>

		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<thead>
				<tr>
					<th>STT</th>
					<th>Họ & Tên</th>
					<th>SĐT</th>
					<th>Email</th>
					<th>Địa Chỉ</th>
					<th>Nội Dung</th>
					<th>Tổng Tiền</th>
					<th>Ngày Tạo</th>
					<th style="width: 120px"></th>
				</tr>
			</thead>
			<tbody>
<?php
	$index = 0;
	foreach($result as $item) {
		echo '<tr>
					<th>'.(++$index).'</th>
					<td><a href="detail.php?id='.$item['id'].'">'.$item['fullname'].'</a></td>
					<td><a href="detail.php?id='.$item['id'].'">'.$item['phone_number'].'</a></td>
					<td>'.$item['address'].'</td>
					<td>'.$item['notes'].'</td>
					<td>'.$item['total_money'].'</td>
					<td>'.$item['order_date'].'</td>
					<td style="width: 50px">';
		if($item['status'] == 0) {
			echo '<button onclick="changeStatus('.$item['id'].', 1)" class="btn btn-sm btn-success" style="margin-bottom: 10px;">Approve</button>
			<button onclick="changeStatus('.$item['id'].', 2)" class="btn btn-sm btn-danger">Cancel</button>';
		} else if($item['status'] == 1) {
			echo '<label class="badge badge-success">Approved</label>';
		} else {
			echo '<label class="badge badge-danger">XÓA</label>';
		}
		echo '</td>
				</tr>';
	}
?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	function changeStatus(id, status) {
		$.post('form_api.php', {
			'id': id,
			'status': status,
			'action': 'update_status'
		}, function(data) {
			location.reload()
		})
	}
</script>

<?php
	require_once('../layouts/footer.php');
?>