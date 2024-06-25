<?php
session_start();
include "../../../../config/koneksi.php";

if ($_GET['act'] == "tambah") {
    $nama_kategori = $_POST['namaKategori'];

    $sql = "INSERT INTO kategori(nama_kategori)VALUES('$nama_kategori')";
    $sql .= mysqli_query($koneksi, $sql);

    if ($sql) {
        $_SESSION['berhasil'] = "Kategori buku berhasil ditambahkan !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['gagal'] = "Kategori buku gagal ditambahkan !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    }
} elseif ($_GET['act'] == "edit") {
    $id = $_POST['idKategori'];
    $nama_kategori = $_POST['namaKategori'];

    $query = "UPDATE kategori SET nama_kategori = '$nama_kategori'";
    $query .= "WHERE id = '$id'";

    $sql = mysqli_query($koneksi, $query);

    if ($sql) {
        $_SESSION['berhasil'] = "Kategori buku berhasil diedit !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['gagal'] = "Kategori buku gagal diedit !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    }
} elseif ($_GET['act'] == "hapus") {
    $id = $_GET['id'];

    $sql = mysqli_query($koneksi, "DELETE FROM kategori WHERE id = '$id'");

    if ($sql) {
        $_SESSION['berhasil'] = "Kategori buku berhasil dihapus !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['gagal'] = "Kategori buku gagal dihapus !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    }
}
