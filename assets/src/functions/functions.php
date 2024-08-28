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
            $targetDirectory = realpath(__DIR__ . '/../img') . '/';
            move_uploaded_file($tmpNameFile, $targetDirectory . $fileName);
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


// Delete Data
function delete($username){
    global $conn;
    $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    return $stmt->affected_rows;
   

    
}

function edit($data){
    global $conn;
    $old_profile_image = $data["old_profile_image"];
    $old_status = $data["old_status"];
    $old_password = $data["old_password"];
    $old_username = $data["old_username"];

    $id = $data["id"];
    $fullname = $data["fullname"];
    $username = $data["username"];
    $email = $data["email"];
    $no_hp = $data["no_hp"];
    $password = $data["password"];
    $confirm_password = $data["confirm_password"];
    $role = $data["role"];
    $status = $data["status"]?? $old_status;
    $fileError = $_FILES["profile_image"]["error"];
    
    if($fileError === UPLOAD_ERR_OK){
        // Cek gambar
       $fileName = $_FILES["profile_image"]["name"];
       $tmpNameFile = $_FILES["profile_image"]["tmp_name"];
       $fileSize = $_FILES["profile_image"]["size"];
       

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
            $targetDirectory = realpath(__DIR__ . '/../img') . '/';
            move_uploaded_file($tmpNameFile, $targetDirectory . $fileName);
        }
    }
    }else{
        $fileName = $old_profile_image;
    }

    // Cek apakah username baru sudah digunakan
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND username != ?");
    $stmt->bind_param("ss", $username, $old_username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek Username
    if($result->fetch_assoc()){
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

    // Cek Password
    if(isset($password) && !empty($password)){
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
        // Enkripsi password baru
        $password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        // Jika password tidak diisi, gunakan password lama
        $password = $old_password;
    }


    // Update Data
    $stmt1 = $conn->prepare("UPDATE users SET fullname = ?, username = ?, email = ?, no_hp = ?, profile_image = ?, password = ?, role = ?, status = ? WHERE id = ?");
    $stmt1->bind_param("ssssssssi", $fullname, $username, $email, $no_hp, $fileName, $password, $role, $status, $id);
    $stmt1->execute();

    // Cek perubahan data
    if($stmt1->affected_rows > 0){
        echo "<script> 
                 Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Data successfully updated',
                  showConfirmButton: true
                });
              </script>";
    } else {
        echo "<script> 
                 Swal.fire({
                  position: 'center',
                  icon: 'info',
                  title: 'No changes were made',
                  showConfirmButton: true
                });
              </script>";
    }


    return mysqli_affected_rows($conn);
}


?>