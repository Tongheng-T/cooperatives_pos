<?php

if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "") {
    header("Location: ../../public");
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
            <!-- <form action="" method="post" name=""> -->
                <div class="box-header with-border">
                    <h3 class="box-title">Order List</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->

                <div class="box-body">
                    <div style="overflow-x:auto;">
                        <table id="orderlisttable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Invoice ID</th>
                                    <th>Customer Namme</th>
                                    <th>OrderDate</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Payment Type</th>
                                    <th>Print</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $select = query("SELECT * from tbl_invoice order by invoice_id desc");
                                confirm($select);
                                while ($row = $select->fetch_object()) {

                                    echo '
                                <tr>
                                <td>' . $row->invoice_id . '</td>
                                <td>' . $row->customer_name . '</td>
                                <td>' . $row->order_date . '</td>
                                <td>' . $row->total . '</td>
                                <td>' . $row->paid . '</td>
                                <td>' . $row->due . '</td>
                                <td>' . $row->payment_type . '</td>
                               
                                <td>
                                <a href="invoice_80mm_1.php?id=' . $row->invoice_id . '" class="btn btn-warning" role="button" target=_blank><span class="glyphicon glyphicon-print" style="color:#ffffff" data-toggle="tooltip" title="Print Invoice"></span></a>
                                </td>

                                <td>
                                <a href="itemt?editorder&id=' . $row->invoice_id . '" class="btn btn-info" role="button"><span class="glyphicon glyphicon-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Order"></span></a>
                                </td>

                                <td>
                                <button id=' . $row->invoice_id . ' class="btn btn-danger btndelete"> <span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Order"></span></button>
                                </td>
                          
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
            <!-- </form> -->

        </div>

    </section>
    <!-- /.content -->

<!-- /.content-wrapper -->

<script>
    $(document).ready(function() {
        $('#orderlisttable').DataTable({
            "order": [
                [0, "desc"]
            ]
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });



    $(document).ready(function() {
        $('.btndelete').click(function() {
            var tdh = $(this);
            var id = $(this).attr("id");

            swal({
                    title: "Do you want to delete Order?",
                    text: "Once Order is deleted, you can not recover it !",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: '../../resources/templates/back/orderdelete.php',
                            type: 'post',
                            data: {
                                pidd: id
                            },
                            success: function(data) {
                                tdh.parents('tr').hide();
                            }
                        });

                        swal("Your Order has been deleted!", {
                            icon: "success",
                        });
                    } else {
                        swal("Your Order is safe!");
                    }
                });


            // alert(id);

        });
    });
</script>

