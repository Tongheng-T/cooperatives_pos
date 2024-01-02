<?php require_once("../resources/config.php"); ?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>POS-តំបែររុងរឿង | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel='shortcut icon' href="productimages/256.ico" type="image/x-icon">
  <link rel="icon" href="productimages/32.ico" sizes="32x32">
  <link rel="icon" href="productimages/48.ico" sizes="48x48">
  <link rel="icon" href="productimages/96.ico" sizes="96x96">
  <link rel="icon" href="productimages/256.ico" sizes="144x144">

  <link rel="stylesheet" href="dlogin/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="dlogin/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dlogin/dist/css/adminlte.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="dlogin/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="dlogin/toastr/toastr.min.css">

  <!-- jQuery -->
  <script src="dlogin/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="dlogin/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="dlogin/sweetalert2/sweetalert2.min.js"></script>
  <!-- Toastr -->
  <script src="dlogin/toastr/toastr.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dlogin/dist/js/adminlte.min.js"></script>
  <style>
    @font-face {
      font-family: "OSbattambang";
      src: url(fone/KhmerOSbattambang.ttf)format("truetype");
    }

    * {
      font-family: "OSbattambang";
    }

    .center {
      text-align: center;
    }
  </style>


  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>


<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="https://web.facebook.com/TonghengCoding" class="h1">សហគមន៍កសិកម្មតំបែររុងរឿង</a>
      </div>

      <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <p class="center"><img src="resources/images/loog.png" style="align-content: center" height="200px" alt=""></p>
        <?php login_user(); ?>
        <?php display_message(); ?>
        <form action="" method="post">
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="txt_email" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" id="pwd" placeholder="Password" name="txt_password" required>
            <div class="input-group-append">
              <div class="input-group-text" id="eye">
                <span class="fas fa-eye-slash" id="eyeicon"></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <a href="#" class="toastrDefaultInfo">I forgot my password</a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block" name="btn_login">Login</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <!-- /.social-auth-links -->

        <p class="mb-1">

        </p>
        <p class="mb-0">

        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->






  <script>
    $(function() {
      var Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 5000
      });
      $('.toastrDefaultInfo').click(function() {
        Toast.fire({
          icon: 'info',
          title: 'ដើម្បីទទួលបានពាក្យសម្ងាត់ សូមទាក់ទងអ្នកគ្រប់គ្រង ឬអ្នកផ្តល់សេវា'
        })
      });

    });
  </script>




  <script>
    function show() {
      var p = document.getElementById('pwd');
      var eyeicon = document.getElementById('eyeicon');
      p.setAttribute('type', 'text');
      eyeicon.classList = 'fas fa-eye';
    }

    function hide() {
      var p = document.getElementById('pwd');
      var eyeicon = document.getElementById('eyeicon');
      p.setAttribute('type', 'password');
      eyeicon.classList = 'fas fa-eye-slash';
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
</body>

</html>