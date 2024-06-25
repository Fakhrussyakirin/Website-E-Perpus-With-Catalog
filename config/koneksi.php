<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "db_perpustakaan";

$koneksi = mysqli_connect($server, $username, $password, $database);

if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}
if (isset($koneksi)) {
    // Kode yang menggunakan $koneksi
} else {
    die("Variabel \$koneksi tidak terdefinisi.");
}
