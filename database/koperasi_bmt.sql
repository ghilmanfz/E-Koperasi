-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 01, 2026 at 07:59 AM
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
('AGT010', '7371012504850010', 'Hendra Wijaya', 'Makassar', '1985-04-25', 'Laki-laki', 'Makassar', 'Dokter', 'Menikah', '2024-07-08', 'Pending');

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
(12, 'AGT007', 'eka', 'eka123', 'anggota');

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
('AGN010', 'PJN010', 1, 1100000, '2024-11-01');

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
('PGN011', '2025-04-10', 'AGT005', 50000);

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
('PJN010', '2024-10-01', 'AGT010', 0.05, 24, 22900000, 1100000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`setting_key`, `setting_value`) VALUES
('alamat', 'Jl. HR. Rasuna Said'),
('cta_deskripsi', 'Silakan hubungi tim pengurus.'),
('cta_judul', 'Butuh Bantuan Administrasi?'),
('deskripsi', 'Sistem Informasi Manajemen Koperasi yang Modern, Transparan, dan Akuntabel.'),
('email', 'mahisduhan2003@gmail.com'),
('foto_hero', 'assets/uploads/hero_1777428519.jpg'),
('logo_path', 'assets/uploads/logo_1777428519.jpg'),
('nama_koperasi', 'Koperasi HIS'),
('syarat_anggota', 'Kewarganegaraan INDONESIA.\r\nKeanggotaan bersifat perorangan dan bukan dalam bentuk badan hukum.\r\nBersedia membayar Simpanan Pokok dan Simpanan Wajib sesuai ketentuan.\r\nMenyetujui Anggaran Dasar (AD) dan Anggaran Rumah Tangga (ART).\r\nMematuhi segala ketentuan yang berlaku dalam Koperasi.'),
('syarat_pinjaman', 'Berstatus sebagai Anggota PKK aktif.\r\nMengisi Formulir Pengajuan Pinjaman dengan lengkap.\r\nMenyerahkan Fotocopy KTP (Suami & Istri jika sudah menikah).\r\nMenyerahkan Fotocopy Kartu Keluarga (KK).\r\nMenyerahkan Fotocopy Rekening Listrik terbaru.\r\nMenyerahkan Slip Gaji (jika ada) dan Agunan yang sah.'),
('telepon', '0851-7201-4471');

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
('SPN012', '2024-02-14', 'AGT005', 'Simpanan Wajib', 300000);

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
('TBN010', 'AGT010', 0, 0);

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
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`setting_key`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_login`
--
ALTER TABLE `tbl_login`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
