<!-- jQuery 3 -->
<script src="../../assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../../assets/dist/js/sweetalert.min.js"></script>

<!-- Sertakan jQuery UI -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- Tambahan -->
<script src="https://cdn.jsdelivr.net/npm/animejs"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
            Peminjaman Buku
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
            <li class="active">Peminjaman Buku</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tgl-pinjam" data-toggle="tab">Formulir Peminjaman Buku</a></li>
                        <li><a href="#permintaan-pinjaman" data-toggle="tab">Riwayat Permintaan Peminjaman</a></li>
                        <li><a href="#riwayat-peminjaman-pengembalian" data-toggle="tab">Riwayat Peminjaman/Pengembalian</a></li>
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane active" id="tgl-pinjam">
                            <section id="new">
                                <?php
                                include "../../config/koneksi.php";
                                $id_user = $_SESSION['id_user'];
                                $query = "SELECT COUNT(*) AS jumlah_buku_dipinjam
                                FROM peminjaman p
                                INNER JOIN permintaan_lvl pl ON p.id_permintaan_lvl = pl.id
                                INNER JOIN user u ON pl.id_user = u.id_user
                                WHERE u.id_user = ? AND p.kondisi_buku_saat_dikembalikan = ''"; // Memeriksa apakah buku sudah dikembalikan
                                $stmt = $koneksi->prepare($query);
                                $stmt->bind_param("i", $id_user);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();
                                $jumlah_buku_dipinjam = $row['jumlah_buku_dipinjam'];
                                if ($jumlah_buku_dipinjam > 0) {
                                    echo "<div class='alert alert-danger small'>
                                            Kamu saat ini telah meminjam sebanyak $jumlah_buku_dipinjam buku !
                                        </div>";
                                }
                                // else {
                                //     echo "<div class='alert alert-info small'>
                                //             Kamu belum meminjam buku.
                                //         </div>";
                                // }
                                ?>

                                <!-- =============== Form Menampilkan Buku =============== -->
                                <form id="Buku">
                                    <?php
                                    $id = $_SESSION['id_user'];
                                    $query_fullname = $koneksi->prepare("SELECT * FROM user WHERE id_user = ?");
                                    $query_fullname->bind_param("i", $id);
                                    $query_fullname->execute();
                                    $result_fullname = $query_fullname->get_result();
                                    $row1 = $result_fullname->fetch_array(MYSQLI_ASSOC);
                                    ?>

                                    <div class=" form-group">
                                        <div class="form-inline my-2 my-lg-0">
                                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" aria-label="Search" style="width: 100%;">
                                        </div>
                                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                            <a href="form-list" class="btn btn-secondary btn-sm" style="width: 50px;">
                                                <i class="fa fa-list"></i> List
                                            </a>
                                            <a href="form-kategori" class="btn btn-secondary btn-sm" style="width: 80px;">
                                                <i class="fa fa-tags"></i> Kategori
                                            </a>
                                            <a href="form-penerbit" class="btn btn-secondary btn-sm" style="width: 74px;">
                                                <i class="fa fa-book"></i> Penerbit
                                            </a>
                                            <a href="form-pengarang" class="btn btn-secondary btn-sm" style="width: 80px;">
                                                <i class="fa fa-user"></i> Pengarang
                                            </a>
                                        </div>
                                    </div>

                                    <div class="form-group" style="display: flex; flex-direction: column; align-items: flex-start;">
                                        <div class="row">
                                            <?php
                                            $query = "SELECT id, judul_buku, foto_buku FROM buku";
                                            $result = $koneksi->query($query);
                                            if ($result) {
                                                $no = 1;
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                    <div class="col-sm-2 col-xs-6">
                                                        <div class="small-box" id="draggableBox<?= $no; ?>" data-judul="<?= $row['judul_buku']; ?>" style="background: url('../staff/pages/function/uploadsGambar/<?= $row['foto_buku']; ?>') no-repeat; background-size: 100% 100%; background-position: center center; cursor: pointer; height: 215px; width: 160px;">
                                                            <div class="inner">
                                                                <h3 class="visually-hidden"><?= $no++; ?> </h3>
                                                                <p class=" visually-hidden"><b><?= $row['judul_buku']; ?></b></p>
                                                            </div>
                                                        </div>
                                                        <p class="sembunyikan" data-judul="<?= $row['judul_buku']; ?>" style="text-align: center;"><b><?= $row['judul_buku']; ?></b></p>
                                                        <br>
                                                    </div>
                                            <?php
                                                }
                                            } else {
                                                error_log("Kesalahan database: " . $koneksi->error);
                                                echo "Terjadi kesalahan dalam mengambil data buku.";
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <!-- =============== Menyembunyikan Judul Buku =============== -->
                                    <style>
                                        .animate-book {
                                            transition: transform 0.5s ease-in-out;
                                        }

                                        .selected-book {
                                            transform: scale(0.8);
                                            opacity: 0;
                                            transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out;
                                        }

                                        .visually-hidden {
                                            position: absolute;
                                            width: 1px;
                                            height: 1px;
                                            margin: -1px;
                                            padding: 0;
                                            overflow: hidden;
                                            clip: rect(0, 0, 0, 0);
                                            border: 0;
                                        }
                                    </style>
                                    <!-- End -->
                                </form>

                            </section>
                        </div>
                        <!-- End -->

                        <!-- =============== Riwayat Permintaan Pinjaman =============== -->
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
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $no = 1;
                                    if (session_status() == PHP_SESSION_NONE) {
                                        session_start();
                                    }
                                    $id_pengguna = $_SESSION['id_user'];
                                    $query_permintaan = "SELECT p.*, u.fullname AS nama_anggota, b.judul_buku
                                    FROM permintaan_lvl p
                                    JOIN user u ON p.id_user = u.id_user
                                    JOIN buku b ON p.id_buku = b.id
                                    WHERE p.role = 'Peminjaman' AND p.id_user = $id_pengguna";
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
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div>
                        <!-- END -->

                        <!-- =============== Riwayat Peminjaman/Pengembalian =============== -->
                        <div class="tab-pane" id="riwayat-peminjaman-pengembalian">
                            <table class="table table-bordered" id="example2">
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
                                    if (session_status() == PHP_SESSION_NONE) {
                                        session_start();
                                    }
                                    $id_pengguna = $_SESSION['id_user'];
                                    $query = mysqli_query($koneksi, "SELECT p.*, pl.id_user, pl.id_buku
                                            FROM peminjaman p 
                                            LEFT JOIN permintaan_lvl pl ON p.id_permintaan_lvl = pl.id
                                            WHERE pl.id_user = $id_pengguna");
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        // Mengambil informasi nama anggota dan judul buku dari tabel permintaan_lvl
                                        $nama_anggota_query = mysqli_query($koneksi, "SELECT fullname FROM user WHERE id_user = (SELECT id_user FROM permintaan_lvl WHERE id = '" . $row['id_permintaan_lvl'] . "')");
                                        $nama_anggota = mysqli_fetch_assoc($nama_anggota_query)['fullname'];
                                        $judul_buku_query = mysqli_query($koneksi, "SELECT judul_buku FROM buku WHERE id = (SELECT id_buku FROM permintaan_lvl WHERE id = '" . $row['id_permintaan_lvl'] . "')");
                                        $judul_buku = mysqli_fetch_assoc($judul_buku_query)['judul_buku'];
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $nama_anggota; ?></td>
                                            <td><?= $judul_buku; ?></td>
                                            <td><?= $row['tanggal_peminjaman']; ?></td>
                                            <td><?= $row['tanggal_pengembalian']; ?></td>
                                            <td><?= $row['kondisi_buku_saat_dipinjam']; ?></td>
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
    $(document).ready(function() {
        <?php if (isset($_SESSION['berhasil']) && $_SESSION['berhasil'] <> '') { ?>
            swal({
                icon: 'success',
                title: 'Berhasil',
                text: '<?= $_SESSION['berhasil']; ?>'
            });
        <?php }
        $_SESSION['berhasil'] = ''; ?>
    });
</script>

<!-- Pesan Gagal Edit -->
<script>
    $(document).ready(function() {
        <?php if (isset($_SESSION['gagal']) && $_SESSION['gagal'] <> '') { ?>
            swal({
                icon: 'error',
                title: 'Gagal',
                text: '<?= $_SESSION['gagal']; ?>'
            });
        <?php }
        $_SESSION['gagal'] = ''; ?>
    });
</script>

<!-- Pemilihan Buku -->
<script>
    $(document).ready(function() {
        $(".small-box").on("click", function() {
            var selectedBookJudul = $(this).data("judul");
            $("#judulBuku").val(selectedBookJudul);
        });
    });
</script>

<!-- Fungsi Pencarian -->
<script>
    $(document).ready(function() {
        $("#searchBuku").on("input", function() {
            var searchTerm = $(this).val().toLowerCase();

            $(".small-box").each(function() {
                var judulBuku = $(this).data("judul").toLowerCase();
                var isMatch = judulBuku.includes(searchTerm);
                $(this).toggle(isMatch);
            });

            kelolaVisibilitasJudulBuku(searchTerm);
        });
    });

    function kelolaVisibilitasJudulBuku(kataKunciPencarian) {
        var elemenJudulBuku = document.querySelectorAll('.sembunyikan');

        elemenJudulBuku.forEach(function(elemen) {
            var judulBuku = elemen.getAttribute('data-judul').toLowerCase();
            var isMatch = judulBuku.includes(kataKunciPencarian.toLowerCase());
            elemen.style.display = isMatch ? 'block' : 'none';
        });
    }
</script>