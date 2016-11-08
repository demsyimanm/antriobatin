-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2016 at 05:39 PM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `antriobatin`
--

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `illness` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `doctor_id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `user_id`, `illness`, `year`, `doctor_id`, `description`, `created_at`, `updated_at`) VALUES
(1, 2, 'batuk berdahak', '2017', 3, 'sada\r\nas\r\nasda"\r\ndemsy', '2016-11-04 07:25:07', '2016-11-04 00:35:53');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activity` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(11, '2014_10_12_000000_create_users_table', 1),
(12, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2016-11-03 10:08:19', '2016-11-03 10:08:19'),
(2, 'Pasien', '2016-11-03 10:08:19', '2016-11-03 10:08:19'),
(3, 'Dokter', '2016-11-03 10:08:19', '2016-11-03 10:08:19'),
(4, 'Apotek', '2016-11-03 10:08:19', '2016-11-03 10:08:19'),
(5, 'Dinas Kesehatan', '2016-11-03 10:08:19', '2016-11-03 10:08:19');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Dikirim ke Apotek', '2016-11-03 10:08:19', '2016-11-03 10:08:19'),
(2, 'Diterima Apotek', '2016-11-03 10:08:19', '2016-11-03 10:08:19'),
(3, 'Sedang dalam proses peracikan obat', '2016-11-03 10:08:19', '2016-11-03 10:08:19'),
(4, 'Obat sudah bisa diambil', '2016-11-03 10:08:19', '2016-11-03 10:08:19'),
(5, 'Obat telah diambil', '2016-11-03 10:08:19', '2016-11-03 10:08:19');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `drugstore_id` int(11) NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cost` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `duration` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `user_id`, `doctor_id`, `drugstore_id`, `photo`, `cost`, `message`, `duration`, `status_id`, `created_at`, `updated_at`) VALUES
(1, 2, 3, 4, 'resep/13032_1.png', '20.000', 'semangat pak lek 2', '3 jam', 5, NULL, '2016-11-04 03:12:14');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `barcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `telp`, `nip`, `barcode`, `address`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin@gmail.com', '$2y$10$IWq5Cv.tZvFwn6m8HgxWz.cQNYhubOnDT3A1ae5eyAgnL5er9Z2uG', 'Admin', '085607227007', '5113100081', '', 'Teknik Informatika ITS', 1, '2hBzCZKGKJHugpAagiBueSYYIcnUQSPkoqYOHzu1zBMrWTEX3H7vqJCmKMty', NULL, '2016-11-03 20:17:16'),
(2, 'pasien@gmail.com', '$2y$10$EiynoIlNQnvWd40/P3O/qeauai24UW1TWCuph9yLhAsmwv/lIB6Hm', 'Pasien', '085607227007', '5113100046', '', 'Keputih', 2, 'V6F5MW3IpfFtYLluuaMbZVhpBXLeSU5JBePEKlI5rWpxfyBghM2o1pOQH52Y', NULL, '2016-11-07 21:44:02'),
(3, 'dokter@gmail.com', '$2y$10$tG/CYWjArh8ZV4NKO.0PmOsIR.s3fwB6OzA2FPVuYBluAMAq66fBy', 'Dokter', '085607227007', '5113100015', '', 'Wisma Permai Gg 3 no 3', 3, 'Z4Iewt8aNOoVI1GZPaCOYRCWaj9wS0cZgxO4yWhX4SgiSVGH3DfC6Xur77I1', NULL, '2016-11-07 07:49:22'),
(4, 'apotek@gmail.com', '$2y$10$7/hHurnTkZgGOSIrgGq5Me9Ga.PuW7xJsAmB8p1yg6bTdiLgkTAgy', 'Apotek', '085607227007', '5113100300', '', 'Apotek Keputih Sukolilo', 4, 'PJcG5HrGtEbEF12KzNCz4ox6oMjtAaR4fOixKh09svKY3lfA3DAZK8FToPjq', NULL, '2016-11-07 21:17:06'),
(5, 'dinas@gmail.com', '$2y$10$o4VvlW9p2mKUoQJv992syuq2rVILjpXfx7sCI5wWnNlK/uaIwUPLG', 'Dinas Kesehatan', '085607227007', '5113100081', '', 'Dinas Kesehatan Surabaya', 5, NULL, NULL, NULL),
(6, 'demsy@gmail.com', '$2y$10$dwLL2a0p4dVtYWI3kkOTKeUUvfHKdp1.JwsDrhlQsD1.kuJCgGRAe', 'demsy iman mustasyar', '085607227007', '5113100015', '', 'wisper', 3, NULL, '2016-11-04 10:31:25', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
