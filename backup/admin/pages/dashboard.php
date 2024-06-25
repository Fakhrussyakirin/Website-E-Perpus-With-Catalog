<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
            Dashboard
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
            <li><a href="beranda"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="alert alert-secondary" style="color: #383d41; background-color: #e2e3e5; border-color: #d6d8db;">
            Selamat Datang <b><?= $_SESSION['fullname']; ?></b>, di Perpustakaan Digital SMPN 2 Mataraman.
        </div>

        <!-- Small boxes (Stat box) -->

        <div class="row">

            <!-- ADMIN -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <?php
                include "../../config/koneksi.php";
                $query_admin = mysqli_query($koneksi, "SELECT * FROM user WHERE role = 'Admin'");
                $row_admin = mysqli_num_rows($query_admin);
                ?>
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?= $row_admin; ?></h3>

                        <p>Data Admin</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="administrator" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <!-- PETUGAS -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <?php
                include "../../config/koneksi.php";
                $query_petugas = mysqli_query($koneksi, "SELECT * FROM user WHERE role = 'Petugas'");
                $row_petugas = mysqli_num_rows($query_petugas);
                ?>
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?= $row_petugas; ?></h3>

                        <p>Data Petugas</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="petugas" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- ANGGOTA -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <?php
                include "../../config/koneksi.php";
                $query_anggota = mysqli_query($koneksi, "SELECT * FROM user WHERE role = 'Anggota'");
                $row_anggota = mysqli_num_rows($query_anggota);
                ?>
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?= $row_anggota; ?></h3>

                        <p>Data Anggota</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="anggota" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>