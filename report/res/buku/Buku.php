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
    <span class="judul">LAPORAN BUKU PERPUSTAKAAN</span>
</div>

<br>

<?php
session_start();
if (isset($_GET['buku'])) {
    $filter = $_GET['buku']; // Mengambil nilai dari dropdown filter
    $column = '';
    switch ($filter) {
        case 'kategori':
            $column = 'nama_kategori';
            break;
        case 'pengarang':
            $column = 'pengarang';
            break;
        case 'penerbit':
            $column = 'nama_penerbit';
            break;
        case 'cetakSemua':
            $query = "SELECT buku.*, kategori.nama_kategori, penerbit.nama_penerbit FROM buku 
                      JOIN kategori ON buku.id_kategori = kategori.id
                      JOIN penerbit ON buku.id_penerbit = penerbit.id";
            $result = mysqli_query($koneksi, $query);
            break;
    }

    if (isset($_GET['inputan']) && $filter !== 'cetakSemua') {
        $kategori = mysqli_real_escape_string($koneksi, $_GET['inputan']);
        $query = "SELECT buku.*, kategori.nama_kategori, penerbit.nama_penerbit FROM buku 
                  JOIN kategori ON buku.id_kategori = kategori.id
                  JOIN penerbit ON buku.id_penerbit = penerbit.id
                  WHERE $column = '$kategori'";
        $result = mysqli_query($koneksi, $query);
    }

    if (isset($result)) {
        if (mysqli_num_rows($result) > 0) {
?>

            <table>
                <colgroup>
                    <col style="width: 5%" class="angka">
                    <col style="width: 15%">
                    <col style="width: 13%">
                    <col style="width: 15%">
                    <col style="width: 25%">
                    <col style="width: 9%">
                    <col style="width: 9%">
                    <col style="width: 9%">
                </colgroup>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Kategori</th>
                        <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th>Baik</th>
                        <th>Rusak</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['judul_buku']; ?></td>
                            <td><?= $row['nama_kategori']; ?></td>
                            <td><?= $row['pengarang']; ?></td>
                            <td><?= $row['nama_penerbit']; ?></td>
                            <td><?= $row['j_buku_baik']; ?></td>
                            <td><?= $row['j_buku_rusak']; ?></td>
                            <td><?php
                                $j_buku_rusak = $row['j_buku_rusak'];
                                $j_buku_baik = $row['j_buku_baik'];
                                echo $j_buku_rusak + $j_buku_baik;
                                ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

<?php
        } else {
            $pesan_gagal = "";
            switch ($filter) {
                case 'kategori':
                    $pesan_gagal = "Tidak ada buku yang ditemukan untuk kategori `$kategori` !";
                    break;
                case 'pengarang':
                    $pesan_gagal = "Tidak ada buku yang ditemukan untuk pengarang `$kategori` !";
                    break;
                case 'penerbit':
                    $pesan_gagal = "Tidak ada buku yang ditemukan untuk nama penerbit `$kategori` !";
                    break;
                case 'cetakSemua':
                    $pesan_gagal = "Tidak ada buku yang ditemukan!";
                    break;
            }
            $_SESSION['gagal'] = $pesan_gagal;
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        }
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