<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../app/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../app/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../app/dist/css/adminlte.min.css">
    <!-- SweetAlert -->
    <script src="../assets/dist/sweetalert2.all.min.js"></script>
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="" class="h1"><b>Register</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Register a new user</p>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" id="username"
                            required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <label for="username" class="fas fa-user"></label>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" id="password"
                            required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <label for="password" class="fas fa-lock"></label>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password1" class="form-control" placeholder="Retype password"
                            id="password1" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <label for="password1" class="fas fa-lock"></label>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <select name="role" id="role" class="form-control" required>
                            <option value="" disabled selected style="color:#f5f5f5;">-- Choose Role --</option>
                            <option value="admin">Admin</option>
                            <option value="kasir">Kasir</option>
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <label for="role" class="fas fa-user-plus"></label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Upload profile picture</label>
                        <input type="file" name="image" id="formFile">
                    </div>
                    <div class="row justify-content-center">
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" name="register"
                                class="btn btn-primary btn-block mb-3">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <a href="../index.php" class="text-center">I already have an account</a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>

</body>

</html>
<!-- php code -->
<?php
require '../app/functions.php';

if(isset($_POST["register"])){
    if(registrasi($_POST)){
        echo "<script> 
                 Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Registration successful',
                  showConfirmButton: true
                  }).then((result) =>{
                      if(result.isConfirmed){
                      window.location.href='../index.php';
                      }
    });
              </script>";
    }
    mysqli_error($conn);
}

?>