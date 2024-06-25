<?php
session_start();

include "../config/koneksi.php";

if ($_GET['aksi'] == "masuk") {

    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $data = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username' AND password = '$password'");

    $cek = mysqli_num_rows($data);

    if ($cek > 0) {
        $row = mysqli_fetch_assoc($data);

        if ($row['role'] == "Petugas") {
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['username'] = $username;
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['password'] = $row['password'];
            $_SESSION['status'] = "Login";
            $_SESSION['level'] = "Petugas";

            date_default_timezone_set('Asia/Jakarta');

            $id_user = $_SESSION['id_user'];
            $tanggal = date('d-m-Y');
            $jam = date('H:i:s');

            $query = "UPDATE user SET terakhir_login = '$tanggal ( $jam )'";
            $query .= " WHERE id_user = $id_user";

            $sql = mysqli_query($koneksi, $query);

            header("location: ../staff");
        } else if ($row['role'] == "Anggota") {
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['username'] = $username;
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['level'] = "Anggota";
            $_SESSION['status'] = "Login";

            date_default_timezone_set('Asia/Jakarta');

            $id_user = $_SESSION['id_user'];
            $tanggal = date('d-m-Y');
            $jam = date('H:i:s');

            $query = "UPDATE user SET terakhir_login = '$tanggal ( $jam )'";
            $query .= " WHERE id_user = $id_user";

            $sql = mysqli_query($koneksi, $query);

            header("location: ../user");
        } else {
            $_SESSION['user_tidak_terdaftar'] = "Maaf, User tidak terdaftar pada database !!";

            header("location: ../masuk");
        }
    } else {
        $_SESSION['gagal_login'] = "Nama Pengguna atau Kata Sandi salah !!";

        header("location: ../masuk");
    }
} elseif ($_GET['aksi'] == "daftar") {
    // Ambil nilai dari formulir
    $nis = $_POST['unnis'];
    $fullname = $_POST['funame'];
    $nomorHp = $_POST['noHp'];
    $username = addslashes(strtolower($_POST['uname']));
    $password = $_POST['passw'];

    // Tentukan nilai lain yang dibutuhkan
    $verif = "Tidak";
    $role = "Anggota";
    $join_date = date('d-m-Y');

    // Query SQL untuk menyimpan data ke database
    $sql = "INSERT INTO pendaftaran(nis_pendaftar, nama_pendaftar, nomor_hp, username_pendaftar, password_pendaftar, tanggal_mendaftar, status)
            VALUES('$nis', '$fullname', '$nomorHp', '$username', '$password', '$join_date', '$verif')";

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
