<?php
if(!empty($_POST)) {

    $id = $_POST['id'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    

    // $thumbnail = moveFile('thumbnail');
    
    $description = $_POST['pro_description'];
    $category_id = $_POST['category_id'];
    $created_at = $updated_at = date('Y-m-d H:i:s');
    
    if($id > 0) {
        // Update existing record
        if(!empty($thumbnail)) {
            $sql = "UPDATE Product SET thumbnail = '$thumbnail', title = '$title', price = $price, discount = $discount, description = '$description', WHERE id = $id";
        } else {
            $sql = "UPDATE Product SET title = '$title', price = $price, discount = $discount, description = '$description', WHERE id = $id";
        }
        
        mysqli_query($conn, $sql);
        
        header('Location: index.php');
        die();
    } else {
        // Insert new record
        $sql = "INSERT INTO Product (thumbnail, title, price, discount, description, deleted, category_id) VALUES ('$thumbnail', '$title', $price, $discount, '$created_at', 0, $category_id)";
        mysqli_query($conn, $sql);
        
        header('Location:index.php');
        die();
    }
}
?>
