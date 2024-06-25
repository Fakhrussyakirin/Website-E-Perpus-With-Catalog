<?php
session_start();
include "../../../../config/koneksi.php";
include "Pesan.php";

if ($_GET['act'] == "tambah") {
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $id_user_lvl = $_POST['id_user_lvl']; // Sesuaikan dengan tingkat akses petugas yang diinginkan
    $tanggal_bergabung = date('d-m-Y'); // Format tanggal disesuaikan dengan format yang diterima oleh MySQL
    $terakhir_login = null; // Set awal terakhir login ke null

    $query = "INSERT INTO petugas(nama_lengkap, username, password, tanggal_bergabung, terakhir_login, id_user_lvl)
            VALUES('$nama_lengkap', '$username', '$password', '$tanggal_bergabung', '$terakhir_login', $id_user_lvl)";
    $sql = mysqli_query($koneksi, $query);

    if ($sql) {
        $_SESSION['berhasil'] = "Petugas berhasil ditambahkan!";
        header("location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['gagal'] = "Petugas gagal ditambahkan!";
        header("location: " . $_SERVER['HTTP_REFERER']);
    }
} elseif ($_GET['act'] == "edit") {

    UpdateDataPesan();

    $id_petugas = $_POST['id_petugas'];
    $nama_lengkap = htmlspecialchars(addslashes($_POST['fullname']));
    $username = htmlspecialchars(strtolower($_POST['username']));
    $password = htmlspecialchars(addslashes($_POST['password']));

    $query = "UPDATE petugas SET nama_lengkap = '$nama_lengkap', username = '$username', password ='$password'";
    $query .= " WHERE id = '$id_petugas'";
    $sql = mysqli_query($koneksi, $query);

    if ($sql) {
        $_SESSION['berhasil'] = "Data Petugas berhasil di edit!";
        header("location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['gagal'] = "Data Petugas gagal di edit!";
        header("location: " . $_SERVER['HTTP_REFERER']);
    }
} elseif ($_GET['act'] == "hapus") {
    $id_petugas = $_GET['id'];

    $query = mysqli_query($koneksi, "DELETE FROM petugas WHERE id = $id_petugas");

    if ($query) {
        $_SESSION['berhasil'] = "Data Petugas berhasil dihapus!";
        header("location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['gagal'] = "Data Petugas gagal dihapus!";
        header("location: " . $_SERVER['HTTP_REFERER']);
    }
}
