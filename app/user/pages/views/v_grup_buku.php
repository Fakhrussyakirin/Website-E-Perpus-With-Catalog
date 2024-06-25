Content Wrapper. Contains page content
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
            <li><a href="peminjaman-buku"><i class="fa fa-home"></i> Peminjaman Buku</a></li>
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
                            <form id="formPeminjaman">
                                <?php
                                $id = $_SESSION['id_user'];
                                $query_fullname = $koneksi->prepare("SELECT * FROM user WHERE id_user = ?");
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
                                    <div class="row">
                                        <?php
                                        include "../../config/koneksi.php"; // Sertakan file koneksi ke database
                                        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                                            // Ambil ID buku dari parameter URL
                                            $id_buku_yang_diinginkan = $_GET['id'];
                                            // Query untuk mengambil informasi buku berdasarkan ID (gunakan parameterisasi untuk mencegah SQL injection)
                                            $query = "SELECT id_buku, judul_buku, foto_buku, kategori_buku, pengarang, tahun_terbit, deskripsi FROM buku WHERE id_buku = ?";
                                            $stmt = $koneksi->prepare($query);
                                            $stmt->bind_param("i", $id_buku_yang_diinginkan);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            // Periksa apakah query berhasil dieksekusi dan mengembalikan hasil yang valid
                                            if ($result && $result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                        ?>
                                                <div class="col-sm-2 col-xs-6">
                                                    <div class="small-box" id="draggableBox<?= $no; ?>" data-judul="<?= $row['judul_buku']; ?>" style="background: url('../staff/pages/function/uploadsGambar/<?= $row['foto_buku']; ?>') no-repeat; background-size: 100% 100%; background-position: center center; cursor: pointer; height: 215px; width: 160px;">
                                                        <!-- # -->
                                                    </div>
                                                    <p class="sembunyikan" data-judul="<?= $row['judul_buku']; ?>" style="text-align: center;"><b><?= $row['judul_buku']; ?></b></p>
                                                    <br>
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

                            </form>
                            <!-- End -->
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- jQuery 3 -->
<script src="../../assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../../assets/dist/js/sweetalert.min.js"></script>

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