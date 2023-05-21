<?php

error_reporting(0);

if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
    header("Location: ../../public");
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
if(isset($_POST['date_1'])){
    $date_1 = $_POST['date_1'];
    $date_2 = $_POST['date_2'];

    $_SESSION['date_1'] = $date_1;
    $_SESSION['date_2'] = $date_2;
}else{
    $date_1 = date("Y-n-j", strtotime("first day of previous month"));
    $date_2 = date("Y-m-d");
    $_SESSION['date_1'] = $date_1;
    $_SESSION['date_2'] = $date_2;
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
                        <div class="col-md-5">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="datepicker1" name="date_1" value="<?php echo $date_1; ?>"
                                    data-date-format="yyyy-mm-dd">
                            </div>

                        </div>
                        <div class="col-md-5">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="datepicker2" name="date_2" value="<?php echo $date_2; ?>"
                                    data-date-format="yyyy-mm-dd">
                            </div>

                        </div>
                        <div class="col-md-2">
                            <div align="left">
                                <input type="submit" name="btndatefilter" value="Filter By Dater"
                                    class="btn btn-success">   
                            </div><br>
                            <button onclick="window.open('print')" class="btn btn-primary" id="print-btn">Print</button>
                        </div>

                    </div>




                    <br><br>

                    <?php
                    $select = query("SELECT sum(total) as total , sum(subtotal) as stotal,count(invoice_id) as invoice from tbl_invoice where order_date between '$date_1' AND '$date_2'");
                    confirm($select);
                    $row = $select->fetch_object();

                    $net_total = $row->total;

                    $stotal = $row->stotal;

                    $invoice = $row->invoice;






                    ?>
                    <!-- Info boxes -->
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-aqua"><i class="fa fa-files-o"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Total Invoice</span>
                                    <span class="info-box-number">
                                        <h2><?php echo $invoice;?></h2>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->

                        <!-- /.col -->

                        <!-- fix for small devices only -->
                        <div class="clearfix visible-sm-block"></div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="fa" style="font-size: 96px; ">៛</i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Sub Total</span>
                                    <span class="info-box-number">
                                        <h2><?php echo number_format($stotal); ?></h2>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-yellow"><i class="fa" style="font-size: 96px; ">៛</i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Net Total</span>
                                    <span class="info-box-number">
                                        <h2><?php echo number_format($net_total); ?></h2>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                    </div>

                    <br>




                    <table id="salesreporttable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>n0</th>
                                <th>Invoice ID</th>
                                <th>Customer Namme</th>
                                <th>Subtotal</th>
                                <th>Tax(5%)</th>
                                <th>Discount</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>OrderDate</th>
                                <th>Payment Type</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $select = query("SELECT * from tbl_invoice where order_date between '$date_1' AND '$date_2'");
                            confirm($select);
                          $no=1;
                            while ($row = $select->fetch_object()) {
                                
                                echo '
                                <tr>
                                <td>' . $no . '</td>
                                <td>' . $row->invoice_id . '</td>
                                <td>' . $row->customer_name . '</td>
                                <td>' . $row->subtotal . '</td>
                                <td>' . $row->tax . '</td>
                                <td>' . $row->discount . '</td>
                                <td><span class="label label-danger">' . number_format($row->total) . ' <b style="font-size: 14px;">&#x17DB</b></span></td>
                                <td>' . $row->paid . '</td>
                                <td>' . $row->due . '</td>

                                
                                <td>' . date('d-m-Y', strtotime($row->order_date)) . '</td>
                               
                          
                                
                                ';
                                if ($row->payment_type == "Cash") {

                                    echo '<td><span class="label label-primary">' . $row->payment_type . '</span></td>';
                                } elseif ($row->payment_type == "Card") {
                                    echo '<td><span class="label label-warning">' . $row->payment_type . '</span></td>';
                                } else {
                                    echo '<td><span class="label label-info">' . $row->payment_type . '</span></td>';
                                }
                                $no++;
                            }


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
    "order": [
        [0, "desc"]
    ]
});
</script>
