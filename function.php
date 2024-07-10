<?php 
// Koneksi ke database
$db_kabita = mysqli_connect("localhost", "root", "", "kabita");

// kita buat function query 
function query($query){
   global $db_kabita;
   $result = mysqli_query($db_kabita, $query);
   // kita siapkan wadah kosong
   $dbKabita = [];
   // untuk fetching nya itu variabel nya harus sama dengan yang ada di htmlnya
   while ($kbt = mysqli_fetch_assoc($result)){
        $dbKabita[] = $kbt;
   }
   return $dbKabita;
   
};

function Add($data) {
    $db_kabita = mysqli_connect('localhost', 'username', '', 'kabita');

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    // global $db_kabita; 

    $nama_makanan = htmlspecialchars( $data["nama_makanan"]);
    $harga = htmlspecialchars( $data["harga"]);
    $tipe_menu = htmlspecialchars( $data["tipe_menu"]);
    $Deskripsi = htmlspecialchars( $data["Deskripsi"]); 
    $Stok = htmlspecialchars( $data["Stok"]);
 
    // Kita buat fungsi upload gambar
    $Gambar = upload();
    if(!$Gambar) {
        return false;
    }

    // var_dump($db_kabita); die;
    mysqli_query($db_kabita,
     "INSERT INTO makanan
            VALUES
            ('', '$nama_makanan', '$harga', '$tipe_menu', '$Deskripsi', '$Stok', '$Gambar')");
    
    return mysqli_affected_rows($db_kabita);


}

function upload(){
    // Check if 'gambar' key exists in $_FILES array
    if (!isset($_FILES['Gambar'])) {
        echo "<script>
                alert('No file was uploaded');
            </script>";
        return false;
    }

    $namaFile = $_FILES['Gambar']['name'];
    $ukuranfile = $_FILES['Gambar']['size'];
    $error = $_FILES['Gambar']['error'];
    $tmpName = $_FILES['Gambar']['tmp_name'];

    // pengecekan apakah tdk ada gambar di upload
    if($error === 4){
        echo "<script>
                alert('Pilih gambar terlebih dahulu');
            </script>";
        return false; // untuk pembatalan insert data
    }

    // pengecekan apakah yang diupload adalah gambar
    $extensionGambarValid = ['jpg', 'jpeg', 'png', 'MOV', 'gif'];
    $extensionGambar = explode('.', $namaFile);
    $extensionGambar = strtolower(end($extensionGambar));

    if(!in_array($extensionGambar, $extensionGambarValid)){
        echo "<script>
                alert('Yang anda upload bukan gambar, tolong cek kejujuran anda!');
            </script>";
        return false;
    }

    // Pengecekan ukuran gambar , Max = 1 MB
    if($ukuranfile > 1000000000){
        echo "<script>
                alert('Ukuran gambar terlalu besar, maksimal 50 MB!');
            </script>";
        return false;
    }

    // Lolos pengecekan, gambar siap di upload
   
    // Generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $extensionGambar;

    move_uploaded_file( $tmpName,'image/' . $namaFileBaru );

    return $namaFileBaru;
}

// function hapus
function Delete($id){
    // $id = "id_makanan"; // The ID of the record you want to delete

   global $db_kabita;
   mysqli_query($db_kabita, "DELETE FROM makanan WHERE id_makanan = $id");


   return mysqli_affected_rows($db_kabita);
}

// Function edit
function UpdateData($data) { // ini functionya
    // global $db_kabita;
    $db_kabita = mysqli_connect('localhost', 'username', '', 'kabita');

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }
    
   $id = $data["id_makanan"];
   $nama_makanan = ( $data["nama_makanan"]);
   $harga =  $data["harga"];
   $tipe_menu = $data["tipe_menu"];
   $Deskripsi =  $data["Deskripsi"];
   $Stok =  $data["Stok"];
   $GambarLama =  $data["gambarLama"];

   // Pengecekan gambar lama atau gambar baru
   if($_FILES['Gambar']['error'] === 4){
       $Gambar = $GambarLama;
   } else {
       $Gambar = upload();
   }
   
   $query = "UPDATE makanan SET
               nama_makanan = '$nama_makanan',
               harga = '$harga',
               tipe_menu = '$tipe_menu',
               Deskripsi = '$Deskripsi',
               Stok = '$Stok',
               Gambar = '$Gambar'
               WHERE id_makanan = $id;
               ";
    
//    printf($query);
//    die;

   mysqli_query($db_kabita, $query); 
   
   return mysqli_affected_rows($db_kabita);
}


// Function Search
function Search($keyword){

   $query ="SELECT * FROM kabita
           WHERE
          harga LIKE '%$keyword%'OR
          nama_makanan LIKE '%$keyword%' OR
          tipe_menu LIKE '%$keyword%' OR
          Deskripsi LIKE '%$keyword%' OR
          Stok LIKE '%$keyword%'";
   return query($query);
   
   
}


function Register($data){
   global $db_kabita;

   $name = $data["harga"];
   $username = strtolower(stripslashes($data['Username']));
   $password = mysqli_real_escape_string( $db_kabita ,$data['Password']);
//    $password2 = mysqli_real_escape_string( $db_kabita ,$data['Password2']);
   
   // Pengecekan username sudah ada atau belum
   $pengecekan = mysqli_query($db_kabita, "SELECT username FROM users WHERE username = '$username'");
   if (mysqli_fetch_assoc($pengecekan)){
       echo"
           <script>
               alert('Username sudah terdaftar! silahkan pilih username yang lain ;)');
           </script>
       ";
       return false;
   }
   // Pengecekan confirm password
//    if($password !== $password2){
//        echo"
//            <script>
//                alert('Password tidak sesuai!');
//            </script>
//        ";
//        return false;
//    } else{
//        echo mysqli_error($db_kabita);

//    }
   // enkripsi password
   $password = password_hash($password, PASSWORD_DEFAULT);
   // Password default itu algoritma nya di pilih oleh php itu sendiri
   // var_dump($password); die;

   // tambahkan userbaru ke database
   mysqli_query($db_kabita, "INSERT INTO users VALUES( '','$name', '$username', '$password','','','')");

   // penngecekan gagal atau tidak
   return mysqli_affected_rows($db_kabita);
};
?>
