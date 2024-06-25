<?php
session_start();
header("Cache-Control: no-cache, must-revalidate");
include "../../../../config/koneksi.php";

// Fungsi untuk mengecek apakah permintaan sudah diproses sebelumnya
function isRequestAlreadyProcessed($idPermintaan)
{
    return isset($_SESSION['processed_requests']) && in_array($idPermintaan, $_SESSION['processed_requests']);
}

// Fungsi untuk menandai permintaan sebagai sudah diproses
function markRequestAsProcessed($idPermintaan)
{
    if (!isset($_SESSION['processed_requests'])) {
        $_SESSION['processed_requests'] = array();
    }
    if (!in_array($idPermintaan, $_SESSION['processed_requests'])) {
        $_SESSION['processed_requests'][] = $idPermintaan;
    }
}

// Fungsi untuk menghapus tanda permintaan yang sudah diproses
function unmarkRequestAsProcessed($idPermintaan)
{
    if (isset($_SESSION['processed_requests'])) {
        $index = array_search($idPermintaan, $_SESSION['processed_requests']);
        if ($index !== false) {
            unset($_SESSION['processed_requests'][$index]);
        }
    }
}

// Fungsi untuk memperbarui status permintaan
function updateRequestStatus($idPermintaan, $status)
{
    global $koneksi;
    $statusLabel = '';
    if ($status === 'Telah disetujui !') {
        $statusLabel = '<span style="color: green; font-weight: bold;">Telah disetujui !</span>';
    } elseif ($status === 'Telah ditolak !') {
        $statusLabel = '<span style="color: red; font-weight: bold;">Telah ditolak !</span>';
    }

    $query_update_status = "UPDATE permintaan_lvl SET status = ?, keterangan = 'Permintaan telah direspon' WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query_update_status);
    mysqli_stmt_bind_param($stmt, "si", $statusLabel, $idPermintaan);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Fungsi untuk menyimpan data peminjaman
function insertPeminjamanData($id_permintaan, $tanggal_peminjaman, $kondisi_buku)
{
    global $koneksi;
    $query_insert_peminjaman = "INSERT INTO peminjaman (id_permintaan_lvl, tanggal_peminjaman, kondisi_buku_saat_dipinjam) 
                                VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $query_insert_peminjaman);
    mysqli_stmt_bind_param($stmt, "iss", $id_permintaan, $tanggal_peminjaman, $kondisi_buku);
    $result_insert_peminjaman = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result_insert_peminjaman;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_permintaan = $_POST['idPermintaan'];
    $aksi = $_POST['aksi'];
    $role = $_POST['role'];

    if ($role === 'Peminjaman') {
        $tanggal_peminjaman = date("d-m-Y");

        // Periksa apakah permintaan telah direspon sebelumnya
        $query_check_responded = "SELECT * FROM permintaan_lvl WHERE id = ? AND keterangan = 'Permintaan telah direspon'";
        $stmt_check_responded = mysqli_prepare($koneksi, $query_check_responded);
        mysqli_stmt_bind_param($stmt_check_responded, "i", $id_permintaan);
        mysqli_stmt_execute($stmt_check_responded);
        $result_check_responded = mysqli_stmt_get_result($stmt_check_responded);

        if (mysqli_num_rows($result_check_responded) > 0) {
            echo "Permintaan tersebut sudah direspon sebelumnya !";
            exit;
        }

        if ($aksi == 'setuju') {
            $kondisi_buku = $_POST['kondisi_buku'];

            if (empty($kondisi_buku)) {
                echo "Harap pilih kondisi buku !";
                exit;
            }

            updateRequestStatus($id_permintaan, 'Telah disetujui !');
            markRequestAsProcessed($id_permintaan);

            $result_insert = insertPeminjamanData($id_permintaan, $tanggal_peminjaman, $kondisi_buku);

            if ($result_insert) {
                echo "success";
            } else {
                echo "Gagal melakukan penyimpanan data";
            }
        } elseif ($aksi == 'tolak') {
            updateRequestStatus($id_permintaan, 'Telah ditolak !');
            unmarkRequestAsProcessed($id_permintaan);
            echo "Permintaan telah ditolak";
        }
    } elseif ($role === 'Pengembalian') {

        if (!is_numeric($id_permintaan) || $id_permintaan <= 0) {
            exit("ID permintaan tidak valid");
        }

        // Ambil tanggal permintaan dari database
        $query_get_request_date = "SELECT tanggal_permintaan FROM permintaan_lvl WHERE id = ?";
        $stmt_get_request_date = mysqli_prepare($koneksi, $query_get_request_date);
        mysqli_stmt_bind_param($stmt_get_request_date, "i", $id_permintaan);
        mysqli_stmt_execute($stmt_get_request_date);
        $result_get_request_date = mysqli_stmt_get_result($stmt_get_request_date);

        if (!$result_get_request_date || mysqli_num_rows($result_get_request_date) == 0) {
            exit("Data permintaan tidak ditemukan");
        }
        $row_request_date = mysqli_fetch_assoc($result_get_request_date);
        $tanggal_permintaan = $row_request_date['tanggal_permintaan'];

        // Ambil tanggal peminjaman dari database
        $query_get_borrowed_date = "SELECT tanggal_peminjaman, kondisi_buku_saat_dipinjam FROM peminjaman WHERE id_permintaan_lvl = ?";
        $stmt_get_borrowed_date = mysqli_prepare($koneksi, $query_get_borrowed_date);
        mysqli_stmt_bind_param($stmt_get_borrowed_date, "i", $id_permintaan);
        mysqli_stmt_execute($stmt_get_borrowed_date);
        $result_get_borrowed_date = mysqli_stmt_get_result($stmt_get_borrowed_date);

        if (!$result_get_borrowed_date || mysqli_num_rows($result_get_borrowed_date) == 0) {
            exit("Data peminjaman tidak ditemukan");
        }
        $row_borrowed_date = mysqli_fetch_assoc($result_get_borrowed_date);
        $tanggal_peminjaman = $row_borrowed_date['tanggal_peminjaman'];
        $kondisi_buku_saat_dipinjam = $row_borrowed_date['kondisi_buku_saat_dipinjam'];

        $tanggal_permintaan_converted = date('Y-m-d', strtotime(substr($tanggal_permintaan, 0, 10)));


        $selisih_hari = floor((strtotime($tanggal_permintaan_converted) - strtotime($tanggal_peminjaman)) / (60 * 60 * 24));
        $denda_selisih_hari = 0;
        if ($selisih_hari > 3) {
            $denda_selisih_hari = 2000 * ($selisih_hari - 3);
        }

        $tanggal_pengembalian = date("d-m-Y");
        $kondisi_buku_saat_dikembalikan = $_POST['kondisi_buku'];

        $denda_kondisi_buku = 0;
        if ($kondisi_buku_saat_dipinjam === 'Rusak' && $kondisi_buku_saat_dikembalikan === 'Rusak') {
            $denda_kondisi_buku = 0;
        } elseif ($kondisi_buku_saat_dikembalikan === 'Rusak') {
            $denda_kondisi_buku = 20000;
        } elseif ($kondisi_buku_saat_dikembalikan === 'Hilang') {
            $denda_kondisi_buku = 50000;
        }

        $total_denda = $denda_selisih_hari + $denda_kondisi_buku;

        updateRequestStatus($id_permintaan, 'Telah disetujui !');

        $query_update_pengembalian = "UPDATE peminjaman SET tanggal_pengembalian = ?, kondisi_buku_saat_dikembalikan = ?, denda = ? WHERE id_permintaan_lvl = ?";
        $stmt_update_pengembalian = mysqli_prepare($koneksi, $query_update_pengembalian);
        mysqli_stmt_bind_param($stmt_update_pengembalian, "ssii", $tanggal_pengembalian, $kondisi_buku_saat_dikembalikan, $total_denda, $id_permintaan);
        $result_update_pengembalian = mysqli_stmt_execute($stmt_update_pengembalian);
        mysqli_stmt_close($stmt_update_pengembalian);

        unmarkRequestAsProcessed($id_permintaan);

        if ($result_update_pengembalian) {
            echo "success";
        } elseif ($aksi == 'tolak') {
            updateRequestStatus($id_permintaan, 'Telah ditolak !');
            unmarkRequestAsProcessed($id_permintaan);
            echo "Permintaan telah ditolak";
        }
    }
}
