<?php
include_once '../../config.php';

if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
    header("Location: ../../public");
}

$id = $_POST['pidd'];

$query = query("DELETE tbl_invoice , tbl_invoice_details FROM tbl_invoice LEFT JOIN tbl_invoice_details ON tbl_invoice.invoice_id = tbl_invoice_details.invoice_id where tbl_invoice.invoice_id='$id'");

confirm($query);

unlink("productimages/");

// $sql = "delete from tbl_product where pid=$id";


if ($query) {
} else {
    echo 'Error in Deleting';
}



