<?php


if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "") {
    header('location:../');
}


$id = $_GET['id'];
$select = query("SELECT * from tbl_invoice where invoice_id =$id");
confirm($select);
$row = $select->fetch_assoc();
$phone = $row['phone'];
$customer_name = $row['customer_name'];
$order_date = date('Y-m-d', strtotime($row['order_date']));
$subtotal = $row["subtotal"];
$tax = $row['tax'];
$discount = $row['discount'];
$total = $row['total'];
$paid = $row['paid'];
$due = $row['due'];
$payment_type = $row['payment_type'];

$row_invoice_detaice = query("SELECT * from tbl_invoice_details where invoice_id ='$id'");
confirm($row_invoice_detaice);
// $row_invoice_detaice = $select->fetch_all();

// if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
//     header('location:index.php');
// }




if (isset($_POST['btnupdateorder'])) {
    $txt_customer_name = $_POST['txtcustomer'];
    $phone = $_POST['txtphone'];
    $txt_order_date = date('Y-m-d', strtotime($_POST['orderdate']));
    $txt_subtotal = $_POST["txtsubtotal"];
    $txt_tax = $_POST['txttax'];
    $txt_discount = $_POST['txtdiscount'];
    $txt_total = $_POST['txttotal'];
    $txt_paid = $_POST['txtpaid'];
    $txt_due = $_POST['txtdue'];
    $txt_payment_type = $_POST['rb'];
    ////////////////////////////////////

    $arr_productid = $_POST['productid'];
    $arr_category_id = $_POST['category_id'];
    $arr_stock = $_POST['stock'];
    $arr_qty = $_POST['qty'];
    $arr_price = $_POST['price'];
    $arr_total = $_POST['total'];


    foreach ($row_invoice_detaice as $item_invoice_details) {
        $updateproduct = query("UPDATE tbl_product set pstock=pstock+" . $item_invoice_details['qty'] . " where pid='" . $item_invoice_details['product_id'] . "'");
        confirm($updateproduct);
    }

    $delete_invoice_details = query("delete from tbl_invoice_details where invoice_id = $id");
    confirm($delete_invoice_details);


    //////////////////////////-------------------------

    $uodate_invoice = query("UPDATE tbl_invoice set customer_name='{$txt_customer_name}',order_date='{$txt_order_date}',subtotal='{$txt_subtotal}',tax='{$txt_tax}',discount='{$txt_discount}',total='{$txt_total}',paid='{$txt_paid}',due='{$txt_due}',payment_type='{$txt_payment_type}',phone='{$phone}' where invoice_id=$id ");
    confirm($uodate_invoice);
    $invoice_id = $id;

    // 2nd insert query for tbl_invoice_details

    if ($invoice_id != null) {
        for ($i = 0; $i < count($arr_productid); $i++) {

            ////////////////////////////////6
            $selectpdt = query("SELECT * from tbl_product where pid='" . $arr_productid[$i] . "'");
            confirm($selectpdt);

            while ($rowpdt = $selectpdt->fetch_object()) {
                $db_stock[$i] = $rowpdt->pstock;

                $rem_qty = $db_stock[$i] - $arr_qty[$i];

                if ($rem_qty < 0) {
                    return "Order Is not Comlete";
                } else {
                    $update = query("UPDATE tbl_product SET pstock='$rem_qty'where pid='" . $arr_productid[$i] . "'");
                    confirm($update);
                }
            }



            ////7

            $insert = query("INSERT into tbl_invoice_details(invoice_id,product_id,category_id,qty,price,order_date)values('{$id}','{$arr_productid[$i]}','{$arr_category_id[$i]}','{$arr_qty[$i]}','{$arr_price[$i]}','{$txt_order_date}')");
            confirm($insert);

            // echo "success fully created order";
            set_message('<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title:"Update successfull!!",
                text: "Order is deleted!",
                icon: "success",
                button: "Ok",
              });
            });
            </script>');

            redirect('itemt?orderlist');
        }
    }
}





?>
<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Edit Order
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
                <h3 class="box-title">Edit Order</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

            <div class="box-body">

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Customer Name</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </div>
                            <input type="text" class="form-control" name="txtcustomer" value="<?php echo $customer_name; ?>" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <input type="text" class="form-control" name="txtphone" value="<?php echo $phone; ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Date:</label>

                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="datepicker" name="orderdate" value="<?php echo $order_date; ?>" data-date-format="yyyy-mm-dd">
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
                                    <th>#</th>
                                    <th>Search Product</th>
                                    <th>Stock</th>
                                    <th>Price</th>
                                    <th>Enter Quantiy</th>
                                    <th>Total</th>
                                    <th>
                                        <center><button type="button" name="add" class="btn btn-info btn-sm btnadd"> <span class="glyphicon glyphicon-plus"></span></button></center>
                                    </th>
                                </tr>
                            </thead>

                            <?php

                            foreach ($row_invoice_detaice as $item_invoice_details) {
                                $select = query("SELECT * FROM tbl_product WHERE pid='{$item_invoice_details['product_id']}'");
                                confirm($select);

                                $row_product = $select->fetch_assoc();

                            ?>
                                <tr>
                                    <?php

                                    echo '<td> <input type="hidden" class="form-control category_id" name="category_id[]"  value="' . $row_product['category_id'] . '" readonly></td>';

                                    echo '<td> <select class="form-control productidedit" name="productid[]" style="width: 250px";><option value="">Select Option</option>' . fill_productt($item_invoice_details['product_id']) . '</select></td>';

                                    echo '<td> <input type="text" class="form-control stock" name="stock[]" value="' . $row_product['pstock'] . '" readonly></td>';
                                    echo '<td> <input type="text" class="form-control price" name="price[]" value="' . $row_product['saleprice'] . '" readonly></td>';
                                    echo '<td> <input type="number" min="1" class="form-control qty" name="qty[]" value="' . $item_invoice_details['qty'] . '"></td>';
                                    echo '<td> <input type="text" class="form-control total" name="total[]" value="' . $row_product['saleprice'] * $item_invoice_details['qty'] . '" readonly></td>';

                                    echo '<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove"> <span class="glyphicon glyphicon-remove"></span></button></center></td>';
                                    ?>
                                </tr>
                            <?php } ?>

                        </table>
                    </div>
                </div>
            </div> <!--this for table -->
            <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>SubTotal</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa" style="font-size: 30px;">៛</i>
                            </div>
                            <input type="text" class="form-control" value="<?php echo $subtotal; ?>" name="txtsubtotal" id="txtsubtotal" required readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tax (5%)</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa" style="font-size: 30px;">៛</i>
                            </div>
                            <input type="text" class="form-control" value="<?php echo $tax; ?>" name="txttax" id="txttax" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Discount</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa" style="font-size: 30px;">៛</i>
                            </div>
                            <input type="text" class="form-control" value="<?php echo $discount; ?>" name="txtdiscount" id="txtdiscount" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Total</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa" style="font-size: 30px;">៛</i>
                            </div>
                            <input type="text" class="form-control" value="<?php echo $total; ?>" name="txttotal" id="txttotal" required readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Paid</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa" style="font-size: 30px;">៛</i>
                            </div>
                            <input type="text" class="form-control" value="<?php echo $paid; ?>" name="txtpaid" id="txtpaid" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Due</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa" style="font-size: 30px;">៛</i>
                            </div>
                            <input type="text" class="form-control" value="<?php echo $due; ?>" name="txtdue" id="txtdue" required readonly>
                        </div>
                    </div>

                    <label>Payment Method</label>
                    <div class="form-group">
                        <label>
                            <input type="radio" name="rb" class="minimal-red" value="Cash" <?php echo ($payment_type == 'Cash') ? 'checked' : '' ?>> CASH
                        </label>
                        <label>
                            <input type="radio" name="rb" class="minimal-red" value="Card" <?php echo ($payment_type == 'Card') ? 'checked' : '' ?>> CARD
                        </label>
                        <label>
                            <input type="radio" name="rb" class="minimal-red" value="Check" <?php echo ($payment_type == 'Check') ? 'checked' : '' ?>>
                            CHECK
                        </label>
                    </div>
                </div>

            </div> <!--tax dis. etc-->
            <hr>
            <div align="center">
                <input type="submit" name="btnupdateorder" value="Update Order" class="btn btn-warning">

            </div>
            <hr>
        </form>
    </div>

</section>
<!-- /.content -->

<!-- /.content-wrapper -->

<script>
    //Date picker
    $('#datepicker').datepicker({
        autoclose: true
    });


    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    });

    $(document).ready(function() {



        $('.productidedit').select2()

        $(".productidedit").on('change', function(e) {

            var productid = this.value;
            var tr = $(this).parent().parent();
            $.ajax({
                url: "../../resources/templates/back/getproduct.php",
                method: "get",
                data: {
                    id: productid
                },
                success: function(data) {
                    // console.log(data);

                    tr.find(".category_id").val(data["category_id"]);
                    tr.find(".stock").val(data["pstock"]);
                    tr.find(".price").val(data["saleprice"]);
                    tr.find(".qty").val(1);
                    tr.find(".total").val(tr.find(".qty").val() * tr.find(".price").val());
                    calculate(0, 0);
                    $("#txtpaid").val("");
                }
            })
        })





        $(document).on('click', '.btnadd', function() {
            var html = '';
            html += '<tr>';
            html += '<td> <input type="hidden" class="form-control category_id" name="category_id[]" readonly></td>';

            html += '<td> <select class="form-control productid" name="productid[]" style="width: 250px";><option value="">Select Option</option><?php fill_product(); ?></select></td>';

            html += '<td> <input type="text" class="form-control stock" name="stock[]" readonly></td>';
            html += '<td> <input type="text" class="form-control price" name="price[]" readonly></td>';
            html += '<td> <input type="number" min="1" class="form-control qty" name="qty[]"></td>';
            html += '<td> <input type="text" class="form-control total" name="total[]" readonly></td>';

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

                        tr.find(".category_id").val(data["category_id"]);
                        tr.find(".stock").val(data["pstock"]);
                        tr.find(".price").val(data["saleprice"]);
                        tr.find(".qty").val(1);
                        tr.find(".total").val(tr.find(".qty").val() * tr.find(".price").val());
                        calculate(0, 0);
                        $("#txtpaid").val("");
                    }
                })
            })
        })

        $(document).on('click', '.btnremove', function() {

            $(this).closest('tr').remove();
            calculate(0, 0);
            $("#txtpaid").val("");
        })

        $("#producttable").delegate(".qty", "keyup change", function() {
            var quantity = $(this);
            var tr = $(this).parent().parent();
            $("#txtpaid").val("");
            if ((quantity.val() - 0) > (tr.find(".stock").val() - 0)) {
                swal("WARNING!", "SORRY! This much of quantity is not available", "warning");
                quantity.val(1);
                tr.find(".total").val(quantity.val() * tr.find(".price").val());
                calculate(0, 0);
            } else {
                tr.find(".total").val(quantity.val() * tr.find(".price").val());
                calculate(0, 0);
            }
        })

        function calculate(dis, paid) {
            var subtotal = 0;
            var tax = 0;
            var discount = dis;
            var net_total = 0;
            var paid_amt = paid;
            var due = 0;

            $(".total").each(function() {
                subtotal = subtotal + ($(this).val() * 1);
            })

            tax = 0 * subtotal;
            net_total = tax + subtotal;
            net_total = net_total - discount;
            due = net_total - paid_amt;


            $("#txtsubtotal").val(subtotal.toFixed(2));
            $("#txttax").val(tax.toFixed(2));
            $("#txttotal").val(net_total.toFixed(2));
            $("#txtdiscount").val(discount);
            $("#txtdue").val(due.toFixed(2));

            $("#txtdiscount").keyup(function() {
                var discount = $(this).val();
                calculate(discount, 0);
            })
            $("#txtpaid").keyup(function() {
                var paid = $(this).val();
                var discount = $("#txtdiscount").val();
                calculate(discount, paid);
            })
        }


    });
</script>