<?php

if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
    header("Location: ../");
}


display_message();

?>
<!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Product List
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
            <div class="box-header with-border">
                <h3 class="box-title">Product List</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->


            <div class="box-body">
                <div style="overflow-x:auto;">
                    <table id="tablecategory" class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product name</th>
                                <th>Category</th>
                                <th>Purchaseprice</th>
                                <th>Sale Price</th>
                                <th>Stock</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>View</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $select = query("SELECT * from tbl_product order by pid desc");
                            confirm($select);
                            while ($row = $select->fetch_object()) {

                                echo '
                                <tr>
                                <td>' . $row->pid . '</td>
                                <td>' . $row->pname . '</td>
                                <td>' . $row->pcategory . '</td>
                                <td>' . $row->purchaseprice . '</td>
                                <td>' . $row->saleprice . '</td>
                                <td>' . $row->pstock . '</td>
                                <td>' . $row->pdescription . '</td>
                                <td><img src="../productimages/' . $row->pimage . '" class="img-rounded" width=50; height="50" alt="photo"></td>
                                <td>
                                <a href="itemt?viewproduct&id=' . $row->pid . '" class="btn btn-success" role="button"><span class="glyphicon glyphicon-eye-open" style="color:#ffffff" data-toggle="tooltip" title="View Product"></span></a>
                                </td>

                                <td>
                                <a href="itemt?editproduct&id=' . $row->pid . '" class="btn btn-info" role="button"><span class="glyphicon glyphicon-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Product"></span></a>
                                </td>

                                <td>
                                <button id=' . $row->pid . ' class="btn btn-danger btndelete"> <span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Product"></span></button>
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
        </div>


    </section>
    <!-- /.content -->

<!-- /.content-wrapper -->

<script>
    $(document).ready(function() {
        $('#tablecategory').DataTable({
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
</script>

<script>
    $(document).ready(function() {
        $('.btndelete').click(function() {
            var tdh = $(this);
            var id = $(this).attr("id");

            swal({
                    title: "Do you want to delete product?",
                    text: "Once product is deleted, you can not recover it !",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: '../resources/templates/back/productdelete.php',
                            type: 'post',
                            data: {
                                pidd: id
                            },
                            success: function(data) {
                                tdh.parents('tr').hide();
                            }
                        });

                        swal("Your Product has been deleted!", {
                            icon: "success",
                        });
                    } else {
                        swal("Your Product is safe!");
                    }
                });


            // alert(id);

        });
    });
</script>
