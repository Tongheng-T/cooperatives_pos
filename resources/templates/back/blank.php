<?php
include_once 'connectdb.php';
session_start();
if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
  header('location:index.php');
}

include_once 'header.php';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
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
      <form action="" method="post" name="">
        <div class="box-header with-border">
          <h3 class="box-title">blank Form</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->

        <div class="box-body">
        </div>
      </form>
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include_once 'footer.php' ?>