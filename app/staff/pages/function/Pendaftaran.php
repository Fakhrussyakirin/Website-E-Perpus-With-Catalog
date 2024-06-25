<?php
session_start();
include "../../../../config/koneksi.php";

if (isset($_POST['aksi']) && $_POST['aksi'] == "setuju") {
    $id_user = $_POST['idAnggota'];
    $tanggal_bergabung = date('Y-m-d');
    $id_user_lvl = 2;

    $query = "UPDATE anggota SET tanggal_bergabung = ?, id_user_lvl = ? WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sii", $tanggal_bergabung, $id_user_lvl, $id_user);
        $sql = mysqli_stmt_execute($stmt);

        if ($sql) {
            $_SESSION['berhasil'] = "Data pendaftaran berhasil disetujui!";
        } else {
            $_SESSION['gagal'] = "Data pendaftaran gagal disetujui!";
        }
    } else {
        $_SESSION['gagal'] = "Terjadi kesalahan dalam mengeksekusi query!";
    }

    header("location: " . $_SERVER['HTTP_REFERER']);
} elseif (isset($_GET['aksi']) && $_GET['aksi'] == "hapus") {
    $id_user = $_GET['idAnggota']; // Mengambil data dari parameter URL dengan nama 'idAnggota'

    $sql = mysqli_query($koneksi, "DELETE FROM anggota WHERE id = $id_user");

    if ($sql) {
        $_SESSION['berhasil'] = "Data pendaftaran berhasil ditolak!";
    } else {
        $_SESSION['gagal'] = "Data pendaftaran gagal ditolak!";
    }

    header("location: " . $_SERVER['HTTP_REFERER']);
} else {
    $_SESSION['gagal'] = "Aksi tidak valid!";
    header("location: " . $_SERVER['HTTP_REFERER']);
}
