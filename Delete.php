<?php 

    require 'function.php';
    
    $id_to_delete= $_GET["id_makanan"];

    // function hapus
    if (Delete($id_to_delete) >0) {
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