<?php
session_start();
include('../../database/config.php');
if(!empty($_POST)) {
	$action = $_POST["action"];

	switch ($action) {
		case 'update_status':
			updateStatus();
			break;
	}
}

function updateStatus() {
    include('../../database/config.php');
	$id = $_POST["id"];
	$status = $_POST["status"];

	$sql = "update Orders set status = $status where id = $id";
	$result = mysqli_query($conn, $sql);
}
?>