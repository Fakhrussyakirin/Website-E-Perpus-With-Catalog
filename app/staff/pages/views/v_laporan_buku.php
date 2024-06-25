<div class="content-wrapper">
    <section class="content-header">
        <h1 style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
            Laporan Buku
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
                        <li class="active"><a href="#buku" data-toggle="tab">Laporan Buku</a></li>
                    </ul>
                    <div class="tab-content">

                        <!-- ============= Laporan Kategori ============= -->
                        <div class="tab-pane active" id="buku">
                            <section id="new">
                                <form action="../../report/report_buku/report_buku.php" method="get" target="_blank" onsubmit="return validateForm()">
                                    <div class="form-group">
                                        <label>Filter</label>
                                        <select class="form-control select" name="buku">
                                            <option disabled selected>-- Harap Pilih --</option>
                                            <option disabled>------------------------------------------</option>
                                            <option value="kategori">Kategori Buku</option>
                                            <option disabled>------------------------------------------</option>
                                            <option value="pengarang">Pengarang Buku</option>
                                            <option disabled>------------------------------------------</option>
                                            <option value="penerbit">Penerbit Buku</option>
                                            <option disabled>------------------------------------------</option>
                                            <option value="cetakSemua">Cetak Semua</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Rekapitulasi Buku </label>
                                        <input type="text" class="form-control" name="inputan" placeholder="Silahkan masukan nama Kategori/Pengarang/Penerbit" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">Tampilkan Data</button>
                                    </div>
                                </form>
                            </section>
                        </div>
                        <!-- End -->

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

<!-- Fungsi untuk memeriksa apakah filter telah dipilih sebelum mengirimkan formulir -->
<script>
    function showErrorNotification(message) {
        swal({
            icon: 'error',
            title: 'Gagal',
            text: message
        });
    }

    function validateForm() {
        var selectedClass = document.querySelector('select[name="buku"]').value;
        if (selectedClass === '-- Harap Pilih --') {
            showErrorNotification('Silakan pilih kategori filter terlebih dahulu !');
            return false;
        }
        return true;
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var selectElement = document.querySelector('select[name="buku"]');
        var inputElement = document.querySelector('input[name="inputan"]');

        selectElement.addEventListener("change", function() {
            if (selectElement.value === "cetakSemua") {
                inputElement.value = "Cetak semua buku";
                inputElement.readOnly = true;
            } else {
                inputElement.value = "";
                inputElement.readOnly = false;
            }
        });
    });
</script>