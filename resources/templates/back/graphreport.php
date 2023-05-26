<?php

// error_reporting(0);

if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
    header("Location: ../");
}

if (isset($_POST['date_1'])) {

    $date_1 = $_POST['date_1'];
    $date_2 = $_POST['date_2'];
} else {
    $date_1 = date("Y-m-01");
    $date_2 = date("Y-m-d");
}
?>
<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Admin Dashboard
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
                            <input type="text" class="form-control pull-right" id="datepicker1" name="date_1" value="<?php echo $date_1; ?>" data-date-format="yyyy-mm-dd">
                        </div>

                    </div>
                    <div class="col-md-5">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="datepicker2" name="date_2" value="<?php echo $date_2; ?>" data-date-format="yyyy-mm-dd">
                        </div>

                    </div>
                    <div class="col-md-2">
                        <div align="left">
                            <input type="submit" name="btndatefilter" value="Filter By Dater" class="btn btn-success">

                        </div>
                    </div>

                </div>




                <br><br>

                <?php
                $select = query("SELECT order_date, sum(total) as price from tbl_invoice where order_date between '$date_1' AND '$date_2' group by order_date");
                confirm($select);

                $total = [];
                $date = [];
                while ($row = $select->fetch_assoc()) {

                    extract($row);
                    $total[] = $price;
                    $date[] = $order_date;
                }
                // echo json_encode($total);

                ?>


                <div class="chart">
                    <canvas id="myChart" style="height: 250px;"></canvas>
                </div>


                <?php
                $select = query("SELECT product_id, sum(qty) as q from tbl_invoice_details where order_date between '$date_1' AND '$date_2' group by product_id");
                confirm($select);
                $pname = [];
                $qty = [];
                while ($row = $select->fetch_assoc()) {

                    extract($row);
                    $pname[] = show_productname($product_id);
                    $qty[] = $q;
                }
                // echo json_encode($total);

                ?>
                <div class="chart">
                    <canvas id="bestsellingproduct" style="height: 250px;"></canvas>
                </div>

            </div>
        </form>
    </div>

</section>
<!-- /.content -->

<!-- /.content-wrapper -->

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',

        // The data for our dataset
        data: {
            labels: <?php echo json_encode($date); ?>,
            datasets: [{
                label: 'Total Earning',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: <?php echo json_encode($total); ?>
            }]
        },

        // Configuration options go here
        options: {}
    });
</script>

<script>
    var ctx = document.getElementById('bestsellingproduct').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: <?php echo json_encode($pname); ?>,
            datasets: [{
                label: 'Total Quantity',
                backgroundColor: 'rgb(100, 207, 225)',
                borderColor: 'rgb(53,137, 187)',
                data: <?php echo json_encode($qty); ?>
            }]
        },

        // Configuration options go here
        options: {}
    });
</script>

<script>
    //Date picker
    $('#datepicker1').datepicker({
        autoclose: true
    });

    //Date picker
    $('#datepicker2').datepicker({
        autoclose: true
    });
</script>