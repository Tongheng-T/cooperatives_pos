<?php

if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
    header("Location: ../");
}


$id = $_GET['id'];

$select = query("SELECT * from tbl_product where pid=$id");
confirm($select);

$row = $select->fetch_assoc();
$id_db = $row['pid'];
$productname_db = $row['pname'];
$category_db = $row['pcategory'];
$purchseprice_db = $row['purchaseprice'];
$saleprice_db = $row['saleprice'];
$stock_db = $row['pstock'];
$description_db = $row['pdescription'];
$productimage_db = $row['pimage'];


if (isset($_POST['btnupdate'])) {
    $productname_txt = $_POST['txtpname'];
    $category_txt = $_POST['txtselect_option'];
    $purchaseprice_txt = $_POST['txtpprice'];
    $saleprice_txt = $_POST['txtsaleprice'];
    $stock_txt = $_POST['txtstock'];
    $description_txt = $_POST['txtdescription'];

    $f_name = $_FILES['myfile']['name'];

    if (!empty($f_name)) {

        $f_temp = $_FILES['myfile']['tmp_name'];

        $f_size = $_FILES['myfile']['size'];
        $f_extension = explode('.', $f_name);
        $f_extension = strtolower(end($f_extension));

        $f_newfile = uniqid() . '.' . $f_extension;

        $store = "../productimages/" . $f_newfile;

        // move_uploaded_file($f_temp_location, 'productimages/' . $f_name);


        if ($f_extension == 'jpg' || $f_extension == 'png' || $f_extension == 'gif') {

            if ($f_size >= 1000000) {
                $error = '<script type="text/javascript">
                jQuery(function validation(){
                  swal({
                    title:"Error!",
                    text: "Max file should be 1MB!",
                    icon: "warning",
                    button: "Ok",
                  });
                });
                </script>';
                echo $error;
            } else {
                if (move_uploaded_file($f_temp, $store)) {
                    $productimage = $f_newfile;

                    if (!isset($error)) {

                        $update = query("UPDATE tbl_product set pname='{$productname_txt}', category_id='{$category_txt}',purchaseprice='{$purchaseprice_txt}',saleprice='{$saleprice_txt}',pstock='{$stock_txt}',pdescription='{$description_txt}',pimage='{$f_newfile}' where pid = $id");
                        confirm($update);
                        if ($update) {
                            echo '<script type="text/javascript">
                            jQuery(function validation(){
                              swal({
                                title:"Update product Successfull!",
                                text: "Product Updated!",
                                icon: "success",
                                button: "Ok",
                              });
                            });
                            </script>';
                            redirect('itemt?productlist');
                        } else {
                            echo '<script type="text/javascript">
                            jQuery(function validation(){
                              swal({
                                title:"Error!",
                                text: "Update product Fail!",
                                icon: "error",
                                button: "Ok",
                              });
                            });
                            </script>';
                        }
                    }
                }
            }
        } else {
            $error = '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title:"Warning!",
                text: "only jpg ,jpeg, png and gif can be upload!",
                icon: "error",
                button: "Ok",
              });
            });
            </script>';
            echo $error;
        }
    } else {
        $update = query("UPDATE tbl_product set pname='{$productname_txt}', category_id='{$category_txt}',purchaseprice='{$purchaseprice_txt}',saleprice='{$saleprice_txt}',pstock='{$stock_txt}',pdescription='{$description_txt}',pimage='{$productimage_db}' where pid = $id");
        confirm($update);
        if ($update) {
            $error = '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title:"Product update successfull!",
                text: "Updated!",
                icon: "success",
                button: "Ok",
              });
            });
            </script>';
            set_message($error);
            redirect('itemt?productlist');
        } else {
            $error = '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title:"Error!",
                text: "Update Fail!",
                icon: "error",S
                button: "Ok",
              });
            });
            </script>';
            echo $error;
        }
    }
}

$select = query("SELECT * from tbl_product where pid=$id");
confirm($select);

$row = $select->fetch_assoc();
$id_db = $row['pid'];
$productname_db = $row['pname'];
$category_db = $row['category_id'];
$purchseprice_db = $row['purchaseprice'];
$saleprice_db = $row['saleprice'];
$stock_db = $row['pstock'];
$description_db = $row['pdescription'];
$productimage_db = $row['pimage'];


?>
<!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Product
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
                <h3 class="box-title"><a href="itemt?productlist" class="btn btn-primary" role="button">Back To Product List</a></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

            <form action="" method="post" name="formproduct" enctype="multipart/form-data">
                <div class="box-body">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" class="form-control" name="txtpname" value="<?php echo $productname_db ?>" placeholder="Enter Name" required>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" name="txtselect_option" required>
                                <option value="" disabled selected>Select Category</option>
                                <?php

                                $select = query("SELECT * from tbl_category order by catid desc");
                                confirm($select);
                                while ($row = $select->fetch_assoc()) {
                                    extract($row)
                                ?>
                                    <option value="<?php echo $row['catid'] ?>" <?php if ($row['catid'] == $category_db) { ?> selected="selected" <?php } ?>>

                                        <?php echo show_categoryname($row['catid']); ?></option>

                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Purchase Price</label>
                            <input type="number" min="1" step="1" class="form-control" name="txtpprice" value="<?php echo $purchseprice_db ?>" placeholder="Enter Purchase Price" required>
                        </div>
                        <div class="form-group">
                            <label>Sale Price</label>
                            <input type="number" min="1" step="1" class="form-control" name="txtsaleprice" value="<?php echo $saleprice_db ?>" placeholder="Enter Sale Price" required>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Stock</label>
                            <input type="number" min="1" step="1" class="form-control" name="txtstock" value="<?php echo $stock_db ?>" placeholder="Enter Sale Price" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="txtdescription" placeholder="Enter Sale Price" rows="4"><?php echo $description_db ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Product image</label>
                            <img src="../productimages/<?php echo $productimage_db ?>" class="img-responsive" width=50; height="50" alt="photo">
                            <input type="file" class="input-group" name="myfile">
                            <p>upload image</p>
                        </div>
                    </div>

                </div>

                <div class="box-footer">
                    <button type="submit" name="btnupdate" class="btn btn-warning">Update Product</button>
                </div>
            </form>
        </div>

    </section>
    <!-- /.content -->

<!-- /.content-wrapper -->