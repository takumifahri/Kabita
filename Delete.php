<?php 

    require 'function.php';
    
    $id= $_GET["id_makanan"];

    // function hapus
    if (Delete($id) > 0) {
        echo "
            <script>
                alert('Data berhasil dihapus');

            </script>;
            
        ";
    } else{
        echo "
            <script>
                alert('Data gagal dihapus');

            </script>;
            
        ";
    };
    header("Location: dashboard_admin.php");
?>