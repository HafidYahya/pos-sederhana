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
        echo "<script> 
                 Swal.fire({
                  position: 'center',
                  icon: 'warning',
                  title: 'Username $username is already in use',
                  showConfirmButton: true
    });
              </script>";
        return false;
    }

// cek password 
    if($password !== $password1){
        echo "<script> 
                 Swal.fire({
                  position: 'center',
                  icon: 'warning',
                  title: 'Password does not match',
                  showConfirmButton: true
    });
              </script>";
       return false;
    }
    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Cek Gambar
    $namaGambar = $_FILES["image"]["name"];
    $ukuranFile = $_FILES["image"]["size"];
    $tmpName = $_FILES["image"]["tmp_name"];
    $fileError = $_FILES["image"]["error"];

    $ekstensiGambarValid = ["jpg", "jpeg", "png", "webp"];
    $ekstensiGambar = explode(".", $namaGambar);
    $ekstensiGambar = strtolower(end($ekstensiGambar));


    if(!empty($namaGambar)){
        // Cek Ekstensi Gambar Valid
        if(in_array($ekstensiGambar, $ekstensiGambarValid) === false){
        echo "<script> 
                 Swal.fire({
                  position: 'center',
                  icon: 'warning',
                  title: 'Invalid file extension!!!',
                  showConfirmButton: true
    });
              </script>";

              return false;
             }else{
                move_uploaded_file($tmpName, '../assets/img/'.$namaGambar);
             }
    }
    

    // Insert Data
    if(isset($namaGambar) && !empty($namaGambar)){
        $stmt = $conn->prepare("INSERT INTO users(username,password,role,image) VALUES(?,?,?,?)");
        $stmt->bind_param("ssss", $username, $password, $role, $namaGambar);
    }else{
        $stmt = $conn->prepare("INSERT INTO users(username,password,role) VALUES(?,?,?)");
        $stmt->bind_param("sss", $username, $password, $role);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();

    return mysqli_affected_rows($conn);


    


}
?>