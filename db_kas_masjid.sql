-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2020 at 05:59 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kas_masjid`
--

-- --------------------------------------------------------

--
-- Table structure for table `coba`
--

CREATE TABLE `coba` (
  `id_coba` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coba`
--

INSERT INTO `coba` (`id_coba`, `nama`) VALUES
(2, '1'),
(3, '2'),
(4, '3'),
(5, '4'),
(6, '5'),
(7, '345'),
(8, '345'),
(9, '56'),
(10, '546'),
(11, '534'),
(12, '5345'),
(13, '5345');

-- --------------------------------------------------------

--
-- Table structure for table `kas_masjid`
--

CREATE TABLE `kas_masjid` (
  `id_km` int(11) NOT NULL,
  `tgl_km` date NOT NULL,
  `uraian_km` varchar(200) NOT NULL,
  `masuk` int(11) NOT NULL,
  `keluar` int(11) NOT NULL,
  `jenis` enum('Masuk','Keluar') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kas_masjid`
--

INSERT INTO `kas_masjid` (`id_km`, `tgl_km`, `uraian_km`, `masuk`, `keluar`, `jenis`) VALUES
(31, '2020-05-23', 'sedekah hamba Allah', 500000, 0, 'Masuk'),
(32, '2020-05-22', 'inpaq pulan bin pulan', 1000000, 0, 'Masuk'),
(33, '2020-05-23', 'pembelian karpet', 0, 500000, 'Keluar'),
(34, '2020-05-23', 'cuci karpet', 0, 100000, 'Keluar'),
(35, '2020-06-05', 'sedekah hamba Allah', 200000, 0, 'Masuk'),
(36, '2020-06-05', 'kotak amal jumat tgl 05', 350000, 0, 'Masuk'),
(37, '2020-06-05', 'beli sejadah', 0, 400000, 'Keluar'),
(38, '2020-06-16', 'Infaq mesjid', 200000, 0, 'Masuk'),
(39, '2020-06-06', 'dsad', 100000, 0, 'Masuk'),
(40, '2020-06-23', 'infaq dari ramdan', 100000, 0, 'Masuk'),
(41, '2020-06-23', 'Infaq mesjid', 100000, 0, 'Masuk'),
(42, '2020-06-23', 'beli makan', 0, 500000, 'Keluar');

-- --------------------------------------------------------

--
-- Table structure for table `kas_sosial`
--

CREATE TABLE `kas_sosial` (
  `id_ks` int(11) NOT NULL,
  `tgl_ks` date NOT NULL,
  `uraian_ks` varchar(200) NOT NULL,
  `masuk` int(11) NOT NULL,
  `keluar` int(11) NOT NULL,
  `jenis` enum('Masuk','Keluar') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kas_sosial`
--

INSERT INTO `kas_sosial` (`id_ks`, `tgl_ks`, `uraian_ks`, `masuk`, `keluar`, `jenis`) VALUES
(3, '2020-03-24', 'bantu banjir', 0, 150000, 'Keluar'),
(5, '2020-03-20', 'Hamba Alloh', 1000000, 0, 'Masuk'),
(6, '2020-03-01', 'tes tanpa internet', 200000, 0, 'Masuk'),
(7, '2020-03-27', 'tes 123', 0, 10000, 'Keluar'),
(8, '2020-03-23', 'regek sos', 120000, 0, 'Masuk'),
(9, '2020-03-02', 'metu rg', 0, 15000, 'Keluar'),
(10, '2020-03-15', 'tes lg', 230000, 0, 'Masuk');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_username` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `kota` varchar(100) NOT NULL,
  `provinsi` varchar(100) NOT NULL,
  `telepon` varchar(100) NOT NULL,
  `id_level` enum('1','2') NOT NULL,
  `is_aktive` enum('1','2') NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_username`, `username`, `password`, `nama`, `email`, `alamat`, `kota`, `provinsi`, `telepon`, `id_level`, `is_aktive`, `create_date`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin Aplikasi', 'admin@kangramdan.com', 'Jln Dewi Sartika', 'Bekasi', 'Jawa Barat', '083874731480', '1', '1', '2020-05-22 16:40:14'),
(4, 'ramdan', '889752dcb81b4ad98ad6e36e9db2cd43', 'ramdan', 'genz9090@gmail.com', 'Jln Dewi Sartika', 'Bekasi', 'Jawa Barat', '083874731480', '2', '1', '2020-05-23 02:24:33'),
(5, 'alim123', '5de9bd14b133563257032b665b0d77df', 'alim', 'saepulramdan244@gmail.com', '', '', '', '', '2', '1', '2020-06-05 18:11:08');

-- --------------------------------------------------------

--
-- Table structure for table `user_level`
--

CREATE TABLE `user_level` (
  `id_level` int(2) NOT NULL,
  `nama_user_level` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_level`
--

INSERT INTO `user_level` (`id_level`, `nama_user_level`) VALUES
(1, 'Admin'),
(2, 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coba`
--
ALTER TABLE `coba`
  ADD PRIMARY KEY (`id_coba`);

--
-- Indexes for table `kas_masjid`
--
ALTER TABLE `kas_masjid`
  ADD PRIMARY KEY (`id_km`);

--
-- Indexes for table `kas_sosial`
--
ALTER TABLE `kas_sosial`
  ADD PRIMARY KEY (`id_ks`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_username`);

--
-- Indexes for table `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`id_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coba`
--
ALTER TABLE `coba`
  MODIFY `id_coba` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `kas_masjid`
--
ALTER TABLE `kas_masjid`
  MODIFY `id_km` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `kas_sosial`
--
ALTER TABLE `kas_sosial`
  MODIFY `id_ks` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_username` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_level`
--
ALTER TABLE `user_level`
  MODIFY `id_level` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
