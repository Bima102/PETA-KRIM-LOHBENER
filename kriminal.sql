-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Bulan Mei 2025 pada 12.08
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
  `kelurahan` enum('Bojongslawi','Kiajaran Kulon','Kiajaran Wetan','Langut','Lanjan','Larangan','Legok','Lohbener','Pamayahan','Rambatan Kulon','Sindangkerta','Waru') NOT NULL,
  `nama_daerah` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `jenis_kejahatan` enum('curanmor','perampokan','begal','tawuran') DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `status` varchar(20) DEFAULT 'diterima'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `maps`
--

INSERT INTO `maps` (`id`, `kelurahan`, `nama_daerah`, `latitude`, `longitude`, `jenis_kejahatan`, `gambar`, `status`) VALUES
(23, 'Bojongslawi', 'jalan raya slaur', '-6.4151146', '108.2594006', 'curanmor', '1744394233_e1df7678be4c3fa0ce89.png', 'diterima'),
(25, 'Sindangkerta', 'sindang', '-6.407893', '108.256797', 'begal', '1744798728_a631582e9ed75f58d318.jpg', 'diterima'),
(28, 'Pamayahan', 'jalan pamayahan', '-6.398401', '108.283808', 'perampokan', '1744819850_6ba7c08c5421288c2161.jpg', 'diterima'),
(29, 'Lohbener', 'celeng', '-6.401054', '108.275958', 'tawuran', '1744819909_fe453dec8ee3df1efb90.png', 'diterima'),
(39, 'Lohbener', 'jalan lama lohbener', '-6.410230', '108.282971', 'begal', '1745239207_f8fa3f647cff735d5e7e.png', 'diterima'),
(47, 'Larangan', 'larangan', '-6.404579', '108.225994', 'begal', '1746433621_6c4e174e68f69e03dec3.png', 'diterima'),
(48, 'Legok', 'jalan baru', '-6.419881', '108.275440', 'begal', '1746626915_7fcf6eafb3227a8ed0c2.png', 'diterima'),
(49, 'Kiajaran Kulon', 'wanguk', '-6.407879 ', '108.251600', 'curanmor', '1747316054_49ffb89130a9fac4a596.jpeg', 'diterima'),
(55, 'Larangan', 'pantura larangan ', '-6.407934', '108.253530', 'perampokan', '1747820382_a048cafbf3081869478d.png', 'diterima');

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
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `role`, `password`, `created_at`, `updated_at`) VALUES
(10, 'wahyu', 'pratama', 'wahyu@gmail.com', 'user', '$2y$10$pdGpQIFWT73BlouWYYaSw.twKwQylqL.T32ia5yApT9Ftd.B1YOna', '2025-04-05 02:05:26', '0000-00-00 00:00:00'),
(11, 'admin', 'kepolisian', 'admin@gmail.com', 'admin', '$2y$10$jukls5o2bzgj2ssnmMWbu.bZx67ucP1SZGwr.eCQRfUwXnc.8qCyi', '2025-04-05 02:26:20', '0000-00-00 00:00:00'),
(12, 'Bima ', 'saputra', 'bima@gmail.com', 'user', '$2y$10$PNKXVL04Q66TEyHHlgBytuIzSgllAZAMKlRGZiyCuv.TiCS2cATh.', '2025-04-09 04:53:37', '0000-00-00 00:00:00');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
