<?php
session_start();
require 'app/functions.php';
if(isset($_SESSION["role"])){
    if($_SESSION["role"] === "admin"){
        header('Location:app/public/admin.php');
        exit;
    }else if($_SESSION["role"] === "kasir"){
        header('Location:app/public/kasir.php');
        exit;
    }  
}

if(isset($_POST["login"])){
$username = $_POST["username"];
$password = $_POST["password"];

// cek username
$stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if(mysqli_num_rows($result) === 1){
    $row_data = mysqli_fetch_assoc($result);
    // cek password
    if(password_verify($password, $row_data["password"])){
        // Cek Role
        if($row_data["role"] === "admin"){
          $_SESSION["role"] = "admin";
          header('Location:app/public/admin.php');
          exit;
        }
        if($row_data["role"] === "kasir"){
          $_SESSION["role"] = "kasir";
          header('Location:app/public/kasir.php');
          exit;
        } 
    }
  }
  $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="app/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="app/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="app/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="" class="h1"><b>Log</b>In</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Log in to start your session</p>
                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" id="username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <label for="username" class="fas fa-user"></label>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-4">
                        <input type="password" name="password" class="form-control" placeholder="Password"
                            id="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <label for="password" class="fas fa-lock"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" name="login" class="btn btn-primary btn-block">Log In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <!-- /.social-auth-links -->
                <?php if(isset($error)): ?>
                <p class="text-center text-danger fst-italic">Invalid username/password</p>
                <?php endif; ?>
                <p class="mb-2">
                    <a href="user/register.php" class="text-center">Register a new user</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
</body>

</html>