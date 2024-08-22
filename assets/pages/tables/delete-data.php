<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delete</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body>
    <!-- SweetAlert -->
    <script src="../../src/dist/sweetalert2.all.min.js"></script>
    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
</body>

</html>
<?php
require '../../src/functions/functions.php';
$user = $_GET["username"];
if(delete($user) > 0){
    echo "<script>
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Data deleted successfully',
            showConfirmButton: false,
            timer: 1500
        }).then(function() {
            window.location.href = 'data.php';
        });
    </script>";
}else{
    echo "<script>
        Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Data deletion failed',
            showConfirmButton: false,
            timer: 1500
        }).then(function() {
            window.location.href = 'data.php';
        });
    </script>";
}
?>