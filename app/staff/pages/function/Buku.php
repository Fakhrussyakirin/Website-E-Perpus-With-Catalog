<?php
session_start();
include "../../../../config/koneksi.php";

function redirectWithMessage($message, $url)
{
    $_SESSION['message'] = $message;
    header("location: $url");
    exit();
}

if (isset($_GET['act'])) {
    if ($_GET['act'] == "tambah") {
        $judul_buku = $_POST['judulBuku'];
        $kategori_buku = $_POST['kategoriBuku'];
        $penerbit_buku = isset($_POST['penerbitBuku']) ? $_POST['penerbitBuku'] : "Penerbit Tidak Diketahui";
        $pengarang = $_POST['pengarang'];
        $tahun_terbit = $_POST['tahunTerbit'];
        $isbn = $_POST['iSbn'];
        $j_buku_baik = $_POST['jumlahBukuBaik'];
        $j_buku_rusak = $_POST['jumlahBukuRusak'];
        $deskripsi = $_POST['deskripsi'];

        $uploadDir = "uploadsGambar/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (!is_writable($uploadDir)) {
            $_SESSION['gagal'] = "Direktori tidak dapat ditulis oleh server.";
            redirectWithMessage($_SESSION['gagal'], $_SERVER['HTTP_REFERER']);
        }

        $foto_buku = '';

        if ($_FILES['foto_buku']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

            if (in_array($_FILES['foto_buku']['type'], $allowedTypes)) {
                $filename = $_FILES['foto_buku']['tmp_name'];
                $extension = pathinfo($_FILES['foto_buku']['name'], PATHINFO_EXTENSION);
                $newFilename = uniqid() . '.' . $extension;
                $destination = $uploadDir . $newFilename;

                if (move_uploaded_file($filename, $destination)) {
                    $foto_buku = $newFilename;
                } else {
                    $_SESSION['gagal'] = "Gagal mengunggah gambar.";
                    redirectWithMessage($_SESSION['gagal'], $_SERVER['HTTP_REFERER']);
                }
            } else {
                $_SESSION['gagal'] = "Jenis file tidak diizinkan. Jenis file yang diunggah: " . $_FILES['foto_buku']['type'];
                redirectWithMessage($_SESSION['gagal'], $_SERVER['HTTP_REFERER']);
            }
        }

        if (empty($kategori_buku) || $kategori_buku == "-- Harap pilih kategori buku --") {
            $_SESSION['gagal'] = "Kategori buku harus dipilih.";
            redirectWithMessage($_SESSION['gagal'], $_SERVER['HTTP_REFERER']);
        }

        $sql = "INSERT INTO buku (judul_buku, kategori_buku, penerbit_buku, pengarang, tahun_terbit, isbn, j_buku_baik, j_buku_rusak, foto_buku, deskripsi)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            'ssssssisss',
            $judul_buku,
            $kategori_buku,
            $penerbit_buku,
            $pengarang,
            $tahun_terbit,
            $isbn,
            $j_buku_baik,
            $j_buku_rusak,
            $foto_buku,
            $deskripsi
        );
        mysqli_stmt_execute($stmt);

        if ($stmt) {
            $_SESSION['berhasil'] = "Data buku berhasil ditambahkan !";
            $_SESSION['foto_buku'] = $foto_buku;
            header("location: " . $_SERVER['HTTP_REFERER']);
        } else {
            $_SESSION['gagal'] = "Data buku gagal ditambahkan: " . mysqli_error($koneksi);
            header("location: " . $_SERVER['HTTP_REFERER']);
        }
        // Bagian Edit Data
    } elseif ($_GET['act'] == "edit") {
        $id_buku = $_POST['id_buku'];
        $judul_buku = $_POST['judulBuku'];
        $kategori_buku = $_POST['kategoriBuku'];
        $penerbit_buku = $_POST['penerbitBuku'];
        $pengarang = $_POST['pengarang'];
        $tahun_terbit = $_POST['tahunTerbit'];
        $isbn = $_POST['iSbn'];
        $j_buku_baik = $_POST['jumlahBukuBaik'];
        $j_buku_rusak = $_POST['jumlahBukuRusak'];
        $deskripsi = $_POST['deskripsi'];

        $uploadDir = "uploadsGambar/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (!is_writable($uploadDir)) {
            $_SESSION['gagal'] = "Direktori tidak dapat ditulis oleh server.";
            redirectWithMessage($_SESSION['gagal'], $_SERVER['HTTP_REFERER']);
        }

        // Ambil nama file foto buku sebelumnya
        $foto_buku_sebelumnya = $_POST['foto_buku_existing'];

        if ($_FILES['foto_buku']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxFileSize = 5 * 1024 * 1024; // 5 MB

            if (in_array($_FILES['foto_buku']['type'], $allowedTypes) && $_FILES['foto_buku']['size'] <= $maxFileSize) {
                $filename = $_FILES['foto_buku']['tmp_name'];
                $extension = pathinfo($_FILES['foto_buku']['name'], PATHINFO_EXTENSION);
                $newFilename = uniqid() . '.' . $extension;
                $destination = $uploadDir . $newFilename;

                // Hapus gambar lama jika ada
                if (!empty($foto_buku_sebelumnya) && file_exists($uploadDir . $foto_buku_sebelumnya)) {
                    unlink($uploadDir . $foto_buku_sebelumnya);
                }

                if (move_uploaded_file($filename, $destination)) {
                    $foto_buku = $newFilename;
                } else {
                    $_SESSION['gagal'] = "Gagal mengunggah gambar.";
                    redirectWithMessage($_SESSION['gagal'], $_SERVER['HTTP_REFERER']);
                }
            } else {
                $_SESSION['gagal'] = "Jenis file tidak diizinkan atau ukuran file terlalu besar (maksimal 5 MB).";
                redirectWithMessage($_SESSION['gagal'], $_SERVER['HTTP_REFERER']);
            }
        } else {
            // Jika tidak ada file gambar yang diunggah, gunakan foto_buku yang sudah ada
            $foto_buku = $foto_buku_sebelumnya;
        }

        $sql = "UPDATE buku SET judul_buku = ?, kategori_buku = ?, penerbit_buku = ?, 
                    pengarang = ?, tahun_terbit = ?, isbn = ?, j_buku_baik = ?, 
                    j_buku_rusak = ?, foto_buku = ?, deskripsi = ? WHERE id_buku = ?";

        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            'ssssssisssi',
            $judul_buku,
            $kategori_buku,
            $penerbit_buku,
            $pengarang,
            $tahun_terbit,
            $isbn,
            $j_buku_baik,
            $j_buku_rusak,
            $foto_buku,
            $deskripsi,
            $id_buku
        );

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['berhasil'] = "Data buku berhasil diedit !";
            $_SESSION['foto_buku'] = $foto_buku;
            header("location: " . $_SERVER['HTTP_REFERER']);
        } else {
            $_SESSION['gagal'] = "Data buku gagal diedit: " . mysqli_error($koneksi);
            header("location: " . $_SERVER['HTTP_REFERER']);
        }
    } elseif ($_GET['act'] == "hapus") {
        $id_buku = $_GET['id'];

        $stmt = mysqli_prepare($koneksi, "DELETE FROM buku WHERE id_buku = ?");
        mysqli_stmt_bind_param($stmt, 'i', $id_buku);
        mysqli_stmt_execute($stmt);

        if ($stmt) {
            $_SESSION['berhasil'] = "Data buku berhasil dihapus !";
            header("location: " . $_SERVER['HTTP_REFERER']);
        } else {
            $_SESSION['gagal'] = "Data buku gagal dihapus !";
            header("location: " . $_SERVER['HTTP_REFERER']);
        }
    }
}
