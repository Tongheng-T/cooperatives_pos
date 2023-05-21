<?php

if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
    header("Location: ../");
}
display_message();

if (isset($_POST['btnsave'])) {
    $username = $_POST['txtname'];
    $useremail = $_POST['txtemail'];
    $password = $_POST['txtpassword'];
    $userrole = $_POST['txtselect_option'];

    if (isset($_POST['txtemail'])) {
        $select = query("SELECT useremail from tbl_user where useremail='$useremail'");
        confirm($select);

        if (mysqli_num_rows($select) > 0) {
            echo '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title:"Warning!",
                text: "Email Already Exist : Please try from diffrent Email !",
                icon: "warning",
                button: "Ok",
              });
            });
            </script>';
        } else {

            $insert = query("INSERT into tbl_user(username,useremail,password,role)values('{$username}','{$useremail}','{$password}','{$userrole}')");
            confirm($insert);

            if ($insert) {
                echo '<script type="text/javascript">
                jQuery(function validation(){
                  swal({
                    title:"Good Job!",
                    text: "Your Registration is Successfull",
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
                    text: "Registration Fail !",
                    icon: "error",
                    button: "Ok",
                  });
                });
                </script>';
            }
        }
    }
}



?>
<!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Registration
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
                <h3 class="box-title">Registration Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post">
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control" name="txtname" placeholder="Enter Name" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" name="txtemail" placeholder="Enter email" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" name="txtpassword" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-control" name="txtselect_option" required>
                                <option value="" disabled selected>Select role</option>
                                <option>User</option>
                                <option>Admin</option>
                            </select>
                        </div>
                        <button type="submit" name="btnsave" class="btn btn-info">Save</button>
                    </div>

                    <div class="col-md-8">

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NAME</th>
                                    <th>EMAIL</th>
                                    <th>PASSWORD</th>
                                    <th>ROLE</th>
                                    <th>DELETE</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $select = query("SELECT * from tbl_user order by userid desc");
                                confirm($select);
                                while ($row = $select->fetch_object()) {

                                    echo '
                                <tr>
                                <td>' . $row->userid . '</td>
                                <td>' . $row->username . '</td>
                                <td>' . $row->useremail . '</td>
                                <td>' . $row->password . '</td>
                                <td>' . $row->role . '</td>
                                <td>
                                <a href="../resources/templates/back/delete.php?id=' . $row->userid . '" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-trash" title="delete"></span></a>
                                </td>
                                </tr>
                                ';
                                }


                                ?>
                            </tbody>

                        </table>

                    </div>






                </div>
                <!-- /.box-body -->

                <div class="box-footer">

                </div>
            </form>
        </div>

    </section>
    <!-- /.content -->

<!-- /.content-wrapper -->

