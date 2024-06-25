    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1 style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
                Laporan Peminjaman
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
                <li class="active">Laporan Perpustakaan</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#harian" data-toggle="tab">Laporan Harian</a></li>
                            <li><a href="#bulanan" data-toggle="tab">Laporan Bulanan</a></li>
                            <li><a href="#nama-anggota" data-toggle="tab">Laporan Nama Peminjam</a></li>
                        </ul>

                        <div class="tab-content">
                            <!-- ============= Laporan Harian ============= -->
                            <div class="tab-pane active" id="harian">
                                <section id="new">
                                    <form action="../../report/report_peminjaman/report_harian.php" method="get" target="_blank">
                                        <div class="form-group">
                                            <label for="datepicker">Rekap Berdasarkan Tanggal</label>
                                            <input type="text" class="form-control" id="datepicker" name="tanggal_peminjaman" placeholder="Silahkan pilih atau masukan tanggal pinjaman (Contoh 03-05-2023)" required>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Tampilkan Data</button>
                                        </div>
                                    </form>
                                </section>
                            </div>
                            <!-- End -->

                            <!-- ============= Laporan Bulanan ============= -->
                            <div class="tab-pane" id="bulanan">
                                <form action="../../report/report_peminjaman/report_bulanan.php" method="get" target="_blank">
                                    <div class="form-group">
                                        <label for="datepicker">Rekap Berdasarkan Bulan</label>
                                        <input type="text" class="form-control" name="bln_pinjm" id="datepicker1" placeholder="Silahkan pilih atau masukan bulan pinjaman (Contoh 05/2023)" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">Tampilkan Data</button>
                                    </div>
                                </form>
                            </div>
                            <!-- End -->

                            <!-- ============= Laporan Nama Anggota / NIS ============= -->
                            <div class="tab-pane" id="nama-anggota">
                                <form action="../../report/report_peminjaman/report_namapeminjam.php" method="get" target="_blank">
                                    <div class="form-group">
                                        <label>Rekap Berdasarkan Nama</label>
                                        <input type="text" class="form-control" name="nama_anggota" placeholder="Masukan nama lengkap peminjam (Contoh Muhammad Fajar)" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">Tampilkan Data</button>
                                    </div>
                                </form>
                            </div>
                            <!-- End -->

                            <!-- /.tab-content -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>

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