-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 28, 2026 at 11:19 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koperasi_bmt`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_anggota`
--

CREATE TABLE `tbl_anggota` (
  `id_anggota` varchar(6) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `nama_anggota` varchar(30) NOT NULL,
  `tempat_lahir` varchar(20) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `gender` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `pekerjaan` varchar(30) NOT NULL,
  `status` varchar(20) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `keterangan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_anggota`
--

INSERT INTO `tbl_anggota` (`id_anggota`, `nik`, `nama_anggota`, `tempat_lahir`, `tanggal_lahir`, `gender`, `alamat`, `pekerjaan`, `status`, `tanggal_masuk`, `keterangan`) VALUES
('AGT001', '3174010112980001', 'Alvin', 'Padang', '1998-12-31', 'Laki-laki', 'Padang', 'Mahasiswa', 'Belum Menikah', '2020-01-07', 'Pending'),
('AGT002', '3174021231200002', 'Testing', 'Padang', '2020-12-31', 'Laki-laki', 'Padang', 'Ex. Mahasiswa', 'Belum Menikah', '2020-01-07', 'Pending'),
('AGT003', '3603012901030003', 'Ana', 'Tangerang', '2003-01-29', 'Perempuan', 'Koang Jaya', 'Pegawai Swasta', 'Belum Menikah', '2026-04-17', 'Pending'),
('AGT004', '3578010515900004', 'Budi Santoso', 'Surabaya', '1990-05-15', 'Laki-laki', 'Surabaya', 'Wiraswasta', 'Menikah', '2024-01-10', 'Aktif'),
('AGT005', '3273022203950005', 'Citra Dewi', 'Bandung', '1995-03-22', 'Perempuan', 'Bandung', 'Pegawai Swasta', 'Belum Menikah', '2024-02-14', 'Aktif'),
('AGT006', '3471010511880006', 'Dodi Prasetyo', 'Yogyakarta', '1988-11-05', 'Laki-laki', 'Yogyakarta', 'Guru', 'Menikah', '2024-03-01', 'Aktif'),
('AGT007', '3374024807930007', 'Eka Putri', 'Semarang', '1993-07-18', 'Perempuan', 'Semarang', 'Pegawai Negeri', 'Menikah', '2024-04-05', 'Aktif'),
('AGT008', '3573023009920008', 'Fajar Nugroho', 'Malang', '1992-09-30', 'Laki-laki', 'Malang', 'Wiraswasta', 'Belum Menikah', '2024-05-20', 'Pending'),
('AGT009', '1271014301970009', 'Gita Sari', 'Medan', '1997-01-12', 'Perempuan', 'Medan', 'Mahasiswa', 'Belum Menikah', '2024-06-15', 'Pending'),
('AGT010', '7371012504850010', 'Hendra Wijaya', 'Makassar', '1985-04-25', 'Laki-laki', 'Makassar', 'Dokter', 'Menikah', '2024-07-08', 'Pending'),
('AGT011', '3257159341702973', 'Kiki Pratama', 'Denpasar', '1986-10-02', 'Perempuan', 'Denpasar', 'Dokter', 'Menikah', '2025-01-21', 'Aktif'),
('AGT012', '3205243753697128', 'Yanti Sari', 'Denpasar', '1972-05-04', 'Laki-laki', 'Denpasar', 'Petani', 'Belum Menikah', '2024-04-07', 'Aktif'),
('AGT013', '3982758196214511', 'Tono Kusuma', 'Denpasar', '1993-03-17', 'Laki-laki', 'Denpasar', 'Dokter', 'Menikah', '2024-05-03', 'Aktif'),
('AGT014', '3659369860564563', 'Eka Saputra', 'Jakarta', '2000-05-19', 'Laki-laki', 'Jakarta', 'Dosen', 'Menikah', '2024-11-16', 'Aktif'),
('AGT015', '3181886305724505', 'Budi Setiawan', 'Tangerang', '1986-08-25', 'Laki-laki', 'Tangerang', 'Pedagang', 'Menikah', '2025-04-26', 'Aktif'),
('AGT016', '3656404298584338', 'Vina Pratama', 'Denpasar', '1992-10-06', 'Perempuan', 'Denpasar', 'Pedagang', 'Menikah', '2025-05-29', 'Aktif'),
('AGT017', '3942099567384026', 'Dedi Siregar', 'Malang', '1991-02-14', 'Laki-laki', 'Malang', 'Pedagang', 'Menikah', '2024-02-06', 'Aktif'),
('AGT018', '3340644063290102', 'Xaverius Setiawan', 'Surabaya', '2000-01-26', 'Perempuan', 'Surabaya', 'Buruh', 'Belum Menikah', '2025-11-07', 'Aktif'),
('AGT019', '3268820815795955', 'Ahmad Indah', 'Padang', '1976-08-21', 'Perempuan', 'Padang', 'Petani', 'Menikah', '2024-09-24', 'Aktif'),
('AGT020', '3602326138181305', 'Feri Indah', 'Bandung', '2000-04-11', 'Laki-laki', 'Bandung', 'Wiraswasta', 'Menikah', '2025-01-07', 'Aktif'),
('AGT021', '3230534070396992', 'Ahmad Hidayat', 'Yogyakarta', '1999-07-19', 'Laki-laki', 'Yogyakarta', 'Wiraswasta', 'Belum Menikah', '2024-05-18', 'Aktif'),
('AGT022', '3319502724767399', 'Cici Saputra', 'Bekasi', '1994-06-20', 'Perempuan', 'Bekasi', 'Guru', 'Belum Menikah', '2025-04-02', 'Aktif'),
('AGT023', '3950729040948195', 'Gita Pratama', 'Bogor', '1991-04-26', 'Perempuan', 'Bogor', 'Buruh', 'Belum Menikah', '2024-08-31', 'Aktif'),
('AGT024', '3811526360504077', 'Siti Wijaya', 'Medan', '2000-09-17', 'Perempuan', 'Medan', 'Petani', 'Menikah', '2024-04-02', 'Aktif'),
('AGT025', '3622639287369119', 'Dedi Putri', 'Malang', '1996-07-27', 'Laki-laki', 'Malang', 'Wiraswasta', 'Belum Menikah', '2025-08-14', 'Aktif'),
('AGT026', '3414088849514727', 'Rizky Sari', 'Makassar', '1981-06-25', 'Perempuan', 'Makassar', 'Pegawai Swasta', 'Belum Menikah', '2025-07-05', 'Aktif'),
('AGT027', '3724766995334818', 'Kiki Pratama', 'Yogyakarta', '1986-07-27', 'Laki-laki', 'Yogyakarta', 'Pegawai Swasta', 'Belum Menikah', '2024-10-02', 'Aktif'),
('AGT028', '3844187234075365', 'Siti Kusuma', 'Depok', '1997-12-12', 'Laki-laki', 'Depok', 'Mahasiswa', 'Menikah', '2025-08-23', 'Aktif'),
('AGT029', '3760132682787374', 'Xaverius Sari', 'Denpasar', '1987-09-20', 'Laki-laki', 'Denpasar', 'PNS', 'Belum Menikah', '2025-03-21', 'Aktif'),
('AGT030', '3767029503522840', 'Eka Putri', 'Bekasi', '1975-07-07', 'Laki-laki', 'Bekasi', 'Wiraswasta', 'Belum Menikah', '2024-11-16', 'Aktif'),
('AGT031', '3743481221951343', 'Nina Putri', 'Tangerang', '1981-06-17', 'Perempuan', 'Tangerang', 'Dokter', 'Menikah', '2024-10-28', 'Aktif'),
('AGT032', '3280021373269796', 'Ahmad Putri', 'Palembang', '1988-08-07', 'Perempuan', 'Palembang', 'Mahasiswa', 'Belum Menikah', '2024-11-18', 'Aktif'),
('AGT033', '3126591070443039', 'Yanti Saputra', 'Bandung', '1973-01-22', 'Perempuan', 'Bandung', 'Mahasiswa', 'Belum Menikah', '2024-10-24', 'Aktif'),
('AGT034', '3190213015626912', 'Rina Pratama', 'Semarang', '1974-01-18', 'Laki-laki', 'Semarang', 'Dosen', 'Menikah', '2024-05-10', 'Aktif'),
('AGT035', '3891107397411936', 'Ayu Siregar', 'Medan', '1975-01-01', 'Laki-laki', 'Medan', 'Pegawai Swasta', 'Menikah', '2024-01-22', 'Aktif'),
('AGT036', '3358012012164176', 'Sari Indah', 'Jakarta', '1991-03-23', 'Laki-laki', 'Jakarta', 'Pegawai Swasta', 'Menikah', '2024-03-03', 'Aktif'),
('AGT037', '3522902371952376', 'Zainal Lestari', 'Depok', '1999-08-13', 'Perempuan', 'Depok', 'Petani', 'Belum Menikah', '2024-01-24', 'Aktif'),
('AGT038', '3956327687679286', 'Ahmad Wahyuni', 'Padang', '2000-01-30', 'Laki-laki', 'Padang', 'Buruh', 'Belum Menikah', '2025-12-28', 'Aktif'),
('AGT039', '3737499012807821', 'Yanti Saputra', 'Makassar', '1973-12-04', 'Laki-laki', 'Makassar', 'Petani', 'Menikah', '2025-12-10', 'Aktif'),
('AGT040', '3747856299428120', 'Qori Pratama', 'Bandung', '1991-01-02', 'Perempuan', 'Bandung', 'Dosen', 'Belum Menikah', '2024-09-28', 'Aktif'),
('AGT041', '3389569152614421', 'Putri Pratama', 'Padang', '1987-12-05', 'Laki-laki', 'Padang', 'Buruh', 'Menikah', '2024-08-08', 'Aktif'),
('AGT042', '3635195870264249', 'Budi Nugroho', 'Palembang', '1979-08-23', 'Perempuan', 'Palembang', 'Wiraswasta', 'Menikah', '2024-04-30', 'Aktif'),
('AGT043', '3393045628543028', 'Ujang Gunawan', 'Malang', '1976-08-22', 'Perempuan', 'Malang', 'Mahasiswa', 'Belum Menikah', '2025-08-04', 'Aktif'),
('AGT044', '3201887630833468', 'Yanti Putri', 'Tangerang', '1971-03-22', 'Laki-laki', 'Tangerang', 'Dokter', 'Menikah', '2024-10-19', 'Aktif'),
('AGT045', '3880816518543927', 'Joko Hidayat', 'Denpasar', '1981-12-22', 'Laki-laki', 'Denpasar', 'Petani', 'Belum Menikah', '2024-05-18', 'Aktif'),
('AGT046', '3304091981591865', 'Wira Putri', 'Semarang', '1990-08-22', 'Laki-laki', 'Semarang', 'Pedagang', 'Menikah', '2025-12-21', 'Aktif'),
('AGT047', '3305963375757438', 'Rizky Setiawan', 'Semarang', '1995-06-24', 'Perempuan', 'Semarang', 'Dokter', 'Menikah', '2024-02-05', 'Aktif'),
('AGT048', '3571121777394842', 'Zainal Hidayat', 'Palembang', '1995-05-06', 'Perempuan', 'Palembang', 'Mahasiswa', 'Belum Menikah', '2024-06-20', 'Aktif'),
('AGT049', '3856956807424485', 'Putri Indah', 'Yogyakarta', '1984-08-13', 'Perempuan', 'Yogyakarta', 'Pegawai Swasta', 'Belum Menikah', '2024-04-16', 'Aktif'),
('AGT050', '3828964388891004', 'Iwan Gunawan', 'Makassar', '1990-05-20', 'Perempuan', 'Makassar', 'Mahasiswa', 'Belum Menikah', '2025-05-30', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login`
--

CREATE TABLE `tbl_login` (
  `id` int NOT NULL,
  `id_anggota` varchar(6) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `level` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_login`
--

INSERT INTO `tbl_login` (`id`, `id_anggota`, `username`, `password`, `level`) VALUES
(1, '', 'sekretaris', 'sekretaris', 'sekretaris'),
(2, '', 'bendahara', 'bendahara', 'bendahara'),
(3, '', 'admin', 'admin123', 'admin'),
(6, 'AGT001', 'alvin', '123', 'anggota'),
(7, 'AGT002', 'testing', '1234', 'anggota'),
(8, 'AGT003', 'ana', 'ana123', 'anggota'),
(9, 'AGT004', 'budi', 'budi123', 'anggota'),
(10, 'AGT005', 'citra', 'citra123', 'anggota'),
(11, 'AGT006', 'dodi', 'dodi123', 'anggota'),
(12, 'AGT007', 'eka', 'eka123', 'anggota'),
(13, 'AGT008', 'fajar', 'fajar123', 'anggota'),
(14, 'AGT009', 'gita', 'gita123', 'anggota'),
(15, 'AGT010', 'hendra', 'hendra123', 'anggota'),
(16, 'AGT011', 'kiki11', 'pass11123', 'anggota'),
(17, 'AGT012', 'yanti12', 'pass12123', 'anggota'),
(18, 'AGT013', 'tono13', 'pass13123', 'anggota'),
(19, 'AGT014', 'eka14', 'pass14123', 'anggota'),
(20, 'AGT015', 'budi15', 'pass15123', 'anggota'),
(21, 'AGT016', 'vina16', 'pass16123', 'anggota'),
(22, 'AGT017', 'dedi17', 'pass17123', 'anggota'),
(23, 'AGT018', 'xaverius18', 'pass18123', 'anggota'),
(24, 'AGT019', 'ahmad19', 'pass19123', 'anggota'),
(25, 'AGT020', 'feri20', 'pass20123', 'anggota'),
(26, 'AGT021', 'ahmad21', 'pass21123', 'anggota'),
(27, 'AGT022', 'cici22', 'pass22123', 'anggota'),
(28, 'AGT023', 'gita23', 'pass23123', 'anggota'),
(29, 'AGT024', 'siti24', 'pass24123', 'anggota'),
(30, 'AGT025', 'dedi25', 'pass25123', 'anggota'),
(31, 'AGT026', 'rizky26', 'pass26123', 'anggota'),
(32, 'AGT027', 'kiki27', 'pass27123', 'anggota'),
(33, 'AGT028', 'siti28', 'pass28123', 'anggota'),
(34, 'AGT029', 'xaverius29', 'pass29123', 'anggota'),
(35, 'AGT030', 'eka30', 'pass30123', 'anggota'),
(36, 'AGT031', 'nina31', 'pass31123', 'anggota'),
(37, 'AGT032', 'ahmad32', 'pass32123', 'anggota'),
(38, 'AGT033', 'yanti33', 'pass33123', 'anggota'),
(39, 'AGT034', 'rina34', 'pass34123', 'anggota'),
(40, 'AGT035', 'ayu35', 'pass35123', 'anggota'),
(41, 'AGT036', 'sari36', 'pass36123', 'anggota'),
(42, 'AGT037', 'zainal37', 'pass37123', 'anggota'),
(43, 'AGT038', 'ahmad38', 'pass38123', 'anggota'),
(44, 'AGT039', 'yanti39', 'pass39123', 'anggota'),
(45, 'AGT040', 'qori40', 'pass40123', 'anggota'),
(46, 'AGT041', 'putri41', 'pass41123', 'anggota'),
(47, 'AGT042', 'budi42', 'pass42123', 'anggota'),
(48, 'AGT043', 'ujang43', 'pass43123', 'anggota'),
(49, 'AGT044', 'yanti44', 'pass44123', 'anggota'),
(50, 'AGT045', 'joko45', 'pass45123', 'anggota'),
(51, 'AGT046', 'wira46', 'pass46123', 'anggota'),
(52, 'AGT047', 'rizky47', 'pass47123', 'anggota'),
(53, 'AGT048', 'zainal48', 'pass48123', 'anggota'),
(54, 'AGT049', 'putri49', 'pass49123', 'anggota'),
(55, 'AGT050', 'iwan50', 'pass50123', 'anggota');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pembayaran`
--

CREATE TABLE `tbl_pembayaran` (
  `id_angsuran` varchar(6) NOT NULL,
  `id_pinjaman` varchar(6) NOT NULL,
  `cicilan` int NOT NULL,
  `jml_bayar` int NOT NULL,
  `tgl_bayar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pembayaran`
--

INSERT INTO `tbl_pembayaran` (`id_angsuran`, `id_pinjaman`, `cicilan`, `jml_bayar`, `tgl_bayar`) VALUES
('AGN001', 'PJN001', 1, 2200000, '2020-02-03'),
('AGN002', 'PJN002', 1, 1000000, '2024-03-01'),
('AGN003', 'PJN003', 1, 1100000, '2024-04-01'),
('AGN004', 'PJN004', 1, 2300000, '2024-05-01'),
('AGN005', 'PJN005', 1, 600000, '2024-06-01'),
('AGN006', 'PJN006', 1, 1100000, '2024-07-01'),
('AGN007', 'PJN007', 1, 1200000, '2024-08-01'),
('AGN008', 'PJN008', 1, 800000, '2024-09-01'),
('AGN009', 'PJN009', 1, 550000, '2024-10-01'),
('AGN010', 'PJN010', 1, 1100000, '2024-11-01'),
('AGN011', 'PJN023', 11, 1200000, '2024-06-22'),
('AGN012', 'PJN028', 3, 1100000, '2025-05-03'),
('AGN013', 'PJN018', 5, 1300000, '2024-08-26'),
('AGN014', 'PJN001', 6, 1100000, '2024-08-18'),
('AGN015', 'PJN019', 11, 1600000, '2025-07-14'),
('AGN016', 'PJN003', 7, 2000000, '2025-05-26'),
('AGN017', 'PJN018', 10, 600000, '2024-07-14'),
('AGN018', 'PJN017', 11, 1200000, '2025-06-22'),
('AGN019', 'PJN010', 2, 1500000, '2024-10-30'),
('AGN020', 'PJN006', 12, 500000, '2025-08-27'),
('AGN021', 'PJN006', 10, 700000, '2025-09-14'),
('AGN022', 'PJN030', 6, 1800000, '2024-02-12'),
('AGN023', 'PJN028', 6, 800000, '2025-02-19'),
('AGN024', 'PJN002', 7, 2000000, '2025-01-28'),
('AGN025', 'PJN029', 7, 2000000, '2025-01-27'),
('AGN026', 'PJN028', 2, 1200000, '2024-09-28'),
('AGN027', 'PJN023', 4, 1400000, '2025-01-15'),
('AGN028', 'PJN029', 5, 800000, '2025-12-06'),
('AGN029', 'PJN028', 1, 1900000, '2025-06-06'),
('AGN030', 'PJN019', 2, 1400000, '2025-04-21'),
('AGN031', 'PJN002', 11, 1300000, '2024-09-10'),
('AGN032', 'PJN005', 2, 900000, '2024-06-29'),
('AGN033', 'PJN001', 2, 1200000, '2024-04-07'),
('AGN034', 'PJN001', 3, 700000, '2025-04-12'),
('AGN035', 'PJN028', 4, 1700000, '2025-12-12'),
('AGN036', 'PJN027', 1, 1700000, '2024-10-15'),
('AGN037', 'PJN002', 2, 1500000, '2024-03-03'),
('AGN038', 'PJN017', 5, 500000, '2025-05-08'),
('AGN039', 'PJN011', 6, 1100000, '2024-10-01'),
('AGN040', 'PJN011', 6, 1600000, '2024-11-21'),
('AGN041', 'PJN004', 4, 800000, '2024-03-26'),
('AGN042', 'PJN012', 4, 900000, '2026-01-05'),
('AGN043', 'PJN010', 11, 700000, '2024-10-04'),
('AGN044', 'PJN015', 7, 800000, '2025-03-30'),
('AGN045', 'PJN026', 2, 1400000, '2025-05-11'),
('AGN046', 'PJN017', 4, 1000000, '2025-02-26'),
('AGN047', 'PJN019', 3, 1800000, '2024-09-15'),
('AGN048', 'PJN015', 9, 1300000, '2025-10-07'),
('AGN049', 'PJN001', 3, 600000, '2024-12-06'),
('AGN050', 'PJN009', 1, 1300000, '2025-06-04');

--
-- Triggers `tbl_pembayaran`
--
DELIMITER $$
CREATE TRIGGER `ubah_pinjaman` AFTER INSERT ON `tbl_pembayaran` FOR EACH ROW BEGIN
UPDATE tbl_pinjaman SET jumlah_pinjaman = jumlah_pinjaman-NEW.jml_bayar WHERE id_pinjaman=NEW.id_pinjaman;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengambilan`
--

CREATE TABLE `tbl_pengambilan` (
  `id_pengambilan` varchar(6) NOT NULL,
  `tgl_pengambilan` date NOT NULL,
  `id_anggota` varchar(6) NOT NULL,
  `jumlah_pengambilan` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pengambilan`
--

INSERT INTO `tbl_pengambilan` (`id_pengambilan`, `tgl_pengambilan`, `id_anggota`, `jumlah_pengambilan`) VALUES
('PGN002', '2020-01-03', 'AGT002', 150000),
('PGN003', '2024-03-15', 'AGT001', 100000),
('PGN004', '2024-06-20', 'AGT001', 50000),
('PGN005', '2024-04-10', 'AGT002', 50000),
('PGN006', '2024-07-05', 'AGT003', 200000),
('PGN007', '2024-09-12', 'AGT003', 100000),
('PGN008', '2024-10-20', 'AGT004', 150000),
('PGN009', '2025-01-15', 'AGT004', 100000),
('PGN010', '2025-02-28', 'AGT005', 100000),
('PGN011', '2025-04-10', 'AGT005', 50000),
('PGN012', '2024-01-21', 'AGT045', 150000),
('PGN013', '2025-06-28', 'AGT048', 200000),
('PGN014', '2024-11-08', 'AGT044', 150000),
('PGN015', '2024-01-01', 'AGT005', 150000),
('PGN016', '2025-05-27', 'AGT043', 100000),
('PGN017', '2026-01-20', 'AGT004', 50000),
('PGN018', '2024-04-18', 'AGT015', 200000),
('PGN019', '2025-09-05', 'AGT029', 150000),
('PGN020', '2024-05-29', 'AGT007', 100000),
('PGN021', '2024-07-06', 'AGT038', 150000),
('PGN022', '2024-09-30', 'AGT011', 200000),
('PGN023', '2024-01-25', 'AGT001', 150000),
('PGN024', '2024-06-30', 'AGT036', 200000),
('PGN025', '2025-05-28', 'AGT011', 50000),
('PGN026', '2024-03-21', 'AGT045', 100000),
('PGN027', '2024-10-27', 'AGT033', 200000),
('PGN028', '2024-09-13', 'AGT005', 100000),
('PGN029', '2024-10-10', 'AGT050', 50000),
('PGN030', '2024-02-06', 'AGT029', 150000),
('PGN031', '2025-08-04', 'AGT018', 200000);

--
-- Triggers `tbl_pengambilan`
--
DELIMITER $$
CREATE TRIGGER `delete_saldo` AFTER DELETE ON `tbl_pengambilan` FOR EACH ROW BEGIN
UPDATE tbl_tabungan SET saldo = saldo+old.jumlah_pengambilan WHERE id_anggota=old.id_anggota;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `kurang_saldo` AFTER INSERT ON `tbl_pengambilan` FOR EACH ROW BEGIN
UPDATE tbl_tabungan SET saldo = saldo-NEW.jumlah_pengambilan WHERE id_anggota=NEW.id_anggota;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pinjaman`
--

CREATE TABLE `tbl_pinjaman` (
  `id_pinjaman` varchar(6) NOT NULL,
  `tgl_pinjaman` date NOT NULL,
  `id_anggota` varchar(6) NOT NULL,
  `bunga_perbulan` float NOT NULL,
  `lama_cicilan` int NOT NULL,
  `jumlah_pinjaman` int NOT NULL,
  `angsuran` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pinjaman`
--

INSERT INTO `tbl_pinjaman` (`id_pinjaman`, `tgl_pinjaman`, `id_anggota`, `bunga_perbulan`, `lama_cicilan`, `jumlah_pinjaman`, `angsuran`) VALUES
('PJN001', '2020-01-03', 'AGT002', 0.1, 12, 21800000, 2200000),
('PJN002', '2024-02-01', 'AGT001', 0.05, 6, 5000000, 1000000),
('PJN003', '2024-03-01', 'AGT003', 0.1, 12, 10900000, 1100000),
('PJN004', '2024-04-01', 'AGT004', 0.05, 24, 47700000, 2300000),
('PJN005', '2024-05-01', 'AGT005', 0.1, 6, 3000000, 600000),
('PJN006', '2024-06-01', 'AGT006', 0.05, 12, 10900000, 1100000),
('PJN007', '2024-07-01', 'AGT007', 0.1, 24, 22800000, 1200000),
('PJN008', '2024-08-01', 'AGT008', 0.05, 6, 4000000, 800000),
('PJN009', '2024-09-01', 'AGT009', 0.1, 12, 5450000, 550000),
('PJN010', '2024-10-01', 'AGT010', 0.05, 24, 22900000, 1100000),
('PJN011', '2024-10-20', 'AGT047', 0.05, 12, 19000000, 1662500),
('PJN012', '2024-02-25', 'AGT023', 0.1, 24, 10000000, 458333),
('PJN013', '2025-02-03', 'AGT008', 0.05, 24, 3000000, 131250),
('PJN014', '2024-02-06', 'AGT003', 0.1, 6, 4000000, 733333),
('PJN015', '2025-06-12', 'AGT016', 0.1, 12, 17000000, 1558333),
('PJN016', '2024-12-23', 'AGT004', 0.05, 6, 17000000, 2975000),
('PJN017', '2025-05-10', 'AGT028', 0.05, 6, 5000000, 875000),
('PJN018', '2024-03-29', 'AGT001', 0.1, 24, 5000000, 229166),
('PJN019', '2025-03-20', 'AGT025', 0.1, 12, 12000000, 1100000),
('PJN020', '2024-05-05', 'AGT040', 0.05, 24, 16000000, 700000),
('PJN021', '2024-03-31', 'AGT022', 0.05, 24, 19000000, 831250),
('PJN022', '2024-05-30', 'AGT031', 0.05, 12, 2000000, 175000),
('PJN023', '2024-10-23', 'AGT032', 0.05, 6, 2000000, 350000),
('PJN024', '2025-05-04', 'AGT022', 0.1, 12, 11000000, 1008333),
('PJN025', '2024-07-13', 'AGT032', 0.05, 12, 19000000, 1662500),
('PJN026', '2024-12-29', 'AGT042', 0.05, 24, 9000000, 393750),
('PJN027', '2025-04-03', 'AGT043', 0.05, 12, 11000000, 962500),
('PJN028', '2024-05-27', 'AGT007', 0.05, 6, 18000000, 3150000),
('PJN029', '2024-04-14', 'AGT003', 0.05, 24, 15000000, 656250),
('PJN030', '2025-04-01', 'AGT044', 0.1, 24, 17000000, 779166);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_simpanan`
--

CREATE TABLE `tbl_simpanan` (
  `id_simpanan` varchar(6) NOT NULL,
  `tgl_simpanan` date NOT NULL,
  `id_anggota` varchar(6) NOT NULL,
  `jenis_simpanan` varchar(20) NOT NULL,
  `jumlah_simpanan` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_simpanan`
--

INSERT INTO `tbl_simpanan` (`id_simpanan`, `tgl_simpanan`, `id_anggota`, `jenis_simpanan`, `jumlah_simpanan`) VALUES
('SPN003', '2020-01-03', 'AGT002', 'Simpanan Wajib', 300000),
('SPN004', '2020-01-03', 'AGT002', 'Simpanan Pokok', 400000),
('SPN005', '2024-01-10', 'AGT001', 'Simpanan Pokok', 500000),
('SPN006', '2024-01-10', 'AGT001', 'Simpanan Wajib', 300000),
('SPN007', '2026-04-17', 'AGT003', 'Simpanan Pokok', 500000),
('SPN008', '2026-04-17', 'AGT003', 'Simpanan Wajib', 300000),
('SPN009', '2024-01-10', 'AGT004', 'Simpanan Pokok', 500000),
('SPN010', '2024-01-10', 'AGT004', 'Simpanan Wajib', 300000),
('SPN011', '2024-02-14', 'AGT005', 'Simpanan Pokok', 500000),
('SPN012', '2024-02-14', 'AGT005', 'Simpanan Wajib', 300000),
('SPN013', '2025-10-29', 'AGT004', 'Simpanan Wajib', 300000),
('SPN014', '2024-06-12', 'AGT013', 'Simpanan Wajib', 300000),
('SPN015', '2024-07-09', 'AGT044', 'Simpanan Pokok', 500000),
('SPN016', '2025-04-19', 'AGT011', 'Simpanan Wajib', 300000),
('SPN017', '2024-03-03', 'AGT035', 'Simpanan Pokok', 500000),
('SPN018', '2024-12-27', 'AGT050', 'Simpanan Pokok', 500000),
('SPN019', '2025-10-17', 'AGT011', 'Simpanan Wajib', 100000),
('SPN020', '2024-03-16', 'AGT028', 'Simpanan Pokok', 500000),
('SPN021', '2024-06-07', 'AGT006', 'Simpanan Pokok', 500000),
('SPN022', '2024-12-17', 'AGT033', 'Simpanan Pokok', 500000),
('SPN023', '2025-08-04', 'AGT039', 'Simpanan Wajib', 200000),
('SPN024', '2025-12-02', 'AGT031', 'Simpanan Wajib', 200000),
('SPN025', '2025-10-18', 'AGT003', 'Simpanan Pokok', 500000),
('SPN026', '2024-11-24', 'AGT047', 'Simpanan Pokok', 500000),
('SPN027', '2025-11-14', 'AGT022', 'Simpanan Pokok', 500000),
('SPN028', '2025-07-22', 'AGT036', 'Simpanan Pokok', 500000),
('SPN029', '2025-07-10', 'AGT023', 'Simpanan Pokok', 500000),
('SPN030', '2025-01-23', 'AGT008', 'Simpanan Pokok', 500000),
('SPN031', '2025-04-15', 'AGT043', 'Simpanan Pokok', 500000),
('SPN032', '2024-01-31', 'AGT004', 'Simpanan Pokok', 500000),
('SPN033', '2025-11-26', 'AGT027', 'Simpanan Wajib', 100000),
('SPN034', '2024-02-28', 'AGT048', 'Simpanan Wajib', 100000),
('SPN035', '2024-05-30', 'AGT038', 'Simpanan Pokok', 500000),
('SPN036', '2025-05-19', 'AGT003', 'Simpanan Wajib', 300000),
('SPN037', '2024-05-26', 'AGT023', 'Simpanan Pokok', 500000),
('SPN038', '2025-07-07', 'AGT033', 'Simpanan Wajib', 100000),
('SPN039', '2025-08-01', 'AGT031', 'Simpanan Wajib', 300000),
('SPN040', '2025-01-21', 'AGT012', 'Simpanan Pokok', 500000),
('SPN041', '2024-04-29', 'AGT018', 'Simpanan Wajib', 100000),
('SPN042', '2025-09-16', 'AGT015', 'Simpanan Wajib', 200000);

--
-- Triggers `tbl_simpanan`
--
DELIMITER $$
CREATE TRIGGER `hapus_saldo` AFTER DELETE ON `tbl_simpanan` FOR EACH ROW BEGIN
IF (old.jenis_simpanan = 'Simpanan Pokok') THEN
UPDATE tbl_tabungan SET saldo = saldo-old.jumlah_simpanan WHERE id_anggota=old.id_anggota;
ELSE
IF (old.jenis_simpanan = 'Simpanan Wajib') THEN
UPDATE tbl_tabungan SET saldo_wajib = saldo_wajib-old.jumlah_simpanan WHERE id_anggota=old.id_anggota;
END IF;
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tambah_saldo` AFTER INSERT ON `tbl_simpanan` FOR EACH ROW BEGIN
IF (NEW.jenis_simpanan = 'Simpanan Pokok') THEN
UPDATE tbl_tabungan SET saldo = saldo+NEW.jumlah_simpanan WHERE id_anggota=NEW.id_anggota;
ELSE
IF (NEW.jenis_simpanan = 'Simpanan Wajib') THEN
UPDATE tbl_tabungan SET saldo_wajib = saldo_wajib+NEW.jumlah_simpanan WHERE id_anggota=NEW.id_anggota;
END IF;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tabungan`
--

CREATE TABLE `tbl_tabungan` (
  `id_tabungan` varchar(6) NOT NULL,
  `id_anggota` varchar(6) NOT NULL,
  `saldo` int NOT NULL,
  `saldo_wajib` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tabungan`
--

INSERT INTO `tbl_tabungan` (`id_tabungan`, `id_anggota`, `saldo`, `saldo_wajib`) VALUES
('TBN001', 'AGT001', 350000, 300000),
('TBN002', 'AGT002', 200000, 300000),
('TBN003', 'AGT003', 200000, 300000),
('TBN004', 'AGT004', 250000, 300000),
('TBN005', 'AGT005', 350000, 300000),
('TBN006', 'AGT006', 0, 0),
('TBN007', 'AGT007', 0, 0),
('TBN008', 'AGT008', 0, 0),
('TBN009', 'AGT009', 0, 0),
('TBN010', 'AGT010', 0, 0),
('TBN011', 'AGT011', 500000, 100000),
('TBN012', 'AGT012', 0, 200000),
('TBN013', 'AGT013', 100000, 100000),
('TBN014', 'AGT014', 200000, 100000),
('TBN015', 'AGT015', 100000, 300000),
('TBN016', 'AGT016', 100000, 100000),
('TBN017', 'AGT017', 400000, 300000),
('TBN018', 'AGT018', 0, 200000),
('TBN019', 'AGT019', 100000, 100000),
('TBN020', 'AGT020', 0, 300000),
('TBN021', 'AGT021', 100000, 100000),
('TBN022', 'AGT022', 400000, 100000),
('TBN023', 'AGT023', 0, 100000),
('TBN024', 'AGT024', 200000, 100000),
('TBN025', 'AGT025', 0, 200000),
('TBN026', 'AGT026', 500000, 200000),
('TBN027', 'AGT027', 400000, 100000),
('TBN028', 'AGT028', 0, 300000),
('TBN029', 'AGT029', 200000, 100000),
('TBN030', 'AGT030', 500000, 100000),
('TBN031', 'AGT031', 0, 300000),
('TBN032', 'AGT032', 300000, 300000),
('TBN033', 'AGT033', 100000, 200000),
('TBN034', 'AGT034', 500000, 200000),
('TBN035', 'AGT035', 0, 300000),
('TBN036', 'AGT036', 400000, 300000),
('TBN037', 'AGT037', 200000, 100000),
('TBN038', 'AGT038', 0, 100000),
('TBN039', 'AGT039', 300000, 200000),
('TBN040', 'AGT040', 0, 300000),
('TBN041', 'AGT041', 500000, 100000),
('TBN042', 'AGT042', 0, 300000),
('TBN043', 'AGT043', 300000, 300000),
('TBN044', 'AGT044', 500000, 300000),
('TBN045', 'AGT045', 0, 200000),
('TBN046', 'AGT046', 100000, 100000),
('TBN047', 'AGT047', 0, 200000),
('TBN048', 'AGT048', 300000, 200000),
('TBN049', 'AGT049', 200000, 100000),
('TBN050', 'AGT050', 500000, 200000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`setting_key`, `setting_value`) VALUES
('nama_koperasi', 'Koperasi HIS'),
('alamat', 'Jl. HR. Rasuna Said'),
('telepon', '0851-7201-4471'),
('email', 'mahisduhan2003@gmail.com'),
('deskripsi', 'Sistem Informasi Manajemen Koperasi yang Modern, Transparan, dan Akuntabel. Kelola data anggota dan keuangan dengan lebih efisien.'),
('logo_path', ''),
('foto_hero', ''),
('syarat_anggota', 'Kewarganegaraan INDONESIA asli.\nKeanggotaan bersifat perorangan dan bukan dalam bentuk badan hukum.\nBersedia membayar Simpanan Pokok dan Simpanan Wajib sesuai ketentuan yang ditetapkan.\nMenyetujui Anggaran Dasar, Anggaran Rumah Tangga dan ketentuan yang berlaku dalam Koperasi.'),
('syarat_pinjaman', 'Berstatus aktif sebagai Anggota Koperasi.\nMengisi Formulir Pinjaman secara lengkap.\nMenyerahkan Fotocopy KTP (Suami & Istri bagi yang sudah menikah).\nMenyerahkan Fotocopy KK, Rekening Listrik, Slip Gaji, dan dokumen Agunan.\nMelengkapi Pengajuan Pinjaman dengan Proposal Tujuan Penggunaan Dana.'),
('cta_judul', 'Butuh Bantuan Administrasi?'),
('cta_deskripsi', 'Silakan hubungi tim pengurus atau buka modul data anggota untuk pengelolaan lebih lanjut.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_anggota`
--
ALTER TABLE `tbl_anggota`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indexes for table `tbl_login`
--
ALTER TABLE `tbl_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
  ADD PRIMARY KEY (`id_angsuran`);

--
-- Indexes for table `tbl_pengambilan`
--
ALTER TABLE `tbl_pengambilan`
  ADD PRIMARY KEY (`id_pengambilan`);

--
-- Indexes for table `tbl_pinjaman`
--
ALTER TABLE `tbl_pinjaman`
  ADD PRIMARY KEY (`id_pinjaman`);

--
-- Indexes for table `tbl_simpanan`
--
ALTER TABLE `tbl_simpanan`
  ADD PRIMARY KEY (`id_simpanan`);

--
-- Indexes for table `tbl_tabungan`
--
ALTER TABLE `tbl_tabungan`
  ADD PRIMARY KEY (`id_tabungan`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_login`
--
ALTER TABLE `tbl_login`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;