<?php 
    require'function.php';

    // ambil data di url
    $id = $_GET["id_makanan"];
    // Query Data mahasiswa berdasarkan ID
    $ediKbt = query("SELECT * FROM makanan WHERE id_makanan = $id")[0];

    if (isset($_POST["submit"])){

        if(Edit($_POST) > 0){
            echo "
                <script>
                    alert('Data berhasil ditambahkan');
                    document.location.href = 'index.php';
                </script>"
            ;
        } else {
            echo "
                <script>
                    alert('Data berhasil ditambahkan');
                    document.location.href = 'index.php';
                </script>"
            ;
        };

    }

?>