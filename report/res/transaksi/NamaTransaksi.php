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
    <span class="judul">REKAPITULASI NAMA TRANSAKSI</span>
</div>

<br>
<!-- ============= Laporan ============= -->

<?php
session_start();
$data = array();

if (isset($_GET['nama_anggota']) && $_GET['nama_anggota'] !== '') {
    $nama_anggota = $_GET['nama_anggota'];

    $query = "SELECT p.*, pl.tanggal_permintaan, pl.keterangan, pl.id_user, pl.id_buku, u.nama_lengkap AS nama_anggota, b.judul_buku
              FROM peminjaman p 
              LEFT JOIN permintaan_lvl pl ON p.id_permintaan_lvl = pl.id
              JOIN anggota u ON pl.id_user = u.id
              JOIN buku b ON pl.id_buku = b.id
              WHERE u.nama_lengkap LIKE '%$nama_anggota%'";
    $result = mysqli_query($koneksi, $query);

    if (!$result || mysqli_num_rows($result) === 0) {
        $_SESSION['gagal'] = "Tidak ada data transaksi yang ditemukan untuk nama yang dicari !";
        echo "<script>window.location.href = '{$_SERVER['HTTP_REFERER']}';</script>";
        exit();
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
}
?>

<table>
    <colgroup>
        <col style="width: 5%" class="angka">
        <col style="width: 26%">
        <col style="width: 25%">
        <col style="width: 23%">
        <col style="width: 21%">
    </colgroup>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Anggota</th>
            <th>Judul Buku</th>
            <th>Tanggal Permintaan</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($data as $row) {
        ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama_anggota']; ?></td>
                <td><?= $row['judul_buku']; ?></td>
                <td><?= $row['tanggal_permintaan']; ?></td>
                <td><?= $row['keterangan']; ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>


<!-- ============= Tertanda yang mencentak ============= -->
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