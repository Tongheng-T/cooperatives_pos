<?php
require_once("../../../../resources/config.php");

if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
  header("Location: ../../../");
}
$id = $_POST['pidd'];
$delete = query("DELETE from tbl_cost where id_cost='$id'");
confirm($delete);
if ($delete) {

  // set_message('<script type="text/javascript">
  //   jQuery(function validation(){
  //     swal({
  //       title:"បានលុបការចំណាយ !",
  //       text: "Account is deleted!",
  //       icon: "success",
  //       button: "Ok",
  //     });
  //   });
  //   </script>');

  // redirect('../../../admin/itemt?cost');
} else {

  set_message('<script type="text/javascript">
    jQuery(function validation(){
      swal({
        title:"Error!",
        text: "Not Deleted",
        icon: "error",
        button: "Ok",
      });
    });
    </script>');
  // redirect('../../../admin/itemt?cost');
}
