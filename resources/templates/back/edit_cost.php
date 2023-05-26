<?php


if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "") {
    header('location:../');
}


$id = $_GET['id'];
$select = query("SELECT * from tbl_cost where id_cost =$id");
confirm($select);
$row = $select->fetch_assoc();
$qty_cost = $row['qty_cost'];
$name_cost = $row['name_cost'];
$order_date = date('Y-m-d', strtotime($row['cost_date']));


if (isset($_POST['btnupdateorder'])) {

    $order_date = date('Y-m-d', strtotime($_POST['orderdate']));
    $arr_name_cost = $_POST['name_cost'];
    $arr_qty_cost = $_POST['qty_cost'];
    $uodate_cost = query("UPDATE tbl_cost set name_cost='{$arr_name_cost}',qty_cost='{$arr_qty_cost}',cost_date='{$order_date}' where id_cost=$id ");

    redirect('itemt?cost');
}




?>
<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 style="font-family: 'KhmerOSMoulLight';">
        ការចំណាយ
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="activee">Here</li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <!--------------------------
        | Your Page Content Here |
        -------------------------->


    <div class="box box-warning">
        <form id="cart" action="" method="post" name="">
            <div class="box-header with-border">
                <h3 class="box-title" style="font-family: 'tong';">ចំណាយ</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

            <div class="box-body">

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Date:</label>

                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="datepicker" name="orderdate" value="<?php echo $order_date ?>" data-date-format="yyyy-mm-dd">
                        </div>
                        <!-- /.input group -->
                    </div>
                </div>


            </div> <!--this is customer and dete -->
            <div class="box-body">
                <div class="col-md-12">
                    <div style="overflow-x:auto;">
                        <table id="producttable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ចំណាយលើ</th>
                                    <th>ចំនួនរៀល</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> <input type="text" class="form-control name" name="name_cost" value="<?php echo $name_cost ?>"></td>
                                    <td> <input type="number" min="1" class="form-control qty" name="qty_cost" value="<?php echo $qty_cost ?>"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!--this for table -->
            <!--tax dis. etc-->
            <hr>
            <div align="center">
                <input type="submit" name="btnupdateorder" value="UPDATE" class="btn btn-info">

            </div>
            <hr>
        </form>
        <div class="box-body">
            <div class="col-md-12">
                <div style="overflow-x:auto;">
                    <table id="salesreporttable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>N.0</th>
                                <th>ចំណាយលើ</th>
                                <th>ចំនួនរៀល</th>
                                <th>Date</th>
                                <th>Edit</th>
                                <th>delete</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $select = query("SELECT * from tbl_cost");
                            confirm($select);
                            $no = 1;
                            $total = 0;
                            while ($row = $select->fetch_object()) {

                                echo '
                      <tr>
                      <td>' . $no . '</td>
                      <td>' . $row->name_cost . '</td>
                      <td>' . number_format($row->qty_cost) . ' ៛</td>
                      <td>' . date('d-m-Y', strtotime($row->cost_date)) . '</td>
                      <td><a href="itemt?edit_cost&id=' . $row->id_cost . '" class="btn btn-info" role="button"><span class="glyphicon glyphicon-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Order"></span></a></td>
                      <td><button id=' . $row->id_cost . ' class="btn btn-danger btndelete"> <span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Order"></span></button></td>
                      </tr>
                      
                      ';
                                $no++;
                                $total += $row->qty_cost;
                            }

                            echo ' 
              <tr>
              <td colspan="1"></td>
              <td>សរុប</td>
              <td>' . number_format($total) . ' ៛</td>
              </tr>';


                            ?>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
</section>


<script>
    $('#datepicker').datepicker({
        autoclose: true
    });
</script>