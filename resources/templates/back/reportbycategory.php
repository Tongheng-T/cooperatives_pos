<?php


if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
    header("Location: ../");
}

?>
<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Sales Report -> Table Report
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
    <?php
    if (isset($_POST['date_1'])) {
        $_SESSION['date'] = $_POST['date_1'];
        $date_1 = $_POST['date_1'];
        $date_2 = $_POST['date_2'];
        $category_id = $_POST['category_id'];

        $_SESSION['date_1'] = $date_1;
        $_SESSION['date_2'] = $date_2;
    } else {
        $date_1 = date('Y-m-01');
        $date_2 = date("Y-m-d");
        $_SESSION['date'] = $date_1;
        $_SESSION['date_1'] = $date_1;
        $_SESSION['date_2'] = $date_2;
        $category_id = ' ';
    }

    ?>

    <div class="box box-warning">
        <form action="" method="post" name="">
            <div class="box-header with-border">
                <!-- <h3 class="box-title">From : <?php echo $date_1 ?> -- To : <?php echo $date_2 ?></h3> -->
                <h3 class="box-title">From : <?php echo date('d-m-Y', strtotime($date_1)) ?> -- To : <?php echo date('d-m-Y', strtotime($date_2)) ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

            <div class="box-body">

                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="datepicker1" name="date_1" value="<?php echo $date_1; ?>" data-date-format="yyyy-mm-dd">
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="datepicker2" name="date_2" value="<?php echo $date_2; ?>" data-date-format="yyyy-mm-dd">
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-tasks"></i>
                            </div>
                            <select class="form-control addEventListener" name="category_id" required>

                                <?php
                                show_name_category($category_id);
                                $select = query("SELECT * from tbl_category order by catid desc");
                                confirm($select);
                                while ($row = $select->fetch_object()) {

                                    echo '
                                    <option value="' . $row->catid . '">' . $row->category . '</option>
                                ';
                                }
                                ?>
                            </select>
                        </div>

                    </div>
                    <div class="col-md-2">
                        <div align="left">
                            <input type="submit" name="btndatefilter" value="Filter By Dater" class="btn btn-success">
                        </div><br>
                        <!-- <button onclick="window.open('print2')" class="btn btn-primary" id="print-btn">Print</button> -->
                    </div>

                </div>


                <table id="salesreporttable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>N.0</th>
                            <th>Invoice ID</th>
                            <th>Product Namme</th>
                            <th>price</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>OrderDate</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $select = query("SELECT * from tbl_invoice_details where order_date between '$date_1' AND '$date_2' AND  category_id ='$category_id'");
                        confirm($select);
                        $totall = 0;
                        $no = 1;
                        while ($row = $select->fetch_object()) {
                            $total = $row->price * $row->qty;
                            echo '
                                <tr>
                                <td>' . $no . '</td>
                                <td>' . $row->invoice_id . '</td>
                                <td>' . show_productname($row->product_id) . '</td>
                                <td>'. number_format($row->price) . ' <b style="font-size: 14px;">&#x17DB</b></td>        
                                <td>' . $row->qty . '</td>                 
                                <td><span class="label label-danger">' . number_format($total) . ' <b style="font-size: 14px;">&#x17DB</b></span></td>                 
                                <td>' . date('d-m-Y', strtotime($row->order_date)) . '</td>   
                                ';
                            $totall += $total;
                            $no++;
                        }
                        echo
                        '<tr>
                        <td colspan="4"></td>
                        <th>សរុប</th>
                        <th>' . number_format($totall) . ' <b style="font-size: 16px;">&#x17DB </b></th>
                        </tr>
                         ';

                        ?>

                    </tbody>

                </table>



            </div>
        </form>
    </div>

</section>
<!-- /.content -->

<!-- /.content-wrapper -->

<script>
    //Date picker
    $('#datepicker1').datepicker({
        autoclose: true
    });

    //Date picker
    $('#datepicker2').datepicker({
        autoclose: true
    });

    $('#salesreporttable').DataTable({

    });
</script>