    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1 style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
                Laporan Anggota
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
                            <li class="active"><a href="#kelas" data-toggle="tab">Laporan Anggota</a></li>
                        </ul>
                        <div class="tab-content">

                            <!-- ============= Laporan Anggota ============= -->
                            <div class="tab-pane active" id="kelas">
                                <section id="new">
                                    <form action="../../report/report_anggota/report_anggota.php" method="get" target="_blank" onsubmit="return validateForm()">
                                        <div class="form-group">
                                            <label>Rekap Berdasarkan Kelas</label>
                                            <select class="form-control select" name="kelas">
                                                <option disabled selected>-- Harap Pilih Kelas --</option>
                                                <option value="VII A">VII A</option>
                                                <option value="VII B">VII B</option>
                                                <option disabled>------------------------------------------</option>
                                                <option value="VIII A">VIII A</option>
                                                <option value="VIII B">VIII B</option>
                                                <option disabled>------------------------------------------</option>
                                                <option value="IX">IX</option>
                                                <option disabled>------------------------------------------</option>
                                                <option value="cetakSemua">Cetak Semua</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Tampilkan Data</button>
                                        </div>
                                    </form>
                                </section>
                            </div>
                            <!-- End -->

                            <!-- /.tab-content -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
        </section>
        <!-- /.content -->
    </div>

    <!-- jQuery 3 -->
    <script src="../../assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../../assets/dist/js/sweetalert.min.js"></script>

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

    <!-- Fungsi untuk memeriksa apakah kelas telah dipilih sebelum mengirimkan formulir -->
    <script>
        function showErrorNotification(message) {
            swal({
                icon: 'error',
                title: 'Gagal',
                text: message
            });
        }

        function validateForm() {
            var selectedClass = document.querySelector('select[name="kelas"]').value;
            if (selectedClass === '-- Harap Pilih Kelas --') {
                showErrorNotification('Silakan pilih kelas terlebih dahulu !');
                return false; // Mencegah pengiriman formulir
            }
            return true; // Mengizinkan pengiriman formulir
        }

        function showNoDataNotification() {
            showErrorNotification('Tidak ada anggota yang ditemukan untuk kelas yang dipilih.');
        }
    </script>