-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Mar 2025 pada 19.03
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
-- Struktur dari tabel `kabupaten_kota`
--

CREATE TABLE `kabupaten_kota` (
  `kabupaten_kota_id` int(11) NOT NULL,
  `provinsi_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kabupaten_kota`
--

INSERT INTO `kabupaten_kota` (`kabupaten_kota_id`, `provinsi_id`, `nama`) VALUES
(104, 10, 'Indramayu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kecamatan`
--

CREATE TABLE `kecamatan` (
  `kecamatan_id` int(11) NOT NULL,
  `kabupaten_kota_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kecamatan`
--

INSERT INTO `kecamatan` (`kecamatan_id`, `kabupaten_kota_id`, `nama`) VALUES
(101, 32, 'Lohbener');

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
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int(11) NOT NULL,
  `no_pelapor` varchar(20) NOT NULL,
  `jenis_kejahatan` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `tanggal_laporan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Struktur dari tabel `provinsi`
--

CREATE TABLE `provinsi` (
  `provinsi_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `provinsi`
--

INSERT INTO `provinsi` (`provinsi_id`, `nama`) VALUES
(10, 'Jawa Barat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `region`
--

CREATE TABLE `region` (
  `id` int(11) NOT NULL,
  `provinsi_id` int(11) NOT NULL,
  `kabupaten_kota_id` int(11) NOT NULL,
  `kecamatan_id` int(11) NOT NULL,
  `kelurahan_id` int(11) NOT NULL,
  `users_id` int(10) DEFAULT NULL,
  `nama_daerah` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `tingkat_kejahatan` enum('rendah','sedang','tinggi') DEFAULT 'rendah'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `region`
--

INSERT INTO `region` (`id`, `provinsi_id`, `kabupaten_kota_id`, `kecamatan_id`, `kelurahan_id`, `users_id`, `nama_daerah`, `latitude`, `longitude`, `deskripsi`, `gambar`, `tingkat_kejahatan`) VALUES
(5, 10, 104, 101, 6, NULL, 'Jl. Larangan - Lelea', '-6.412335', '108.254448', 'begal', '1741009104_7b8d9bce01eded3064b7.jpeg', 'rendah'),
(11, 10, 104, 101, 12, NULL, 'jember', '-6.3448895', '108.3155391', 'pencurian', 'danger.png', 'rendah'),
(12, 10, 104, 101, 9, NULL, 'santing', '-6.4151146', '108.2594006', 'begal', '1742320783_74119f171e93b23ac2e2.png', NULL);

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
(1, 'Admin ', 'Choiruddin', 'asd@gmail.com', 'admin', '$2y$10$jAoswCSmfJbNMlTQMFyfkukS8YNt8.fKnBbESV9qpe/7UvSGMMnz.', '2022-11-10 02:14:26', '0000-00-00 00:00:00'),
(2, 'coba', 'coba', 'coba@gmail.com', 'user', '$2y$10$QNb8sWAm/NNLcjaM7mVapuZiXta6cXuWZtt/we8Rt18P23VMSfUku', '2022-11-18 08:17:32', '0000-00-00 00:00:00'),
(3, 'coba', 'coba2', 'coba2@gmail.com', 'user', '$2y$10$MfzT/J8x.pBrZwvIOLG67u7SD7r9bgoTHk9kvz0VmWDpJ6fa1pnGy', '2023-01-22 04:47:02', '0000-00-00 00:00:00'),
(4, 'Bima ', 'Syahputra', 'bimasputra@gmail.com', 'user', '$2y$10$o3mpXqVulHhJtYyyz.uVBe0xBORHYrvybBoiCyeAIcITMe7pehULO', '2025-03-03 06:27:44', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `connections`
--
ALTER TABLE `connections`
  ADD PRIMARY KEY (`c_id`);

--
-- Indeks untuk tabel `kabupaten_kota`
--
ALTER TABLE `kabupaten_kota`
  ADD PRIMARY KEY (`kabupaten_kota_id`);

--
-- Indeks untuk tabel `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`kecamatan_id`),
  ADD KEY `kabupaten_kota_id` (`kabupaten_kota_id`);

--
-- Indeks untuk tabel `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD PRIMARY KEY (`kelurahan_id`),
  ADD KEY `kecamatan_id` (`kecamatan_id`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `provinsi`
--
ALTER TABLE `provinsi`
  ADD PRIMARY KEY (`provinsi_id`);

--
-- Indeks untuk tabel `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id`),
  ADD KEY `provinsi_id` (`provinsi_id`),
  ADD KEY `kecamatan_id` (`kecamatan_id`),
  ADD KEY `kabupaten_kota_id` (`kabupaten_kota_id`),
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
-- AUTO_INCREMENT untuk tabel `connections`
--
ALTER TABLE `connections`
  MODIFY `c_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `kabupaten_kota`
--
ALTER TABLE `kabupaten_kota`
  MODIFY `kabupaten_kota_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT untuk tabel `kelurahan`
--
ALTER TABLE `kelurahan`
  MODIFY `kelurahan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `provinsi`
--
ALTER TABLE `provinsi`
  MODIFY `provinsi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `region`
--
ALTER TABLE `region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  ADD CONSTRAINT `region_ibfk_1` FOREIGN KEY (`provinsi_id`) REFERENCES `provinsi` (`provinsi_id`),
  ADD CONSTRAINT `region_ibfk_5` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatan` (`kecamatan_id`),
  ADD CONSTRAINT `region_ibfk_6` FOREIGN KEY (`kabupaten_kota_id`) REFERENCES `kabupaten_kota` (`kabupaten_kota_id`),
  ADD CONSTRAINT `region_ibfk_7` FOREIGN KEY (`kelurahan_id`) REFERENCES `kelurahan` (`kelurahan_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
