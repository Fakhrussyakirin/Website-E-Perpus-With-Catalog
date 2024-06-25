<?php
session_start();

include "../config/koneksi.php";

if ($_GET['aksi'] == "masuk") {

    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Query untuk petugas
    $query_petugas = "SELECT p.*, u.role 
                      FROM petugas p 
                      JOIN user_lvl u ON p.id_user_lvl = u.id 
                      WHERE p.username = '$username' AND p.password = '$password'";

    // Query untuk anggota
    $query_anggota = "SELECT a.*, u.role 
                      FROM anggota a 
                      JOIN user_lvl u ON a.id_user_lvl = u.id 
                      WHERE a.username = '$username' AND a.password = '$password'";

    // Eksekusi query untuk petugas
    $data_petugas = mysqli_query($koneksi, $query_petugas);
    $cek_petugas = mysqli_num_rows($data_petugas);

    // Eksekusi query untuk anggota jika tidak ada data petugas
    if ($cek_petugas == 0) {
        $data_anggota = mysqli_query($koneksi, $query_anggota);
        $cek_anggota = mysqli_num_rows($data_anggota);

        if ($cek_anggota > 0) {
            $row = mysqli_fetch_assoc($data_anggota);

            $_SESSION['id_user'] = $row['id'];
            $_SESSION['username'] = $username;
            $_SESSION['fullname'] = $row['nama_lengkap'];
            $_SESSION['password'] = $row['password'];
            $_SESSION['status'] = "Login";
            $_SESSION['level'] = $row['role']; // Mengambil level dari tabel user_lvl

            date_default_timezone_set('Asia/Jakarta');

            $id_user = $_SESSION['id_user'];
            $tanggal = date('d-m-Y');
            $jam = date('H:i:s');

            $query = "UPDATE anggota SET terakhir_login = '$tanggal ( $jam )'";
            $query .= " WHERE id = $id_user";

            $sql = mysqli_query($koneksi, $query);

            if ($row['role'] == "Anggota") {
                header("location: ../user");
            } elseif ($row['role'] == "Pending") {
                header("location: ../pending");
            }
        } else {
            $_SESSION['gagal_login'] = "Nama Pengguna atau Kata Sandi salah !!";
            header("location: ../masuk");
        }
    } else { // Jika ada data petugas
        $row = mysqli_fetch_assoc($data_petugas);

        $_SESSION['id_user'] = $row['id'];
        $_SESSION['username'] = $username;
        $_SESSION['fullname'] = $row['nama_lengkap'];
        $_SESSION['password'] = $row['password'];
        $_SESSION['status'] = "Login";
        $_SESSION['level'] = $row['role']; // Mengambil level dari tabel user_lvl

        date_default_timezone_set('Asia/Jakarta');

        $id_user = $_SESSION['id_user'];
        $tanggal = date('d-m-Y');
        $jam = date('H:i:s');

        $query = "UPDATE petugas SET terakhir_login = '$tanggal ( $jam )'";
        $query .= " WHERE id = $id_user";

        $sql = mysqli_query($koneksi, $query);

        if ($row['role'] == "Petugas") {
            header("location: ../staff");
        } elseif ($row['role'] == "Pending") {
            header("location: ../pending");
        }
    }
} elseif ($_GET['aksi'] == "daftar") {
    // Ambil nilai dari formulir
    $nis = $_POST['unnis'];
    $fullname = $_POST['funame'];
    $nomorHp = $_POST['noHp'];
    $username = addslashes(strtolower($_POST['uname']));
    $password = $_POST['passw'];

    // Tentukan nilai lain yang dibutuhkan
    $join_date = date('d-m-Y');
    $status = "Belum disetujui !"; // Nilai untuk kolom `tanggal_bergabung`
    $id_user_lvl = 3; // Nilai untuk kolom `id_user_lvl`

    // Query SQL untuk menyimpan data ke database
    $sql = "INSERT INTO anggota (nis, nama_lengkap, username, password, nomor_hp, tanggal_bergabung, id_user_lvl)
            VALUES ('$nis', '$fullname', '$username', '$password', '$nomorHp', '$status', $id_user_lvl)";

    // Jalankan query
    $sql_result = mysqli_query($koneksi, $sql);

    // Periksa apakah query berhasil dijalankan
    if ($sql_result) {
        $_SESSION['berhasil'] = "Pendaftaran Berhasil, Tunggu Respon dari Petugas !";
        header("location: ../masuk");
    } else {
        $_SESSION['gagal'] = "Pendaftaran Gagal !";
        header("location: ../masuk");
    }
}
