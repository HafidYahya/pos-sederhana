<?php

$conn = mysqli_connect('localhost', 'root', 'Yahya123#', 'pos_sederhana');

// registrasi
function registrasi($data){
    global $conn;
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password1 = mysqli_real_escape_string($conn, $data["password1"]);
    $role = $data["role"];

    // cek username
    $ress = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $ress->bind_param("s", $username);
    $ress->execute();
    $result1 = $ress->get_result();

    if(mysqli_fetch_assoc($result1)){
        echo "
        <script>
        alert('Username $username sudah dipakai');
        </script>
        ";
        return false;
    }

// cek password
    if($password !== $password1){
        echo "<script>
              alert('Konfirmasi password gagal');
              </script>";
       return false;
    }
    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Insert Data
    $stmt = $conn->prepare("INSERT INTO users(username,password,role) VALUES(?,?,?)");
    $stmt->bind_param("sss", $username, $password, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    return mysqli_affected_rows($conn);

}
?>