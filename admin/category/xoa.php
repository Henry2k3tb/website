
<?php
include("../../database/config.php");
//lấy id bên trang display
$layid = $_GET["id"];
$sql = "DELETE FROM category WHERE id = '$layid'";
$result = mysqli_query($conn, $sql);
if ($result) {
    header("location:index.php");
} else {
    echo "Xóa không thành công";
}
?>