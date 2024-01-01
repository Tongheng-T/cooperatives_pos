<?php

if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "") {
  header("Location: ../");
}



// if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
//     header('location:index.php');
// }


if (isset($_POST['btnsaveorder'])) {
  $order_date = date('Y-m-d', strtotime($_POST['orderdate']));
  ////////////////////////////////////
  $arr_name_cost = $_POST['name_cost'];
  $arr_qty_cost = $_POST['qty_cost'];
  $category_id = $_POST['category_id'];

  if (empty($arr_qty_cost)) {
    set_message('<script type="text/javascript">
    jQuery(function validation(){
      swal({
        title:"Error!",
        text: "NO Data",
        icon: "error",
        button: "Ok",
      });
    });
    </script>');
  } else {
    // 2nd insert query for tbl_invoice_details
    for ($i = 0; $i < count($arr_name_cost); $i++) {

      $insert = query("INSERT into tbl_cost(name_cost,qty_cost,cost_date,category_id)values('{$arr_name_cost[$i]}','{$arr_qty_cost[$i]}','{$order_date}','{$category_id[$i]}')");

      redirect("itemt?cost");
    }
  }
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
              <input type="text" class="form-control pull-right" id="datepicker" name="orderdate" value="<?php echo date("Y-m-d"); ?>" data-date-format="yyyy-mm-dd">
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
                  <th>មុខរបរ</th>
                  <th>
                    <center><button type="button" name="add" class="btn btn-success btn-sm btnadd"> <span class="glyphicon glyphicon-plus"></span></button></center>
                  </th>
                </tr>
              </thead>

            </table>
          </div>
        </div>
      </div> <!--this for table -->
      <!--tax dis. etc-->
      <hr>
      <div align="center">
        <input type="submit" name="btnsaveorder" value="Save" class="btn btn-info">

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
                <th>មុខរបរ</th>
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
                      <td>' . show_name_category_inview_cos($row->category_id) . '</td>
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
<!-- /.content -->

<!-- /.content-wrapper -->

<script>
  // function Calc(v){
  //     var index = $(v).parent().parent().index();
  //     var qty = document.getElementsByName("qty")[index].value;
  //     var price = document.getElementsByName("price")[index].value;
  //     var total = qty * price;
  //     document.getElementsByName("total")[index].value = total;
  // }
  //Date picker
  $('#datepicker').datepicker({
    autoclose: true
  });


  //Red color scheme for iCheck
  // $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
  //     checkboxClass: 'icheckbox_minimal-red',
  //     radioClass: 'iradio_minimal-red'
  // });

  $(document).ready(function() {

    $(document).on('click', '.btnadd', function() {
      var html = '';
      html += '<tr>';
      html += '<td> <input type="text" class="form-control name" name="name_cost[]"></td>';
      html += '<td> <input type="number" min="1" class="form-control qty" name="qty_cost[]" required></td>';
      html += '<td> <select class="form-control category_id" name="category_id[]" style="width: 250px";><option value=""disabled selected>Select Option</option><?php fill_category(); ?></select></td>';
      html += '<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove"> <span class="glyphicon glyphicon-remove"></span></button></center></td>';
      $('#producttable').append(html);

      //Initialize Select2 Elements

    })

    $(document).on('click', '.btnremove', function() {

      $(this).closest('tr').remove();
      calculate(0, 0);
      $("#txtpaid").val(0);
    })



  });
</script>
<script>
  function autoCalcSetup() {
    $('form#cart').jAutoCalc('destroy');
    $('form#cart tr.line_items').jAutoCalc({
      keyEventsFire: true,
      decimalPlaces: 2,
      emptyAsZero: true
    });
    $('form#cart').jAutoCalc({
      decimalPlaces: 2
    });
  }
  autoCalcSetup();
</script>
<script>
  $(document).ready(function() {
    $('.btn-danger').click(function() {
      var tdh = $(this);
      var id = $(this).attr("id");
      swal({
          title: "Do you want to delete ?",
          text: "deleted, you can not recover it !",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: '../resources/templates/back/delete_cost.php',
              type: 'post',
              data: {
                pidd: id
              },
              success: function(data) {
                tdh.parents('tr').hide();
              }
            });

            swal({
              title: "បានលុបការចំណាយ !",
              text: "Account is deleted!",
              icon: "success",
              button: "Ok",
            });
          } else {
            swal("Your Order is safe!");
          }
        });


      // alert(id);

    });
  });
</script>