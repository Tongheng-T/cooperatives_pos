<?php

include_once '../../../../resources/config.php';

$id = $_GET["id"];

$select = query("SELECT * from tbl_product where pid = $id");
confirm($select);

$row = $select->fetch_assoc();
$respone = $row;

header('Content-Type: application/json');

echo json_encode($respone);





?>