    <?php
    session_start();
    include "../../../../config/koneksi.php";
    include "Pesan.php";

    if ($_GET['act'] == "tambah") {
        $fullname = $_POST['namaLengkap'];
        $username = $_POST['namaPengguna'];
        $password = $_POST['kataSandi'];
        $role = $_POST['role'];
        $join_date = date('d-m-Y');
        $verif = "Iya";
        $kode_user = "-";
        $nis = "-";
        $kelas = "-";
        $alamat = "-";

        $query = "INSERT INTO user(kode_user,nis,fullname,username,password,kelas,alamat,verif,role,join_date)
            VALUES('" . $kode_user . "','" . $nis . "','" . $fullname . "','" . $username . "','" . $password . "','" . $kelas . "','" . $alamat . "', '" . $verif . "','" . $role . "','" . $join_date . "')";
        $sql = mysqli_query($koneksi, $query);

        if ($sql) {
            $_SESSION['berhasil'] = "Petugas berhasil ditambahkan !";
            header("location: " . $_SERVER['HTTP_REFERER']);
        } else {
            $_SESSION['gagal'] = "Petugas gagal ditambahkan !";
            header("location: " . $_SERVER['HTTP_REFERER']);
        }
    } elseif ($_GET['act'] == "edit") {

        UpdateDataPesan();

        $id_petugas = $_POST['id_petugas'];
        $fullname = htmlspecialchars(addslashes($_POST['fullname']));
        $username = htmlspecialchars(strtolower($_POST['username']));
        $password = htmlspecialchars(addslashes($_POST['password']));

        $query = "UPDATE user SET fullname = '$fullname', username = '$username', password ='$password'";
        $query .= " WHERE id_user = '$id_petugas'";
        $sql = mysqli_query($koneksi, $query);

        if ($sql) {
            $_SESSION['berhasil'] = "Data Petugas berhasil di edit !";
            header("location: " . $_SERVER['HTTP_REFERER']);
        } else {
            $_SESSION['gagal'] = "Data Petugas gagal di edit !";
            header("location: " . $_SERVER['HTTP_REFERER']);
        }
    } elseif ($_GET['act'] == "hapus") {
        $id_petugas = $_GET['id'];

        $query = mysqli_query($koneksi, "DELETE FROM user WHERE id_user = $id_petugas");

        if ($query) {
            $_SESSION['berhasil'] = "Data Petugas berhasil dihapus !";
            header("location: " . $_SERVER['HTTP_REFERER']);
        } else {
            $_SESSION['gagal'] = "Data Petugas gagal dihapus !";
            header("location: " . $_SERVER['HTTP_REFERER']);
        }
    }
