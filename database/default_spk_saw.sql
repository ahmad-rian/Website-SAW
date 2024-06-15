-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 15 Jun 2024 pada 07.20
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `default_spk_saw`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `alternatif` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `alternatif`) VALUES
(21, 'A1 ( Himpunan Mahasiswa Teknik Elektro )'),
(22, 'A2 ( Himpunan Mahasiswa Teknik Sipil )'),
(23, 'A3 ( Himpunan Mahasiswa Teknik Geologi )'),
(24, 'A4 ( Himpunan Mahasiswa Informatika )'),
(25, 'A5 ( Himpunan Mahasiswa Teknik Industri )');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil`
--

CREATE TABLE `hasil` (
  `id_hasil` int(11) NOT NULL,
  `kode_hasil` varchar(255) DEFAULT NULL,
  `id_alternatif` int(11) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `hasil`
--

INSERT INTO `hasil` (`id_hasil`, `kode_hasil`, `id_alternatif`, `nilai`) VALUES
(1, 'kode-666d234c4ae719.97461205', 21, 1.525),
(2, 'kode-666d234c4b9d19.28916916', 22, 1.85),
(3, 'kode-666d234c4c97b7.56114571', 23, 1.925),
(4, 'kode-666d234c4db7e3.67145955', 24, 1.65),
(5, 'kode-666d234c4e9df2.16015430', 25, 1.625);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `kode_kriteria` varchar(10) NOT NULL,
  `kriteria` varchar(50) NOT NULL,
  `type` enum('Benefit','Cost') NOT NULL,
  `bobot` float NOT NULL,
  `ada_pilihan` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `kode_kriteria`, `kriteria`, `type`, `bobot`, `ada_pilihan`) VALUES
(9, 'C11', 'Keselarasan dengan Minat dan Kebutuhan', 'Benefit', 0.1, 0),
(10, 'C12', 'Pengalaman dan Keterlibatan', 'Benefit', 0.1, 0),
(11, 'C13', 'Program Kerja dan Aktivitas Organisasi', 'Benefit', 0.3, 0),
(12, 'C14', 'Dukungan Sistem Pendukung Keputusan', 'Benefit', 0.2, 0),
(13, 'C15', 'Reputasi dan Jaringan', 'Benefit', 0.2, 0),
(14, 'C16', 'Bidang Studi dan Kesesuaian Akademik', 'Benefit', 0.25, 0),
(15, 'C17', 'Fleksibilitas dan Adaptasi Organisasi', 'Benefit', 0.1, 0),
(16, 'C18', 'Waktu dan Komitmen', 'Benefit', 0.2, 0),
(17, 'C19', 'Budaya dan Nilai Organisasi', 'Benefit', 0.35, 0),
(19, 'C20', 'Kesejahteraan Anggota', 'Benefit', 0.2, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` int(11) NOT NULL,
  `id_alternatif` int(10) NOT NULL,
  `id_kriteria` int(10) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `penilaian`
--

INSERT INTO `penilaian` (`id_penilaian`, `id_alternatif`, `id_kriteria`, `nilai`) VALUES
(106, 21, 9, 2),
(107, 21, 10, 3),
(108, 21, 11, 3),
(109, 21, 12, 3),
(110, 21, 13, 3),
(111, 21, 14, 3),
(112, 21, 15, 3),
(113, 21, 16, 3),
(114, 21, 17, 3),
(115, 21, 19, 3),
(116, 22, 9, 2),
(117, 22, 10, 4),
(118, 22, 11, 4),
(119, 22, 12, 4),
(120, 22, 13, 4),
(121, 22, 14, 4),
(122, 22, 15, 4),
(123, 22, 16, 2),
(124, 22, 17, 4),
(125, 22, 19, 3),
(126, 23, 9, 1),
(127, 23, 10, 4),
(128, 23, 11, 4),
(129, 23, 12, 4),
(130, 23, 13, 4),
(131, 23, 14, 4),
(132, 23, 15, 4),
(133, 23, 16, 4),
(134, 23, 17, 4),
(135, 23, 19, 3),
(146, 25, 9, 4),
(147, 25, 10, 3),
(148, 25, 11, 3),
(149, 25, 12, 3),
(150, 25, 13, 3),
(151, 25, 14, 3),
(152, 25, 15, 3),
(153, 25, 16, 4),
(154, 25, 17, 3),
(155, 25, 19, 3),
(156, 24, 9, 2),
(157, 24, 10, 3),
(158, 24, 11, 4),
(159, 24, 12, 3),
(160, 24, 13, 4),
(161, 24, 14, 3),
(162, 24, 15, 3),
(163, 24, 16, 3),
(164, 24, 17, 3),
(165, 24, 19, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_sub_kriteria` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `sub_kriteria` varchar(50) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(5) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(70) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `role` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `email`, `role`) VALUES
(16, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin', 'admin@gmail.com', '1'),
(18, 'rian', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'rian', 'alriansr@gmail.com', '1'),
(19, 'athifa', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'athifa', 'athifa@gmail.com', '2'),
(20, 'eka', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'eka', 'eka@gmail.com', '2');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indeks untuk tabel `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `fk_hasil` (`id_alternatif`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `fk_penilaian_alternatif` (`id_alternatif`),
  ADD KEY `fk_penilaian_kriteria` (`id_kriteria`);

--
-- Indeks untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_sub_kriteria`),
  ADD KEY `fk_sub_kriteria_id_kriteria` (`id_kriteria`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `hasil`
--
ALTER TABLE `hasil`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `hasil`
--
ALTER TABLE `hasil`
  ADD CONSTRAINT `fk_hasil` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `fk_penilaian_alternatif` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`),
  ADD CONSTRAINT `fk_penilaian_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `fk_sub_kriteria_id_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
