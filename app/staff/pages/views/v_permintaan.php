<!-- jQuery 3 -->
<script src="../../assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Sweet Alert -->
<script src="../../assets/dist/js/sweetalert.min.js"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
            Form Permintaan
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
            <li><a href="dashboard"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">Data Permintaan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#permintaan-pinjaman" data-toggle="tab">Permintaan Pinjaman</a></li>
                        <li><a href="#permintaan-pengembalian" data-toggle="tab">Permintaan Pengembalian</a></li>
                        <li><a href="#permintaan-pendaftaran" data-toggle="tab">Permintaan Pendaftaran</a></li>
                    </ul>
                    <div class="tab-content">

                        <!-- =============== Permintaan Pinjaman =============== -->
                        <div class="tab-pane active" id="permintaan-pinjaman">
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
                                    $query_permintaan = "SELECT p.*, a.nama_lengkap AS nama_anggota, b.judul_buku
                                    FROM permintaan_lvl p
                                    JOIN anggota a ON p.id_user = a.id
                                    JOIN buku b ON p.id_buku = b.id
                                    WHERE p.role = 'Peminjaman'";
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
                                                <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalPermintaanPinjaman<?= $row['id']; ?>" data-role="peminjaman"><i class="fa fa-info"></i> Tindak Lanjuti !</a>
                                            </td>
                                        </tr>

                                        <!-- Form Persetujuan Peminjaman User -->
                                        <div class="modal fade" id="modalPermintaanPinjaman<?= $row['id']; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content" style="border-radius: 5px;">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
                                                            Permintaan Peminjaman ( <?= $namaUser; ?> )
                                                        </h4>
                                                    </div>

                                                    <form id="formPermintaanPinjaman<?= $row['id']; ?>" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="role" value="Peminjaman">
                                                            <input type="hidden" name="aksi" value="setuju">
                                                            <input type="hidden" value="<?= htmlspecialchars($row['id']); ?>" name="idPermintaan">
                                                            <input type="hidden" value="<?= htmlspecialchars($row['id_buku']); ?>" name="idBuku">

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
                                                                <input type="text" class="form-control" value="<?= htmlspecialchars($row['tanggal_permintaan']); ?>" name="tanggalPermintaan" readonly>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Kondisi Buku Saat Dipinjam <small style="color: red;">* Wajib diisi</small> </label>
                                                                <select class="form-control" id="kondisiBuku<?= $row['id']; ?>" data-id="<?= $row['id']; ?>">
                                                                    <option disabled selected>-- Harap Pilih Kondisi Buku --</option>
                                                                    <option value="Baik">Baik</option>
                                                                    <option value="Rusak">Rusak</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Keterangan</label>
                                                                <input type="text" class="form-control" value="<?= htmlspecialchars($row['keterangan']); ?>" name="keterangan" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-success btn-sm btn-setuju" data-dismiss="modal" data-id="<?= $row['id']; ?>" data-buku="<?= $row['id_buku']; ?>">Setuju</button>
                                                            <button type="button" class="btn btn-danger btn-sm btn-tolak" data-dismiss="modal" data-id="<?= $row['id']; ?>">Tolak</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- END Form Persetujuan Peminjaman User -->
                                    <?php
                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div>
                        <!-- END -->

                        <!-- =============== Permintaan Pengembalian =============== -->
                        <div class="tab-pane" id="permintaan-pengembalian">
                            <table class="table table-bordered" id="example2">
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
                                    $query_permintaan = "SELECT p.*, a.nama_lengkap AS nama_anggota, b.judul_buku, pm.kondisi_buku_saat_dipinjam
                                    FROM permintaan_lvl p
                                    JOIN anggota a ON p.id_user = a.id
                                    JOIN buku b ON p.id_buku = b.id
                                    JOIN peminjaman pm ON p.id = pm.id_permintaan_lvl
                                    WHERE p.role = 'Pengembalian'";
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
                                                <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalPermintaanPengembalian<?= $row['id']; ?>" data-role="pengembalian"><i class="fa fa-info"></i> Tindak Lanjuti !</a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="modalPermintaanPengembalian<?= $row['id']; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content" style="border-radius: 5px;">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
                                                            Permintaan Pengembalian ( <?= $namaUser; ?> )
                                                        </h4>
                                                    </div>

                                                    <form id="formPermintaanPengembalian<?= $row['id']; ?>" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="role" value="Pengembalian">
                                                            <input type="hidden" name="aksi" value="setuju">
                                                            <input type="hidden" value="<?= htmlspecialchars($row['id']); ?>" name="idPermintaan">
                                                            <input type="hidden" value="<?= htmlspecialchars($row['id_buku']); ?>" name="idBuku">

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
                                                                <input type="text" class="form-control" value="<?= htmlspecialchars($row['tanggal_permintaan']); ?>" name="tanggalPermintaan" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Kondisi Buku Saat Dipinjam</label>
                                                                <input type="text" class="form-control" value="<?= htmlspecialchars($row['kondisi_buku_saat_dipinjam']); ?>" name="kondisiSaatDipinjam" readonly disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Kondisi Buku Saat Dikembalikan <small style="color: red;">* Wajib diisi</small> </label>
                                                                <select class="form-control" id="kondisiBuku<?= $row['id']; ?>" data-id="<?= $row['id']; ?>">
                                                                    <option disabled selected>-- Harap Pilih Kondisi Buku --</option>
                                                                    <?php if ($row['kondisi_buku_saat_dipinjam'] !== "Rusak") : ?>
                                                                        <option value="Baik">Baik</option>
                                                                    <?php endif; ?>
                                                                    <option value="Rusak">Rusak</option>
                                                                    <option value="Hilang">Hilang</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Keterangan</label>
                                                                <input type="text" class="form-control" value="<?= htmlspecialchars($row['keterangan']); ?>" name="keterangan" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-success btn-sm btn-setuju" data-dismiss="modal" data-id="<?= $row['id']; ?>" data-buku="<?= $row['id_buku']; ?>">Setuju</button>
                                                            <button type="button" class="btn btn-danger btn-sm btn-tolak" data-dismiss="modal" data-id="<?= $row['id']; ?>">Tolak</button>
                                                        </div>
                                                    </form>
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

                        <!-- =============== Permintaan Pendaftaran =============== -->
                        <div class="tab-pane" id="permintaan-pendaftaran">
                            <table class="table table-bordered" id="example3">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Pendaftar</th>
                                        <th>Nomor Hp</th>
                                        <th>Tanggal Disetujui</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include "../../config/koneksi.php";
                                    $no = 1;
                                    $query = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id_user_lvl = 3");
                                    while ($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $row['nis']; ?></td>
                                            <td><?php echo $row['nama_lengkap']; ?></td>
                                            <td><?php echo $row['nomor_hp']; ?></td>
                                            <td><?php echo $row['tanggal_bergabung']; ?></td>
                                            <td>
                                                <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalPermintaanPendaftaran<?= $row['id']; ?>"><i class="fa fa-info"></i> Tindak Lanjuti !</a>
                                            </td>
                                        </tr>
                                        <!-- Modal Pendaftaran Anggota -->
                                        <div class="modal fade" id="modalPermintaanPendaftaran<?= $row['id']; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content" style="border-radius: 5px;">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        <h4 class="modal-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
                                                            Data Pendaftaran ( <?= $row['nama_lengkap']; ?> )
                                                        </h4>
                                                    </div>
                                                    <form action="pages/function/Pendaftaran.php?aksi=setuju" enctype="multipart/form-data" method="POST">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label>Nama Anggota</label>
                                                                <input type="text" class="form-control" value="<?= htmlspecialchars($row['nama_lengkap']); ?>" name="namaAnggota" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>NIS</label>
                                                                <input type="text" class="form-control" value="<?= htmlspecialchars($row['nis']); ?>" name="nis" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Nama Pendaftar</label>
                                                                <input type="text" class="form-control" value="<?= htmlspecialchars($row['nama_lengkap']); ?>" name="namaLengkap" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Nomor Hp</label>
                                                                <input type="text" class="form-control" value="<?= htmlspecialchars($row['nomor_hp']); ?>" name="nomorHp" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Tanggal Disetujui</label>
                                                                <input type="text" class="form-control" value="<?= htmlspecialchars($row['tanggal_bergabung']); ?>" name="tanggalBergabung" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-success btn-sm ">Setuju</button>
                                                            <button type="button" class="btn btn-danger btn-sm ">Tolak</button>
                                                        </div>

                                                    </form>
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

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- =============== Java Script =============== -->

<!-- Notif Berhasil -->
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

<!-- Notif Gagal -->
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

<!-- Permintaan Buku -->
<script>
    $(document).ready(function() {
        $('.btn-danger').on('click', function() {
            var idPermintaan = $(this).data('id');
            var idBuku = $(this).data('buku');
            var kondisiBuku = $('#kondisiBuku' + idPermintaan).val();
            if (kondisiBuku === "") {
                swal("Peringatan", "Harap pilih kondisi buku", "warning");
                return;
            }
        });

        $('.btn-setuju').on('click', function() {
            var idPermintaan = $(this).data('id');
            var idBuku = $(this).data('buku');
            var kondisiBuku = $('#kondisiBuku' + idPermintaan).val();
            swal({
                title: "Peringatan",
                text: "Apakah anda yakin ingin menyetujui permintaan ini ?",
                icon: "warning",
                buttons: ["Tidak, Batalkan !", "Iya, Setujui"],
                dangerMode: true,
            }).then((willApprove) => {
                if (willApprove) {
                    sendApprovalRequest(idPermintaan, idBuku, kondisiBuku);
                } else {
                    swal({
                        icon: 'error',
                        title: 'Dibatalkan',
                        text: 'Data Permintaan tersebut aman !'
                    });
                }
            });
        });

        $('.btn-tolak').on('click', function() {
            var idPermintaan = $(this).data('id');
            swal({
                title: "Peringatan",
                text: "Apakah anda yakin ingin menolak permintaan ini ?",
                icon: "warning",
                buttons: ["Tidak, Batalkan !", "Iya, Tolak"],
                dangerMode: true,
            }).then((willReject) => {
                if (willReject) {
                    sendRejectionRequest(idPermintaan);
                } else {
                    swal({
                        icon: 'error',
                        title: 'Dibatalkan',
                        text: 'Data Permintaan tersebut aman !'
                    });
                }
            });
        });
    });

    function sendApprovalRequest(idPermintaan, idBuku, kondisiBuku) {
        var role = $('input[name="role"]').val(); // Mendapatkan nilai peran (role) dari input hidden

        if (kondisiBuku === "-- Harap Pilih Kondisi Buku --") {
            swal("Gagal", "Harap pilih kondisi buku", "error");
            return; // Stop the function execution
        }

        $.ajax({
            type: 'POST',
            url: 'pages/function/PermintaanBuku.php',
            data: {
                aksi: 'setuju',
                idPermintaan: idPermintaan,
                idBuku: idBuku,
                kondisi_buku: kondisiBuku,
                role: role // Mengirim nilai peran (role) ke skrip PHP
            },
            success: function(response) {
                if (response === 'success') {
                    swal("Berhasil", "Permintaan berhasil disetujui", "success")
                        .then(() => {
                            window.location.reload();
                        });
                } else {
                    swal("Gagal", response, "error");
                }
            },
            error: function(xhr, status, error) {
                swal("Gagal", "Terdapat masalah saat menyetujui permintaan", "error");
                console.error(xhr.responseText);
            }
        });
    }

    function sendRejectionRequest(idPermintaan) {
        var role = $('input[name="role"]').val(); // Mendapatkan nilai peran (role) dari input hidden

        $.ajax({
            type: 'POST',
            url: 'pages/function/PermintaanBuku.php',
            data: {
                aksi: 'tolak',
                idPermintaan: idPermintaan,
                role: role // Mengirim nilai peran (role) ke skrip PHP
            },
            success: function(response) {
                console.log(response); // Tambahkan ini untuk melihat respons dari server
                if (response === 'Permintaan tersebut telah ditolak sebelumnya !') {
                    swal("Gagal", response, "error");
                } else if (response === 'Permintaan telah ditolak') {
                    swal("Berhasil", response, "success")
                        .then(() => {
                            window.location.reload();
                        });
                } else {
                    swal("Gagal", "Respons tidak valid", "error");
                }
            },
            error: function(xhr, status, error) {
                swal("Gagal", "Terdapat masalah saat menolak permintaan", "error");
                console.error(xhr.responseText);
            }
        });
    }
</script>