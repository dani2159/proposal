-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 26, 2022 at 04:42 PM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pengajuan_ormawa`
--

-- --------------------------------------------------------

--
-- Table structure for table `ormawa`
--

CREATE TABLE `ormawa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ketua` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ormawa`
--

INSERT INTO `ormawa` (`id`, `nama`, `ketua`, `keterangan`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'HMTI', 'Bahrun', 'HMTI', 0, '2022-08-25 05:34:01', '2022-08-25 05:34:01'),
(2, 'Rumahku', 'Asep Ahmad Alwi', 'Himpunan Mahasiswa Akuntansi', 0, '2022-08-26 08:02:50', '2022-08-26 09:04:54');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_ormawa`
--

CREATE TABLE `pengajuan_ormawa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_ormawa` bigint(20) UNSIGNED NOT NULL,
  `nama_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tema_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_kegiatan` datetime NOT NULL,
  `total_dana` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `note_reject` text COLLATE utf8mb4_unicode_ci,
  `lampiran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lampiran_lpj` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_parent` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengajuan_ormawa`
--

INSERT INTO `pengajuan_ormawa` (`id`, `id_ormawa`, `nama_kegiatan`, `jenis_kegiatan`, `tema_kegiatan`, `tanggal_kegiatan`, `total_dana`, `status`, `note_reject`, `lampiran`, `lampiran_lpj`, `id_parent`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 2, 'asddasq2', 'wqeqw', 'asaddasdas', '2022-08-26 22:05:00', '750000', 2, 'rubah tema', '1661526335.pdf', NULL, NULL, 0, 0, '2022-08-26 08:05:35', '2022-08-26 08:11:19'),
(2, 2, 'asddasq2', 'wqeqw', 'gdhasgd11', '2022-08-26 22:05:00', '750000', 1, NULL, '1661526335.pdf', '1661526743.pdf', 1, 1, 0, '2022-08-26 08:11:19', '2022-08-26 08:12:23'),
(3, 2, 'rapat umum', 'mubes', 'bersenergi semangat', '2022-08-26 22:46:00', '2000000', 2, 'dana terlalu besar, mohon di sesuaikan', '1661528838.pdf', NULL, NULL, 0, 0, '2022-08-26 08:47:18', '2022-08-26 08:54:21'),
(4, 2, 'rapat umum', 'mubes', 'bersenergi semangat', '2022-08-26 22:46:00', '20000', 2, 'dokumen mohon di sesuaikan', '1661528838.pdf', NULL, 3, 0, 0, '2022-08-26 08:54:21', '2022-08-26 08:56:26'),
(5, 2, 'rapat umum', 'mubes', 'bersenergi semangat', '2022-08-26 22:46:00', '20000', 1, NULL, '1661529386.pdf', '1661529594.pdf', 3, 1, 0, '2022-08-26 08:56:26', '2022-08-26 08:59:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mahasiswa',
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_ormawa` bigint(20) UNSIGNED DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `level`, `username`, `id_ormawa`, `password`, `remember_token`, `is_deleted`, `created_at`, `updated_at`) VALUES
(8, 'HMTI', 'ormawa', 'HMTI', 1, '$2y$10$4StTwuVjOO9V1pdfcoGX8OSxL0dADfiYQkMwGXBxNj4m5R2.Wr4m.', NULL, 0, '2022-08-08 05:28:09', '2022-08-08 05:28:09'),
(9, 'BEM', 'bem', 'BEM', NULL, '$2y$10$zERTIjixKD1f6GY4jciMBeNpPiPVIIZIHmiB7EQbC6ioVFxa4bwtG', NULL, 0, '2022-08-08 05:29:51', '2022-08-08 05:29:51'),
(10, 'AdminMhs', 'admin_mhs', 'AdminMhs', NULL, '$2y$10$mjRnZUG1deHCU2N2SOg/ve8oWXAG57YUrP0tzhUlazqLEZ/PHnUKe', NULL, 0, '2022-08-08 06:57:26', '2022-08-08 06:57:26'),
(13, 'hme', 'ormawa', 'hme', 1, '$2y$10$ktycvWD7A2A33V2V/0PEnuIfY7oJWUaK9Vtwxy9aKbfw4X.RFI2aK', NULL, 0, '2022-08-13 10:12:41', '2022-08-25 05:57:41'),
(14, 'agi', 'admin_mhs', 'agi', NULL, '$2y$10$.AgTfPJQIuD3IUJBfVT1x.A47BCsV2A8//G86FeIkqhAUuf1KEd1u', NULL, 0, '2022-08-14 06:33:49', '2022-08-14 06:33:49'),
(19, 'Rumahku', 'ormawa', 'rumahku', 2, '$2y$10$hhakw4vCufTHNRXqfJz6y./q16A85qP4/vkMd8I6kQQ6Z/pS89A2a', NULL, 0, '2022-08-26 08:04:52', '2022-08-26 09:08:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ormawa`
--
ALTER TABLE `ormawa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengajuan_ormawa`
--
ALTER TABLE `pengajuan_ormawa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengajuan_ormawa_ibfk_1` (`id_ormawa`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_ibfk_1` (`id_ormawa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ormawa`
--
ALTER TABLE `ormawa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengajuan_ormawa`
--
ALTER TABLE `pengajuan_ormawa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pengajuan_ormawa`
--
ALTER TABLE `pengajuan_ormawa`
  ADD CONSTRAINT `pengajuan_ormawa_ibfk_1` FOREIGN KEY (`id_ormawa`) REFERENCES `ormawa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_ormawa`) REFERENCES `ormawa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
