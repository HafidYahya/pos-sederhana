<?php 
session_start();
require '../../src/functions/functions.php';
if(!isset($_SESSION["role"]) || empty($_SESSION["role"])){
    header('Location:../../../index.php');
    exit;
}
$username = $_GET["username"];
$user = $conn->prepare("SELECT * FROM users WHERE username = ?");
$user->bind_param("s", $username);
$user->execute();
$ress = $user->get_result();
$user_edit = $ress->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add New User</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn btn-outline-danger" onclick="Swal.fire({
                         title:'Are you sure you want to exit the application?',
                         showDenyButton: true,  
                         showConfirmButton: true ,
                         confirmButtonColor:'#FF0000',
                         denyButtonColor:'#999999',
                         denyButtonText: 'Cancel',
                         confirmButtonText: 'Log out' 
                         }).then((result)=> {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                        window.location.href='../../../logout.php'
                        } else if (result.isDenied) {
                        Swal.fire('Canceled', '', 'success');
                        }
                        });">Log out</button>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="add-user.php" class="brand-link">
                <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><?= $_SESSION["role"]; ?></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <?php if(isset($_SESSION["profile_image"]) && !empty($_SESSION["profile_image"])): ?>
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../../src/img/<?=$_SESSION["profile_image"]?>" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="add-user.php" class="d-block"><?= $_SESSION["username"] ?></a>
                    </div>
                </div>
                <?php else: ?>
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../../dist/img/profile_default.webp" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="add-user.php" class="d-block"><?= $_SESSION["username"] ?></a>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item menu-open">
                            <a href="../../../dashboard.php" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <?php if(isset($_SESSION["role"]) && $_SESSION["role"] === "ADMIN"): ?>
                        <li class="nav-item">
                            <a href="../tables/data.php" class="nav-link active">
                                <i class="nav-icon fas fa-users"></i>
                                <p>User Management</p>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Add User</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content ">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col">
                            <!-- general form elements -->
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Form</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="fullname">Full name</label>
                                            <input type="text" name="fullname" class="form-control" id="fullname"
                                                placeholder="Enter Fullname" value="<?= $user_edit['fullname'] ?>">
                                        </div>
                                        <!-- Hidden Role -->
                                        <input type="hidden" name="role" value="<?= $user_edit['role'] ?>">
                                        <!-- /Hidden Role -->
                                        <!-- Hidden status -->
                                        <input type="hidden" name="old_status" value="<?= $user_edit['status'] ?>">
                                        <!-- /Hidden status -->
                                        <!-- Hidden Username -->
                                        <input type="hidden" name="old_username" value="<?= $user_edit['username'] ?>">
                                        <!-- /Hidden Username -->
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" name="username" class="form-control" id="username"
                                                placeholder="Enter Username" value="<?= $user_edit['username'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control" id="email"
                                                placeholder="Enter email" value="<?= $user_edit['email'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="no_hp">Phone number</label>
                                            <input type="number" name="no_hp" class="form-control" id="no_hp"
                                                placeholder="Enter phone number" value="<?= $user_edit['no_hp'] ?>">
                                        </div>
                                        <!-- Hidden Profile Image -->
                                        <input type="hidden" name="old_profile_image"
                                            value="<?= $user_edit['profile_image'] ?>">
                                        <!-- /Hidden Profile Image -->
                                        <div class="form-group">
                                            <label for="profile_image">Profile image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="profile_image" class="custom-file-input"
                                                        id="profile_image">
                                                    <label class="custom-file-label" for="profile_image">Choose
                                                        new file (Opsional)</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status user</label>
                                            <select class="custom-select rounded-0" name="status" id="status">
                                                <option disabled selected>New status (Opsional)</option>
                                                <option value="Y">Y</option>
                                                <option value="N">N</option>
                                            </select>
                                        </div>
                                        <!-- Hidden ID -->
                                        <input type="hidden" name="id" value="<?= $user_edit['id'] ?>">
                                        <!-- /Hidden ID -->
                                        <!-- Hidden Password -->
                                        <input type="hidden" name="old_password" value="<?= $user_edit['password'] ?>">
                                        <!-- /Hidden password -->
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" class="form-control" id="password"
                                                placeholder="New password (Opsional)">
                                        </div>
                                        <div class="form-group">
                                            <label for="confirm_password">Confirm password</label>
                                            <input type="password" name="confirm_password" class="form-control"
                                                id="confirm_password" placeholder="Confirm new password">
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" name="edit" class="btn btn-success">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
        </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.2.0
        </div>
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
        reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- SweetAlert -->
    <script src="../../src/dist/sweetalert2.all.min.js"></script>
    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="../../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
    $(function() {
        bsCustomFileInput.init();
    });
    </script>
</body>

</html>
<?php


if(isset($_POST["edit"])){
    edit($_POST);
}
    

?>