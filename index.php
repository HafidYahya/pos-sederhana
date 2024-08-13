<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="index.php"><b>Log</b>In</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session
                </p>

                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- SweetAlert -->
    <script src="assets/src/dist/sweetalert2.all.min.js"></script>
    <!-- jQuery -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/dist/js/adminlte.min.js"></script>
</body>

</html>
<?php
session_start();
require 'assets/src/functions.php';

if(isset($_POST["login"])){
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Cek Username
  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows > 0){
    $row_data = $result->fetch_assoc();
    // Cek password
    if(password_verify($password, $row_data["password"])){
        if($row_data["role"]==="ADMIN"){
            $_SESSION["role"]="ADMIN";
            $_SESSION["username"]=$username;
            $_SESSION["profile_image"]=$row_data["profile_image"];
            header('Location:dashboard.php');
            exit;
        }else{
            $_SESSION["role"]="KASIR";
            $_SESSION["username"]=$username;
            $_SESSION["profile_image"]=$row_data["profile_image"];
            header('Location:dashboard.php');  
            exit;
        }
      
    }else{
      echo "<script>
            Swal.fire({
              position: 'center',
              icon: 'error',
              title: 'Your password is incorrect',
              showConfirmButton: true
            });
          </script>";
    }
  }else{
    echo "<script>
            Swal.fire({
              position: 'center',
              icon: 'error',
              title: 'Username not registered',
              showConfirmButton: true
            });
          </script>";
  }
}


?>