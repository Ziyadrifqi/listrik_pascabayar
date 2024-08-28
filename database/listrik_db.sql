-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2024 at 09:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `listrik_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `agen`
--

CREATE TABLE `agen` (
  `id_agen` varchar(12) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `saldo` double NOT NULL,
  `biaya_admin` double NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `akses` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `agen`
--

INSERT INTO `agen` (`id_agen`, `nama`, `alamat`, `no_telepon`, `saldo`, `biaya_admin`, `username`, `password`, `akses`) VALUES
('A20240727001', 'Rifqi Permana', 'Depok', '088225801565', 0, 2000, 'rifqi', 'zripe123', 'agen'),
('A20240727002', 'Muhammad Ramzi', 'Depok', '088225801789', 0, 2000, 'Ramzi', 'zidun123', 'agen'),
('A20240804001', 'Syakira amelia', 'Depok', '088225807256', 0, 2000, 'Syakira', 'syaki123', 'agen');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` varchar(14) NOT NULL,
  `no_meter` varchar(12) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `tenggang` varchar(2) NOT NULL,
  `id_tarif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `no_meter`, `nama`, `alamat`, `tenggang`, `id_tarif`) VALUES
('20180126081200', '025180150800', 'Yahyan', 'Sukamaju', '26', 4),
('20180126081257', '025180150857', 'Fadia', 'Raden Saleh', '26', 3),
('20180126081804', '025180150804', 'Roslina', 'haji Dimun', '26', 5),
('20180128141026', '027180171426', 'lailatul', 'Mandala', '28', 5),
('20180128141409', '027180171409', 'rosa', 'studio alam', '28', 4),
('20180129135850', '028180111350', 'rifqi ', 'haji dimun1', '29', 4),
('20180131085951', '030180130851', 'Fahri', 'Taman Manggis ', '31', 3),
('20240727142219', '209240761419', 'Muhammad Ramdu', 'Raden saleh', '27', 8),
('20240728162713', '210240771613', 'Permana', 'jatijajar', '28', 8),
('20240731150325', '213240731525', 'azka saputra', 'Taman manggis', '31', 8),
('20240806100958', '219240821058', 'anindita putri', 'depok', '06', 4);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` varchar(15) NOT NULL,
  `id_pelanggan` varchar(14) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `waktu_bayar` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `bulan_bayar` varchar(2) NOT NULL,
  `tahun_bayar` year(4) NOT NULL,
  `jumlah_bayar` double NOT NULL,
  `biaya_admin` double NOT NULL,
  `total_akhir` double NOT NULL,
  `bayar` double NOT NULL,
  `kembali` double NOT NULL,
  `id_agen` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pelanggan`, `tgl_bayar`, `waktu_bayar`, `bulan_bayar`, `tahun_bayar`, `jumlah_bayar`, `biaya_admin`, `total_akhir`, `bayar`, `kembali`, `id_agen`) VALUES
('', '', '0000-00-00', '2024-07-26 09:15:58', '', '0000', 0, 0, 0, 0, 0, ''),
('BYR201801260001', '20180126081200', '2018-01-26', '2018-01-26 08:07:41', '02', '2018', 15000, 2000, 17000, 20000, 3000, 'A20180125001'),
('BYR201801260002', '20180126081804', '2018-01-26', '2018-01-26 09:22:34', '02', '2018', 75000, 2000, 77000, 80000, 3000, 'A20180125001'),
('BYR201801260003', '20180126165945', '2018-01-26', '2018-01-26 10:04:01', '02', '2018', 150000, 2000, 152000, 160000, 8000, 'A20180125001'),
('BYR201801280001', '20180126081200', '2018-01-28', '2018-01-28 10:17:20', '03', '2018', 135000, 2000, 137000, 140000, 3000, 'A20180125001'),
('BYR201801280002', '20180126081200', '2018-01-28', '2018-01-28 10:18:52', '04', '2018', 1350000, 2000, 1352000, 1400000, 48000, 'A20180125001'),
('BYR201801290001', '20180129132711', '2018-01-29', '2018-01-29 06:29:58', '02', '2018', 140000, 2000, 142000, 150000, 8000, 'A20180125001'),
('BYR201801290002', '20180128141130', '2018-01-29', '2018-01-29 06:41:50', '02', '2018', 1500000, 2000, 1502000, 1510000, 8000, 'A20180125001'),
('BYR201801300001', '20180130165747', '2018-01-30', '2018-01-30 10:01:59', '02', '2018', 150000, 2000, 152000, 160000, 8000, 'A20180125001'),
('BYR201802010001', '20180128141026', '2018-02-01', '2018-02-01 01:33:50', '02', '2018', 75000, 2000, 77000, 80000, 3000, 'A20180125001'),
('BYR201802010002', '20180128141026', '2018-02-01', '2018-02-01 02:22:32', '03', '2018', 37500, 2000, 39500, 40000, 500, 'A20180125001'),
('BYR202407260001', '', '2024-07-26', '2024-07-26 12:45:15', '07', '2024', 84500, 2500, 0, 0, 0, ''),
('BYR202407270001', '20180128141026', '2024-07-27', '2024-07-27 09:40:47', '04', '2018', 37500, 2000, 39500, 50000, 10500, 'A20180125001'),
('BYR202407290001', '20180129135850', '2024-07-29', '2024-07-29 06:00:54', '03', '2018', 30000, 2000, 32000, 50000, 18000, 'A20180125001'),
('BYR202407310001', '20180129135850', '2024-07-31', '2024-07-31 08:06:44', '02', '2018', 75000, 2000, 77000, 100000, 23000, 'A20240727001'),
('BYR202408050001', '20240805142002', '2024-08-05', '2024-08-05 07:37:05', '8', '2024', 70000, 2000, 72000, 100000, 28000, 'A20240727001'),
('BYR202408060001', '20240728162713', '2024-08-06', '2024-08-06 03:15:06', '8', '2024', 180000, 2000, 182000, 200000, 18000, 'A20240727001');

-- --------------------------------------------------------

--
-- Table structure for table `penggunaan`
--

CREATE TABLE `penggunaan` (
  `id_penggunaan` varchar(20) NOT NULL,
  `id_pelanggan` varchar(14) NOT NULL,
  `bulan` varchar(2) NOT NULL,
  `tahun` year(4) NOT NULL,
  `meter_awal` int(11) NOT NULL,
  `meter_akhir` int(11) NOT NULL,
  `tgl_cek` date NOT NULL,
  `id_petugas` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `penggunaan`
--

INSERT INTO `penggunaan` (`id_penggunaan`, `id_pelanggan`, `bulan`, `tahun`, `meter_awal`, `meter_akhir`, `tgl_cek`, `id_petugas`) VALUES
('20180126081200022018', '20180126081200', '02', '2018', 0, 10, '2018-02-23', 'P20180125001'),
('20180126081200032018', '20180126081200', '03', '2018', 10, 100, '2018-02-26', 'P20180125001'),
('20180126081200042018', '20180126081200', '04', '2018', 100, 1000, '2018-04-26', 'P20180125001'),
('20180126081200052018', '20180126081200', '05', '2018', 1000, 0, '0000-00-00', ''),
('20180126081257022018', '20180126081257', '02', '2018', 0, 80, '2018-02-26', 'P20180125001'),
('20180126081257032018', '20180126081257', '03', '2018', 80, 0, '0000-00-00', ''),
('20180126081804022018', '20180126081804', '02', '2018', 0, 100, '2018-02-26', 'P20180125001'),
('20180126081804032018', '20180126081804', '03', '2018', 100, 0, '0000-00-00', ''),
('20180126165945022018', '20180126165945', '02', '2018', 0, 100, '2018-02-26', 'P20180125001'),
('20180126165945032018', '20180126165945', '03', '2018', 100, 22222, '2024-07-27', 'P20180125001'),
('20180126165945042018', '20180126165945', '04', '2018', 22222, 200000, '2024-07-12', 'P20180125001'),
('20180126165945052018', '20180126165945', '05', '2018', 200000, 0, '0000-00-00', ''),
('20180128141026022018', '20180128141026', '02', '2018', 0, 100, '2018-02-01', 'P20180125001'),
('20180128141026032018', '20180128141026', '03', '2018', 100, 150, '2018-03-01', 'P20180125001'),
('20180128141026042018', '20180128141026', '04', '2018', 150, 250, '2024-07-27', 'P20180125001'),
('20180128141026052018', '20180128141026', '05', '2018', 200, 250, '2024-07-27', 'P20180125001'),
('20180128141049032018', '20180128141049', '03', '2018', 1000, 20000, '2024-07-16', 'P20180125001'),
('20180128141049042018', '20180128141049', '04', '2018', 20000, 0, '0000-00-00', ''),
('20180128141130032018', '20180128141130', '03', '2018', 1000, 2000, '2018-01-01', 'P20180125001'),
('20180128141130042018', '20180128141130', '04', '2018', 2000, 0, '0000-00-00', ''),
('20180128141409022018', '20180128141409', '02', '2018', 0, 100, '2024-07-27', 'P20180125001'),
('20180128141409032018', '20180128141409', '03', '2018', 100, 120, '2024-08-05', 'P20180129001'),
('20180128141409042018', '20180128141409', '04', '2018', 120, 0, '0000-00-00', ''),
('20180129132711022018', '20180129132711', '02', '2018', 0, 100, '2018-01-29', 'P20180125001'),
('20180129132711032018', '20180129132711', '03', '2018', 100, 0, '0000-00-00', ''),
('20180129135850022018', '20180129135850', '02', '2018', 0, 50, '2018-02-25', 'P20180125001'),
('20180129135850032018', '20180129135850', '03', '2018', 50, 70, '2018-03-25', 'P20180125001'),
('20180129135850042018', '20180129135850', '04', '2018', 70, 120, '2024-07-31', 'P20180125001'),
('20180129135850052018', '20180129135850', '05', '2018', 120, 0, '0000-00-00', ''),
('20180130165747022018', '20180130165747', '02', '2018', 0, 100, '2018-02-21', 'P20180125001'),
('20180130165747032018', '20180130165747', '03', '2018', 100, 0, '0000-00-00', ''),
('20180131085951022018', '20180131085951', '02', '2018', 0, 100, '2018-02-21', 'P20180125001'),
('20180131085951032018', '20180131085951', '03', '2018', 100, 0, '0000-00-00', ''),
('20180131085951042018', '20180131085951', '04', '2018', 120, 0, '0000-00-00', ''),
('20180131085951052018', '20180131085951', '05', '2018', 200, 0, '0000-00-00', ''),
('20180201075546022018', '20180201075546', '02', '2018', 0, 0, '0000-00-00', ''),
('20180201092427022018', '20180201092427', '02', '2018', 0, 100, '2018-02-21', 'P20180125001'),
('20180201092427032018', '20180201092427', '03', '2018', 100, 0, '0000-00-00', ''),
('20240727114434082024', '20240727114434', '8', '2024', 0, 0, '0000-00-00', ''),
('20240727115300082024', '20240727115300', '8', '2024', 0, 0, '0000-00-00', ''),
('20240727115611082024', '20240727115611', '8', '2024', 0, 0, '0000-00-00', ''),
('20240727115625082024', '20240727115625', '08', '2024', 0, 0, '0000-00-00', ''),
('20240727120846082024', '20240727120846', '8', '2024', 0, 0, '0000-00-00', ''),
('20240727122501082024', '20240727122501', '8', '2024', 0, 0, '0000-00-00', ''),
('20240727125944082024', '20240727125944', '8', '2024', 0, 0, '0000-00-00', ''),
('20240727130313082024', '20240727130313', '8', '2024', 0, 0, '0000-00-00', ''),
('20240727130344082024', '20240727130344', '8', '2024', 0, 0, '0000-00-00', ''),
('20240727130409082024', '20240727130409', '8', '2024', 0, 0, '0000-00-00', ''),
('20240727130430082024', '20240727130430', '8', '2024', 0, 0, '0000-00-00', ''),
('20240727130557082024', '20240727130557', '8', '2024', 0, 0, '0000-00-00', ''),
('20240727130855082024', '20240727130855', '8', '2024', 0, 0, '0000-00-00', ''),
('20240727133943082024', '20240727133943', '8', '2024', 0, 0, '0000-00-00', ''),
('20240727134424082024', '20240727134424', '8', '2024', 0, 0, '0000-00-00', ''),
('20240727135234082024', '20240727135234', '8', '2024', 0, 0, '0000-00-00', ''),
('20240727135350082024', '20240727135350', '08', '2024', 0, 0, '0000-00-00', ''),
('20240727135457082024', '20240727135457', '08', '2024', 0, 0, '0000-00-00', ''),
('20240727140533082024', '20240727140533', '08', '2024', 0, 0, '0000-00-00', ''),
('20240727142219082024', '20240727142219', '08', '2024', 0, 200, '2024-07-27', 'P20180125001'),
('20240727142219092024', '20240727142219', '09', '2024', 200, 0, '0000-00-00', ''),
('20240728162713082024', '20240728162713', '08', '2024', 0, 120, '2024-07-28', 'P20180125001'),
('20240728162713092024', '20240728162713', '09', '2024', 120, 0, '0000-00-00', ''),
('20240731150325082024', '20240731150325', '08', '2024', 0, 0, '0000-00-00', ''),
('20240805141520082024', '20240805141520', '08', '2024', 0, 0, '0000-00-00', ''),
('20240805142002082024', '20240805142002', '08', '2024', 0, 50, '2024-08-05', 'P20180129001'),
('20240805142002092024', '20240805142002', '09', '2024', 50, 0, '0000-00-00', ''),
('20240806100958082024', '20240806100958', '08', '2024', 0, 0, '0000-00-00', ''),
('87de76f9-0585-41ba-a', '20240727115625', '08', '2024', 0, 0, '0000-00-00', ''),
('af7f1108-ce15-4e9c-9', '20240727115625', '08', '2024', 0, 0, '0000-00-00', ''),
('b9158406-0b19-43ef-a', '20240727115625', '08', '2024', 0, 0, '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` varchar(12) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `jk` varchar(1) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `akses` varchar(20) NOT NULL,
  `email` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nama`, `alamat`, `no_telepon`, `jk`, `username`, `password`, `akses`, `email`) VALUES
('P20180125001', 'Ahmad Syahroni', 'depok', '083811941421', 'L', 'petugas', 'petugas123', 'petugas', 'ahmad123@gmail.com'),
('P20180129001', 'ZiyadRifqi Permana', 'depok', '088225801565', 'L', 'ziyad', 'aku123', 'petugas', 'ziyad@gmail.com'),
('P20240727001', 'Raihan Prayoga', 'Depok', '088225801565', 'L', '17210746', 'ziyad123', 'petugas', 'raihan@gmail.com');

-- --------------------------------------------------------

--
-- Stand-in structure for view `qw_pembayaran`
-- (See below for the actual view)
--
CREATE TABLE `qw_pembayaran` (
`id_pembayaran` varchar(15)
,`id_pelanggan` varchar(14)
,`tgl_bayar` date
,`waktu_bayar` timestamp
,`bulan_bayar` varchar(2)
,`tahun_bayar` year(4)
,`jumlah_bayar` double
,`biaya_admin` double
,`total_akhir` double
,`bayar` double
,`kembali` double
,`id_agen` varchar(12)
,`nama_pelanggan` varchar(50)
,`nama_agen` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `qw_penggunaan`
-- (See below for the actual view)
--
CREATE TABLE `qw_penggunaan` (
`id_penggunaan` varchar(20)
,`id_pelanggan` varchar(14)
,`bulan` varchar(2)
,`tahun` year(4)
,`meter_awal` int(11)
,`meter_akhir` int(11)
,`tgl_cek` date
,`id_petugas` varchar(12)
,`nama_pelanggan` varchar(50)
,`nama_petugas` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `qw_tagihan`
-- (See below for the actual view)
--
CREATE TABLE `qw_tagihan` (
`id_tagihan` int(11)
,`id_pelanggan` varchar(14)
,`bulan` varchar(2)
,`tahun` year(4)
,`jumlah_meter` int(11)
,`tarif_perkwh` double
,`jumlah_bayar` double
,`status` varchar(15)
,`id_petugas` varchar(12)
,`nama_pelanggan` varchar(50)
,`id_tarif` int(11)
,`nama_petugas` varchar(50)
);

-- --------------------------------------------------------

--
-- Table structure for table `tagihan`
--

CREATE TABLE `tagihan` (
  `id_tagihan` int(11) NOT NULL,
  `id_pelanggan` varchar(14) NOT NULL,
  `bulan` varchar(2) NOT NULL,
  `tahun` year(4) NOT NULL,
  `jumlah_meter` int(11) NOT NULL,
  `tarif_perkwh` double NOT NULL,
  `jumlah_bayar` double NOT NULL,
  `status` varchar(15) NOT NULL,
  `id_petugas` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tagihan`
--

INSERT INTO `tagihan` (`id_tagihan`, `id_pelanggan`, `bulan`, `tahun`, `jumlah_meter`, `tarif_perkwh`, `jumlah_bayar`, `status`, `id_petugas`) VALUES
(5, '20180126081200', '02', '2018', 10, 1500, 15000, 'Terbayar', 'P20180125001'),
(6, '20180126081200', '03', '2018', 90, 1500, 135000, 'Terbayar', 'P20180125001'),
(7, '20180126081804', '02', '2018', 100, 750, 75000, 'Terbayar', 'P20180125001'),
(8, '20180126165945', '02', '2018', 100, 1500, 150000, 'Terbayar', 'P20180125001'),
(9, '20180126081257', '02', '2018', 80, 1000, 80000, 'Terbayar', 'P20180125001'),
(10, '20180126081200', '04', '2018', 900, 1500, 1350000, 'Terbayar', 'P20180125001'),
(11, '20180129132711', '02', '2018', 100, 1400, 140000, 'Terbayar', 'P20180125001'),
(12, '20180128141130', '02', '2018', 1000, 1500, 1500000, 'Terbayar', 'P20180125001'),
(13, '20180128141130', '03', '2018', 1000, 1500, 1500000, 'Belum Bayar', 'P20180125001'),
(14, '20180129135850', '02', '2018', 50, 1500, 75000, 'Terbayar', 'P20180125001'),
(15, '20180129135850', '03', '2018', 20, 1500, 30000, 'Terbayar', 'P20180125001'),
(16, '20180128141026', '02', '2018', 100, 750, 75000, 'Terbayar', 'P20180125001'),
(17, '20180128141026', '03', '2018', 50, 750, 37500, 'Terbayar', 'P20180125001'),
(18, '20180128141026', '04', '2018', 50, 750, 37500, 'Terbayar', 'P20180125001'),
(19, '20180130165747', '02', '2018', 100, 1500, 150000, 'Terbayar', 'P20180125001'),
(20, '20180131085951', '02', '2018', 100, 1000, 100000, 'Belum Bayar', 'P20180125001'),
(21, '20180131085951', '03', '2018', 20, 1000, 20000, 'Belum Bayar', 'P20180125001'),
(22, '20180131085951', '04', '2018', 80, 1000, 80000, 'Belum Bayar', 'P20180125001'),
(24, '20180201092427', '02', '2018', 100, 1000, 100000, 'Belum Bayar', 'P20180125001'),
(25, '20180126165945', '3', '2018', 22122, 1500, 33183000, 'Belum Bayar', 'P20180125001'),
(26, '20180126165945', '4', '2018', 177778, 1500, 266667000, 'Belum Bayar', 'P20180125001'),
(27, '20180128141049', '2', '2018', 1000, 1500, 1500000, 'Belum Bayar', 'P20180125001'),
(28, '20180128141049', '3', '2018', 19000, 1500, 28500000, 'Belum Bayar', 'P20180125001'),
(29, '20240727142219', '8', '2024', 200, 1500, 300000, 'Belum Bayar', 'P20180125001'),
(30, '20180128141026', '4', '2018', 100, 750, 75000, 'Belum Bayar', 'P20180125001'),
(31, '20180128141026', '5', '2018', 50, 750, 37500, 'Belum Bayar', 'P20180125001'),
(32, '20180128141409', '2', '2018', 100, 1500, 150000, 'Belum Bayar', 'P20180125001'),
(33, '20240728162713', '8', '2024', 120, 1500, 180000, 'Terbayar', 'P20180125001'),
(34, '20180129135850', '4', '2018', 50, 1500, 75000, 'Belum Bayar', 'P20180125001'),
(35, '20180128141409', '3', '2018', 20, 1500, 30000, 'Belum Bayar', 'P20180129001'),
(36, '20240805142002', '8', '2024', 50, 1400, 70000, 'Terbayar', 'P20180129001');

-- --------------------------------------------------------

--
-- Table structure for table `tarif`
--

CREATE TABLE `tarif` (
  `id_tarif` int(11) NOT NULL,
  `kode_tarif` varchar(20) NOT NULL,
  `golongan` varchar(10) NOT NULL,
  `daya` varchar(10) NOT NULL,
  `tarif_perkwh` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tarif`
--

INSERT INTO `tarif` (`id_tarif`, `kode_tarif`, `golongan`, `daya`, `tarif_perkwh`) VALUES
(3, 'R3/450VA', 'R3', '450VA', 1000),
(4, 'R1/900VA', 'R1', '900VA', 1500),
(5, 'R2/450VA', 'R2', '450VA', 750),
(8, 'R2/900VA', 'R2', '900VA', 1500),
(9, 'B1/1500VA', 'B1', '1500VA', 2000),
(10, 'R3/900VA', 'R3', '900VA', 1400),
(16, 'R3/1300VA', 'R3', '1300VA', 1500),
(17, 'R1/450VA', 'R1', '450VA', 1000);

-- --------------------------------------------------------

--
-- Structure for view `qw_pembayaran`
--
DROP TABLE IF EXISTS `qw_pembayaran`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `qw_pembayaran`  AS SELECT `pembayaran`.`id_pembayaran` AS `id_pembayaran`, `pembayaran`.`id_pelanggan` AS `id_pelanggan`, `pembayaran`.`tgl_bayar` AS `tgl_bayar`, `pembayaran`.`waktu_bayar` AS `waktu_bayar`, `pembayaran`.`bulan_bayar` AS `bulan_bayar`, `pembayaran`.`tahun_bayar` AS `tahun_bayar`, `pembayaran`.`jumlah_bayar` AS `jumlah_bayar`, `pembayaran`.`biaya_admin` AS `biaya_admin`, `pembayaran`.`total_akhir` AS `total_akhir`, `pembayaran`.`bayar` AS `bayar`, `pembayaran`.`kembali` AS `kembali`, `pembayaran`.`id_agen` AS `id_agen`, `pelanggan`.`nama` AS `nama_pelanggan`, `agen`.`nama` AS `nama_agen` FROM ((`pembayaran` join `pelanggan` on(`pelanggan`.`id_pelanggan` = `pembayaran`.`id_pelanggan`)) join `agen` on(`agen`.`id_agen` = `pembayaran`.`id_agen`)) ;

-- --------------------------------------------------------

--
-- Structure for view `qw_penggunaan`
--
DROP TABLE IF EXISTS `qw_penggunaan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `qw_penggunaan`  AS SELECT `penggunaan`.`id_penggunaan` AS `id_penggunaan`, `penggunaan`.`id_pelanggan` AS `id_pelanggan`, `penggunaan`.`bulan` AS `bulan`, `penggunaan`.`tahun` AS `tahun`, `penggunaan`.`meter_awal` AS `meter_awal`, `penggunaan`.`meter_akhir` AS `meter_akhir`, `penggunaan`.`tgl_cek` AS `tgl_cek`, `penggunaan`.`id_petugas` AS `id_petugas`, `pelanggan`.`nama` AS `nama_pelanggan`, `petugas`.`nama` AS `nama_petugas` FROM ((`penggunaan` join `pelanggan` on(`penggunaan`.`id_pelanggan` = `pelanggan`.`id_pelanggan`)) join `petugas` on(`penggunaan`.`id_petugas` = `petugas`.`id_petugas`)) ;

-- --------------------------------------------------------

--
-- Structure for view `qw_tagihan`
--
DROP TABLE IF EXISTS `qw_tagihan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `qw_tagihan`  AS SELECT `tagihan`.`id_tagihan` AS `id_tagihan`, `tagihan`.`id_pelanggan` AS `id_pelanggan`, `tagihan`.`bulan` AS `bulan`, `tagihan`.`tahun` AS `tahun`, `tagihan`.`jumlah_meter` AS `jumlah_meter`, `tagihan`.`tarif_perkwh` AS `tarif_perkwh`, `tagihan`.`jumlah_bayar` AS `jumlah_bayar`, `tagihan`.`status` AS `status`, `tagihan`.`id_petugas` AS `id_petugas`, `pelanggan`.`nama` AS `nama_pelanggan`, `pelanggan`.`id_tarif` AS `id_tarif`, `petugas`.`nama` AS `nama_petugas` FROM ((`tagihan` join `pelanggan` on(`pelanggan`.`id_pelanggan` = `tagihan`.`id_pelanggan`)) join `petugas` on(`petugas`.`id_petugas` = `tagihan`.`id_petugas`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agen`
--
ALTER TABLE `agen`
  ADD PRIMARY KEY (`id_agen`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indexes for table `penggunaan`
--
ALTER TABLE `penggunaan`
  ADD PRIMARY KEY (`id_penggunaan`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indexes for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id_tagihan`);

--
-- Indexes for table `tarif`
--
ALTER TABLE `tarif`
  ADD PRIMARY KEY (`id_tarif`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tagihan`
--
ALTER TABLE `tagihan`
  MODIFY `id_tagihan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tarif`
--
ALTER TABLE `tarif`
  MODIFY `id_tarif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
