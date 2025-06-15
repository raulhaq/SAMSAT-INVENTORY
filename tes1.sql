-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Jun 2025 pada 20.15
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
-- Database: `tes1`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `keluar`
--

CREATE TABLE `keluar` (
  `idkeluar` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp(),
  `merk` varchar(30) NOT NULL,
  `pemakai` varchar(30) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `keluar`
--

INSERT INTO `keluar` (`idkeluar`, `idbarang`, `tanggal`, `merk`, `pemakai`, `qty`) VALUES
(3, 22, '2025-05-07 09:31:34', '', 'ALEX', 1),
(4, 26, '2025-05-22 08:50:39', '', '-', 1),
(5, 25, '2025-05-22 08:51:04', '', '-', 10),
(6, 23, '2025-05-01 09:31:00', '', 'CIna', 1),
(7, 24, '2025-05-08 08:32:00', '', 'rodox', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `iduser` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`iduser`, `email`, `password`) VALUES
(1, 'admin@gmail.com', 'admin123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `masuk`
--

CREATE TABLE `masuk` (
  `idmasuk` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `kodebarang` varchar(30) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `merk` varchar(30) NOT NULL,
  `penerima` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `masuk`
--

INSERT INTO `masuk` (`idmasuk`, `idbarang`, `kodebarang`, `tanggal`, `merk`, `penerima`, `qty`) VALUES
(1, 1, '', '2025-05-03 14:52:52', '', 'eren', 10),
(2, 4, '', '2025-05-03 23:25:15', '', 'jh', 10),
(10, 17, '', '2025-05-05 05:25:53', '', 'Anto.SPd', 100),
(12, 23, '', '2025-05-07 09:27:43', '', 'Herman', 10),
(13, 22, '', '2025-05-05 06:51:06', '', 'Zaki MPHSPD', 1000),
(14, 23, '', '2025-05-22 08:29:19', '', 'Zaki M.E', 200),
(16, 25, '', '2025-05-22 08:29:07', '', 'Zaki S.H', 12),
(17, 24, '', '2025-05-21 10:24:00', '', 'Zaki S.H', 1),
(18, 23, '', '2025-05-15 10:24:00', '', 'Jeki', 2),
(19, 24, '', '2025-05-02 12:27:00', '', 'a', 2),
(20, 24, '', '2025-05-28 03:29:40', '', 'ikan', 3),
(21, 23, '', '2025-05-28 03:30:18', '', 'f', 1),
(22, 23, '', '2025-06-01 10:35:00', '', 'Raul', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock`
--

CREATE TABLE `stock` (
  `idbarang` int(11) NOT NULL,
  `kodebarang` varchar(30) NOT NULL,
  `namabarang` varchar(30) NOT NULL,
  `merk` varchar(30) NOT NULL,
  `tahun` int(4) NOT NULL,
  `asal` varchar(20) NOT NULL,
  `kondisi` varchar(20) NOT NULL,
  `stock` int(11) NOT NULL,
  `harga` int(30) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `ruangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `stock`
--

INSERT INTO `stock` (`idbarang`, `kodebarang`, `namabarang`, `merk`, `tahun`, `asal`, `kondisi`, `stock`, `harga`, `keterangan`, `ruangan`) VALUES
(23, '51.100', 'AC', 'Daikin', 2017, 'Pembelian', 'Baik', 188, 100000, '3 Lusin AC', 'Ruangan Kanwil UPTD Banda Aceh'),
(24, '1.111.211.01', 'BUKU', 'Erlangga', 2025, 'Pembelian', 'Rusak', 8, 400000, 'Selusin Buku', 'Perpustakaan Utama'),
(25, '12.433.17', 'Laptop', 'Lenovo LOQ 13', 2011, 'Pembelian', 'Baik', 26, 60000000, '2 Lusin Laptop', 'Ruangan Administrasi'),
(26, '21.112.10', 'Kipas', 'Robot', 2024, 'Pembelian', 'Baik', 29, 14000000, 'Pengadaan Kipas Angin ', 'Ruangan Kepala UPTD'),
(27, '122.10.114', 'Kursi', 'Kursi 16C-609 UA', 2019, 'Pembelian', 'Baik', 1, 1745000, 'Kursi Staff', 'Ruang Paur STNK');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `keluar`
--
ALTER TABLE `keluar`
  ADD PRIMARY KEY (`idkeluar`);

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`iduser`);

--
-- Indeks untuk tabel `masuk`
--
ALTER TABLE `masuk`
  ADD PRIMARY KEY (`idmasuk`);

--
-- Indeks untuk tabel `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`idbarang`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `keluar`
--
ALTER TABLE `keluar`
  MODIFY `idkeluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `masuk`
--
ALTER TABLE `masuk`
  MODIFY `idmasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `stock`
--
ALTER TABLE `stock`
  MODIFY `idbarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
