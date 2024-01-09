<?php
require_once("../../../resources/config.php");
$uid=$_SESSION['userid'];
$date = new DateTime('now', new DateTimeZone('Asia/bangkok'));
$datee =  $date->format('Y-m-d H:i:s');
$time=time()+10;
$res = query("UPDATE tbl_user set login_online='$time', last_login='$datee' where userid=" . $_SESSION['userid']);
confirm($res);
