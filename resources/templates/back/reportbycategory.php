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

        $_SESSION['category_id'] = $category_id;

        $_SESSION['date_1'] = $date_1;
        $_SESSION['date_2'] = $date_2;
    } else {
        $date_1 = date('Y-m-01');
        $date_2 = date("Y-m-d");
        $_SESSION['date'] = $date_1;
        $_SESSION['date_1'] = $date_1;
        $_SESSION['date_2'] = $date_2;
        $category_id = ' ';
        $_SESSION['category_id'] = $category_id;
    }

    error_reporting(0);
    $tbl_cost = query("SELECT sum(qty_cost) as total_cost from tbl_cost where cost_date between '$date_1' AND '$date_2'and category_id > 1");
    confirm($tbl_cost);
    $row_cost = $tbl_cost->fetch_object();

    $tbl_invoice_details = query("SELECT * from tbl_invoice_details where order_date between '$date_1' AND '$date_2' AND  category_id ='$category_id'");
    confirm($tbl_invoice_details);

    $no = 1;
    $total = 0;
    $stotal = 0;
    $discount = 0;
    while ($row = $tbl_invoice_details->fetch_object()) {
        $invoice_id = $row->invoice_id;
        $total_sel = $row->price * $row->qty;
        $purchaseprice = show_purchaseprice($row->product_id);
        $select2 = query("SELECT * from tbl_invoice where order_date between '$date_1' AND '$date_2' AND invoice_id = '$invoice_id'");
        confirm($select2);
        while ($rowin = $select2->fetch_object()) {
            $discount += $rowin->discount;

        }

        $total += $purchaseprice;
        $stotal += $total_sel;
    }

    // $net_total = $row->total;



    $cost = $row_cost->total_cost;

    $total_cost = $stotal - $cost - $total;

    $total_jomnay = $cost;
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
                        <button onclick="window.open('print_category')" class="btn btn-primary" id="print-btn">Print</button>
                    </div>

                </div><br>



                <div class="row">

                    <!-- fix for small devices only -->
                    <div class="clearfix visible-sm-block"></div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
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
                    <!-- <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-aqua"><i class="fa" style="font-size: 96px; ">៛</i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Discount</span>
                                <span class="info-box-number">
                                    <h2><?php echo $discount; ?></h2>
                                </span>
                            </div>
                         
                        </div>
                       
                    </div> -->
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-yellow"><i class="fa" style="font-size: 96px; ">៛</i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">ចំណាយផ្សេងៗ</span>
                                <span class="info-box-number">
                                    <h2><?php echo number_format($total_jomnay); ?></h2>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-red"><i class="fa" style="font-size: 96px; ">៛</i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">ថ្លៃដើម</span>
                                <span class="info-box-number">
                                    <h2><?php echo number_format($total); ?></h2>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>


                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-blue"><i class="fa" style="font-size: 96px; ">៛</i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">ប្រាក់ចំណេញ</span>
                                <span class="info-box-number">
                                    <h2><?php echo number_format($total_cost); ?></h2>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                </div>

                <table id="salesreporttable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>N.0</th>
                            <th>Invoice ID</th>
                            <th>Customer Name</th>
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
                            $invoice_id = $row->invoice_id;
                            $select2 = query("SELECT * from tbl_invoice where order_date between '$date_1' AND '$date_2' AND invoice_id = '$invoice_id'");
                            confirm($select2);
                            while ($rowin = $select2->fetch_object()) {
                                $customer_name = $rowin->customer_name;
                            }
                            echo '
                                <tr>
                                <td>' . $no . '</td>                               
                                <td>' . $invoice_id . '</td>
                                <td>' . $customer_name . '</td>
                                <td>' . show_productname($row->product_id) . '</td>
                                <td>' . number_format($row->price) . ' <b style="font-size: 14px;">&#x17DB</b></td>        
                                <td>' . $row->qty . '</td>                 
                                <td><span class="label label-danger">' . number_format($total) . ' <b style="font-size: 14px;">&#x17DB</b></span></td>                 
                                <td>' . date('d-m-Y', strtotime($row->order_date)) . '</td> 
                                ';
                            $totall += $total;
                            $no++;
                        }

                        echo
                        '<tr>
                        <td colspan="5"></td>
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