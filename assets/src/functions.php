<?php

$conn = mysqli_connect('localhost', 'root', 'Yahya123#', 'pos');
// Register
function register($data){
    global $conn;
    $fullname = $data["fullname"];
    $username = strtolower(stripslashes($data["username"]));
    $email = $data["email"];
    $no_hp = $data["no_hp"];
    $role = $data["role"];
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $confirm_password = mysqli_real_escape_string($conn, $data["confirm_password"]);
    $status = "Y";

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek Username
    if(mysqli_fetch_assoc($result)){
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
    // Cek password
    if($password !== $confirm_password){
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

    // Cek gambar
    $fileName = $_FILES["profile_image"]["name"];
    $tmpNameFile = $_FILES["profile_image"]["tmp_name"];
    $fileSize = $_FILES["profile_image"]["size"];
    $fileError = $_FILES["profile_image"]["error"];

    $extensionFileValid = ["jpg", "jpeg", "png", "webp"];
    $extensionFile = explode(".", $fileName);
    $extensionFile = strtolower(end($extensionFile));

    // Cek extension file

    if(!empty($fileName)){
        if(in_array($extensionFile, $extensionFileValid) === false){
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
            move_uploaded_file($tmpNameFile, '/pos/assets/src/img/'.$fileName);
        }
    }

    // insert data
    if(isset($fileError) && $fileError===0){
        $stmt1 = $conn->prepare("INSERT INTO users (fullname,username,email,no_hp,profile_image,password, role, status) VALUES (?,?,?,?,?,?,?,?)");
        $stmt1->bind_param("ssssssss", $fullname, $username, $email, $no_hp, $fileName, $password, $role, $status);
    }else{
        $stmt1 = $conn->prepare("INSERT INTO users (fullname,username,email,no_hp,password,role,status) VALUES (?,?,?,?,?,?,?)");
        $stmt1->bind_param("sssssss", $fullname, $username, $email, $no_hp, $password, $role, $status);
    }

    $stmt1->execute();
    $ress = $stmt1->get_result();

    return mysqli_affected_rows($conn);
    
}

// Select data user
function query($query){
    global $conn;
    $data = [];
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
    }
    return $data;
}

?>