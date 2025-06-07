
<?php
$koneksi = new mysqli("localhost", "root", "123", "db_topsis_wisata_1");
if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}
?>
