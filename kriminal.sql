-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Apr 2025 pada 21.46
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
-- Struktur dari tabel `aduan`
--

CREATE TABLE `aduan` (
  `id` int(11) NOT NULL,
  `jenis_kejahatan` enum('curanmor','perampokan','begal','tawuran') NOT NULL,
  `kelurahan` varchar(255) NOT NULL,
  `daerah` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `pelapor` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `aduan`
--

INSERT INTO `aduan` (`id`, `jenis_kejahatan`, `kelurahan`, `daerah`, `latitude`, `longitude`, `pelapor`, `created_at`) VALUES
(8, 'curanmor', 'waru', 'jalan waru', '-6.3941201', '108.1407558', 'Bima  saputra', '2025-04-11 17:19:16');

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
-- Struktur dari tabel `kecamatan`
--

CREATE TABLE `kecamatan` (
  `kecamatan_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kecamatan`
--

INSERT INTO `kecamatan` (`kecamatan_id`, `nama`) VALUES
(101, 'Lohbener');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelurahan`
--

CREATE TABLE `kelurahan` (
  `kelurahan_id` int(11) NOT NULL,
  `kecamatan_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kode_pos` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kelurahan`
--

INSERT INTO `kelurahan` (`kelurahan_id`, `kecamatan_id`, `nama`, `kode_pos`) VALUES
(1, 101, 'Bojongslawi', '45252'),
(2, 101, 'Kiajaran Kulon', '45252'),
(3, 101, 'Kiajaran Wetan', '45252'),
(4, 101, 'Langut', '45252'),
(5, 101, 'Lanjan', '45252'),
(6, 101, 'Larangan', '45252'),
(7, 101, 'Legok', '45252'),
(8, 101, 'Lohbener', '45252'),
(9, 101, 'Pamayahan', '45252'),
(10, 101, 'Rambatan Kulon', '45252'),
(11, 101, 'Sindangkerta', '45252'),
(12, 101, 'Waru', '45252');

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
-- Struktur dari tabel `region`
--

CREATE TABLE `region` (
  `id` int(11) NOT NULL,
  `kecamatan_id` int(11) NOT NULL,
  `kelurahan_id` int(11) NOT NULL,
  `nama_daerah` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `jenis_kejahatan` enum('curanmor','perampokan','begal','tawuran') DEFAULT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `region`
--

INSERT INTO `region` (`id`, `kecamatan_id`, `kelurahan_id`, `nama_daerah`, `latitude`, `longitude`, `jenis_kejahatan`, `gambar`) VALUES
(23, 101, 1, 'kiajaran', '-6.4151146', '108.2594006', 'begal', '1744394233_e1df7678be4c3fa0ce89.png');

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
-- Indeks untuk tabel `aduan`
--
ALTER TABLE `aduan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `connections`
--
ALTER TABLE `connections`
  ADD PRIMARY KEY (`c_id`);

--
-- Indeks untuk tabel `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`kecamatan_id`);

--
-- Indeks untuk tabel `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD PRIMARY KEY (`kelurahan_id`),
  ADD KEY `kecamatan_id` (`kecamatan_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kecamatan_id` (`kecamatan_id`),
  ADD KEY `kelurahan_id` (`kelurahan_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `aduan`
--
ALTER TABLE `aduan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `connections`
--
ALTER TABLE `connections`
  MODIFY `c_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `kelurahan`
--
ALTER TABLE `kelurahan`
  MODIFY `kelurahan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `region`
--
ALTER TABLE `region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD CONSTRAINT `kelurahan_ibfk_1` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatan` (`kecamatan_id`);

--
-- Ketidakleluasaan untuk tabel `region`
--
ALTER TABLE `region`
  ADD CONSTRAINT `region_ibfk_5` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatan` (`kecamatan_id`),
  ADD CONSTRAINT `region_ibfk_7` FOREIGN KEY (`kelurahan_id`) REFERENCES `kelurahan` (`kelurahan_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
