<?php

if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "") {
    header("Location: ../");
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
                                    <th>ល.រ</th>
                                    <th>Invoice ID</th>
                                    <th>Customer Namme</th>
                                    <th>OrderDate</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Payment Type</th>
                                    <th>Phone Number</th>
                                    <th>Print</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php get_products();?>

            <!-- </form> -->

        </div>

    </section>
    <!-- /.content -->

<!-- /.content-wrapper -->

<script>
    // $(document).ready(function() {
    //     $('#orderlisttable').DataTable({
    //         "order": [
    //             [0, "desc"]
    //         ]
    //     });
    // });


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
                            url: '../resources/templates/back/orderdelete.php',
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

