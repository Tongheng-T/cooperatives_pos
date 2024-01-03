<?php

if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
    header("Location: ../");
}
display_message();
registration();
if (isset($_POST['btnsaved'])) {
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
        <div class="box-body">
            <?php edit_registration(); ?>

            <div class="col-md-8">
                <form action="" method="post">
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
                            $select = query("SELECT * from tbl_user order by userid ASC");
                            confirm($select);

                            $admin = 'Admin';
                            $user = 'User';
                            while ($row = $select->fetch_object()) {
                                if ($row->role == $admin or $row->role == $user) {
                                    $password = "********";
                                } else {
                                    $password = $row->password;
                                }
                                if ($row->useremail == "bibben5016@gmail.com") {
                                    $delete = '';
                                } else {
                                    $delete = '<a href="../resources/templates/back/delete.php?id=' . $row->userid . '" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-trash" title="delete"></span></a>';
                                }
                                echo '
                                   <tr>
                                   <td>' . $row->userid . '</td>
                                   <td> <img height="50" src="../resources/userpic/' . $row->img . '" alt=""> ' . $row->username . '</td>
                                   <td>' . $row->useremail . '</td>
                                   <td>' . $password . '</td>  
                                   <td>' . $row->role . '</td>
                                   <td><button type="submit" class="btn btn-primary" value="' . $row->userid . '" name="btnedit">Edit</button></td>
                                   <td>' . $delete . '</td>
                                   </tr>';
                            }
                            ?>
                        </tbody>

                    </table>
                </form>
            </div>
        </div>






    </div>
    <!-- /.box-body -->

    <div class="box-footer">

    </div>



</section>
<!-- /.content -->

<!-- /.content-wrapper -->

<script>
    function show() {
        var p = document.getElementById('pwd');
        p.setAttribute('type', 'text');
    }

    function hide() {
        var p = document.getElementById('pwd');
        p.setAttribute('type', 'password');
    }

    var pwShown = 0;

    document.getElementById("eye").addEventListener("click", function() {
        if (pwShown == 0) {
            pwShown = 1;
            show();
        } else {
            pwShown = 0;
            hide();
        }
    }, false);
</script>