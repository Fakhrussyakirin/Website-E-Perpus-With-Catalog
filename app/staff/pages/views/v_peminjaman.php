<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
            Form Peminjaman
            <small>
                <script type='text/javascript'>
                    var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
                    var date = new Date();
                    var day = date.getDate();
                    var month = date.getMonth();
                    var thisDay = date.getDay(),
                        thisDay = myDays[thisDay];
                    var yy = date.getYear();
                    var year = (yy < 1000) ? yy + 1900 : yy;
                    document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);
                </script>
            </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Data Peminjaman</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">Data Peminjaman</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">

                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Anggota</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Tanggal Pengembalian</th>
                                    <th>Kondisi Saat Dipinjam</th>
                                    <th>Kondisi Saat Dikembalikan</th>
                                    <th>Denda</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                include "../../config/koneksi.php";
                                $no = 1;
                                $query = "SELECT p.*, pl.id_user, pl.id, u.nama_lengkap AS nama_anggota, b.judul_buku
                FROM peminjaman p 
                LEFT JOIN permintaan_lvl pl ON p.id_permintaan_lvl = pl.id
                LEFT JOIN anggota u ON pl.id_user = u.id
                LEFT JOIN buku b ON pl.id_buku = b.id";
                                $result = mysqli_query($koneksi, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $nama_anggota = $row['nama_anggota'] ?? '-';
                                    $judul_buku = $row['judul_buku'] ?? '-';
                                    $tanggal_pengembalian = $row['tanggal_pengembalian'] ?? '-';
                                    $kondisi_buku_saat_dikembalikan = $row['kondisi_buku_saat_dikembalikan'] ?? '-';
                                    $denda = $row['denda'] ?? '-';

                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $nama_anggota; ?></td>
                                        <td><?= $judul_buku; ?></td>
                                        <td><?= $row['tanggal_peminjaman']; ?></td>
                                        <td><?= $tanggal_pengembalian; ?></td>
                                        <td><?= $row['kondisi_buku_saat_dipinjam']; ?></td>
                                        <td><?= $kondisi_buku_saat_dikembalikan; ?></td>
                                        <td><?= $denda; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>


                        </table>


                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>