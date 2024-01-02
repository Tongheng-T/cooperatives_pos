<?php


if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
    header("Location: ../");
}


if (isset($_POST['btnsave'])) {
    $category = $_POST['txtcategory'];
    if (empty($category)) {

        $error = '<script type="text/javascript">
    jQuery(function validation(){
      swal({
        title:"Feild is Empty!",
        text: "Please Fill Feild!!",
        icon: "error",
        button: "Ok",
      });
    });
    </script>';

        set_message($error);
    }
    if (!isset($error)) {
        $insert = query("insert into tbl_category(category) values('{$category}')");
        confirm($insert);
        if ($insert) {

            set_message('<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title:"Added!", 
            text: "Your Category is Added!",
            icon: "success",
            button: "Ok",
          });
        });
        </script>');
        } else {
            set_message('<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title:"Error!",
            text: "Query Fail!",
            icon: "error",
            button: "Ok",
          });
        });
        </script>');
        }
    }
}
//// btn_Update 

if (isset($_POST['btnupdate'])) {
    $category = $_POST['txtcategory'];
    $id = $_POST['txtid'];
    if (empty($category)) {

        $errorupdate = '<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title:"Error!",
            text: "Feild is empty : please enter category!",
            icon: "error",
            button: "Ok",
          });
        });
        </script>';

        echo $errorupdate;
    }

    if (!isset($errorupdate)) {
        $update = query("UPDATE tbl_category set category='$category' where catid=" . $id);
        confirm($update);
        if ($update) {

            echo '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title:"Updated!",
                text: "Your Category is Update!",
                icon: "success",
                button: "Ok",
              });
            });
            </script>';
        } else {
            echo '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title:"Error!",
                text: "Your Category is Not Update!",
                icon: "error",
                button: "Ok",
              });
            });
            </script>';
        }
    }
}
//-------------------btn_Delete=======================================


if (isset($_POST['btndelete'])) {
    $delete = query("delete from tbl_category where catid=" . $_POST['btndelete']);
    confirm($delete);
    if ($delete) {
        echo '<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title:"Deleted!",
            text: "Your Category is Deleted!",
            icon: "success",
            button: "Ok",
          });
        });
        </script>';
    } else {
        echo '<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title:"Error!",
            text: "Your Category is Not Deleted!",
            icon: "error",
            button: "Ok",
          });
        });
        </script>';
    }
}




?>
<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Category
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
            <h3 class="box-title">Category Form</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->

        <div class="box-body">
            <form role="form" action="" method="post">

                <?php
                if (isset($_POST['btnedit'])) {
                    $select = query("select * from tbl_category where catid=" . $_POST['btnedit']);
                    confirm($select);
                    if ($select) {
                        $row = mysqli_fetch_object($select);
                        echo '
                        <div class="col-md-4">
                        <div class="form-group">
                            <label>Category</label>
                            <input type="hidden" class="form-control"  value="' . $row->catid . '" name="txtid" placeholder="Enter Category">
                            <input type="text" class="form-control" name="txtcategory" value="' . $row->category . '" placeholder="Enter Category">
                         </div>
                        <button type="submit" name="btnupdate" class="btn btn-info">Update</button>
                        </div>';
                    }
                } else {
                    echo '
                        <div class="col-md-4">
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" class="form-control" name="txtcategory" placeholder="Enter Category">
                        </div>
                        <button type="submit" name="btnsave" class="btn btn-warning">Save</button>
                    </div>';
                }



                ?>





                <div class="col-md-8">

                    <table id="tablecategory" class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>CATEGORY</th>
                                <th>EDIT</th>
                                <th>DELETE</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $select = query("select * from tbl_category order by catid desc");
                            confirm($select);
                            while ($row = mysqli_fetch_object($select)) {

                                echo '
                                <tr>
                                <td>' . $row->catid . '</td>
                                <td>' . $row->category . '</td>
                                <td><button type="submit" value="' . $row->catid . '" name="btnedit" class="btn btn-success">Edit</button></td>
                                <td><button type="submit" value="' . $row->catid . '" name="btndelete" class="btn btn-danger">Delete</button></td>
                                </tr>
                                ';
                            }


                            ?>
                        </tbody>

                    </table>

                </div>




            </form>

        </div>
        <!-- /.box-body -->

        <div class="box-footer">

        </div>

    </div>


    <!-- ////////////////////////////////////////////////////////////////////// -->

    <?php



    if (isset($_POST['btnsave_cos'])) {
        $category = $_POST['txtcategory_cos'];
        if (empty($category)) {

            $error = '<script type="text/javascript">
    jQuery(function validation(){
      swal({
        title:"Feild is Empty!",
        text: "Please Fill Feild!!",
        icon: "error",
        button: "Ok",
      });
    });
    </script>';

            set_message($error);
        }
        if (!isset($error)) {
            $insert = query("insert into tbl_category_cost(cost_category) values('{$category}')");
            confirm($insert);
            if ($insert) {

                set_message('<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title:"Added!", 
            text: "Your Category expnses is Added!",
            icon: "success",
            button: "Ok",
          });
        });
        </script>');
            } else {
                set_message('<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title:"Error!",
            text: "Query Fail!",
            icon: "error",
            button: "Ok",
          });
        });
        </script>');
            }
        }
    }
    //// btn_Update 

    if (isset($_POST['btnupdate_cos'])) {
        $category = $_POST['txtcategory_cos'];
        $id = $_POST['txtid_cos'];
        if (empty($category)) {

            $errorupdate = '<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title:"Error!",
            text: "Feild is empty : please enter category expnses!",
            icon: "error",
            button: "Ok",
          });
        });
        </script>';

            echo $errorupdate;
        }

        if (!isset($errorupdate)) {
            $update = query("UPDATE tbl_category_cost set cost_category='$category' where id_cry_cost=" . $id);
            confirm($update);
            if ($update) {

                echo '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title:"Updated!",
                text: "Your Category expnses is Update!",
                icon: "success",
                button: "Ok",
              });
            });
            </script>';
            } else {
                echo '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title:"Error!",
                text: "Your Category expnses is Not Update!",
                icon: "error",
                button: "Ok",
              });
            });
            </script>';
            }
        }
    }
    //-------------------btn_Delete=======================================


    if (isset($_POST['btndelete_cos'])) {
        $delete = query("delete from tbl_category_cost where id_cry_cost=" . $_POST['btndelete_cos']);
        confirm($delete);
        if ($delete) {
            echo '<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title:"Deleted!",
            text: "Your Category expnses is Deleted!",
            icon: "success",
            button: "Ok",
          });
        });
        </script>';
        } else {
            echo '<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title:"Error!",
            text: "Your Category expnses is Not Deleted!",
            icon: "error",
            button: "Ok",
          });
        });
        </script>';
        }
    }





    ?>



    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">CATEGORY EXPENSES Form</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->

        <div class="box-body">
            <form role="form" action="" method="post">

                <?php
                if (isset($_POST['btnedit_cos'])) {
                    $select_cos = query("select * from tbl_category_cost where id_cry_cost=" . $_POST['btnedit_cos']);
                    confirm($select_cos);
                    if ($select_cos) {
                        $row = mysqli_fetch_object($select_cos);
                        echo '
                        <div class="col-md-4">
                        <div class="form-group">
                            <label>Category</label>
                            <input type="hidden" class="form-control"  value="' . $row->id_cry_cost . '" name="txtid_cos" placeholder="Enter Category">
                            <input type="text" class="form-control" name="txtcategory_cos" value="' . $row->cost_category . '" placeholder="Enter Category">
                         </div>
                        <button type="submit" name="btnupdate_cos" class="btn btn-info">Update</button>
                        </div>';
                    }
                } else {
                    echo '
                        <div class="col-md-4">
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" class="form-control" name="txtcategory_cos" placeholder="Enter Category">
                        </div>
                        <button type="submit" name="btnsave_cos" class="btn btn-success">Save</button>
                    </div>';
                }



                ?>





                <div class="col-md-8">

                    <table id="tablecategory" class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>CATEGORY EXPENSES</th>
                                <th>EDIT</th>
                                <th>DELETE</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $select = query("select * from tbl_category_cost order by id_cry_cost desc");
                            confirm($select);
                            while ($row = mysqli_fetch_object($select)) {

                                echo '
                                <tr>
                                <td>' . $row->id_cry_cost . '</td>
                                <td>' . $row->cost_category . '</td>
        
                                ';
                                if ($row->id_cry_cost == 1) {
                                    echo '<td><button type="submit" value="' . $row->id_cry_cost . '" name="btnedit_cos" class="btn btn-success">Edit</button></td>
                              
                                 </tr>';
                                } else {
                                    echo '<td><button type="submit" value="' . $row->id_cry_cost . '" name="btnedit_cos" class="btn btn-success">Edit</button></td>
                                 <td><button type="submit" value="' . $row->id_cry_cost . '" name="btndelete_cos" class="btn btn-danger">Delete</button></td>
                                 </tr>';
                                }
                            }


                            ?>
                        </tbody>

                    </table>

                </div>




            </form>

        </div>
        <!-- /.box-body -->

        <div class="box-footer">

        </div>

    </div>



    <?php display_message(); ?>

</section>
<!-- /.content -->

<!-- /.content-wrapper -->

<!-- Call this single function  -->
<script>
    $(document).ready(function() {
        $('#tablecategory').DataTable({
            "order": [
                [0, "desc"]
            ]
        });
    });
</script>