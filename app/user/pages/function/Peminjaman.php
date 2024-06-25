<?php
session_start();

include "../../../../config/koneksi.php";

if (isset($_GET['aksi']) && $_GET['aksi'] == "pinjam") {
    $nama_anggota = $_POST['namaAnggota'];
    $judul_buku = $_POST['judulBuku'];

    $queryCekPeminjaman = "SELECT id FROM permintaan_lvl WHERE id_user = (SELECT id FROM anggota WHERE nama_lengkap = ?) AND id_buku = (SELECT id FROM buku WHERE judul_buku = ?)";
    $stmt = $koneksi->prepare($queryCekPeminjaman);
    $stmt->bind_param("ss", $nama_anggota, $judul_buku);
    $stmt->execute();
    $resultCekPeminjaman = $stmt->get_result();

    if ($resultCekPeminjaman->num_rows > 0) {
        $_SESSION['gagal'] = "Buku tersebut sudah Anda minta sebelumnya!";
        header("location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    if (empty($judul_buku)) {
        $_SESSION['gagal'] = "Silahkan klik gambar buku yang akan dipinjam!";
        header("location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $queryGetUserId = "SELECT id FROM anggota WHERE nama_lengkap = ?";
    $stmt = $koneksi->prepare($queryGetUserId);
    $stmt->bind_param("s", $nama_anggota);
    $stmt->execute();
    $resultGetUserId = $stmt->get_result();

    if ($resultGetUserId->num_rows > 0) {
        $rowGetUserId = $resultGetUserId->fetch_assoc();
        $id_user = $rowGetUserId['id'];

        $role = "Peminjaman";
        $keterangan = "Peminjaman Buku";
        $status = "Menunggu persetujuan!";

        $queryInsertPermintaanLvl = "INSERT INTO permintaan_lvl (role, id_user, id_buku, tanggal_permintaan, keterangan, status) VALUES (?, ?, (SELECT id FROM buku WHERE judul_buku = ?), CONCAT(DATE_FORMAT(NOW(), '%d-%m-%Y'), ' (', DATE_FORMAT(NOW(), '%H.%i'), ')'), ?, ?)";
        $stmt = $koneksi->prepare($queryInsertPermintaanLvl);
        $stmt->bind_param("sisss", $role, $id_user, $judul_buku, $keterangan, $status);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['berhasil'] = "Permintaan berhasil, tunggu persetujuan petugas!";
            header("location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            $_SESSION['gagal'] = "Terjadi kesalahan. Data tidak berhasil disimpan di database.";
            header("location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
} elseif (isset($_GET['aksi']) && $_GET['aksi'] == "pengembalian") {
    include "Pemberitahuan.php";

    $judul_buku = $_POST['judulBuku'];
    $tanggal_pengembalian = $_POST['tanggalPengembalian'];

    $query = "SELECT id FROM buku WHERE judul_buku = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $judul_buku);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_buku = $row['id'];

        $nama_anggota = $_SESSION['fullname'];
        $queryUserId = "SELECT id FROM anggota WHERE nama_lengkap = ?";
        $stmtUserId = $koneksi->prepare($queryUserId);
        $stmtUserId->bind_param("s", $nama_anggota);
        $stmtUserId->execute();
        $resultUserId = $stmtUserId->get_result();

        if ($resultUserId->num_rows > 0) {
            $rowUserId = $resultUserId->fetch_assoc();
            $id_user = $rowUserId['id'];
            $queryUpdatePermintaanLvl = "UPDATE permintaan_lvl SET role = ?, tanggal_permintaan = CONCAT(DATE_FORMAT(NOW(), '%d-%m-%Y'), ' (', DATE_FORMAT(NOW(), '%H.%i'), ')'), keterangan = ?, status = ? WHERE id_user = ? AND id_buku = ?";
            $stmtUpdate = $koneksi->prepare($queryUpdatePermintaanLvl);
            $role = "Pengembalian";
            $keterangan = "Pengembalian Buku";
            $status = "Menunggu persetujuan !";
            $stmtUpdate->bind_param("sssii", $role, $keterangan, $status, $id_user, $id_buku);
            $stmtUpdate->execute();

            if ($stmtUpdate->affected_rows > 0) {
                $_SESSION['berhasil'] = "Permintaan pengembalian buku berhasil !";
                header("location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                $_SESSION['gagal'] = "Terjadi masalah dalam pengiriman permintaan pengembalian !";
                header("location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }
        }
    } else {
        $_SESSION['gagal'] = "Judul buku yang dipilih tidak valid !";
        header("location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
