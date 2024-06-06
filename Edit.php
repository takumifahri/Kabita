<?php 
    require 'function.php';
        
     $id = $data["id"];
     $NIM = htmlspecialchars( $data["NIM"]);
     $Nama = htmlspecialchars( $data["Nama"]);
     $email = htmlspecialchars( $data["email"]);
     $Jurusan = htmlspecialchars( $data["Jurusan"]);
     $GambarLama = htmlspecialchars( $data["gambarLama"]);
 
     // Pengecekan gambar lama atau gambar baru
     if($_FILES['gambar']['error'] === 4){
         $Gambar = $GambarLama;
     } else {
         $Gambar = upload();
     }
   
 
     $query = "UPDATE mahasiswa SET
                 NIM = '$NIM',
                 Nama = '$Nama',
                 email = '$email',
                 Jurusan = '$Jurusan',
                 Gambar = '$Gambar'
                 WHERE id = $id;
                 ";
    
 
     mysqli_query($db_mahasiswa, $query);
 
     return mysqli_affected_rows($db_mahasiswa);
?>