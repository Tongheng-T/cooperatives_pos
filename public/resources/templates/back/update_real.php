<?php

require_once("../../../../resources/config.php");
?>




<div class="card card-success card-outline">

  <div class="card-body">

    <?php

    if (isset($_POST['val'])) {
      $id_branch =  $_POST['val'];
      $id = 1;
      $update = query("UPDATE tbl_change set usd_or_real= '$id_branch' where id=" . $id);
      confirm($update);
    }
    ?>


  </div>
</div>