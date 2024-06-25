<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
            Form Anggota
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
                    //
                </script>
            </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Data Anggota</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">Data Anggota</h3>
                        <div class="form-group m-b-2 text-right" style="margin-top: -20px; margin-bottom: -5px;">
                            <button type="button" onclick="tambahAnggota()" class="btn btn-info"><i class="fa fa-plus"></i> Tambah Data</button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama Lengkap</th>
                                    <th>Kelas</th>
                                    <th>Alamat</th>
                                    <th>Nomor Hp</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                include "../../config/koneksi.php";
                                $no = 1;
                                $query = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id_user_lvl = 2");
                                while ($row = mysqli_fetch_assoc($query)) {
                                ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row['nis']; ?></td>
                                        <td><?php echo $row['nama_lengkap']; ?></td>
                                        <td><?php echo $row['kelas']; ?></td>
                                        <td><?php echo $row['alamat']; ?></td>
                                        <td><?php echo $row['nomor_hp']; ?></td>
                                        <td>
                                            <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalEditAnggota<?php echo $row['id']; ?>"><i class="fa fa-edit"></i> Ubah</a>
                                            <a href="pages/function/Anggota.php?aksi=hapus&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm btn-del"><i class="fa fa-trash"></i> Hapus</a>
                                        </td>
                                    </tr>
                                    <!-- Modal Edit Anggota -->
                                    <div class="modal fade" id="modalEditAnggota<?= $row['id']; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content" style="border-radius: 5px;">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
                                                        Edit Anggota ( <?= $row['nama_lengkap']; ?> )
                                                    </h4>
                                                </div>
                                                <form action="pages/function/Anggota.php?aksi=edit" enctype="multipart/form-data" method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" value="<?= $row['id']; ?>" name="idUser">
                                                        <div class="form-group">
                                                            <label>Nomor Induk Siswa </label>
                                                            <input type="text" class="form-control" value="<?= $row['nis']; ?>" name="nis">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nama Lengkap </label>
                                                            <input type="text" class="form-control" value="<?= $row['nama_lengkap']; ?>" name="namaLengkap">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nama Pengguna </label>
                                                            <input type="text" class="form-control" value="<?= $row['username']; ?>" name="username">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kata Sandi </label>
                                                            <input type="text" class="form-control" value="<?= $row['password']; ?>" name="password">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kelas <small style="color: red;">* Wajib diisi</small></label>
                                                            <select class="form-control" name="kelas">
                                                                <?php
                                                                $selected_kelas = $row['kelas'];
                                                                $kelas_options = ['VII A', 'VII B', 'VIII A', 'VIII B', 'IX'];
                                                                foreach ($kelas_options as $kelas_option) {
                                                                    $selected = ($selected_kelas == $kelas_option) ? 'selected' : '';
                                                                    echo "<option value='$kelas_option' $selected>$kelas_option</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Alamat </label>
                                                            <textarea class="form-control" style="resize: none; height: 60px;" name="alamat"><?= $row['alamat']; ?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nomor Hp </label>
                                                            <input type="text" class="form-control" value="<?= $row['nomor_hp']; ?>" name="nomorHp">
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
                                    <!-- /. Modal Edit Anggota-->

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

<div class="modal fade" id="modalTambahAnggota">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 5px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">Tambah Anggota</h4>
            </div>
            <form action="pages/function/Anggota.php?aksi=tambah" enctype="multipart/form-data" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nomor Induk Siswa <small style="color: red;">* Wajib diisi</small></label>
                        <input type="number" class="form-control" placeholder="Masukan NIS" name="nis" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap <small style="color: red;">* Wajib diisi</small></label>
                        <input type="text" class="form-control" placeholder="Masukan Nama Lengkap" name="namaLengkap" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Pengguna <small style="color: red;">* Wajib diisi</small></label>
                        <input type="text" class="form-control" placeholder="Masukan Nama Pengguna" name="username" required>
                    </div>
                    <div class="form-group">
                        <label>Kata Sandi <small style="color: red;">* Wajib diisi</small></label>
                        <input type="text" class="form-control" placeholder="Masukan Kata Sandi" name="password" required>
                    </div>
                    <div class="form-group">
                        <label>Kelas <small style="color: red;">* Wajib diisi</small></label>
                        <select class="form-control" name="kelas">
                            <option disabled>------------------------------------------</option>
                            <!-- X -->
                            <option disabled selected>-- Harap Pilih Kelas --</option>
                            <!-- X -->
                            <option value="VII A">VII A</option>
                            <option value="VII B">VII B</option>
                            <!-- XI -->
                            <option disabled>------------------------------------------</option>
                            <option value="VIII A">VIII A</option>
                            <option value="VIII B">VIII B</option>
                            <!-- XI -->
                            <option disabled>------------------------------------------</option>
                            <option value="IX">IX</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Alamat <small style="color: red;">* Wajib diisi</small></label>
                        <textarea class="form-control" style="resize: none; height: 70px;" name="alamat" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Nomor Hp <small style="color: red;">* Wajib diisi</small></label>
                        <input type="number" class="form-control" placeholder="Masukan Nomor Telepon" name="nomorHp" required>
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
    function tambahAnggota() {
        $('#modalTambahAnggota').modal('show');
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
                text: 'Apakah anda yakin ingin menghapus data anggota ini ?',
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
                        text: 'Data anggota tersebut aman !'
                    })
                }
            });
    })
</script>