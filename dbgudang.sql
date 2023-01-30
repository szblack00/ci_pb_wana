-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Jan 2023 pada 01.53
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbgudang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `brgkode` char(10) NOT NULL,
  `brgnama` varchar(100) NOT NULL,
  `brgkatid` int(10) UNSIGNED NOT NULL,
  `brgsatid` int(10) UNSIGNED NOT NULL,
  `brgharga` double NOT NULL,
  `brgstok` int(11) NOT NULL,
  `brggambar` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`brgkode`, `brgnama`, `brgkatid`, `brgsatid`, `brgharga`, `brgstok`, `brggambar`) VALUES
('B001', 'GOOGLE HELMET', 5, 4, 9000, 200, 'upload/B001.png'),
('B002', 'Helmet Proyek', 5, 4, 200000, 200, 'upload/B002.png'),
('B003', 'Baut Probolt 5 cm', 3, 5, 1000000, 310, 'upload/B003.png'),
('B004', 'Emergency Stop kontak', 3, 4, 50000, 300, 'upload/B004.png'),
('B005', 'MOUSE', 8, 4, 9000, 100, 'upload/B005.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barangkeluar`
--

CREATE TABLE `barangkeluar` (
  `faktur` char(20) NOT NULL,
  `tglfaktur` date NOT NULL,
  `id_costumer` int(11) NOT NULL,
  `totalharga` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barangmasuk`
--

CREATE TABLE `barangmasuk` (
  `faktur` char(20) NOT NULL,
  `tglfaktur` date NOT NULL,
  `totalharga` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barangmasuk`
--

INSERT INTO `barangmasuk` (`faktur`, `tglfaktur`, `totalharga`) VALUES
('20220112', '2022-12-01', 10810000),
('F000345', '2022-12-01', 18090000),
('FKP00125', '2022-12-09', 221000000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `costumer_pt`
--

CREATE TABLE `costumer_pt` (
  `costid` int(10) NOT NULL,
  `costnama` varchar(100) NOT NULL,
  `costtelp` double NOT NULL,
  `costalamat` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `costumer_pt`
--

INSERT INTO `costumer_pt` (`costid`, `costnama`, `costtelp`, `costalamat`) VALUES
(1, 'Harun Zakaria', 82780757137, 'jl.patriot 4 rt 01 rw 024 no.5 setiamekar, tambun selatan'),
(2, 'Yahya aditya', 877805798, 'bekasi'),
(3, 'Aris Nugraha Ibrahim', 2188653231, 'Jakarta Pusat Pedurenan 3'),
(4, 'Biham Maulana', 877672398, 'Bekasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_barangkeluar`
--

CREATE TABLE `detail_barangkeluar` (
  `id` bigint(20) NOT NULL,
  `detfaktur` char(20) NOT NULL,
  `detbrgkode` char(10) NOT NULL,
  `detharga` double NOT NULL,
  `detjml` int(11) NOT NULL,
  `detsubtotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_barangmasuk`
--

CREATE TABLE `detail_barangmasuk` (
  `iddetail` bigint(20) NOT NULL,
  `detfaktur` char(20) NOT NULL,
  `detbrgkode` char(10) CHARACTER SET utf8 NOT NULL,
  `dethargamasuk` double NOT NULL,
  `detjml` int(11) NOT NULL,
  `detsubtotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_barangmasuk`
--

INSERT INTO `detail_barangmasuk` (`iddetail`, `detfaktur`, `detbrgkode`, `dethargamasuk`, `detjml`, `detsubtotal`) VALUES
(1, 'F000345', 'B002', 200000, 90, 18000000),
(2, 'F000345', 'B001', 9000, 10, 90000),
(3, '20220112', 'B003', 1000000, 10, 10000000),
(4, '20220112', 'B001', 9000, 90, 810000),
(5, 'FKP00125', 'B004', 50000, 300, 15000000),
(6, 'FKP00125', 'B003', 1000000, 200, 200000000),
(7, 'FKP00125', 'B002', 200000, 30, 6000000);

--
-- Trigger `detail_barangmasuk`
--
DELIMITER $$
CREATE TRIGGER `tri_tambah_stok_barang` AFTER INSERT ON `detail_barangmasuk` FOR EACH ROW BEGIN
UPDATE
barang
SET
barang.brgstok=barang.brgstok+ new.detjml WHERE barang.brgkode=new.detbrgkode;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `nama_jabatan` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`) VALUES
(1, 'Atasan'),
(2, 'Operator');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `katid` int(10) UNSIGNED NOT NULL,
  `katnama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`katid`, `katnama`) VALUES
(1, 'Elektronik'),
(2, 'Raw Metal'),
(3, 'Sperpart'),
(4, 'Toolskit '),
(5, 'Safety Kit'),
(6, 'Welding Equipment'),
(7, 'Manchine '),
(8, 'Computer & Hardware'),
(9, 'ATK & OFFICER');

-- --------------------------------------------------------

--
-- Struktur dari tabel `levels`
--

CREATE TABLE `levels` (
  `levelid` int(11) NOT NULL,
  `levelnama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `levels`
--

INSERT INTO `levels` (`levelid`, `levelnama`) VALUES
(1, 'Admin'),
(2, 'Gudang'),
(3, 'Manager'),
(4, 'Purchasing');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2022-06-02-034842', 'App\\Database\\Migrations\\Kategori', 'default', 'App', 1669732815, 1),
(2, '2022-06-02-034907', 'App\\Database\\Migrations\\Satuan', 'default', 'App', 1669732815, 1),
(3, '2022-06-02-034921', 'App\\Database\\Migrations\\Barang', 'default', 'App', 1669732816, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `po`
--

CREATE TABLE `po` (
  `id_po` int(11) NOT NULL,
  `faktur` varchar(20) NOT NULL,
  `file` varchar(100) NOT NULL,
  `tgl_req` date NOT NULL,
  `status` char(100) NOT NULL DEFAULT '0',
  `userid` varchar(50) NOT NULL,
  `id_jabatan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `po`
--

INSERT INTO `po` (`id_po`, `faktur`, `file`, `tgl_req`, `status`, `userid`, `id_jabatan`) VALUES
(1, '`2018320001', 'Coba File 1', '2023-01-20', '1', '1', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuan`
--

CREATE TABLE `satuan` (
  `satid` int(10) UNSIGNED NOT NULL,
  `satnama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `satuan`
--

INSERT INTO `satuan` (`satid`, `satnama`) VALUES
(1, 'KG'),
(2, 'Meters'),
(3, 'Unit'),
(4, 'PCS'),
(5, 'Box'),
(6, 'Lusin'),
(7, 'Kodi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `temp_barangkeluar`
--

CREATE TABLE `temp_barangkeluar` (
  `id` bigint(20) NOT NULL,
  `detfaktur` char(20) NOT NULL,
  `detbrgkode` char(10) NOT NULL,
  `detharga` double NOT NULL,
  `detjml` int(11) NOT NULL,
  `detsubtotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `temp_barangkeluar`
--

INSERT INTO `temp_barangkeluar` (`id`, `detfaktur`, `detbrgkode`, `detharga`, `detjml`, `detsubtotal`) VALUES
(1, '2712220001', 'B003', 1000000, 2, 2000000),
(2, '2712220001', 'B004', 50000, 3, 150000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `temp_barangmasuk`
--

CREATE TABLE `temp_barangmasuk` (
  `iddetail` bigint(20) NOT NULL,
  `detfaktur` char(20) NOT NULL,
  `detbrgkode` char(10) NOT NULL,
  `dethargamasuk` double NOT NULL,
  `detjml` int(11) NOT NULL,
  `detsubtotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `temp_barangmasuk`
--

INSERT INTO `temp_barangmasuk` (`iddetail`, `detfaktur`, `detbrgkode`, `dethargamasuk`, `detjml`, `detsubtotal`) VALUES
(11, '2018320001', 'B004', 50000, 2, 100000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `userid` char(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `userpassword` varchar(100) NOT NULL,
  `userlevelid` int(11) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `atasan` varchar(255) NOT NULL,
  `useraktif` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`userid`, `username`, `userpassword`, `userlevelid`, `id_jabatan`, `atasan`, `useraktif`) VALUES
('admin', 'administrator', '$2y$10$rkhngGD1xxZL087trWrk2eF3fELq01dHvj2TfKXkaN1MSO31WGeNa', 1, 1, '', '1'),
('gudang', 'Harun Zakaria', '$2y$10$rkhngGD1xxZL087trWrk2eF3fELq01dHvj2TfKXkaN1MSO31WGeNa', 2, 2, '', '1'),
('manager', 'Handoko srimulyo', '$2y$10$rkhngGD1xxZL087trWrk2eF3fELq01dHvj2TfKXkaN1MSO31WGeNa', 3, 1, 'Handoko srimulyo', '1'),
('purchasing', 'Afif', '$2y$10$rkhngGD1xxZL087trWrk2eF3fELq01dHvj2TfKXkaN1MSO31WGeNa', 4, 2, '1', '1');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`brgkode`),
  ADD KEY `barang_brgkatid_foreign` (`brgkatid`),
  ADD KEY `barang_brgsatid_foreign` (`brgsatid`);

--
-- Indeks untuk tabel `barangkeluar`
--
ALTER TABLE `barangkeluar`
  ADD PRIMARY KEY (`faktur`);

--
-- Indeks untuk tabel `barangmasuk`
--
ALTER TABLE `barangmasuk`
  ADD PRIMARY KEY (`faktur`);

--
-- Indeks untuk tabel `costumer_pt`
--
ALTER TABLE `costumer_pt`
  ADD PRIMARY KEY (`costid`);

--
-- Indeks untuk tabel `detail_barangkeluar`
--
ALTER TABLE `detail_barangkeluar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `detail_barangmasuk`
--
ALTER TABLE `detail_barangmasuk`
  ADD PRIMARY KEY (`iddetail`),
  ADD KEY `detail_barangmasuk_ibfk_1` (`detbrgkode`),
  ADD KEY `detail_barangmasuk_ibfk_2` (`detfaktur`);

--
-- Indeks untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD KEY `katid` (`katid`);

--
-- Indeks untuk tabel `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`levelid`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `po`
--
ALTER TABLE `po`
  ADD PRIMARY KEY (`id_po`);

--
-- Indeks untuk tabel `satuan`
--
ALTER TABLE `satuan`
  ADD KEY `satid` (`satid`);

--
-- Indeks untuk tabel `temp_barangkeluar`
--
ALTER TABLE `temp_barangkeluar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `temp_barangmasuk`
--
ALTER TABLE `temp_barangmasuk`
  ADD PRIMARY KEY (`iddetail`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `costumer_pt`
--
ALTER TABLE `costumer_pt`
  MODIFY `costid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `detail_barangkeluar`
--
ALTER TABLE `detail_barangkeluar`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `detail_barangmasuk`
--
ALTER TABLE `detail_barangmasuk`
  MODIFY `iddetail` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `katid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `levels`
--
ALTER TABLE `levels`
  MODIFY `levelid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `po`
--
ALTER TABLE `po`
  MODIFY `id_po` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `satuan`
--
ALTER TABLE `satuan`
  MODIFY `satid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `temp_barangkeluar`
--
ALTER TABLE `temp_barangkeluar`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `temp_barangmasuk`
--
ALTER TABLE `temp_barangmasuk`
  MODIFY `iddetail` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_brgkatid_foreign` FOREIGN KEY (`brgkatid`) REFERENCES `kategori` (`katid`),
  ADD CONSTRAINT `barang_brgsatid_foreign` FOREIGN KEY (`brgsatid`) REFERENCES `satuan` (`satid`);

--
-- Ketidakleluasaan untuk tabel `detail_barangmasuk`
--
ALTER TABLE `detail_barangmasuk`
  ADD CONSTRAINT `detail_barangmasuk_ibfk_1` FOREIGN KEY (`detbrgkode`) REFERENCES `barang` (`brgkode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_barangmasuk_ibfk_2` FOREIGN KEY (`detfaktur`) REFERENCES `barangmasuk` (`faktur`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
