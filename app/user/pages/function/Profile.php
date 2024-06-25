<?php
session_start();
include "../../../../config/koneksi.php";
include "Peminjaman.php";
include "Pesan.php";

if ($_GET['aksi'] == "edit") {
    include "../../config/koneksi.php";

    $id_user = $_POST['IdUser'];
    $nis = $_POST['Nis'];
    $fullname = $_POST['Fullname'];
    $username = $_POST['Username'];
    $password = $_POST['Password'];
    $kelas = $_POST['kelas']; // Mengubah menjadi 'kelas'
    $alamat = $_POST['Alamat'];

    if ($kelas == NULL) { // Mengubah $_POST['kelas'] menjadi $kelas
        $_SESSION['gagal'] = "Harap pilih kelas anda !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    } else {

        // UpdateDataPeminjaman(); // Tidak ada detail mengenai fungsi ini

        // UpdateDataPesan(); // Tidak ada detail mengenai fungsi ini

        $query = "UPDATE anggota SET nis = '$nis', nama_lengkap = '$fullname', username = '$username', password = '$password', kelas = '$kelas', alamat = '$alamat' "; // Mengubah 'user' menjadi 'anggota'
        $query .= "WHERE id = $id_user"; // Mengubah 'id_user' menjadi 'id'

        $sql = mysqli_query($koneksi, $query);

        if ($sql) {
            $_SESSION['berhasil'] = "Update profil berhasil !";
            header("location: " . $_SERVER['HTTP_REFERER']);
        } else {
            $_SESSION['gagal'] = "Update profil gagal !";
            header("location: " . $_SERVER['HTTP_REFERER']);
        }
    }
}
