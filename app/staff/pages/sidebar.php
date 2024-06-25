<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="../../assets/dist/img/avatar01.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?= $_SESSION['fullname']; ?></p>
                <?php
                include "../../config/koneksi.php";

                $id = $_SESSION['id_user'];

                $query = mysqli_query($koneksi, "SELECT * FROM petugas WHERE id = '$id'");
                $row = mysqli_fetch_array($query);
                ?>

                <?php

                if ($row['id_user_lvl'] == 1) {
                    echo "<a><i class='fa fa-check-circle text-info'></i> Akun Terverifikasi</a>";
                } elseif ($row['id_user_lvl'] == 2) {
                    echo "<a><i class='fa fa-user-circle text-info'></i> Pengguna Biasa</a>";
                } else {
                    echo "<a><i class='fa fa-exclamation text-danger'></i> Tidak Diketahui </a>";
                }

                ?>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN MENU</li>

            <li>
                <a href="dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i>
                    <span>Katalog Buku</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="data-buku"><i class="fa fa-circle-o"></i> Data Buku</a></li>
                    <li><a href="penerbit"><i class="fa fa-circle-o"></i> Data Penerbit</a></li>
                    <li><a href="kategori-buku"><i class="fa fa-circle-o"></i> Kategori Buku</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-folder"></i>
                    <span>Master Data</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="petugas"><i class="fa fa-circle-o"></i> Data Petugas</a></li>
                    <li><a href="siswa"><i class="fa fa-circle-o"></i> Data Anggota</a></li>
                    <li><a href="data-peminjaman"><i class="fa fa-circle-o"></i> Data Peminjaman</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-info"></i>
                    <span>Permintaan</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="permintaan"><i class="fa fa-circle-o"></i>Buku/Anggota</a></li>
                </ul>
            </li>

            <li class="header">LAIN LAIN</li>
            <li>
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Analisa FP-Growth</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i>
                    <span>Laporan Perpustakaan</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="laporan-peminjaman"><i class="fa fa-circle-o"></i> <span>Laporan Peminjaman</span></a></li>
                    <li><a href="laporan-pengembalian"><i class="fa fa-circle-o"></i> <span>Laporan Pengembalian</span></a></li>
                    <li><a href="laporan-buku"><i class="fa fa-circle-o"></i> <span>Laporan Buku</span></a></li>
                    <li><a href="laporan-anggota"><i class="fa fa-circle-o"></i> <span>Laporan Anggota</span></a></li>
                    <li><a href="laporan-transaksi"><i class="fa fa-circle-o"></i> <span>Laporan transaksi</span></a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> <span>Laporan Hasil Analisa</span></a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> <span>Laporan Kartu Anggota</span></a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> <span>Laporan Keterlambatan</span></a></li>
                </ul>
            </li>



            <!-- <li>
                <a href="pesan"><i class="fa fa-envelope"></i>
                    <span>Pesan</span>
                    <span class="pull-right-container" id="jumlahPesan">
                        <?php
                        include "../../config/koneksi.php";

                        $nama_saya = $_SESSION['fullname'];
                        $default = "Belum dibaca";
                        $query_pesan  = mysqli_query($koneksi, "SELECT * FROM pesan WHERE penerima = '$nama_saya' AND status = '$default'");
                        $jumlah_pesan = mysqli_num_rows($query_pesan);

                        $nama_saya = $_SESSION['fullname'];
                        $default = "Belum dibaca";
                        $query_pesan  = mysqli_query($koneksi, "SELECT * FROM pesan WHERE penerima = '$nama_saya' AND status = '$default'");
                        $row_pesan = mysqli_fetch_array($query_pesan);

                        if ($jumlah_pesan == null) {
                        } else {
                            echo "<span class='label label-danger pull-right'>" . $jumlah_pesan . "</span>";
                        }
                        ?>
                    </span>
                </a>
            </li> -->

            <li class="header">LANJUTAN</li>
            <li><a href="#Logout" data-toggle="modal" data-target="#modalLogoutConfirm"><i class="fa fa-sign-out"></i> <span>Keluar</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<div class="modal fade" id="modalLogoutConfirm">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 5px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">Peringatan</h4>
            </div>
            <div class="modal-body">
                <span>Apa anda yakin ingin keluar dari Aplikasi ? <br>
                    Anda harus login kembali jika ingin menggunakan Aplikasi Perpustakaan !</span>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger">Batal</button>
                <a href="keluar" class="btn btn-primary">Iya, Logout</a>
            </div>
        </div>
    </div>
</div>
<script>
    var refreshId = setInterval(function() {
        $('#jumlahPesan').load('./pages/function/Pesan.php?aksi=jumlahPesan');
    }, 500);
</script>