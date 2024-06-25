-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Mar 2024 pada 07.54
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_perpustakaan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `id` int(11) NOT NULL,
  `nis` char(20) NOT NULL,
  `nama_lengkap` varchar(55) NOT NULL,
  `username` varchar(55) NOT NULL,
  `password` varchar(55) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `alamat` varchar(225) NOT NULL,
  `nomor_hp` char(20) NOT NULL,
  `tanggal_bergabung` varchar(55) NOT NULL,
  `terakhir_login` varchar(55) NOT NULL,
  `id_user_lvl` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`id`, `nis`, `nama_lengkap`, `username`, `password`, `kelas`, `alamat`, `nomor_hp`, `tanggal_bergabung`, `terakhir_login`, `id_user_lvl`) VALUES
(3, '200751', 'Muhammad Fajar', 'fajar', 'Fajar', 'VII A', 'Gunung Ulin Mataraman', '081219550857', '10-01-2024', '29-02-2024 ( 23:03:37 )', 2),
(4, '200756', 'Dika Maulana', 'dika maulana', 'Dika Maulana', 'VII B', 'Gunung Ulin, Mataraman', '082190630447', '27-02-2024', '', 2),
(5, '200749', 'Ahmad Jaidi Yannur', 'ahmad jaidi yannur', 'Ahmad Jaidi Yannur', 'VII B', 'Astambul', '085776422447', '27-02-2024', '29-02-2024 ( 12:30:24 )', 2),
(6, '200761', 'Fabiyan Nur Suwadana', 'fabiyan nur suwadana', 'Fabiyan Nur Suwadana', 'VIII B', 'Kelampayan', '089694938291', '27-02-2024', '', 2),
(7, '200755', 'Muhammad Syahril Mubaroq', 'muhammad syahril mubaroq', 'Muhammad Syahril Mubaroq', 'VIII B', 'Karang Intan', '085327333861', '27-02-2024', '29-02-2024 ( 12:28:42 )', 2),
(110, '200759', 'Muhammad Zainal Arifin', 'muhammad zainal arifin', 'Muhammad Zainal Arifin', 'VIII A', 'Karang Intan', '085813221927', '28-02-2024', '', 2),
(111, '200747', 'Siti Rohimah', 'siti rohimah', 'Siti Rohimah', 'IX', 'Martapura, Sekumpul', '082113720777', '28-02-2024', '29-02-2024 ( 12:29:11 )', 2),
(112, '200743', 'Aprisilla Nadien Islami', 'aprisilla nadien islami', 'Aprisilla Nadien Islami', 'IX', 'Martapura, Sekumpul', '085213931566', '28-02-2024', '', 2),
(121, '123', 'M.Noor', 'm.noor', 'M.Noor', '', '', '123', 'Belum disetujui !', '', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id` int(11) NOT NULL,
  `judul_buku` varchar(125) NOT NULL,
  `pengarang` varchar(125) NOT NULL,
  `tahun_terbit` varchar(125) NOT NULL,
  `isbn` int(50) NOT NULL,
  `j_buku_baik` varchar(125) NOT NULL,
  `j_buku_rusak` varchar(125) NOT NULL,
  `foto_buku` varchar(255) DEFAULT NULL,
  `deskripsi` varchar(425) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_penerbit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id`, `judul_buku`, `pengarang`, `tahun_terbit`, `isbn`, `j_buku_baik`, `j_buku_rusak`, `foto_buku`, `deskripsi`, `id_kategori`, `id_penerbit`) VALUES
(1, 'Jujutsu Kaisen Vol.01', 'Gege Akutami', '2021', 2147483647, '34', '6', '65b50f28224ad.jpg', 'Yuji Itadori seorang murid SMA dengan kemampuan atletik yang luar biasa. Kesehariannya adalah menjenguk kakeknya yang terbaring di rumah sakit. Suatu hari, segel \"objek terkutuk\" yang berada di sekolahnya terlepas, monster-monster pun mulai bermunculan. Yuji menyusup ke dalam gedung sekolah demi menolong senior di klubnya, akan tetapi...!?', 11, 16),
(2, 'Laskar Pelangi', 'Andrea Hirata', '2005', 2147483647, '40', '0', '65b1edbf116ff.jpg', 'Laskar Pelangi telah menjadi international best seller, diterjemahkan ke dalam 40 bahasa asing. Telah terbit dalam 22 bahasa, diedarkan di lebih dari 130 negara. Melalui program beasiswa, Hirata meraih Master of Science (M.Sc.) bidang teori ekonomi dari Sheffield Hallam University, UK. Hirata juga mendapat beasiswa pendidikan sastra di IWP (International Writing Program), University of Iowa, USA.', 12, 8),
(3, 'Pintu Harmonika', 'Tere Liye', '2007', 2147483647, '35', '5', '65b1ee2f33b90.jpeg', 'Rizal, Juni, dan David menemukan surga lewat ketidaksengajaan; Buka pintu harmonika, berjalan mengikuti sinar matahari, dan temukan surga. Surga yang tersembunyi di belakang ruko tempat tinggal mereka.', 12, 7),
(4, 'Si Juki: Cari Kerja', 'Faza Meonk', '2006', 2147483647, '36', '4', '65b1ef3147d09.jpeg', 'Setelah lulus SMA, Juki—bocah nyentrik yang ngakunya Anti mainstream—memutuskan untuk langsung bekerja. Dengan keterampilan seadanya, kelakuan nyeleneh, dan teman-teman yang ajaib, Juki memulai petualangannya.', 11, 7),
(5, 'Interaktif (PPKn)', 'Sigit Dwi Nuridha, Aprilia Nur Kurniawati', '2021', 2147483647, '38', '2', '65b517d87d2a3.jpg', ' Keunggulan buku ini: konten multimedia melalui QR Code, paket soal variatif mirip dengan AN, Olimpiade, SBMPTN, dan HOTS, serta fitur pendukung pembelajaran seperti Computational Thinking, Pojok Literasi, dan fitur Proyek Penguatan Profil Pelajar Pancasila. Dilengkapi juga dengan Buku Digital terintegrasi Jelajah Ilmu, yang gratis dan memungkinkan interaksi sosial serta monitoring orang tua.', 2, 14),
(6, 'Thinking, Fast and Slow', 'Daniel Kahneman', '2011', 2147483647, '40', '0', '65b35f0b4c3b5.jpeg', 'Buku ini mengulas psikologi pengambilan keputusan, berdasarkan peristiwa di Universitas Ibrani Yerusalem 1969. Kahneman menyoroti kelebihan dan kekurangan berpikir cepat serta dampaknya. Dampaknya termasuk hilangnya antusiasme terhadap strategi korporat, kesulitan memprediksi kebahagiaan, tantangan menilai risiko, dan dampak bias kognitif pada berbagai situasi.', 15, 9),
(8, 'Aroma Karsa', 'Sapardi Djoko Damono', '2001', 2147483647, '37', '3', '65b360333f6bb.jpg', 'Dari sebuah lontar kuno, Raras Prayagung mengetahui bahwa Puspa Karsa yang dikenalnya sebagai dongeng, ternyata tanaman sungguhan yang tersembunyi di tempat rahasia. Obsesi Raras untuk memburu dan menemukan Puspa Karsa, bunga sakti yang konon mampu mengendalikan kehendak dan hanya bisa diidentifikasi melalui aroma, mempertemukannya dengan Jati Wesi.', 16, 7),
(9, 'Negeri 5 Menara', 'Ahmad Fuadi', '2009', 2147483647, '40', '0', '65b360e1baf27.jpg', ' \"Negeri 5 Menara\" oleh Ahmad Fuadi, wartawan TEMPO & VOA, penerima beasiswa, penyuka fotografi, dan mantan Direktur Komunikasi NGO konservasi. Alumni Pondok Modern Gontor, HI Unpad, George Washington University, dan Royal Holloway, University of London. Ia mengalokasikan sebagian royalti trilogi ini untuk mendirikan Komunitas Menara, lembaga sosial bantu pendidikan masyarakat tak mampu dengan sukarelawan.', 17, 7),
(10, 'Mimpi Sejuta Dolar', 'Merry Riana', '2009', 2147483647, '38', '2', '65b1ebacc6285.jpg', 'Buku Merry Riana: Mimpi Sejuta Dollar akan membawakan kisah hidup Merry yang inspirasional. Mulai dari kondisi terendahnya, perubahan pola pikirnya, perwujudan impiannya, hingga titik awal kesuksesannya. Buku ini juga mencantumkan formula sukses yang dijalani Merry dan berbagai kata-kata yang sangat motivasional.', 14, 7),
(11, 'Jujutsu Kaisen 4', 'Gege Akutami', '2021', 2147483647, '35', '5', '65b50edc214a3.jpg', ' Itadori bertemu Junpei dalam penyelidikan pembunuhan \"kutukan\". Awalnya tanpa prasangka, Itadori jadi akrab dengan Junpei. Namun, Junpei terpesona oleh bujukan Mahito dan bertikai dengan Itadori. Saat mencoba mengembalikan Junpei, Itadori dicemooh oleh Sukuna dan Mahito. Mampukah Itadori membebaskan Junpei dari kutukan?', 11, 16),
(12, 'Pulang ', 'Tere Liye', '2020', 2147483647, '40', '0', '65b3cda85a8d6.jpeg', 'Novel Pulang oleh Tere Liye menceritakan perjalanan hidup seorang pria dari Bukit Tinggi yang menjadi tukang jagal sukses di kota. Meski sukses, ia merasa kehampaan dalam hidupnya. Prestasi di bidang shadow economy tak memberikan ketenangan. Akhirnya, ia menyadari arti sejati pulang adalah menjemput kedamaian.', 1, 12),
(13, 'Interaktif: Informatika', 'Galih Pangesthi, Triyanti', '2022', 2147483647, '39', '1', '65b5202c6af5c.jpg', 'Buku Interaktif: Informatika SMP/MTs Kelas 7 akan menjadi pendamping yang tepat untuk melakukan pembelajaran dengan kurikulum merdeka.', 2, 14),
(14, 'Top Rank Buku Pintar IPA', 'WINDA SOETRISNO DESY LISTIYANTI', '2022', 2147483647, '40', '0', '65b5cb18d1998.jpg', 'Buku ini berisi materi pelajaran IPA SMP untuk kelas 1, 2, dan 3. Materi dalam buku ini disusun berdasarkan kurikulum dan kisi-kisi ujian nasional IPA untuk siswa SMP yang terbaru. Buku ini juga dilengkapi dengan peta konsep dan pola soal-soal yang sering muncul di ujian nasional.', 2, 15);

-- --------------------------------------------------------

--
-- Struktur dari tabel `identitas`
--

CREATE TABLE `identitas` (
  `id_identitas` int(11) NOT NULL,
  `nama_app` varchar(50) NOT NULL,
  `alamat_app` text NOT NULL,
  `email_app` varchar(125) NOT NULL,
  `nomor_hp` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(1, 'Novel '),
(2, 'Pelajaran'),
(4, 'Biografi'),
(7, 'Agama'),
(9, 'Majalah'),
(10, 'Kamus'),
(11, 'Komik'),
(12, 'Sastra'),
(13, 'Sejarah'),
(14, 'Motivasi'),
(15, 'Psikologi'),
(16, 'Puisi'),
(17, 'Pendidikan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemberitahuan`
--

CREATE TABLE `pemberitahuan` (
  `id_pemberitahuan` int(11) NOT NULL,
  `isi_pemberitahuan` varchar(255) NOT NULL,
  `level_user` varchar(125) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemberitahuan`
--

INSERT INTO `pemberitahuan` (`id_pemberitahuan`, `isi_pemberitahuan`, `level_user`, `status`) VALUES
(1, '<i class=\'fa fa-exchange\'></i> #Reza  Saputra Telah meminjam Buku', 'Admin', 'Sudah dibaca'),
(2, '<i class=\'fa fa-repeat\'></i> #Reza  Saputra Telah mengembalikan Buku', 'Admin', 'Sudah dibaca'),
(3, '<i class=\'fa fa-exchange\'></i> #Syaker Telah meminjam Buku', 'Admin', 'Sudah dibaca'),
(4, '<i class=\'fa fa-exchange\'></i> #Agus Fifiyanto Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(5, '<i class=\'fa fa-exchange\'></i> #Agus Fifiyanto Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(6, '<i class=\'fa fa-exchange\'></i> #Ahmad Rizki Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(7, '<i class=\'fa fa-repeat\'></i> #Ahmad Rizki Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(8, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(9, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(10, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(11, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(12, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(13, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(14, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(15, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(16, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(17, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(18, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(19, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(20, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(21, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(22, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(23, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(24, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(25, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(26, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(27, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(28, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(29, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(30, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(31, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(32, '<i class=\'fa fa-exchange\'></i> #Fakhrussyakirin Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(33, '<i class=\'fa fa-exchange\'></i> #Fakhrussyakirin Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(34, '<i class=\'fa fa-exchange\'></i> #Fakhrussyakirin Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(35, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(36, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(37, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(38, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(39, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(40, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(41, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(42, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(43, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(44, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(45, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Sudah dibaca'),
(46, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(47, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(48, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(49, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(50, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(51, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(52, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(53, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(54, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(55, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(56, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(57, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(58, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(59, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(60, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(61, '<i class=\'fa fa-repeat\'></i> #Muhammad Fajar Telah mengembalikan Buku', 'Admin', 'Belum dibaca'),
(62, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca'),
(63, '<i class=\'fa fa-exchange\'></i> #Muhammad Fajar Telah meminjam Buku', 'Admin', 'Belum dibaca');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `tanggal_peminjaman` varchar(125) NOT NULL,
  `tanggal_pengembalian` varchar(125) NOT NULL,
  `kondisi_buku_saat_dipinjam` varchar(125) NOT NULL,
  `kondisi_buku_saat_dikembalikan` varchar(125) NOT NULL,
  `denda` varchar(125) NOT NULL,
  `id_permintaan_lvl` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `tanggal_peminjaman`, `tanggal_pengembalian`, `kondisi_buku_saat_dipinjam`, `kondisi_buku_saat_dikembalikan`, `denda`, `id_permintaan_lvl`) VALUES
(105, '28-02-2024', '28-02-2024', 'Baik', 'Baik', '0', 148),
(106, '24-02-2024', '24-02-2024', 'Baik', 'Baik', '0', 149),
(107, '24-02-2024', '24-02-2024', 'Baik', 'Baik', '0', 150),
(108, '24-02-2024', '24-02-2024', 'Baik', 'Baik', '0', 151),
(109, '23-02-2024', '23-02-2024', 'Baik', 'Rusak', '20000', 152),
(110, '23-02-2024', '23-02-2024', 'Baik', 'Baik', '0', 153),
(111, '23-02-2024', '23-02-2024', 'Baik', 'Hilang', '50000', 154),
(112, '29-02-2024', '29-02-2024', 'Baik', 'Baik', '0', 155),
(113, '29-02-2024', '29-02-2024', 'Baik', 'Rusak', '20000', 156),
(114, '29-02-2024', '29-02-2024', 'Baik', 'Baik', '0', 157);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id_pendaftaran` int(11) NOT NULL,
  `nis_pendaftar` char(20) NOT NULL,
  `nama_pendaftar` varchar(125) NOT NULL,
  `nomor_hp` char(55) NOT NULL,
  `username_pendaftar` varchar(55) NOT NULL,
  `password_pendaftar` varchar(55) NOT NULL,
  `tanggal_mendaftar` varchar(125) NOT NULL,
  `status` enum('Disetujui','Ditolak','Belum ada tindakan') DEFAULT 'Belum ada tindakan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pendaftaran`
--

INSERT INTO `pendaftaran` (`id_pendaftaran`, `nis_pendaftar`, `nama_pendaftar`, `nomor_hp`, `username_pendaftar`, `password_pendaftar`, `tanggal_mendaftar`, `status`) VALUES
(53, '200759', 'Muhammad Zainal Arifin', '085813221927', 'muhammad zainal arifin', 'Muhammad Zainal Arifin', '28-02-2024', 'Disetujui'),
(54, '200747', 'Siti Rohimah', '082113720777', 'siti rohimah', 'Siti Rohimah', '28-02-2024', 'Disetujui'),
(55, '123456', 'Fadil Ridwansyah', '081219550857', 'fadil ridwansyah', 'Fadil Ridwansyah', '28-02-2024', 'Ditolak'),
(56, '200743', 'Aprisilla Nadien Islami', '085213931566', 'aprisilla nadien islami', 'Aprisilla Nadien Islami', '28-02-2024', 'Disetujui');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penerbit`
--

CREATE TABLE `penerbit` (
  `id` int(11) NOT NULL,
  `nama_penerbit` varchar(50) NOT NULL,
  `verif_penerbit` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penerbit`
--

INSERT INTO `penerbit` (`id`, `nama_penerbit`, `verif_penerbit`) VALUES
(7, 'Gramedia Pustaka Utama', 'Terverifikasi'),
(8, 'Bentang Pustaka', 'Terverifikasi'),
(9, 'Farrar, Straus and Giroux', 'Terverifikasi'),
(11, 'Republika', 'Terverifikasi'),
(12, 'Sabak Grip Nusantara', 'Terverifikasi'),
(13, 'Pusat Kurikulum dan Perbukuan Kemendikbudristek', 'Terverifikasi'),
(14, 'PT PENERBIT INTAN PARIWARA', 'Terverifikasi'),
(15, 'Bintang Wahyu', 'Terverifikasi'),
(16, 'Elex Media Komputindo', 'Terverifikasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permintaan_lvl`
--

CREATE TABLE `permintaan_lvl` (
  `id` int(11) NOT NULL,
  `keterangan` varchar(125) NOT NULL,
  `tanggal_permintaan` varchar(125) NOT NULL,
  `role` varchar(125) NOT NULL,
  `status` varchar(125) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `permintaan_lvl`
--

INSERT INTO `permintaan_lvl` (`id`, `keterangan`, `tanggal_permintaan`, `role`, `status`, `id_user`, `id_buku`) VALUES
(148, 'Permintaan telah direspon', '28-02-2024 (13.48)', 'Pengembalian', '<span style=\"color: green; font-weight: bold;\">Telah disetujui !</span>', 3, 14),
(149, 'Permintaan telah direspon', '29-02-2024 (12.29)', 'Pengembalian', '<span style=\"color: green; font-weight: bold;\">Telah disetujui !</span>', 111, 2),
(150, 'Permintaan telah direspon', '29-02-2024 (12.29)', 'Pengembalian', '<span style=\"color: green; font-weight: bold;\">Telah disetujui !</span>', 111, 3),
(151, 'Permintaan telah direspon', '29-02-2024 (12.29)', 'Pengembalian', '<span style=\"color: green; font-weight: bold;\">Telah disetujui !</span>', 111, 8),
(152, 'Permintaan telah direspon', '29-02-2024 (12.30)', 'Pengembalian', '<span style=\"color: green; font-weight: bold;\">Telah disetujui !</span>', 5, 1),
(153, 'Permintaan telah direspon', '29-02-2024 (12.30)', 'Pengembalian', '<span style=\"color: green; font-weight: bold;\">Telah disetujui !</span>', 5, 12),
(154, 'Permintaan telah direspon', '29-02-2024 (12.30)', 'Pengembalian', '<span style=\"color: green; font-weight: bold;\">Telah disetujui !</span>', 5, 13),
(155, 'Permintaan telah direspon', '29-02-2024 (12.28)', 'Pengembalian', '<span style=\"color: green; font-weight: bold;\">Telah disetujui !</span>', 7, 11),
(156, 'Permintaan telah direspon', '29-02-2024 (12.28)', 'Pengembalian', '<span style=\"color: green; font-weight: bold;\">Telah disetujui !</span>', 7, 6),
(157, 'Permintaan telah direspon', '29-02-2024 (12.28)', 'Pengembalian', '<span style=\"color: green; font-weight: bold;\">Telah disetujui !</span>', 7, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesan`
--

CREATE TABLE `pesan` (
  `id_pesan` int(11) NOT NULL,
  `penerima` varchar(50) NOT NULL,
  `pengirim` varchar(50) NOT NULL,
  `judul_pesan` varchar(50) NOT NULL,
  `isi_pesan` text NOT NULL,
  `status` varchar(50) NOT NULL,
  `tanggal_kirim` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE `petugas` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(55) NOT NULL,
  `username` varchar(55) NOT NULL,
  `password` varchar(55) NOT NULL,
  `tanggal_bergabung` varchar(55) NOT NULL,
  `terakhir_login` varchar(55) NOT NULL,
  `id_user_lvl` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`id`, `nama_lengkap`, `username`, `password`, `tanggal_bergabung`, `terakhir_login`, `id_user_lvl`) VALUES
(6, 'Muhammad Noor, S.Pd', 'M.Noor', 'm123', '29-02-2024', '01-03-2024 ( 02:03:38 )', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_lvl`
--

CREATE TABLE `user_lvl` (
  `id` int(11) NOT NULL,
  `role` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_lvl`
--

INSERT INTO `user_lvl` (`id`, `role`) VALUES
(1, 'Petugas'),
(2, 'Anggota'),
(3, 'Pending');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user_lvl` (`id_user_lvl`);

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kategori` (`id_kategori`,`id_penerbit`),
  ADD KEY `id_penerbit` (`id_penerbit`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pemberitahuan`
--
ALTER TABLE `pemberitahuan`
  ADD PRIMARY KEY (`id_pemberitahuan`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_permintaan` (`id_permintaan_lvl`);

--
-- Indeks untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`);

--
-- Indeks untuk tabel `penerbit`
--
ALTER TABLE `penerbit`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `permintaan_lvl`
--
ALTER TABLE `permintaan_lvl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indeks untuk tabel `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`id_pesan`);

--
-- Indeks untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user_lvl` (`id_user_lvl`);

--
-- Indeks untuk tabel `user_lvl`
--
ALTER TABLE `user_lvl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `pemberitahuan`
--
ALTER TABLE `pemberitahuan`
  MODIFY `id_pemberitahuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `penerbit`
--
ALTER TABLE `penerbit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `permintaan_lvl`
--
ALTER TABLE `permintaan_lvl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT untuk tabel `pesan`
--
ALTER TABLE `pesan`
  MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `user_lvl`
--
ALTER TABLE `user_lvl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD CONSTRAINT `anggota_ibfk_1` FOREIGN KEY (`id_user_lvl`) REFERENCES `user_lvl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `buku_ibfk_2` FOREIGN KEY (`id_penerbit`) REFERENCES `penerbit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_permintaan_lvl`) REFERENCES `permintaan_lvl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `permintaan_lvl`
--
ALTER TABLE `permintaan_lvl`
  ADD CONSTRAINT `permintaan_lvl_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `anggota` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permintaan_lvl_ibfk_3` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD CONSTRAINT `petugas_ibfk_1` FOREIGN KEY (`id_user_lvl`) REFERENCES `user_lvl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
