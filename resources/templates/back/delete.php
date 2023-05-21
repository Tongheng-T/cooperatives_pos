<?php
include_once '../../config.php';

$id = $_GET['id'];
$delete = query("DELETE from tbl_user where userid=" . $id);
confirm($delete);
if ($delete) {

  set_message('<script type="text/javascript">
    jQuery(function validation(){
      swal({
        title:"Good Job!",
        text: "Account is deleted!",
        icon: "success",
        button: "Ok",
      });
    });
    </script>');

    redirect('../../../public/admin/itemt?registration');
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
    redirect('../../../public/admin/itemt?registration');
}
