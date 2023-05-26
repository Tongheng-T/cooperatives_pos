<?php


if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
  header("Location: ../");
}


$query = query("SELECT sum(total) as t , count(invoice_id) as inv from tbl_invoice");
confirm($query);
$row =  $query->fetch_object();

$total_order = $row->inv;
$net_total = $row->t;



$query = query("SELECT order_date, sum(total) as subtotal  from tbl_invoice group by order_date LIMIT 30");

$ttl = [];
$date = [];
while ($row = fetch_array($query)) {

  extract($row);
  $ttl[] = $subtotal;
  $date[] = $order_date;
}
// echo json_encode($total);





?>
<!-- Content Wrapper. Contains page content -->

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Admin Dashboard
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="itemt?dashboard"><i class="fa fa-dashboard"></i> Level</a></li>
      <li class="activee">Here</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content container-fluid">

    <!--------------------------
        | Your Page Content Here |
        -------------------------->

    <div class="box-body">

      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $total_order; ?></h3>

              <p>Total Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="itemt?orderlist" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo number_format($net_total); ?> <i class="fa" style="font-size: 40px;">៛</i> <sup style="font-size: 20px"></sup></h3>

              <p>Total Revenue</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

        <?php
        $query = query("SELECT count(pname) as p from tbl_product");
        confirm($query);
        $row =  $query->fetch_object();

        $total_product = $row->p;

        ?>


        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $total_product; ?></h3>

              <p>Total Product</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="itemt?productlist" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <?php
        $query = query("SELECT count(category) as cate from tbl_category");
        confirm($query);
        $row =  $query->fetch_object();

        $total_category = $row->cate;

        ?>

        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $total_category; ?></h3>

              <p>Total Category</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="itemt?category" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>



      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Earning By Date</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->

        <div class="box-body">
          <div class="chart">
            <canvas id="earningbydate" style="height: 250px;"></canvas>
          </div>

        </div>

      </div>


      <div class="row">
        <div class="col-md-6">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Best Selling Product</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
              <table id="bestsellingproductlist" class="table table-striped">
                <thead>
                  <tr>
                    <th>Product ID</th>
                    <th>Product Namme</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $query = query("SELECT product_id,price, sum(qty) as q, sum(qty*price) as total from tbl_invoice_details group by product_id order by sum(qty) DESC LIMIT 30");
                  confirm($query);
                  while ($row = mysqli_fetch_object($query)) {
                    // <i class="fa" style="font-size: 30px;">៛</i>
                    echo '
                          <tr>
                          <td>' . $row->product_id . '</td>
                          <td>' . show_productname($row->product_id) . '</td>
                          <td><span class="label label-info">' . $row->q . '</span></td>
                          <td><span class="label label-success">' . number_format($row->price) . ' <b style="font-size: 14px;">&#x17DB</b></span></td>
                          <td><span class="label label-danger">' . number_format($row->total) . ' <b style="font-size: 14px;">&#x17DB</b></span></td>
                        
                          </tr>
                          ';
                  }


                  ?>

                  <!-- <td>
                            <a href="deleteproduct.php?id=' . $row->pid . '" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Product"></span></a>
                        </td> -->
                </tbody>

              </table>
            </div>
          </div>

        </div>
        <div class="col-md-6">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Recent Orders</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
              <table id="orderlisttable" class="table table-striped">
                <thead>
                  <tr>
                    <th>Invoice ID</th>
                    <th>CustomerNamme</th>
                    <th>OrderDate</th>
                    <th>Total</th>
                    <th>Payment Type</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $query = query("SELECT * from tbl_invoice order by invoice_id desc LIMIT 50");
                  confirm($query);
                  while ($row = mysqli_fetch_object($query)){

                    echo '
                          <tr>
                          <td><a href="itemt?editorder&id=' . $row->invoice_id . '">' . $row->invoice_id . '</a></td>
                          <td>' . $row->customer_name . '</td>
                          <td>' . $row->order_date . '</td>
                          <td><span class="label label-danger">' . number_format($row->total) . ' <b style="font-size: 14px;">&#x17DB</b></span></td>
                          ';

                    if ($row->payment_type == "Cash") {
                      echo '<td><span class="label label-warning">' . $row->payment_type . '</span></td>';
                    } elseif ($row->payment_type == "Card") {
                      echo '<td><span class="label label-success">' . $row->payment_type . '</span></td>';
                    } else {
                      echo '<td><span class="label label-primary">' . $row->payment_type . '</span></td>';
                    }
                  }



                  ?>

                  <!-- <td>
                            <a href="deleteproduct.php?id=' . $row->pid . '" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Product"></span></a>
                        </td> -->
                </tbody>

              </table>
            </div>
          </div>

        </div>

      </div>

    </div>

  </section>
  <!-- /.content -->

<!-- /.content-wrapper -->


<script>
  var ctx = document.getElementById('earningbydate').getContext('2d');
  var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
      labels: <?php echo  json_encode($date); ?>,
      datasets: [{
        label: 'Total Earning',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: <?php echo json_encode($ttl); ?>
      }]
    },

    // Configuration options go here
    options: {}
  });
</script>

<script>
  $(document).ready(function() {
    $('#bestsellingproductlist').DataTable({

    });
  });
</script>

<script>
  $(document).ready(function() {
    $('#orderlisttable').DataTable({
      "order": [
        [0, "desc"]
      ]
    });
  });
</script>

