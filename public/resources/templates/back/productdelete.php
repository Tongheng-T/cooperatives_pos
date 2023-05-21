<?php require_once("../../../../resources/config.php");

if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
    header("Location: ../../");
}

$id = $_POST['pidd'];
$category_query = query("SELECT * FROM tbl_product where pid='$id'");
$row =  $category_query->fetch_object();
$image = $row->pimage;
$query = query("DELETE from tbl_product where pid='$id'");
confirm($query);

if($query){
unlink("../../../productimages/$image");
}else{
    echo 'Error in Deleting';
}




?>