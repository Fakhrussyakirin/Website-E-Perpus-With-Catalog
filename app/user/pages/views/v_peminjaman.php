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
                        <li><a href="#permintaan-pinjaman" data-toggle="tab">Riwayat Permintaan Pinjaman</a></li>
                        <li><a href="#riwayat-peminjaman-pengembalian" data-toggle="tab">Riwayat Pinjaman/Pengembalian</a></li>
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
                                INNER JOIN anggota a ON pl.id_user = a.id
                                WHERE a.id = ? AND p.kondisi_buku_saat_dikembalikan = ''";
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
                                //                         else {
                                //                             echo "<div class='alert alert-info small'>
                                //     Kamu belum meminjam buku.
                                // </div>";
                                //                         }
                                ?>


                                <!-- =============== Form Menampilkan Buku =============== -->
                                <form id="Buku">
                                    <?php
                                    include "../../config/koneksi.php";
                                    $id = $_SESSION['id_user'];
                                    $query_fullname = $koneksi->prepare("SELECT * FROM anggota WHERE id = ?");
                                    $query_fullname->bind_param("i", $id);
                                    $query_fullname->execute();
                                    $result_fullname = $query_fullname->get_result();
                                    $row1 = $result_fullname->fetch_array(MYSQLI_ASSOC);
                                    ?>

                                    <div class="form-group">
                                        <div class="form-inline my-2 my-lg-0">
                                            <input id="searchInput" class="form-control mr-sm-2" type="search" placeholder="Cari Judul Buku, Kategori, Pengarang . ." aria-label="Search" style="width: 100%;" oninput="handleSearch()">
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
                                                    $book_id = $row['id'];
                                                    $book_title = $row['judul_buku'];
                                            ?>
                                                    <div class="col-sm-2 col-xs-6">
                                                        <a href="home.php?module=pages/views/v_detail_buku&id=<?= $book_id; ?>">
                                                            <div class="small-box" data-judul="<?= $book_title; ?>" style="background: url('../staff/pages/function/uploadsGambar/<?= $row['foto_buku']; ?>') no-repeat; background-size: 100% 100%; background-position: center center; cursor: pointer; height: 215px; width: 160px;">
                                                                <div class="inner">
                                                                    <h3 class="visually-hidden"><?= $no++; ?> </h3>
                                                                    <p class="visually-hidden"><b><?= $book_title; ?></b></p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <p class="sembunyikan" data-judul="<?= $book_title; ?>" style="text-align: center;"><b><?= $book_title; ?></b></p>
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
                                <!-- End -->


                            </section>
                        </div>

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
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <?php
                                include "../../config/koneksi.php";
                                if (session_status() == PHP_SESSION_NONE) {
                                    session_start();
                                }
                                $id_pengguna = $_SESSION['id_user'];
                                $query_permintaan = "SELECT p.*, a.nama_lengkap AS nama_anggota, b.judul_buku
                                FROM permintaan_lvl p
                                JOIN anggota a ON p.id_user = a.id
                                JOIN buku b ON p.id_buku = b.id
                                WHERE p.role = 'Peminjaman' AND p.id_user = ?";
                                $stmt = $koneksi->prepare($query_permintaan);
                                $stmt->bind_param("i", $id_pengguna);
                                $stmt->execute();
                                $result_permintaan = $stmt->get_result();
                                $no = 1;
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
                                    if (session_status() == PHP_SESSION_NONE) {
                                        session_start();
                                    }
                                    $id_pengguna = $_SESSION['id_user'];
                                    $query = "SELECT p.*, pl.id_user, pl.id_buku
                                    FROM peminjaman p 
                                    LEFT JOIN permintaan_lvl pl ON p.id_permintaan_lvl = pl.id
                                    WHERE pl.id_user = ?";
                                    $stmt = $koneksi->prepare($query);
                                    $stmt->bind_param("i", $id_pengguna);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $no = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        // Mengambil informasi nama anggota dan judul buku dari tabel permintaan_lvl
                                        $nama_anggota_query = $koneksi->prepare("SELECT nama_lengkap FROM anggota WHERE id = (SELECT id_user FROM permintaan_lvl WHERE id = ?)");
                                        $nama_anggota_query->bind_param("i", $row['id_permintaan_lvl']);
                                        $nama_anggota_query->execute();
                                        $nama_anggota_result = $nama_anggota_query->get_result();
                                        $nama_anggota_row = $nama_anggota_result->fetch_assoc();
                                        $nama_anggota = $nama_anggota_row['nama_lengkap'];

                                        $judul_buku_query = $koneksi->prepare("SELECT judul_buku FROM buku WHERE id = (SELECT id_buku FROM permintaan_lvl WHERE id = ?)");
                                        $judul_buku_query->bind_param("i", $row['id_permintaan_lvl']);
                                        $judul_buku_query->execute();
                                        $judul_buku_result = $judul_buku_query->get_result();
                                        $judul_buku_row = $judul_buku_result->fetch_assoc();
                                        $judul_buku = $judul_buku_row['judul_buku'];
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.querySelector("#Buku input[type='search']");
        const books = document.querySelectorAll(".small-box");

        searchInput.addEventListener("input", function() {
            const searchTerm = this.value.trim().toLowerCase();

            books.forEach(function(book) {
                const title = book.dataset.judul.toLowerCase();
                if (title.includes(searchTerm)) {
                    book.style.display = "block";
                } else {
                    book.style.display = "none";
                }
            });
        });
    });

    // Fungsi untuk menangani perubahan pada input pencarian
    function handleSearch() {
        var searchInput = document.getElementById('searchInput').value.toLowerCase(); // Ambil nilai pencarian dan ubah menjadi lowercase
        var bookTitles = document.getElementsByClassName('sembunyikan'); // Ambil semua elemen dengan kelas 'sembunyikan'

        // Iterasi melalui semua judul buku
        for (var i = 0; i < bookTitles.length; i++) {
            var title = bookTitles[i].getAttribute('data-judul').toLowerCase(); // Ambil judul buku dan ubah menjadi lowercase

            // Periksa apakah judul buku cocok dengan kata kunci pencarian
            if (title.includes(searchInput)) {
                // Jika cocok, tampilkan kembali elemen judul buku
                bookTitles[i].style.display = 'block';
            } else {
                // Jika tidak cocok, sembunyikan elemen judul buku
                bookTitles[i].style.display = 'none';
            }
        }
    }

    // Tambahkan event listener untuk memanggil fungsi handleSearch() setiap kali nilai pencarian berubah
    document.getElementById('searchInput').addEventListener('input', handleSearch);
</script>