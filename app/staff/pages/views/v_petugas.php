<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
            Form Petugas
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
            <li class="active">Data Petugas</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">Data Petugas</h3>
                        <div class="form-group m-b-2 text-right" style="margin-top: -20px; margin-bottom: -5px;">
                            <button type="button" onclick="tambahPetugas()" class="btn btn-info"><i class="fa fa-plus"></i> Tambah Petugas</button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Nama Pengguna</th>
                                    <th>Kata Sandi</th>
                                    <th>Terakhir Login</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "../../config/koneksi.php";
                                $no = 1;
                                $query = mysqli_query($koneksi, "SELECT * FROM petugas");
                                while ($row = mysqli_fetch_assoc($query)) {
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row['nama_lengkap']; ?></td>
                                        <td><?= $row['username']; ?></td>
                                        <td>
                                            <?php
                                            $pass = $_SESSION['password'];
                                            if ($row['password'] == $pass) {
                                                echo $row['password'];
                                            } else {
                                                echo "************";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($row['terakhir_login'] == null) {
                                                echo "Tidak diketahui !";
                                            } else {
                                                echo $row['terakhir_login'];
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalEditPetugas<?= $row['id']; ?>"><i class="fa fa-edit"></i> Ubah</a>
                                            <a href="pages/function/Petugas.php?act=hapus&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm btn-del" onclick="hapusAnggota()"><i class="fa fa-trash"></i> Hapus</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>

                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM petugas");
                        while ($row = mysqli_fetch_assoc($query)) {
                        ?>
                            <!-- Modal Edit Petugas -->
                            <div class="modal fade" id="modalEditPetugas<?= $row['id']; ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="border-radius: 5px;">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">Edit Petugas</h4>
                                        </div>
                                        <form action="pages/function/Petugas.php?act=edit" enctype="multipart/form-data" method="POST">
                                            <input type="hidden" name="id_petugas" value="<?= $row['id']; ?>">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Nama Lengkap <small style="color: red;">* Wajib diisi</small></label>
                                                    <input type="text" class="form-control" name="fullname" value="<?= $row['nama_lengkap']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama Pengguna <small style="color: red;">* Wajib diisi</small></label>
                                                    <input type="text" class="form-control" name="username" value="<?= $row['username']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kata Sandi <small style="color: red;">* Wajib diisi</small></label>
                                                    <input type="password" class="form-control" name="password" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        <?php
                        }
                        ?>

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

<!-- Modal Tambah Petugas -->
<div class="modal fade" id="modalTambahPetugas">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 5px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">Tambah Petugas</h4>
            </div>
            <form action="pages/function/Petugas.php?act=tambah" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- -->
                    <input type="hidden" name="id_user_lvl" value="1"> <!-- Sesuaikan dengan tingkat akses petugas -->
                    <div class="form-group">
                        <label>Nama Lengkap <small style="color: red;">* Wajib diisi</small></label>
                        <input type="text" class="form-control" placeholder="Masukkan Nama Lengkap" name="nama_lengkap" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Pengguna <small style="color: red;">* Wajib diisi</small></label>
                        <input type="text" class="form-control" placeholder="Masukkan Nama Pengguna" name="username" required>
                    </div>
                    <div class="form-group">
                        <label>Kata Sandi <small style="color: red;">* Wajib diisi</small></label>
                        <input type="password" class="form-control" placeholder="Masukkan Kata Sandi" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script>
    function tambahPetugas() {
        $('#modalTambahPetugas').modal('show');
    }
</script>

<!-- jQuery 3 -->
<script src="../../assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../../assets/dist/js/sweetalert.min.js"></script>

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

<!-- Swal Hapus Data -->
<script>
    $('.btn-del').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href')

        swal({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Apakah anda yakin ingin menghapus data Petugas ini ?',
                buttons: true,
                dangerMode: true,
                buttons: ['Tidak, Batalkan !', 'Iya, Hapus']
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.location.href = href;
                } else {
                    swal({
                        icon: 'error',
                        title: 'Dibatalkan',
                        text: 'Data Petugas tersebut tetap aman !'
                    })
                }
            });
    })
</script>