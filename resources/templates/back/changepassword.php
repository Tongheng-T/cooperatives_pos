<?php

if ($_SESSION['useremail'] == "") {
    header("Location: ../");
}


if (isset($_POST['btnupdate'])) {
    $oldpassword_txt = $_POST['txtoldpass'];
    $newpassword_txt = $_POST['txtnewpass'];
    $confpassword_txt = $_POST['txtconfpass'];


    $email = $_SESSION['useremail'];

    $select = query("SELECT * from tbl_user where useremail='$email'");
    confirm($select);
    $row = $select->fetch_assoc();

    $useremail_db = $row['useremail'];
    $password_db = $row['password'];


    if ($oldpassword_txt == $password_db) {
        if ($newpassword_txt == $confpassword_txt) {
            $update = query("UPDATE tbl_user set password='$confpassword_txt' where useremail='$email'");

            if ($update) {

                echo '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title: "Good Job!",
                text: "Your Password Is Updated Successfull",
                icon: "success",
                button: "Ok",
              });
            });
            </script>';
            } else {
                echo '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title: "Error !!",
                text: "Query Fail",
                icon: "error",
                button: "Ok",
              });
            });
            </script>';
            }
        } else {
            echo '<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title: "Oopas!!",
            text: "Your New Password And Confirm Password Is Not Matched",
            icon: "warning",
            button: "Ok",
          });
        });
        </script>';
        }
    } else {

        echo '<script type="text/javascript">
    jQuery(function validation(){
      swal({
        title: "Warning !!",
        text: "Your Password Is Wrong Please Fill Right Password",
        icon: "warning",
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
            Change Password
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

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Change Password form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Old Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="txtoldpass">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">New Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="txtnewpass">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Confirm Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="txtconfpass">
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="btnupdate">Update</button>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->

<!-- /.content-wrapper -->

