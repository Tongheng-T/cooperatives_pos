<?php

if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "") {
    header("Location: ../");
}



// if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
//     header('location:index.php');
// }


display_message();

if (isset($_POST['btnsaveorder'])) {
    $order_date = date('Y-m-d', strtotime($_POST['orderdate']));
    ////////////////////////////////////

    $arr_productid = $_POST['productid'];
    $arr_productname = $_POST['productname'];
    $arr_stock = $_POST['stock'];
    $arr_newstock = $_POST['newstock'];


    // 2nd insert query for tbl_invoice_details

    for ($i = 0; $i < count($arr_productid); $i++) {

        $rem_qty = $arr_stock[$i] + $arr_newstock[$i];

        if ($rem_qty < 0) {
            return "Order Is not Comlete";
        } else {
            $update = query("UPDATE tbl_product SET pstock='$rem_qty'where pid='" . $arr_productid[$i] . "'");
            confirm($update);
        }

        set_message(' <script type="text/javascript">
            jQuery(function validation(){
            swal({
              title:"Good Job!", 
              text: "បានបន្ថែមស្តុក​",
              icon: "success",
              button: "Ok",
              });
            });
             </script>');
        redirect("itemt?add_stock");
    }
}



?>
<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Add Stock
        <small></small>
    </h1>

</section>

<!-- Main content -->
<section class="content container-fluid">

    <!--------------------------
        | Your Page Content Here |
        -------------------------->


    <div class="box box-warning">
        <form id="cart" action="" method="post" name="">
            <div class="box-header with-border">
                <h3 class="box-title">Add Stock</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="col-md-12">
                    <div style="overflow-x:auto;">
                        <table id="producttable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Search Product</th>
                                    <th>Stock</th>
                                    <th>New Stock</th>

                                    <th>
                                        <center><button type="button" name="add" class="btn btn-success btn-sm btnadd"> <span class="glyphicon glyphicon-plus"></span></button></center>
                                    </th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div> <!--this for table -->

            <hr>
            <div align="center">
                <input type="submit" class="btn btn-info" name="btnsaveorder" value="Add Stock" disabled>

            </div>
            <hr>
        </form>
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
    // $('#datepicker').datepicker({
    //     autoclose: true
    // });


    //Red color scheme for iCheck
    // $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
    //     checkboxClass: 'icheckbox_minimal-red',
    //     radioClass: 'iradio_minimal-red'
    // });

    $(document).ready(function() {

        $(document).on('click', '.btnadd', function() {
            var html = '';
            html += '<tr>';
            html += '<td> <input type="hidden" class="form-control pname" name="productname[]" readonly></td>';
            html += '<td> <select class="form-control productid" name="productid[]" style="width: 250px";><option value="">Select Option</option><?php fill_product(); ?></select></td>';
            html += '<td> <input type="text" class="form-control stock" name="stock[]" readonly></td>';
            html += '<td> <input type="number" class="form-control newstock" name="newstock[]"></td>';

            html += '<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove"> <span class="glyphicon glyphicon-remove"></span></button></center></td>';
            $('#producttable').append(html);

            //Initialize Select2 Elements
            $('.productid').select2()

            $(".productid").on('change', function(e) {

                var productid = this.value;
                var tr = $(this).parent().parent();
                $.ajax({
                    url: "../resources/templates/back/getproduct.php",
                    method: "get",
                    data: {
                        id: productid
                    },
                    success: function(data) {
                        // console.log(data);

                        tr.find(".pname").val(data["pname"]);
                        tr.find(".stock").val(data["pstock"]);
                        calculate(0, 0);

                    }
                })
            })
            $(".newstock").on('change', function(e) {
                var newstock = $(this).val();
                if (newstock >= 1) {
                    $('.btn-info').prop('disabled', false);
                } else {
                    $('.btn-info').prop('disabled', true);
                }
            })
        })

        $(document).on('click', '.btnremove', function() {

            $(this).closest('tr').remove();
            calculate(0, 0);
            $("#txtpaid").val(0);
        })


    });
</script>