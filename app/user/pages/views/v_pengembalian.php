<!-- jQuery 3 -->
<script src="../../assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../../assets/dist/js/sweetalert.min.js"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
            Pengembalian Buku
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
            <li><a href="beranda"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Pengembalian Buku</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tgl-pinjam" data-toggle="tab">Formulir Pengembalian Buku</a></li>
                        <li><a href="#permintaan-pinjaman" data-toggle="tab">Riwayat Permintaan Pengembalian</a></li>
                        <li><a href="#riwayat-peminjaman-pengembalian" data-toggle="tab">Riwayat Pengembalian</a></li>
                    </ul>
                    <div class="tab-content">

                        <!-- =============== Pilihan Buku yang Dikembalikan =============== -->
                        <div class="tab-pane active" id="tgl-pinjam">
                            <section id="new">
                                <?php
                                include "../../config/koneksi.php";
                                if (session_status() == PHP_SESSION_NONE) {
                                    session_start();
                                }
                                if (!isset($_SESSION['fullname'])) {
                                    echo "Anda harus login untuk mengakses halaman ini.";
                                    exit;
                                }
                                $sql = "SELECT id FROM permintaan_lvl 
                                WHERE status = '<span style=\"color: green; font-weight: bold;\">Telah disetujui !</span>' 
                                AND role = 'Peminjaman' LIMIT 1";
                                $result = mysqli_query($koneksi, $sql);
                                $data = mysqli_fetch_assoc($result);
                                $id = isset($data['id']) ? $data['id'] : "";
                                ?>
                                <form id="formPengembalian" action="pages/function/Peminjaman.php?aksi=pengembalian" method="POST">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" name="id" value="<?= $id; ?>" readonly required>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                        $fullname = $_SESSION['fullname'];
                                        $sql = "SELECT p.id_buku, b.judul_buku
                                        FROM permintaan_lvl p 
                                        JOIN buku b ON p.id_buku = b.id
                                        JOIN anggota a ON p.id_user = a.id
                                        WHERE p.status = '<span style=\"color: green; font-weight: bold;\">Telah disetujui !</span>'   
                                        AND p.role = 'Peminjaman'
                                        AND a.nama_lengkap = '$fullname'";
                                        $result = mysqli_query($koneksi, $sql);
                                        ?>
                                        <label for="judulBuku">Judul Buku</label>
                                        <select class="form-control" name="judulBuku" id="judulBuku" required>
                                            <option selected disabled> -- Silahkan pilih buku yang ingin dikembalikan -- </option>
                                            <?php
                                            while ($data = mysqli_fetch_array($result)) {
                                            ?>
                                                <option value="<?= $data['judul_buku']; ?>"> <?= $data['judul_buku']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Pengembalian</label>
                                        <input type="text" class="form-control" name="tanggalPengembalian" value="<?= date('d-m-Y'); ?>" readonly required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block" onclick="debugSubmit()">Kirim</button>
                                    </div>
                                </form>
                            </section>
                        </div>
                        <!-- END -->

                        <!-- =============== Riwayat Permintaan Pengembalian =============== -->
                        <div class="tab-pane" id="permintaan-pinjaman">
                            <table class="table table-bordered" id="example1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Anggota</th>
                                        <th>Judul Buku</th>
                                        <th>Tanggal Permintaan</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    if (session_status() == PHP_SESSION_NONE) {
                                        session_start();
                                    }
                                    $id_pengguna = $_SESSION['id_user'];
                                    $query_permintaan = "SELECT p.*, a.nama_lengkap AS nama_anggota, b.judul_buku
                                    FROM permintaan_lvl p
                                    JOIN anggota a ON p.id_user = a.id
                                    JOIN buku b ON p.id_buku = b.id
                                    WHERE p.role = 'Pengembalian' AND p.id_user = $id_pengguna";
                                    $result_permintaan = mysqli_query($koneksi, $query_permintaan);
                                    while ($row = mysqli_fetch_assoc($result_permintaan)) {
                                        $namaUser = $row['nama_anggota'];
                                        $judulBuku = $row['judul_buku'];
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $namaUser; ?></td>
                                            <td><?= $judulBuku; ?></td>
                                            <td><?= $row['tanggal_permintaan']; ?></td>
                                            <td>
                                                <b><?= $row['keterangan']; ?></b>
                                            </td>
                                            <td id="status-<?= $row['id']; ?>"><?= $row['status']; ?></td>
                                            <td>
                                                <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalPermintaan<?= $row['id']; ?>"><i class="fa fa-info"></i> Batalkan !</a>
                                            </td>
                                        </tr>
                                        <!-- Modal Permintaan -->
                                        <div class="modal fade" id="modalPermintaan<?= $row['id']; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content" style="border-radius: 5px;">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        <h4 class="modal-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
                                                            Permintaan ( <?= $namaUser; ?> )
                                                        </h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Nama Anggota</label>
                                                            <input type="text" class="form-control" value="<?= htmlspecialchars($namaUser); ?>" name="namaAnggota" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Judul Buku</label>
                                                            <input type="text" class="form-control" value="<?= htmlspecialchars($judulBuku); ?>" name="judulBuku" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Tanggal Permintaan</label>
                                                            <input type="text" class="form-control" value="<?= htmlspecialchars($row['tanggal_permintaan']); ?>" name="TanggalPermintaan" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Keterangan</label>
                                                            <input type="text" class="form-control" value="<?= htmlspecialchars($row['keterangan']); ?>" name="Keterangan" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Batalkan</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- END -->

                        <!-- =============== Riwayat Pengembalian =============== -->
                        <div class="tab-pane" id="riwayat-peminjaman-pengembalian">
                            <table class="table table-bordered" id="example2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Anggota</th>
                                        <th>Judul Buku</th>
                                        <th>Tanggal Pengembalian</th>
                                        <th>Kondisi Saat Dikembalikan</th>
                                        <th>Denda</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include "../../config/koneksi.php";
                                    $no = 1;
                                    if (session_status() == PHP_SESSION_NONE) {
                                        session_start();
                                    }
                                    $id_pengguna = $_SESSION['id_user'];
                                    $query = mysqli_query($koneksi, "SELECT p.*, pl.id_user, pl.id_buku
                                            FROM peminjaman p 
                                            LEFT JOIN permintaan_lvl pl ON p.id_permintaan_lvl = pl.id
                                            WHERE pl.id_user = '$id_pengguna'");

                                    while ($row = mysqli_fetch_assoc($query)) {
                                        $nama_anggota_query = mysqli_query($koneksi, "SELECT nama_lengkap FROM anggota WHERE id = '" . $row['id_user'] . "'"); // Mengubah 'user' menjadi 'anggota'
                                        $nama_anggota = mysqli_fetch_assoc($nama_anggota_query)['nama_lengkap']; // Mengubah 'fullname' menjadi 'nama_lengkap'
                                        $judul_buku_query = mysqli_query($koneksi, "SELECT judul_buku FROM buku WHERE id = '" . $row['id_buku'] . "'");
                                        $judul_buku = mysqli_fetch_assoc($judul_buku_query)['judul_buku'];
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $nama_anggota; ?></td>
                                            <td><?= $judul_buku; ?></td>
                                            <td><?= $row['tanggal_pengembalian']; ?></td>
                                            <td><?= $row['kondisi_buku_saat_dikembalikan']; ?></td>
                                            <td><?= $row['denda']; ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- END -->


                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Pesan Berhasil Edit -->
<script>
    <?php
    if (isset($_SESSION['berhasil']) && $_SESSION['berhasil'] <> '') {
        echo "swal({
            icon: 'success',
            title: 'Berhasil',
            text: '$_SESSION[berhasil]'
        })";
    }
    $_SESSION['berhasil'] = '';
    ?>
</script>

<!-- Pesan Gagal Edit -->
<script>
    <?php
    if (isset($_SESSION['gagal']) && $_SESSION['gagal'] <> '') {
        echo "swal({
                icon: 'error',
                title: 'Gagal',
                text: '$_SESSION[gagal]'
              })";
    }
    $_SESSION['gagal'] = '';
    ?>
</script>