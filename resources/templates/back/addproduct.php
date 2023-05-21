<?php

if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
    header("Location: ../../public");
}

if (isset($_POST['btnaddproduct'])) {
    $productname = $_POST['txtpname'];
    $category = $_POST['txtselect_option'];
    $purchaseprice = $_POST['txtpprice'];
    $saleprice = $_POST['txtsaleprice'];
    $stock = $_POST['txtstock'];
    $description = $_POST['txtdescription'];

    $f_name = $_FILES['myfile']['name'];
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

                    $insert = query("INSERT into tbl_product(pname,pcategory,purchaseprice,saleprice,pstock,pdescription,pimage)
                    VALUES('{$productname}','{$category}','{$purchaseprice}','{$saleprice}','{$stock}','{$description}','{$productimage}')");
                    confirm($insert);

                    if ($insert) {
                        set_message('<script type="text/javascript">
                        jQuery(function validation(){
                          swal({
                            title:"Add product Successfull!",
                            text: "Product Added!",
                            icon: "success",
                            button: "Ok",
                          });
                        });
                        </script>');
                        redirect("itemt?productlist");
                    } else {
                        echo '<script type="text/javascript">
                        jQuery(function validation(){
                          swal({
                            title:"Error!",
                            text: "Add product Fail!",
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
}

?>
<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Add Product
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


    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><a href="itemt?productlist" class="btn btn-primary" role="button">Back To Product
                    List</a></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form action="" method="post" name="formproduct" enctype="multipart/form-data">
            <div class="box-body">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" class="form-control" name="txtpname" placeholder="Enter Name" required>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" name="txtselect_option" required>
                            <option value="" disabled selected>Select Category</option>
                            <?php

                            $select = query("SELECT * from tbl_category order by catid desc");
                            confirm($select);
                            while ($row = $select->fetch_object()) {

                                echo '
                                    <option>' . $row->category . '</option>
                                ';
                            }
                            ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label>Purchase Price</label>
                        <input type="number" min="1" step="1" class="form-control" name="txtpprice" placeholder="Enter Purchase Price" required>
                    </div>
                    <div class="form-group">
                        <label>Sale Price</label>
                        <input type="number" min="1" step="1" class="form-control" name="txtsaleprice" placeholder="Enter Sale Price" required>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Stock</label>
                        <input type="number" min="1" step="1" class="form-control" name="txtstock" placeholder="Enter Sale Price" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="txtdescription" placeholder="Enter Sale Price" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Product image</label>
                        <input type="file" class="input-group" name="myfile" required>
                        <p>upload image</p>
                    </div>
                </div>

            </div>

            <div class="box-footer">
                <button type="submit" name="btnaddproduct" class="btn btn-info">Add product</button>
            </div>
        </form>
    </div>

</section>
<!-- /.content -->

<!-- /.content-wrapper -->
