-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Jun 2025 pada 18.53
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
-- Database: `db_topsis_wisata_1`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `kode` varchar(10) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `bobot` float DEFAULT NULL,
  `atribut` enum('benefit','cost') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `kode`, `nama`, `bobot`, `atribut`) VALUES
(1, 'C1', 'Jarak', 0.2, 'cost'),
(2, 'C2', 'Waktu', 0.15, 'benefit'),
(3, 'C3', 'Tiket', 0.15, 'cost'),
(4, 'C4', 'Transportasi', 0.25, 'benefit'),
(5, 'C5', 'Fasilitas', 0.25, 'benefit');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` int(11) NOT NULL,
  `id_wisata` int(11) DEFAULT NULL,
  `id_kriteria` int(11) DEFAULT NULL,
  `nilai` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `nilai`
--

INSERT INTO `nilai` (`id_nilai`, `id_wisata`, `id_kriteria`, `nilai`) VALUES
(6, 2, 1, 5),
(7, 2, 2, 3),
(8, 2, 3, 4),
(9, 2, 4, 4),
(10, 2, 5, 12),
(11, 3, 1, 4),
(12, 3, 2, 5),
(13, 3, 3, 4),
(14, 3, 4, 5),
(15, 3, 5, 13),
(16, 4, 1, 4),
(17, 4, 2, 5),
(18, 4, 3, 5),
(19, 4, 4, 5),
(20, 4, 5, 15),
(31, 1, 1, 5),
(32, 1, 2, 5),
(33, 1, 3, 5),
(34, 1, 4, 5),
(35, 1, 5, 15);

-- --------------------------------------------------------

--
-- Struktur dari tabel `wisata`
--

CREATE TABLE `wisata` (
  `id_wisata` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `wisata`
--

INSERT INTO `wisata` (`id_wisata`, `nama`, `jenis`, `alamat`, `keterangan`, `foto`) VALUES
(1, 'gunung merapi', 'Alam', ' Klaten; Boyolali; Magelang; (Jawa Tengah); Sleman (Daerah Istimewa Yogyakarta)', 'Gunung Merapi adalah gunung berapi di bagian tengah Pulau Jawa dan merupakan salah satu gunung api teraktif di Indonesia. ', 'merapi.jpg'),
(2, 'Taman sari', 'Budaya', 'Patehan, Kraton, Yogyakarta City, Special Region of Yogyakarta 55133', 'Taman Sari Yogyakarta adalah situs bekas taman istana Keraton Ngayogyakarta Hadiningrat. Taman istana ini dibangun pada zaman Sultan Hamengkubuwana I pada tahun 1758â€“1765.', 'taman sari.jpg'),
(3, 'benteng vredeburg', 'Sejarah', 'Jl. Margo Mulyo No.6, Ngupasan, Kec. Gondomanan, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55122', 'Museum Benteng Vredeburg adalah sebuah bangunan benteng pertahanan yang terletak di depan Gedung Agung dan Kraton Kesultanan Yogyakarta. Alamatnya ada di Jl. A. Yani No. 6, Yogyakarta. Sekarang, benteng ini menjadi sebuah museum.', 'benteng vredeburg.jpg'),
(4, 'Hutan Pinus Mangunan', 'Alam', 'Jl raya Jl. Hutan Pinus Nganjir, Mangunan, Kec. Dlingo, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55783', 'Hutan Pinus Mangunan adalah hutan pinus yang terletak di Sukorame, Mangunan, Dlingo, Bantul, Daerah Istimewa Yogyakarta. Sebelum wisata ini dikenal banyak orang, hutan ini dulunya merupakan kawasan tandus.', 'hutan pinus.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `id_wisata` (`id_wisata`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indeks untuk tabel `wisata`
--
ALTER TABLE `wisata`
  ADD PRIMARY KEY (`id_wisata`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `wisata`
--
ALTER TABLE `wisata`
  MODIFY `id_wisata` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`id_wisata`) REFERENCES `wisata` (`id_wisata`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
