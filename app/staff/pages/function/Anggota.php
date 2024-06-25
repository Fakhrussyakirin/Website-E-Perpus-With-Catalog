<?php
session_start();
include "../../../../config/koneksi.php";

if (isset($_GET['aksi']) && $_GET['aksi'] == "tambah") {

    $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['namaLengkap']);
    $username = mysqli_real_escape_string($koneksi, strtolower($_POST['username']));
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $nomor_hp = mysqli_real_escape_string($koneksi, $_POST['nomorHp']);
    $tanggal_bergabung = date('d-m-Y');
    $terakhir_login = "";
    $id_user_lvl = 2;

    $sql = "INSERT INTO anggota (nis, nama_lengkap, username, password, kelas, alamat, nomor_hp, tanggal_bergabung, terakhir_login, id_user_lvl) 
            VALUES ('$nis', '$nama_lengkap', '$username', '$password', '$kelas', '$alamat', '$nomor_hp', '$tanggal_bergabung', '$terakhir_login', $id_user_lvl)";

    $result = mysqli_query($koneksi, $sql);

    if ($result) {
        session_start();
        $_SESSION['berhasil'] = "Anggota berhasil ditambahkan !";
        header("location: " . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        session_start();
        $_SESSION['gagal'] = "Anggota gagal ditambahkan !";
        header("location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
} else if (isset($_GET['aksi']) && $_GET['aksi'] == "edit") {

    $id_user = mysqli_real_escape_string($koneksi, $_POST['idUser']);
    $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['namaLengkap']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $nomor_hp = mysqli_real_escape_string($koneksi, $_POST['nomorHp']);

    $query = "UPDATE anggota SET nis = ?, nama_lengkap = ?, username = ?, 
          password = ?, kelas = ?, alamat = ?, nomor_hp = ?
          WHERE id = ?";

    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "sssssssi", $nis, $nama_lengkap, $username, $password, $kelas, $alamat, $nomor_hp, $id_user);
    $sql = mysqli_stmt_execute($stmt);

    if ($sql) {
        $_SESSION['berhasil'] = "Data anggota berhasil dirubah!";
        header("location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['gagal'] = "Data anggota gagal dirubah!";
        header("location: " . $_SERVER['HTTP_REFERER']);
    }
} else if ($_GET['aksi'] == "hapus") {
    $id_user = $_GET['id'];

    $sql = mysqli_query($koneksi, "DELETE FROM anggota WHERE id = $id_user");

    if ($sql) {
        $_SESSION['berhasil'] = "Anggota berhasil dihapus!";
        header("location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['gagal'] = "Anggota gagal dihapus!";
        header("location: " . $_SERVER['HTTP_REFERER']);
    }
}
