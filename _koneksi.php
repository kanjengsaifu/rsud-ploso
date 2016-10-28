<?php
$mysqli = mysqli_connect("localhost", "root", "", "rsudploso");
if (mysqli_connect_errno($mysqli)) {
    echo "Gagal koneksi database MySQL: " . mysqli_connect_error();
}
?>