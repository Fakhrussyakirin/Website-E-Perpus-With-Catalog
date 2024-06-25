<!-- jQuery 3 -->
<script src="../../assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../../assets/dist/js/sweetalert.min.js"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
            Detail Buku
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
            <li><a href="peminjaman-buku"><i class="fa fa-exchange"></i> Peminjaman Buku</a></li>
            <li class="active">Detail Buku</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="nav-tabs-custom">
                    <div class="tab-content">
                        <section id="new">

                            <!-- =============== Form Peminjaman Buku =============== -->
                            <form id="formPeminjaman" action="pages/function/Peminjaman.php?aksi=pinjam" method="POST">
                                <?php
                                $id = $_SESSION['id_user'];
                                $query_fullname = $koneksi->prepare("SELECT * FROM anggota WHERE id = ?");
                                $query_fullname->bind_param("i", $id);
                                $query_fullname->execute();
                                $result_fullname = $query_fullname->get_result();
                                $row1 = $result_fullname->fetch_array(MYSQLI_ASSOC);
                                ?>

                                <div class="form-group">
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

                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="namaAnggota" value="<?= $row1['nama_lengkap']; ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <?php
                                        include "../../config/koneksi.php";
                                        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                                            $id_buku_yang_diinginkan = $_GET['id'];
                                            $query = "SELECT b.*, k.nama_kategori, p.nama_penerbit
                                            FROM buku b
                                            LEFT JOIN kategori k ON b.id_kategori = k.id
                                            LEFT JOIN penerbit p ON b.id_penerbit = p.id
                                            WHERE b.id = ?";
                                            $stmt = $koneksi->prepare($query);
                                            $stmt->bind_param("i", $id_buku_yang_diinginkan);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            if ($result && $result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                        ?>
                                                <div class="col-sm-2 col-xs-6" style="height: 215px;">
                                                    <div class="small-box" data-judul="<?= $row['judul_buku']; ?>" style="background: url('../staff/pages/function/uploadsGambar/<?php echo $row['foto_buku']; ?>') no-repeat; background-size: 100% 100%; background-position: center center; height: 100%; width: 160px;">
                                                        <div class="inner">
                                                            <p class="visually-hidden"><b><?= $row['judul_buku']; ?></b></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-10 col-xs-6" style="height: 215px;">
                                                    <div class="small-box bg-white" style="height: 100%;">
                                                        <div class="inner">
                                                            <p data-judul="<?= $row['judul_buku']; ?>">
                                                                <b><?= $row['judul_buku']; ?></b>
                                                            </p>
                                                            <p data-deskripsi="<?= $row['deskripsi']; ?>"> <?= $row['deskripsi']; ?> </p>
                                                            <b>
                                                                <p data-kategori="<?= $row['nama_kategori']; ?>" style="font-size: 12px;"> Kategori : <?= $row['nama_kategori']; ?> </p>
                                                                <p data-pengarang="<?= $row['pengarang']; ?>" style="font-size: 12px;"> Pengarang : <?= $row['pengarang']; ?> </p>
                                                                <p data-tahun-terbit="<?= $row['tahun_terbit']; ?>" style="font-size: 12px;"> Tahun Terbit : <?= $row['tahun_terbit']; ?> </p>
                                                            </b>
                                                        </div>
                                                    </div>

                                                    <style>
                                                        .inner:hover {
                                                            color: black;
                                                        }
                                                    </style>
                                                </div>
                                        <?php
                                            } else {
                                                echo "Buku tidak ditemukan atau terjadi kesalahan dalam mengambil data buku.";
                                            }
                                        } else {
                                            echo "ID buku tidak valid atau tidak tersedia.";
                                        }
                                        ?>
                                    </div>
                                </div>

                                <!-- =============== Menyembunyikan Judul Buku =============== -->
                                <style>
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

                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="judulBuku" id="judulBuku" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Peminjaman :</label>
                                    <input type="text" class="form-control" name="tanggalPeminjaman" value="<?= date('d-m-Y'); ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Pinjam</button>
                                </div>
                            </form>
                            <!-- End -->

                        </section>
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

<!-- Input Judul otomatis -->
<script>
    var judulBuku = document.querySelector('.small-box').getAttribute('data-judul');
    document.getElementById('judulBuku').value = judulBuku;
</script>