<!-- Content Wrapper. Contains page content -->
<style>
    .no-image {
        color: red;
        /* Sesuaikan gaya sesuai kebutuhan */
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
            Form Buku
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
            <li class="active">Data Buku</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">Data Buku</h3>
                        <div class="form-group m-b-2 text-right" style="margin-top: -20px; margin-bottom: -5px;">
                            <button type="button" onclick="tambahBuku()" class="btn btn-info"><i class="fa fa-plus"></i> Tambah Data</button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
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
                                    <th>Foto</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <?php
                            include "../../config/koneksi.php";
                            $no = 1;
                            ?>
                            <tbody>
                                <?php
                                $no = 1;
                                $query = mysqli_query($koneksi, "SELECT buku.*, kategori.nama_kategori, penerbit.nama_penerbit FROM buku 
                                JOIN kategori ON buku.id_kategori = kategori.id
                                JOIN penerbit ON buku.id_penerbit = penerbit.id");
                                while ($row = mysqli_fetch_assoc($query)) { // Menggunakan mysqli_fetch_assoc()
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

                                        <!-- ========================= Menampilkan Foto ========================= -->
                                        <td>
                                            <?php
                                            if ($row['foto_buku'] == "") {
                                            ?>
                                                <img class="foto-buku" src="pages/function/gambar/deffault.png" alt="Foto Buku Default">
                                            <?php
                                            } else {
                                            ?>
                                                <img class="foto-buku" src="pages/function/uploadsGambar/<?= $row['foto_buku']; ?>" alt="Foto Buku" style="max-width: 100px; max-height: 65px;">
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <!-- End -->

                                        <td>
                                            <a href="#" data-target="#modalEditBuku<?= $row['id']; ?>" data-toggle="modal" class="btn btn-info btn-sm btn-block"><i class="fa fa-edit"></i> Ubah</a>
                                            <a href="pages/function/Buku.php?act=hapus&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm btn-del btn-block"><i class="fa fa-trash"></i> Hapus</a>
                                        </td>
                                    </tr>

                                    <!-- ============================== Modal Edit ============================== -->
                                    <div class="modal fade" id="modalEditBuku<?= $row['id']; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content" style="border-radius: 5px;">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">Edit Buku ( <?= $row['judul_buku']; ?> - <?= $row['pengarang']; ?> )</h4>
                                                </div>
                                                <form action="pages/function/Buku.php?act=edit" enctype="multipart/form-data" method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                        <div class="form-group">
                                                            <label>Judul Buku <small style="color: red;">* Wajib diisi</small></label>
                                                            <input type="text" class="form-control" value="<?= $row['judul_buku']; ?>" name="judulBuku">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kategori Buku <small style="color: red;">* Wajib diisi</small></label>
                                                            <select class="form-control" name="kategoriBuku" required>
                                                                <option selected value="<?= $row['id_kategori']; ?>"><?= $row['id_kategori']; ?> ( Dipilih Sebelumnya )</option>
                                                                <?php
                                                                include "../../config/koneksi.php";

                                                                $sql = mysqli_query($koneksi, "SELECT * FROM kategori");
                                                                while ($data = mysqli_fetch_array($sql)) {
                                                                ?>
                                                                    <option value="<?= $data['nama_kategori']; ?>"> <?= $data['nama_kategori']; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Penerbit Buku <small style="color: red;">* Wajib diisi</small></label>
                                                            <select class="form-control select2" name="penerbitBuku">
                                                                <option selected value="<?= $row['id_penerbit']; ?>"><?= $row['id_penerbit']; ?> ( Dipilih Sebelumnya )</option>
                                                                <?php
                                                                include "../../config/koneksi.php";

                                                                $sql = mysqli_query($koneksi, "SELECT * FROM penerbit");
                                                                while ($data = mysqli_fetch_array($sql)) {
                                                                ?>
                                                                    <option value="<?= $data['nama_penerbit']; ?>"><?= $data['nama_penerbit']; ?> ( <?= $data['verif_penerbit']; ?> )</option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Pengarang <small style="color: red;">* Wajib diisi</small></label>
                                                            <input type="text" class="form-control" value="<?= $row['pengarang']; ?>" name="pengarang" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Tahun Terbit <small style="color: red;">* Wajib diisi</small></label>
                                                            <input type="number" min="2000" max="2100" class="form-control" value="<?= $row['tahun_terbit']; ?>" name="tahunTerbit" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>ISBN <small style="color: red;">* Wajib diisi</small></label>
                                                            <input type="number" class="form-control" value="<?= $row['isbn']; ?>" name="iSbn" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Jumlah Buku Baik <small style="color: red;">* Wajib diisi</small></label>
                                                            <input type="number" class="form-control" value="<?= $row['j_buku_baik']; ?>" name="jumlahBukuBaik" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Jumlah Buku Rusak <small style="color: red;">* Wajib diisi</small></label>
                                                            <input type="number" class="form-control" value="<?= $row['j_buku_rusak']; ?>" name="jumlahBukuRusak" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Deskripsi <small style="color: red;">* Wajib diisi</small></label>
                                                            <input type="text" class="form-control" value="<?= $row['deskripsi']; ?>" name="deskripsi" required>
                                                        </div>

                                                        <!-- ============================== Edit Gambar ============================== -->
                                                        <div class="form-group">
                                                            <!-- Input tersembunyi untuk menyimpan nama file gambar sebelumnya -->
                                                            <input type="hidden" name="foto_buku_existing" value="<?= $row['foto_buku']; ?>">

                                                            <!-- Menampilkan gambar buku sebelumnya -->
                                                            <label>Sampul Buku</label>
                                                            <br>
                                                            <img src="pages/function/uploadsGambar/<?= $row['foto_buku']; ?>" alt="Gambar Buku" style="max-width: 328px; max-height: 188px;">
                                                            <br>
                                                            <br>

                                                            <!-- Label untuk mengunggah gambar baru -->
                                                            <label>Ganti Foto Sampul</label>
                                                            <!-- Input file untuk mengunggah gambar baru -->
                                                            <input type="file" name="foto_buku" accept="image/*">
                                                        </div>
                                                        <!-- End -->


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
                                    <!-- /. Modal Edit -->
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

<!-- ============================== Modal Tambah ============================== -->
<div class="modal fade" id="modalTambahBuku">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 5px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">Tambah Buku</h4>
            </div>
            <form action="pages/function/Buku.php?act=tambah" enctype="multipart/form-data" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Judul Buku <small style="color: red;">* Wajib diisi</small></label>
                        <input type="text" class="form-control" placeholder="Masukan Judul Buku" name="judulBuku">
                    </div>
                    <div class="form-group">
                        <label>Kategori Buku <small style="color: red;">* Wajib diisi</small></label>
                        <select class="form-control" name="kategoriBuku" required>
                            <option selected>-- Harap pilih kategori buku --</option>
                            <?php
                            include "../../config/koneksi.php";

                            $sql = mysqli_query($koneksi, "SELECT * FROM kategori");
                            while ($data = mysqli_fetch_array($sql)) {
                            ?>
                                <option value="<?= $data['nama_kategori']; ?>"> <?= $data['nama_kategori']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Penerbit Buku <small style="color: red;">* Wajib diisi</small></label>
                        <select class="form-control select2" name="penerbitBuku">
                            <option selected disabled>-- Harap Pilih Penerbit Buku --</option>
                            <?php
                            include "../../config/koneksi.php";

                            $sql = mysqli_query($koneksi, "SELECT * FROM penerbit");
                            while ($data = mysqli_fetch_array($sql)) {
                            ?>
                                <option value="<?= $data['nama_penerbit']; ?>"><?= $data['nama_penerbit']; ?> ( <?= $data['verif_penerbit']; ?> )</option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pengarang <small style="color: red;">* Wajib diisi</small></label>
                        <input type="text" class="form-control" placeholder="Masukan Nama Pengarang" name="pengarang" required>
                    </div>
                    <div class="form-group">
                        <label>Tahun Terbit <small style="color: red;">* Wajib diisi</small></label>
                        <input type="number" min="2000" max="2100" class="form-control" placeholder="Masukan Tahun Terbit ( Contoh : 2003 )" name="tahunTerbit" required>
                    </div>
                    <div class="form-group">
                        <label>ISBN <small style="color: red;">* Wajib diisi</small></label>
                        <input type="number" class="form-control" placeholder="Masukan ISBN" name="iSbn" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Buku Baik <small style="color: red;">* Wajib diisi</small></label>
                        <input type="number" class="form-control" placeholder="Masukan Jumlah Buku Baik" name="jumlahBukuBaik" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Buku Rusak <small style="color: red;">* Wajib diisi</small></label>
                        <input type="number" class="form-control" placeholder="Masukan Jumlah Buku Rusak" name="jumlahBukuRusak" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi <small style="color: red;">* Wajib diisi</small></label>
                        <input type="text" class="form-control" placeholder="Masukan Deskripsi Buku" name="deskripsi" required>
                    </div>

                    <!-- ============================== Tambah Gambar ============================== -->
                    <div class="form-group">
                        <label>Foto <small style="color: red;">* Wajib diisi </small></label>
                        <input type="file" name="foto_buku" accept="image/*">
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
    function tambahBuku() {
        $('#modalTambahBuku').modal('show');
    }
</script>
<!-- jQuery 3 -->
<script src="../../assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../../assets/dist/js/sweetalert.min.js"></script>


<!-- Pesan Berhasil Edit dan Notif Gagal -->
<script>
    <?php
    if (isset($_SESSION['berhasil']) && $_SESSION['berhasil'] <> '') {
        echo "swal({
            icon: 'success',
            title: 'Berhasil',
            text: '$_SESSION[berhasil]'
        })";
    } elseif (isset($_SESSION['gagal']) && $_SESSION['gagal'] <> '') {
        echo "swal({
            icon: 'error',
            title: 'Gagal',
            text: '$_SESSION[gagal]'
        })";
    }
    $_SESSION['berhasil'] = '';
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
                text: 'Apakah anda yakin ingin menghapus data buku ini ?',
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
                        text: 'Data buku tersebut aman !'
                    })
                }
            });
    })
</script>