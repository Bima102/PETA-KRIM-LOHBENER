-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Jul 2025 pada 13.12
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kriminal`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `connections`
--

CREATE TABLE `connections` (
  `c_id` int(10) UNSIGNED NOT NULL,
  `c_resource_id` int(11) NOT NULL,
  `c_user_id` int(11) NOT NULL,
  `c_name` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `maps`
--

CREATE TABLE `maps` (
  `id` int(11) NOT NULL,
  `kelurahan` enum('Bojongslawi','Kiajaran Kulon','Kiajaran Wetan','Langut','Lanjan','Larangan','Legok','Lohbener','Pamayahan','Rambatan Kulon','Sindangkerta','Waru') DEFAULT NULL,
  `nama_daerah` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `jenis_kejahatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `nama_pelapor` varchar(255) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `status` enum('pending','Diproses','Selesai','Ditolak') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `maps`
--

INSERT INTO `maps` (`id`, `kelurahan`, `nama_daerah`, `latitude`, `longitude`, `jenis_kejahatan`, `nama_pelapor`, `no_hp`, `deskripsi`, `gambar`, `status`, `created_at`) VALUES
(102, 'Waru', 'esuk', '-6.417799', '108.255021', 'begal', 'bima', '081935487229', 'bdjq', 'danger.png', 'Selesai', '2025-07-24 03:59:25'),
(103, 'Waru', 'hadvhahd', '-6.417568', '108.255226', 'perampokan', 'bima', '081935487229', 'wdbjwbdjw', 'danger.png', 'Selesai', '2025-07-24 04:17:48'),
(105, 'Larangan', 'hdwhwd', '-6.407934', '108.256070', 'curanmor', 'andre', '081935487229', 'wdbqwdbwj', 'danger.png', 'Selesai', '2025-07-24 04:58:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2022-10-29-055545', 'App\\Database\\Migrations\\AddConnections', 'default', 'App', 1667394695, 1),
(2, '2022-10-29-060250', 'App\\Database\\Migrations\\AddUsers', 'default', 'App', 1667394695, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'user',
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `role`, `password`, `phone`) VALUES
(10, 'wahyu', 'pratama', 'wahyu@gmail.com', 'user', '$2y$10$pdGpQIFWT73BlouWYYaSw.twKwQylqL.T32ia5yApT9Ftd.B1YOna', NULL),
(11, 'admin', 'kepolisian', 'admin@gmail.com', 'admin', '$2y$10$jukls5o2bzgj2ssnmMWbu.bZx67ucP1SZGwr.eCQRfUwXnc.8qCyi', NULL),
(12, 'Bima ', 'saputra', 'bimasputra102@gmail.com', 'user', '$2y$10$PNKXVL04Q66TEyHHlgBytuIzSgllAZAMKlRGZiyCuv.TiCS2cATh.', '081935487229'),
(13, 'wasno', 'tardi', 'wasno@gmail.com', 'user', '$2y$10$HKT340IE13DmLdsVkFVNYeSUzPqYpuaaXQcWVMGbbvUYB4Y3sY/.2', NULL),
(14, 'latifa', 'nazwa', 'latifa@gmail.com', 'user', '$2y$10$HDBbTdkTOXxE75lA14AIt.Jz8yNIgI.SPAmQoP582AV9I9XUzy5Z6', NULL),
(19, 'deni', 'pirman', 'punchkyy@gmail.com', 'user', '$2y$10$hBgv.vdNa7atIrPKl92OG.ujRQdyPhICHSK0iHvzX.5mZfwmBCCqu', '081935487229');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `connections`
--
ALTER TABLE `connections`
  ADD PRIMARY KEY (`c_id`);

--
-- Indeks untuk tabel `maps`
--
ALTER TABLE `maps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelurahan_id` (`kelurahan`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `connections`
--
ALTER TABLE `connections`
  MODIFY `c_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `maps`
--
ALTER TABLE `maps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
