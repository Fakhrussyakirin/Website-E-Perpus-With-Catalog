<!-- jQuery 3 -->
<script src="../../assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../../assets/dist/js/sweetalert.min.js"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
            Pengarang Buku
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
            <li><a href="peminjaman-buku"><i class="fa fa-exchange"></i> Peminjaman Buku</a></li>
            <li class="active">List Buku</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="nav-tabs-custom">
                    <div class="tab-content">
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
                        </section>

                        <!-- =============== Form List =============== -->
                        <form id="List">
                            <div class="form-group">
                                <div class="form-inline my-2 my-lg-0">
                                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" style="width: 100%;" id="searchInput">
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

                            <div class="form-group">
                                <ul class="content-list" style="list-style: none; padding: 0;" id="bookList">
                                    <?php
                                    include "../../config/koneksi.php";
                                    $query = "SELECT DISTINCT LEFT(pengarang, 1) AS huruf_awal FROM buku ORDER BY huruf_awal";
                                    $stmt = $koneksi->prepare($query);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                        $letter = $row['huruf_awal']; // No need to escape
                                        echo "<li style='margin-bottom: 10px; border-bottom: 1px dotted darkgrey;'><h2 style='margin-bottom: 5px; font-family: serif;'>" . htmlspecialchars($letter) . "</h2><ul style='list-style: none; padding: 0;'>";
                                        $query_books = "SELECT id, pengarang FROM buku WHERE LEFT(pengarang, 1) = ? GROUP BY pengarang";
                                        $stmt_books = $koneksi->prepare($query_books); // Prepare the query
                                        $stmt_books->bind_param("s", $letter); // Bind parameter
                                        $stmt_books->execute(); // Execute the query
                                        $result_books = $stmt_books->get_result(); // Get the results
                                        while ($book_row = $result_books->fetch_assoc()) {
                                            $book_id = htmlspecialchars($book_row['id']);
                                            $book_title = htmlspecialchars($book_row['pengarang']);
                                            echo "<li>
                                                <a href='home.php?module=pages/views/v_detail_buku&id=$book_id'>
                                                    $book_title
                                                </a>
                                            </li>";
                                        }
                                        echo "</ul></li>";
                                    }
                                    ?>
                                </ul>
                            </div>


                        </form>
                        <!-- End -->

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

<!-- Fungsi Pencarian -->
<script>
    const searchInput = document.getElementById('searchInput');
    const bookList = document.getElementById('bookList').getElementsByTagName('li');
    searchInput.addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        for (let i = 0; i < bookList.length; i++) {
            const bookTitle = bookList[i].textContent.toLowerCase();
            if (bookTitle.includes(searchValue)) {
                bookList[i].style.display = 'block';
            } else {
                bookList[i].style.display = 'none';
            }
        }
    });
</script>