<?php


if ($_SESSION['useremail'] == ""  or $_SESSION['role'] == "User") {

    header('location:../');
}

display_message();

?>





<!-- ======================================================= -->


<?php




if (isset($_POST['btnupdate_ch'])) {


    $exchange = $_POST['txtchange'];

    $id = $_POST['txtid_ch'];

    if ($exchange < 0) {
        set_message('<script type="text/javascript">
    jQuery(function validation(){
      swal({
        title:"Feild is Empty!",
        text: "NO Data",
        icon: "warning",
        button: "Ok",
      });
    });
    </script>');

        redirect('itemt?exchange');
    } else {
        $update = query("UPDATE tbl_change set exchange='{$exchange}' where id =" . $id);
        confirm($update);

        if ($update) {
            set_message('<script type="text/javascript">
    jQuery(function validation(){
      swal({
        title:"Dis Update successfully",
        icon: "success",
        button: "Ok",
      });
    });
    </script>');

            redirect('itemt?exchange');
        } else {
            set_message(' <script type="text/javascript">
            jQuery(function validation(){
      Swal({
        icon: "warning",
        title: "Failed"
      });
    });
    </script>');
            redirect('itemt?exchange');
        }
    }
}


?>



<section class="content container-fluid">
    <div class="box box-warning">

        <div class="card card-primary card-outline">
            <div class="box-header with-border">
                <h5 class="box-title">Exchange Form</h5>
            </div>


            <form action="" method="post">
                <div class="card-body">


                    <div class="row">


                        <?php

                        if (isset($_POST['btnedit_ch'])) {

                            $select = query("SELECT * from tbl_change where id =" . $_POST['btnedit_ch']);
                            confirm($select);
                            if ($select) {
                                $row = $select->fetch_object();

                                echo '<div class="col-md-4">


               
               <div class="form-group">
                
               
                 <input type="hidden" class="form-control" placeholder="Enter Category"  value="' . $row->id . '" name="txtid_ch" >

               
               <div class="form-group">
                 <label for="exampleInputEmail1">Exchange(៛)</label>
                 <input type="text" class="form-control" placeholder="Enter Exchange" value="' . $row->exchange . '" name="txtchange" >
               </div>
               
               </div>
               
               <div class="card-footer">
               <button type="submit" class="btn btn-info" name="btnupdate_ch">Update</button>
               </div>
               
               
               </div>';
                            }
                        } else {

                            echo '<div class="col-md-4">
               
               
               <div class="form-group">
                 <label for="exampleInputEmail1">Exchange(៛)</label>
                 <input type="text" class="form-control" placeholder="Enter Exchange"  name="txtchange" >
               </div>
               

               
               </div>';
                        }




                        ?>


                        <div class="col-md-8">

                            <table id="table_taxx" class="table table-striped table-hover ">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Exchange(៛)</td>
                                        <td>Edit</td>

                                    </tr>

                                </thead>


                                <tbody>

                                    <?php

                                    $select = query("SELECT * from tbl_change order by id ASC");
                                    confirm($select);

                                    while ($row = $select->fetch_object()) {

                                        echo '
                      <tr>
                      <td>' . $row->id . '</td>
                      <td>' . $row->exchange . '</td>
        
                      <td>
                      
                      <button type="submit" class="btn btn-primary" value="' . $row->id . '" name="btnedit_ch">Edit</button>
                      
                      </td>
                      
                      
                      </tr>';
                                    }

                                    ?>

                                </tbody>
                                <!-- <tfoot>
                  <tr>
                    <td>#</td>
                    <td>SGST</td>
                    <td>CGST</td>
                    <td>Discount</td>
                    <td>Edit</td>

                  </tr>

                </tfoot> -->

                            </table>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div><!-- /.container-fluid -->
</section>






<!-- ======================================================= -->




<section class="content container-fluid">
    <div class="box box-info">

        <div class="card card-primary card-outline">
            <div class="box-header with-border">
                <h5 class="box-title">USD OR LEAR</h5>
            </div>

            <div class="row">
                <div class="col-md-10">
                    <div class="content" style="padding: 10px;">
                        <div class="row">
                            <?php
                            function active_usd($active)
                            {
                                $change = query("SELECT * from tbl_change");
                                confirm($change);
                                $row_exchange = $change->fetch_object();
                                $exchange = $row_exchange->usd_or_real;
                                if ($active == $exchange) {
                                    echo "active";
                                }
                            }
                            function active_check($active)
                            {
                                $change = query("SELECT * from tbl_change");
                                confirm($change);
                                $row_exchange = $change->fetch_object();
                                $exchange = $row_exchange->usd_or_real;
                                if ($active == $exchange) {
                                    echo '<i class="fa fa-check" aria-hidden="true"></i>';
                                }
                            }

                            ?>

                            <div class="col-md-2">
                                <button value="usd" class="btn btn-primary chang_branch <?php active_usd("usd") ?>"><?php active_check("usd") ?> USD($)</button>
                            </div>
                            <div class="col-md-2">
                                <button value="real" class="btn btn-primary chang_branch <?php active_usd("real") ?>"><?php active_check("real") ?> រៀល(៛)</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>



        </div>
    </div><!-- /.container-fluid -->
</section>


<script>
    $('.chang_branch').on('click', function() {
        var val = $(this).attr("value");
        $.ajax({
            url: "../resources/templates/back/update_real.php",
            method: "post",
            data: {
                val: val
            },
            success: function(data) {
                window.location.href = 'itemt?exchange';
            }

        });
    })
</script>