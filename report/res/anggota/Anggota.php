<style type="text/css">
    table {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    th {
        border: 1px solid;
        padding: 8px;
        text-align: center;
        background-color: #ddd;
    }

    td {
        border: 1px solid;
        padding: 8px;
    }

    td.angka {
        text-align: right;
    }


    td.garisbawah {
        text-align: center;
        border-bottom: 1px solid;
        padding-bottom: 6px;
    }

    td.info {
        border: 0px;
        padding: 2px;
    }

    td.tebal {
        font-weight: bold;
    }

    td.spasi-ttd {
        border: 0px;
        height: 32px;
    }

    .center {
        height: 100px;
    }

    .judul {
        font-size: 20px;
        font-weight: bold;
        display: table;
        margin: 0 auto;
    }
</style>

<table>
    <colgroup>
        <col style="width: 100%">
    </colgroup>
    <tbody>
        <tr>
            <td class="info garisbawah">
                <img style="height: 100px;" src="../../assets/images/header.jpg" alt="">
            </td>
        </tr>
    </tbody>
</table>
<br>

<div style="text-align: center;">
    <span class="judul">LAPORAN PERPUSTAKAAN</span>
</div>

<br>

<?php
session_start();

if (isset($_GET['kelas'])) {
    $kelas = $_GET['kelas'];
    if ($kelas === "cetakSemua") {
        $query = "SELECT * FROM anggota";
    } else {
        $query = "SELECT * FROM anggota WHERE kelas = '$kelas'";
    }
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
?>

        <table>
            <colgroup>
                <col style="width: 5%" class="angka">
                <col style="width: 11%">
                <col style="width: 28%">
                <col style="width: 12%">
                <col style="width: 28%">
                <col style="width: 16%" class="angka">
            </colgroup>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama Lengkap</th>
                    <th>Kelas</th>
                    <th>Alamat</th>
                    <th>Nomor Hp</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($rowAnggota = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $rowAnggota['nis']; ?></td>
                        <td><?= $rowAnggota['nama_lengkap']; ?></td>
                        <td><?= $rowAnggota['kelas']; ?></td>
                        <td><?= $rowAnggota['alamat']; ?></td>
                        <td><?= $rowAnggota['nomor_hp']; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

<?php
    } else {
        $_SESSION['gagal'] = "Tidak ada anggota yang ditemukan untuk kelas $kelas.";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
}
?>


<!-- ============================= Tertanda yang mencentak ============================= -->
<br>

<?php
$queryPetugas = mysqli_query($koneksi, "SELECT * FROM petugas");
if (!$queryPetugas) {
    die('Error in query: ' . mysqli_error($koneksi));
}

if ($rowPetugas = mysqli_fetch_assoc($queryPetugas)) {
    $_SESSION['id'] = $rowPetugas['id'];
    $_SESSION['nama_lengkap'] = $rowPetugas['nama_lengkap'];

?>
    <table>
        <colgroup>
            <col style="width: 75%">
            <col style="width: 25%">
        </colgroup>
        <tbody>
            <tr>
                <td class="info"></td>
                <td class="info"></td>
            </tr>
            <tr>
                <td class="info"></td>
                <td class="info"></td>
            </tr>

            <tr>
                <td class="info"></td>
                <td class="info">Mataraman, <?= tanggalIndonesia(date("Y-m-d")) ?></td>
            </tr>
            <tr>
                <td class="info"></td>
                <td class="info">Mengetahui,</td>
            </tr>
            <tr>
                <td class="info"></td>
                <td class="info">Penanggung Jawab</td>
            </tr>

            <tr>
                <td rowspan="1" class="spasi-ttd"></td>
            </tr>
            <tr>
                <td class="info"></td>
                <td class="info"><?= $_SESSION['nama_lengkap'] ?></td>
            </tr>
        </tbody>
    </table>
<?php
}
?>